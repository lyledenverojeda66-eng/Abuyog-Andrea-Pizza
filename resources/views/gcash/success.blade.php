@include('partials.navbar')

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Payment Submitted</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        .success-page {
            max-width: 700px;
            margin: 0 auto;
            padding: 55px 18px;
        }

        .success-card {
            background: white;
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .success-icon {
            width: 75px;
            height: 75px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #d1e7dd;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 700;
        }

        .success-card h1 {
            margin: 0 0 10px;
            font-size: 28px;
        }

        .success-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin: 8px 0;
        }

        .order-number {
            margin: 22px 0;
            padding: 16px;
            background: #fff4e8;
            border: 1px solid #ffd8b5;
            border-radius: 10px;
        }

        .order-number strong {
            display: block;
            margin-bottom: 6px;
        }

        .reference {
            margin-top: 15px;
            padding: 12px;
            background: #f8f8f8;
            border-radius: 8px;
            font-size: 13px;
            color: #555;
            word-break: break-word;
        }

        .reference strong {
            color: #222;
        }

        .pending-message {
            margin-top: 20px;
            padding: 14px;
            background: #fff3cd;
            color: #664d03;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.5;
        }

        .buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
        }

        .btn-primary {
            background: #ed1c24;
            color: white;
        }

        .btn-secondary {
            background: #eee;
            color: #333;
        }

        .btn-primary:hover {
            background: #c9151c;
        }

        .btn-secondary:hover {
            background: #ddd;
        }

        @media (max-width: 600px) {

            .success-page {
                padding: 35px 12px;
            }

            .success-card {
                padding: 30px 20px;
            }

            .success-card h1 {
                font-size: 24px;
            }

        }

    </style>

</head>

<body>

<div class="success-page">

    <div class="success-card">


        {{-- SUCCESS ICON --}}

        <div class="success-icon">
            ✓
        </div>


        {{-- TITLE --}}

        <h1>
            Payment Submitted!
        </h1>


        <p>
            Thank you! Your payment reference has been
            submitted successfully.
        </p>


        <p>
            Your payment will be verified by
            Abuyog Andrea Pizza.
        </p>


        {{-- ORDER NUMBER --}}

        <div class="order-number">

            <strong>
                Order Number
            </strong>

            {{ $order->order_number }}

        </div>


        {{-- PAYMENT REFERENCE --}}

        @if($order->payment)

            @if($order->payment->reference_number)

                <div class="reference">

                    Payment Reference Number:

                    <br>

                    <strong>
                        {{ $order->payment->reference_number }}
                    </strong>

                </div>

            @endif

        @endif


        {{-- PENDING NOTICE --}}

        <div class="pending-message">

            ⏳ Your payment is currently
            <strong>pending verification</strong>.
            The administrator will verify your payment
            before marking it as paid.

        </div>


       {{-- BUTTONS --}}
<div class="buttons">

    <a href="{{ route('orders') }}" class="btn btn-primary">
        View My Orders
    </a>

    <a href="{{ route('menu') }}" class="btn btn-secondary">
        Continue Shopping
    </a>

</div>


    </div>

</div>

</body>

</html>