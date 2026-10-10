
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number ?? $order->id }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            background: #f1f5f1;
            color: #222;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .receipt {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            padding: 35px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .receipt-header {
            padding-bottom: 22px;
            text-align: center;
            border-bottom: 2px dashed #198754;
        }

        .receipt-header h1 {
            margin: 0 0 8px;
            color: #198754;
            font-size: 27px;
        }

        .receipt-header p {
            margin: 5px 0;
            color: #666;
        }

        .receipt-title {
            margin: 22px 0;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            margin-bottom: 25px;
        }

        .detail-label {
            display: block;
            margin-bottom: 4px;
            color: #777;
            font-size: 12px;
        }

        .detail-value {
            overflow-wrap: anywhere;
            font-weight: 600;
        }

        .section-title {
            margin: 22px 0 12px;
            font-size: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 8px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f0f7f2;
            color: #245c3b;
            font-size: 12px;
        }

        .number {
            text-align: right;
            white-space: nowrap;
        }

        .totals {
            width: 100%;
            max-width: 340px;
            margin: 20px 0 0 auto;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 8px 0;
        }

        .grand-total {
            margin-top: 8px;
            padding-top: 14px;
            border-top: 2px solid #198754;
            color: #198754;
            font-size: 20px;
            font-weight: bold;
        }

        .notes {
            margin-top: 24px;
            padding: 12px;
            background: #f8faf8;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow-wrap: anywhere;
        }

        .receipt-footer {
            margin-top: 32px;
            padding-top: 18px;
            border-top: 2px dashed #ccc;
            text-align: center;
            color: #666;
            line-height: 1.7;
        }

        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 0 auto 20px;
        }

        .receipt-actions button,
        .receipt-actions a {
            display: inline-block;
            padding: 11px 18px;
            border: 0;
            border-radius: 7px;
            background: #198754;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .receipt-actions a {
            background: #555;
        }

        @media (max-width: 550px) {
            body {
                padding: 10px;
            }

            .receipt {
                padding: 18px;
            }

            .details {
                grid-template-columns: 1fr;
            }

            th, td {
                padding: 9px 5px;
                font-size: 12px;
            }
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                padding: 0;
                background: #fff;
                font-size: 12px;
            }

            .receipt {
                max-width: none;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .receipt-actions {
                display: none !important;
            }

            .receipt-header,
            .section-title,
            table,
            .totals,
            .notes {
                break-inside: avoid;
            }

            thead {
                display: table-header-group;
            }

            tr {
                break-inside: avoid;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-actions">
        <button type="button" onclick="window.print()">
            🖨️ Print Receipt
        </button>

        <a href="{{ route('admin.orders.show', $order->id) }}">
            ← Back to Order
        </a>
    </div>

    <main class="receipt">

        <header class="receipt-header">
            <h1>🍕 Abuyog Andrea Pizza</h1>
            <p>Order Receipt</p>
            <p>Thank you for ordering with us!</p>
        </header>

        <div class="receipt-title">ORDER RECEIPT</div>

        <section class="details">
            <div>
                <span class="detail-label">Order Number</span>
                <span class="detail-value">
                    {{ $order->order_number ?? ('ORD-' . $order->id) }}
                </span>
            </div>

            <div>
                <span class="detail-label">Order Date</span>
                <span class="detail-value">
                    {{ $order->created_at?->format('M d, Y h:i A') ?? 'N/A' }}
                </span>
            </div>

            <div>
                <span class="detail-label">Customer</span>
                <span class="detail-value">
                    {{ $order->user->name ?? 'Customer' }}
                </span>
            </div>

            <div>
                <span class="detail-label">Contact Number</span>
                <span class="detail-value">
                    {{ $order->contact_number ?? 'N/A' }}
                </span>
            </div>

            <div>
                <span class="detail-label">Order Status</span>
                <span class="detail-value">
                    {{ ucwords(str_replace('_', ' ', $order->status ?? 'pending')) }}
                </span>
            </div>

            <div>
                <span class="detail-label">Order Type</span>
                <span class="detail-value">
                    {{ ucwords(str_replace('_', ' ', $order->delivery_option ?? 'N/A')) }}
                </span>
            </div>

            <div>
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">
                    {{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                </span>
            </div>

            <div>
                <span class="detail-label">Payment Status</span>
                <span class="detail-value">
                    {{ ucwords(str_replace('_', ' ', $order->payment->status ?? 'pending')) }}
                </span>
            </div>
        </section>

        @if(($order->delivery_option ?? '') === 'delivery')
            <div class="section-title">Delivery Address</div>
            <p>{{ $order->delivery_address ?? 'No delivery address provided.' }}</p>
        @endif

        <div class="section-title">Ordered Items</div>

        <table>
            <thead>
                <tr>
                    <th>Pizza</th>
                    <th class="number">Price</th>
                    <th class="number">Qty</th>
                    <th class="number">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse($order->orderItems as $item)
                    @php
                        $pizzaName = $item->pizza->name
                            ?? $item->pizza->pizza_name
                            ?? 'Pizza';

                        $quantity = (int) ($item->quantity ?? 0);
                        $price = (float) ($item->price ?? 0);
                        $lineTotal = $price * $quantity;
                    @endphp

                    <tr>
                        <td>{{ $pizzaName }}</td>
                        <td class="number">₱{{ number_format($price, 2) }}</td>
                        <td class="number">{{ $quantity }}</td>
                        <td class="number">₱{{ number_format($lineTotal, 2) }}</td>
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

        @php
            $subtotal = (float) ($order->subtotal ?? 0);
            $deliveryFee = (float) ($order->delivery_fee ?? 0);
            $totalAmount = (float) ($order->total_amount ?? 0);
        @endphp

        <section class="totals">
            <div class="total-row">
                <span>Subtotal</span>
                <strong>₱{{ number_format($subtotal, 2) }}</strong>
            </div>

            <div class="total-row">
                <span>Delivery Fee</span>
                <strong>₱{{ number_format($deliveryFee, 2) }}</strong>
            </div>

            <div class="total-row grand-total">
                <span>Total</span>
                <span>₱{{ number_format($totalAmount, 2) }}</span>
            </div>
        </section>

        @if(!empty($order->notes))
            <div class="notes">
                <strong>Order Notes:</strong><br>
                {{ $order->notes }}
            </div>
        @endif

        @if($order->payment)
            <div class="section-title">Payment Information</div>

            @if(!empty($order->payment->reference_number))
                <p>
                    <strong>Reference Number:</strong>
                    {{ $order->payment->reference_number }}
                </p>
            @endif

            @if(isset($order->payment->amount))
                <p>
                    <strong>Payment Amount:</strong>
                    ₱{{ number_format((float) $order->payment->amount, 2) }}
                </p>
            @endif
        @endif

        <footer class="receipt-footer">
            <strong>Thank you for choosing Abuyog Andrea Pizza!</strong><br>
            Please keep this receipt for your records.<br>
            <small>Generated on {{ now()->format('M d, Y h:i A') }}</small>
        </footer>

    </main>

</body>
</html>