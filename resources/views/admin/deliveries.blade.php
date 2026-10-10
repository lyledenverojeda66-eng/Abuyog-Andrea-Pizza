

@extends('admin.layout')



@section('title', 'Deliveries')



@section('content')



<style>

    .deliveries-page {

        width: 100%;

        color: #1f2937;

    }



    .deliveries-page * {

        box-sizing: border-box;

    }



    .deliveries-page .page-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 24px;

        gap: 12px;

    }



    .deliveries-page .page-header h1 {

        margin: 0 0 6px;

        font-size: 27px;

        font-weight: 800;

        line-height: 1.4;

        color: #111827;

    }



    .deliveries-page .page-header p {

        margin: 0;

        color: #6b7280;

        font-size: 14px;

        line-height: 1.6;

    }



    .deliveries-page .delivery-subtitle {

        display: flex;

        align-items: center;

        gap: 9px;

    }



    .deliveries-page .delivery-icon {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        width: 42px;

        height: 42px;

        border-radius: 12px;

        background: #dcfce7;

        font-size: 22px;

    }



    .deliveries-page .delivery-card {

        background: #fff;

        border: 1px solid #e5e7eb;

        border-radius: 15px;

        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);

        overflow: hidden;

    }



    .deliveries-page .card-heading {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 12px;

        padding: 20px 22px;

        border-bottom: 1px solid #e5e7eb;

    }



    .deliveries-page .card-heading h2 {

        margin: 0;

        font-size: 16px;

        font-weight: 750;

        color: #111827;

    }



    .deliveries-page .card-heading p {

        margin: 4px 0 0;

        font-size: 12px;

        color: #6b7280;

    }



    .deliveries-page .delivery-count {

        padding: 6px 11px;

        border-radius: 20px;

        background: #dcfce7;

        color: #166534;

        font-size: 12px;

        font-weight: 700;

        white-space: nowrap;

    }



    .deliveries-page .table-wrapper {

        width: 100%;

        overflow-x: auto;

    }



    .deliveries-page table {

        width: 100%;

        min-width: 1240px;

        border-collapse: separate;

        border-spacing: 0;

    }



    .deliveries-page thead th {

        padding: 15px 14px;

        background: #f8fafc;

        color: #64748b;

        font-size: 11px;

        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .45px;

        white-space: nowrap;

        text-align: left;

        border-bottom: 1px solid #e5e7eb;

    }



    .deliveries-page tbody td {

        padding: 17px 14px;

        vertical-align: middle;

        border-bottom: 1px solid #f1f5f9;

        font-size: 13px;

    }



    .deliveries-page tbody tr:last-child td {

        border-bottom: none;

    }



    .deliveries-page tbody tr {

        transition: *background* .15s ease;

    }



    .deliveries-page tbody tr:hover {

        background: #f9fcfa;

    }



    .deliveries-page .order-number {

        display: block;

        max-width: 180px;

        color: #15803d;

        font-size: 12px;

        font-weight: 800;

        line-height: 1.7;

        overflow-wrap: anywhere;

    }



    .deliveries-page .customer-name {

        display: block;

        color: #1f2937;

        font-weight: 700;

        line-height: 1.5;

    }



    .deliveries-page .customer-label {

        display: block;

        margin-top: 4px;

        color: #9ca3af;

        font-size: 11px;

    }



    .deliveries-page .contact-text {

        color: #475569;

        white-space: nowrap;

    }



    .deliveries-page .date-text {

        display: block;

        min-width: 125px;

        color: #64748b;

        font-size: 12px;

        line-height: 1.7;

    }



    .deliveries-page .date-empty {

        color: #cbd5e1;

    }



    .deliveries-page .form-stack {

        display: flex;

        flex-direction: column;

        gap: 8px;

        width: 150px;

        margin: 0;

    }



    .deliveries-page .form-stack input,

    .deliveries-page .form-stack select {

        display: block;

        width: 100%;

        min-width: 0;

        height: 36px;

        margin: 0;

        padding: 0 10px;

        border: 1px solid #dbe2ea;

        border-radius: 7px;

        background: #fff;

        color: #334155;

        font-family: inherit;

        font-size: 12px;

        outline: none;

        transition: border-color .15s ease, box-shadow .15s ease;

    }



    .deliveries-page .form-stack input::placeholder {

        color: #9ca3af;

    }



    .deliveries-page .form-stack input:focus,

    .deliveries-page .form-stack select:focus {

        border-color: #16a34a;

        box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);

    }



    .deliveries-page .form-stack select {

        cursor: pointer;

    }



    .deliveries-page .btn-delivery {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 5px;

        width: 100%;

        min-height: 35px;

        padding: 8px 10px;

        border: 0;

        border-radius: 7px;

        background: #15803d;

        color: #fff;

        font-family: inherit;

        font-size: 12px;

        font-weight: 700;

        cursor: pointer;

        transition: *background* .15s ease, transform .15s ease;

    }



    .deliveries-page .btn-delivery:hover {

        background: #166534;

    }



    .deliveries-page .btn-delivery:active {

        transform: scale(.98);

    }



    .deliveries-page .btn-status {

        background: #1d4ed8;

    }



    .deliveries-page .btn-status:hover {

        background: #1e40af;

    }



    .deliveries-page .btn-payment {

        background: #475569;

    }



    .deliveries-page .btn-payment:hover {

        background: #334155;

    }



    .deliveries-page .status-label {

        display: inline-block;

        padding: 5px 9px;

        border-radius: 20px;

        background: #f1f5f9;

        color: #475569;

        font-size: 11px;

        font-weight: 750;

        white-space: nowrap;

    }



    .deliveries-page .empty-deliveries {

        padding: 45px 20px !important;

        text-align: center;

        color: #64748b;

        line-height: 1.8;

    }



    .deliveries-page .empty-icon {

        display: block;

        margin-bottom: 8px;

        font-size: 30px;

    }



    .deliveries-page .table-footer {

        padding: 13px 20px;

        border-top: 1px solid #e5e7eb;

        background: #fff;

        color: #64748b;

        font-size: 12px;

    }



    @media (max-width: 768px) {

        .deliveries-page .page-header h1 {

            font-size: 23px;

        }



        .deliveries-page .card-heading {

            padding: 16px;

        }



        .deliveries-page tbody td {

            padding: 13px 11px;

        }



        .deliveries-page thead th {

            padding: 13px 11px;

        }

    }

