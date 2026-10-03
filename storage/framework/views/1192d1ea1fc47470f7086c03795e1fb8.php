

<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">

    <div>

        <h1>📊 Reports</h1>

        <p>
            Overview of your pizza ordering system.
        </p>

    </div>

</div>


<div class="grid-4">

    <div class="stat-card">

        <div class="stat-label">
            TOTAL ORDERS
        </div>

        <div class="stat-number">
            <?php echo e($totalOrders); ?>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            PENDING ORDERS
        </div>

        <div class="stat-number">
            <?php echo e($pendingOrders); ?>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            DELIVERED ORDERS
        </div>

        <div class="stat-number">
            <?php echo e($deliveredOrders); ?>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            CANCELLED ORDERS
        </div>

        <div class="stat-number">
            <?php echo e($cancelledOrders); ?>

        </div>

    </div>

</div>


<br>


<div class="grid-3">

    <div class="card">

        <h3 style="color:#15803d">
            💰 Total Sales
        </h3>

        <div style="
            font-size:28px;
            font-weight:900;
            color:#15803d;
        ">

            ₱<?php echo e(number_format($totalSales, 2)); ?>


        </div>

    </div>


    <div class="card">

        <h3 style="color:#15803d">
            📱 GCash Sales
        </h3>

        <div style="
            font-size:28px;
            font-weight:900;
            color:#15803d;
        ">

            ₱<?php echo e(number_format($gcashSales, 2)); ?>


        </div>

    </div>


    <div class="card">

        <h3 style="color:#15803d">
            💵 Cash Sales
        </h3>

        <div style="
            font-size:28px;
            font-weight:900;
            color:#15803d;
        ">

            ₱<?php echo e(number_format($cashSales, 2)); ?>


        </div>

    </div>

</div>


<br>


<div class="card">

    <h2 style="color:#15803d;margin-top:0">
        📋 System Summary
    </h2>

    <div style="
        display:grid;
        gap:15px;
    ">

        <div style="
            display:flex;
            justify-content:space-between;
            border-bottom:1px solid #eee;
            padding-bottom:12px;
        ">

            <span>
                Registered Customers
            </span>

            <strong style="color:#15803d">
                <?php echo e($totalCustomers); ?>

            </strong>

        </div>


        <div style="
            display:flex;
            justify-content:space-between;
            border-bottom:1px solid #eee;
            padding-bottom:12px;
        ">

            <span>
                Pizza Products
            </span>

            <strong style="color:#15803d">
                <?php echo e($totalPizzas); ?>

            </strong>

        </div>


        <div style="
            display:flex;
            justify-content:space-between;
            border-bottom:1px solid #eee;
            padding-bottom:12px;
        ">

            <span>
                Delivered Orders
            </span>

            <strong style="color:#15803d">
                <?php echo e($deliveredOrders); ?>

            </strong>

        </div>


        <div style="
            display:flex;
            justify-content:space-between;
        ">

            <span>
                Cancelled Orders
            </span>

            <strong style="color:#dc2626">
                <?php echo e($cancelledOrders); ?>

            </strong>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/reports.blade.php ENDPATH**/ ?>