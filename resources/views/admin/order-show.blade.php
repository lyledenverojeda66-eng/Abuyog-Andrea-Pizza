
@extends('admin.layout')

@section('content')
<style>
    .order-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
        color: #1f2937;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .order-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
    }

    .order-subtitle {
        margin-top: 6px;
        color: #6b7280;
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .back-btn {
        display: inline-block;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .back-btn:hover {
        background: #f9fafb;
    }

    .order-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(300px, 1fr);
        gap: 20px;
        align-items: start;
    }

    .order-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }

    .order-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .order-card-title {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .order-card-title h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 750;
    }

    .order-card-body {
        padding: 20px;
    }

    .info-row,
    .side-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding: 11px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child,
    .side-row:last-child {
        border-bottom: none;
    }

    .info-label,
    .side-label {
        color: #6b7280;
        font-size: 13px;
        flex-shrink: 0;
    }

    .info-value,
    .side-value {
        text-align: right;
        font-size: 13px;
        font-weight: 650;
        overflow-wrap: anywhere;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 750;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-preparing {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .status-ready_for_delivery {
        background: #e0f2fe;
        color: #075985;
    }

    .status-out_for_delivery {
        background: #ffedd5;
        color: #9a3412;
    }

    .status-delivered {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .items-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table th,
    .items-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        font-size: 13px;
    }

    .items-table th {
        color: #6b7280;
        background: #f9fafb;
        font-weight: 700;
    }

    .items-table td:last-child,
    .items-table th:last-child {
        text-align: right;
    }

    .items-table tr:last-child td {
        border-bottom: none;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 9px 0;
        font-size: 14px;
    }

    .grand-total {
        margin-top: 8px;
        padding-top: 14px;
        border-top: 2px solid #e5e7eb;
        font-size: 18px;
        font-weight: 800;
    }

    .status-buttons {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .status-buttons form {
        margin: 0;
        min-width: 0;
    }

    .status-button {
        width: 100%;
        min-height: 44px;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .status-button:hover:not(:disabled) {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .status-button:disabled {
        cursor: default;
        opacity: 1;
    }

    .status-btn-pending.status-active {
        background: #fef3c7;
        color: #92400e;
        border-color: #f59e0b;
    }

    .status-btn-confirmed.status-active {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #60a5fa;
    }

    .status-btn-preparing.status-active {
        background: #f3e8ff;
        color: #7e22ce;
        border-color: #c084fc;
    }

    .status-btn-ready_for_delivery.status-active {
        background: #e0f2fe;
        color: #075985;
        border-color: #38bdf8;
    }

    .status-btn-out_for_delivery.status-active {
        background: #ffedd5;
        color: #9a3412;
        border-color: #fb923c;
    }

    .status-btn-delivered.status-active {
        background: #dcfce7;
        color: #166534;
        border-color: #4ade80;
    }

    .status-btn-cancelled.status-active {
        background: #fee2e2;
        color: #991b1b;
        border-color: #f87171;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 12px 16px;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 13px;
        font-weight: 750;
        text-align: center;
        cursor: pointer;
    }

    .btn-success {
        background: #16a34a;
    }

    .btn-success:hover {
        background: #15803d;
    }

    .help-text {
        margin: 9px 0 0;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.5;
    }

    .payment-approval {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .notes-box {
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        color: #4b5563;
        font-size: 13px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .alert {
        margin-bottom: 20px;
        padding: 13px 16px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-success {
        color: #166534;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        color: #991b1b;
        background: #fee2e2;
        border: 1px solid #fecaca;
    }

    #print-order-summary {
        display: none;
    }

    @media (max-width: 900px) {
        .order-grid {
            grid-template-columns: 1fr;
        }

        .order-page {
            padding: 14px;
        }
    }

    @media (max-width: 420px) {
        .status-buttons {
            grid-template-columns: 1fr;
        }

        .info-row,
        .side-row {
            gap: 10px;
        }
    }

    @media print {
        @page {
            size: A4;
            margin: 12mm;
        }

        body * {
            visibility: hidden !important;
        }

        #print-order-summary,
        #print-order-summary * {
            visibility: visible !important;
        }

        #print-order-summary {
            display: block !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            color: #111 !important;
            background: #fff !important;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        #print-order-summary h1 {
            margin: 0 0 6px;
            font-size: 23px;
            text-align: center;
        }

        #print-order-summary h2 {
            margin: 0 0 8px;
            font-size: 17px;
            text-align: center;
        }

        #print-order-summary .print-header {
            text-align: center;
        }

        #print-order-summary h3 {
            margin: 15px 0 8px;
            font-size: 14px;
        }

        #print-order-summary p {
            margin: 6px 0;
            overflow-wrap: anywhere;
        }

        .print-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .print-items-table th,
        .print-items-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .print-items-table th {
            background: #f3f4f6 !important;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .print-totals {
            width: 300px;
            max-width: 100%;
            margin: 12px 0 0 auto;
        }

        .print-totals p {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .print-grand-total {
            padding-top: 8px;
            border-top: 2px solid #111;
            font-size: 15px;
        }

        .print-footer {
            margin-top: 30px;
            text-align: center;
            font-weight: bold;
        }
    }
</style>

@php
    $payment = $order->payment;

    $paymentMethod = strtolower(trim(
        $payment->method ?? $order->payment_method ?? ''
    ));

    $paymentStatus = strtolower(trim($payment->status ?? 'pending'));

    $isGcash = $paymentMethod === 'gcash';

    $isCod = in_array($paymentMethod, [
        'cash_on_delivery',
        'cod',
        'cash on delivery',
    ], true);

    $statusLabels = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'preparing' => 'Preparing',
        'ready_for_delivery' => 'Ready for Delivery',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="order-page">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="order-header">
        <div>
            <h1>Order Details</h1>
            <div class="order-subtitle">
                Order #{{ $order->order_number ?? $order->id }}
            </div>
        </div>

        <div class="header-actions">
            <a href="{{ route('admin.orders') }}" class="back-btn">
                ← Back to Orders
            </a>

            <button
                type="button"
                class="back-btn"
                onclick="printOrderSummary()"
            >
                🖨️ Print Order
            </button>
        </div>
    </div>

    <div class="order-grid">

        {{-- LEFT COLUMN --}}
        <div class="order-column">

            {{-- ORDER INFORMATION --}}
            <div class="order-card">
                <div class="order-card-title">
                    <h2>📋 Order Information</h2>
                </div>

                <div class="order-card-body">
                    <div class="info-row">
                        <span class="info-label">Order Number</span>
                        <span class="info-value">
                            {{ $order->order_number ?? $order->id }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Customer</span>
                        <span class="info-value">
                            {{ $order->user->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">
                            {{ $order->user->email ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Contact Number</span>
                        <span class="info-value">
                            {{ $order->contact_number ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">
                            {{ $order->created_at
                                ? $order->created_at->format('M d, Y h:i A')
                                : 'N/A' }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Status</span>
                        <span class="info-value">
                            <span class="badge status-{{ $order->status }}">
                                {{ $statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Delivery Address</span>
                        <span class="info-value">
                            {{ $order->delivery_address ?? 'N/A' }}
                        </span>
                    </div>

                    @if($order->notes)
                        <div style="margin-top:16px;">
                            <strong style="display:block;margin-bottom:8px;font-size:13px;">
                                Order Notes
                            </strong>

                            <div class="notes-box">
                                {{ $order->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ORDER ITEMS --}}
            <div class="order-card">
                <div class="order-card-title">
                    <h2>🍕 Order Items</h2>
                </div>

                <div class="items-table-wrap">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($order->orderItems as $item)
                                <tr>
                                    <td>
                                        {{ $item->pizza->name ?? $item->name ?? 'Pizza' }}
                                    </td>

                                    <td>{{ $item->quantity }}</td>

                                    <td>
                                        ₱{{ number_format($item->price, 2) }}
                                    </td>

                                    <td>
                                        ₱{{ number_format(
                                            $item->subtotal ?? ($item->quantity * $item->price),
                                            2
                                        ) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">
                                        No order items found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="order-card-body">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <strong>
                            ₱{{ number_format($order->subtotal ?? 0, 2) }}
                        </strong>
                    </div>

                    <div class="total-row">
                        <span>Delivery Fee</span>
                        <strong>
                            ₱{{ number_format($order->delivery_fee ?? 0, 2) }}
                        </strong>
                    </div>

                    <div class="total-row grand-total">
                        <span>Total Amount</span>
                        <span>
                            ₱{{ number_format($order->total_amount ?? 0, 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="order-column">

            {{-- UPDATE ORDER STATUS --}}
            <div class="order-card">
                <div class="order-card-title">
                    <h2>⚙️ Update Order Status</h2>
                </div>

                <div class="order-card-body">
                    <p style="margin:0 0 14px;color:#6b7280;font-size:13px;">
                        Select the new order status.
                    </p>

                    <div class="status-buttons">
                        @foreach($statusLabels as $value => $label)
                            <form
                                action="{{ route('admin.orders.status', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Change order status to {{ $label }}?');"
                            >
                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="{{ $value }}"
                                >

                                <button
                                    type="submit"
                                    class="status-button status-btn-{{ $value }} {{ $order->status === $value ? 'status-active' : '' }}"
                                    {{ $order->status === $value ? 'disabled' : '' }}
                                >
                                    {{ $label }}

                                    @if($order->status === $value)
                                        ✓ Current
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PAYMENT INFORMATION --}}
            <div class="order-card">
                <div class="order-card-title">
                    <h2>💳 Payment Information</h2>
                </div>

                <div class="order-card-body">
                    @if($payment)

                        <div class="side-row">
                            <span class="side-label">Amount</span>
                            <span class="side-value">
                                ₱{{ number_format($payment->amount ?? 0, 2) }}
                            </span>
                        </div>

                        <div class="side-row">
                            <span class="side-label">Payment Method</span>
                            <span class="side-value">
                                @if($isGcash)
                                    📱 GCash
                                @elseif($isCod)
                                    💵 Cash on Delivery
                                @elseif($paymentMethod === 'cash_on_pickup')
                                    💵 Cash on Pickup
                                @else
                                    {{ ucwords(str_replace('_', ' ', $paymentMethod ?: 'N/A')) }}
                                @endif
                            </span>
                        </div>

                        <div class="side-row">
                            <span class="side-label">Payment Status</span>
                            <span class="side-value">
                                @if($paymentStatus === 'paid')
                                    <span class="badge" style="background:#dcfce7;color:#166534;">
                                        ✓ Paid
                                    </span>
                                @elseif($paymentStatus === 'failed')
                                    <span class="badge" style="background:#fee2e2;color:#991b1b;">
                                        ✕ Failed
                                    </span>
                                @else
                                    <span class="badge" style="background:#fef3c7;color:#92400e;">
                                        ⏳ Pending Approval
                                    </span>
                                @endif
                            </span>
                        </div>

                        @if($payment->reference_number)
                            <div class="side-row">
                                <span class="side-label">Reference Number</span>
                                <span class="side-value">
                                    {{ $payment->reference_number }}
                                </span>
                            </div>
                        @endif

                        @if($payment->paid_at)
                            <div class="side-row">
                                <span class="side-label">Paid At</span>
                                <span class="side-value">
                                    {{ $payment->paid_at->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        @endif

                        {{-- ADMIN APPROVAL: GCASH ONLY --}}
                        @if(
                            $isGcash &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed' &&
                            $order->status === 'ready_for_delivery'
                        )
                            <div class="payment-approval">
                                <form
                                    action="{{ route('admin.orders.approve-payment', $order->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Have you verified the GCash payment? Approve this payment?');"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success">
                                        ✓ Approve GCash Payment
                                    </button>
                                </form>

                                <p class="help-text">
                                    Verify the GCash reference number before approving the payment.
                                </p>
                            </div>

                        {{-- COD: RIDER MUST CONFIRM CASH RECEIPT --}}
                        @elseif(
                            $isCod &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed'
                        )
                            <div class="payment-approval">
                                <p class="help-text">
                                    The rider must confirm that the cash has been received before the COD payment can be marked as paid.
                                </p>
                            </div>

                        @elseif(
                            $isGcash &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed' &&
                            $order->status !== 'cancelled'
                        )
                            <p class="help-text">
                                GCash payment approval is available when the order is
                                <strong>Ready for Delivery</strong>.
                            </p>
                        @endif

                    @else
                        <p style="margin:0;color:#6b7280;font-size:13px;">
                            No payment record found for this order.
                        </p>
                    @endif
                </div>
            </div>

            {{-- DELIVERY INFORMATION --}}
            <div class="order-card">
                <div class="order-card-title">
                    <h2>🚚 Delivery Information</h2>
                </div>

                <div class="order-card-body">
                    <div class="side-row">
                        <span class="side-label">Delivery Method</span>
                        <span class="side-value">
                            {{ ucwords(str_replace(
                                '_',
                                ' ',
                                $order->delivery_option ?? $order->delivery_method ?? 'N/A'
                            )) }}
                        </span>
                    </div>

                    <div class="side-row">
                        <span class="side-label">Address</span>
                        <span class="side-value">
                            {{ $order->delivery_address ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="side-row">
                        <span class="side-label">Contact Number</span>
                        <span class="side-value">
                            {{ $order->contact_number ?? 'N/A' }}
                        </span>
                    </div>

                    @if($order->delivery && $order->delivery->picked_up_at)
                        <div class="side-row">
                            <span class="side-label">Picked Up At</span>
                            <span class="side-value">
                                {{ $order->delivery->picked_up_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                    @endif

                    @if($order->delivery && $order->delivery->delivered_at)
                        <div class="side-row">
                            <span class="side-label">Delivered At</span>
                            <span class="side-value">
                                {{ $order->delivery->delivered_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- PRINT-ONLY ORDER SUMMARY --}}
<div id="print-order-summary">
    <div class="print-header">
        <h1>Abuyog Andrea Pizza</h1>
        <h2>Order Summary</h2>

        <p>
            <strong>Order Number:</strong>
            {{ $order->order_number ?? $order->id }}
        </p>

        <p>
            <strong>Date:</strong>
            {{ $order->created_at
                ? $order->created_at->format('M d, Y h:i A')
                : 'N/A' }}
        </p>
    </div>

    <hr>

    <h3>Customer Information</h3>

    <p>
        <strong>Customer:</strong>
        {{ $order->user->name ?? 'N/A' }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $order->user->email ?? 'N/A' }}
    </p>

    <p>
        <strong>Contact Number:</strong>
        {{ $order->contact_number ?? 'N/A' }}
    </p>

    <p>
        <strong>Delivery Address:</strong>
        {{ $order->delivery_address ?? 'N/A' }}
    </p>

    <hr>

    <h3>Ordered Items</h3>

    <table class="print-items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @forelse($order->orderItems as $item)
                <tr>
                    <td>
                        {{ $item->pizza->name ?? $item->name ?? 'Pizza' }}
                    </td>

                    <td>{{ $item->quantity }}</td>

                    <td>
                        ₱{{ number_format($item->price, 2) }}
                    </td>

                    <td>
                        ₱{{ number_format(
                            $item->subtotal ?? ($item->quantity * $item->price),
                            2
                        ) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="print-totals">
        <p>
            <span>Subtotal</span>
            <strong>
                ₱{{ number_format($order->subtotal ?? 0, 2) }}
            </strong>
        </p>

        <p>
            <span>Delivery Fee</span>
            <strong>
                ₱{{ number_format($order->delivery_fee ?? 0, 2) }}
            </strong>
        </p>

        <p class="print-grand-total">
            <span>Total Amount</span>
            <strong>
                ₱{{ number_format($order->total_amount ?? 0, 2) }}
            </strong>
        </p>
    </div>

    <hr>

    <h3>Payment Information</h3>

    <p>
        <strong>Payment Method:</strong>
        @if($isGcash)
            GCash
        @elseif($isCod)
            Cash on Delivery
        @else
            {{ ucwords(str_replace('_', ' ', $paymentMethod ?: 'N/A')) }}
        @endif
    </p>

    <p>
        <strong>Payment Status:</strong>
        {{ $paymentStatus === 'paid'
            ? 'Paid'
            : ($paymentStatus === 'failed' ? 'Failed' : 'Pending Approval') }}
    </p>

    @if($payment && $payment->reference_number)
        <p>
            <strong>Reference Number:</strong>
            {{ $payment->reference_number }}
        </p>
    @endif

    <p>
        <strong>Order Status:</strong>
        {{ $statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
    </p>

    @if($order->notes)
        <p><strong>Order Notes:</strong> {{ $order->notes }}</p>
    @endif

    <div class="print-footer">
        Thank you for ordering from Abuyog Andrea Pizza!
    </div>
</div>

<script>
    function printOrderSummary() {
        window.print();
    }
</script>
@endsection