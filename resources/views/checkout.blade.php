
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Abuyog Andrea Pizza</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        .checkout-page {
            max-width: 1080px;
            margin: 0 auto;
            padding: 30px 20px 50px;
        }

        .checkout-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .checkout-title h1 {
            margin: 0;
            color: #ed1c24;
            font-size: 36px;
        }

        .checkout-title p {
            margin-top: 6px;
            color: #666;
            font-size: 17px;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 25px;
            align-items: start;
        }

        .checkout-card,
        .summary-card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .checkout-card h2,
        .summary-card h2 {
            margin-top: 0;
            margin-bottom: 22px;
            font-size: 24px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ed1c24;
        }

        .error-box {
            background: #ffe5e5;
            color: #b00000;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .success-box {
            background: #e8f8ee;
            color: #15803d;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        .order-item:last-child { border-bottom: none; }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding-top: 18px;
            font-size: 22px;
            font-weight: bold;
            color: #ed1c24;
        }

        .place-order-btn {
            width: 100%;
            margin-top: 18px;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #16a34a;
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        .place-order-btn:hover:not(:disabled) {
            background: #12813b;
        }

        .place-order-btn:disabled {
            background: #999;
            cursor: not-allowed;
        }

        .back-btn {
            display: block;
            width: 100%;
            margin-top: 12px;
            padding: 13px;
            border-radius: 8px;
            background: #222;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover { background: #000; }

        .selected-info {
            background: #f5f5f5;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #444;
        }

        .selected-order-option {
            background: #e8f8ee;
            border: 1px solid #b9e8ca;
            color: #087a36;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .selected-order-option strong { color: #087a36; }

        .distance-info {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 13px;
            margin-bottom: 18px;
            line-height: 1.7;
            font-size: 14px;
        }

        .distance-info strong { color: #087a36; }

        .fee-message {
            margin-top: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .fee-message.success { color: #15803d; }
        .fee-message.warning { color: #b45309; }
        .fee-message.error { color: #b00020; }

        @media (max-width: 800px) {
            .checkout-layout { grid-template-columns: 1fr; }
            .checkout-title h1 { font-size: 30px; }
        }

        @media (max-width: 500px) {
            .checkout-page { padding: 20px 12px 40px; }

            .checkout-card,
            .summary-card { padding: 18px; }

            .order-item { font-size: 14px; }

            .summary-total { font-size: 19px; }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    @php
        $isDelivery = ($deliveryOption ?? 'delivery') === 'delivery';
        $initialQuoteKnown = !$isDelivery
            || (bool) data_get($deliveryQuote ?? [], 'known', false);

        $initialFee = $isDelivery
            ? (float) ($deliveryFee ?? 0)
            : 0;

        $initialTotal = (float) ($subtotal ?? 0) + $initialFee;
    @endphp

    <div class="checkout-page">

        <div class="checkout-title">
            <h1>Checkout</h1>
            <p>Complete your order details below.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="error-box">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="success-box">{{ session('success') }}</div>
        @endif

        <form
            id="checkout-form"
            action="{{ route('checkout.store') }}"
            method="POST"
        >
            @csrf

            <div class="checkout-layout">

                <div class="checkout-card">

                    <h2>Order Details</h2>

                    <div class="selected-info">
                        Your delivery and payment options have already been selected in your cart.
                    </div>

                    <div class="selected-order-option">
                        <strong>Delivery Option:</strong>

                        @if ($isDelivery)
                            🚚 Delivery
                        @else
                            🏪 Pickup
                        @endif

                        <br>

                        <strong>Payment Method:</strong>

                        @if (($paymentMethod ?? '') === 'cash_on_delivery')
                            💵 Cash on Delivery
                        @elseif (($paymentMethod ?? '') === 'cash_on_pickup')
                            💵 Cash on Pickup
                        @elseif (($paymentMethod ?? '') === 'gcash')
                            📱 GCash
                        @else
                            Not selected
                        @endif
                    </div>

                    @if ($isDelivery)

                        <div class="form-group">
                            <label for="delivery_address">
                                Delivery Address
                            </label>

                            <textarea
                                id="delivery_address"
                                name="delivery_address"
                                placeholder="Enter your complete address, including your barangay"
                                maxlength="1000"
                                required
                                aria-describedby="fee-message"
                            >{{ old('delivery_address', $deliveryAddress ?? '') }}</textarea>

                            <small>
                                Include your barangay in the address so we can calculate your delivery fee.
                            </small>
                        </div>

                        <div class="distance-info">
                            <div>
                                <strong>Delivery Fee:</strong>
                                <span id="delivery-fee-display">
                                    @if ($initialQuoteKnown)
                                        ₱{{ number_format($initialFee, 2) }}
                                    @else
                                        To be confirmed
                                    @endif
                                </span>
                            </div>

                            <div
                                id="fee-message"
                                class="fee-message {{ $initialQuoteKnown ? 'success' : 'warning' }}"
                                role="status"
                                aria-live="polite"
                            >
                                @if ($initialQuoteKnown)
                                    @if (data_get($deliveryQuote ?? [], 'barangay'))
                                        Delivery fee for {{ data_get($deliveryQuote, 'barangay') }}.
                                    @else
                                        Delivery fee calculated.
                                    @endif
                                @else
                                    {{ data_get($deliveryQuote ?? [], 'message', 'Enter your barangay to check the delivery fee.') }}
                                @endif
                            </div>
                        </div>

                    @else

                        <div class="distance-info">
                            <strong>Pickup Order</strong>
                            <br>
                            No delivery fee will be charged.
                            <br>
                            <strong>Delivery Fee:</strong> ₱0.00
                        </div>

                    @endif

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>

                        <input
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            value="{{ old('contact_number') }}"
                            placeholder="09XXXXXXXXX"
                            maxlength="30"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="notes">Order Notes</label>

                        <textarea
                            id="notes"
                            name="notes"
                            placeholder="Optional notes..."
                            maxlength="2000"
                        >{{ old('notes') }}</textarea>
                    </div>

                </div>

                <div class="summary-card">

                    <h2>Order Summary</h2>

                    @foreach ($cart as $item)
                        <div class="order-item">
                            <span>
                                {{ $item['name'] ?? 'Pizza' }}
                                × {{ $item['quantity'] ?? 0 }}
                            </span>

                            <span>
                                ₱{{ number_format(
                                    (float) ($item['price'] ?? 0)
                                    * (int) ($item['quantity'] ?? 0),
                                    2
                                ) }}
                            </span>
                        </div>
                    @endforeach

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>
                            ₱{{ number_format((float) $subtotal, 2) }}
                        </span>
                    </div>

                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span id="summary-fee">
                            @if ($initialQuoteKnown)
                                ₱{{ number_format($initialFee, 2) }}
                            @else
                                To be confirmed
                            @endif
                        </span>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span id="summary-total">
                            @if ($initialQuoteKnown)
                                ₱{{ number_format($initialTotal, 2) }}
                            @else
                                To be confirmed
                            @endif
                        </span>
                    </div>

                    <button
                        type="submit"
                        id="place-order-btn"
                        class="place-order-btn"
                        @if (!$initialQuoteKnown) disabled @endif
                    >
                        Place Order
                    </button>

                    <a href="{{ route('cart') }}" class="back-btn">
                        ← Back to Cart
                    </a>

                </div>

            </div>
        </form>

    </div>

    @if ($isDelivery)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addressInput = document.getElementById('delivery_address');
                const feeDisplay = document.getElementById('delivery-fee-display');
                const summaryFee = document.getElementById('summary-fee');
                const summaryTotal = document.getElementById('summary-total');
                const feeMessage = document.getElementById('fee-message');
                const placeOrderButton = document.getElementById('place-order-btn');
                const checkoutForm = document.getElementById('checkout-form');

                const subtotal = Number(@json((float) $subtotal));
                const quoteUrl = @json(route('delivery-fee.quote'));
                const csrfToken = @json(csrf_token());

                let debounceTimer = null;
                let requestNumber = 0;
                let quoteKnown = @json($initialQuoteKnown);

                function formatPeso(amount) {
                    return '₱' + Number(amount).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                function setMessage(message, type) {
                    feeMessage.textContent = message;
                    feeMessage.className = 'fee-message ' + type;
                }

                function setUnknown(message) {
                    quoteKnown = false;
                    feeDisplay.textContent = 'To be confirmed';
                    summaryFee.textContent = 'To be confirmed';
                    summaryTotal.textContent = 'To be confirmed';
                    placeOrderButton.disabled = true;
                    setMessage(
                        message || 'Contact us to confirm the delivery fee.',
                        'warning'
                    );
                }

                function setKnownQuote(quote) {
                    const fee = Number(quote.fee);

                    if (!Number.isFinite(fee) || fee < 0) {
                        setUnknown('Unable to calculate the delivery fee. Please try again.');
                        return;
                    }

                    quoteKnown = true;
                    feeDisplay.textContent = formatPeso(fee);
                    summaryFee.textContent = formatPeso(fee);
                    summaryTotal.textContent = formatPeso(subtotal + fee);
                    placeOrderButton.disabled = false;

                    if (quote.barangay) {
                        setMessage(
                            'Delivery fee for ' + quote.barangay + '.',
                            'success'
                        );
                    } else {
                        setMessage('Delivery fee calculated.', 'success');
                    }
                }

                async function checkDeliveryFee(address, currentRequest) {
                    try {
                        const response = await fetch(quoteUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                address: address
                            })
                        });

                        const result = await response.json();

                        if (currentRequest !== requestNumber) {
                            return;
                        }

                        if (!response.ok) {
                            setUnknown(
                                result.message ||
                                'Unable to check the delivery fee. Please review your address.'
                            );
                            return;
                        }

                        if (result.known && result.fee !== null) {
                            setKnownQuote(result);
                        } else {
                            setUnknown(
                                result.message ||
                                'Contact us to confirm the delivery fee.'
                            );
                        }
                    } catch (error) {
                        if (currentRequest !== requestNumber) {
                            return;
                        }

                        setUnknown(
                            'Could not check the delivery fee. Check your connection and try again.'
                        );
                    }
                }

                addressInput.addEventListener('input', function () {
                    clearTimeout(debounceTimer);

                    const address = addressInput.value.trim();
                    const currentRequest = ++requestNumber;

                    if (address.length < 3) {
                        setUnknown('Enter your complete address, including your barangay.');
                        return;
                    }

                    setUnknown('Checking delivery fee...');
                    debounceTimer = setTimeout(function () {
                        checkDeliveryFee(address, currentRequest);
                    }, 450);
                });

                checkoutForm.addEventListener('submit', function (event) {
                    if (!quoteKnown) {
                        event.preventDefault();
                        setMessage(
                            'Please enter a recognized barangay and wait for the delivery fee confirmation before placing your order.',
                            'warning'
                        );
                        addressInput.focus();
                    }
                });
            });
        </script>
    @endif

</body>
</html>
