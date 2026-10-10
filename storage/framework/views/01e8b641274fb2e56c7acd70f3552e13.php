

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .dashboard-page {
        width: 100%;
    }

    /* =========================
       PAGE HEADER
    ========================= */

    .dashboard-page .page-header {
        margin-bottom: 22px;
    }

    .dashboard-page .page-header h1 {
        margin: 0 0 6px;
        line-height: 1.4;
    }

    .dashboard-page .page-header p {
        margin: 0;
        color: #6b7280;
        line-height: 1.5;
    }

    /* =========================
       STAT CARDS
    ========================= */

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .dashboard-stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 5px 16px rgba(0, 0, 0, 0.05);
    }

    .dashboard-stat-label {
        margin-bottom: 8px;
        color: #6b7280;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        line-height: 1.4;
    }

    .dashboard-stat-value {
        color: #111827;
        font-size: 28px;
        font-weight: 900;
        line-height: 1.3;
    }

    .dashboard-stat-subtitle {
        margin-top: 5px;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.5;
    }

    .dashboard-stat-sales .dashboard-stat-value {
        color: #15803d;
    }

    .dashboard-stat-pending .dashboard-stat-value {
        color: #d97706;
    }

    /* =========================
       QUICK ACTIONS
    ========================= */

    .dashboard-page .card {
        width: 100%;
    }

    .quick-actions-header {
        margin-bottom: 18px;
    }

    .quick-actions-header h2 {
        margin: 0 0 5px;
        font-size: 18px;
        line-height: 1.4;
    }

    .quick-actions-header p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .quick-action-card {
        display: block;
        min-height: 150px;

        padding: 18px;

        border: 1px solid #e5e7eb;
        border-radius: 12px;

        background: #ffffff;
        color: #111827;

        text-decoration: none;

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .quick-action-card:hover {
        color: #111827;
        text-decoration: none;

        transform: translateY(-3px);

        border-color: #bbf7d0;

        box-shadow:
            0 10px 25px rgba(0, 0, 0, .08);
    }

    .quick-action-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .quick-action-icon {
        width: 45px;
        height: 45px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: #f0fdf4;

        font-size: 22px;
    }

    .quick-action-card strong {
        display: block;

        margin-bottom: 7px;

        color: #111827;

        font-size: 15px;
        font-weight: 800;
        line-height: 1.4;
    }

    .quick-action-description {
        color: #6b7280;

        font-size: 12px;
        line-height: 1.55;
    }

    /* =========================
       FEEDBACK ACTION
    ========================= */

    .feedback-action {
        border-color: #fde68a;
        background: #fffdf5;
    }

    .feedback-action:hover {
        border-color: #facc15;
    }

    .feedback-action .quick-action-icon {
        background: #fef3c7;
    }

    .feedback-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 5px 9px;

        border-radius: 999px;

        background: #fef3c7;
        color: #92400e;

        font-size: 10px;
        font-weight: 900;

        line-height: 1.3;

        white-space: nowrap;
    }

    /* =========================
       SYSTEM SUMMARY
    ========================= */

    .summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 18px;
    }

    .summary-header h2 {
        margin: 0;

        font-size: 18px;
        line-height: 1.4;
    }

    .summary-header a {
        color: #15803d;
        text-decoration: none;

        font-size: 12px;
        font-weight: 800;

        line-height: 1.4;
        white-space: nowrap;
    }

    .summary-header a:hover {
        text-decoration: underline;
    }

    .summary-grid {
        display: grid;

        grid-template-columns:
            repeat(5, 1fr);

        gap: 15px;
    }

    .summary-card {
        display: block;

        min-height: 125px;

        padding: 18px;

        border: 1px solid #e5e7eb;
        border-radius: 12px;

        background: #ffffff;

        text-decoration: none;

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .summary-card:hover {
        text-decoration: none;

        transform: translateY(-3px);

        border-color: #bbf7d0;

        box-shadow:
            0 9px 22px rgba(0, 0, 0, .07);
    }

    .summary-label {
        margin-bottom: 8px;

        color: #6b7280;

        font-size: 10px;
        font-weight: 900;

        letter-spacing: .5px;

        line-height: 1.4;
    }

    .summary-number {
        color: #111827;

        font-size: 27px;
        font-weight: 900;

        line-height: 1.3;
    }

    .summary-small {
        margin-top: 6px;

        color: #6b7280;

        font-size: 11px;

        line-height: 1.4;
    }

    .pending-summary {
        border-color: #fde68a;
    }

    .pending-summary .summary-number {
        color: #d97706;
    }

    .feedback-summary {
        border-color: #fde68a;
        background: #fffdf5;
    }

    .feedback-summary:hover {
        border-color: #facc15;
    }

    .feedback-summary .summary-number {
        color: #d97706;
    }

    /* =========================
       RECENT ORDERS
    ========================= */

    .recent-orders-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 18px;
    }

    .recent-orders-header h2 {
        margin: 0 0 5px;

        font-size: 18px;
        line-height: 1.4;
    }

    .recent-orders-header p {
        margin: 0;

        color: #6b7280;

        font-size: 13px;
        line-height: 1.5;
    }

    .recent-orders-header a {
        color: #15803d;

        font-size: 12px;
        font-weight: 800;

        text-decoration: none;

        white-space: nowrap;
    }

    .recent-orders-header a:hover {
        text-decoration: underline;
    }

    .dashboard-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-page table {
        width: 100%;

        border-collapse: separate;
        border-spacing: 0;

        min-width: 760px;
    }

    .dashboard-page table th {
        padding: 13px 15px;

        color: #374151;

        font-size: 12px;
        font-weight: 800;

        line-height: 1.4;

        text-align: left;

        white-space: nowrap;

        background: #f9fafb;

        border-bottom: 1px solid #e5e7eb;
    }

    .dashboard-page table td {
        padding: 13px 15px;

        color: #374151;

        font-size: 13px;

        line-height: 1.5;

        vertical-align: middle;

        border-bottom: 1px solid #f1f5f9;
    }

    .dashboard-page table tbody tr:last-child td {
        border-bottom: 0;
    }

    .dashboard-page table tbody tr:hover {
        background: #fafafa;
    }

    .dashboard-order-number {
        color: #15803d;
        font-weight: 800;
        white-space: nowrap;
    }

    .dashboard-customer-name {
        color: #111827;
        font-weight: 700;
        white-space: nowrap;
    }

    .dashboard-amount {
        color: #15803d;
        font-weight: 800;
        white-space: nowrap;
    }

    .dashboard-status {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 5px 10px;

        border-radius: 999px;

        font-size: 10px;
        font-weight: 900;

        line-height: 1.4;

        text-transform: capitalize;

        white-space: nowrap;
    }

    .dashboard-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .dashboard-status.confirmed,
    .dashboard-status.preparing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .dashboard-status.ready_for_delivery {
        background: #ede9fe;
        color: #6d28d9;
    }

    .dashboard-status.out_for_delivery {
        background: #cffafe;
        color: #155e75;
    }

    .dashboard-status.delivered {
        background: #dcfce7;
        color: #166534;
    }

    .dashboard-status.cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .dashboard-view-button {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 7px 11px;

        border-radius: 7px;

        background: #f0fdf4;
        color: #15803d;

        font-size: 11px;
        font-weight: 800;

        text-decoration: none;

        white-space: nowrap;
    }

    .dashboard-view-button:hover {
        background: #dcfce7;
        color: #166534;
        text-decoration: none;
    }

    .dashboard-empty {
        padding: 35px 20px !important;

        color: #6b7280 !important;

        text-align: center !important;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 1100px) {

        .dashboard-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 700px) {

        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .summary-header,
        .recent-orders-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-stat-card {
            padding: 17px;
        }

        .quick-action-card {
            min-height: auto;
        }
    }
