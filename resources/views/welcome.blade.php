<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Abuyog Andrea Pizza</title>


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #111;
        }


        /* =========================
           NAVIGATION
        ========================= */

        .navbar {
            background: #080808;

            min-height: 115px;

            padding: 18px 7%;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .logo {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .pizza-logo {
            font-size: 48px;
        }


        .logo-text {
            line-height: 0.95;
        }


        .logo-top {
            color: white;

            font-size: 28px;

            font-weight: 900;

            font-style: italic;

            letter-spacing: 1px;
        }


        .logo-bottom {
            color: #16a34a;

            font-size: 42px;

            font-weight: 900;

            font-style: italic;

            letter-spacing: 1px;
        }


        .nav-links {
            display: flex;

            align-items: center;

            gap: 30px;
        }


        .nav-links a {
            color: white;

            text-decoration: none;

            font-weight: bold;

            font-size: 16px;

            padding: 10px 0;

            transition: 0.2s;
        }


        .nav-links a:hover {
            color: #16a34a;
        }


        .login-btn {
            border: 1px solid #16a34a;

            border-radius: 25px;

            padding: 12px 22px !important;

            color: #16a34a !important;
        }


        .login-btn:hover {
            background: #16a34a;

            color: white !important;
        }


        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: 600px;

            display: flex;

            align-items: center;

            padding: 70px 8%;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)
                ),
                url('/images/andreas-pizza-banner.jpg');

            background-size: cover;

            background-position: center;
        }


        .hero-content {
            max-width: 650px;

            color: white;
        }


        .hero-content h1 {
            font-size: 62px;

            font-style: italic;

            font-weight: 900;

            line-height: 1;

            margin-bottom: 20px;
        }


        .hero-content h1 span {
            color: #16a34a;
        }


        .hero-content p {
            font-size: 20px;

            line-height: 1.6;

            margin-bottom: 30px;
        }


        /* =========================
           ORDER BUTTON
        ========================= */

        .order-btn {
            display: inline-block;

            background: #16a34a;

            color: white;

            text-decoration: none;

            padding: 15px 30px;

            border-radius: 30px;

            font-weight: bold;

            font-size: 17px;

            transition: 0.2s;

            box-shadow:
                0 5px 15px rgba(22, 163, 74, 0.30);
        }


        .order-btn:hover {
            background: #15803d;

            transform: translateY(-2px);
        }


        /* =========================
           FEATURES
        ========================= */

        .features {
            width: 86%;

            max-width: 1200px;

            margin: 60px auto;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;
        }


        .feature {
            background: white;

            text-align: center;

            padding: 35px 25px;

            border-radius: 15px;

            border-top: 4px solid #16a34a;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.08);

            transition: 0.2s;
        }


        .feature:hover {
            transform: translateY(-5px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.12);
        }


        .feature-icon {
            font-size: 45px;

            margin-bottom: 15px;
        }


        .feature h3 {
            margin-bottom: 10px;

            color: #16a34a;

            font-size: 22px;
        }


        .feature p {
            color: #666;

            line-height: 1.5;
        }


        /* =========================
           CTA
        ========================= */

        .cta {
            width: 86%;

            max-width: 1200px;

            margin: 20px auto 60px;

            padding: 45px 30px;

            background: #16a34a;

            color: white;

            text-align: center;

            border-radius: 18px;

            box-shadow:
                0 8px 25px rgba(22, 163, 74, 0.25);
        }


        .cta h2 {
            font-size: 35px;

            margin-bottom: 10px;
        }


        .cta p {
            margin-bottom: 25px;

            font-size: 17px;
        }


        .cta-btn {
            display: inline-block;

            background: white;

            color: #16a34a;

            text-decoration: none;

            padding: 13px 28px;

            border-radius: 25px;

            font-weight: bold;

            transition: 0.2s;
        }


        .cta-btn:hover {
            background: #f1f1f1;

            transform: translateY(-2px);
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #080808;

            color: white;

            text-align: center;

            padding: 25px;

            margin-top: 40px;
        }


        footer span {
            color: #16a34a;

            font-weight: bold;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 850px) {

            .navbar {
                flex-direction: column;

                gap: 20px;
            }


            .nav-links {
                flex-wrap: wrap;

                justify-content: center;

                gap: 18px;
            }


            .hero {
                text-align: center;

                justify-content: center;
            }


            .hero-content h1 {
                font-size: 45px;
            }


            .features {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 500px) {

            .hero {
                min-height: 520px;

                padding: 50px 6%;
            }


            .hero-content h1 {
                font-size: 38px;
            }


            .hero-content p {
                font-size: 17px;
            }


            .cta {
                width: 92%;
            }

        }

    </style>

</head>


<body>


    {{-- =========================
         NAVIGATION
    ========================= --}}

    @include('partials.navbar')


    {{-- =========================
         HERO
    ========================= --}}

    <section class="hero">

        <div class="hero-content">

            <h1>

                Delicious Pizza,

                <span>
                    Made Fresh.
                </span>

            </h1>


            <p>

                Enjoy delicious and freshly prepared pizza
                from Abuyog Andrea Pizza.
                Order your favorite pizza today!

            </p>


            <a
                href="{{ route('menu') }}"
                class="order-btn"
            >
                🍕 Order Now
            </a>

        </div>

    </section>


    {{-- =========================
         FEATURES
    ========================= --}}

    <section class="features">


        <div class="feature">

            <div class="feature-icon">
                🍕
            </div>


            <h3>
                Fresh Pizza
            </h3>


            <p>
                Freshly prepared pizza made
                with delicious ingredients.
            </p>

        </div>


        <div class="feature">

            <div class="feature-icon">
                🚚
            </div>


            <h3>
                Fast Delivery
            </h3>


            <p>
                Get your favorite pizza delivered
                right to your location.
            </p>

        </div>


        <div class="feature">

            <div class="feature-icon">
                ❤️
            </div>


            <h3>
                Made With Love
            </h3>


            <p>
                We prepare every pizza with care
                for our customers.
            </p>

        </div>


    </section>


    {{-- =========================
         CALL TO ACTION
    ========================= --}}

    <section class="cta">

        <h2>
            Ready to Order?
        </h2>


        <p>
            Choose your favorite pizza and
            enjoy Abuyog Andrea Pizza today!
        </p>


        <a
            href="{{ route('menu') }}"
            class="cta-btn"
        >
            View Our Menu
        </a>

    </section>


    {{-- =========================
         FOOTER
    ========================= --}}

    <footer>

        © {{ date('Y') }}

        <span>
            Abuyog Andrea Pizza
        </span>

        All Rights Reserved.

    </footer>


</body>

</html>