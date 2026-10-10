
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard | Abuyog Andrea Pizza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6f4;
            color: #24332b;
            font-size: 12px;
        }

        header {
            background: #176b3a;
            color: white;
            padding: 14px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
        }

        header p {
            margin: 4px 0 0;
            color: #e0f2e7;
            font-size: 12px;
        }

        .logout-form {
            margin: 0;
        }

        button {
            border: 0;
            border-radius: 6px;
            padding: 8px 11px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
        }

        .logout-btn {
            background: white;
            color: #176b3a;
        }

        main {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 14px;
        }

        .welcome {
            margin-bottom: 18px;
        }

        .welcome h2 {
            margin: 0 0 6px;
            font-size: 19px;
        }

        .welcome p {
            margin: 0;
            font-size: 13px;
            color: #526158;
        }

        .notice {
            padding: 10px 12px;
            border-radius: 7px;
            margin-bottom: 12px;
            font-size: 12px;
        }

        .success {
            background: #d9f7e3;
            color: #176b3a;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .delivery-card {
            background: white;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px #0000000c;
            border: 1px solid #e0e8e2;
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            border-bottom: 1px solid #e6ece8;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .card-heading h3 {
            margin: 0;
            font-size: 15px;
            overflow-wrap: anywhere;
        }

        .card-heading p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #68756c;
        }

        .status {
            display: inline-block;
            border-radius: 20px;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            background: #edf0ed;
            color: #39463d;
        }

        .paid {
            background: #d9f7e3;
            color: #176b3a;
        }

        .pending {
            background: #fff0c2;
            color: #805b00;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
        }

        .detail-box {
            padding: 10px;
            border-radius: 7px;
            background: #f7f9f7;
            overflow-wrap: anywhere;
            font-size: 12px;
            line-height: 1.5;
        }

        .detail-box strong {
            display: block;
            margin-bottom: 5px;
            color: #176b3a;
            font-size: 12px;
        }

        .items {
            margin-top: 14px;
            font-size: 12px;
        }

        .items > strong {
            color: #176b3a;
        }

        .items ul {
            padding-left: 18px;
            line-height: 1.7;
            margin-bottom: 0;
        }

        .delivery-action,
        .payment-action {
            border-top: 1px solid #e6ece8;
            padding-top: 12px;
            margin-top: 14px;
        }

        .action-title {
            display: block;
            margin-bottom: 9px;
            color: #176b3a;
            font-size: 13px;
        }

        .action-form {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .action-form select {
            flex: 1;
            min-width: 170px;
            padding: 8px 10px;
            border: 1px solid #cbd5ce;
            border-radius: 6px;
            background: white;
            color: #24332b;
            font-size: 12px;
        }

        .update-btn,
        .confirm-btn {
            background: #176b3a;
            color: white;
        }

        .update-btn:hover,
        .confirm-btn:hover {
            background: #10552d;
        }

        .update-btn:disabled,
        .confirm-btn:disabled {
            background: #a5b5aa;
            cursor: not-allowed;
        }

        .hint {
            font-size: 11px;
            color: #68756c;
            margin-top: 7px;
            line-height: 1.6;
        }

        .empty {
            text-align: center;
            padding: 35px 15px;
            background: white;
            border-radius: 10px;
            border: 1px solid #e0e8e2;
        }

        .empty h3 {
            color: #176b3a;
            font-size: 17px;
            margin-top: 0;
        }

        .empty p {
            font-size: 12px;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            header {
                padding: 12px 15px;
            }

            header h1 {
                font-size: 17px;
            }

            header p {
                font-size: 11px;
            }

            main {
                margin: 15px auto;
                padding: 0 10px;
            }

            .welcome h2 {
                font-size: 17px;
            }

            .delivery-card {
                padding: 12px;
            }

            .details {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .detail-box {
                padding: 8px;
                font-size: 11px;
            }

            .detail-box strong {
                font-size: 11px;
            }

            .action-form {
                flex-direction: column;
                align-items: stretch;
                gap: 7px;
            }

            .action-form select,
            .action-form button {
                width: 100%;
                min-width: 0;
            }

            .card-heading h3 {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>🍕 Abuyog Andrea Pizza</h1>
            <p>Rider Delivery Dashboard</p>
        </div>

        <form class="logout-form"
              method="POST"
              action="{{ route('logout') }}">
            @csrf

            <button class="logout-btn" type="submit">
                Logout
            </button>
        </form>
    </header>

    <main>
        <section class="welcome">
            <h2>Welcome, {{ auth()->user()->name }}!</h2>
            <p>Here are the deliveries assigned to your account.</p>
        </section>

        @if (session('success'))
            <div class="notice success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notice error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="notice error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @forelse ($deliveries as $delivery)
            @php
                $order = $delivery->order;
                $payment = $order?->payment;

                $currentStatus = $delivery->status ?? 'pending';

                $deliveryStatus = ucwords(
                    str_replace('_', ' ', $currentStatus)
                );

                $paymentStatus = strtolower(
                    $payment?->status
                    ?? $delivery->payment_status
                    ?? 'pending'
                );

                $paymentMethod = strtolower(trim(
                    $payment?->method
                    ?? $order?->payment_method
                    ?? ''
                ));

                $isCod = in_array($paymentMethod, [
                    'cash_on_delivery',
                    'cod',
                    'cash on delivery',
                ], true);

                $isGcash = in_array($paymentMethod, [
                    'gcash',
                    'g-cash',
                ], true);

                $nextStatuses = [
                    'pending' => [
                        'preparing' => 'Preparing Order',
                    ],
                    'preparing' => [
                        'ready_for_pickup' => 'Ready for Pickup',
                    ],
                    'ready_for_pickup' => [
                        'picked_up' => 'Picked Up',
                    ],
                    'picked_up' => [
                        'out_for_delivery' => 'Out for Delivery',
                        'delivered' => 'Delivered',
                    ],
                    'out_for_delivery' => [
                        'delivered' => 'Delivered',
                    ],
                    'delivered' => [],
                ];

                $availableStatuses =
                    $nextStatuses[$currentStatus] ?? [];
            @endphp

            <article class="delivery-card">

                <div class="card-heading">
                    <div>
                        <h3>
                            Order #{{ $order?->order_number ?? $delivery->order_id }}
                        </h3>

                        <p>
                            Delivery ID: {{ $delivery->id }}
                        </p>
                    </div>

                    <span class="status {{ $currentStatus === 'delivered' ? 'paid' : '' }}">
                        {{ $deliveryStatus }}
                    </span>
                </div>

                <div class="details">

                    <div class="detail-box">
                        <strong>Customer</strong>
                        {{ $order?->user?->name ?? 'N/A' }}
                    </div>

                    <div class="detail-box">
                        <strong>Contact Number</strong>
                        {{ $order?->contact_number ?? 'N/A' }}
                    </div>

                    <div class="detail-box">
                        <strong>Delivery Address</strong>
                        {{ $order?->delivery_address ?? 'N/A' }}
                    </div>

                    <div class="detail-box">
                        <strong>Order Total</strong>
                        ₱{{ number_format((float) ($order?->total_amount ?? 0), 2) }}
                    </div>

                    <div class="detail-box">
                        <strong>Payment Method</strong>
                        {{ strtoupper(str_replace(
                            '_',
                            ' ',
                            $payment?->method
                            ?? $order?->payment_method
                            ?? 'N/A'
                        )) }}
                    </div>

                    <div class="detail-box">
                        <strong>Payment Status</strong>

                        <span class="status {{ $paymentStatus === 'paid' ? 'paid' : 'pending' }}">
                            {{ ucfirst($paymentStatus) }}
                        </span>
                    </div>

                </div>

                <div class="items">
                    <strong>Ordered Items</strong>

                    @if ($order && $order->orderItems->isNotEmpty())
                        <ul>
                            @foreach ($order->orderItems as $item)
                                <li>
                                    {{ $item->pizza?->name ?? 'Pizza' }}
                                    × {{ $item->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No order items found.</p>
                    @endif
                </div>

                {{-- DELIVERY STATUS UPDATE --}}
                <div class="delivery-action">
                    <strong class="action-title">
                        Update Delivery Status
                    </strong>

                    @if (count($availableStatuses) > 0)
                        <form
                            class="action-form"
                            method="POST"
                            action="{{ route('rider.deliveries.update-status', $delivery->id) }}"
                            onsubmit="return confirm('Are you sure you want to update this delivery status?');"
                        >
                            @csrf
                            @method('PUT')

                            <select name="status" required aria-label="New delivery status">
                                <option value="">Select next status</option>

                                @foreach ($availableStatuses as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="update-btn">
                                Update Status
                            </button>
                        </form>

                        <p class="hint">
                            Piliin ang susunod na status kapag nakumpleto
                            na ang kasalukuyang step.
                        </p>
                    @else
                        <span class="status paid">
                            ✓ Delivery Completed
                        </span>

                        <p class="hint">
                            This delivery has already been completed.
                        </p>
                    @endif
                </div>

                {{-- PAYMENT CONFIRMATION --}}
                <div class="payment-action">
                    <strong class="action-title">
                        Payment Confirmation
                    </strong>

                    @if ($isCod)
                        @if ($paymentStatus === 'paid')
                            <span class="status paid">
                                ✓ COD Payment Received
                            </span>

                        @elseif ($payment && $paymentStatus !== 'failed')
                            <form
                                method="POST"
                                action="{{ route('rider.deliveries.confirm-payment', $delivery->id) }}"
                                onsubmit="return confirm('Confirm that you have actually received the cash payment?');"
                            >
                                @csrf
                                @method('PUT')

                                <button type="submit" class="confirm-btn">
                                    Confirm COD Payment Received
                                </button>
                            </form>

                            <p class="hint">
                                Kumpirmahin lamang kapag aktuwal mo nang
                                natanggap ang cash mula sa customer.
                            </p>

                        @else
                            <span class="status pending">
                                Payment Failed
                            </span>
                        @endif

                    @elseif ($isGcash)
                        @if ($paymentStatus === 'paid')
                            <span class="status paid">
                                ✓ GCash Payment Approved
                            </span>

                            <p class="hint">
                                Na-verify na ng Admin ang GCash payment.
                                Hindi na ito kailangang kumpirmahin ng rider.
                            </p>
                        @else
                            <span class="status pending">
                                GCash Payment Pending
                            </span>

                            <p class="hint">
                                Admin ang kailangang mag-verify at
                                mag-approve ng GCash payment.
                            </p>
                        @endif

                    @elseif ($paymentStatus === 'paid')
                        <span class="status paid">
                            ✓ Payment Marked as Paid
                        </span>

                        <p class="hint">
                            Walang rider payment confirmation na available
                            para sa payment method na ito.
                        </p>

                    @elseif ($payment)
                        <span class="status pending">
                            {{ ucfirst($paymentStatus) }}
                        </span>

                        <p class="hint">
                            Pakisuri sa Admin ang payment method at status.
                        </p>

                    @else
                        <p class="hint">
                            No payment record is linked to this order yet.
                            Please contact the Admin.
                        </p>
                    @endif
                </div>

            </article>

        @empty
            <section class="empty">
                <h3>No Assigned Deliveries</h3>

                <p>
                    Wala ka pang assigned orders. Ask the admin to assign
                    deliveries to your rider account.
                </p>
            </section>
        @endforelse
    </main>
</body>
</html>