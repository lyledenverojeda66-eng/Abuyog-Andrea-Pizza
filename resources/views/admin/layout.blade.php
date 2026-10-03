<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Admin')
        - Abuyog Andrea Pizza
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #fff8ee;

            color: #222;
        }

        /* NAVBAR */

        .navbar {
            background: #15803d;

            color: white;

            padding: 0 30px;

            min-height: 72px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            box-shadow:
                0 3px 10px
                rgba(0, 0, 0, .12);

            position: sticky;

            top: 0;

            z-index: 1000;
        }

        .brand {
            color: white;

            text-decoration: none;

            font-size: 18px;

            font-weight: 900;

            line-height: 1.1;

            white-space: nowrap;
        }

        .brand span {
            display: block;

            font-size: 10px;

            letter-spacing: 3px;

            margin-top: 3px;
        }

        .nav-links {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 3px;

            flex-wrap: wrap;
        }

        .nav-links a {
            color: white;

            text-decoration: none;

            padding: 10px 11px;

            border-radius: 8px;

            font-size: 12px;

            font-weight: 600;

            transition: .2s;
        }

        .nav-links a:hover {
            background: #16a34a;
        }

        .nav-links a.active {
            background: #16a34a;

            font-weight: 800;
        }

        .admin-area {
            display: flex;

            align-items: center;

            gap: 10px;

            white-space: nowrap;
        }

        .admin-name {
            font-size: 12px;

            font-weight: 700;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            border: 1px solid
                rgba(255,255,255,.5);

            background: transparent;

            color: white;

            padding: 8px 11px;

            border-radius: 8px;

            cursor: pointer;

            font-size: 11px;

            font-weight: 700;
        }

        .logout-btn:hover {
            background: white;

            color: #15803d;
        }

        /* CONTAINER */

        .container {
            max-width: 1400px;

            width: 100%;

            margin: auto;

            padding: 30px 25px 50px;
        }

        .page-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;

            color: #15803d;

            font-size: 28px;
        }

        .page-header p {
            margin: 6px 0 0;

            color: #6b7280;

            font-size: 13px;
        }

        /* CARD */

        .card {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 15px;

            padding: 20px;

            box-shadow:
                0 5px 18px
                rgba(0,0,0,.05);
        }

        /* TABLE */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 700px;
        }

        th {
            background: #f0fdf4;

            color: #4b5563;

            text-align: left;

            padding: 12px;

            font-size: 11px;

            border-bottom:
                1px solid #bbf7d0;
        }

        td {
            padding: 13px 12px;

            font-size: 12px;

            border-bottom:
                1px solid #f1f5f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* STATUS */

        .status {
            display: inline-block;

            padding: 6px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;
        }

        .pending {
            background: #fef3c7;

            color: #92400e;
        }

        .confirmed {
            background: #dbeafe;

            color: #1e40af;
        }

        .preparing {
            background: #ede9fe;

            color: #6d28d9;
        }

        .ready_for_delivery {
            background: #cffafe;

            color: #155e75;
        }

        .out_for_delivery {
            background: #e0e7ff;

            color: #3730a3;
        }

        .delivered {
            background: #dcfce7;

            color: #166534;
        }

        .cancelled {
            background: #fee2e2;

            color: #991b1b;
        }

        /* BUTTON */

        .btn {
            display: inline-block;

            padding: 9px 13px;

            border-radius: 8px;

            text-decoration: none;

            border: none;

            cursor: pointer;

            font-size: 12px;

            font-weight: 800;
        }

        .btn-green {
            background: #16a34a;

            color: white;
        }

        .btn-green:hover {
            background: #15803d;
        }

        .btn-outline {
            background: white;

            color: #15803d;

            border: 1px solid #16a34a;
        }

        .btn-danger {
            background: #dc2626;

            color: white;
        }

        /* ALERT */

        .alert {
            padding: 13px 16px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 13px;
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

        /* GRID */

        .grid-2 {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }

        .grid-3 {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .grid-4 {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;
        }

        /* STAT */

        .stat-card {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 20px;

            box-shadow:
                0 5px 18px
                rgba(0,0,0,.05);
        }

        .stat-label {
            color: #6b7280;

            font-size: 11px;

            font-weight: 800;
        }

        .stat-number {
            color: #15803d;

            font-size: 28px;

            font-weight: 900;

            margin-top: 8px;
        }

        /* FORM */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 12px;

            font-weight: 800;
        }

        .form-control {
            width: 100%;

            padding: 11px 12px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            font-size: 13px;

            background: white;
        }

        /* RESPONSIVE */

        @media(max-width:1100px) {

            .navbar {
                flex-wrap: wrap;

                padding: 15px 20px;
            }

            .nav-links {
                order: 3;

                width: 100%;
            }

            .grid-4 {
                grid-template-columns:
                    repeat(2,1fr);
            }

        }

        @media(max-width:700px) {

            .container {
                padding: 22px 15px;
            }

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
            }

            .grid-4 {
                grid-template-columns:
                    repeat(2,1fr);
            }

            .admin-name {
                display: none;
            }

            .nav-links {
                overflow-x: auto;

                flex-wrap: nowrap;

                justify-content: flex-start;
            }

            .nav-links a {
                white-space: nowrap;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<nav class="navbar">

    <a
        href="{{ route('admin.dashboard') }}"
        class="brand"
    >
        ABUYOG ANDREA
        <span>PIZZA</span>
    </a>


    <div class="nav-links">

        <a
            href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            🏠 Dashboard
        </a>

        <a
            href="{{ route('admin.pizzas') }}"
            class="{{ request()->routeIs('admin.pizzas') ? 'active' : '' }}"
        >
            🍕 Pizza Menu
        </a>

        <a
            href="{{ route('admin.orders') }}"
            class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
        >
            📦 Orders
        </a>

        <a
            href="{{ route('admin.customers') }}"
            class="{{ request()->routeIs('admin.customers') ? 'active' : '' }}"
        >
            👥 Customers
        </a>

        <a
            href="{{ route('admin.payments') }}"
            class="{{ request()->routeIs('admin.payments') ? 'active' : '' }}"
        >
            💳 Payments
        </a>

        <a
            href="{{ route('admin.deliveries') }}"
            class="{{ request()->routeIs('admin.deliveries') ? 'active' : '' }}"
        >
            🚚 Deliveries
        </a>

        <a
            href="{{ route('admin.reports') }}"
            class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"
        >
            📊 Reports
        </a>

    </div>


    <div class="admin-area">

        <span class="admin-name">
            👤 {{ auth()->user()->name }}
        </span>

        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >

            @csrf

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

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif


    @yield('content')

</main>

@stack('scripts')

</body>

</html>