</style>



<div class="deliveries-page">



    <div class="page-header">

        <div>

            <h1>

                <span class="delivery-subtitle">

                    <span class="delivery-icon">🚚</span>

                    Deliveries

                </span>

            </h1>



            <p>Monitor customer deliveries, assign riders, and track payments.</p>

        </div>

    </div>



    <div class="delivery-card">



        <div class="card-heading">

            <div>

                <h2>Delivery Management</h2>

                <p>Manage rider assignments, delivery progress, and payment status.</p>

            </div>



            <span class="delivery-count">

                {{ $deliveries->count() }} Records

            </span>

        </div>



        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Order / Customer</th>

                        <th>Assign Rider</th>

                        <th>Contact</th>

                        <th>Delivery Status</th>

                        <th>Payment Status</th>

                        <th>Picked Up</th>

                        <th>Delivered</th>

                    </tr>

                </thead>



                <tbody>

                    @forelse($deliveries as $delivery)

                        <tr>

                            {{-- ORDER AND CUSTOMER --}}

                            <td>

                                <span class="order-number">

                                    {{ $delivery->order->order_number ?? 'N/A' }}

                                </span>



                                <span class="customer-name">

                                    {{ $delivery->order->user->name ?? 'Customer' }}

                                </span>



                                <span class="customer-label">Customer</span>

                            </td>



                            {{-- ASSIGN RIDER --}}

