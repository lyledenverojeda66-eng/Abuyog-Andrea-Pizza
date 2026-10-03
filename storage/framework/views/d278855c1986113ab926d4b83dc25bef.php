<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Confirmation - Abuyog Andrea Pizza</title>

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

        .navbar {
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .logo {
            line-height: 0.9;
            font-weight: 800;
        }

        .logo .top {
            display: block;
            color: #111;
            font-size: 20px;
        }

        .logo .bottom {
            display: block;
            color: #ed1c24;
            font-size: 25px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .nav-links a,
        .logout-btn {
            color: #111;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-btn {
            border: none;
            background: none;
            cursor: pointer;
            font-family: inherit;
        }

        .container {
            width: 92%;
            max-width: 900px;
            margin: 35px auto;
        }

        .success-box {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }

        .check {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #198754;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 30px;
            font-weight: bold;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .subtitle {
            color: #666;
            margin: 0 0 25px;
        }

        .order-number {
            display: inline-block;
            background: #fff3cd;
            padding: 10px 16px;
            border-radius: 7px;
            font-weight: bold;
            color: #664d03;
        }

        .section {
            margin-top: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
        }

        .section h2 {
            margin: 0 0 15px;
            font-size: 19px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
        }

        .item-info {
            color: #666;
            font-size: 14px;
            margin-top: 4px;
        }

        .price {
            font-weight: bold;
            white-space: nowrap;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .summary-row.total {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 14px;
            font-size: 19px;
            font-weight: bold;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-box {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 13px;
        }

        .detail-label {
            color: #777;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #fff3cd;
            color: #664d03;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-primary {
            background: #ed1c24;
            color: white;
        }

        .btn-secondary {
            background: #222;
            color: white;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 14px 18px;
            }

            .nav-links {
                gap: 12px;
            }

            .container {
                width: 94%;
                margin: 20px auto;
            }

            .success-box {
                padding: 22px;
            }

            .details {
                grid-template-columns: 1fr;
            }

            .item {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    
    <nav class="navbar">

        <div class="logo">
            <span class="top">ABUYOG ANDREA</span>
            <span class="bottom">PIZZA</span>
        </div>

        <div class="nav-links">

            <a href="<?php echo e(route('home')); ?>">
                Home
            </a>

            <a href="<?php echo e(route('menu')); ?>">
                Menu
            </a>

            <a href="<?php echo e(route('contact')); ?>">
                Contact
            </a>

            <a href="<?php echo e(route('customer.dashboard')); ?>">
                Customer Dashboard
            </a>

            <a href="<?php echo e(route('cart')); ?>">
                🛒 Cart
            </a>

            <a href="<?php echo e(route('customer.orders')); ?>">
                My Orders
            </a>

            <form
                action="<?php echo e(route('logout')); ?>"
                method="POST"
                style="display:inline;"
            >
                <?php echo csrf_field(); ?>

                <button
                    type="submit"
                    class="logout-btn"
                >
                    Logout
                </button>
            </form>

        </div>

    </nav>


    <main class="container">

        
        <div class="success-box">

            <div class="check">
                ✓
            </div>

            <h1>Order Placed Successfully!</h1>

            <p class="subtitle">
                Thank you for ordering from Abuyog Andrea Pizza.
            </p>

            <div class="order-number">
                Order #: <?php echo e($order->order_number); ?>

            </div>

        </div>


        
        <div class="section">

            <h2>Order Summary</h2>

            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="item">

                    <div>

                        <div class="item-name">
                            <?php echo e($item->pizza->name); ?>

                        </div>

                        <div class="item-info">
                            ₱<?php echo e(number_format($item->price, 2)); ?>

                            ×
                            <?php echo e($item->quantity); ?>

                        </div>

                    </div>

                    <div class="price">
                        ₱<?php echo e(number_format($item->subtotal, 2)); ?>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>


        
        <div class="section">

            <h2>Order Information</h2>

            <div class="details">

                <div class="detail-box">

                    <div class="detail-label">
                        Order Status
                    </div>

                    <div>
                        <span class="status">
                            <?php echo e(str_replace('_', ' ', $order->status)); ?>

                        </span>
                    </div>

                </div>


                <div class="detail-box">

                    <div class="detail-label">
                        Payment Method
                    </div>

                    <div class="detail-value">

                        <?php if($order->payment_method === 'gcash'): ?>

                            GCash / MariBank

                        <?php elseif($order->payment_method === 'cash_on_pickup'): ?>

                            Cash on Pickup

                        <?php else: ?>

                            Cash on Delivery

                        <?php endif; ?>

                    </div>

                </div>


                <div class="detail-box">

                    <div class="detail-label">
                        Order Type
                    </div>

                    <div class="detail-value">

                        <?php if($order->delivery_option === 'pickup'): ?>

                            Pick Up

                        <?php else: ?>

                            Delivery

                        <?php endif; ?>

                    </div>

                </div>


                <div class="detail-box">

                    <div class="detail-label">
                        Contact Number
                    </div>

                    <div class="detail-value">
                        <?php echo e($order->contact_number); ?>

                    </div>

                </div>


                <?php if($order->delivery_option === 'delivery'): ?>

                    <div class="detail-box" style="grid-column: 1 / -1;">

                        <div class="detail-label">
                            Delivery Address
                        </div>

                        <div class="detail-value">
                            <?php echo e($order->delivery_address); ?>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        
        <div class="section">

            <h2>Payment Summary</h2>

            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <span>
                    ₱<?php echo e(number_format($order->subtotal, 2)); ?>

                </span>

            </div>


            <div class="summary-row">

                <span>
                    Delivery Fee
                </span>

                <span>

                    <?php if($order->delivery_fee > 0): ?>

                        ₱<?php echo e(number_format($order->delivery_fee, 2)); ?>


                    <?php else: ?>

                        ₱0.00

                    <?php endif; ?>

                </span>

            </div>


            <div class="summary-row total">

                <span>
                    Total
                </span>

                <span>
                    ₱<?php echo e(number_format($order->total_amount, 2)); ?>

                </span>

            </div>

        </div>


        
        <div class="actions">

            <a
                href="<?php echo e(route('customer.orders')); ?>"
                class="btn btn-primary"
            >
                View My Orders
            </a>

            <a
                href="<?php echo e(route('menu')); ?>"
                class="btn btn-secondary"
            >
                Continue Shopping
            </a>

        </div>

    </main>

</body>
</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/order/confirmation.blade.php ENDPATH**/ ?>