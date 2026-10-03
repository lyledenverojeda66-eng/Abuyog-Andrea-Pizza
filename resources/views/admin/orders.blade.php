@extends('admin.layout')

@section('content')

<style>

    .orders-page {
        max-width: 1200px;
        margin: auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        color: #166534;
        margin: 0 0 6px;
    }

    .page-header p {
        color: #777;
        margin: 0;
    }

    .orders-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .orders-table th {
        background: #f0fdf4;
        color: #166534;
        padding: 14px;
        text-align: left;
        font-size: 14px;
    }

    .orders-table td {
        padding: 14px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .orders-table tr:hover {
        background: #f9fffb;
    }

    .order-number {
        color: #166534;
        font-weight: bold;
    }

    .customer-name {
        font-weight: bold;
        color: #333;
    }

    .customer-email {
        color: #777;
        font-size: 12px;
        margin-top: 3px;
    }

    .status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed {
        background: #dcfce7;
        color: #166534;
    }

    .status-preparing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-ready_for_delivery {
        background: #ede9fe;
        color: #6d28d9;
    }

    .status-out_for_delivery {
        background: #cffafe;
        color: #0e7490;
    }

    .status-delivered {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .payment {
        font-weight: bold;
        color: #166534;
    }

    .payment-status {
        font-size: 12px;
        color: #777;
        margin-top: 3px;
        text-transform: capitalize;
    }

    .amount {
        color: #15803d;
        font-size: 16px;
        font-weight: bold;
        white-space: nowrap;
    }

    .date {
        color: #555;
        font-size: 13px;
        white-space: nowrap;
    }

    .view-btn {
        display: inline-block;
        background: #16a34a;
        color: white;
        text-decoration: none;
        padding: 9px 15px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
    }

    .view-btn:hover {
        background: #15803d;
    }

    .empty {
        text-align: center;
        padding: 50px 20px;
        color: #777;
    }

    .empty-icon {
        font-size: 50px;
        margin-bottom: 10px;
    }

</style>


<div class="orders-page">


    <div class="page-header">

        <h1>
            Orders
        </h1>

        <p>
            Manage customer orders and update their delivery status.
        </p>

    </div>


    @if(session('success'))

        <div style="
            background:#dcfce7;
            color:#166534;
            padding:14px 18px;
            border-radius:10px;
            margin-bottom:20px;
            font-weight:bold;
        ">

            {{ session('success') }}

        </div>

    @endif


    <div class="orders-card">


        @if($orders->count())


            <table class="orders-table">

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
                            Payment
                        </th>

                        <th>
                            Total
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


                    @foreach($orders as $order)


                        <tr>


                            <td>

                                <div class="order-number">
                                    #{{ $order->order_number }}
                                </div>

                                <div style="
                                    color:#777;
                                    font-size:12px;
                                    margin-top:4px;
                                ">

                                    {{ $order->orderItems->count() }}
                                    item(s)

                                </div>

                            </td>


                            <td>

                                <div class="customer-name">

                                    {{ $order->user->name }}

                                </div>

                                <div class="customer-email">

                                    {{ $order->user->email }}

                                </div>

                            </td>


                            <td>

                                <div class="date">

                                    {{ $order->created_at->format('M d, Y') }}

                                </div>

                                <div style="
                                    color:#777;
                                    font-size:12px;
                                    margin-top:3px;
                                ">

                                    {{ $order->created_at->format('h:i A') }}

                                </div>

                            </td>


                            <td>

                                <div class="payment">

                                    @if($order->payment_method === 'gcash')

                                        GCash

                                    @else

                                        Cash on Delivery

                                    @endif

                                </div>


                                @if($order->payment)

                                    <div class="payment-status">

                                        {{ $order->payment->status }}

                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="amount">

                                    ₱{{ number_format($order->total_amount, 2) }}

                                </div>

                            </td>


                            <td>

                                <span
                                    class="status status-{{ $order->status }}"
                                >

                                    {{ str_replace('_', ' ', $order->status) }}

                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('admin.orders.show', $order->id) }}"
                                    class="view-btn"
                                >
                                    View Details
                                </a>

                            </td>


                        </tr>


                    @endforeach


                </tbody>

            </table>


        @else


            <div class="empty">

                <div class="empty-icon">
                    📦
                </div>

                <h2>
                    No Orders Yet
                </h2>

                <p>
                    There are currently no customer orders.
                </p>

            </div>


        @endif


    </div>


</div>

@endsection