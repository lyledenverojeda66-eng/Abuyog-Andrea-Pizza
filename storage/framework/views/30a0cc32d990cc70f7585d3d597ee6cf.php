


<?php $__env->startSection('content'); ?>
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

<?php
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
?>

<div class="order-page">

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            ✓ <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="order-header">
        <div>
            <h1>Order Details</h1>
            <div class="order-subtitle">
                Order #<?php echo e($order->order_number ?? $order->id); ?>

            </div>
        </div>

        <div class="header-actions">
            <a href="<?php echo e(route('admin.orders')); ?>" class="back-btn">
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

        
        <div class="order-column">

            
            <div class="order-card">
                <div class="order-card-title">
                    <h2>📋 Order Information</h2>
                </div>

                <div class="order-card-body">
                    <div class="info-row">
                        <span class="info-label">Order Number</span>
                        <span class="info-value">
                            <?php echo e($order->order_number ?? $order->id); ?>

                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Customer</span>
                        <span class="info-value">
                            <?php echo e($order->user->name ?? 'N/A'); ?>

                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">
                            <?php echo e($order->user->email ?? 'N/A'); ?>

                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Contact Number</span>
                        <span class="info-value">
                            <?php echo e($order->contact_number ?? 'N/A'); ?>

                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">
                            <?php echo e($order->created_at
                                ? $order->created_at->format('M d, Y h:i A')
                                : 'N/A'); ?>

                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Status</span>
                        <span class="info-value">
                            <span class="badge status-<?php echo e($order->status); ?>">
                                <?php echo e($statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status))); ?>

                            </span>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Delivery Address</span>
                        <span class="info-value">
                            <?php echo e($order->delivery_address ?? 'N/A'); ?>

                        </span>
                    </div>

                    <?php if($order->notes): ?>
                        <div style="margin-top:16px;">
                            <strong style="display:block;margin-bottom:8px;font-size:13px;">
                                Order Notes
                            </strong>

                            <div class="notes-box">
                                <?php echo e($order->notes); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
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
                            <?php $__empty_1 = true; $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php echo e($item->pizza->name ?? $item->name ?? 'Pizza'); ?>

                                    </td>

                                    <td><?php echo e($item->quantity); ?></td>

                                    <td>
                                        ₱<?php echo e(number_format($item->price, 2)); ?>

                                    </td>

                                    <td>
                                        ₱<?php echo e(number_format(
                                            $item->subtotal ?? ($item->quantity * $item->price),
                                            2
                                        )); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" style="text-align:center;">
                                        No order items found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="order-card-body">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <strong>
                            ₱<?php echo e(number_format($order->subtotal ?? 0, 2)); ?>

                        </strong>
                    </div>

                    <div class="total-row">
                        <span>Delivery Fee</span>
                        <strong>
                            ₱<?php echo e(number_format($order->delivery_fee ?? 0, 2)); ?>

                        </strong>
                    </div>

                    <div class="total-row grand-total">
                        <span>Total Amount</span>
                        <span>
                            ₱<?php echo e(number_format($order->total_amount ?? 0, 2)); ?>

                        </span>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="order-column">

            
            <div class="order-card">
                <div class="order-card-title">
                    <h2>⚙️ Update Order Status</h2>
                </div>

                <div class="order-card-body">
                    <p style="margin:0 0 14px;color:#6b7280;font-size:13px;">
                        Select the new order status.
                    </p>

                    <div class="status-buttons">
                        <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form
                                action="<?php echo e(route('admin.orders.status', $order->id)); ?>"
                                method="POST"
                                onsubmit="return confirm('Change order status to <?php echo e($label); ?>?');"
                            >
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>

                                <input
                                    type="hidden"
                                    name="status"
                                    value="<?php echo e($value); ?>"
                                >

                                <button
                                    type="submit"
                                    class="status-button status-btn-<?php echo e($value); ?> <?php echo e($order->status === $value ? 'status-active' : ''); ?>"
                                    <?php echo e($order->status === $value ? 'disabled' : ''); ?>

                                >
                                    <?php echo e($label); ?>


                                    <?php if($order->status === $value): ?>
                                        ✓ Current
                                    <?php endif; ?>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
            <div class="order-card">
                <div class="order-card-title">
                    <h2>💳 Payment Information</h2>
                </div>

                <div class="order-card-body">
                    <?php if($payment): ?>

                        <div class="side-row">
                            <span class="side-label">Amount</span>
                            <span class="side-value">
                                ₱<?php echo e(number_format($payment->amount ?? 0, 2)); ?>

                            </span>
                        </div>

                        <div class="side-row">
                            <span class="side-label">Payment Method</span>
                            <span class="side-value">
                                <?php if($isGcash): ?>
                                    📱 GCash
                                <?php elseif($isCod): ?>
                                    💵 Cash on Delivery
                                <?php elseif($paymentMethod === 'cash_on_pickup'): ?>
                                    💵 Cash on Pickup
                                <?php else: ?>
                                    <?php echo e(ucwords(str_replace('_', ' ', $paymentMethod ?: 'N/A'))); ?>

                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="side-row">
                            <span class="side-label">Payment Status</span>
                            <span class="side-value">
                                <?php if($paymentStatus === 'paid'): ?>
                                    <span class="badge" style="background:#dcfce7;color:#166534;">
                                        ✓ Paid
                                    </span>
                                <?php elseif($paymentStatus === 'failed'): ?>
                                    <span class="badge" style="background:#fee2e2;color:#991b1b;">
                                        ✕ Failed
                                    </span>
                                <?php else: ?>
                                    <span class="badge" style="background:#fef3c7;color:#92400e;">
                                        ⏳ Pending Approval
                                    </span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <?php if($payment->reference_number): ?>
                            <div class="side-row">
                                <span class="side-label">Reference Number</span>
                                <span class="side-value">
                                    <?php echo e($payment->reference_number); ?>

                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if($payment->paid_at): ?>
                            <div class="side-row">
                                <span class="side-label">Paid At</span>
                                <span class="side-value">
                                    <?php echo e($payment->paid_at->format('M d, Y h:i A')); ?>

                                </span>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(
                            $isGcash &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed' &&
                            $order->status === 'ready_for_delivery'
                        ): ?>
                            <div class="payment-approval">
                                <form
                                    action="<?php echo e(route('admin.orders.approve-payment', $order->id)); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Have you verified the GCash payment? Approve this payment?');"
                                >
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <button type="submit" class="btn btn-success">
                                        ✓ Approve GCash Payment
                                    </button>
                                </form>

                                <p class="help-text">
                                    Verify the GCash reference number before approving the payment.
                                </p>
                            </div>

                        
                        <?php elseif(
                            $isCod &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed'
                        ): ?>
                            <div class="payment-approval">
                                <p class="help-text">
                                    The rider must confirm that the cash has been received before the COD payment can be marked as paid.
                                </p>
                            </div>

                        <?php elseif(
                            $isGcash &&
                            $paymentStatus !== 'paid' &&
                            $paymentStatus !== 'failed' &&
                            $order->status !== 'cancelled'
                        ): ?>
                            <p class="help-text">
                                GCash payment approval is available when the order is
                                <strong>Ready for Delivery</strong>.
                            </p>
                        <?php endif; ?>

                    <?php else: ?>
                        <p style="margin:0;color:#6b7280;font-size:13px;">
                            No payment record found for this order.
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="order-card">
                <div class="order-card-title">
                    <h2>🚚 Delivery Information</h2>
                </div>

                <div class="order-card-body">
                    <div class="side-row">
                        <span class="side-label">Delivery Method</span>
                        <span class="side-value">
                            <?php echo e(ucwords(str_replace(
                                '_',
                                ' ',
                                $order->delivery_option ?? $order->delivery_method ?? 'N/A'
                            ))); ?>

                        </span>
                    </div>

                    <div class="side-row">
                        <span class="side-label">Address</span>
                        <span class="side-value">
                            <?php echo e($order->delivery_address ?? 'N/A'); ?>

                        </span>
                    </div>

                    <div class="side-row">
                        <span class="side-label">Contact Number</span>
                        <span class="side-value">
                            <?php echo e($order->contact_number ?? 'N/A'); ?>

                        </span>
                    </div>

                    <?php if($order->delivery && $order->delivery->picked_up_at): ?>
                        <div class="side-row">
                            <span class="side-label">Picked Up At</span>
                            <span class="side-value">
                                <?php echo e($order->delivery->picked_up_at->format('M d, Y h:i A')); ?>

                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if($order->delivery && $order->delivery->delivered_at): ?>
                        <div class="side-row">
                            <span class="side-label">Delivered At</span>
                            <span class="side-value">
                                <?php echo e($order->delivery->delivered_at->format('M d, Y h:i A')); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="print-order-summary">
    <div class="print-header">
        <h1>Abuyog Andrea Pizza</h1>
        <h2>Order Summary</h2>

        <p>
            <strong>Order Number:</strong>
            <?php echo e($order->order_number ?? $order->id); ?>

        </p>

        <p>
            <strong>Date:</strong>
            <?php echo e($order->created_at
                ? $order->created_at->format('M d, Y h:i A')
                : 'N/A'); ?>

        </p>
    </div>

    <hr>

    <h3>Customer Information</h3>

    <p>
        <strong>Customer:</strong>
        <?php echo e($order->user->name ?? 'N/A'); ?>

    </p>

    <p>
        <strong>Email:</strong>
        <?php echo e($order->user->email ?? 'N/A'); ?>

    </p>

    <p>
        <strong>Contact Number:</strong>
        <?php echo e($order->contact_number ?? 'N/A'); ?>

    </p>

    <p>
        <strong>Delivery Address:</strong>
        <?php echo e($order->delivery_address ?? 'N/A'); ?>

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
            <?php $__empty_1 = true; $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php echo e($item->pizza->name ?? $item->name ?? 'Pizza'); ?>

                    </td>

                    <td><?php echo e($item->quantity); ?></td>

                    <td>
                        ₱<?php echo e(number_format($item->price, 2)); ?>

                    </td>

                    <td>
                        ₱<?php echo e(number_format(
                            $item->subtotal ?? ($item->quantity * $item->price),
                            2
                        )); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">No items found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="print-totals">
        <p>
            <span>Subtotal</span>
            <strong>
                ₱<?php echo e(number_format($order->subtotal ?? 0, 2)); ?>

            </strong>
        </p>

        <p>
            <span>Delivery Fee</span>
            <strong>
                ₱<?php echo e(number_format($order->delivery_fee ?? 0, 2)); ?>

            </strong>
        </p>

        <p class="print-grand-total">
            <span>Total Amount</span>
            <strong>
                ₱<?php echo e(number_format($order->total_amount ?? 0, 2)); ?>

            </strong>
        </p>
    </div>

    <hr>

    <h3>Payment Information</h3>

    <p>
        <strong>Payment Method:</strong>
        <?php if($isGcash): ?>
            GCash
        <?php elseif($isCod): ?>
            Cash on Delivery
        <?php else: ?>
            <?php echo e(ucwords(str_replace('_', ' ', $paymentMethod ?: 'N/A'))); ?>

        <?php endif; ?>
    </p>

    <p>
        <strong>Payment Status:</strong>
        <?php echo e($paymentStatus === 'paid'
            ? 'Paid'
            : ($paymentStatus === 'failed' ? 'Failed' : 'Pending Approval')); ?>

    </p>

    <?php if($payment && $payment->reference_number): ?>
        <p>
            <strong>Reference Number:</strong>
            <?php echo e($payment->reference_number); ?>

        </p>
    <?php endif; ?>

    <p>
        <strong>Order Status:</strong>
        <?php echo e($statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status))); ?>

    </p>

    <?php if($order->notes): ?>
        <p><strong>Order Notes:</strong> <?php echo e($order->notes); ?></p>
    <?php endif; ?>

    <div class="print-footer">
        Thank you for ordering from Abuyog Andrea Pizza!
    </div>
</div>

<script>
    function printOrderSummary() {
        window.print();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/order-show.blade.php ENDPATH**/ ?>