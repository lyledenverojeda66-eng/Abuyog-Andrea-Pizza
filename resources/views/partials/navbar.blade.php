<nav class="navbar">

    <div class="navbar-container">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="logo">

            <div class="logo-icon">
                🍕
            </div>

            <div class="logo-text">
                <div>ABUYOG ANDREA</div>
                <strong>PIZZA</strong>
            </div>

        </a>

        {{-- NAVIGATION --}}
        <div class="nav-links">

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="{{ route('menu') }}">
                Menu
            </a>

            <a href="{{ route('contact') }}">
                Contact
            </a>

            @auth

                <a href="{{ route('customer.dashboard') }}">
                    Customer Dashboard
                </a>

                <a href="{{ route('cart') }}">
                    🛒 Cart
                </a>

                <a href="{{ route('orders') }}">
                    My Orders
                </a>

                {{-- CUSTOMER PROFILE ICON --}}
                <div class="profile-nav" id="profileNav">

                    <button
                        type="button"
                        class="profile-icon-btn"
                        id="profileToggle"
                        aria-label="Open customer profile"
                        aria-expanded="false"
                        aria-controls="profileDropdown"
                    >

                        @if (auth()->user()->profile_picture)
                            <img
                                src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                alt="Profile Picture"
                                class="profile-nav-image"
                            >
                        @else
                            <span class="profile-default-icon">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"></path>
                                </svg>
                            </span>
                        @endif

                    </button>

                    {{-- PROFILE DROPDOWN --}}
                    <div
                        class="profile-dropdown"
                        id="profileDropdown"
                        hidden
                    >

                        {{-- PROFILE HEADER --}}
                        <div class="profile-dropdown-header">

                            @if (auth()->user()->profile_picture)
                                <img
                                    src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                    alt="Profile Picture"
                                    class="profile-dropdown-image"
                                >
                            @else
                                <div class="profile-dropdown-placeholder">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="30"
                                        height="30"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <circle cx="12" cy="8" r="4"></circle>
                                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="profile-user-info">

                                <strong>
                                    {{ auth()->user()->name }}
                                </strong>

                                <span>
                                    {{ auth()->user()->email }}
                                </span>

                            </div>

                        </div>

                        <div class="profile-dropdown-divider"></div>

                        {{-- PROFILE INFORMATION --}}
                        <div class="profile-dropdown-details">

                            <div class="profile-detail-item">
                                <span class="profile-detail-label">
                                    Phone Number
                                </span>

                                <span class="profile-detail-value">
                                    {{ auth()->user()->phone ?? 'Not provided' }}
                                </span>
                            </div>

                            <div class="profile-detail-item">
                                <span class="profile-detail-label">
                                    Delivery Address
                                </span>

                                <span class="profile-detail-value">
                                    {{ auth()->user()->address ?? 'Not provided' }}
                                </span>
                            </div>

                        </div>

                        <div class="profile-dropdown-divider"></div>

                        {{-- EDIT PROFILE --}}
                        <a
                            href="{{ route('customer.profile') }}"
                            class="profile-edit-link"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L9 17l-4 1 1-4Z"></path>
                            </svg>

                            <span>Edit Profile</span>

                        </a>

                    </div>

                </div>

                {{-- LOGOUT --}}
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="logout-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn"
                    >
                        Logout
                    </button>

                </form>

            @else

                <a href="{{ route('login') }}">
                    Log in
                </a>

                <a href="{{ route('register') }}">
                    Sign in
                </a>

            @endauth

        </div>

    </div>

</nav>


<style>

/* ========================================
   NAVBAR
======================================== */

.navbar {
    width: 100%;
    background: #ffffff;

    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.10);

    position: relative;
    z-index: 1000;
}


/* ========================================
   NAVBAR CONTAINER
======================================== */

.navbar-container {
    width: 92%;
    max-width: 1400px;

    margin: 0 auto;

    min-height: 78px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;
}


/* ========================================
   LOGO
======================================== */

.logo {
    display: flex;
    align-items: center;
    gap: 8px;

    text-decoration: none;
    color: #16a34a;

    flex-shrink: 0;
}

.logo-icon {
    font-size: 30px;
    line-height: 1;
}

.logo-text {
    color: #16a34a;

    font-size: 20px;
    font-weight: 800;
    font-style: italic;
    line-height: 1;
}

.logo-text strong {
    display: block;

    margin-top: 2px;

    font-size: 27px;
    font-weight: 900;
    color: #16a34a;
}


/* ========================================
   NAVIGATION LINKS
======================================== */

.nav-links {
    display: flex;
    align-items: center;
    justify-content: flex-end;

    gap: 20px;
}

.nav-links > a {
    color: #000000;

    text-decoration: none;

    font-size: 14px;
    font-weight: 700;
    white-space: nowrap;

    transition: color 0.2s ease;
}

.nav-links > a:hover {
    color: #16a34a;
}


/* ========================================
   PROFILE ICON
======================================== */

.profile-nav {
    position: relative;

    display: flex;
    align-items: center;

    flex-shrink: 0;
}

.profile-icon-btn {
    width: 34px;
    height: 34px;

    padding: 0;

    border: 2px solid #16a34a;
    border-radius: 50%;

    background: #f0fdf4;
    color: #16a34a;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
    overflow: hidden;

    transition:
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.profile-icon-btn:hover {
    background: #dcfce7;
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
}

.profile-icon-btn:focus-visible {
    outline: 2px solid #16a34a;
    outline-offset: 3px;
}

.profile-nav-image {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
    border-radius: 50%;
}

.profile-default-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    line-height: 1;
}


