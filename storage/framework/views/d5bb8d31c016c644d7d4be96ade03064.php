<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Your Cart - Abuyog Andrea Pizza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        .cart-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px 20px 50px;
        }

        .cart-title {
            text-align: center;
            margin-bottom: 26px;
        }

        .cart-title h1 {
            margin: 0;
            color: #ed1c24;
            font-size: 36px;
        }

        .cart-title p {
            margin-top: 8px;
            color: #666;
            font-size: 17px;
        }

        .success-message {
            max-width: 900px;
            margin: 0 auto 20px;
            padding: 12px 16px;
            background: #e8f8ee;
            border: 1px solid #b9e8ca;
            color: #15803d;
            border-radius: 8px;
            font-weight: bold;
        }

        .error-message {
            max-width: 900px;
            margin: 0 auto 20px;
            padding: 12px 16px;
            background: #ffe8e8;
            border: 1px solid #f3b5b5;
            color: #c40000;
            border-radius: 8px;
            font-weight: bold;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 365px;
            gap: 25px;
            align-items: start;
        }

        .cart-items-card,
        .summary-card,
        .options-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .cart-item {
            display: flex;
            gap: 18px;
            padding: 10px 0 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 5px;
        }

        .pizza-image {
            width: 120px;
            height: 120px;
            background: #f5f5f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .pizza-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .pizza-image .no-image {
            color: #999;
            font-size: 13px;
            text-align: center;
        }

        .item-details {
            flex: 1;
            min-width: 0;
        }

        .item-details h2 {
            margin: 0 0 6px;
            font-size: 22px;
        }

        .item-price {
            color: #ed1c24;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 7px;
        }

        .item-subtotal {
            color: #555;
            margin-bottom: 12px;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .update-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .quantity-label {
            font-weight: bold;
            margin-right: 2px;
        }

        .quantity-input {
            width: 65px;
            height: 38px;
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            text-align: center;
        }

        .quantity-input:focus {
            outline: none;
            border-color: #159447;
        }

        .update-btn,
        .remove-btn {
            border: none;
            padding: 9px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            height: 38px;
        }

        .update-btn {
            background: #159447;
            color: white;
        }

        .update-btn:hover {
            background: #117a3a;
        }

        .remove-btn {
            background: #ed1c24;
            color: white;
        }

        .remove-btn:hover {
            background: #c9141b;
        }

        .remove-form {
            margin: 0;
        }

        .summary-card {
            position: sticky;
            top: 20px;
        }

        .summary-card h2,
        .options-card h2 {
            margin: 0 0 20px;
            font-size: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 11px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding-top: 18px;
            font-size: 23px;
            font-weight: bold;
            color: #ed1c24;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            margin-top: 22px;
            padding: 14px;
            background: #159447;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .checkout-btn:hover {
            background: #117a3a;
        }

        .shopping-btn {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            background: #222;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .shopping-btn:hover {
            background: #000;
        }

        .clear-form {
            text-align: center;
            margin-top: 18px;
        }

        .clear-btn {
            border: none;
            background: none;
            color: #ed1c24;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .clear-btn:hover {
            text-decoration: underline;
        }

        .options-card {
            margin-top: 25px;
        }

        .current-selection {
            background: #e8f8ee;
            border: 1px solid #b9e8ca;
            color: #087a36;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .option-title {
            font-size: 17px;
            font-weight: bold;
            margin: 0 0 10px;
        }

        .option-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 15px;
            margin-bottom: 9px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            background: #fff;
        }

        .option-box:hover {
            border-color: #159447;
            background: #f8fff9;
        }

        .option-box input {
            width: 16px;
            height: 16px;
            accent-color: #159447;
        }

        .option-box label {
            cursor: pointer;
            flex: 1;
            font-size: 15px;
        }

        .payment-section {
            margin-top: 20px;
        }

        .save-options-btn {
            width: 100%;
            border: none;
            padding: 13px;
            margin-top: 10px;
            border-radius: 8px;
            background: #159447;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .save-options-btn:hover {
            background: #117a3a;
        }

        .empty-cart {
            max-width: 650px;
            margin: 60px auto;
            background: white;
            border-radius: 14px;
            padding: 45px 25px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-cart h2 {
            margin-top: 0;
            font-size: 28px;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 25px;
        }

        .empty-cart a {
            display: inline-block;
            padding: 13px 22px;
            background: #159447;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        @media (max-width: 850px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .cart-page {
                padding: 20px 12px 40px;
            }

            .cart-title h1 {
                font-size: 30px;
            }

            .cart-item {
                gap: 12px;
            }

            .pizza-image {
                width: 90px;
                height: 90px;
            }

            .item-details h2 {
                font-size: 19px;
            }

            .cart-actions {
                align-items: flex-start;
            }

            .update-form {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="cart-page">

        <div class="cart-title">
            <h1>Your Cart</h1>
            <p>Review your selected pizzas before checking out.</p>
        </div>

        
        <?php if(session('success')): ?>
            <div class="success-message">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <?php if(session('error')): ?>
            <div class="error-message">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(empty($cart)): ?>

            <div class="empty-cart">

                <h2>Your cart is empty.</h2>

                <p>
                    Add some delicious pizzas before checking out.
                </p>

                <a href="<?php echo e(route('menu')); ?>">
                    Browse Pizza Menu
                </a>

            </div>

        <?php else: ?>

            <div class="cart-layout">

                
                <div>

                    
                    <div class="cart-items-card">

                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizzaId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="cart-item">

                                <div class="pizza-image">

                                    <?php if(!empty($item['image'])): ?>

                                        <img
                                            src="<?php echo e(asset($item['image'])); ?>"
                                            alt="<?php echo e($item['name']); ?>"
                                        >

                                    <?php else: ?>

                                        <span class="no-image">
                                            No Image
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <div class="item-details">

                                    <h2>
                                        <?php echo e($item['name']); ?>

                                    </h2>

                                    <div class="item-price">
                                        ₱<?php echo e(number_format($item['price'], 2)); ?>

                                    </div>

                                    <div class="item-subtotal">
                                        Subtotal:
                                        ₱<?php echo e(number_format(
                                            $item['price'] * $item['quantity'],
                                            2
                                        )); ?>

                                    </div>

                                    
                                    <div class="cart-actions">

                                        <form
                                            action="<?php echo e(route('cart.update', $pizzaId)); ?>"
                                            method="POST"
                                            class="update-form"
                                        >

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>

                                            <span class="quantity-label">
                                                Qty:
                                            </span>

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="<?php echo e($item['quantity']); ?>"
                                                min="1"
                                                class="quantity-input"
                                                required
                                            >

                                            <button
                                                type="submit"
                                                class="update-btn"
                                            >
                                                Update
                                            </button>

                                        </form>

                                        <form
                                            action="<?php echo e(route('cart.remove', $pizzaId)); ?>"
                                            method="POST"
                                            class="remove-form"
                                        >

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button
                                                type="submit"
                                                class="remove-btn"
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

                        <div class="current-selection">

                            <strong>
                                Your selection:
                            </strong>

                            <br>

                            <?php if($deliveryOption === 'delivery'): ?>

                                🚚 Delivery

                            <?php else: ?>

                                🏪 Pickup

                            <?php endif; ?>

                            <br>

                            Payment:

                            <?php if($paymentMethod === 'cash_on_delivery'): ?>

                                Cash on Delivery

                            <?php elseif($paymentMethod === 'cash_on_pickup'): ?>

                                Cash on Pickup

                            <?php elseif($paymentMethod === 'gcash'): ?>

                                GCash

                            <?php else: ?>

                                Not selected

                            <?php endif; ?>

                        </div>


                        <form
                            action="<?php echo e(route('cart.options')); ?>"
                            method="POST"
                        >

                            <?php echo csrf_field(); ?>

                            
                            <p class="option-title">
                                Do you want delivery?
                            </p>

                            <label class="option-box">

                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="delivery"
                                    <?php echo e($deliveryOption === 'delivery' ? 'checked' : ''); ?>

                                >

                                <span>
                                    🚚 Yes, deliver my order
                                </span>

                            </label>

                            <label class="option-box">

                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="pickup"
                                    <?php echo e($deliveryOption === 'pickup' ? 'checked' : ''); ?>

                                >

                                <span>
                                    🏪 No, I will pick up my order
                                </span>

                            </label>


                            
                            <div class="payment-section">

                                <p class="option-title">
                                    Payment Method
                                </p>

                                
                                <label
                                    class="option-box"
                                    id="cash-delivery-option"
                                >

                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="cash_on_delivery"
                                        <?php echo e($paymentMethod === 'cash_on_delivery' ? 'checked' : ''); ?>

                                    >

                                    <span>
                                        💵 Cash on Delivery
                                    </span>

                                </label>

                                
                                <label
                                    class="option-box"
                                    id="cash-pickup-option"
                                >

                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="cash_on_pickup"
                                        <?php echo e($paymentMethod === 'cash_on_pickup' ? 'checked' : ''); ?>

                                    >

                                    <span>
                                        💵 Cash on Pickup
                                    </span>

                                </label>

                                
                                <label class="option-box">

                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="gcash"
                                        <?php echo e($paymentMethod === 'gcash' ? 'checked' : ''); ?>

                                    >

                                    <span>
                                        📱 GCash
                                    </span>

                                </label>

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


                
                <div class="summary-card">

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
                            ₱<?php echo e(number_format($total, 2)); ?>

                        </span>

                    </div>

                    <div class="summary-row">

                        <span>
                            Delivery Fee
                        </span>

                        <span>
                            ₱<?php echo e(number_format($deliveryFee, 2)); ?>

                        </span>

                    </div>

                    <div class="summary-total">

                        <span>
                            Total
                        </span>

                        <span>
                            ₱<?php echo e(number_format($grandTotal, 2)); ?>

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
                        class="shopping-btn"
                    >
                        Continue Shopping
                    </a>


                    <form
                        action="<?php echo e(route('cart.clear')); ?>"
                        method="POST"
                        class="clear-form"
                    >

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button
                            type="submit"
                            class="clear-btn"
                            onclick="return confirm('Are you sure you want to clear your cart?')"
                        >
                            Clear Cart
                        </button>

                    </form>

                </div>

            </div>

        <?php endif; ?>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const deliveryOptions =
                document.querySelectorAll(
                    'input[name="delivery_option"]'
                );

            const cashDelivery =
                document.querySelector(
                    '#cash-delivery-option'
                );

            const cashPickup =
                document.querySelector(
                    '#cash-pickup-option'
                );

            function updatePaymentOptions() {

                const selected =
                    document.querySelector(
                        'input[name="delivery_option"]:checked'
                    );

                if (!selected) {
                    return;
                }

                if (selected.value === 'delivery') {

                    cashDelivery.style.display = 'flex';
                    cashPickup.style.display = 'none';

                    const pickupRadio =
                        document.querySelector(
                            'input[value="cash_on_pickup"]'
                        );

                    if (pickupRadio) {
                        pickupRadio.checked = false;
                    }

                } else {

                    cashDelivery.style.display = 'none';
                    cashPickup.style.display = 'flex';

                    const deliveryRadio =
                        document.querySelector(
                            'input[value="cash_on_delivery"]'
                        );

                    if (deliveryRadio) {
                        deliveryRadio.checked = false;
                    }
                }
            }

            deliveryOptions.forEach(function (option) {

                option.addEventListener(
                    'change',
                    updatePaymentOptions
                );

            });

            updatePaymentOptions();

        });
    </script>

</body>
</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/cart.blade.php ENDPATH**/ ?>