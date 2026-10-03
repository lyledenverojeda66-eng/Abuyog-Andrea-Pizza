@extends('admin.layout')

@section('content')

<div class="page-header">
    <div>
        <h1>
            {{ $isEdit ? 'Edit Pizza' : 'Add New Pizza' }}
        </h1>

        <p>
            {{ $isEdit
                ? 'Update pizza information and stock.'
                : 'Add a new pizza to your menu.'
            }}
        </p>
    </div>

    <a
        href="{{ route('admin.pizzas') }}"
        class="back-btn"
    >
        ← Back to Pizza Menu
    </a>
</div>


<div class="form-card">

    @if ($errors->any())

        <div class="error-box">

            <strong>
                Please fix the following errors:
            </strong>

            <ul>
                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach
            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{
            $isEdit
                ? route('admin.pizzas.update', $pizza)
                : route('admin.pizzas.store')
        }}"
    >

        @csrf

        @if($isEdit)
            @method('PUT')
        @endif


        {{-- PIZZA NAME --}}

        <div class="form-group">

            <label for="name">
                Pizza Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $pizza?->name) }}"
                placeholder="Example: Chicken Supreme"
                required
            >

        </div>


        {{-- CATEGORY --}}

        <div class="form-group">

            <label for="category_id">
                Category
            </label>

            <select
                id="category_id"
                name="category_id"
                required
            >

                <option value="">
                    Select Category
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old(
                            'category_id',
                            $pizza?->category_id
                        ) == $category->id
                            ? 'selected'
                            : ''
                        }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- PRICE --}}

        <div class="form-group">

            <label for="price">
                Price
            </label>

            <input
                type="number"
                id="price"
                name="price"
                step="0.01"
                min="0"
                value="{{ old('price', $pizza?->price) }}"
                placeholder="115.00"
                required
            >

        </div>


        {{-- STOCK --}}

        <div class="form-group">

            <label for="stock">
                Stock
            </label>

            <input
                type="number"
                id="stock"
                name="stock"
                min="0"
                value="{{ old('stock', $pizza?->stock ?? 0) }}"
                placeholder="20"
                required
            >

            <small>
                Enter the number of available pizzas.
            </small>

        </div>


        {{-- DESCRIPTION --}}

        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Describe this pizza..."
            >{{ old('description', $pizza?->description) }}</textarea>

        </div>


        {{-- IMAGE --}}

        <div class="form-group">

            <label for="image">
                Image
            </label>

            <input
                type="text"
                id="image"
                name="image"
                value="{{ old('image', $pizza?->image) }}"
                placeholder="images/pizza.jpg"
            >

            <small>
                Optional image path or URL.
            </small>

        </div>


        {{-- STATUS --}}

        <div class="checkbox-group">

            <input
                type="checkbox"
                id="status"
                name="status"
                value="1"
                {{ old(
                    'status',
                    $pizza?->status ?? true
                ) ? 'checked' : '' }}
            >

            <label for="status">
                Active / Available
            </label>

        </div>


        {{-- BUTTONS --}}

        <div class="form-actions">

            <a
                href="{{ route('admin.pizzas') }}"
                class="cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="save-btn"
            >
                {{ $isEdit
                    ? 'Update Pizza'
                    : 'Add Pizza'
                }}
            </button>

        </div>

    </form>

</div>


<style>

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.page-header h1 {
    margin: 0;
    color: #166534;
}

.page-header p {
    margin-top: 6px;
    color: #64748b;
}

.back-btn {
    text-decoration: none;
    background: #dcfce7;
    color: #166534;
    padding: 12px 18px;
    border-radius: 10px;
    font-weight: 700;
}

.form-card {
    max-width: 800px;
    background: white;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 700;
    color: #166534;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 13px 14px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 15px;
    outline: none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #16a34a;
    box-shadow: 0 0 0 3px #dcfce7;
}

.form-group small {
    display: block;
    margin-top: 6px;
    color: #64748b;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
}

.checkbox-group input {
    width: 18px;
    height: 18px;
}

.checkbox-group label {
    font-weight: 700;
    color: #166534;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.cancel-btn,
.save-btn {
    padding: 13px 20px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.cancel-btn {
    background: #f1f5f9;
    color: #334155;
}

.save-btn {
    background: #16a34a;
    color: white;
}

.save-btn:hover {
    background: #15803d;
}

.error-box {
    background: #fee2e2;
    color: #991b1b;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.error-box ul {
    margin-bottom: 0;
}

@media (max-width: 700px) {

    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-card {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column;
    }

    .cancel-btn,
    .save-btn {
        text-align: center;
        width: 100%;
        box-sizing: border-box;
    }

}

</style>

@endsection