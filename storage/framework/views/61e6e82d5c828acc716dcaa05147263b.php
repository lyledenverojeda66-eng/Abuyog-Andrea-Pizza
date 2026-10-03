<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Track Your Order - Abuyog Andrea Pizza</title>


    <style>

        /* =========================
           RESET
        ========================= */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #111;
            min-height: 100vh;
        }


        /* =========================
           ALERT
        ========================= */

        .alert {
            width: 90%;
            max-width: 1000px;
            margin: 15px auto;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
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


        /* =========================
           PAGE HEADER
        ========================= */

        .tracking-header {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto 22px;
            text-align: center;
        }


        .tracking-header h1 {
            color: #16a34a;
            font-size: 30px;
            font-weight: 900;
            margin-bottom: 7px;
        }


        .tracking-header p {
            color: #666;
            font-size: 14px;
        }


        /* =========================
           MAIN CONTAINER
        ========================= */

        .tracking-container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto 45px;
        }


        /* =========================
           ORDER INFORMATION
        ========================= */

        .order-info {
            background: white;
            border-radius: 12px;
            padding: 18px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
            margin-bottom: 20px;
        }


        .info-box {
            background: #fffaf3;
            border-radius: 8px;
            padding: 14px;
            border: 1px solid #eeeeee;
        }


        .info-label {
            color: #666;
            font-size: 11px;
            margin-bottom: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }


        .info-value {
            color: #111;
            font-size: 15px;
            font-weight: 800;
            word-break: break-word;
        }


        /* =========================
           CANCELLED
        ========================= */

        .cancelled-message {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }


        /* =========================
           STATUS SECTION
        ========================= */

        .status-section {
            background: white;
            border-radius: 12px;
            padding: 22px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
            margin-bottom: 20px;
        }


        .status-section h2 {
            color: #16a34a;
            font-size: 22px;
            margin-bottom: 22px;
            padding-bottom: 10px;
            border-bottom: 2px solid #16a34a;
        }


        /* =========================
           TIMELINE
        ========================= */

        .timeline {
            display: flex;
            flex-direction: column;
        }


        .timeline-item {
            position: relative;
            display: flex;
            gap: 14px;
            min-height: 80px;
        }


        .timeline-item:last-child {
            min-height: auto;
        }


        .timeline-icon-area {
            width: 44px;
            min-width: 44px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e5e7eb;
            color: #6b7280;
            font-size: 17px;
            font-weight: bold;
            z-index: 2;
            border: 2px solid #e5e7eb;
        }


        .timeline-line {
            width: 3px;
            flex: 1;
            background: #e5e7eb;
            margin-top: 2px;
            margin-bottom: 2px;
        }


        /* =========================
           COMPLETED
        ========================= */

        .timeline-item.completed .timeline-icon {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
        }


        .timeline-item.completed .timeline-line {
            background: #16a34a;
        }


        /* =========================
           CURRENT
        ========================= */

        .timeline-item.current .timeline-icon {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
            box-shadow: 0 0 0 4px #dcfce7;
        }


        .timeline-item.current .timeline-content h3 {
            color: #16a34a;
        }


        /* =========================
           TIMELINE CONTENT
        ========================= */

        .timeline-content {
            padding-top: 2px;
            padding-bottom: 20px;
            flex: 1;
        }


        .timeline-content h3 {
            color: #222;
            font-size: 16px;
            margin-bottom: 5px;
        }


        .timeline-content p {
            color: #666;
            font-size: 13px;
            line-height: 1.45;
            max-width: 650px;
        }


        .current-status {
            display: inline-block;
            margin-top: 8px;
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
        }


        /* =========================
           INFORMATION CARD
        ========================= */

        .information-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
            margin-bottom: 20px;
        }


        .information-card h2 {
            color: #16a34a;
            font-size: 21px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #16a34a;
        }


        .information-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }


        .information-item {
            background: #fffaf3;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #eeeeee;
        }


        .information-item strong {
            display: block;
            color: #555;
            font-size: 11px;
            margin-bottom: 5px;
        }


        .information-item span {
            color: #111;
            font-weight: bold;
            font-size: 14px;
            word-break: break-word;
        }


        /* =========================
           ACTION BUTTONS
        ========================= */

        .tracking-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }


        .back-btn,
        .order-again-btn {
            display: inline-block;
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 22px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
            text-align: center;
        }


        .back-btn {
            background: #111;
            color: white;
        }


        .back-btn:hover {
            background: #333;
            transform: translateY(-2px);
        }


        .order-again-btn {
            background: #16a34a;
            color: white;
        }


        .order-again-btn:hover {
            background: #15803d;
            transform: translateY(-2px);
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #080808;
            color: white;
            text-align: center;
            padding: 22px;
            margin-top: 40px;
            font-size: 14px;
        }


        footer span {
            color: #16a34a;
            font-weight: bold;
        }


        /* =========================
           TABLET
        ========================= */

        @media (max-width: 750px) {

            .order-info {
                grid-template-columns: 1fr;
            }


            .information-grid {
                grid-template-columns: 1fr;
            }

        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {

            .tracking-header {
                margin-top: 25px;
            }


            .tracking-header h1 {
                font-size: 26px;
            }


            .tracking-header p {
                font-size: 13px;
            }


            .tracking-container {
                width: 92%;
            }


            .order-info,
            .status-section,
            .information-card {
                padding: 17px;
            }


            .status-section h2,
            .information-card h2 {
                font-size: 19px;
            }


            .timeline-item {
                gap: 10px;
            }


            .timeline-icon-area {
                width: 40px;
                min-width: 40px;
            }


            .timeline-icon {
                width: 37px;
                height: 37px;
                font-size: 15px;
            }


            .timeline-content h3 {
                font-size: 15px;
            }


            .timeline-content p {
                font-size: 12px;
            }


            .tracking-actions {
                flex-direction: column;
            }


            .back-btn,
            .order-again-btn {
                width: 100%;
            }

        }

    </style>

</head>


<body>


    

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <?php if(session('success')): ?>

        <div class="alert alert-success">

            ✅ <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>


    <?php if(session('error')): ?>

        <div class="alert alert-error">

            ❌ <?php echo e(session('error')); ?>


        </div>

    <?php endif; ?>


    

    <section class="tracking-header">

        <h1>
            📦 Track Your Order
        </h1>

        <p>
            Follow the progress of your pizza order.
        </p>

    </section>


    <div class="tracking-container">


        

        <div class="order-info">


            <div class="info-box">

                <div class="info-label">
                    Order Number
                </div>

                <div class="info-value">

                    #<?php echo e($order->order_number); ?>


                </div>

            </div>


            <div class="info-box">

                <div class="info-label">
                    Order Date
                </div>

                <div class="info-value">

                    <?php echo e($order->created_at->format('M d, Y h:i A')); ?>


                </div>

            </div>


            <div class="info-box">

                <div class="info-label">
                    Total Amount
                </div>

                <div class="info-value">

                    ₱<?php echo e(number_format($order->total_amount, 2)); ?>


                </div>

            </div>


        </div>


        

        <?php if($order->status === 'cancelled'): ?>

            <div class="cancelled-message">

                ❌ This order has been cancelled.

            </div>

        <?php endif; ?>


        

        <?php

            $statuses = [
                'pending',
                'confirmed',
                'preparing',
                'ready_for_delivery',
                'out_for_delivery',
                'delivered'
            ];

            $currentIndex = array_search(
                $order->status,
                $statuses
            );

            if ($currentIndex === false) {
                $currentIndex = 0;
            }

        ?>


        <div class="status-section">


            <h2>
                Order Status
            </h2>


            <div class="timeline">


                

                <div
                    class="
                        timeline-item
                        <?php echo e($currentIndex >= 0 && $order->status !== 'cancelled'
                            ? 'completed'
                            : ''); ?>

                        <?php echo e($order->status === 'pending'
                            ? 'current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($currentIndex >= 0 && $order->status !== 'cancelled'
                                ? '✓'
                                : '1'); ?>


                        </div>

                        <div class="timeline-line"></div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Order Placed
                        </h3>

                        <p>
                            Your order has been received and is waiting for confirmation.
                        </p>


                        <?php if($order->status === 'pending'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                

                <div
                    class="
                        timeline-item
                        <?php echo e($currentIndex >= 1 && $order->status !== 'cancelled'
                            ? 'completed'
                            : ''); ?>

                        <?php echo e($order->status === 'confirmed'
                            ? 'current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($currentIndex >= 1 && $order->status !== 'cancelled'
                                ? '✓'
                                : '2'); ?>


                        </div>

                        <div class="timeline-line"></div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Order Confirmed
                        </h3>

                        <p>
                            Your order has been confirmed by the restaurant.
                        </p>


                        <?php if($order->status === 'confirmed'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                

                <div
                    class="
                        timeline-item
                        <?php echo e($currentIndex >= 2 && $order->status !== 'cancelled'
                            ? 'completed'
                            : ''); ?>

                        <?php echo e($order->status === 'preparing'
                            ? 'current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($currentIndex >= 2 && $order->status !== 'cancelled'
                                ? '✓'
                                : '3'); ?>


                        </div>

                        <div class="timeline-line"></div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Preparing Your Order
                        </h3>

                        <p>
                            Your pizza is currently being prepared.
                        </p>


                        <?php if($order->status === 'preparing'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                

                <div
                    class="
                        timeline-item
                        <?php echo e($currentIndex >= 3 && $order->status !== 'cancelled'
                            ? 'completed'
                            : ''); ?>

                        <?php echo e($order->status === 'ready_for_delivery'
                            ? 'current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($currentIndex >= 3 && $order->status !== 'cancelled'
                                ? '✓'
                                : '4'); ?>


                        </div>

                        <div class="timeline-line"></div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Ready for Delivery
                        </h3>

                        <p>
                            Your order is ready and waiting for delivery.
                        </p>


                        <?php if($order->status === 'ready_for_delivery'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                

                <div
                    class="
                        timeline-item
                        <?php echo e($currentIndex >= 4 && $order->status !== 'cancelled'
                            ? 'completed'
                            : ''); ?>

                        <?php echo e($order->status === 'out_for_delivery'
                            ? 'current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($currentIndex >= 4 && $order->status !== 'cancelled'
                                ? '🚚'
                                : '5'); ?>


                        </div>

                        <div class="timeline-line"></div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Out for Delivery
                        </h3>

                        <p>
                            Your order is on its way to your delivery address.
                        </p>


                        <?php if($order->status === 'out_for_delivery'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                

                <div
                    class="
                        timeline-item
                        <?php echo e($order->status === 'delivered'
                            ? 'completed current'
                            : ''); ?>

                    "
                >

                    <div class="timeline-icon-area">

                        <div class="timeline-icon">

                            <?php echo e($order->status === 'delivered'
                                ? '🎉'
                                : '6'); ?>


                        </div>

                    </div>


                    <div class="timeline-content">

                        <h3>
                            Delivered
                        </h3>

                        <p>
                            Your order has been successfully delivered.
                        </p>


                        <?php if($order->status === 'delivered'): ?>

                            <span class="current-status">
                                ● Current Status
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


            </div>

        </div>


        

        <div class="information-card">


            <h2>
                🚚 Delivery Information
            </h2>


            <?php if($order->delivery): ?>

                <div class="information-grid">


                    <?php if($order->delivery->rider_name): ?>

                        <div class="information-item">

                            <strong>
                                Rider Name
                            </strong>

                            <span>
                                <?php echo e($order->delivery->rider_name); ?>

                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if($order->delivery->rider_contact): ?>

                        <div class="information-item">

                            <strong>
                                Rider Contact
                            </strong>

                            <span>
                                <?php echo e($order->delivery->rider_contact); ?>

                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if($order->delivery->picked_up_at): ?>

                        <div class="information-item">

                            <strong>
                                Picked Up
                            </strong>

                            <span>
                                <?php echo e($order->delivery->picked_up_at->format('M d, Y h:i A')); ?>

                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if($order->delivery->delivered_at): ?>

                        <div class="information-item">

                            <strong>
                                Delivered
                            </strong>

                            <span>
                                <?php echo e($order->delivery->delivered_at->format('M d, Y h:i A')); ?>

                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if($order->delivery->delivery_notes): ?>

                        <div class="information-item">

                            <strong>
                                Delivery Notes
                            </strong>

                            <span>
                                <?php echo e($order->delivery->delivery_notes); ?>

                            </span>

                        </div>

                    <?php endif; ?>


                </div>

            <?php else: ?>

                <p style="color:#666; font-size:13px;">

                    Delivery information will appear here once your
                    order is assigned for delivery.

                </p>

            <?php endif; ?>


        </div>


        

        <div class="information-card">


            <h2>
                💳 Payment Information
            </h2>


            <?php if($order->payment): ?>

                <div class="information-grid">


                    <div class="information-item">

                        <strong>
                            Payment Method
                        </strong>

                        <span>

                            <?php echo e($order->payment->method === 'gcash'
                                ? 'GCash'
                                : 'Cash on Delivery'); ?>


                        </span>

                    </div>


                    <div class="information-item">

                        <strong>
                            Payment Status
                        </strong>

                        <span>

                            <?php echo e(ucfirst($order->payment->status)); ?>


                        </span>

                    </div>


                    <?php if($order->payment->reference_number): ?>

                        <div class="information-item">

                            <strong>
                                Reference Number
                            </strong>

                            <span>

                                <?php echo e($order->payment->reference_number); ?>


                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if($order->payment->paid_at): ?>

                        <div class="information-item">

                            <strong>
                                Paid At
                            </strong>

                            <span>

                                <?php echo e($order->payment->paid_at->format('M d, Y h:i A')); ?>


                            </span>

                        </div>

                    <?php endif; ?>


                </div>

            <?php else: ?>

                <p style="color:#666; font-size:13px;">

                    Payment information is not yet available.

                </p>

            <?php endif; ?>


        </div>


        

        <div class="tracking-actions">


            <a
                href="<?php echo e(route('customer.orders')); ?>"
                class="back-btn"
            >

                ← My Orders

            </a>


            <a
                href="<?php echo e(route('menu')); ?>"
                class="order-again-btn"
            >

                🍕 Order Again

            </a>


        </div>


    </div>


    

    <footer>

        © <?php echo e(date('Y')); ?>


        <span>
            Abuyog Andrea Pizza
        </span>

        All Rights Reserved.

    </footer>


</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/customer/tracking.blade.php ENDPATH**/ ?>