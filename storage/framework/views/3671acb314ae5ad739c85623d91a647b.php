<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Abuyog Andrea Pizza</title>

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

        .checkout-page {
            max-width: 1080px;
            margin: 0 auto;
            padding: 30px 20px 50px;
        }

        .checkout-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .checkout-title h1 {
            margin: 0;
            color: #ed1c24;
            font-size: 36px;
        }

        .checkout-title p {
            margin-top: 6px;
            color: #666;
            font-size: 17px;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 25px;
            align-items: start;
        }

        .checkout-card,
        .summary-card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .checkout-card h2,
        .summary-card h2 {
            margin-top: 0;
            margin-bottom: 22px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ed1c24;
        }

        .error-box {
            background: #ffe5e5;
            color: #b00000;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding-top: 18px;
            font-size: 22px;
            font-weight: bold;
            color: #ed1c24;
        }

        .place-order-btn {
            width: 100%;
            margin-top: 18px;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #16a34a;
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        .place-order-btn:hover {
            background: #12813b;
        }

        .back-btn {
            display: block;
            width: 100%;
            margin-top: 12px;
            padding: 13px;
            border-radius: 8px;
            background: #222;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            background: #000;
        }

        .selected-info {
            background: #f5f5f5;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #444;
        }

        @media (max-width: 800px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .checkout-title h1 {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="checkout-page">

        <div class="checkout-title">
            <h1>Checkout</h1>
            <p>Complete your order details below.</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="error-box">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="error-box">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="checkout-layout">

                
                <div class="checkout-card">

                    <h2>Order Details</h2>

                    
                    <div class="selected-info">
                        Your delivery and payment options have already been selected in your cart.
                    </div>

                    <div class="form-group">
                        <label for="delivery_address">
                            Delivery Address
                        </label>

                        <textarea
                            id="delivery_address"
                            name="delivery_address"
                            placeholder="Enter your complete delivery address"
                            required
                        ><?php echo e(old('delivery_address')); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="contact_number">
                            Contact Number
                        </label>

                        <input
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            value="<?php echo e(old('contact_number')); ?>"
                            placeholder="09XXXXXXXXX"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="notes">
                            Order Notes
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            placeholder="Optional notes..."
                        ><?php echo e(old('notes')); ?></textarea>
                    </div>

                </div>

                
                <div class="summary-card">

                    <h2>Order Summary</h2>

                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="order-item">
                            <span>
                                <?php echo e($item['name']); ?>

                                × <?php echo e($item['quantity']); ?>

                            </span>

                            <span>
                                ₱<?php echo e(number_format(
                                    $item['price'] * $item['quantity'],
                                    2
                                )); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>
                            ₱<?php echo e(number_format($subtotal, 2)); ?>

                        </span>
                    </div>

                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span>
                            ₱<?php echo e(number_format($deliveryFee, 2)); ?>

                        </span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span>
                            ₱<?php echo e(number_format($total, 2)); ?>

                        </span>
                    </div>

                    <button
                        type="submit"
                        class="place-order-btn"
                    >
                        Place Order
                    </button>

                    <a
                        href="<?php echo e(route('cart')); ?>"
                        class="back-btn"
                    >
                        ← Back to Cart
                    </a>

                </div>

            </div>
        </form>

    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/checkout.blade.php ENDPATH**/ ?>