

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<!-- =========================
     PAGE HEADER
========================= -->

<div class="page-header">

    <div>

        <h1>
            Admin Dashboard
        </h1>

        <p>
            Welcome back,
            <?php echo e(auth()->user()->name); ?>!
            Here's what's happening with your pizza shop.
        </p>

    </div>

    <div
        style="
            background:#dcfce7;
            color:#15803d;
            border:1px solid #bbf7d0;
            padding:9px 15px;
            border-radius:20px;
            font-size:13px;
            font-weight:800;
        "
    >
        Administrator
    </div>

</div>


<!-- =========================
     STATISTICS
========================= -->

<div class="grid-4">


    <!-- TOTAL ORDERS -->

    <div class="stat-card">

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            "
        >

            <div class="stat-label">
                TOTAL ORDERS
            </div>

            <div
                style="
                    width:42px;
                    height:42px;
                    background:#dcfce7;
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:20px;
                "
            >
                📦
            </div>

        </div>

        <div class="stat-number">
            <?php echo e($totalOrders); ?>

        </div>

        <div
            style="
                color:#9ca3af;
                font-size:12px;
                margin-top:4px;
            "
        >
            All customer orders
        </div>

    </div>


    <!-- PENDING ORDERS -->

    <div class="stat-card">

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            "
        >

            <div class="stat-label">
                PENDING ORDERS
            </div>

            <div
                style="
                    width:42px;
                    height:42px;
                    background:#fef3c7;
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:20px;
                "
            >
                ⏳
            </div>

        </div>

        <div class="stat-number">
            <?php echo e($pendingOrders); ?>

        </div>

        <div
            style="
                color:#9ca3af;
                font-size:12px;
                margin-top:4px;
            "
        >
            Orders needing attention
        </div>

    </div>


    <!-- CUSTOMERS -->

    <div class="stat-card">

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            "
        >

            <div class="stat-label">
                CUSTOMERS
            </div>

            <div
                style="
                    width:42px;
                    height:42px;
                    background:#dbeafe;
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:20px;
                "
            >
                👥
            </div>

        </div>

        <div class="stat-number">
            <?php echo e($totalCustomers); ?>

        </div>

        <div
            style="
                color:#9ca3af;
                font-size:12px;
                margin-top:4px;
            "
        >
            Registered customers
        </div>

    </div>


    <!-- TOTAL SALES -->

    <div class="stat-card">

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            "
        >

            <div class="stat-label">
                TOTAL SALES
            </div>

            <div
                style="
                    width:42px;
                    height:42px;
                    background:#dcfce7;
                    border-radius:10px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:20px;
                "
            >
                💰
            </div>

        </div>

        <div class="stat-number">
            ₱<?php echo e(number_format($totalSales, 2)); ?>

        </div>

        <div
            style="
                color:#9ca3af;
                font-size:12px;
                margin-top:4px;
            "
        >
            Completed / active sales
        </div>

    </div>

</div>


<br>


<!-- =========================
     MAIN CONTENT
========================= -->

<div
    style="
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:20px;
    "
    class="dashboard-main-grid"
>


    <!-- =========================
         RECENT ORDERS
    ========================= -->

    <div class="card">

        <div
            style="
                display:flex;
                align-items:center;
                justify-content:space-between;
                gap:15px;
                margin-bottom:18px;
            "
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                📦 Recent Orders
            </h2>


            <a
                href="<?php echo e(route('admin.orders')); ?>"
                style="
                    color:#15803d;
                    text-decoration:none;
                    font-size:12px;
                    font-weight:800;
                "
            >
                View All →
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            <!-- ORDER -->

                            <td>

                                <strong
                                    style="
                                        color:#15803d;
                                    "
                                >
                                    <?php echo e($order->order_number); ?>

                                </strong>

                            </td>


                            <!-- CUSTOMER -->

                            <td>

                                <strong>

                                    <?php echo e($order->user->name ?? 'Customer'); ?>


                                </strong>

                            </td>


                            <!-- AMOUNT -->

                            <td>

                                <strong
                                    style="
                                        color:#15803d;
                                    "
                                >

                                    ₱<?php echo e(number_format($order->total_amount, 2)); ?>


                                </strong>

                            </td>


                            <!-- PAYMENT -->

                            <td>

                                <?php if($order->payment_method === 'gcash'): ?>

                                    📱 GCash

                                <?php else: ?>

                                    💵 Cash

                                <?php endif; ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php

                                    $statusClass = match ($order->status) {

                                        'pending' =>
                                            'pending',

                                        'confirmed' =>
                                            'confirmed',

                                        'preparing' =>
                                            'preparing',

                                        'ready_for_delivery' =>
                                            'ready_for_delivery',

                                        'out_for_delivery' =>
                                            'out_for_delivery',

                                        'delivered' =>
                                            'delivered',

                                        'cancelled' =>
                                            'cancelled',

                                        default =>
                                            'pending',

                                    };

                                ?>


                                <span
                                    class="status <?php echo e($statusClass); ?>"
                                >

                                    <?php echo e(str_replace('_', ' ', $order->status)); ?>


                                </span>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <a
                                    href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                    class="btn btn-green"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="6"
                                style="
                                    text-align:center;
                                    padding:35px;
                                    color:#6b7280;
                                "
                            >

                                📦 No orders found.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- =========================
         QUICK ACTIONS
    ========================= -->

    <div class="card">

        <div
            style="
                margin-bottom:18px;
            "
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                ⚡ Quick Actions
            </h2>

            <p
                style="
                    color:#6b7280;
                    font-size:12px;
                    margin:6px 0 0;
                "
            >
                Quickly manage your system.
            </p>

        </div>


        <!-- PIZZA MENU -->

        <a
            href="<?php echo e(route('admin.pizzas')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                margin-bottom:12px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                🍕
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Pizza Menu
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                Manage pizzas, categories,
                prices and availability.
            </div>

        </a>


        <!-- ORDERS -->

        <a
            href="<?php echo e(route('admin.orders')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                margin-bottom:12px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                📦
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Orders
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                View and manage
                customer orders.
            </div>

        </a>


        <!-- CUSTOMERS -->

        <a
            href="<?php echo e(route('admin.customers')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                margin-bottom:12px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                👥
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Customers
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                View registered
                customers and orders.
            </div>

        </a>


        <!-- PAYMENTS -->

        <a
            href="<?php echo e(route('admin.payments')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                margin-bottom:12px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                💳
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Payments
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                Monitor GCash and
                cash payments.
            </div>

        </a>


        <!-- DELIVERIES -->

        <a
            href="<?php echo e(route('admin.deliveries')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                margin-bottom:12px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                🚚
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Deliveries
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                Monitor riders and
                delivery status.
            </div>

        </a>


        <!-- REPORTS -->

        <a
            href="<?php echo e(route('admin.reports')); ?>"
            style="
                display:block;
                text-decoration:none;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                padding:16px;
                color:#222;
                transition:.2s;
            "
        >

            <div
                style="
                    font-size:25px;
                    margin-bottom:7px;
                "
            >
                📊
            </div>

            <strong
                style="
                    color:#15803d;
                    font-size:13px;
                "
            >
                Reports
            </strong>

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    line-height:1.5;
                    margin-top:4px;
                "
            >
                View sales and
                system reports.
            </div>

        </a>

    </div>

