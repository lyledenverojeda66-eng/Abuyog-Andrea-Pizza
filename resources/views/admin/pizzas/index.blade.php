@extends('admin.layout')

@section('title', 'Pizza Menu')

@section('content')

<style>
    .pizza-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .pizza-page-header h1 {
        margin: 0 0 5px;
        font-size: 24px;
        font-weight: 800;
        color: #111827;
    }

    .pizza-page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .pizza-count {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .pizza-alert {
        padding: 12px 15px;
        border-radius: 9px;
        margin-bottom: 15px;
        font-size: 13px;
        font-weight: 700;
    }

    .pizza-alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
    }

    .pizza-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .pizza-table-card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        padding: 18px 20px;
        overflow-x: auto;
    }

    .pizza-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .pizza-table thead th {
        background: #effcf4;
        color: #183b29;
        font-size: 12px;
        font-weight: 800;
        text-align: left;
        padding: 12px 13px;
        border-bottom: 1px solid #c9efd8;
    }

    .pizza-table tbody td {
        padding: 13px;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
        vertical-align: middle;
    }

    .pizza-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pizza-table tbody tr:hover {
        background: #fcfffd;
    }

    /* =========================================
       SAME PICTURE SIZE/STYLE AS MENU
    ========================================= */

    .admin-pizza-image-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        overflow: hidden;
        background: #f5f5f5;
    }

    .admin-pizza-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
    }

    .admin-pizza-name {
        color: #111827;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .admin-pizza-description {
        color: #8a94a6;
        font-size: 12px;
        line-height: 1.4;
        max-width: 380px;
    }

    .admin-pizza-category {
        color: #374151;
        font-size: 13px;
    }

    .admin-pizza-price {
        color: #07843b;
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-pizza-stock {
        color: #07843b;
        font-weight: 800;
    }

    .admin-pizza-stock-out {
        color: #dc2626;
        font-weight: 800;
    }

    .admin-pizza-status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
    }

    .admin-pizza-status-active {
        background: #d9f8e5;
        color: #08783a;
    }

    .admin-pizza-status-inactive {
        background: #eeeeee;
        color: #666666;
    }

    .admin-pizza-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .admin-pizza-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #10a64f;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 9px 13px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
    }

    .admin-pizza-edit:hover {
        background: #07883e;
        color: white;
    }

    .admin-pizza-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffe1e1;
        color: #dc2626;
        border: 1px solid #ffc4c4;
        border-radius: 9px;
        padding: 9px 13px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
    }

    .admin-pizza-delete:hover {
        background: #ffd0d0;
    }

    .pizza-empty {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }

    .pizza-empty h3 {
        margin-bottom: 8px;
        color: #111827;
    }

    @media (max-width: 700px) {
        .pizza-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .pizza-table-card {
            padding: 10px;
        }
    }
</style>


{{-- =========================================================
     SUCCESS / ERROR MESSAGES
========================================================= --}}

@if(session('success'))
    <div class="pizza-alert pizza-alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="pizza-alert pizza-alert-error">
        ⚠️ {{ session('error') }}
    </div>
@endif


{{-- =========================================================
     EXACT SAME IMAGE MAPPING FROM CUSTOMER MENU
     
     SOURCE:
     public/image/pizzas/
========================================================= --}}

@php
    $pizzaImages = [
        'Ham & Cheese' =>
            asset('image/pizzas/Ham & Cheese Pizza.png'),

        'Hawaiian' =>
            asset('image/pizzas/Hawaiian pizza.png'),

        'Pepperoni' =>
            asset('image/pizzas/Pepperoni pizza.png'),

        'Bacon' =>
            asset('image/pizzas/bacon.png.webp'),

        'Beef' =>
            asset('image/pizzas/Beef.png'),

        'Vegetarian' =>
            asset('image/pizzas/Vegetarian.png'),
    ];
@endphp


{{-- =========================================================
     PAGE HEADER
========================================================= --}}

<div class="pizza-page-header">

    <div>

        <h1>
            🍕 Pizza Products
        </h1>

        <p>
            View and manage all pizza products.
        </p>

    </div>

    <div class="pizza-count">
        {{ $pizzas->count() }} Pizzas
    </div>

</div>


{{-- =========================================================
     PIZZA TABLE
========================================================= --}}

<div class="pizza-table-card">

    @if($pizzas->count() > 0)

        <table class="pizza-table">

            <thead>

                <tr>

                    <th>
                        Image
                    </th>

                    <th>
                        Pizza
                    </th>

                    <th>
                        Category
                    </th>

                    <th>
                        Price
                    </th>

                    <th>
                        Stock
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($pizzas as $pizza)

                    @php
                        /*
                        |--------------------------------------------------------------------------
                        | GET EXACT SAME IMAGE USED BY CUSTOMER MENU
                        |--------------------------------------------------------------------------
                        */

                        $image = $pizzaImages[$pizza->name]
                            ?? asset('image/pizzas/Beef.png');
                    @endphp

                    <tr>

                        {{-- =================================================
                             IMAGE
                        ================================================== --}}

                        <td>

                            <div class="admin-pizza-image-wrapper">

                                <img
                                    src="{{ $image }}"
                                    alt="{{ $pizza->name }}"
                                    class="admin-pizza-image"
                                >

                            </div>

                        </td>


                        {{-- =================================================
                             PIZZA NAME + DESCRIPTION
                        ================================================== --}}

                        <td>

                            <div class="admin-pizza-name">
                                {{ $pizza->name }}
                            </div>

                            <div class="admin-pizza-description">
                                {{ $pizza->description }}
                            </div>

                        </td>


                        {{-- =================================================
                             CATEGORY
                        ================================================== --}}

                        <td>

                            <span class="admin-pizza-category">

                                {{ $pizza->category->name ?? 'Uncategorized' }}

                            </span>

                        </td>


                        {{-- =================================================
                             PRICE
                        ================================================== --}}

                        <td>

                            <span class="admin-pizza-price">

                                ₱{{ number_format((float) $pizza->price, 2) }}

                            </span>

                        </td>


                        {{-- =================================================
                             STOCK
                        ================================================== --}}

                        <td>

                            @if($pizza->stock > 0)

                                <span class="admin-pizza-stock">

                                    {{ $pizza->stock }}

                                </span>

                            @else

                                <span class="admin-pizza-stock-out">

                                    0

                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                             STATUS
                        ================================================== --}}

                        <td>

                            @if($pizza->status)

                                <span
                                    class="
                                        admin-pizza-status
                                        admin-pizza-status-active
                                    "
                                >

                                    Active

                                </span>

                            @else

                                <span
                                    class="
                                        admin-pizza-status
                                        admin-pizza-status-inactive
                                    "
                                >

                                    Inactive

                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                             ACTIONS
                        ================================================== --}}

                        <td>

                            <div class="admin-pizza-actions">

                                <a
                                    href="{{ route('admin.pizzas.edit', $pizza->id) }}"
                                    class="admin-pizza-edit"
                                >
                                    ✏️ Edit
                                </a>


                                <form
                                    action="{{ route('admin.pizzas.destroy', $pizza->id) }}"
                                    method="POST"
                                    style="margin: 0;"
                                    onsubmit="return confirm('Are you sure you want to delete this pizza?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="admin-pizza-delete"
                                    >
                                        🗑 Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <div class="pizza-empty">

            <h3>
                🍕 No Pizza Products Found
            </h3>

            <p>
                There are currently no pizza products available.
            </p>

        </div>

    @endif

</div>

@endsection