/* ========================================
   PROFILE DROPDOWN
======================================== */

.profile-dropdown {
    position: absolute;

    top: calc(100% + 12px);
    right: 0;

    width: 300px;
    max-width: calc(100vw - 30px);

    padding: 16px;

    background: #ffffff;
    color: #111827;

    border: 1px solid #e5e7eb;
    border-radius: 12px;

    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.14);

    z-index: 2000;
}

.profile-dropdown[hidden] {
    display: none;
}


/* ========================================
   PROFILE HEADER
======================================== */

.profile-dropdown-header {
    display: flex;
    align-items: center;

    gap: 12px;
}

.profile-dropdown-image,
.profile-dropdown-placeholder {
    width: 54px;
    height: 54px;

    flex-shrink: 0;

    border-radius: 50%;
}

.profile-dropdown-image {
    object-fit: cover;
}

.profile-dropdown-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;

    background: #f0fdf4;
    color: #16a34a;

    border: 1px solid #16a34a;
}

.profile-user-info {
    min-width: 0;

    display: flex;
    flex-direction: column;

    gap: 5px;
}

.profile-user-info strong {
    color: #111827;

    font-size: 14px;
    font-weight: 700;

    overflow-wrap: anywhere;
}

.profile-user-info span {
    color: #6b7280;

    font-size: 12px;

    overflow-wrap: anywhere;
}


/* ========================================
   DIVIDER
======================================== */

.profile-dropdown-divider {
    height: 1px;

    background: #e5e7eb;

    margin: 13px 0;
}


/* ========================================
   PROFILE DETAILS
======================================== */

.profile-dropdown-details {
    display: flex;
    flex-direction: column;

    gap: 12px;
}

.profile-detail-item {
    display: flex;
    flex-direction: column;

    gap: 4px;
}

.profile-detail-label {
    color: #6b7280;

    font-size: 11px;
    font-weight: 600;
}

.profile-detail-value {
    color: #111827;

    font-size: 13px;
    line-height: 1.5;

    overflow-wrap: anywhere;
}


/* ========================================
   EDIT PROFILE LINK
======================================== */

.profile-edit-link {
    display: flex;
    align-items: center;

    gap: 9px;

    padding: 7px 0;

    color: #16a34a !important;

    font-size: 13px !important;
    font-weight: 700;

    text-decoration: none;
}

.profile-edit-link:hover {
    color: #15803d !important;
}


/* ========================================
   LOGOUT
======================================== */

.logout-form {
    margin: 0;
    padding: 0;
    flex-shrink: 0;
}

.logout-btn {
    border: none;
    background: transparent;

    color: #000000;

    font-family: inherit;
    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    padding: 0;

    white-space: nowrap;

    transition: color 0.2s ease;
}

.logout-btn:hover {
    color: #16a34a;
}


/* ========================================
   TABLET
======================================== */

@media (max-width: 1100px) {

    .navbar-container {
        width: 94%;
        gap: 15px;
    }

    .logo-text {
        font-size: 18px;
    }

    .logo-text strong {
        font-size: 25px;
    }

    .logo-icon {
        font-size: 27px;
    }

    .nav-links {
        gap: 15px;
    }

    .nav-links > a,
    .logout-btn {
        font-size: 13px;
    }

}


/* ========================================
   MOBILE
======================================== */

@media (max-width: 850px) {

    .navbar-container {
        width: 94%;

        padding: 11px 0;
        min-height: auto;

        flex-direction: column;
        gap: 11px;
    }

    .logo {
        justify-content: center;
    }

    .logo-icon {
        font-size: 27px;
    }

    .logo-text {
        font-size: 18px;
    }

    .logo-text strong {
        font-size: 24px;
    }

    .nav-links {
        width: 100%;

        justify-content: center;
        flex-wrap: wrap;

        gap: 10px 17px;
    }

    .nav-links > a,
    .logout-btn {
        font-size: 13px;
    }

    .profile-dropdown {
        right: -45px;
    }

}


/* ========================================
   SMALL MOBILE
======================================== */

@media (max-width: 600px) {

    .navbar-container {
        padding: 10px 0;
    }

    .logo-icon {
        font-size: 24px;
    }

    .logo-text {
        font-size: 16px;
    }

    .logo-text strong {
        font-size: 21px;
    }

    .nav-links {
        gap: 8px 13px;
    }

    .nav-links > a,
    .logout-btn {
        font-size: 12px;
    }

    .profile-icon-btn {
        width: 32px;
        height: 32px;
    }

    .profile-dropdown {
        right: -45px;
    }

}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const profileNav = document.getElementById('profileNav');
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    if (!profileNav || !profileToggle || !profileDropdown) {
        return;
    }

    // Open and close the profile dropdown.
    profileToggle.addEventListener('click', function (event) {

        event.stopPropagation();

        const isCurrentlyOpen = !profileDropdown.hidden;

        profileDropdown.hidden = isCurrentlyOpen;

        profileToggle.setAttribute(
            'aria-expanded',
            String(!isCurrentlyOpen)
        );

    });

    // Close when clicking outside the profile area.
    document.addEventListener('click', function (event) {

        if (!profileNav.contains(event.target)) {

            profileDropdown.hidden = true;

            profileToggle.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

    // Close with Escape.
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            profileDropdown.hidden = true;

            profileToggle.setAttribute(
                'aria-expanded',
                'false'
            );

            profileToggle.focus();

        }

    });

});
</script>
@include('partials.chatbot')