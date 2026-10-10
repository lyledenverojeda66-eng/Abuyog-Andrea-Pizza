
@extends('admin.layout')

@section('title', 'Admin Profile')

@section('content')

<style>
    .profile-page { width: 100%; color: #111827; }
    .profile-header { margin-bottom: 18px; }
    .profile-header h1 { margin: 0; font-size: 25px; font-weight: 800; }
    .profile-header p { margin: 6px 0 0; color: #6b7280; font-size: 13px; }

    .profile-layout {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 18px;
        align-items: start;
    }

    .profile-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        min-width: 0;
    }

    .profile-left { text-align: center; }

    .avatar-wrapper {
        width: 110px;
        height: 110px;
        position: relative;
        margin: 0 auto 14px;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #dcfce7;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
        border: 3px solid #bbf7d0;
    }

    .camera-button {
        position: absolute;
        right: 0;
        bottom: 2px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid white;
        background: #15803d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 17px;
    }

    .camera-button:hover { background: #166534; }

    .profile-name {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .profile-role {
        display: inline-block;
        margin-top: 7px;
        padding: 5px 10px;
        border-radius: 999px;
        background: #dcfce7;
        color: #166534;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .profile-description {
        margin: 12px 0 0;
        color: #6b7280;
        font-size: 11px;
        line-height: 1.5;
    }

    .profile-actions {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .profile-dashboard-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 14px;
        border-radius: 7px;
        background: #15803d;
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .profile-dashboard-button:hover {
        background: #166534;
        color: white;
    }

    .profile-info-title {
        margin: 0 0 18px;
        font-size: 16px;
        font-weight: 800;
    }

    .profile-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .form-group { min-width: 0; }
    .form-group.full-width { grid-column: 1 / -1; }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #374151;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        padding: 11px 12px;
        font-size: 13px;
        background: white;
        color: #111827;
        outline: none;
    }

    .form-control:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 3px rgba(21,128,61,.12);
    }

    textarea.form-control {
        min-height: 95px;
        resize: vertical;
    }

    .profile-save-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .save-button {
        background: #15803d;
        color: white;
        border: 0;
        border-radius: 7px;
        padding: 11px 18px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .save-button:hover { background: #166534; }

    .profile-note {
        margin-top: 18px;
        padding: 12px;
        border-radius: 8px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 11px;
        line-height: 1.5;
    }

    .alert-success {
        margin-bottom: 16px;
        padding: 12px 15px;
        border-radius: 8px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 13px;
    }

    .alert-danger {
        margin-bottom: 16px;
        padding: 12px 15px;
        border-radius: 8px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 13px;
    }

    .field-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 11px;
    }

    .help-text {
        display: block;
        margin-top: 5px;
        color: #6b7280;
        font-size: 11px;
    }

    @media (max-width: 750px) {
        .profile-layout { grid-template-columns: 1fr; }
        .profile-form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: auto; }
        .profile-header h1 { font-size: 21px; }
    }
</style>

@php
    $admin = auth()->user();
    $name = $admin->name ?? 'Administrator';
    $nameParts = preg_split('/\s+/', trim($name));
    $initials = '';

    foreach ($nameParts as $part) {
        if ($part !== '') {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        if (strlen($initials) >= 2) {
            break;
        }
    }
@endphp

<div class="profile-page">

    <div class="profile-header">
        <h1>Admin Profile</h1>
        <p>Manage your administrator account information.</p>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Please check the following:</strong>
            <ul style="margin: 8px 0 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-layout">

        {{-- LEFT PROFILE CARD --}}
        <div class="profile-card profile-left">

            <div class="avatar-wrapper">

                @if ($admin->profile_picture)
                    <img
                        id="profilePreview"
                        class="profile-avatar"
                        src="{{ asset('storage/' . $admin->profile_picture) }}"
                        alt="Admin Profile Picture"
                    >
                @else
                    <div
                        id="profileInitials"
                        class="profile-avatar"
                    >
                        {{ $initials ?: 'A' }}
                    </div>

                    <img
                        id="profilePreview"
                        class="profile-avatar"
                        src=""
                        alt="Profile Preview"
                        style="display: none;"
                    >
                @endif

                <label
                    for="profile_picture"
                    class="camera-button"
                    title="Change profile picture"
                >
                    &#128247;
                </label>

            </div>

            <h2 class="profile-name" id="previewName">
                {{ $admin->name ?? 'Administrator' }}
            </h2>

            <span class="profile-role">
                {{ ucfirst($admin->role ?? 'Administrator') }}
            </span>

            <p class="profile-description">
                Abuyog Andrea Pizza administrator account.
                Click the camera icon to change your picture.
            </p>

            <div class="profile-actions">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="profile-dashboard-button"
                >
                    &larr; Dashboard
                </a>
            </div>

            <div class="profile-note">
                <strong>Account ID:</strong>
                #{{ $admin->id }}

                <br>

                <strong>Account Created:</strong>
                {{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}

                <br>

                <strong>Last Updated:</strong>
                {{ $admin->updated_at ? $admin->updated_at->format('M d, Y') : 'N/A' }}
            </div>

        </div>

        {{-- RIGHT EDIT PROFILE CARD --}}
        <div class="profile-card">

            <h2 class="profile-info-title">
                Edit Account Information
            </h2>

            <form
                id="adminProfileForm"
                action="{{ route('admin.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <div class="profile-form-grid">

                    {{-- PROFILE PICTURE --}}
                    <div class="form-group full-width">
                        <label for="profile_picture">
                            Profile Picture
                        </label>

                        <input
                            type="file"
                            name="profile_picture"
                            id="profile_picture"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        >

                        <span class="help-text">
                            JPG, JPEG, PNG, or WEBP. Maximum size: 2 MB.
                        </span>

                        @error('profile_picture')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- NAME --}}
                    <div class="form-group">
                        <label for="name">Full Name *</label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name', $admin->name) }}"
                            maxlength="255"
                            required
                        >

                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label for="email">Email Address *</label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ old('email', $admin->email) }}"
                            maxlength="255"
                            required
                        >

                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PHONE --}}
                    <div class="form-group">
                        <label for="phone">Phone Number</label>

                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control"
                            value="{{ old('phone', $admin->phone) }}"
                            maxlength="30"
                            placeholder="Enter phone number"
                        >

                        @error('phone')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ADDRESS --}}
                    <div class="form-group">
                        <label for="address">Address</label>

                        <textarea
                            name="address"
                            id="address"
                            class="form-control"
                            maxlength="500"
                            placeholder="Enter your address"
                        >{{ old('address', $admin->address) }}</textarea>

                        @error('address')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="profile-save-row">
                    <button type="submit" class="save-button">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('profile_picture');
    const preview = document.getElementById('profilePreview');
    const initials = document.getElementById('profileInitials');
    const nameInput = document.getElementById('name');
    const previewName = document.getElementById('previewName');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Please select a JPG, PNG, or WEBP image.');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('The image must not exceed 2 MB.');
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = 'flex';

                if (initials) {
                    initials.style.display = 'none';
                }
            };

            reader.readAsDataURL(file);
        });
    }

    if (nameInput && previewName) {
        nameInput.addEventListener('input', function () {
            previewName.textContent = this.value || 'Administrator';
        });
    }
});
</script>

@endsection