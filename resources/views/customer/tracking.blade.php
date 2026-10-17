{{-- resources/views/customer/tracking.blade.php --}}

@include('partials.navbar')

@php
    $delivery = $order->delivery;
    $rider = $delivery?->rider;

    $riderName = $rider?->name ?: ($delivery?->rider_name ?? 'Not assigned yet');
    $riderContact = $rider?->phone ?: ($delivery?->rider_contact ?? 'No contact number');

    $orderStatus = strtolower($order->status ?? 'pending');
    $deliveryStatus = strtolower($delivery?->status ?? 'pending');

    $statusLabels = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'preparing' => 'Preparing',
        'ready_for_delivery' => 'Ready for Delivery',
        'ready_for_pickup' => 'Ready for Pickup',
        'picked_up' => 'Picked Up',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    $currentStatusLabel = $statusLabels[$orderStatus]
        ?? ucfirst(str_replace('_', ' ', $orderStatus));

    $timeline = [
        [
            'label' => 'Order Placed',
            'description' => 'Your order has been received.',
            'statuses' => [
                'pending',
                'confirmed',
                'preparing',
                'ready_for_delivery',
                'ready_for_pickup',
                'picked_up',
                'out_for_delivery',
                'delivered',
            ],
        ],
        [
            'label' => 'Preparing',
            'description' => 'Your pizza is being prepared.',
            'statuses' => [
                'preparing',
                'ready_for_delivery',
                'ready_for_pickup',
                'picked_up',
                'out_for_delivery',
                'delivered',
            ],
        ],
        [
            'label' => 'Ready for Delivery',
            'description' => 'Your order is ready for delivery.',
            'statuses' => [
                'ready_for_delivery',
                'ready_for_pickup',
                'picked_up',
                'out_for_delivery',
                'delivered',
            ],
        ],
        [
            'label' => 'Out for Delivery',
            'description' => 'The rider is on the way to your address.',
            'statuses' => [
                'out_for_delivery',
                'delivered',
            ],
        ],
        [
            'label' => 'Delivered',
            'description' => 'Your order has been successfully delivered.',
            'statuses' => ['delivered'],
        ],
    ];

    $isCancelled = $orderStatus === 'cancelled';

    $isDelivered = $deliveryStatus === 'delivered'
        || $orderStatus === 'delivered';

    $payment = $order->payment;

    $paymentMethod = $payment?->method
        ?? $order->payment_method
        ?? 'Not specified';

    $paymentStatus = $payment?->status
        ?? $order->payment_status
        ?? 'pending';

    $paymentLabels = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded',
    ];

    $paymentStatusLabel = $paymentLabels[strtolower($paymentStatus)]
        ?? ucfirst(str_replace('_', ' ', $paymentStatus));
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Tracking | Abuyog Andrea Pizza</title>

    <style>
        :root {
            --red: #ed1c24;
            --dark: #171717;
            --green: #176b3a;
            --light-green: #eaf7ee;
            --cream: #fff8ee;
            --border: #e8e0d7;
            --muted: #777;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: #292929;
            font-family: Arial, Helvetica, sans-serif;
        }

        .tracking-page {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 18px 50px;
        }

        .tracking-header {
            margin-bottom: 25px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 10px 16px;
            border-radius: 8px;
            background: var(--green);
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: background .2s, transform .2s;
        }

        .back-link:hover {
            background: #10552d;
            transform: translateY(-1px);
        }

        .tracking-header h1 {
            margin: 0 0 8px;
            color: var(--dark);
            font-size: clamp(25px, 4vw, 34px);
        }

        .tracking-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .order-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .summary-item {
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            overflow-wrap: anywhere;
        }

        .summary-label {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .summary-value {
            font-size: 17px;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 30px;
            background: #fff0d9;
            color: #875400;
            font-size: 12px;
            font-weight: 700;
        }

        .status-badge.delivered {
            background: var(--light-green);
            color: var(--green);
        }

        .status-badge.cancelled {
            background: #ffe8e8;
            color: #b42318;
        }

        .tracking-container {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(280px, .8fr);
            align-items: start;
            gap: 22px;
        }

        .tracking-main,
        .tracking-sidebar {
            display: grid;
            gap: 22px;
            min-width: 0;
        }

        .information-card {
            padding: 23px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .035);
            min-width: 0;
        }

        .information-card h2 {
            margin: 0 0 20px;
            color: var(--dark);
            font-size: 20px;
        }

        .timeline {
            position: relative;
            display: grid;
            gap: 0;
        }

        .timeline-item {
            position: relative;
            display: grid;
            grid-template-columns: 35px minmax(0, 1fr);
            gap: 13px;
            min-height: 83px;
        }

        .timeline-item:last-child {
            min-height: 40px;
        }

        .timeline-marker-column {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .timeline-marker {
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 2px solid #d7d7d7;
            border-radius: 50%;
            background: #fff;
            color: #999;
            font-size: 13px;
            font-weight: 700;
        }

        .timeline-item.completed .timeline-marker {
            border-color: var(--green);
            background: var(--green);
            color: #fff;
        }

        .timeline-line {
            position: absolute;
            top: 30px;
            bottom: 0;
            width: 2px;
            background: #dedede;
        }

        .timeline-item.completed .timeline-line {
            background: var(--green);
        }

        .timeline-content {
            padding: 4px 0 23px;
        }

        .timeline-content h3 {
            margin: 0 0 6px;
            font-size: 15px;
        }

        .timeline-content p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .timeline-item:not(.completed) .timeline-content h3 {
            color: #777;
        }

        .cancelled-notice {
            padding: 14px;
            border: 1px solid #ffcaca;
            border-radius: 9px;
            background: #fff0f0;
            color: #a11;
            line-height: 1.6;
        }

        .detail-list {
            display: grid;
            gap: 0;
        }

        .detail-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 13px 0;
            border-bottom: 1px solid #f0ece7;
        }

        .detail-row:first-child {
            padding-top: 0;
        }

        .detail-row:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-label {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .detail-value {
            max-width: 65%;
            color: #292929;
            font-size: 13px;
            font-weight: 700;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .payment-note {
            margin-top: 14px;
            padding: 12px;
            border-radius: 8px;
            background: #f7f5f1;
            color: #555;
            font-size: 12px;
            line-height: 1.7;
        }

        .tracking-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 12px 17px;
            border: 0;
            border-radius: 8px;
            background: var(--red);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s;
        }

        .action-button:hover {
            background: #c9151c;
        }

        .action-button.secondary {
            border: 1px solid var(--border);
            background: #fff;
            color: #292929;
        }

        .action-button.secondary:hover {
            background: #f5f2ee;
        }

        .tracking-footer {
            padding: 25px 18px;
            color: #777;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 760px) {
            .tracking-container {
                grid-template-columns: 1fr;
            }

            .order-summary {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .summary-item {
                padding: 14px;
            }

            .information-card {
                padding: 18px;
            }
        }

        @media (max-width: 420px) {
            .tracking-page {
                padding: 22px 12px 35px;
            }

            .detail-row {
                gap: 10px;
            }

            .detail-value {
                max-width: 58%;
            }

            .tracking-actions {
                flex-direction: column;
            }

            .action-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="tracking-page">
        <header class="tracking-header">
            <a href="{{ route('orders') }}" class="back-link">
                <span aria-hidden="true">←</span>
                Back to My Orders
            </a>

            <h1>📦 Order Tracking</h1>
            <p>Track your order from preparation to delivery.</p>
        </header>

        <section class="order-summary" aria-label="Order summary">
            <div class="summary-item">
                <span class="summary-label">Order Number</span>
                <span class="summary-value">
                    #{{ $order->order_number ?? $order->id }}
                </span>
            </div>

            <div class="summary-item">
                <span class="summary-label">Order Status</span>
                <span class="status-badge {{ $isDelivered ? 'delivered' : ($isCancelled ? 'cancelled' : '') }}">
                    {{ $statusLabels[$orderStatus] ?? $currentStatusLabel }}
                </span>
            </div>

            <div class="summary-item">
                <span class="summary-label">Order Total</span>
                <span class="summary-value">
                    ₱{{ number_format((float) ($order->total ?? 0), 2) }}
                </span>
            </div>
        </section>

        <div class="tracking-container">
            <div class="tracking-main">

                {{-- DELIVERY PROGRESS --}}
                <section class="information-card">
                    <h2>🚚 Delivery Progress</h2>

                    @if ($isCancelled)
                        <div class="cancelled-notice">
                            <strong>Order Cancelled</strong><br>
                            This order has been cancelled. If you have questions about the cancellation or payment, please contact Andrea's Pizza.
                        </div>
                    @else
                        <div class="timeline">
                            @foreach ($timeline as $index => $step)
                                @php
                                    $stepCompleted = in_array($orderStatus, $step['statuses'], true)
                                        || in_array($deliveryStatus, $step['statuses'], true);

                                    if ($index === 0) {
                                        $stepCompleted = true;
                                    }
                                @endphp

                                <div class="timeline-item {{ $stepCompleted ? 'completed' : '' }}">
                                    <div class="timeline-marker-column">
                                        <div class="timeline-marker">
                                            @if ($stepCompleted)
                                                ✓
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>

                                        @if ($index < count($timeline) - 1)
                                            <div class="timeline-line"></div>
                                        @endif
                                    </div>

                                    <div class="timeline-content">
                                        <h3>{{ $step['label'] }}</h3>
                                        <p>{{ $step['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- DELIVERY INFORMATION (NO PROOF PHOTO HERE) --}}
                <section class="information-card">
                    <h2>🛵 Delivery Information</h2>

                    <div class="detail-list">
                        <div class="detail-row">
                            <span class="detail-label">Delivery Status</span>
                            <span class="detail-value">
                                {{ $statusLabels[$deliveryStatus] ?? ucfirst(str_replace('_', ' ', $deliveryStatus)) }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Rider Name</span>
                            <span class="detail-value">{{ $riderName }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Rider Contact</span>
                            <span class="detail-value">{{ $riderContact }}</span>
                        </div>

                        @if ($delivery?->picked_up_at)
                            <div class="detail-row">
                                <span class="detail-label">Picked Up At</span>
                                <span class="detail-value">
                                    {{ \Illuminate\Support\Carbon::parse($delivery->picked_up_at)->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        @endif

                        @if ($delivery?->delivered_at)
                            <div class="detail-row">
                                <span class="detail-label">Delivered At</span>
                                <span class="detail-value">
                                    {{ \Illuminate\Support\Carbon::parse($delivery->delivered_at)->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        @endif

                        @if ($delivery?->notes)
                            <div class="detail-row">
                                <span class="detail-label">Delivery Notes</span>
                                <span class="detail-value">{{ $delivery->notes }}</span>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <aside class="tracking-sidebar">

                {{-- PAYMENT INFORMATION --}}
                <section class="information-card">
                    <h2>💳 Payment Information</h2>

                    <div class="detail-list">
                        <div class="detail-row">
                            <span class="detail-label">Payment Method</span>
                            <span class="detail-value">
                                {{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Payment Status</span>
                            <span class="detail-value">
                                {{ $paymentStatusLabel }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Order Total</span>
                            <span class="detail-value">
                                ₱{{ number_format((float) ($order->total ?? 0), 2) }}
                            </span>
                        </div>

                        @if ($payment?->paid_at)
                            <div class="detail-row">
                                <span class="detail-label">Paid At</span>
                                <span class="detail-value">
                                    {{ \Illuminate\Support\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="payment-note">
                        If you have questions about your payment or delivery, please contact Andrea's Pizza.
                    </div>
                </section>

                {{-- ORDER ITEMS --}}
                <section class="information-card">
                    <h2>🍕 Order Summary</h2>

                    <div class="detail-list">
                        @forelse ($order->orderItems ?? [] as $item)
                            <div class="detail-row">
                                <span class="detail-label">
                                    {{ $item->pizza?->name ?? $item->name ?? 'Pizza' }}
                                    × {{ $item->quantity ?? 1 }}
                                </span>

                                <span class="detail-value">
                                    ₱{{ number_format(
                                        (float) ($item->price ?? 0) * (int) ($item->quantity ?? 1),
                                        2
                                    ) }}
                                </span>
                            </div>
                        @empty
                            <p style="color: #777; font-size: 13px;">
                                No order items are available.
                            </p>
                        @endforelse

                        <div class="detail-row">
                            <span class="detail-label"><strong>Total</strong></span>
                            <span class="detail-value">
                                ₱{{ number_format((float) ($order->total ?? 0), 2) }}
                            </span>
                        </div>
                    </div>
                </section>
            </aside>
        </div>

        <div class="tracking-actions">
            <a href="{{ route('orders') }}" class="action-button secondary">
                ← Back to My Orders
            </a>

            <a href="{{ route('menu') }}" class="action-button">
                Order More Pizza 🍕
            </a>
        </div>
    </main>

    <footer class="tracking-footer">
        © {{ date('Y') }} Abuyog Andrea Pizza. All rights reserved.
    </footer>
</body>
</html>