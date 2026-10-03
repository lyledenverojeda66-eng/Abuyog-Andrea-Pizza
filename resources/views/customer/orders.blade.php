<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        My Orders - Abuyog Andrea Pizza
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 30px auto;
        }

        h1 {
            text-align: center;
            color: #168f54;
            margin-bottom: 25px;
            font-size: 30px;
        }

        .order-card {
            background: white;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 18px;
            box-shadow: 0 3px 12px rgba(0,0,0,.07);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }

        .order-number {
            font-weight: bold;
            font-size: 17px;
        }

        .date {
            color: #777;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status.confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status.preparing {
            background: #e2d9f3;
            color: #563d7c;
        }

        .status.ready_for_delivery {
            background: #d4edda;
            color: #155724;
        }

        .status.out_for_delivery {
            background: #cce5ff;
            color: #004085;
        }

        .status.delivered {
            background: #d4edda;
            color: #155724;
        }

        .status.cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-box {
            background: #fafafa;
            padding: 12px;
            border-radius: 7px;
        }

        .info-label {
            font-size: 12px;
            color: #777;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: bold;
        }

        .items {
            border-top: 1px solid #eee;
            padding-top: 12px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 7px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item:last-child {
            border-bottom: none;
        }

        .total {
            text-align: right;
            font-size: 19px;
            font-weight: bold;
            color: #ed1c24;
            margin-top: 13px;
        }

        .actions {
            margin-top: 15px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .track-btn {
            background: #168f54;
            color: white;
        }

        .pay-btn {
            background: #007bff;
            color: white;
        }

        .empty {
            background: white;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0,0,0,.07);
        }

        .menu-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #168f54;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        @media(max-width: 700px) {

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-info {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

    @include('partials.navbar')


    <main class="container">

        <h1>
            My Orders
        </h1>


        @if($orders->isEmpty())

            <div class="empty">

                <h2>
                    No orders yet.
                </h2>

                <p>
                    You haven't placed any orders yet.
                </p>

                <a
                    href="{{ route('menu') }}"
                    class="menu-btn"
                >
                    Order Pizza
                </a>

            </div>

        @else


            @foreach($orders as $order)

                <div class="order-card">


                    <div class="order-header">

                        <div>

                            <div class="order-number">

                                Order #{{ $order->order_number }}

                            </div>

                            <div class="date">

                                {{ $order->created_at->format('M d, Y h:i A') }}

                            </div>

                        </div>


                        <span
                            class="status {{ $order->status }}"
                        >

                            {{ str_replace(
                                '_',
                                ' ',
                                $order->status
                            ) }}

                        </span>

                    </div>


                    <div class="order-info">


                        <div class="info-box">

                            <div class="info-label">
                                Order Type
                            </div>

                            <div class="info-value">

                                @if(
                                    $order->delivery_option === 'pickup'
                                )

                                    🏪 Pick Up

                                @else

                                    🚚 Delivery

                                @endif

                            </div>

                        </div>


                        <div class="info-box">

                            <div class="info-label">
                                Payment
                            </div>

                            <div class="info-value">

                                @if(
                                    $order->payment_method === 'gcash'
                                )

                                    📱 GCash

                                @elseif(
                                    $order->delivery_option === 'pickup'
                                )

                                    💵 Cash

                                @else

                                    💵 Cash on Delivery

                                @endif

                            </div>

                        </div>


                        <div class="info-box">

                            <div class="info-label">
                                Total
                            </div>

                            <div class="info-value">

                                ₱{{ number_format(
                                    $order->total_amount,
                                    2
                                ) }}

                            </div>

                        </div>


                    </div>


                    <div class="items">

                        @foreach(
                            $order->orderItems
                            as $item
                        )

                            <div class="item">

                                <span>

                                    {{ $item->pizza->name }}
                                    × {{ $item->quantity }}

                                </span>

                                <span>

                                    ₱{{ number_format(
                                        $item->subtotal,
                                        2
                                    ) }}

                                </span>

                            </div>

                        @endforeach

                    </div>


                    <div class="total">

                        Total:
                        ₱{{ number_format(
                            $order->total_amount,
                            2
                        ) }}

                    </div>


                    <div class="actions">

                        <a
                            href="{{ route(
                                'customer.order.tracking',
                                $order->id
                            ) }}"
                            class="btn track-btn"
                        >
                            Track Order
                        </a>


                        @if(
                            $order->payment_method === 'gcash'
                            &&
                            $order->payment
                            &&
                            $order->payment->status !== 'paid'
                        )

                            <a
                                href="{{ route(
                                    'gcash.payment',
                                    $order->id
                                ) }}"
                                class="btn pay-btn"
                            >
                                Pay with GCash
                            </a>

                        @endif

                    </div>


                </div>

            @endforeach


        @endif

    </main>

</body>

</html>