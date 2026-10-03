<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Order Confirmed - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #111;
        }

        /* =========================
           MAIN CONTAINER
        ========================= */

        .confirmation-container {
            width: 90%;
            max-width: 850px;
            margin: 35px auto 40px;
        }

        /* =========================
           SUCCESS HEADER
        ========================= */

        .success-header {
            background: white;
            text-align: center;
            padding: 25px 20px;
            border-radius: 12px;
            border-top: 5px solid #16a34a;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.07);

            margin-bottom: 18px;
        }

        .success-icon {
            width: 52px;
            height: 52px;

            margin: 0 auto 12px;

            border-radius: 50%;

            background: #dcfce7;
            border: 2px solid #16a34a;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #16a34a;

            font-size: 25px;
            font-weight: bold;
        }

        .success-header h1 {
            color: #16a34a;

            font-size: 30px;

            margin-bottom: 8px;
        }

        .success-header p {
            color: #555;

            font-size: 14px;

            line-height: 1.5;
        }

        /* =========================
           ORDER NUMBER
        ========================= */

        .order-number {
            background: #f0fdf4;

            border: 1px solid #bbf7d0;

            border-radius: 8px;

            padding: 13px 15px;

            margin-top: 18px;

            text-align: center;
        }

        .order-number-label {
            display: block;

            color: #555;

            font-size: 12px;

            margin-bottom: 5px;
        }

        .order-number-value {
            color: #111;

            font-size: 17px;

            font-weight: 900;
        }

        /* =========================
           CARD
        ========================= */

        .card {
            background: white;

            border-radius: 12px;

            padding: 20px;

            margin-bottom: 18px;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.07);
        }

        .card h2 {
            color: #16a34a;

            font-size: 21px;

            margin-bottom: 15px;

            padding-bottom: 8px;

            border-bottom: 2px solid #dcfce7;
        }

        /* =========================
           ORDER INFO
        ========================= */

        .order-info {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 12px;
        }

        .info-item {
            background: #fafafa;

            border: 1px solid #eeeeee;

            border-radius: 8px;

            padding: 12px;
        }

        .info-label {
            color: #777;

            font-size: 11px;

            margin-bottom: 4px;
        }

        .info-value {
            color: #222;

            font-size: 13px;

            font-weight: bold;

            line-height: 1.4;
        }

        /* =========================
           STATUS
        ========================= */

        .status {
            display: inline-block;

            background: #fef3c7;

            color: #92400e;

            padding: 4px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;

            text-transform: capitalize;
        }

        /* =========================
           ORDER ITEMS
        ========================= */

        .order-item {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

            padding: 12px 0;

            border-bottom: 1px solid #eeeeee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            color: #222;

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 4px;
        }

        .item-quantity {
            color: #777;

            font-size: 12px;
        }

        .item-price {
            color: #111;

            font-size: 14px;

            font-weight: bold;

            white-space: nowrap;
        }

        /* =========================
           TOTAL
        ========================= */

        .total-row {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 15px;

            padding-top: 15px;

            border-top: 2px solid #16a34a;
        }

        .total-label {
            color: #111;

            font-size: 17px;

            font-weight: 900;
        }

        .total-value {
            color: #16a34a;

            font-size: 21px;

            font-weight: 900;
        }

        /* =========================
           BUTTONS
        ========================= */

        .actions {
            display: flex;

            justify-content: center;

            gap: 12px;

            margin-top: 25px;
        }

        .btn {
            display: inline-block;

            text-decoration: none;

            padding: 10px 20px;

            border-radius: 22px;

            font-size: 13px;

            font-weight: bold;

            transition: 0.2s;
        }

        .btn-primary {
            background: #16a34a;

            color: white;
        }

        .btn-primary:hover {
            background: #15803d;

            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;

            color: #16a34a;

            border: 1px solid #16a34a;
        }

        .btn-secondary:hover {
            background: #f0fdf4;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #080808;

            color: white;

            text-align: center;

            padding: 20px;

            font-size: 13px;
        }

        footer span {
            color: #16a34a;

            font-weight: bold;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {

            .confirmation-container {
                width: 92%;

                margin-top: 25px;
            }

            .success-header {
                padding: 22px 15px;
            }

            .success-header h1 {
                font-size: 25px;
            }

            .success-header p {
                font-size: 13px;
            }

            .order-number-value {
                font-size: 15px;
            }

            .card {
                padding: 16px;
            }

            .card h2 {
                font-size: 19px;
            }

            .order-info {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;

                text-align: center;
            }

        }

    </style>

</head>


<body>


    {{-- =========================
         SAME NAVIGATION
    ========================= --}}

    @include('partials.navbar')


    <main class="confirmation-container">


        {{-- =========================
             SUCCESS HEADER
        ========================= --}}

        <section class="success-header">

            <div class="success-icon">
                ✓
            </div>

            <h1>
                Order Confirmed!
            </h1>

            <p>
                Thank you for ordering from
                <strong>Abuyog Andrea Pizza!</strong>
                Your order has been successfully placed.
            </p>


            <div class="order-number">

                <span class="order-number-label">
                    Order Number
                </span>

                <span class="order-number-value">
                    {{ $order->order_number }}
                </span>

            </div>

        </section>


        {{-- =========================
             ORDER INFORMATION
        ========================= --}}

        <section class="card">

            <h2>
                Order Details
            </h2>


            <div class="order-info">


                <div class="info-item">

                    <div class="info-label">
                        Status
                    </div>

                    <div class="info-value">

                        <span class="status">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>

                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Delivery Address
                    </div>

                    <div class="info-value">
                        {{ $order->delivery_address }}
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Contact Number
                    </div>

                    <div class="info-value">
                        {{ $order->contact_number }}
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Payment Method
                    </div>

                    <div class="info-value">

                        {{ str_replace('_', ' ', ucwords($order->payment_method)) }}

                    </div>

                </div>


            </div>

        </section>


        {{-- =========================
             ITEMS ORDERED
        ========================= --}}

        <section class="card">

            <h2>
                Items Ordered
            </h2>


            @foreach($order->orderItems as $item)

                <div class="order-item">

                    <div>

                        <div class="item-name">

                            {{ $item->pizza->name }}

                        </div>

                        <div class="item-quantity">

                            Quantity:
                            {{ $item->quantity }}

                        </div>

                    </div>


                    <div class="item-price">

                        ₱{{ number_format($item->subtotal, 2) }}

                    </div>

                </div>

            @endforeach


            {{-- TOTAL --}}

            <div class="total-row">

                <div class="total-label">
                    Total Amount
                </div>

                <div class="total-value">

                    ₱{{ number_format($order->total_amount, 2) }}

                </div>

            </div>

        </section>


        {{-- =========================
             ACTION BUTTONS
        ========================= --}}

        <div class="actions">

            <a
                href="{{ route('menu') }}"
                class="btn btn-primary"
            >

                🍕 Order More

            </a>


            <a
                href="{{ route('customer.dashboard') }}"
                class="btn btn-secondary"
            >

                View Dashboard

            </a>

        </div>


    </main>


    {{-- =========================
         FOOTER
    ========================= --}}

    <footer>

        © {{ date('Y') }}

        <span>
            Abuyog Andrea Pizza
        </span>

        All Rights Reserved.

    </footer>


</body>

</html>