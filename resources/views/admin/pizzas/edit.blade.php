@extends('admin.layout')

@section('title', 'Edit Pizza')

@section('content')

<style>

    .pizza-edit-page {
        width: 100%;
    }

    /* PAGE HEADER */
    .pizza-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .pizza-page-header-left h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #15803d;
    }

    .pizza-page-header-left p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    /* BACK BUTTON */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        background: #ffffff;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .15s ease;
    }

    .back-button:hover {
        background: #f3f4f6;
        color: #15803d;
        border-color: #15803d;
    }

    /* FORM CARD */
    .pizza-form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 26px;
        max-width: 900px;
    }

    /* FORM GROUP */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #111827;
        font-size: 13px;
        font-weight: 800;
    }

    .required {
        color: #dc2626;
    }

    .form-control,
    .form-select,
    .form-textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: .15s ease;
    }

    .form-control:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px #dcfce7;
    }

    .form-textarea {
        min-height: 110px;
        resize: vertical;
    }

    /* TWO COLUMN */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* HELP TEXT */
    .form-help {
        margin-top: 5px;
        color: #9ca3af;
        font-size: 11px;
    }

    /* CHECKBOX */
    .active-box {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 13px 15px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .active-box input {
        width: 16px;
        height: 16px;
        accent-color: #16a34a;
    }

    .active-box label {
        color: #1f2937;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    /* IMAGE PREVIEW */
    .image-preview {
        margin-top: 10px;
        padding: 12px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .image-preview-title {
        margin-bottom: 8px;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .image-preview img {
        display: block;
        width: 130px;
        height: 90px;
        object-fit: cover;
        border-radius: 7px;
        border: 1px solid #e5e7eb;
    }

    /* ERROR */
    .validation-error {
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    /* FORM ACTIONS */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .cancel-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        background: #ffffff;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .cancel-button:hover {
        background: #f3f4f6;
    }

    .update-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        background: #16a34a;
        color: #ffffff;
        border: 1px solid #16a34a;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .15s ease;
    }

    .update-button:hover {
        background: #15803d;
        border-color: #15803d;
    }

    /* SUCCESS / ERROR */
    .alert {
        padding: 12px 15px;
        margin-bottom: 18px;
        border-radius: 8px;
        font-size: 13px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* MOBILE */
    @media (max-width: 700px) {

        .pizza-page-header {
            flex-direction: column;
        }

        .pizza-form-card {
            padding: 18px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .cancel-button,
        .update-button {
            width: 100%;
        }

    }

</style>


<div class="pizza-edit-page">


    {{-- ============================================================
         PAGE HEADER
    ============================================================= --}}

    <div class="pizza-page-header">

        <div class="pizza-page-header-left">

            <h1>
                🍕 Edit Pizza
            </h1>

            <p>
                Update pizza information.
            </p>

        </div>


        <a
            href="{{ route('admin.pizzas') }}"
            class="back-button"
        >
            ← Back to Pizza Menu
        </a>

    </div>


    {{-- ============================================================
         SUCCESS MESSAGE
    ============================================================= --}}

    @if(session('success'))

        <div class="alert alert-success">

            ✓ {{ session('success') }}

        </div>

    @endif


    {{-- ============================================================
         ERROR MESSAGE
    ============================================================= --}}

    @if(session('error'))

        <div class="alert alert-error">

            ⚠ {{ session('error') }}

        </div>

    @endif


    {{-- ============================================================
         VALIDATION ERRORS
    ============================================================= --}}

    @if($errors->any())

        <div class="alert alert-error">

            <strong>
                Please fix the following:
            </strong>

            <ul
                style="
                    margin:8px 0 0 18px;
                    padding:0;
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


    {{-- ============================================================
         FORM
    ============================================================= --}}

    <div class="pizza-form-card">

        <form
            action="{{ route('admin.pizzas.update', $pizza->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            {{-- ====================================================
                 CATEGORY
            ===================================================== --}}

            <div class="form-group">

                <label
                    for="category_id"
                    class="form-label"
                >
                    Category
                    <span class="required">*</span>
                </label>


                <select
                    name="category_id"
                    id="category_id"
                    class="form-select"
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
                                $pizza->category_id
                            ) == $category->id
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>


                @error('category_id')

                    <div class="validation-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ====================================================
                 PIZZA NAME
            ===================================================== --}}

            <div class="form-group">

                <label
                    for="name"
                    class="form-label"
                >
                    Pizza Name
                    <span class="required">*</span>
                </label>


                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name', $pizza->name) }}"
                    placeholder="Enter pizza name"
                    required
                >


                @error('name')

                    <div class="validation-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ====================================================
                 DESCRIPTION
            ===================================================== --}}

            <div class="form-group">

                <label
                    for="description"
                    class="form-label"
                >
                    Description
                </label>


                <textarea
                    name="description"
                    id="description"
                    class="form-textarea"
                    placeholder="Enter pizza description"
                >{{ old('description', $pizza->description) }}</textarea>


                @error('description')

                    <div class="validation-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ====================================================
                 PRICE + STOCK
            ===================================================== --}}

            <div class="form-row">


                {{-- PRICE --}}

                <div class="form-group">

                    <label
                        for="price"
                        class="form-label"
                    >
                        Price
                        <span class="required">*</span>
                    </label>


                    <input
                        type="number"
                        name="price"
                        id="price"
                        class="form-control"
                        value="{{ old('price', $pizza->price) }}"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required
                    >


                    @error('price')

                        <div class="validation-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- STOCK --}}

                <div class="form-group">

                    <label
                        for="stock"
                        class="form-label"
                    >
                        Stock
                        <span class="required">*</span>
                    </label>


                    <input
                        type="number"
                        name="stock"
                        id="stock"
                        class="form-control"
                        value="{{ old('stock', $pizza->stock) }}"
                        min="0"
                        placeholder="0"
                        required
                    >


                    <div class="form-help">
                        Number of available pizzas.
                    </div>


                    @error('stock')

                        <div class="validation-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- ====================================================
                 IMAGE PATH
            ===================================================== --}}

            <div class="form-group">

                <label
                    for="image"
                    class="form-label"
                >
                    Image Path
                </label>


                <input
                    type="text"
                    name="image"
                    id="image"
                    class="form-control"
                    value="{{ old('image', $pizza->image) }}"
                    placeholder="image/pizzas/pizza.png"
                >


                <div class="form-help">

                    Example:
                    image/pizzas/Hawaiian pizza.png

                </div>


                @error('image')

                    <div class="validation-error">
                        {{ $message }}
                    </div>

                @enderror


                {{-- IMAGE PREVIEW --}}

                @if($pizza->image)

                    <div class="image-preview">

                        <div class="image-preview-title">
                            Current Image
                        </div>


                        <img
                            src="{{ asset($pizza->image) }}"
                            alt="{{ $pizza->name }}"
                            onerror="
                                this.style.display='none';
                            "
                        >

                    </div>

                @endif

            </div>


            {{-- ====================================================
                 ACTIVE PIZZA
            ===================================================== --}}

            <div class="form-group">

                <div class="active-box">

                    <input
                        type="checkbox"
                        name="status"
                        id="status"
                        value="1"
                        {{ old(
                            'status',
                            $pizza->status
                        )
                            ? 'checked'
                            : ''
                        }}
                    >


                    <label for="status">
                        Active Pizza
                    </label>

                </div>

            </div>


            {{-- ====================================================
                 FORM ACTIONS
            ===================================================== --}}

            <div class="form-actions">


                <a
                    href="{{ route('admin.pizzas') }}"
                    class="cancel-button"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="update-button"
                >
                    ✓ Update Pizza
                </button>


            </div>


        </form>

    </div>

</div>

@endsection