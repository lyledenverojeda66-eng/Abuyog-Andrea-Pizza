@extends('admin.layout')

@section('title', 'Customers')

@section('content')

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
                            <strong>
                                {{ $customer->name }}
                            </strong>
                        </td>

                        <td>
                            {{ $customer->email }}
                        </td>

                        <td>

                            <strong style="color:#15803d">
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
                            style="text-align:center"
                        >
                            No customers found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection