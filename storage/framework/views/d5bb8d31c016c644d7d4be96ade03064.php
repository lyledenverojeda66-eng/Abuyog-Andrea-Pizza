<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Your Cart - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select {
            font-family: inherit;
        }


        /* =========================
           PAGE HEADER
        ========================= */

        .cart-header {
            text-align: center;
            padding: 35px 20px 25px;
        }

        .cart-header h1 {
            color: #e51b23;
            font-size: 38px;
            margin-bottom: 8px;
        }

        .cart-header p {
            color: #666;
            font-size: 16px;
        }


        /* =========================
           MAIN CONTAINER
        ========================= */

        .cart-container {
            width: 92%;
            max-width: 1250px;
            margin: 0 auto 50px;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
            gap: 25px;
            align-items: start;
        }


        /* =========================
           CART CARD
        ========================= */

        .cart-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 12px 0 22px;
            margin-bottom: 18px;
            border-bottom: 1px solid #e5e5e5;
        }

        .cart-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 5px;
        }


        /* =========================
           PIZZA IMAGE
        ========================= */

        .cart-image {
            width: 130px;
            height: 130px;
            flex-shrink: 0;

            border-radius: 12px;
            overflow: hidden;

            background: #f3f3f3;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .no-image {
            color: #999;
            font-size: 14px;
            text-align: center;
        }


        /* =========================
           ITEM DETAILS
        ========================= */

        .cart-details {
            flex: 1;
            min-width: 0;
        }

        .cart-details h2 {
            font-size: 23px;
            color: #111;
            margin-bottom: 6px;
        }

        .cart-price {
            color: #e51b23;
            font-size: 19px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .cart-subtotal {
            color: #555;
            font-size: 16px;
            margin-bottom: 12px;
        }


        /* =========================
           ACTIONS
        ========================= */

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .qty-label {
            font-weight: bold;
            color: #222;
        }

        .qty-input {
            width: 70px;
            height: 42px;

            border: 1px solid #ccc;
            border-radius: 7px;

            padding: 7px 10px;

            font-size: 15px;
            text-align: center;

            outline: none;
        }

        .qty-input:focus {
            border-color: #16a34a;
        }

        .btn {
            border: none;
            border-radius: 7px;

            min-height: 42px;

            padding: 9px 17px;

            font-size: 14px;
            font-weight: bold;

            cursor: pointer;
            transition: 0.2s;
        }

        .update-btn {
            background: #16a34a;
            color: white;
        }

        .update-btn:hover {
            background: #15803d;
        }

        .remove-btn {
            background: #ef1b25;
            color: white;
        }

        .remove-btn:hover {
            background: #c9151d;
        }


        /* =========================
           EMPTY CART
        ========================= */

        .empty-cart {
            background: white;
            border-radius: 16px;
            padding: 55px 25px;

            text-align: center;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        }

        .empty-cart-icon {
            font-size: 55px;
            margin-bottom: 12px;
        }

        .empty-cart h2 {
            font-size: 25px;
            margin-bottom: 8px;
        }

        .empty-cart p {
            color: #777;
            margin-bottom: 22px;
        }

        .shop-btn {
            display: inline-block;

            background: #16a34a;
            color: white;

            padding: 12px 25px;
            border-radius: 8px;

            font-weight: bold;
        }

        .shop-btn:hover {
            background: #15803d;
        }


        /* =========================
           ORDER SUMMARY
        ========================= */

        .summary-card {
            background: white;
            border-radius: 16px;
            padding: 25px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);

            position: sticky;
            top: 20px;
        }

        .summary-card h2 {
            font-size: 27px;
            margin-bottom: 22px;
            color: #222;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 12px 0;

            border-bottom: 1px solid #ddd;

            font-size: 17px;
        }

        .summary-row:last-of-type {
            border-bottom: none;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 17px 0 12px;

            color: #e51b23;

            font-size: 25px;
            font-weight: bold;
        }


        /* =========================
           SUMMARY BUTTONS
        ========================= */

        .checkout-btn {
            width: 100%;

            display: block;

            background: #16a34a;
            color: white;

            text-align: center;

            padding: 14px 15px;

            border-radius: 8px;

            font-size: 17px;
            font-weight: bold;

            margin-top: 8px;
        }

        .checkout-btn:hover {
            background: #15803d;
        }

        .continue-btn {
            width: 100%;

            display: block;

            background: #222;
            color: white;

            text-align: center;

            padding: 14px 15px;

            border-radius: 8px;

            font-size: 16px;
            font-weight: bold;

            margin-top: 12px;
        }

        .continue-btn:hover {
            background: #000;
        }

        .clear-form {
            text-align: center;
            margin-top: 18px;
        }

        .clear-btn {
            border: none;
            background: transparent;

            color: #e51b23;

            font-weight: bold;
            font-size: 14px;

            cursor: pointer;
        }

        .clear-btn:hover {
            text-decoration: underline;
        }


        /* =========================
           ORDER OPTION
        ========================= */

        .options-card {
            background: white;

            border-radius: 16px;

            padding: 25px;

            margin-top: 25px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        }

        .options-card h2 {
            font-size: 25px;
            margin-bottom: 20px;
        }

        .option-group {
            margin-bottom: 20px;
        }

        .option-group:last-child {
            margin-bottom: 0;
        }

        .option-group label.title {
            display: block;

            font-weight: bold;

            font-size: 16px;

            margin-bottom: 10px;
        }

        .option-list {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .option-item {
            flex: 1;
            min-width: 190px;
        }

        .option-item input {
            display: none;
        }

        .option-item label {
            display: block;

            padding: 14px 15px;

            border: 1px solid #d5d5d5;

            border-radius: 9px;

            cursor: pointer;

            background: #fff;

            transition: 0.2s;
        }

        .option-item label:hover {
            border-color: #16a34a;
            background: #f0fdf4;
        }

        .option-item input:checked + label {
            border-color: #16a34a;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        .option-item strong {
            display: block;
            margin-bottom: 4px;
        }

        .option-item span {
            display: block;
            font-size: 13px;
            color: #777;
        }

        .option-item input:checked + label span {
            color: #166534;
        }

        .save-options-btn {
            width: 100%;

            border: none;

            background: #16a34a;
            color: white;

            padding: 13px;

            border-radius: 8px;

            font-weight: bold;
            font-size: 15px;

            cursor: pointer;
        }

        .save-options-btn:hover {
            background: #15803d;
        }


        /* =========================
           ALERTS
        ========================= */

        .alert {
            width: 92%;
            max-width: 1250px;

            margin: 20px auto 0;

            padding: 13px 17px;

            border-radius: 8px;

            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin-left: 18px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 950px) {

            .cart-layout {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }

        }


        @media (max-width: 650px) {

            .cart-header {
                padding: 28px 15px 20px;
            }

            .cart-header h1 {
                font-size: 31px;
            }

            .cart-header p {
                font-size: 14px;
            }

            .cart-container {
                width: 94%;
            }

            .cart-card {
                padding: 17px;
            }

            .cart-item {
                align-items: flex-start;
                gap: 14px;
            }

            .cart-image {
                width: 95px;
                height: 95px;
            }

            .cart-details h2 {
                font-size: 19px;
            }

            .cart-price {
                font-size: 17px;
            }

            .cart-subtotal {
                font-size: 14px;
            }

            .cart-actions {
                gap: 7px;
            }

            .qty-input {
                width: 58px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .summary-card {
                padding: 20px;
            }

            .options-card {
                padding: 20px;
            }

            .option-item {
                min-width: 100%;
            }

        }


        @media (max-width: 450px) {

            .cart-item {
                display: grid;
                grid-template-columns: 80px 1fr;
            }

            .cart-image {
                width: 80px;
                height: 80px;
            }

            .cart-details {
                width: 100%;
            }

            .cart-actions {
                grid-column: 1 / -1;
            }

            .qty-input {
                width: 60px;
            }

        }

    </style>

</head>


<body>


    

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <?php if(session('success')): ?>

        <div class="alert alert-success">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>


    <?php if(session('error')): ?>

        <div class="alert alert-error">

            <?php echo e(session('error')); ?>


        </div>

    <?php endif; ?>


    <?php if($errors->any()): ?>

        <div class="alert alert-error">

            <ul>

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li>
                        <?php echo e($error); ?>

                    </li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

        </div>

    <?php endif; ?>


    

    <section class="cart-header">

        <h1>
            Your Cart
        </h1>

        <p>
            Review your selected pizzas before checking out.
        </p>

    </section>


    

    <main class="cart-container">


        <?php if(empty($cart)): ?>


            

            <div class="empty-cart">

                <div class="empty-cart-icon">
                    🛒
                </div>

                <h2>
                    Your cart is empty
                </h2>

                <p>
                    Add some delicious pizzas to your cart.
                </p>

                <a
                    href="<?php echo e(route('menu')); ?>"
                    class="shop-btn"
                >
                    🍕 Browse Pizza Menu
                </a>

            </div>


        <?php else: ?>


            

            <div class="cart-layout">


                

                <div>

                    <div class="cart-card">


                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizzaId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="cart-item">


                                

                                <div class="cart-image">

                                    <?php if(!empty($item['image'])): ?>

                                        <?php

                                            $pizzaImage = $item['image'];

                                            if (
                                                str_starts_with(
                                                    $pizzaImage,
                                                    'http://'
                                                ) ||
                                                str_starts_with(
                                                    $pizzaImage,
                                                    'https://'
                                                )
                                            ) {

                                                $pizzaImageUrl =
                                                    $pizzaImage;

                                            } else {

                                                $pizzaImageUrl =
                                                    asset(
                                                        'image/pizzas/' .
                                                        ltrim(
                                                            $pizzaImage,
                                                            '/'
                                                        )
                                                    );

                                            }

                                        ?>


                                        <img
                                            src="<?php echo e($pizzaImageUrl); ?>"
                                            alt="<?php echo e($item['name']); ?>"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >

                                        <div
                                            class="no-image"
                                            style="display:none;"
                                        >
                                            No Image
                                        </div>

                                    <?php else: ?>

                                        <div class="no-image">
                                            No Image
                                        </div>

                                    <?php endif; ?>

                                </div>


                                

                                <div class="cart-details">

                                    <h2>
                                        <?php echo e($item['name']); ?>

                                    </h2>

                                    <div class="cart-price">

                                        ₱<?php echo e(number_format(
                                            $item['price'],
                                            2
                                        )); ?>


                                    </div>

                                    <div class="cart-subtotal">

                                        Subtotal:

                                        ₱<?php echo e(number_format(
                                            $item['price'] *
                                            $item['quantity'],
                                            2
                                        )); ?>


                                    </div>


                                    

                                    <div class="cart-actions">


                                        <span class="qty-label">
                                            Qty:
                                        </span>


                                        <form
                                            action="<?php echo e(route('cart.update', $pizzaId)); ?>"
                                            method="POST"
                                            style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;"
                                        >

                                            <?php echo csrf_field(); ?>

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="<?php echo e($item['quantity']); ?>"
                                                min="1"
                                                class="qty-input"
                                                required
                                            >


                                            <button
                                                type="submit"
                                                class="btn update-btn"
                                            >
                                                Update
                                            </button>

                                        </form>


                                        <form
                                            action="<?php echo e(route('cart.remove', $pizzaId)); ?>"
                                            method="POST"
                                        >

                                            <?php echo csrf_field(); ?>

                                            <button
                                                type="submit"
                                                class="btn remove-btn"
                                            >
                                                Remove
                                            </button>

                                        </form>


                                    </div>

                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>


                    

                    <div class="options-card">

                        <h2>
                            Order Option
                        </h2>


                        <form
                            action="<?php echo e(route('cart.options')); ?>"
                            method="POST"
                        >

                            <?php echo csrf_field(); ?>


                            

                            <div class="option-group">

                                <label class="title">
                                    How would you like to receive your order?
                                </label>


                                <div class="option-list">


                                    <div class="option-item">

                                        <input
                                            type="radio"
                                            id="delivery"
                                            name="delivery_option"
                                            value="delivery"
                                            <?php echo e($deliveryOption === 'delivery' ? 'checked' : ''); ?>

                                        >

                                        <label for="delivery">

                                            <strong>
                                                🚚 Delivery
                                            </strong>

                                            <span>
                                                Delivery fee: ₱50.00
                                            </span>

                                        </label>

                                    </div>


                                    <div class="option-item">

                                        <input
                                            type="radio"
                                            id="pickup"
                                            name="delivery_option"
                                            value="pickup"
                                            <?php echo e($deliveryOption === 'pickup' ? 'checked' : ''); ?>

                                        >

                                        <label for="pickup">

                                            <strong>
                                                🏪 Pickup
                                            </strong>

                                            <span>
                                                No delivery fee
                                            </span>

                                        </label>

                                    </div>


                                </div>

                            </div>


                            

                            <div class="option-group">

                                <label class="title">
                                    Payment Method
                                </label>


                                <div class="option-list">


                                    <div
                                        class="option-item"
                                        data-payment="delivery-cash"
                                    >

                                        <input
                                            type="radio"
                                            id="cash_delivery"
                                            name="payment_method"
                                            value="cash_on_delivery"
                                            <?php echo e($paymentMethod === 'cash_on_delivery' ? 'checked' : ''); ?>

                                        >

                                        <label for="cash_delivery">

                                            <strong>
                                                💵 Cash on Delivery
                                            </strong>

                                            <span>
                                                Pay when your order arrives
                                            </span>

                                        </label>

                                    </div>


                                    <div
                                        class="option-item"
                                        data-payment="pickup-cash"
                                    >

                                        <input
                                            type="radio"
                                            id="cash_pickup"
                                            name="payment_method"
                                            value="cash_on_pickup"
                                            <?php echo e($paymentMethod === 'cash_on_pickup' ? 'checked' : ''); ?>

                                        >

                                        <label for="cash_pickup">

                                            <strong>
                                                💵 Cash on Pickup
                                            </strong>

                                            <span>
                                                Pay when you pick up your order
                                            </span>

                                        </label>

                                    </div>


                                    <div class="option-item">

                                        <input
                                            type="radio"
                                            id="gcash"
                                            name="payment_method"
                                            value="gcash"
                                            <?php echo e($paymentMethod === 'gcash' ? 'checked' : ''); ?>

                                        >

                                        <label for="gcash">

                                            <strong>
                                                📱 GCash
                                            </strong>

                                            <span>
                                                Pay using GCash
                                            </span>

                                        </label>

                                    </div>


                                </div>

                            </div>


                            <button
                                type="submit"
                                class="save-options-btn"
                            >
                                Save Order Options
                            </button>


                        </form>

                    </div>


                </div>


                

                <aside class="summary-card">


                    <h2>
                        Order Summary
                    </h2>


                    <div class="summary-row">

                        <span>
                            Items
                        </span>

                        <span>
                            <?php echo e(count($cart)); ?>

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <span>
                            ₱<?php echo e(number_format(
                                $total,
                                2
                            )); ?>

                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Delivery Fee
                        </span>

                        <span>

                            ₱<?php echo e(number_format(
                                $deliveryFee,
                                2
                            )); ?>


                        </span>

                    </div>


                    <div class="summary-total">

                        <span>
                            Total
                        </span>

                        <span>
                            ₱<?php echo e(number_format(
                                $grandTotal,
                                2
                            )); ?>

                        </span>

                    </div>


                    <a
                        href="<?php echo e(route('checkout')); ?>"
                        class="checkout-btn"
                    >
                        Proceed to Checkout
                    </a>


                    <a
                        href="<?php echo e(route('menu')); ?>"
                        class="continue-btn"
                    >
                        Continue Shopping
                    </a>


                    <form
                        action="<?php echo e(route('cart.clear')); ?>"
                        method="POST"
                        class="clear-form"
                    >

                        <?php echo csrf_field(); ?>

                        <button
                            type="submit"
                            class="clear-btn"
                            onclick="return confirm('Are you sure you want to clear your cart?')"
                        >
                            Clear Cart
                        </button>

                    </form>


                </aside>


            </div>


        <?php endif; ?>


    </main>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const delivery =
                    document.getElementById(
                        'delivery'
                    );

                const pickup =
                    document.getElementById(
                        'pickup'
                    );

                const cashDelivery =
                    document.getElementById(
                        'cash_delivery'
                    );

                const cashPickup =
                    document.getElementById(
                        'cash_pickup'
                    );


                function updatePaymentOptions() {

                    if (!delivery || !pickup) {
                        return;
                    }


                    if (delivery.checked) {

                        cashDelivery.disabled = false;

                        cashPickup.disabled = true;

                        if (cashPickup.checked) {

                            cashDelivery.checked = true;

                        }

                    }


                    if (pickup.checked) {

                        cashDelivery.disabled = true;

                        cashPickup.disabled = false;

                        if (cashDelivery.checked) {

                            cashPickup.checked = true;

                        }

                    }

                }


                if (delivery) {

                    delivery.addEventListener(
                        'change',
                        updatePaymentOptions
                    );

                }


                if (pickup) {

                    pickup.addEventListener(
                        'change',
                        updatePaymentOptions
                    );

                }


                updatePaymentOptions();

            }
        );

    </script>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/cart.blade.php ENDPATH**/ ?>