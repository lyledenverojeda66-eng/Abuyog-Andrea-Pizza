@extends('admin.layout')

@section('title', 'Reports')

@section('content')

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
            {{ $totalOrders }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            PENDING ORDERS
        </div>

        <div class="stat-number">
            {{ $pendingOrders }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            DELIVERED ORDERS
        </div>

        <div class="stat-number">
            {{ $deliveredOrders }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            CANCELLED ORDERS
        </div>

        <div class="stat-number">
            {{ $cancelledOrders }}
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

            ₱{{ number_format($totalSales, 2) }}

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

            ₱{{ number_format($gcashSales, 2) }}

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

            ₱{{ number_format($cashSales, 2) }}

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
                {{ $totalCustomers }}
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
                {{ $totalPizzas }}
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
                {{ $deliveredOrders }}
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
                {{ $cancelledOrders }}
            </strong>

        </div>

    </div>

</div>

@endsection