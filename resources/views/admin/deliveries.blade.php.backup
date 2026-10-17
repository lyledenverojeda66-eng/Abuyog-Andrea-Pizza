
@extends('admin.layout')

@section('title', 'Deliveries')

@section('content')
<style>
    .deliveries-page {
        width: 100%;
        color: #1f2937;
        font-size: 13px;
    }

    .deliveries-page *,
    .deliveries-page *::before,
    .deliveries-page *::after {
        box-sizing: border-box;
    }

    .deliveries-page .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .deliveries-page .page-header h1 {
        margin: 0 0 5px;
        color: #111827;
        font-size: 26px;
        font-weight: 800;
    }

    .deliveries-page .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.6;
    }

    .deliveries-page .delivery-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .deliveries-page .delivery-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #dcfce7;
        font-size: 22px;
    }

    .deliveries-page .delivery-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .deliveries-page .card-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .deliveries-page .card-heading h2 {
        margin: 0;
        color: #111827;
        font-size: 16px;
        font-weight: 800;
    }

    .deliveries-page .card-heading p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 12px;
    }

    .deliveries-page .delivery-count {
        padding: 6px 11px;
        border-radius: 20px;
        background: #dcfce7;
        color: #166534;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Search and filters */

    .deliveries-page .toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 14px 18px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }

    .deliveries-page .search-box {
        position: relative;
        flex: 1 1 260px;
        min-width: 180px;
    }

    .deliveries-page .search-box span {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 15px;
    }

    .deliveries-page .search-box input,
    .deliveries-page .filter-select {
        width: 100%;
        height: 39px;
        padding: 0 12px;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        background: #fff;
        color: #334155;
        font-family: inherit;
        font-size: 12px;
        outline: none;
    }

    .deliveries-page .search-box input {
        padding-left: 35px;
    }

    .deliveries-page .search-box input:focus,
    .deliveries-page .filter-select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);
    }

    .deliveries-page .filter-select {
        flex: 0 1 190px;
        min-width: 155px;
        cursor: pointer;
    }

    .deliveries-page .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 39px;
        padding: 0 13px;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        background: #f8fafc;
        color: #475569;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .deliveries-page .btn-reset:hover {
        background: #f1f5f9;
    }

    .deliveries-page .filter-summary {
        padding: 9px 19px;
        color: #64748b;
        font-size: 11px;
        background: #fafafa;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Table */

    .deliveries-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .deliveries-page table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .deliveries-page thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        padding: 12px;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .35px;
        white-space: nowrap;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .deliveries-page tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }

    .deliveries-page tbody tr:last-child td {
        border-bottom: none;
    }

    .deliveries-page tbody tr {
        transition: background .15s ease;
    }

    .deliveries-page tbody tr:hover {
        background: #f8fcf9;
    }

    .deliveries-page .order-number {
        display: block;
        max-width: 180px;
        color: #15803d;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .deliveries-page .customer-name {
        display: block;
        margin-top: 3px;
        color: #1f2937;
        font-weight: 750;
        line-height: 1.5;
    }

    .deliveries-page .customer-label {
        display: block;
        margin-top: 2px;
        color: #9ca3af;
        font-size: 10px;
    }

    .deliveries-page .contact-text {
        color: #475569;
        white-space: nowrap;
        text-decoration: none;
    }

    .deliveries-page a.contact-text:hover {
        color: #15803d;
        text-decoration: underline;
    }

    .deliveries-page .date-text {
        display: block;
        min-width: 105px;
        color: #64748b;
        font-size: 11px;
        line-height: 1.65;
    }

    .deliveries-page .date-empty {
        color: #94a3b8;
    }

    /* Compact forms */

    .deliveries-page .form-stack {
        display: flex;
        flex-direction: column;
        gap: 6px;
        width: 145px;
        margin: 0;
    }

    .deliveries-page .form-stack select {
        display: block;
        width: 100%;
        min-width: 0;
        height: 34px;
        margin: 0;
        padding: 0 8px;
        border: 1px solid #dbe2ea;
        border-radius: 7px;
        background: #fff;
        color: #334155;
        font-family: inherit;
        font-size: 11px;
        outline: none;
    }

    .deliveries-page .form-stack select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);
    }

    .deliveries-page .btn-delivery {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        width: 100%;
        min-height: 32px;
        padding: 7px 9px;
        border: 0;
        border-radius: 7px;
        background: #15803d;
        color: #fff;
        font-family: inherit;
        font-size: 11px;
        font-weight: 750;
        cursor: pointer;
        transition: background .15s ease, transform .15s ease;
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

    .deliveries-page .status-label {
        display: inline-block;
        padding: 5px 8px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .deliveries-page .empty-deliveries {
        padding: 35px 20px !important;
        text-align: center;
        color: #64748b;
        line-height: 1.8;
    }

    .deliveries-page .empty-icon {
        display: block;
        margin-bottom: 8px;
        font-size: 28px;
    }

    .deliveries-page .no-results {
        display: none;
        padding: 30px 15px;
        text-align: center;
        color: #64748b;
        background: #fff;
    }

    .deliveries-page .no-results strong {
        display: block;
        margin-bottom: 5px;
        color: #334155;
    }

    .deliveries-page .table-footer {
        padding: 11px 18px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
        color: #64748b;
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .deliveries-page .page-header h1 {
            font-size: 22px;
        }

        .deliveries-page .card-heading {
            padding: 14px;
        }

        .deliveries-page .toolbar {
            padding: 12px;
        }

        .deliveries-page .search-box {
            flex-basis: 100%;
        }

        .deliveries-page .filter-select {
            flex: 1 1 160px;
        }

        .deliveries-page .table-footer {
            line-height: 1.7;
        }
    }
</style>

<div class="deliveries-page">

    <div class="page-header">
        <div>
            <h1>
                <span class="delivery-title">
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

            <span class="delivery-count" id="deliveryCount">
                {{ $deliveries->count() }} Records
            </span>
        </div>

        {{-- SEARCH AND FILTERS --}}
        <div class="toolbar">
            <div class="search-box">
                <span>🔎</span>
                <input
                    type="search"
                    id="deliverySearch"
                    placeholder="Search order, customer, or rider..."
                    aria-label="Search deliveries"
                    autocomplete="off"
                >
            </div>

            <select
                class="filter-select"
                id="deliveryStatusFilter"
                aria-label="Filter by delivery status"
            >
                <option value="">All Delivery Statuses</option>
                <option value="pending">Pending</option>
                <option value="preparing">Preparing</option>
                <option value="ready_for_pickup">Ready for Pickup</option>
                <option value="picked_up">Picked Up</option>
                <option value="out_for_delivery">Out for Delivery</option>
                <option value="delivered">Delivered</option>
            </select>

            <select
                class="filter-select"
                id="deliveryPaymentFilter"
                aria-label="Filter by payment status"
            >
                <option value="">All Payment Statuses</option>
                <option value="pending">Payment Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Payment Failed</option>
            </select>

            <button type="button" class="btn-reset" id="resetDeliveryFilters">
                Reset
            </button>
        </div>

        <div class="filter-summary" id="deliveryFilterSummary" aria-live="polite">
            Showing {{ $deliveries->count() }} deliveries
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Order / Customer</th>
                        <th>Assign Rider</th>
                        <th>Rider Contact</th>
                        <th>Delivery Status</th>
                        <th>Payment Status</th>
                        <th>Picked Up</th>
                        <th>Delivered</th>
                    </tr>
                </thead>

                <tbody id="deliveriesTableBody">
                    @forelse($deliveries as $delivery)
                        @php
                            $order = $delivery->order;
                            $customer = $order?->user;
                            $rider = $delivery->rider;

                            $orderNumber = $order?->order_number ?? 'N/A';
                            $customerName = $customer?->name ?? 'Customer';
                            $riderName = $rider?->name ?? $delivery->rider_name ?? '';

                            $deliveryStatus = strtolower($delivery->status ?? 'pending');

                            $paymentStatus = strtolower(
                                $order?->payment?->status
                                ?? $delivery->payment_status
                                ?? 'pending'
                            );

                            $paymentLabels = [
                                'paid' => 'Paid',
                                'pending' => 'Pending',
                                'failed' => 'Failed',
                            ];

                            $paymentColors = [
                                'paid' => [
                                    'background' => '#dcfce7',
                                    'color' => '#166534',
                                ],
                                'pending' => [
                                    'background' => '#fef3c7',
                                    'color' => '#92400e',
                                ],
                                'failed' => [
                                    'background' => '#fee2e2',
                                    'color' => '#991b1b',
                                ],
                            ];

                            $paymentLabel = $paymentLabels[$paymentStatus]
                                ?? ucfirst(str_replace('_', ' ', $paymentStatus));

                            $paymentColor = $paymentColors[$paymentStatus] ?? [
                                'background' => '#f1f5f9',
                                'color' => '#475569',
                            ];

                            $riderPhone = $rider?->phone ?: $delivery->rider_contact;
                            $searchText = strtolower(
                                $orderNumber . ' '
                                . $customerName . ' '
                                . $riderName . ' '
                                . ($rider?->email ?? '') . ' '
                                . ($riderPhone ?? '')
                            );
                        @endphp

                        <tr
                            class="delivery-row"
                            data-search="{{ $searchText }}"
                            data-status="{{ $deliveryStatus }}"
                            data-payment="{{ $paymentStatus }}"
                        >
                            {{-- ORDER AND CUSTOMER --}}
                            <td>
                                <span class="order-number">
                                    {{ $orderNumber }}
                                </span>

                                <span class="customer-name">
                                    {{ $customerName }}
                                </span>

                                <span class="customer-label">Customer</span>
                            </td>

                            {{-- QUICK RIDER ASSIGNMENT --}}
                            <td>
                                <form
                                    action="{{ route('admin.deliveries.assign-rider', $delivery->id) }}"
                                    method="POST"
                                    class="form-stack rider-assignment-form"
                                >
                                    @csrf
                                    @method('PUT')

                                    <select
                                        name="rider_id"
                                        aria-label="Assign rider to order {{ $orderNumber }}"
                                        required
                                        data-original-value="{{ $delivery->rider_id ?? '' }}"
                                        onchange="confirmRiderChange(this)"
                                    >
                                        <option value="">Select Rider</option>

                                        @foreach ($riders as $riderOption)
                                            <option
                                                value="{{ $riderOption->id }}"
                                                @selected((int) $delivery->rider_id === (int) $riderOption->id)
                                            >
                                                {{ $riderOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- RIDER CONTACT --}}
                            <td>
                                @if (filled($riderPhone))
                                    <a
                                        class="contact-text"
                                        href="tel:{{ preg_replace('/[^0-9+]/', '', $riderPhone) }}"
                                        aria-label="Call rider {{ $riderName }}"
                                    >
                                        {{ $riderPhone }}
                                    </a>
                                @else
                                    <span class="contact-text">Not available</span>
                                @endif

                                @if (filled($riderName))
                                    <span class="date-text">{{ $riderName }}</span>
                                @endif
                            </td>

                            {{-- QUICK DELIVERY STATUS --}}
                            <td>
                                <form
                                    action="{{ route('admin.deliveries.update-status', $delivery->id) }}"
                                    method="POST"
                                    class="form-stack"
                                    onsubmit="return confirmDeliveryStatus(this)"
                                >
                                    @csrf
                                    @method('PUT')

                                    <select
                                        name="status"
                                        aria-label="Delivery status for order {{ $orderNumber }}"
                                        required
                                    >
                                        @foreach ([
                                            'pending' => 'Pending',
                                            'preparing' => 'Preparing',
                                            'ready_for_pickup' => 'Ready for Pickup',
                                            'picked_up' => 'Picked Up',
                                            'out_for_delivery' => 'Out for Delivery',
                                            'delivered' => 'Delivered',
                                        ] as $value => $label)
                                            <option
                                                value="{{ $value }}"
                                                @selected($deliveryStatus === $value)
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
                                <span
                                    class="status-label"
                                    style="background: {{ $paymentColor['background'] }}; color: {{ $paymentColor['color'] }};"
                                >
                                    {{ $paymentLabel }}
                                </span>

                                @if ($paymentStatus === 'paid' && $delivery->payment_received_at)
                                    <span class="date-text">
                                        {{ $delivery->payment_received_at->format('M d, Y h:i A') }}
                                    </span>
                                @endif
                            </td>

                            {{-- PICKED UP --}}
                            <td>
                                @if ($delivery->picked_up_at)
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
                                @if ($delivery->delivered_at)
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

        <div class="no-results" id="deliveryNoResults">
            <strong>No matching deliveries found.</strong>
            Try another search term or change your filters.
        </div>

        <div class="table-footer">
            Use search and filters to find deliveries quickly. Changes to rider assignments
            and delivery statuses are saved through the existing application routes.
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('deliverySearch');
        const statusFilter = document.getElementById('deliveryStatusFilter');
        const paymentFilter = document.getElementById('deliveryPaymentFilter');
        const resetButton = document.getElementById('resetDeliveryFilters');
        const rows = Array.from(document.querySelectorAll('.delivery-row'));
        const countLabel = document.getElementById('deliveryCount');
        const summary = document.getElementById('deliveryFilterSummary');
        const noResults = document.getElementById('deliveryNoResults');

        function filterDeliveries() {
            const query = searchInput.value.trim().toLowerCase();
            const status = statusFilter.value;
            const payment = paymentFilter.value;
            let visibleCount = 0;

            rows.forEach(function (row) {
                const searchableText = row.dataset.search || '';
                const rowStatus = row.dataset.status || 'pending';
                const rowPayment = row.dataset.payment || 'pending';

                const matchesSearch = !query || searchableText.includes(query);
                const matchesStatus = !status || rowStatus === status;
                const matchesPayment = !payment || rowPayment === payment;
                const visible = matchesSearch && matchesStatus && matchesPayment;

                row.style.display = visible ? '' : 'none';

                if (visible) {
                    visibleCount++;
                }
            });

            countLabel.textContent = visibleCount + ' of ' + rows.length + ' Records';

            summary.textContent = 'Showing ' + visibleCount
                + ' of ' + rows.length + ' deliveries';

            noResults.style.display =
                rows.length > 0 && visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterDeliveries);
        statusFilter.addEventListener('change', filterDeliveries);
        paymentFilter.addEventListener('change', filterDeliveries);

        resetButton.addEventListener('click', function () {
            searchInput.value = '';
            statusFilter.value = '';
            paymentFilter.value = '';
            filterDeliveries();
            searchInput.focus();
        });

        filterDeliveries();
    });

    function confirmRiderChange(select) {
    const originalValue = select.dataset.originalValue || '';
    const selectedValue = select.value;

    if (!selectedValue) {
        select.value = originalValue;
        return;
    }

    if (selectedValue === originalValue) {
        return;
    }

    const selectedOption = select.options[select.selectedIndex];
    const selectedName = selectedOption
        ? selectedOption.text
        : 'this rider';

    if (confirm('Assign ' + selectedName + ' to this delivery?')) {
        // Submit the existing Laravel form.
        select.form.submit();
    } else {
        // Restore the previously assigned rider.
        select.value = originalValue;
    }
}
    function confirmDeliveryStatus(form) {
        const select = form.querySelector('select[name="status"]');

        if (!select) {
            return true;
        }

        const selectedOption = select.options[select.selectedIndex];
        const selectedStatus = selectedOption ? selectedOption.text : select.value;

        return confirm('Update this delivery status to "' + selectedStatus + '"?');
    }
</script>
@endsection
