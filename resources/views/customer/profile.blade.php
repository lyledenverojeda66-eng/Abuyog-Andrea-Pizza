
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Profile - Abuyog Andrea Pizza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f9fafb;
            color: #1f2937;
        }

        .profile-page {
            max-width: 1000px;
            margin: 35px auto;
            padding: 20px;
        }

        .profile-heading {
            margin-bottom: 25px;
        }

        .profile-heading h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .profile-heading p {
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }

        .profile-card {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .profile-sidebar {
            background: #f0fdf4;
            padding: 30px 20px;
            text-align: center;
            border-right: 1px solid #dcfce7;
        }

        .profile-avatar {
            width: 125px;
            height: 125px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #16a34a;
            background: #fff;
            margin-bottom: 15px;
        }

        .profile-sidebar h3 {
            font-size: 19px;
            font-weight: 700;
            overflow-wrap: anywhere;
            margin: 5px 0 8px;
        }

        .profile-sidebar p {
            color: #6b7280;
            font-size: 14px;
            overflow-wrap: anywhere;
            line-height: 1.5;
            margin: 6px 0;
        }

        .profile-form {
            padding: 30px;
            min-width: 0;
        }

        .profile-form h2 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 22px;
        }

        .profile-field {
            margin-bottom: 18px;
        }

        .profile-field label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 7px;
        }

        .profile-field input,
        .profile-field textarea {
            display: block;
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font: inherit;
            background: #fff;
            color: #1f2937;
            outline: none;
        }

        .profile-field input:focus,
        .profile-field textarea:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
        }

        .profile-field input[type="file"] {
            padding: 9px;
            font-size: 13px;
        }

        .profile-field textarea {
            resize: vertical;
            min-height: 90px;
        }

        .profile-hint {
            display: block;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.5;
            margin-top: 6px;
        }

        .profile-error {
            color: #dc2626;
            font-size: 13px;
            line-height: 1.5;
            margin-top: 5px;
        }

        .profile-success {
            padding: 12px 15px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .profile-validation {
            padding: 12px 15px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .profile-validation ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .profile-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .profile-save,
        .profile-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .profile-save {
            background: #16a34a;
            color: #fff;
        }

        .profile-save:hover {
            background: #15803d;
        }

        .profile-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .profile-cancel {
            color: #374151;
            background: #f3f4f6;
        }

        .profile-cancel:hover {
            background: #e5e7eb;
        }

        @media (max-width: 700px) {
            .profile-page {
                margin: 15px auto;
                padding: 12px;
            }

            .profile-heading h1 {
                font-size: 24px;
            }

            .profile-card {
                grid-template-columns: minmax(0, 1fr);
            }

            .profile-sidebar {
                border-right: none;
                border-bottom: 1px solid #dcfce7;
            }

            .profile-form {
                padding: 22px 18px;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    @php
        $user = $user ?? auth()->user();
    @endphp

    <main class="profile-page">

        <div class="profile-heading">
            <h1>My Profile</h1>
            <p>Manage your personal information and profile picture.</p>
        </div>

        @if (session('success'))
            <div class="profile-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-validation" role="alert">
                <strong>Please check the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-card">

            <aside class="profile-sidebar">

                @if ($user->profile_picture)
                    <img
                        id="profilePreview"
                        class="profile-avatar"
                        src="{{ asset('storage/' . $user->profile_picture) }}"
                        alt="Profile picture"
                    >

                    <div
                        id="defaultAvatar"
                        class="profile-avatar"
                        style="display:none; align-items:center; justify-content:center; color:#16a34a;"
                    >
                        <svg
                            width="65"
                            height="65"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M4 21a8 8 0 0 1 16 0"></path>
                        </svg>
                    </div>
                @else
                    <div
                        id="defaultAvatar"
                        class="profile-avatar"
                        style="display:inline-flex; align-items:center; justify-content:center; color:#16a34a;"
                    >
                        <svg
                            width="65"
                            height="65"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M4 21a8 8 0 0 1 16 0"></path>
                        </svg>
                    </div>

                    <img
                        id="profilePreview"
                        class="profile-avatar"
                        src=""
                        alt="Profile picture preview"
                        style="display:none;"
                    >
                @endif

                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <p>Customer Account</p>

            </aside>

            <section class="profile-form">

                <h2>Edit Personal Information</h2>

                <form
                    action="{{ route('customer.profile.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <div class="profile-field">
                        <label for="profile_picture">Profile Picture</label>

                        <input
                            type="file"
                            name="profile_picture"
                            id="profile_picture"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        >

                        <span class="profile-hint">
                            JPG, JPEG, PNG, or WebP. Maximum file size: 2 MB.
                        </span>

                        @error('profile_picture')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="name">Full Name</label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            maxlength="255"
                        >

                        @error('name')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="email">Email Address</label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            maxlength="255"
                        >

                        @error('email')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="phone">Phone Number</label>

                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            value="{{ old('phone', $user->phone) }}"
                            maxlength="30"
                            placeholder="Enter your phone number"
                        >

                        @error('phone')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-field">
                        <label for="address">Delivery Address</label>

                        <textarea
                            name="address"
                            id="address"
                            maxlength="1000"
                            placeholder="Enter your complete delivery address"
                        >{{ old('address', $user->address) }}</textarea>

                        @error('address')
                            <div class="profile-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="profile-save">
                            Save Changes
                        </button>

                        <a
                            href="{{ url('/dashboard') }}"
                            class="profile-cancel"
                        >
                            Cancel
                        </a>
                    </div>

                </form>

            </section>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('profile_picture');
            const preview = document.getElementById('profilePreview');
            const defaultAvatar = document.getElementById('defaultAvatar');

            if (!input || !preview) {
                return;
            }

            let previewUrl = null;

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    return;
                }

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a JPG, PNG, or WebP image.');
                    this.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('The image must not exceed 2 MB.');
                    this.value = '';
                    return;
                }

                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                }

                previewUrl = URL.createObjectURL(file);
                preview.src = previewUrl;
                preview.style.display = 'inline-block';

                if (defaultAvatar) {
                    defaultAvatar.style.display = 'none';
                }
            });

            window.addEventListener('beforeunload', function () {
                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                }
            });
        });
    </script>

</body>
</html>