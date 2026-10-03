@extends('admin.layout')

@section('title', 'Payments')

@section('content')

<div class="page-header">

    <div>

        <h1>💳 Payments</h1>

        <p>
            Monitor all payment transactions.
        </p>

    </div>

</div>


<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Order</th>
                    <th>Customer</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Reference</th>

                </tr>

            </thead>

            <tbody>

                @forelse($payments as $payment)

                    <tr>

                        <td>
                            {{ $payment->order->order_number ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $payment->order->user->name ?? 'Customer' }}
                        </td>

                        <td>

                            @if($payment->method === 'gcash')

                                📱 GCash

                            @else

                                💵 Cash

                            @endif

                        </td>

                        <td>

                            <strong style="color:#15803d">

                                ₱{{ number_format($payment->amount, 2) }}

                            </strong>

                        </td>

                        <td>

                            <span
                                class="status
                                {{ $payment->status === 'paid'
                                    ? 'delivered'
                                    : ($payment->status === 'failed'
                                        ? 'cancelled'
                                        : 'pending') }}"
                            >

                                {{ $payment->status }}

                            </span>

                        </td>

                        <td>

                            {{ $payment->reference_number ?? '—' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center"
                        >
                            No payments found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection