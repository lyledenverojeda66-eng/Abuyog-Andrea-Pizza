<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Abuyog Andrea Pizza
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7f6;
            color: #1f2937;
        }

        body {
            min-height: 100vh;
        }


        /* =========================
           ADMIN NAVBAR
        ========================= */

        .admin-navbar {
            background: #15803d;
            color: white;
            min-height: 64px;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 25px;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-weight: 800;
            white-space: nowrap;
        }

        .admin-brand-main {
            font-size: 18px;
            line-height: 1;
            letter-spacing: .4px;
        }

        .admin-brand-sub {
            font-size: 10px;
            opacity: .85;
            letter-spacing: 1px;
            margin-top: 3px;
        }


        /* =========================
           ADMIN NAVIGATION
        ========================= */

        .admin-nav {
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
            flex-wrap: wrap;
        }

        .admin-nav a {
            color: rgba(255,255,255,.95);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 11px;
            border-radius: 7px;
            transition:
                background .15s ease,
                color .15s ease;
        }

        .admin-nav a:hover {
            background: rgba(255,255,255,.13);
            color: white;
        }

        .admin-nav a.active {
            background: white;
            color: #15803d;
        }


        /* =========================
           ADMIN ACCOUNT
        ========================= */

        .admin-account {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .admin-name {
            font-size: 12px;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | CLICKABLE ADMIN PROFILE
        |--------------------------------------------------------------------------
        */

        .admin-profile-link {
            color: white;
            text-decoration: none;
            cursor: pointer;
            transition: .15s ease;
        }

        .admin-profile-link:hover {
            color: #dcfce7;
            text-decoration: underline;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            border: 1px solid rgba(255,255,255,.45);
            background: transparent;
            color: white;
            padding: 8px 11px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .logout-button:hover {
            background: rgba(255,255,255,.12);
        }


        /* =========================
           MAIN CONTAINER
        ========================= */

        .container {
            width: 100%;
            max-width: 1250px;
            margin: 0 auto;
            padding: 25px 22px 40px;
        }


        /* =========================
           PAGE HEADER
        ========================= */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 25px;
            color: #111827;
        }

        .page-header p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 13px;
        }


        /* =========================
           CARD
        ========================= */

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }


        /* =========================
           GRIDS
        ========================= */

        .grid-2 {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns:
                repeat(4, minmax(0, 1fr));
            gap: 18px;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 800;
            color: #374151;
        }

        .form-control {
            width: 100%;
            border: 1px solid #d1d5db;
            background: white;
            color: #111827;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            outline: none;
            transition:
                border-color .15s ease,
                box-shadow .15s ease;
        }

        .form-control:focus {
            border-color: #16a34a;
            box-shadow:
                0 0 0 3px rgba(22,163,74,.10);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        input[type="file"].form-control {
            padding: 8px;
        }


        /* =========================
           BUTTONS
        ========================= */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            border: 1px solid transparent;
            transition:
                background .15s ease,
                border-color .15s ease,
                color .15s ease;
        }

        .btn-green {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
        }

        .btn-green:hover {
            background: #15803d;
            border-color: #15803d;
        }

        .btn-outline {
            background: white;
            color: #374151;
            border-color: #d1d5db;
        }

        .btn-outline:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }

        .btn-warning:hover {
            background: #d97706;
            border-color: #d97706;
        }

        .btn-small {
            padding: 7px 10px;
            font-size: 11px;
        }


        /* =========================
           ALERTS
        ========================= */

        .alert {
            padding: 12px 14px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 13px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table th {
            background: #f9fafb;
            color: #374151;
            font-size: 11px;
            font-weight: 800;
            text-align: left;
            padding: 11px 12px;
            border-bottom:
                1px solid #e5e7eb;
            white-space: nowrap;
        }

        .table td {
            padding: 11px 12px;
            border-bottom:
                1px solid #f0f1f2;
            font-size: 12px;
            color: #374151;
            vertical-align: middle;
        }

        .table tr:hover td {
            background: #fafafa;
        }


        /* =========================
           BADGES
        ========================= */

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-gray {
            background: #f3f4f6;
            color: #4b5563;
        }


        /* =========================
           STAT CARDS
        ========================= */

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .stat-value {
            color: #111827;
            font-size: 25px;
            font-weight: 800;
        }


        /* =========================
           ACTIONS
        ========================= */

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }


        /* =========================
           IMAGES
        ========================= */

        .admin-image {
            display: block;
            max-width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1050px) {

            .admin-navbar {
                padding: 12px 18px;
                flex-wrap: wrap;
            }

            .admin-nav {
                order: 3;
                width: 100%;
                overflow-x: auto;
                padding-bottom: 2px;
            }

            .admin-account {
                margin-left: auto;
            }

        }


        @media (max-width: 750px) {

            .container {
                padding: 20px 15px 30px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }

            .admin-brand {
                width: 100%;
            }

            .admin-account {
                width: 100%;
                margin-left: 0;
                justify-content: space-between;
            }

            .admin-nav {
                gap: 3px;
            }

            .admin-nav a {
                font-size: 11px;
                padding: 8px 9px;
            }

            .card {
                padding: 15px;
            }

        }

    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>

