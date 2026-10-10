
@extends('admin.layout')

@section('title', 'Edit Banner')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Banner</h2>
            <p class="text-muted mb-0">Update your banner details.</p>
        </div>

        <a href="{{ route('admin.banners.index') }}"
           class="btn btn-secondary">
            Back to Banners
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form
                action="{{ route('admin.banners.update', $banner) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">
                        Banner Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title', $banner->title) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="3"
                    >{{ old('description', $banner->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>

                    <div class="mb-3">
                        <img
                            src="{{ asset('storage/' . $banner->image) }}"
                            alt="Current banner"
                            style="max-width: 300px; max-height: 180px; object-fit: contain;"
                        >
                    </div>

                    <label for="image" class="form-label">
                        Replace Image (optional)
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                    >
                </div>

                <div class="mb-3">
                    <label for="button_text" class="form-label">
                        Button Text
                    </label>

                    <input
                        type="text"
                        name="button_text"
                        id="button_text"
                        class="form-control"
                        value="{{ old('button_text', $banner->button_text) }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="button_link" class="form-label">
                        Button Link
                    </label>

                    <input
                        type="text"
                        name="button_link"
                        id="button_link"
                        class="form-control"
                        value="{{ old('button_link', $banner->button_link) }}"
                    >
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        class="form-control"
                        min="0"
                        value="{{ old('sort_order', $banner->sort_order) }}"
                    >
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        name="status"
                        id="status"
                        value="1"
                        class="form-check-input"
                        {{ old('status', $banner->status) ? 'checked' : '' }}
                    >

                    <label for="status" class="form-check-label">
                        Active Banner
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a
                    href="{{ route('admin.banners.index') }}"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

@endsection