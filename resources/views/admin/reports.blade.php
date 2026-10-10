@extends('admin.layout')

@section('content')

<style>
    .reports-page {
        padding: 12px;
        background: #f7f8fa;
        min-height: 100vh;
    }

    /* =========================
       HEADER
       ========================= */

    .reports-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .reports-title h1 {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        color: #222;
    }

    .reports-title p {
        margin: 3px 0 0;
        color: #777;
        font-size: 11px;
    }

    /* =========================
       PERIOD BUTTONS
       ========================= */

    .period-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .period-buttons a {
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 6px;
        background: #fff;
        color: #555;
        border: 1px solid #ddd;
        font-size: 11px;
        font-weight: 700;
        transition: .2s;
    }

    .period-buttons a:hover {
        border-color: #198754;
        color: #198754;
    }

    .period-buttons a.active {
        background: #198754;
        color: #fff;
        border-color: #198754;
    }

    /* =========================
       FILTER
       ========================= */

    .filter-box {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 12px;
    }

    .filter-box form {
        display: flex;
        align-items: end;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .filter-group label {
        font-size: 10px;
        font-weight: 700;
        color: #555;
    }

    .filter-group input,
    .filter-group select {
        height: 32px;
        min-width: 130px;
        border: 1px solid #d8d8d8;
        border-radius: 5px;
        padding: 0 8px;
        background: #fff;
        font-size: 11px;
        outline: none;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #198754;
    }

    .filter-button {
        height: 32px;
        padding: 0 13px;
        border: 0;
        border-radius: 5px;
        background: #198754;
        color: white;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .filter-button:hover {
        background: #157347;
    }

    .period-label {
        margin-top: 6px;
        color: #777;
        font-size: 10px;
    }

    /* =========================
       STATISTICS
       ========================= */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 9px;
        margin-bottom: 12px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 8px;
        padding: 11px;
    }

    .stat-card .label {
        color: #777;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .stat-card .value {
        margin-top: 4px;
        color: #222;
        font-size: 18px;
        font-weight: 800;
    }

    .stat-card .small {
        margin-top: 3px;
        color: #888;
        font-size: 9px;
    }

    /* =========================
       CHARTS
       ========================= */

    .charts-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }

    .chart-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 11px;
    }

    .chart-card.full {
        grid-column: 1 / -1;
    }

    .chart-title {
        margin-bottom: 7px;
    }

    .chart-title h3 {
        margin: 0;
        font-size: 13px;
        color: #222;
    }

    .chart-title p {
        margin: 2px 0 0;
        font-size: 9px;
        color: #888;
    }

    .chart-wrapper {
        position: relative;
        height: 230px;
    }

    .chart-wrapper.small {
        height: 190px;
    }

    /* =========================
       TRANSACTIONS
       ========================= */

    .transactions-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 11px;
        margin-top: 10px;
    }

    .transactions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        gap: 8px;
        flex-wrap: wrap;
    }

    .transactions-header h3 {
        margin: 0;
        font-size: 14px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .transactions-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .transactions-table th {
        text-align: left;
        padding: 7px;
        background: #f7f7f7;
        color: #555;
        font-size: 9px;
        border-bottom: 1px solid #e5e5e5;
    }

    .transactions-table td {
        padding: 7px;
        font-size: 10px;
        color: #444;
        border-bottom: 1px solid #eee;
    }

    /* =========================
       STATUS BADGES
       ========================= */

    .status-badge {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-preparing {
        background: #e2d9f3;
        color: #4b2e83;
    }

    .status-ready_for_delivery {
        background: #cfe2ff;
        color: #084298;
    }

    .status-out_for_delivery {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-delivered {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #842029;
    }

    /* =========================
       VIEW BUTTON
       ========================= */

    .view-button {
        display: inline-block;
        text-decoration: none;
        padding: 4px 7px;
        border-radius: 4px;
        background: #198754;
        color: white;
        font-size: 9px;
        font-weight: 700;
    }

    .view-button:hover {
        background: #157347;
        color: white;
    }

    /* =========================
       EMPTY STATE
       ========================= */

    .empty-state {
        padding: 25px;
        text-align: center;
        color: #999;
        font-size: 11px;
    }

    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .chart-card.full {
            grid-column: auto;
        }
    }

    @media (max-width: 650px) {

        .reports-page {
            padding: 8px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .reports-title h1 {
            font-size: 18px;
        }

        .period-buttons {
            width: 100%;
        }

        .period-buttons a {
            flex: 1;
            text-align: center;
            padding: 6px 5px;
        }

        .filter-group {
            width: 100%;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
        }

        .filter-button {
            width: 100%;
        }

        .chart-wrapper {
            height: 200px;
        }

        .chart-wrapper.small {
            height: 170px;
        }
    }
</style>


<div class="reports-page">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="reports-header">

        <div class="reports-title">

            <h1>
                Reports & Analytics
            </h1>

            <p>
                Sales and order performance report
            </p>

        </div>


        <div class="period-buttons">

            <a
                href="{{ route('admin.reports', ['period' => 'daily']) }}"
                class="{{ $period === 'daily' ? 'active' : '' }}"
            >
                Daily
            </a>

            <a
                href="{{ route('admin.reports', ['period' => 'weekly']) }}"
                class="{{ $period === 'weekly' ? 'active' : '' }}"
            >
                Weekly
            </a>

            <a
                href="{{ route('admin.reports', ['period' => 'monthly']) }}"
                class="{{ $period === 'monthly' ? 'active' : '' }}"
            >
                Monthly
            </a>

            <a
                href="{{ route('admin.reports', ['period' => 'yearly']) }}"
                class="{{ $period === 'yearly' ? 'active' : '' }}"
            >
                Yearly
            </a>

            <a
                href="{{ route('admin.reports', ['period' => 'manual']) }}"
                class="{{ $period === 'manual' ? 'active' : '' }}"
            >
                Manual
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    <div class="filter-box">

        @if($period === 'daily')

            <form
                method="GET"
                action="{{ route('admin.reports') }}"
            >

                <input
                    type="hidden"
                    name="period"
                    value="daily"
                >

                <div class="filter-group">

                    <label for="date">
                        Select Date
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date', now()->format('Y-m-d')) }}"
                    >

                </div>

                <button
                    type="submit"
                    class="filter-button"
                >
                    View Report
                </button>

            </form>

        @elseif($period === 'weekly')

            <form
                method="GET"
                action="{{ route('admin.reports') }}"
            >

                <input
                    type="hidden"
                    name="period"
                    value="weekly"
                >

                <div class="filter-group">

                    <label for="week">
                        Week Starting
                    </label>

                    <input
                        type="date"
                        id="week"
                        name="week"
                        value="{{ request('week', now()->startOfWeek()->format('Y-m-d')) }}"
                    >

                </div>

                <button
                    type="submit"
                    class="filter-button"
                >
                    View Report
                </button>

            </form>

        @elseif($period === 'monthly')

            <form
                method="GET"
                action="{{ route('admin.reports') }}"
            >

                <input
                    type="hidden"
                    name="period"
                    value="monthly"
                >

                <div class="filter-group">

                    <label for="month">
                        Select Month
                    </label>

                    <input
                        type="month"
                        id="month"
                        name="month"
                        value="{{ request('month', now()->format('Y-m')) }}"
                    >

                </div>

                <button
                    type="submit"
                    class="filter-button"
                >
                    View Report
                </button>

            </form>

        @elseif($period === 'yearly')

            <form
                method="GET"
                action="{{ route('admin.reports') }}"
            >

                <input
                    type="hidden"
                    name="period"
                    value="yearly"
                >

                <div class="filter-group">

                    <label for="year">
                        Select Year
                    </label>

                    <select
                        id="year"
                        name="year"
                    >

                        @for(
                            $year = now()->year;
                            $year >= now()->year - 10;
                            $year--
                        )

                            <option
                                value="{{ $year }}"
                                {{ (string) request('year', now()->year) === (string) $year ? 'selected' : '' }}
                            >
                                {{ $year }}
                            </option>

                        @endfor

                    </select>

                </div>

                <button
                    type="submit"
                    class="filter-button"
                >
                    View Report
                </button>

            </form>

        @else

            <form
                method="GET"
                action="{{ route('admin.reports') }}"
            >

                <input
                    type="hidden"
                    name="period"
                    value="manual"
                >

                <div class="filter-group">

                    <label for="start_date">
                        Start Date
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}"
                    >

                </div>


                <div class="filter-group">

                    <label for="end_date">
                        End Date
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ request('end_date', now()->format('Y-m-d')) }}"
                    >

                </div>


                <button
                    type="submit"
                    class="filter-button"
                >
                    View Report
                </button>

            </form>

        @endif


        <div class="period-label">

            Showing report for:

            <strong>
                {{ $reportPeriodText }}
            </strong>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- STATISTICS --}}
    {{-- ========================================================= --}}

    <div class="stats-grid">

        <div class="stat-card">

            <div class="label">
                Total Orders
            </div>

            <div class="value">
                {{ number_format($totalOrders) }}
            </div>

            <div class="small">
                Orders in selected period
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Total Sales
            </div>

            <div class="value">
                ₱{{ number_format($totalSales, 2) }}
            </div>

            <div class="small">
                Completed sales
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Delivered
            </div>

            <div class="value">
                {{ number_format($deliveredOrders) }}
            </div>

            <div class="small">
                Delivered orders
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Cancelled
            </div>

            <div class="value">
                {{ number_format($cancelledOrders) }}
            </div>

            <div class="small">
                Cancelled orders
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Pending
            </div>

            <div class="value">
                {{ number_format($pendingOrders) }}
            </div>

            <div class="small">
                Pending orders
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Customers
            </div>

            <div class="value">
                {{ number_format($totalCustomers) }}
            </div>

            <div class="small">
                Registered customers
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Average Sale
            </div>

            <div class="value">
                ₱{{ number_format($averageSale, 2) }}
            </div>

            <div class="small">
                Average per completed order
            </div>

        </div>


        <div class="stat-card">

            <div class="label">
                Pizza Products
            </div>

            <div class="value">
                {{ number_format($totalPizzas) }}
            </div>

            <div class="small">
                Total pizza products
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CHARTS --}}
    {{-- ========================================================= --}}

    <div class="charts-grid">

        {{-- SALES TREND --}}

        <div class="chart-card full">

            <div class="chart-title">

                <h3>
                    Sales & Orders Trend
                </h3>

                <p>
                    {{ ucfirst($period) }} report —
                    {{ $reportPeriodText }}
                </p>

            </div>

            <div class="chart-wrapper">

                <canvas id="salesTrendChart"></canvas>

            </div>

        </div>


        {{-- STATUS --}}

        <div class="chart-card">

            <div class="chart-title">

                <h3>
                    Order Status
                </h3>

                <p>
                    Orders by status
                </p>

            </div>

            <div class="chart-wrapper small">

                <canvas id="statusChart"></canvas>

            </div>

        </div>


        {{-- PAYMENT --}}

        <div class="chart-card">

            <div class="chart-title">

                <h3>
                    Payment Methods
                </h3>

                <p>
                    Sales by payment method
                </p>

            </div>

            <div class="chart-wrapper small">

                <canvas id="paymentChart"></canvas>

            </div>

        </div>


        {{-- DELIVERY --}}

        <div class="chart-card">

            <div class="chart-title">

                <h3>
                    Delivery vs Pickup
                </h3>

                <p>
                    Sales by order type
                </p>

            </div>

            <div class="chart-wrapper small">

                <canvas id="deliveryChart"></canvas>

            </div>

        </div>


        {{-- TOP PIZZAS --}}

        <div class="chart-card">

            <div class="chart-title">

                <h3>
                    Top Selling Pizzas
                </h3>

                <p>
                    Quantity sold
                </p>

            </div>

            <div class="chart-wrapper small">

                <canvas id="topPizzaChart"></canvas>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TRANSACTIONS --}}
    {{-- ========================================================= --}}

    <div class="transactions-card">

        <div class="transactions-header">

            <h3>
                Recent Transactions
            </h3>

            <span style="font-size:10px;color:#888;">
                {{ $transactions->count() }} transaction(s)
            </span>

        </div>


        @if($transactions->count() > 0)

            <div class="table-wrapper">

                <table class="transactions-table">

                    <thead>

                        <tr>

                            <th>
                                Order #
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
                                Payment
                            </th>

                            <th>
                                Type
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

                        @foreach($transactions as $transaction)

                            <tr>

                                <td>

                                    <strong>
                                        {{ $transaction->order_number ?? '#' . $transaction->id }}
                                    </strong>

                                </td>


                                <td>

                                    {{ $transaction->user->name ?? 'Guest' }}

                                </td>


                                <td>

                                    {{ optional($transaction->created_at)->format('M d, Y h:i A') }}

                                </td>


                                <td>

                                    <strong>
                                        ₱{{ number_format($transaction->total_amount, 2) }}
                                    </strong>

                                </td>


                                <td>

                                    @if($transaction->payment_method === 'gcash')

                                        📱 GCash

                                    @elseif($transaction->payment_method === 'cash_on_pickup')

                                        💵 Cash on Pickup

                                    @else

                                        💵 Cash

                                    @endif

                                </td>


                                <td>

                                    @if($transaction->delivery_option === 'delivery')

                                        🚚 Delivery

                                    @else

                                        🛵 Pickup

                                    @endif

                                </td>


                                <td>

                                    <span
                                        class="status-badge status-{{ $transaction->status }}"
                                    >
                                        {{ ucwords(str_replace('_', ' ', $transaction->status)) }}
                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="{{ route('admin.orders.show', $transaction->id) }}"
                                        class="view-button"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                No transactions found for this period.

            </div>

        @endif

    </div>