</head>


<body>


    <nav class="admin-navbar">


        

        <a
            href="<?php echo e(route('admin.dashboard')); ?>"
            class="admin-brand"
        >

            <div>

                <div class="admin-brand-main">
                    ABUYOG ANDREA
                </div>

                <div class="admin-brand-sub">
                    PIZZA ADMIN
                </div>

            </div>

        </a>


        

        <div class="admin-nav">


            

            <a
                href="<?php echo e(route('admin.dashboard')); ?>"
                class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
            >
                🏠 Dashboard
            </a>


            

            <a
                href="<?php echo e(route('admin.pizzas')); ?>"
                class="<?php echo e(request()->routeIs('admin.pizzas') || request()->routeIs('admin.pizzas.*') ? 'active' : ''); ?>"
            >
                🍕 Pizza Menu
            </a>


            

            <a
                href="<?php echo e(route('admin.banners.index')); ?>"
                class="<?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>"
            >
                🖼️ Banners
            </a>


            

            <a
                href="<?php echo e(route('admin.orders')); ?>"
                class="<?php echo e(request()->routeIs('admin.orders') || request()->routeIs('admin.orders.*') ? 'active' : ''); ?>"
            >
                📦 Orders
            </a>


            

            <a
                href="<?php echo e(route('admin.customers')); ?>"
                class="<?php echo e(request()->routeIs('admin.customers') ? 'active' : ''); ?>"
            >
                👥 Customers
            </a>


            

            <a
                href="<?php echo e(route('admin.payments')); ?>"
                class="<?php echo e(request()->routeIs('admin.payments') ? 'active' : ''); ?>"
            >
                💳 Payments
            </a>


            

            <a
                href="<?php echo e(route('admin.deliveries')); ?>"
                class="<?php echo e(request()->routeIs('admin.deliveries') ? 'active' : ''); ?>"
            >
                🚚 Deliveries
            </a>


            

            <a
                href="<?php echo e(route('admin.reports')); ?>"
                class="<?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>"
            >
                📊 Reports
            </a>


        </div>


        

        <div class="admin-account">


            

            <a
                href="<?php echo e(route('admin.profile')); ?>"
                class="admin-name admin-profile-link"
            >
                <?php echo e(auth()->user()->name ?? 'Administrator'); ?>

            </a>


            

            <form
                action="<?php echo e(route('logout')); ?>"
                method="POST"
                class="logout-form"
            >

                <?php echo csrf_field(); ?>

                <button
                    type="submit"
                    class="logout-button"
                >
                    Logout
                </button>

            </form>

        </div>


    </nav>


    <main class="container">


        

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


        

        <?php echo $__env->yieldContent('content'); ?>


    </main>


    <?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->make('partials.chatbot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/layout.blade.php ENDPATH**/ ?>