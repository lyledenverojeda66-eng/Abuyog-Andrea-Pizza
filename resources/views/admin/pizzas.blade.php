@extends('admin.layout')

@section('content')

<div class="page-header">

    <div>
        <h1>Pizza Menu</h1>

        <p>
            Manage your pizza products, prices, and stock.
        </p>
    </div>

    <a
        href="{{ route('admin.pizzas.create') }}"
        class="add-btn"
    >
        + Add Pizza
    </a>

</div>


@if(session('success'))

    <div class="success-message">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="error-message">
        {{ session('error') }}
    </div>

@endif


<div class="table-card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Pizza</th>

                    <th>Description</th>

                    <th>Category</th>

                    <th>Price</th>

                    <th>Stock</th>

                    <th>Status</th>

                    <th>Created</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($pizzas as $pizza)

                    <tr>

                        <td>

                            <strong>
                                {{ $pizza->name }}
                            </strong>

                        </td>


                        <td>

                            {{ $pizza->description
                                ?: 'No description'
                            }}

                        </td>


                        <td>

                            {{ $pizza->category?->name
                                ?? 'No Category'
                            }}

                        </td>


                        <td>

                            <strong>
                                ₱{{ number_format(
                                    $pizza->price,
                                    2
                                ) }}
                            </strong>

                        </td>


                        {{-- STOCK --}}

                        <td>

                            @if($pizza->stock > 0)

                                <span class="stock-badge in-stock">

                                    {{ $pizza->stock }}

                                    available

                                </span>

                            @else

                                <span class="stock-badge out-stock">

                                    Out of Stock

                                </span>

                            @endif

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($pizza->status)

                                <span class="status active">
                                    Active
                                </span>

                            @else

                                <span class="status inactive">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td>

                            {{ $pizza->created_at
                                ? $pizza->created_at->format('M d, Y')
                                : '-'
                            }}

                        </td>


                        {{-- ACTIONS --}}

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route(
                                        'admin.pizzas.edit',
                                        $pizza
                                    ) }}"
                                    class="edit-btn"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.pizzas.destroy',
                                        $pizza
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Are you sure you want to delete this pizza?'
                                    );"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty"
                        >

                            No pizzas found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<style>

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 20px;
}

.page-header h1 {
    margin: 0;
    color: #166534;
}

.page-header p {
    color: #64748b;
    margin-top: 6px;
}

.add-btn {
    background: #16a34a;
    color: white;
    padding: 13px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
}

.add-btn:hover {
    background: #15803d;
}

.success-message {
    background: #dcfce7;
    color: #166534;
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: 600;
}

.error-message {
    background: #fee2e2;
    color: #991b1b;
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: 600;
}

.table-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 950px;
}

thead {
    background: #f0fdf4;
}

th {
    padding: 16px;
    text-align: left;
    color: #166534;
    font-size: 14px;
    white-space: nowrap;
}

td {
    padding: 16px;
    border-top: 1px solid #f1f5f9;
    color: #475569;
    vertical-align: middle;
}

.stock-badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

.in-stock {
    background: #dcfce7;
    color: #166534;
}

.out-stock {
    background: #fee2e2;
    color: #991b1b;
}

.status {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
}

.status.active {
    background: #dcfce7;
    color: #166534;
}

.status.inactive {
    background: #f1f5f9;
    color: #475569;
}

.actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.edit-btn {
    background: #dcfce7;
    color: #166534;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
}

.delete-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
}

.empty {
    text-align: center;
    padding: 40px;
    color: #64748b;
}

@media (max-width: 700px) {

    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection