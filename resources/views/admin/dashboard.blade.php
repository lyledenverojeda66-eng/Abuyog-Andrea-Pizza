@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

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
            {{ auth()->user()->name }}!
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
            {{ $totalOrders }}
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
            {{ $pendingOrders }}
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
            {{ $totalCustomers }}
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
            ₱{{ number_format($totalSales, 2) }}
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
                href="{{ route('admin.orders') }}"
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

                    @forelse($recentOrders as $order)

                        <tr>

                            <!-- ORDER -->

                            <td>

                                <strong
                                    style="
                                        color:#15803d;
                                    "
                                >
                                    {{ $order->order_number }}
                                </strong>

                            </td>


                            <!-- CUSTOMER -->

                            <td>

                                <strong>

                                    {{ $order->user->name ?? 'Customer' }}

                                </strong>

                            </td>


                            <!-- AMOUNT -->

                            <td>

                                <strong
                                    style="
                                        color:#15803d;
                                    "
                                >

                                    ₱{{ number_format($order->total_amount, 2) }}

                                </strong>

                            </td>


                            <!-- PAYMENT -->

                            <td>

                                @if($order->payment_method === 'gcash')

                                    📱 GCash

                                @else

                                    💵 Cash

                                @endif

                            </td>


                            <!-- STATUS -->

                            <td>

                                @php

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

                                @endphp


                                <span
                                    class="status {{ $statusClass }}"
                                >

                                    {{ str_replace('_', ' ', $order->status) }}

                                </span>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <a
                                    href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn btn-green"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                    @empty

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

                    @endforelse

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
            href="{{ route('admin.pizzas') }}"
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
            href="{{ route('admin.orders') }}"
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
            href="{{ route('admin.customers') }}"
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
            href="{{ route('admin.payments') }}"
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
            href="{{ route('admin.deliveries') }}"
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
            href="{{ route('admin.reports') }}"
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
            href="{{ route('admin.reports') }}"
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
            href="{{ route('admin.pizzas') }}"
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
                {{ $totalPizzas }}
            </div>

        </a>


        <!-- CUSTOMERS -->

        <a
            href="{{ route('admin.customers') }}"
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
                {{ $totalCustomers }}
            </div>

        </a>


        <!-- PENDING -->

        <a
            href="{{ route('admin.orders') }}"
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
                {{ $pendingOrders }}
            </div>

        </a>


        <!-- SALES -->

        <a
            href="{{ route('admin.reports') }}"
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
                ₱{{ number_format($totalSales, 2) }}
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

@endsection