</div>


{{-- ============================================================= --}}
{{-- CHART.JS --}}
{{-- ============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA FROM LARAVEL
    |--------------------------------------------------------------------------
    */

    const chartLabels = @json($chartLabels);
    const chartSales = @json($chartSales);
    const chartOrders = @json($chartOrders);

    const statusLabels = @json($statusLabels);
    const statusData = @json($statusData);

    const paymentLabels = @json($paymentLabels);
    const paymentData = @json($paymentData);

    const deliveryLabels = @json($deliveryLabels);
    const deliveryData = @json($deliveryData);

    const topPizzaLabels = @json($topPizzaLabels);
    const topPizzaData = @json($topPizzaData);


    /*
    |--------------------------------------------------------------------------
    | GLOBAL SETTINGS
    |--------------------------------------------------------------------------
    */

    Chart.defaults.font.family =
        'Arial, Helvetica, sans-serif';

    Chart.defaults.font.size = 10;

    Chart.defaults.color = '#666';


    /*
    |--------------------------------------------------------------------------
    | SALES AND ORDERS
    |--------------------------------------------------------------------------
    */

    const salesTrendCanvas =
        document.getElementById('salesTrendChart');

    if (salesTrendCanvas) {

        new Chart(
            salesTrendCanvas,
            {
                type: 'line',

                data: {

                    labels: chartLabels,

                    datasets: [

                        {
                            label: 'Sales',

                            data: chartSales,

                            borderColor: '#198754',

                            backgroundColor:
                                'rgba(25, 135, 84, 0.08)',

                            borderWidth: 2,

                            fill: true,

                            tension: 0.35,

                            pointRadius: 2,

                            pointHoverRadius: 5,

                            yAxisID: 'salesAxis'
                        },

                        {
                            label: 'Orders',

                            data: chartOrders,

                            borderColor: '#0d6efd',

                            backgroundColor:
                                'rgba(13, 110, 253, 0.05)',

                            borderWidth: 2,

                            fill: false,

                            tension: 0.35,

                            pointRadius: 2,

                            pointHoverRadius: 5,

                            yAxisID: 'ordersAxis'
                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {

                        mode: 'index',

                        intersect: false

                    },

                    plugins: {

                        legend: {

                            position: 'top',

                            labels: {

                                boxWidth: 10,

                                padding: 8,

                                font: {

                                    size: 10

                                }

                            }

                        },

                        tooltip: {

                            callbacks: {

                                label: function (context) {

                                    if (
                                        context.dataset.label === 'Sales'
                                    ) {

                                        return ' Sales: ₱'
                                            + Number(
                                                context.raw
                                            ).toLocaleString(
                                                'en-PH',
                                                {
                                                    minimumFractionDigits: 2
                                                }
                                            );

                                    }

                                    return ' Orders: '
                                        + Number(
                                            context.raw
                                        ).toLocaleString();

                                }

                            }

                        }

                    },

                    scales: {

                        salesAxis: {

                            type: 'linear',

                            position: 'left',

                            beginAtZero: true,

                            title: {

                                display: true,

                                text: 'Sales (₱)',

                                font: {

                                    size: 9

                                }

                            },

                            ticks: {

                                font: {

                                    size: 9

                                }

                            }

                        },

                        ordersAxis: {

                            type: 'linear',

                            position: 'right',

                            beginAtZero: true,

                            grid: {

                                drawOnChartArea: false

                            },

                            title: {

                                display: true,

                                text: 'Orders',

                                font: {

                                    size: 9

                                }

                            },

                            ticks: {

                                font: {

                                    size: 9

                                },

                                precision: 0

                            }

                        },

                        x: {

                            ticks: {

                                font: {

                                    size: 8

                                },

                                maxRotation: 45,

                                minRotation: 0

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS CHART
    |--------------------------------------------------------------------------
    */

    const statusCanvas =
        document.getElementById('statusChart');

    if (statusCanvas) {

        new Chart(
            statusCanvas,
            {
                type: 'doughnut',

                data: {

                    labels: statusLabels,

                    datasets: [

                        {
                            data: statusData,

                            backgroundColor: [

                                '#ffc107',
                                '#0dcaf0',
                                '#6f42c1',
                                '#0d6efd',
                                '#20c997',
                                '#198754',
                                '#dc3545'

                            ],

                            borderWidth: 1,

                            borderColor: '#fff'

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: '62%',

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                boxWidth: 9,

                                padding: 7,

                                font: {

                                    size: 8

                                }

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT CHART
    |--------------------------------------------------------------------------
    */

    const paymentCanvas =
        document.getElementById('paymentChart');

    if (paymentCanvas) {

        new Chart(
            paymentCanvas,
            {
                type: 'pie',

                data: {

                    labels: paymentLabels,

                    datasets: [

                        {
                            data: paymentData,

                            backgroundColor: [
                                '#198754',
                                '#0d6efd'
                            ],

                            borderWidth: 1,

                            borderColor: '#fff'

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                boxWidth: 9,

                                padding: 7,

                                font: {

                                    size: 8

                                }

                            }

                        },

                        tooltip: {

                            callbacks: {

                                label: function (context) {

                                    return ' '
                                        + context.label
                                        + ': ₱'
                                        + Number(
                                            context.raw
                                        ).toLocaleString(
                                            'en-PH',
                                            {
                                                minimumFractionDigits: 2
                                            }
                                        );

                                }

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DELIVERY CHART
    |--------------------------------------------------------------------------
    */

    const deliveryCanvas =
        document.getElementById('deliveryChart');

    if (deliveryCanvas) {

        new Chart(
            deliveryCanvas,
            {
                type: 'doughnut',

                data: {

                    labels: deliveryLabels,

                    datasets: [

                        {
                            data: deliveryData,

                            backgroundColor: [
                                '#fd7e14',
                                '#6c757d'
                            ],

                            borderWidth: 1,

                            borderColor: '#fff'

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: '62%',

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                boxWidth: 9,

                                padding: 7,

                                font: {

                                    size: 8

                                }

                            }

                        },

                        tooltip: {

                            callbacks: {

                                label: function (context) {

                                    return ' '
                                        + context.label
                                        + ': ₱'
                                        + Number(
                                            context.raw
                                        ).toLocaleString(
                                            'en-PH',
                                            {
                                                minimumFractionDigits: 2
                                            }
                                        );

                                }

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TOP PIZZAS
    |--------------------------------------------------------------------------
    */

    const topPizzaCanvas =
        document.getElementById('topPizzaChart');

    if (topPizzaCanvas) {

        new Chart(
            topPizzaCanvas,
            {
                type: 'bar',

                data: {

                    labels: topPizzaLabels,

                    datasets: [

                        {
                            label: 'Quantity Sold',

                            data: topPizzaData,

                            backgroundColor: '#198754',

                            borderRadius: 4,

                            borderSkipped: false

                        }

                    ]

                },

                options: {

                    indexAxis: 'y',

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            display: false

                        }

                    },

                    scales: {

                        x: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0,

                                font: {

                                    size: 8

                                }

                            }

                        },

                        y: {

                            ticks: {

                                font: {

                                    size: 8

                                }

                            }

                        }

                    }

                }

            }

        );

    }

});

</script>

@endsection