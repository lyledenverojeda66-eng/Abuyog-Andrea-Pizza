@extends('admin.layout')

@section('title', 'Deliveries')

@section('content')

<div class="page-header">

    <div>

        <h1>🚚 Deliveries</h1>

        <p>
            Monitor customer deliveries and riders.
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
                    <th>Rider</th>
                    <th>Contact</th>
                    <th>Picked Up</th>
                    <th>Delivered</th>

                </tr>

            </thead>

            <tbody>

                @forelse($deliveries as $delivery)

                    <tr>

                        <td>

                            <strong style="color:#15803d">

                                {{ $delivery->order->order_number ?? 'N/A' }}

                            </strong>

                        </td>

                        <td>

                            {{ $delivery->order->user->name ?? 'Customer' }}

                        </td>

                        <td>

                            {{ $delivery->rider_name ?? 'Not assigned' }}

                        </td>

                        <td>

                            {{ $delivery->rider_contact ?? '—' }}

                        </td>

                        <td>

                            {{ $delivery->picked_up_at
                                ? $delivery->picked_up_at->format('M d, Y h:i A')
                                : '—'
                            }}

                        </td>

                        <td>

                            {{ $delivery->delivered_at
                                ? $delivery->delivered_at->format('M d, Y h:i A')
                                : '—'
                            }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center"
                        >

                            No delivery records found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection