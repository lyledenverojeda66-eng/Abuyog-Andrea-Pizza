@extends('admin.layout')

@section('title', 'Order Details')

@section('content')

<!-- =========================
     PAGE HEADER
========================= -->

<div class="page-header">

    <div>

        <h1>
            Order Details
        </h1>

        <p>
            View and manage order information.
        </p>

    </div>

    <a
        href="{{ route('admin.orders') }}"
        class="btn btn-green"
    >
        ← Back to Orders
    </a>

</div>


<!-- =========================
     SUCCESS MESSAGE
========================= -->

@if(session('success'))

    <div
        style="
            background:#dcfce7;
            color:#166534;
            border:1px solid #bbf7d0;
            padding:12px 16px;
            border-radius:10px;
            margin-bottom:20px;
            font-size:13px;
            font-weight:600;
        "
    >

        ✅ {{ session('success') }}

    </div>

@endif


<!-- =========================
     ERROR MESSAGE
========================= -->

@if(session('error'))

    <div
        style="
            background:#fee2e2;
            color:#991b1b;
            border:1px solid #fecaca;
            padding:12px 16px;
            border-radius:10px;
            margin-bottom:20px;
            font-size:13px;
            font-weight:600;
        "
    >

        ❌ {{ session('error') }}

    </div>

@endif


<!-- =========================
     VALIDATION ERRORS
========================= -->

@if($errors->any())

    <div
        style="
            background:#fee2e2;
            color:#991b1b;
            border:1px solid #fecaca;
            padding:12px 16px;
            border-radius:10px;
            margin-bottom:20px;
            font-size:13px;
        "
    >

        <strong>
            Please fix the following:
        </strong>

        <ul
            style="
                margin:8px 0 0;
                padding-left:20px;
            "
        >

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<!-- =========================
     MAIN CONTENT
========================= -->

<div
    style="
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:20px;
        align-items:start;
    "
    class="order-details-grid"
>


    <!-- =========================
         LEFT COLUMN
    ========================= -->

    <div>


        <!-- =========================
             ORDER INFORMATION
        ========================= -->

        <div class="card">

            <div
                style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:15px;
                    margin-bottom:20px;
                "
            >

                <h2
                    style="
                        margin:0;
                        font-size:18px;
                    "
                >
                    📦 Order Information
                </h2>

                <span
                    class="status {{ $order->status }}"
                >
                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                </span>

            </div>


            <div
                style="
                    display:grid;
                    grid-template-columns:repeat(2, 1fr);
                    gap:18px;
                "
                class="order-info-grid"
            >


                <!-- ORDER NUMBER -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Order Number
                    </div>

                    <div
                        style="
                            color:#15803d;
                            font-size:16px;
                            font-weight:900;
                        "
                    >
                        {{ $order->order_number }}
                    </div>

                </div>


                <!-- ORDER DATE -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Order Date
                    </div>

                    <div
                        style="
                            font-weight:700;
                        "
                    >
                        {{ $order->created_at->format('F d, Y') }}
                    </div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:12px;
                            margin-top:3px;
                        "
                    >
                        {{ $order->created_at->format('h:i A') }}
                    </div>

                </div>


                <!-- SUBTOTAL -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Subtotal
                    </div>

                    <div
                        style="
                            font-size:15px;
                            font-weight:800;
                        "
                    >
                        ₱{{ number_format($order->subtotal, 2) }}
                    </div>

                </div>


                <!-- DELIVERY FEE -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Delivery Fee
                    </div>

                    <div
                        style="
                            font-size:15px;
                            font-weight:800;
                        "
                    >
                        ₱{{ number_format($order->delivery_fee, 2) }}
                    </div>

                </div>


                <!-- TOTAL -->

                <div
                    style="
                        grid-column:1 / -1;
                        background:#f0fdf4;
                        border:1px solid #bbf7d0;
                        border-radius:10px;
                        padding:15px;
                    "
                >

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Total Amount
                    </div>

                    <div
                        style="
                            color:#15803d;
                            font-size:24px;
                            font-weight:900;
                        "
                    >
                        ₱{{ number_format($order->total_amount, 2) }}
                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             CUSTOMER INFORMATION
        ========================= -->

        <div
            class="card"
            style="margin-top:20px;"
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                👤 Customer Information
            </h2>


            <div
                style="
                    margin-top:20px;
                    display:grid;
                    gap:15px;
                "
            >

                <!-- NAME -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Customer Name
                    </div>

                    <div
                        style="
                            font-weight:800;
                        "
                    >
                        {{ $order->user->name ?? 'Customer' }}
                    </div>

                </div>


                <!-- EMAIL -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Email Address
                    </div>

                    <div>
                        {{ $order->user->email ?? 'N/A' }}
                    </div>

                </div>


                <!-- CONTACT -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Contact Number
                    </div>

                    <div>
                        {{ $order->contact_number }}
                    </div>

                </div>


                <!-- ADDRESS -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Delivery Address
                    </div>

                    <div
                        style="
                            background:#f9fafb;
                            border:1px solid #e5e7eb;
                            border-radius:8px;
                            padding:12px;
                            line-height:1.6;
                        "
                    >
                        {{ $order->delivery_address }}
                    </div>

                </div>


                <!-- NOTES -->

                @if($order->notes)

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Customer Notes
                        </div>

                        <div
                            style="
                                background:#fffbeb;
                                border:1px solid #fde68a;
                                border-radius:8px;
                                padding:12px;
                                line-height:1.6;
                            "
                        >
                            {{ $order->notes }}
                        </div>

                    </div>

                @endif

            </div>

        </div>


        <!-- =========================
             ORDERED PIZZAS
        ========================= -->

        <div
            class="card"
            style="margin-top:20px;"
        >

            <div
                style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:18px;
                "
            >

                <h2
                    style="
                        margin:0;
                        font-size:18px;
                    "
                >
                    🍕 Ordered Pizza
                </h2>

                <span
                    style="
                        color:#6b7280;
                        font-size:12px;
                    "
                >
                    {{ $order->orderItems->sum('quantity') }} item(s)
                </span>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Pizza
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Quantity
                            </th>

                            <th>
                                Subtotal
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($order->orderItems as $item)

                            <tr>

                                <!-- PIZZA -->

                                <td>

                                    <strong>
                                        {{ $item->pizza->name ?? 'Pizza' }}
                                    </strong>

                                </td>


                                <!-- PRICE -->

                                <td>

                                    ₱{{ number_format($item->price, 2) }}

                                </td>


                                <!-- QUANTITY -->

                                <td>

                                    {{ $item->quantity }}

                                </td>


                                <!-- SUBTOTAL -->

                                <td>

                                    <strong
                                        style="
                                            color:#15803d;
                                        "
                                    >
                                        ₱{{ number_format($item->subtotal, 2) }}
                                    </strong>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    style="
                                        text-align:center;
                                        padding:30px;
                                        color:#6b7280;
                                    "
                                >

                                    No pizza items found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        <!-- =========================
             PAYMENT INFORMATION
        ========================= -->

        <div
            class="card"
            style="margin-top:20px;"
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                💳 Payment Information
            </h2>


            <div
                style="
                    margin-top:20px;
                    display:grid;
                    gap:15px;
                "
            >

                <!-- PAYMENT METHOD -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Payment Method
                    </div>

                    <div
                        style="
                            font-weight:800;
                        "
                    >

                        @if($order->payment_method === 'gcash')

                            📱 GCash

                        @else

                            💵 Cash on Delivery

                        @endif

                    </div>

                </div>


                <!-- PAYMENT AMOUNT -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Payment Amount
                    </div>

                    <div
                        style="
                            color:#15803d;
                            font-size:17px;
                            font-weight:900;
                        "
                    >
                        ₱{{ number_format($order->total_amount, 2) }}
                    </div>

                </div>


                <!-- PAYMENT STATUS -->

                <div>

                    <div
                        style="
                            color:#6b7280;
                            font-size:11px;
                            font-weight:700;
                            text-transform:uppercase;
                            margin-bottom:5px;
                        "
                    >
                        Payment Status
                    </div>


                    @if($order->payment)

                        <span
                            class="status {{ $order->payment->status }}"
                        >
                            {{ ucfirst($order->payment->status) }}
                        </span>

                    @else

                        <span class="status pending">
                            Pending
                        </span>

                    @endif

                </div>


                <!-- REFERENCE -->

                @if($order->payment?->reference_number)

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Reference Number
                        </div>

                        <div>
                            {{ $order->payment->reference_number }}
                        </div>

                    </div>

                @endif


                <!-- PAID DATE -->

                @if($order->payment?->paid_at)

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Paid At
                        </div>

                        <div>
                            {{ $order->payment->paid_at->format('F d, Y h:i A') }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- =========================
         RIGHT COLUMN
    ========================= -->

    <div>


        <!-- =========================
             UPDATE ORDER STATUS
        ========================= -->

        <div class="card">

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                🔄 Update Order Status
            </h2>


            <p
                style="
                    color:#6b7280;
                    font-size:12px;
                    margin:7px 0 20px;
                "
            >
                Change the current status of this order.
            </p>


            <form
                action="{{ route('admin.orders.status', $order) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <label
                    for="status"
                    style="
                        display:block;
                        font-size:12px;
                        font-weight:800;
                        margin-bottom:8px;
                    "
                >
                    Order Status
                </label>


                <select
                    name="status"
                    id="status"
                    required
                    style="
                        width:100%;
                        padding:12px;
                        border:1px solid #d1d5db;
                        border-radius:8px;
                        background:#fff;
                        font-size:13px;
                        margin-bottom:15px;
                    "
                >

                    <option
                        value="pending"
                        {{ $order->status === 'pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="confirmed"
                        {{ $order->status === 'confirmed' ? 'selected' : '' }}
                    >
                        Confirmed
                    </option>

                    <option
                        value="preparing"
                        {{ $order->status === 'preparing' ? 'selected' : '' }}
                    >
                        Preparing
                    </option>

                    <option
                        value="ready_for_delivery"
                        {{ $order->status === 'ready_for_delivery' ? 'selected' : '' }}
                    >
                        Ready for Delivery
                    </option>

                    <option
                        value="out_for_delivery"
                        {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}
                    >
                        Out for Delivery
                    </option>

                    <option
                        value="delivered"
                        {{ $order->status === 'delivered' ? 'selected' : '' }}
                    >
                        Delivered
                    </option>

                    <option
                        value="cancelled"
                        {{ $order->status === 'cancelled' ? 'selected' : '' }}
                    >
                        Cancelled
                    </option>

                </select>


                <button
                    type="submit"
                    class="btn btn-green"
                    style="
                        width:100%;
                    "
                >
                    Update Status
                </button>

            </form>

        </div>


        <!-- =========================
             DELIVERY INFORMATION
        ========================= -->

        <div
            class="card"
            style="margin-top:20px;"
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                🚚 Delivery Information
            </h2>


            <div
                style="
                    margin-top:20px;
                    display:grid;
                    gap:15px;
                "
            >

                @if($order->delivery)

                    <!-- RIDER -->

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Rider
                        </div>

                        <div
                            style="
                                font-weight:800;
                            "
                        >
                            {{ $order->delivery->rider_name ?? 'Not assigned' }}
                        </div>

                    </div>


                    <!-- RIDER CONTACT -->

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Rider Contact
                        </div>

                        <div>
                            {{ $order->delivery->rider_contact ?? 'N/A' }}
                        </div>

                    </div>


                    <!-- PICKED UP -->

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Picked Up
                        </div>

                        <div>

                            @if($order->delivery->picked_up_at)

                                {{ $order->delivery->picked_up_at->format('F d, Y h:i A') }}

                            @else

                                <span style="color:#9ca3af;">
                                    Not yet picked up
                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- DELIVERED -->

                    <div>

                        <div
                            style="
                                color:#6b7280;
                                font-size:11px;
                                font-weight:700;
                                text-transform:uppercase;
                                margin-bottom:5px;
                            "
                        >
                            Delivered
                        </div>

                        <div>

                            @if($order->delivery->delivered_at)

                                {{ $order->delivery->delivered_at->format('F d, Y h:i A') }}

                            @else

                                <span style="color:#9ca3af;">
                                    Not yet delivered
                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- DELIVERY NOTES -->

                    @if($order->delivery->delivery_notes)

                        <div>

                            <div
                                style="
                                    color:#6b7280;
                                    font-size:11px;
                                    font-weight:700;
                                    text-transform:uppercase;
                                    margin-bottom:5px;
                                "
                            >
                                Delivery Notes
                            </div>

                            <div
                                style="
                                    background:#f9fafb;
                                    border:1px solid #e5e7eb;
                                    border-radius:8px;
                                    padding:12px;
                                    line-height:1.5;
                                "
                            >
                                {{ $order->delivery->delivery_notes }}
                            </div>

                        </div>

                    @endif

                @else

                    <div
                        style="
                            text-align:center;
                            padding:20px;
                            background:#f9fafb;
                            border:1px dashed #d1d5db;
                            border-radius:10px;
                            color:#6b7280;
                            font-size:13px;
                        "
                    >

                        🚚

                        <br>

                        No delivery information available yet.

                    </div>

                @endif

            </div>

        </div>


        <!-- =========================
             QUICK INFORMATION
        ========================= -->

        <div
            class="card"
            style="margin-top:20px;"
        >

            <h2
                style="
                    margin:0;
                    font-size:18px;
                "
            >
                ℹ️ Quick Information
            </h2>


            <div
                style="
                    margin-top:20px;
                    display:grid;
                    gap:12px;
                "
            >

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        gap:10px;
                    "
                >

                    <span style="color:#6b7280;">
                        Order ID
                    </span>

                    <strong>
                        #{{ $order->id }}
                    </strong>

                </div>


                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        gap:10px;
                    "
                >

                    <span style="color:#6b7280;">
                        Items
                    </span>

                    <strong>
                        {{ $order->orderItems->sum('quantity') }}
                    </strong>

                </div>


                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        gap:10px;
                    "
                >

                    <span style="color:#6b7280;">
                        Payment
                    </span>

                    <strong>

                        @if($order->payment_method === 'gcash')

                            GCash

                        @else

                            Cash

                        @endif

                    </strong>

                </div>


                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        gap:10px;
                    "
                >

                    <span style="color:#6b7280;">
                        Status
                    </span>

                    <strong
                        style="
                            color:#15803d;
                            text-transform:capitalize;
                        "
                    >
                        {{ str_replace('_', ' ', $order->status) }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================
     RESPONSIVE DESIGN
========================= -->

<style>

.order-details-grid {
    width:100%;
}

@media(max-width:1000px) {

    .order-details-grid {
        grid-template-columns:1fr !important;
    }

}

@media(max-width:700px) {

    .order-info-grid {
        grid-template-columns:1fr !important;
    }

}

@media(max-width:600px) {

    .page-header {
        flex-direction:column !important;
        align-items:flex-start !important;
        gap:15px;
    }

}

</style>

@endsection