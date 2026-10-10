@extends('admin.layout')

@section('title', 'Customers')

@section('content')

<style>
    .customers-page {
        width: 100%;
    }

    .customers-page .page-header {
        margin-bottom: 20px;
    }

    .customers-page .page-header h1 {
        margin: 0 0 6px 0;
        line-height: 1.4;
    }

    .customers-page .page-header p {
        margin: 0;
        line-height: 1.5;
        color: #6b7280;
    }

    .customers-page .card {
        width: 100%;
    }

    .customers-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .customers-page table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 700px;
    }

    .customers-page table th {
        padding: 13px 16px;
        line-height: 1.4;
        white-space: nowrap;
        text-align: left;
    }

    .customers-page table td {
        padding: 14px 16px;
        line-height: 1.5;
        vertical-align: middle;
    }

    .customers-page table th:first-child,
    .customers-page table td:first-child {
        width: 70px;
    }

    .customers-page table th:nth-child(4),
    .customers-page table td:nth-child(4) {
        text-align: center;
        width: 130px;
    }

    .customers-page table th:nth-child(5),
    .customers-page table td:nth-child(5) {
        white-space: nowrap;
        width: 140px;
    }

    .customer-name {
        display: block;
        line-height: 1.5;
        white-space: nowrap;
    }

    .customer-email {
        line-height: 1.5;
        white-space: nowrap;
    }

    .order-count {
        display: inline-block;
        min-width: 28px;
        line-height: 1.4;
        text-align: center;
    }

    .empty-customers {
        text-align: center !important;
        padding: 35px 20px !important;
        color: #6b7280;
        line-height: 1.5;
    }

    @media (max-width: 700px) {

        .customers-page table {
            min-width: 650px;
        }

        .customers-page table th,
        .customers-page table td {
            padding: 11px 13px;
        }

    }
</style>


<div class="customers-page">

    <div class="page-header">

        <div>

            <h1>👥 Customers</h1>

            <p>
                Registered customer accounts.
            </p>

        </div>

    </div>


    <div class="card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Total Orders</th>

                        <th>Registered</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($customers as $customer)

                        <tr>

                            <td>
                                {{ $customer->id }}
                            </td>


                            <td>

                                <strong class="customer-name">
                                    {{ $customer->name }}
                                </strong>

                            </td>


                            <td>

                                <span class="customer-email">
                                    {{ $customer->email }}
                                </span>

                            </td>


                            <td>

                                <strong
                                    class="order-count"
                                    style="color:#15803d"
                                >
                                    {{ $customer->orders_count }}
                                </strong>

                            </td>


                            <td>

                                {{ $customer->created_at->format('M d, Y') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="empty-customers"
                            >
                                No customers found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection