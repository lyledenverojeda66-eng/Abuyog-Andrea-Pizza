
<?php
    $cart = $cart ?? session('cart', []);

    $deliveryOption = old(
        'delivery_option',
        $deliveryOption ?? session('delivery_option', 'delivery')
    );

    $paymentMethod = old(
        'payment_method',
        $paymentMethod ?? session('payment_method', 'cash_on_delivery')
    );

    $deliveryAddress = old(
        'delivery_address',
        $deliveryAddress ?? session('delivery_address', '')
    );

    $deliveryFee = (float) ($deliveryFee ?? session('delivery_fee', 0));

    $pizzaImages = [
        'bacon' => 'bacon.png.webp',
        'beef' => 'Beef.png',
        'ham & cheese' => 'Ham & Cheese Pizza.png',
        'hawaiian' => 'Hawaiian pizza.png',
        'pepperoni' => 'Pepperoni pizza.png',
        'vegetarian' => 'Vegetarian.png',
    ];

    $subtotal = 0;

    foreach ($cart as $item) {
        $subtotal +=
            (float) ($item['price'] ?? 0) *
            (int) ($item['quantity'] ?? 1);
    }

    $grandTotal = $subtotal + (
        $deliveryOption === 'pickup' ? 0 : $deliveryFee
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Order Your Pizza | Abuyog Andrea Pizza</title>

    <style>
        :root {
            --green: #16803c;
            --green-hover: #11682f;
            --black: #171717;
            --cream: #fff8ee;
            --border: #eadfd3;
            --gray: #6b7280;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--black);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        .page {
            width: min(1100px, 96%);
            margin: 14px auto 24px;
        }

        .page-heading {
            margin-bottom: 12px;
        }

        h1 {
            margin: 0 0 4px;
            font-size: 25px;
            font-weight: 800;
        }

        .intro {
            margin: 0;
            color: var(--gray);
            font-size: 12px;
            line-height: 1.5;
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(270px, .9fr);
            gap: 12px;
            align-items: start;
        }

        .main-column,
        .side-column {
            min-width: 0;
        }

        .card {
            padding: 13px;
            margin-bottom: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 11px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .025);
            min-width: 0;
        }

        .card h2 {
            font-size: 17px;
            margin: 0 0 12px;
            font-weight: 800;
        }

        .pizza-item {
            display: grid;
            grid-template-columns: 65px minmax(0, 1fr);
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee6de;
        }

        .pizza-item:first-of-type {
            padding-top: 0;
        }

        .pizza-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .pizza-image,
        .placeholder {
            display: block;
            width: 65px;
            height: 65px;
            border-radius: 8px;
            background: #f4eee7;
        }

        .pizza-image {
            object-fit: cover;
        }

        .placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .pizza-name {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .price {
            margin-bottom: 6px;
            color: var(--green);
            font-size: 12px;
            font-weight: 700;
        }

        .actions,
        .inline-form {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .inline-form {
            gap: 5px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d8d0c7;
            border-radius: 7px;
            background: white;
            color: var(--black);
            font: inherit;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid rgba(22, 128, 60, .13);
            border-color: var(--green);
        }

        input[type="radio"] {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            margin: 2px 0 0;
            padding: 0;
            accent-color: var(--green);
        }

        input[type="number"] {
            width: 55px;
            padding: 6px;
        }

        textarea {
            min-height: 55px;
            resize: vertical;
        }

        .field {
            margin-bottom: 10px;
        }

        .field label,
        .group-label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 700;
        }

        .choice {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 8px;
            margin-bottom: 6px;
            border: 1px solid #ded5cc;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            line-height: 1.4;
        }

        .choice:has(input:checked) {
            background: #effaf2;
            border-color: var(--green);
        }

        .choice:has(input:disabled) {
            opacity: .5;
            cursor: not-allowed;
        }

        .choice strong {
            display: block;
        }

        .choice small {
            display: block;
            margin-top: 2px;
            color: var(--gray);
            font-size: 11px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 7px 10px;
            border: 1px solid var(--green);
            border-radius: 7px;
            background: var(--green);
            color: white;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background .15s ease;
        }

        .btn:hover {
            background: var(--green-hover);
            border-color: var(--green-hover);
        }

        .btn-black {
            background: var(--black);
            border-color: var(--black);
        }

        .btn-black:hover {
            background: #333;
            border-color: #333;
        }

        .btn:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .btn.full {
            display: flex;
            width: 100%;
        }

        .small-btn {
            min-height: 28px;
            padding: 5px 8px;
            font-size: 11px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
            margin: 8px 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .summary-row span:first-child {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .summary-row span:last-child {
            flex-shrink: 0;
            text-align: right;
            font-weight: 700;
        }

        .grand-total {
            padding-top: 10px;
            margin-top: 10px;
            border-top: 1px solid var(--border);
            font-size: 16px;
            font-weight: 800;
        }

        .grand-total span:last-child {
            color: var(--green);
        }

        .hint,
        .status {
            font-size: 11px;
            line-height: 1.5;
            color: var(--gray);
        }

        .hint {
            margin: 6px 0 0;
        }

        .status {
            margin-top: 5px;
        }

        .success-text {
            color: var(--green);
        }

        .error-text {
            color: #b42318;
        }

        .alert {
            padding: 10px 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 12px;
            line-height: 1.5;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #842029;
        }

        .alert ul {
            margin: 5px 0 0;
            padding-left: 20px;
        }

        .address-field[hidden] {
            display: none !important;
        }

        .empty {
            padding: 30px 15px;
            text-align: center;
        }

        .empty .emoji {
            margin-bottom: 8px;
            font-size: 42px;
        }

        .empty h2 {
            margin-bottom: 6px;
        }

        .empty p {
            margin-bottom: 15px;
        }

        .summary-actions {
            display: grid;
            gap: 7px;
            margin-top: 12px;
        }

        @media (max-width: 760px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .side-column {
                order: -1;
            }
        }

        @media (max-width: 420px) {
            .page {
                width: 94%;
                margin-top: 10px;
            }

            .card {
                padding: 10px;
            }

            .pizza-item {
                grid-template-columns: 55px minmax(0, 1fr);
                gap: 8px;
            }

            .pizza-image,
            .placeholder {
                width: 55px;
                height: 55px;
            }

            .pizza-name {
                font-size: 13px;
            }

            .btn {
                padding: 6px 8px;
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
<?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main class="page">
    <header class="page-heading">
        <h1>🍕 Order Your Pizza</h1>
        <p class="intro">Choose your pizzas, select your payment method, and place your order in one page.</p>
    </header>

    <?php if(session('success')): ?>
        <div class="alert alert-success" role="status">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error" role="alert">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error" role="alert">
            <strong>Please correct the following:</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(empty($cart)): ?>
        <section class="card empty">
            <div class="emoji">🍕</div>
            <h2>Your Cart Is Empty</h2>
            <p class="hint">Explore our menu and add your favorite pizzas.</p>
            <a href="<?php echo e(route('menu')); ?>" class="btn full">Browse Menu</a>
        </section>
    <?php else: ?>
        <div class="layout">
            <div class="main-column">
                <section class="card">
                    <h2>Your Items (<?php echo e(count($cart)); ?>)</h2>

                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizzaId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemName = $item['name'] ?? 'Pizza';
                            $quantity = (int) ($item['quantity'] ?? 1);
                            $price = (float) ($item['price'] ?? 0);
                            $itemSubtotal = $price * $quantity;
                            $itemNameLower = strtolower($itemName);

                            $filename = null;

                            foreach ($pizzaImages as $key => $candidate) {
                                if (str_contains($itemNameLower, $key)) {
                                    $filename = $candidate;
                                    break;
                                }
                            }

                            $imageUrl = $filename
                                ? asset('image/pizzas/' . rawurlencode($filename))
                                : null;
                        ?>

                        <article class="pizza-item">
                            <div>
                                <?php if($imageUrl): ?>
                                    <img
                                        class="pizza-image"
                                        src="<?php echo e($imageUrl); ?>"
                                        alt="<?php echo e($itemName); ?>"
                                        loading="lazy"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="placeholder" style="display:none">🍕</div>
                                <?php else: ?>
                                    <div class="placeholder">🍕</div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <h3 class="pizza-name"><?php echo e($itemName); ?></h3>
                                <div class="price">₱<?php echo e(number_format($price, 2)); ?> each</div>

                                <div class="summary-row" style="margin:0 0 7px">
                                    <span>Item subtotal</span>
                                    <span>₱<?php echo e(number_format($itemSubtotal, 2)); ?></span>
                                </div>

                                <div class="actions">
                                    <form
                                        action="<?php echo e(route('cart.update', $pizzaId)); ?>"
                                        method="POST"
                                        class="inline-form"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>

                                        <label for="qty-<?php echo e($pizzaId); ?>" class="hint">Qty</label>

                                        <input
                                            id="qty-<?php echo e($pizzaId); ?>"
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            max="99"
                                            value="<?php echo e($quantity); ?>"
                                            required
                                        >

                                        <button type="submit" class="btn small-btn">Update</button>
                                    </form>

                                    <form
                                        action="<?php echo e(route('cart.remove', $pizzaId)); ?>"
                                        method="POST"
                                        onsubmit="return confirm('Remove this pizza from your cart?')"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit" class="btn btn-black small-btn">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="actions" style="margin-top:12px">
                        <a href="<?php echo e(route('menu')); ?>" class="btn btn-black">Continue Shopping</a>

                        <form
                            action="<?php echo e(route('cart.clear')); ?>"
                            method="POST"
                            onsubmit="return confirm('Remove all items from your cart?')"
                        >
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit" class="btn btn-black">Clear Cart</button>
                        </form>
                    </div>
                </section>

                <section class="card">
                    <h2>Delivery and Payment</h2>

                    <form id="place-order-form" action="<?php echo e(route('checkout.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="field">
                            <span class="group-label">Order Type</span>

                            <label class="choice">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="delivery"
                                    <?php echo e($deliveryOption === 'delivery' ? 'checked' : ''); ?>

                                    required
                                >
                                <span>
                                    <strong>🚚 Delivery</strong>
                                    <small>Have your order delivered to your address.</small>
                                </span>
                            </label>

                            <label class="choice">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="pickup"
                                    <?php echo e($deliveryOption === 'pickup' ? 'checked' : ''); ?>

                                    required
                                >
                                <span>
                                    <strong>🏪 Pickup</strong>
                                    <small>Collect your order at the store. No delivery fee.</small>
                                </span>
                            </label>
                        </div>

                        <div class="field address-field" id="address-field">
                            <label for="delivery_address">Delivery Address</label>

                            <textarea
                                id="delivery_address"
                                name="delivery_address"
                                maxlength="1000"
                                placeholder="Enter your complete address, barangay, municipality, and nearby landmark."
                            ><?php echo e($deliveryAddress); ?></textarea>

                            <div id="fee-status" class="status" aria-live="polite"></div>

                            <p class="hint">
                                The delivery fee must be confirmed before placing a delivery order.
                            </p>
                        </div>

                        <div class="field">
                            <label for="contact_number">Contact Number</label>

                            <input
                                id="contact_number"
                                name="contact_number"
                                type="tel"
                                value="<?php echo e(old('contact_number', auth()->user()->phone ?? '')); ?>"
                                maxlength="30"
                                required
                                placeholder="Enter your contact number"
                            >
                        </div>

                        <div class="field">
                            <span class="group-label">Payment Method</span>

                            <label class="choice">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cash_on_delivery"
                                    <?php echo e($paymentMethod === 'cash_on_delivery' ? 'checked' : ''); ?>

                                    required
                                >
                                <span>
                                    <strong>💵 Cash on Delivery</strong>
                                    <small>Pay when your order arrives.</small>
                                </span>
                            </label>

                            <label class="choice">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cash_on_pickup"
                                    <?php echo e($paymentMethod === 'cash_on_pickup' ? 'checked' : ''); ?>

                                    required
                                >
                                <span>
                                    <strong>💰 Cash on Pickup</strong>
                                    <small>Pay when collecting your order.</small>
                                </span>
                            </label>

                            <label class="choice">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="gcash"
                                    <?php echo e($paymentMethod === 'gcash' ? 'checked' : ''); ?>

                                    required
                                >
                                <span>
                                    <strong>📱 GCash</strong>
                                    <small>Continue to the existing GCash payment process.</small>
                                </span>
                            </label>
                        </div>

                        <div class="field">
                            <label for="notes">Order Notes (Optional)</label>

                            <textarea
                                id="notes"
                                name="notes"
                                maxlength="2000"
                                placeholder="Special instructions for your order..."
                            ><?php echo e(old('notes')); ?></textarea>
                        </div>

                        <button type="submit" id="place-order-button" class="btn full">
                            Place Order
                        </button>
                    </form>
                </section>
            </div>

            <aside class="side-column">
                <section class="card">
                    <h2>Order Summary</h2>

                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $name = $item['name'] ?? 'Pizza';
                            $qty = (int) ($item['quantity'] ?? 1);
                            $price = (float) ($item['price'] ?? 0);
                        ?>

                        <div class="summary-row">
                            <span><?php echo e($name); ?> × <?php echo e($qty); ?></span>
                            <span>₱<?php echo e(number_format($price * $qty, 2)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal-display">₱<?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>

                    <div class="summary-row">
                        <span>Order Type</span>
                        <span id="order-type-display"><?php echo e($deliveryOption === 'pickup' ? 'Pickup' : 'Delivery'); ?></span>
                    </div>

                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span id="fee-display">
                            <?php if($deliveryOption === 'pickup'): ?>
                                ₱0.00
                            <?php elseif($deliveryAddress === '' || (isset($deliveryQuote) && !($deliveryQuote['known'] ?? false))): ?>
                                To be confirmed
                            <?php else: ?>
                                ₱<?php echo e(number_format($deliveryFee, 2)); ?>

                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="summary-row">
                        <span>Payment</span>
                        <span id="payment-display">
                            <?php echo e([
                                'cash_on_delivery' => 'Cash on Delivery',
                                'cash_on_pickup' => 'Cash on Pickup',
                                'gcash' => 'GCash'
                            ][$paymentMethod] ?? 'Cash on Delivery'); ?>

                        </span>
                    </div>

                    <div class="summary-row grand-total">
                        <span>Total</span>
                        <span id="total-display">
                            <?php if($deliveryOption === 'pickup'): ?>
                                ₱<?php echo e(number_format($subtotal, 2)); ?>

                            <?php elseif($deliveryAddress === '' || (isset($deliveryQuote) && !($deliveryQuote['known'] ?? false))): ?>
                                To be confirmed
                            <?php else: ?>
                                ₱<?php echo e(number_format($grandTotal, 2)); ?>

                            <?php endif; ?>
                        </span>
                    </div>

                    <p id="summary-note" class="hint">
                        Confirm the delivery fee for your current address before placing the order.
                    </p>

                    <div class="summary-actions">
                        <a href="<?php echo e(route('menu')); ?>" class="btn btn-black full">Continue Shopping</a>
                    </div>
                </section>
            </aside>
        </div>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('place-order-form');

    if (!form) {
        return;
    }

    const addressField = document.getElementById('address-field');
    const addressInput = document.getElementById('delivery_address');
    const feeStatus = document.getElementById('fee-status');
    const feeDisplay = document.getElementById('fee-display');
    const totalDisplay = document.getElementById('total-display');
    const orderTypeDisplay = document.getElementById('order-type-display');
    const paymentDisplay = document.getElementById('payment-display');
    const summaryNote = document.getElementById('summary-note');
    const placeButton = document.getElementById('place-order-button');

    const subtotal = Number(<?php echo json_encode($subtotal, 15, 512) ?>);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    let quoteKnown = false;
    let quotedAddress = '';
    let quotedFee = 0;
    let timer = null;
    let requestNumber = 0;
    let activeController = null;

    function selected(name) {
        return document.querySelector('input[name="' + name + '"]:checked')?.value || '';
    }

    function peso(amount) {
        return '₱' + Number(amount).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function setStatus(message, className = '') {
        feeStatus.textContent = message;
        feeStatus.className = 'status ' + className;
    }

    function updatePaymentAvailability() {
        const isDelivery = selected('delivery_option') === 'delivery';

        const cod = document.querySelector('input[name="payment_method"][value="cash_on_delivery"]');
        const cop = document.querySelector('input[name="payment_method"][value="cash_on_pickup"]');

        cod.disabled = !isDelivery;
        cop.disabled = isDelivery;

        if (isDelivery && cop.checked) {
            cod.checked = true;
        }

        if (!isDelivery && cod.checked) {
            cop.checked = true;
        }

        const labels = {
            cash_on_delivery: 'Cash on Delivery',
            cash_on_pickup: 'Cash on Pickup',
            gcash: 'GCash'
        };

        paymentDisplay.textContent = labels[selected('payment_method')] || 'Not selected';
    }

    function updateSummary() {
        const isDelivery = selected('delivery_option') === 'delivery';
        const address = addressInput.value.trim();

        addressField.hidden = !isDelivery;
        addressInput.required = isDelivery;

        orderTypeDisplay.textContent = isDelivery ? 'Delivery' : 'Pickup';

        updatePaymentAvailability();

        if (!isDelivery) {
            feeDisplay.textContent = peso(0);
            totalDisplay.textContent = peso(subtotal);
            summaryNote.textContent = 'Pickup orders have no delivery fee.';
            return;
        }

        if (!address || !quoteKnown || quotedAddress !== address) {
            feeDisplay.textContent = 'To be confirmed';
            totalDisplay.textContent = 'To be confirmed';
            summaryNote.textContent = 'Confirm the delivery fee for your current address before placing the order.';
            return;
        }

        feeDisplay.textContent = peso(quotedFee);
        totalDisplay.textContent = peso(subtotal + quotedFee);
        summaryNote.textContent = 'Delivery fee confirmed. Review your order details.';
    }

    async function quoteDeliveryFee() {
        const address = addressInput.value.trim();
        const currentRequest = ++requestNumber;

        if (activeController) {
            activeController.abort();
        }

        activeController = null;
        quoteKnown = false;
        quotedAddress = '';
        quotedFee = 0;

        if (selected('delivery_option') !== 'delivery') {
            setStatus('No delivery fee applies to pickup orders.', 'success-text');
            updateSummary();
            return;
        }

        if (address.length < 3) {
            setStatus('Enter your complete delivery address.');
            updateSummary();
            return;
        }

        const controller = new AbortController();
        activeController = controller;

        setStatus('Checking delivery fee...');
        updateSummary();

        try {
            const response = await fetch(<?php echo json_encode(route('delivery-fee.quote'), 15, 512) ?>, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ address: address }),
                signal: controller.signal
            });

            const data = await response.json();

            if (currentRequest !== requestNumber) {
                return;
            }

            if (!response.ok) {
                throw new Error(data.message || 'Unable to calculate the delivery fee.');
            }

            if (data.known === true && Number.isFinite(Number(data.fee))) {
                quoteKnown = true;
                quotedAddress = address;
                quotedFee = Number(data.fee);

                setStatus(
                    (data.barangay ? data.barangay + ': ' : '') +
                    'Estimated delivery fee: ' + peso(quotedFee),
                    'success-text'
                );
            } else {
                setStatus(
                    data.message || 'The delivery fee could not be confirmed for this address.',
                    'error-text'
                );
            }

            updateSummary();
        } catch (error) {
            if (error.name !== 'AbortError' && currentRequest === requestNumber) {
                setStatus(error.message || 'Unable to calculate the delivery fee.', 'error-text');
                updateSummary();
            }
        } finally {
            if (currentRequest === requestNumber) {
                activeController = null;
            }
        }
    }

    document.querySelectorAll('input[name="delivery_option"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            clearTimeout(timer);

            quoteKnown = false;
            quotedAddress = '';
            quotedFee = 0;

            updateSummary();

            if (selected('delivery_option') === 'delivery') {
                quoteDeliveryFee();
            } else {
                if (activeController) {
                    activeController.abort();
                }

                setStatus('No delivery fee applies to pickup orders.', 'success-text');
                updateSummary();
            }
        });
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
        radio.addEventListener('change', updateSummary);
    });

    addressInput.addEventListener('input', function () {
        quoteKnown = false;
        quotedAddress = '';
        quotedFee = 0;

        clearTimeout(timer);
        updateSummary();

        if (selected('delivery_option') === 'delivery') {
            setStatus('Checking the updated address...');
            timer = setTimeout(quoteDeliveryFee, 600);
        }
    });

    form.addEventListener('submit', function (event) {
        const orderType = selected('delivery_option');
        const payment = selected('payment_method');
        const address = addressInput.value.trim();

        if (orderType === 'delivery' && address.length < 3) {
            event.preventDefault();
            setStatus('Please enter your complete delivery address.', 'error-text');
            addressInput.focus();
            return;
        }

        if (orderType === 'delivery' && payment === 'cash_on_pickup') {
            event.preventDefault();
            setStatus('Cash on Pickup is only available for pickup orders.', 'error-text');
            return;
        }

        if (orderType === 'pickup' && payment === 'cash_on_delivery') {
            event.preventDefault();
            setStatus('Cash on Delivery is only available for delivery orders.', 'error-text');
            return;
        }

        if (orderType === 'delivery' && (!quoteKnown || quotedAddress !== address)) {
            event.preventDefault();
            setStatus('Please wait until the delivery fee is confirmed.', 'error-text');
            quoteDeliveryFee();
            return;
        }

        placeButton.disabled = true;
        placeButton.textContent = 'Placing Order...';
    });

    updatePaymentAvailability();
    updateSummary();

    if (selected('delivery_option') === 'delivery' && addressInput.value.trim()) {
        quoteDeliveryFee();
    } else {
        setStatus('No delivery fee applies to pickup orders.', 'success-text');
    }
});
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/cart.blade.php ENDPATH**/ ?>