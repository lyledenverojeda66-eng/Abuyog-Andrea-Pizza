@extends('admin.layout')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Banner Management</h2>
            <p class="text-muted mb-0">
                Manage the banners displayed on the customer home page.
            </p>
        </div>

        <a href="{{ route('admin.banners.create') }}"
           class="btn btn-primary">
            + Add Banner
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if($banners->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th width="90">Image</th>
                                <th>Banner</th>
                                <th width="100">Order</th>
                                <th width="120">Status</th>
                                <th width="250">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($banners as $banner)

                                <tr>

                                    <td>
                                        <img
                                            src="{{ asset('image/banners/' . $banner->image) }}"
                                            alt="{{ $banner->title ?? 'Banner' }}"
                                            style="
                                                width:80px;
                                                height:55px;
                                                object-fit:cover;
                                                border-radius:8px;
                                                border:1px solid #ddd;
                                            "
                                        >
                                    </td>

                                    <td>

                                        <div class="fw-bold">
                                            {{ $banner->title ?: 'Untitled Banner' }}
                                        </div>

                                        @if($banner->description)
                                            <div class="text-muted small mt-1">
                                                {{ \Illuminate\Support\Str::limit($banner->description, 100) }}
                                            </div>
                                        @endif

                                        @if($banner->button_text)
                                            <div class="small mt-1">
                                                Button:
                                                <strong>{{ $banner->button_text }}</strong>
                                            </div>
                                        @endif

                                    </td>

                                    <td>
                                        {{ $banner->sort_order }}
                                    </td>

                                    <td>

                                        @if($banner->status)

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="d-flex gap-2 flex-wrap">

                                            <a
                                                href="{{ route('admin.banners.edit', $banner) }}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Edit
                                            </a>

                                           <form
    action="{{ route('admin.banners.toggle', $banner) }}"
    method="POST"
    style="display: inline;"
>
    @csrf

    <button
        type="submit"
        class="btn btn-sm btn-outline-warning"
    >
        {{ $banner->status ? 'Deactivate' : 'Activate' }}
    </button>
</form>
                                            <form
                                                action="{{ route('admin.banners.destroy', $banner) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this banner?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div style="font-size:50px;">
                        🖼️
                    </div>

                    <h4 class="mt-3">
                        No banners yet
                    </h4>

                    <p class="text-muted">
                        Add your first banner to display it on the customer home page.
                    </p>

                    <a
                        href="{{ route('admin.banners.create') }}"
                        class="btn btn-primary"
                    >
                        + Add Banner
                    </a>

                </div>

            @endif

        </div>
    </div>

</div>

@endsection