<td>

    <form

        action="{{ route('admin.deliveries.assign-rider', $delivery->id) }}"

        method="POST"

        class="form-stack"

    >

        @csrf

        @method('PUT')



        <select

            name="rider_id"

            aria-label="Select rider"

            required

        >

            <option value="">Select Rider</option>



            @foreach ($riders as $rider)

                <option

                    value="{{ $rider->id }}"

                    @selected(

                        (int) $delivery->rider_id === (int) $rider->id

                    )

                >

                    {{ $rider->name }}

                </option>

            @endforeach

        </select>



        <button type="submit" class="btn-delivery">

            {{ $delivery->rider_id ? 'Update Rider' : 'Assign Rider' }}

        </button>

    </form>

</td>

                           {{-- RIDER PHONE CONTACT --}}
                            <td>
                                @php
                                    $riderPhone = $delivery->rider?->phone
                                        ?: $delivery->rider_contact;
                                @endphp

                                @if (filled($riderPhone))
                                    <a
                                        class="contact-text"
                                        href="tel:{{ preg_replace('/[^0-9+]/', '', $riderPhone) }}"
                                        aria-label="Call rider {{ $delivery->rider?->name ?? '' }}"
                                    >
                                        {{ $riderPhone }}
                                    </a>
                                @else
                                    <span class="contact-text">Not available</span>
                                @endif
                            </td>

                            {{-- DELIVERY STATUS --}}

                            <td>

                                <form

                                    action="{{ route('admin.deliveries.update-status', $delivery->id) }}"

                                    method="POST"

                                    class="form-stack"

                                >

                                    @csrf

                                    @method('PUT')



                                    <select name="status" aria-label="Delivery status" required>

                                        @foreach([

                                            'pending' => 'Pending',

                                            'preparing' => 'Preparing',

                                            'ready_for_pickup' => 'Ready for Pickup',

                                            'picked_up' => 'Picked Up',

                                            'out_for_delivery' => 'Out for Delivery',

                                            'delivered' => 'Delivered'

                                        ] as $value => $label)

                                            <option

                                                value="{{ $value }}"

                                                @selected(($delivery->status ?? 'pending') === $value)

                                            >

                                                {{ $label }}

                                            </option>

                                        @endforeach

                                    </select>



                                    <button type="submit" class="btn-delivery btn-status">

                                        Update Status

                                    </button>

                                </form>

                            </td>



                            {{-- PAYMENT STATUS --}}

                            <td>

                                <form

                                    action="{{ route('admin.deliveries.update-payment', $delivery->id) }}"

                                    method="POST"

                                    class="form-stack"

                                >

                                    @csrf

                                    @method('PUT')



                                    <select name="payment_status" aria-label="Payment status" required>

                                        @foreach([

                                            'pending' => 'Pending',

                                            'paid' => 'Paid',

                                            'failed' => 'Failed'

                                        ] as $value => $label)

                                            <option

                                                value="{{ $value }}"

                                                @selected(($delivery->payment_status ?? 'pending') === $value)

                                            >

                                                {{ $label }}

                                            </option>

                                        @endforeach

                                    </select>



                                    <button type="submit" class="btn-delivery btn-payment">

                                        Update Payment

                                    </button>

                                </form>

                            </td>



                            {{-- PICKED UP --}}

                            <td>

                                @if($delivery->picked_up_at)

                                    <span class="date-text">

                                        {{ $delivery->picked_up_at->format('M d, Y') }}

                                        <br>

                                        {{ $delivery->picked_up_at->format('h:i A') }}

                                    </span>

                                @else

                                    <span class="date-text date-empty">Not picked up</span>

                                @endif

                            </td>



                            {{-- DELIVERED --}}

                            <td>

                                @if($delivery->delivered_at)

                                    <span class="date-text">

                                        {{ $delivery->delivered_at->format('M d, Y') }}

                                        <br>

                                        {{ $delivery->delivered_at->format('h:i A') }}

                                    </span>

                                @else

                                    <span class="date-text date-empty">Not delivered</span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="empty-deliveries">

                                <span class="empty-icon">📦</span>

                                <strong>No delivery records found.</strong>

                                <br>

                                Delivery records will appear here when available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



        <div class="table-footer">

            Scroll horizontally to view all delivery information on smaller screens.

        </div>



    </div>

</div>



@endsection