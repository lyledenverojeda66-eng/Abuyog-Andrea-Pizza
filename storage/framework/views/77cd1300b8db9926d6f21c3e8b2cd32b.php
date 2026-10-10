<?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Customer Dashboard - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #fff8ee;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
        }

        /* =========================================
           DASHBOARD CONTAINER
        ========================================= */

        .dashboard-container {
            width: 90%;
            max-width: 1280px;
            margin: 42px auto 50px;
        }

        /* =========================================
           WELCOME HEADER
        ========================================= */

        .welcome-box {
            background: linear-gradient(
                135deg,
                #16a34a,
                #168b42
            );

            color: white;

            border-radius: 18px;

            padding: 38px 42px;

            min-height: 185px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;

            box-shadow:
                0 10px 25px
                rgba(22, 163, 74, 0.20);
        }

        .welcome-content {
            flex: 1;
        }

        .welcome-content h1 {
            margin: 0 0 12px;

            font-size: 34px;
            line-height: 1.2;

            color: #ffffff;
        }

        .welcome-content p {
            margin: 0;

            font-size: 16px;
            line-height: 1.5;

            color: #ffffff;
        }

        .welcome-icon {
            font-size: 75px;
            line-height: 1;

            flex-shrink: 0;
        }

        /* =========================================
           QUICK ACTIONS
        ========================================= */

        .quick-actions {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-top: 30px;
        }

        .action-card {
            background: #ffffff;

            border-radius: 15px;

            padding: 25px;

            display: flex;
            align-items: center;

            gap: 18px;

            text-decoration: none;

            color: #222;

            box-shadow:
                0 3px 12px
                rgba(0, 0, 0, 0.07);

            border: 1px solid #eeeeee;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .action-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 7px 18px
                rgba(0, 0, 0, 0.10);
        }

        .action-icon {
            width: 58px;
            height: 58px;

            border-radius: 50%;

            background: #dcfce7;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 29px;

            flex-shrink: 0;
        }

        .action-content h3 {
            margin: 0 0 5px;

            color: #168b42;

            font-size: 19px;
        }

        .action-content p {
            margin: 0;

            color: #666;

            font-size: 14px;

            line-height: 1.4;
        }

        /* =========================================
           RECENT ORDERS HEADER
        ========================================= */

        .recent-header {
            margin-top: 42px;

            margin-bottom: 18px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }

        .recent-header h2 {
            margin: 0;

            font-size: 28px;

            color: #222;
        }

        .recent-header h2 span {
            color: #16a34a;
        }

        .order-again {
            color: #16a34a;

            text-decoration: none;

            font-weight: 700;

            font-size: 14px;
        }

        .order-again:hover {
            text-decoration: underline;
        }

        /* =========================================
           ORDER CARD
        ========================================= */

        .orders-list {
            display: flex;

            flex-direction: column;

            gap: 12px;
        }

        .order-card {
            background: #ffffff;

            border-radius: 15px;

            padding: 20px 28px;

            display: grid;

            grid-template-columns:
                2fr 1fr 1fr auto;

            align-items: center;

            gap: 25px;

            border-left: 5px solid #16a34a;

            box-shadow:
                0 3px 10px
                rgba(0, 0, 0, 0.06);
        }

        .order-number {
            color: #168b42;

            font-size: 18px;

            font-weight: 800;

            margin-bottom: 6px;
        }

        .order-date {
            color: #777;

            font-size: 13px;
        }

        .order-label {
            color: #888;

            font-size: 11px;

            text-transform: uppercase;

            margin-bottom: 5px;
        }

        .order-total {
            color: #16a34a;

            font-size: 19px;

            font-weight: 800;
        }

        /* =========================================
           STATUS
        ========================================= */

        .status {
            display: inline-block;

            padding: 8px 14px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 700;

            text-transform: capitalize;
        }

        .status.pending {
            background: #fff3cd;
            color: #996c00;
        }

        .status.confirmed {
            background: #cff4fc;
            color: #087990;
        }

        .status.preparing {
            background: #e2d9f3;
            color: #59359a;
        }

        .status.ready_for_delivery {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status.out_for_delivery {
            background: #cfe2ff;
            color: #084298;
        }

        .status.delivered {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status.cancelled {
            background: #f8d7da;
            color: #842029;
        }

        /* =========================================
           VIEW ORDER BUTTON
        ========================================= */

        .view-order {
            display: inline-block;

            background: #16a34a;

            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 22px;

            font-size: 13px;

            font-weight: 700;

            white-space: nowrap;

            transition:
                background 0.2s ease;
        }

        .view-order:hover {
            background: #12833c;
        }

        /* =========================================
           EMPTY ORDERS
        ========================================= */

        .empty-orders {
            background: #ffffff;

            border-radius: 15px;

            padding: 40px 20px;

            text-align: center;

            box-shadow:
                0 3px 10px
                rgba(0, 0, 0, 0.06);
        }

        .empty-orders .empty-icon {
            font-size: 45px;

            margin-bottom: 10px;
        }

        .empty-orders h3 {
            margin: 0 0 8px;

            color: #333;

            font-size: 20px;
        }

        .empty-orders p {
            margin: 0 0 18px;

            color: #777;

            font-size: 14px;
        }

        .menu-button {
            display: inline-block;

            background: #16a34a;

            color: white;

            text-decoration: none;

            padding: 10px 20px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: 700;
        }

        /* =========================================
           TABLET
        ========================================= */

        @media (max-width: 1000px) {

            .dashboard-container {
                width: 92%;

                margin-top: 30px;
            }

            .welcome-box {
                padding: 30px;

                min-height: 160px;
            }

            .welcome-content h1 {
                font-size: 28px;
            }

            .welcome-content p {
                font-size: 14px;
            }

            .welcome-icon {
                font-size: 60px;
            }

            .quick-actions {
                gap: 15px;
            }

            .action-card {
                padding: 18px;

                gap: 12px;
            }

            .action-icon {
                width: 50px;
                height: 50px;

                font-size: 24px;
            }

            .action-content h3 {
                font-size: 16px;
            }

            .action-content p {
                font-size: 12px;
            }

            .order-card {
                grid-template-columns:
                    1.7fr 1fr 1fr;

                padding: 18px;
            }

            .view-order {
                grid-column: 1 / -1;

                width: fit-content;
            }
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 700px) {

            .dashboard-container {
                width: 94%;

                margin-top: 22px;
            }

            .welcome-box {
                padding: 25px;

                min-height: auto;

                border-radius: 14px;
            }

            .welcome-content h1 {
                font-size: 24px;
            }

            .welcome-content p {
                font-size: 13px;
            }

            .welcome-icon {
                font-size: 45px;
            }

            .quick-actions {
                grid-template-columns: 1fr;

                gap: 12px;

                margin-top: 20px;
            }

            .action-card {
                padding: 17px;
            }

            .recent-header {
                margin-top: 30px;

                align-items: flex-start;

                flex-direction: column;
            }

            .recent-header h2 {
                font-size: 23px;
            }

            .order-card {
                grid-template-columns: 1fr;

                gap: 12px;

                padding: 18px;
            }

            .view-order {
                grid-column: auto;

                width: 100%;

                text-align: center;
            }
        }

        /* =========================================
           SMALL MOBILE
        ========================================= */

        @media (max-width: 450px) {

            .welcome-box {
                padding: 20px;
            }

            .welcome-content h1 {
                font-size: 21px;
            }

            .welcome-content p {
                font-size: 12px;
            }

            .welcome-icon {
                font-size: 38px;
            }

            .recent-header h2 {
                font-size: 21px;
            }
        }

    </style>

</head>

<body>

    <main class="dashboard-container">

        <!-- =====================================
             WELCOME SECTION
        ====================================== -->

        <section class="welcome-box">

            <div class="welcome-content">

                <h1>
                    Welcome, <?php echo e($user->name); ?>!
                </h1>

                <p>
                    Welcome to your Abuyog Andrea Pizza
                    customer dashboard. Manage your orders
                    and enjoy your favorite pizza!
                </p>

            </div>

            <div class="welcome-icon">
                🍕
            </div>

        </section>


        <!-- =====================================
             QUICK ACTIONS
        ====================================== -->

        <section class="quick-actions">

            <!-- ORDER PIZZA -->

            <a
                href="<?php echo e(route('menu')); ?>"
                class="action-card"
            >

                <div class="action-icon">
                    🍕
                </div>

                <div class="action-content">

                    <h3>
                        Order Pizza
                    </h3>

                    <p>
                        Browse our delicious menu
                    </p>

                </div>

            </a>


            <!-- MY CART -->

            <a
                href="<?php echo e(route('cart')); ?>"
                class="action-card"
            >

                <div class="action-icon">
                    🛒
                </div>

                <div class="action-content">

                    <h3>
                        My Cart
                    </h3>

                    <p>
                        View items in your cart
                    </p>

                </div>

            </a>


            <!-- CONTACT -->

            <a
                href="<?php echo e(route('contact')); ?>"
                class="action-card"
            >

                <div class="action-icon">
                    📍
                </div>

                <div class="action-content">

                    <h3>
                        Contact Us
                    </h3>

                    <p>
                        Find our store and contact us
                    </p>

                </div>

            </a>

        </section>


        <!-- =====================================
             RECENT ORDERS HEADER
        ====================================== -->

        <section class="recent-header">

            <h2>
                Recent <span>Orders</span>
            </h2>

            <a
                href="<?php echo e(route('menu')); ?>"
                class="order-again"
            >
                + Order Again
            </a>

        </section>


        <!-- =====================================
             ORDERS
        ====================================== -->

        <?php if($orders->count() > 0): ?>

            <section class="orders-list">

                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="order-card">

                        <!-- ORDER -->

                        <div>

                            <div class="order-number">
                                <?php echo e($order->order_number); ?>

                            </div>

                            <div class="order-date">

                                Ordered:

                                <?php echo e($order->created_at->format('M d, Y h:i A')); ?>


                            </div>

                        </div>


                        <!-- TOTAL -->

                        <div>

                            <div class="order-label">
                                Total
                            </div>

                            <div class="order-total">

                                ₱<?php echo e(number_format($order->total_amount, 2)); ?>


                            </div>

                        </div>


                        <!-- STATUS -->

                        <div>

                            <div class="order-label">
                                Status
                            </div>

                            <span
                                class="status <?php echo e($order->status); ?>"
                            >

                                <?php echo e(str_replace('_', ' ', $order->status)); ?>


                            </span>

                        </div>


                        <!-- VIEW ORDER -->

                        <div>

                            <a
                               href="<?php echo e(route('orders.tracking', ['orderId' => $order->id])); ?>"
                                class="view-order"
                            >
                                View Order
                            </a>

                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </section>

        <?php else: ?>

            <!-- =================================
                 NO ORDERS
            ================================== -->

            <section class="empty-orders">

                <div class="empty-icon">
                    🍕
                </div>

                <h3>
                    No orders yet
                </h3>

                <p>
                    You haven't placed an order yet.
                    Start by browsing our pizza menu.
                </p>

                <a
                    href="<?php echo e(route('menu')); ?>"
                    class="menu-button"
                >
                    Browse Menu
                </a>

            </section>

        <?php endif; ?>

    </main>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>