</style>


<div class="dashboard-page">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="page-header">

        <div>

            <h1>
                🏠 Admin Dashboard
            </h1>

            <p>
                Welcome back, <?php echo e(auth()->user()->name ?? 'Administrator'); ?>.
                Manage your pizza ordering system from here.
            </p>

        </div>

    </div>


    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <div class="dashboard-stats">

        <!-- TOTAL ORDERS -->

        <div class="dashboard-stat-card">

            <div class="dashboard-stat-label">
                Total Orders
            </div>

            <div class="dashboard-stat-value">
                <?php echo e($totalOrders); ?>

            </div>

            <div class="dashboard-stat-subtitle">
                All customer orders
            </div>

        </div>


        <!-- PENDING ORDERS -->

        <div class="dashboard-stat-card dashboard-stat-pending">

            <div class="dashboard-stat-label">
                Pending Orders
            </div>

            <div class="dashboard-stat-value">
                <?php echo e($pendingOrders); ?>

            </div>

            <div class="dashboard-stat-subtitle">
                Orders waiting for action
            </div>

        </div>


        <!-- CUSTOMERS -->

        <div class="dashboard-stat-card">

            <div class="dashboard-stat-label">
                Customers
            </div>

            <div class="dashboard-stat-value">
                <?php echo e($totalCustomers); ?>

            </div>

            <div class="dashboard-stat-subtitle">
                Registered customer accounts
            </div>

        </div>


        <!-- SALES -->

        <div class="dashboard-stat-card dashboard-stat-sales">

            <div class="dashboard-stat-label">
                Total Sales
            </div>

            <div class="dashboard-stat-value">
                ₱<?php echo e(number_format($totalSales, 2)); ?>

            </div>

            <div class="dashboard-stat-subtitle">
                From confirmed and completed orders
            </div>

        </div>

    </div>


    <!-- =====================================================
         QUICK ACTIONS
    ====================================================== -->

    <div class="card">

        <div class="quick-actions-header">

            <h2>
                ⚡ Quick Actions
            </h2>

            <p>
                Quickly manage your system.
            </p>

        </div>


        <div class="quick-actions-grid">


            <!-- PIZZA MENU -->

            <a
                href="<?php echo e(route('admin.pizzas')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        🍕
                    </div>

                </div>

                <strong>
                    Pizza Menu
                </strong>

                <div class="quick-action-description">
                    Manage pizzas, categories,
                    prices and availability.
                </div>

            </a>


            <!-- ORDERS -->

            <a
                href="<?php echo e(route('admin.orders')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        📦
                    </div>

                </div>

                <strong>
                    Orders
                </strong>

                <div class="quick-action-description">
                    View and manage
                    customer orders.
                </div>

            </a>


            <!-- CUSTOMERS -->

            <a
                href="<?php echo e(route('admin.customers')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        👥
                    </div>

                </div>

                <strong>
                    Customers
                </strong>

                <div class="quick-action-description">
                    View registered
                    customers and orders.
                </div>

            </a>


            <!-- PAYMENTS -->

            <a
                href="<?php echo e(route('admin.payments')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        💳
                    </div>

                </div>

                <strong>
                    Payments
                </strong>

                <div class="quick-action-description">
                    Monitor GCash and
                    cash payments.
                </div>

            </a>


            <!-- DELIVERIES -->

            <a
                href="<?php echo e(route('admin.deliveries')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        🚚
                    </div>

                </div>

                <strong>
                    Deliveries
                </strong>

                <div class="quick-action-description">
                    Monitor riders and
                    delivery status.
                </div>

            </a>


            <!-- CUSTOMER FEEDBACK -->

            <a
                href="<?php echo e(route('admin.feedback')); ?>"
                class="quick-action-card feedback-action"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        💬
                    </div>


                    <?php if($pendingFeedback > 0): ?>

                        <span class="feedback-badge">
                            <?php echo e($pendingFeedback); ?> Pending
                        </span>

                    <?php endif; ?>

                </div>


                <strong>
                    Customer Feedback
                </strong>


                <div class="quick-action-description">
                    Review, approve and reply
                    to customer feedback.
                </div>

            </a>


            <!-- REPORTS -->

            <a
                href="<?php echo e(route('admin.reports')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        📊
                    </div>

                </div>

                <strong>
                    Reports
                </strong>

                <div class="quick-action-description">
                    View sales and
                    system reports.
                </div>

            </a>


            <!-- BANNERS -->

            <a
                href="<?php echo e(route('admin.banners.index')); ?>"
                class="quick-action-card"
            >

                <div class="quick-action-top">

                    <div class="quick-action-icon">
                        🖼️
                    </div>

                </div>

                <strong>
                    Banners
                </strong>

                <div class="quick-action-description">
                    Manage homepage banners
                    and promotions.
                </div>

            </a>

        </div>

    </div>


    <br>


    <!-- =====================================================
         SYSTEM SUMMARY
    ====================================================== -->

    <div class="card">

        <div class="summary-header">

            <h2>
                📊 System Summary
            </h2>

            <a href="<?php echo e(route('admin.reports')); ?>">
                View Reports →
            </a>

        </div>


        <div class="summary-grid">


            <!-- PIZZAS -->

            <a
                href="<?php echo e(route('admin.pizzas')); ?>"
                class="summary-card"
            >

                <div class="summary-label">
                    PIZZA PRODUCTS
                </div>

                <div class="summary-number">
                    <?php echo e($totalPizzas); ?>

                </div>

            </a>


            <!-- CUSTOMERS -->

            <a
                href="<?php echo e(route('admin.customers')); ?>"
                class="summary-card"
            >

                <div class="summary-label">
                    CUSTOMERS
                </div>

                <div class="summary-number">
                    <?php echo e($totalCustomers); ?>

                </div>

            </a>


            <!-- PENDING ORDERS -->

            <a
                href="<?php echo e(route('admin.orders')); ?>"
                class="summary-card pending-summary"
            >

                <div class="summary-label">
                    PENDING ORDERS
                </div>

                <div class="summary-number">
                    <?php echo e($pendingOrders); ?>

                </div>

            </a>


            <!-- PENDING FEEDBACK -->

            <a
                href="<?php echo e(route('admin.feedback')); ?>"
                class="summary-card feedback-summary"
            >

                <div class="summary-label">
                    PENDING FEEDBACK
                </div>

                <div class="summary-number">
                    <?php echo e($pendingFeedback); ?>

                </div>

                <div class="summary-small">
                    Click to review
                </div>

            </a>


            <!-- SALES -->

            <a
                href="<?php echo e(route('admin.reports')); ?>"
                class="summary-card"
            >

                <div class="summary-label">
                    TOTAL SALES
                </div>

                <div class="summary-number">
                    ₱<?php echo e(number_format($totalSales, 2)); ?>

                </div>

                <div class="summary-small">
                    View sales reports
                </div>

            </a>

        </div>

    </div>


    <br>


    <!-- =====================================================
         RECENT ORDERS
    ====================================================== -->

    <div class="card">

        <div class="recent-orders-header">

            <div>

                <h2>
                    📦 Recent Orders
                </h2>

                <p>
                    Latest customer orders in the system.
                </p>

            </div>

            <a href="<?php echo e(route('admin.orders')); ?>">
                View All Orders →
            </a>

        </div>


        <div class="dashboard-table-wrapper">

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
                            Date
                        </th>

                        <th>
                            Amount
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

                                <span class="dashboard-order-number">
                                    <?php echo e($order->order_number); ?>

                                </span>

                            </td>


                            <!-- CUSTOMER -->

                            <td>

                                <span class="dashboard-customer-name">
                                    <?php echo e($order->user->name ?? 'Customer'); ?>

                                </span>

                            </td>


                            <!-- DATE -->

                            <td>

                                <?php echo e($order->created_at->format('M d, Y h:i A')); ?>


                            </td>


                            <!-- AMOUNT -->

                            <td>

                                <span class="dashboard-amount">
                                    ₱<?php echo e(number_format($order->total_amount, 2)); ?>

                                </span>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <span
                                    class="dashboard-status <?php echo e($order->status); ?>"
                                >
                                    <?php echo e(str_replace('_', ' ', $order->status)); ?>

                                </span>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <a
                                    href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                    class="dashboard-view-button"
                                >
                                    View
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="6"
                                class="dashboard-empty"
                            >
                                No orders found.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>