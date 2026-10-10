<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>GCash Payment - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #fff8ee;
            font-family: Arial, sans-serif;
            color: #222;
            font-size: 13px;
        }

        .payment-container {
            width: 92%;
            max-width: 760px;
            margin: 22px auto 35px;
        }

        /* HEADER */

        .payment-header {
            background: #ff7900;
            color: white;
            text-align: center;
            padding: 18px 15px;
            border-radius: 14px;
            margin-bottom: 18px;
        }

        .payment-header h1 {
            margin: 0 0 5px;
            font-size: 24px;
            font-weight: 700;
        }

        .payment-header p {
            margin: 0;
            font-size: 12px;
        }

        /* MAIN CARD */

        .payment-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
        }

        /* ORDER INFORMATION */

        .order-info {
            border: 1px solid #ffd5b5;
            background: #fff8f1;
            border-radius: 9px;
            padding: 12px 14px;
            margin-bottom: 18px;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 7px;
        }

        .order-row:last-child {
            margin-bottom: 0;
        }

        .order-label {
            font-weight: 700;
            font-size: 12px;
        }

        .order-number {
            font-size: 12px;
            color: #333;
            text-align: right;
        }

        .amount {
            color: #ed1c24;
            font-size: 20px;
            font-weight: 700;
        }

        /* QR SECTION */

        .qr-section {
            text-align: center;
        }

        .qr-section h2 {
            margin: 0 0 5px;
            font-size: 19px;
        }

        .qr-section p {
            margin: 0 auto 12px;
            color: #666;
            font-size: 12px;
            line-height: 1.4;
        }

        .qr-box {
            width: 250px;
            margin: 0 auto 18px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: white;
        }

        .qr-box img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* PAYMENT ACCOUNT */

        .payment-account {
            max-width: 400px;
            margin: 0 auto 18px;
            padding: 12px 15px;
            background: #f7f7f7;
            border-radius: 8px;
            text-align: center;
        }

        .payment-account h3 {
            margin: 0 0 6px;
            font-size: 13px;
        }

        .payment-account p {
            margin: 0;
            font-size: 11px;
            color: #666;
        }

        /* INSTRUCTIONS */

        .instructions {
            max-width: 500px;
            margin: 0 auto 18px;
            background: #f7f7f7;
            border-radius: 8px;
            padding: 12px 15px;
        }

        .instructions h3 {
            margin: 0 0 7px;
            font-size: 13px;
        }

        .instructions ol {
            margin: 0;
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 4px;
            font-size: 11px;
            line-height: 1.4;
        }

        /* FORM */

        .payment-form {
            max-width: 500px;
            margin: 0 auto;
        }

        .payment-form label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 700;
        }

        .payment-form input {
            width: 100%;
            padding: 9px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 12px;
            outline: none;
        }

        .payment-form input:focus {
            border-color: #198754;
        }

        .submit-btn {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #198754;
            color: white;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #146c43;
        }

        /* BACK BUTTON */

        .back-btn {
            display: block;
            width: fit-content;
            margin: 12px auto 0;
            color: #555;
            text-decoration: none;
            font-size: 11px;
        }

        .back-btn:hover {
            color: #ed1c24;
        }

        /* ERROR */

        .alert {
            max-width: 500px;
            margin: 0 auto 15px;
            padding: 9px 11px;
            border-radius: 6px;
            background: #f8d7da;
            color: #842029;
            font-size: 11px;
        }

        /* SUCCESS */

        .success-alert {
            max-width: 500px;
            margin: 0 auto 15px;
            padding: 9px 11px;
            border-radius: 6px;
            background: #d1e7dd;
            color: #0f5132;
            font-size: 11px;
        }

        /* MOBILE */

        @media (max-width: 600px) {

            .payment-container {
                width: 94%;
                margin: 15px auto 25px;
            }

            .payment-header {
                padding: 15px 10px;
            }

            .payment-header h1 {
                font-size: 20px;
            }

            .payment-header p {
                font-size: 11px;
            }

            .payment-card {
                padding: 15px;
            }

            .order-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 3px;
            }

            .order-number {
                text-align: left;
            }

            .amount {
                font-size: 18px;
            }

            .qr-box {
                width: 210px;
            }

        }

    </style>

</head>


<body>

    {{-- NAVBAR --}}

    @include('partials.navbar')


    <main class="payment-container">


        <!-- HEADER -->

        <section class="payment-header">

            <h1>
                💳 GCash Payment
            </h1>

            <p>
                Scan the QR code to complete your payment.
            </p>

        </section>


        <!-- MAIN CARD -->

        <section class="payment-card">


            <!-- ORDER INFORMATION -->

            <div class="order-info">

                <div class="order-row">

                    <span class="order-label">
                        Order Number
                    </span>

                    <span class="order-number">
                        {{ $order->order_number }}
                    </span>

                </div>


                <div class="order-row">

                    <span class="order-label">
                        Amount to Pay
                    </span>

                    <span class="amount">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </span>

                </div>

            </div>


            <!-- QR PAYMENT -->

            <div class="qr-section">

                <h2>
                    Scan to Pay
                </h2>

                <p>
                    Scan the GCash QR code below using your GCash app.
                </p>


                <div class="qr-box">

                    <img
                        src="{{ asset('image/payment/gcash-qr code.jpg') }}"
                        alt="GCash Payment QR Code"
                    >

                </div>


                <!-- PAYMENT ACCOUNT INFORMATION -->

                <div class="payment-account">

                    <h3>
                        GCash Payment
                    </h3>

                    <p>
                        Please verify the recipient details shown
                        in your GCash application before sending payment.
                    </p>

                </div>

            </div>


            <!-- INSTRUCTIONS -->

            <div class="instructions">

                <h3>
                    Payment Instructions
                </h3>

                <ol>

                    <li>
                        Open your GCash application.
                    </li>

                    <li>
                        Tap the Scan QR option.
                    </li>

                    <li>
                        Scan the GCash QR code above.
                    </li>

                    <li>
                        Verify the recipient details before paying.
                    </li>

                    <li>
                        Enter the exact amount shown above.
                    </li>

                    <li>
                        Complete the payment.
                    </li>

                    <li>
                        Copy your GCash payment reference number.
                    </li>

                    <li>
                        Enter the reference number below.
                    </li>

                </ol>

            </div>


            <!-- SUCCESS MESSAGE -->

            @if(session('success'))

                <div class="success-alert">
                    {{ session('success') }}
                </div>

            @endif


            <!-- ERROR MESSAGE -->

            @if(session('error'))

                <div class="alert">
                    {{ session('error') }}
                </div>

            @endif


            <!-- VALIDATION ERRORS -->

            @if($errors->any())

                <div class="alert">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <!-- PAYMENT FORM -->

            <form
                action="{{ route('gcash.pay', $order->id) }}"
                method="POST"
                class="payment-form"
            >

                @csrf


                <label for="reference_number">
                    GCash Payment Reference Number
                </label>


                <input
                    type="text"
                    id="reference_number"
                    name="reference_number"
                    value="{{ old('reference_number') }}"
                    placeholder="Enter your GCash reference number"
                    required
                    maxlength="100"
                >


                <button
                    type="submit"
                    class="submit-btn"
                >
                    ✓ I Have Paid
                </button>

            </form>


            <!-- BACK TO CHECKOUT -->

            <a
                href="{{ route('checkout') }}"
                class="back-btn"
            >
                ← Back to Checkout
            </a>


        </section>


    </main>

</body>

</html>
