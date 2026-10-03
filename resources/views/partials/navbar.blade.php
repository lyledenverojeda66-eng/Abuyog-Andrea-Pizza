<nav class="navbar">

    <div class="navbar-container">

        <!-- LOGO -->
        <a href="{{ route('home') }}" class="logo">

            <div class="logo-icon">
                🍕
            </div>

            <div class="logo-text">
                <div>ABUYOG ANDREA</div>
                <strong>PIZZA</strong>
            </div>

        </a>


        <!-- NAVIGATION -->
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

                <a href="{{ route('customer.orders') }}">
                    My Orders
                </a>

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

    box-shadow:
        0 2px 6px rgba(0, 0, 0, 0.10);

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


/* Pizza icon */

.logo-icon {
    font-size: 30px;

    line-height: 1;
}


/* ABUYOG ANDREA */

.logo-text {
    color: #16a34a;

    font-size: 20px;

    font-weight: 800;

    font-style: italic;

    line-height: 1;
}


/* PIZZA */

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


/* Normal links */

.nav-links a {
    color: #000000;

    text-decoration: none;

    font-size: 14px;

    font-weight: 700;

    white-space: nowrap;

    transition:
        color 0.2s ease;
}


/* Hover */

.nav-links a:hover {
    color: #16a34a;
}


/* ========================================
   LOGOUT
======================================== */

.logout-form {
    margin: 0;

    padding: 0;
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

    transition:
        color 0.2s ease;
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


    .nav-links a,
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


    .nav-links a,
    .logout-btn {
        font-size: 13px;
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


    .nav-links a,
    .logout-btn {
        font-size: 12px;
    }

}

</style>