</div>


<br>


<!-- =========================
     SYSTEM SUMMARY
========================= -->

<div class="card">

    <div
        style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:18px;
        "
    >

        <h2
            style="
                margin:0;
                font-size:18px;
            "
        >
            📊 System Summary
        </h2>

        <a
            href="<?php echo e(route('admin.reports')); ?>"
            style="
                color:#15803d;
                text-decoration:none;
                font-size:12px;
                font-weight:800;
            "
        >
            View Reports →
        </a>

    </div>


    <div
        style="
            display:grid;
            grid-template-columns:
                repeat(4, 1fr);
            gap:15px;
        "
    >


        <!-- PIZZAS -->

        <a
            href="<?php echo e(route('admin.pizzas')); ?>"
            style="
                text-decoration:none;
                color:#222;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:10px;
                padding:16px;
            "
        >

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    font-weight:700;
                "
            >
                PIZZA PRODUCTS
            </div>

            <div
                style="
                    color:#15803d;
                    font-size:25px;
                    font-weight:900;
                    margin-top:6px;
                "
            >
                <?php echo e($totalPizzas); ?>

            </div>

        </a>


        <!-- CUSTOMERS -->

        <a
            href="<?php echo e(route('admin.customers')); ?>"
            style="
                text-decoration:none;
                color:#222;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:10px;
                padding:16px;
            "
        >

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    font-weight:700;
                "
            >
                CUSTOMERS
            </div>

            <div
                style="
                    color:#15803d;
                    font-size:25px;
                    font-weight:900;
                    margin-top:6px;
                "
            >
                <?php echo e($totalCustomers); ?>

            </div>

        </a>


        <!-- PENDING -->

        <a
            href="<?php echo e(route('admin.orders')); ?>"
            style="
                text-decoration:none;
                color:#222;
                background:#fff7ed;
                border:1px solid #fed7aa;
                border-radius:10px;
                padding:16px;
            "
        >

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    font-weight:700;
                "
            >
                PENDING ORDERS
            </div>

            <div
                style="
                    color:#d97706;
                    font-size:25px;
                    font-weight:900;
                    margin-top:6px;
                "
            >
                <?php echo e($pendingOrders); ?>

            </div>

        </a>


        <!-- SALES -->

        <a
            href="<?php echo e(route('admin.reports')); ?>"
            style="
                text-decoration:none;
                color:#222;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:10px;
                padding:16px;
            "
        >

            <div
                style="
                    color:#6b7280;
                    font-size:11px;
                    font-weight:700;
                "
            >
                TOTAL SALES
            </div>

            <div
                style="
                    color:#15803d;
                    font-size:20px;
                    font-weight:900;
                    margin-top:8px;
                "
            >
                ₱<?php echo e(number_format($totalSales, 2)); ?>

            </div>

        </a>

    </div>

</div>


<style>

@media(max-width:1000px) {

    .dashboard-main-grid {
        grid-template-columns:1fr !important;
    }

}

@media(max-width:700px) {

    .dashboard-main-grid > div {
        min-width:0;
    }

}

@media(max-width:600px) {

    .dashboard-main-grid {
        grid-template-columns:1fr !important;
    }

    .dashboard-main-grid + br + .card > div:last-child {
        grid-template-columns:
            repeat(2, 1fr) !important;
    }

}

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>