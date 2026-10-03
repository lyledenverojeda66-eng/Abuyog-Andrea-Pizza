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

        /* =========================
           RESET
        ========================= */

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
           HERO BANNER
        ========================= */

        .hero {
            width: 100%;
            height: 420px;
            position: relative;
            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            background-image:
                url('<?php echo e(asset('images/andreas-pizza-banner.jpg')); ?>');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        .hero-content {
            position: relative;
            z-index: 2;

            width: 100%;
            height: 100%;

            display: flex;
            align-items: flex-end;
            justify-content: center;

            padding-bottom: 28px;

            text-align: center;
        }


        .hero-button {
            display: inline-block;

            background: #16a34a;
            color: white;

            text-decoration: none;

            padding: 12px 27px;

            border-radius: 25px;

            font-size: 15px;
            font-weight: bold;

            border: 2px solid white;

            box-shadow:
                0 4px 14px rgba(0, 0, 0, 0.30);

            transition: 0.2s;
        }


        .hero-button:hover {
            background: #15803d;
            transform: translateY(-2px);
        }


        /* =========================
           FEATURES
        ========================= */

        .features {
            width: 90%;
            max-width: 1050px;

            margin: 32px auto;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;
        }


        .feature {
            background: white;

            min-height: 125px;

            display: flex;
            align-items: center;

            gap: 14px;

            padding: 18px;

            border-radius: 10px;

            border-left: 4px solid #16a34a;

            box-shadow:
                0 4px 14px rgba(0, 0, 0, 0.07);

            transition: 0.2s;
        }


        .feature:hover {
            transform: translateY(-3px);

            box-shadow:
                0 7px 18px rgba(0, 0, 0, 0.10);
        }


        .feature-icon {
            min-width: 58px;

            width: 58px;
            height: 58px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;

            background: #dcfce7;

            border: 1px solid #bbf7d0;
        }


        .feature-content {
            min-width: 0;
        }


        .feature-content h3 {
            color: #16a34a;

            font-size: 18px;

            margin-bottom: 6px;
        }


        .feature-content p {
            color: #555;

            line-height: 1.4;

            font-size: 13px;
        }


        /* =========================
           ORDER SECTION
        ========================= */

        .order-section {
            width: 90%;
            max-width: 1050px;

            margin: 35px auto;

            padding: 32px 25px;

            text-align: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #087f3c,
                    #16a34a,
                    #22c55e
                );

            color: white;

            box-shadow:
                0 6px 20px rgba(0, 0, 0, 0.12);
        }


        .order-section h2 {
            font-size: 28px;

            margin-bottom: 9px;
        }


        .order-section p {
            font-size: 15px;

            line-height: 1.5;

            margin-bottom: 20px;
        }


        .order-section .order-btn {
            display: inline-block;

            background: white;

            color: #15803d;

            text-decoration: none;

            padding: 11px 24px;

            border-radius: 25px;

            font-weight: bold;

            font-size: 14px;

            transition: 0.2s;
        }


        .order-section .order-btn:hover {
            background: #f0fdf4;

            transform: translateY(-2px);
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #080808;

            color: white;

            text-align: center;

            padding: 20px;

            margin-top: 30px;

            font-size: 13px;
        }


        footer span {
            color: #16a34a;

            font-weight: bold;
        }


        /* =========================
           TABLET
        ========================= */

        @media (max-width: 900px) {

            .hero {
                height: 380px;
            }


            .features {
                grid-template-columns: 1fr;

                max-width: 700px;
            }


            .feature {
                min-height: 110px;
            }

        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {

            .hero {
                height: 320px;

                background-position: center;
            }


            .hero-content {
                padding-bottom: 22px;
            }


            .hero-button {
                padding: 10px 22px;

                font-size: 14px;
            }


            .features {
                width: 92%;

                margin: 25px auto;

                gap: 12px;
            }


            .feature {
                min-height: 105px;

                padding: 15px;

                gap: 12px;
            }


            .feature-icon {
                min-width: 52px;

                width: 52px;
                height: 52px;

                font-size: 25px;
            }


            .feature-content h3 {
                font-size: 17px;
            }


            .feature-content p {
                font-size: 12px;
            }


            .order-section {
                width: 92%;

                margin: 28px auto;

                padding: 27px 18px;
            }


            .order-section h2 {
                font-size: 24px;
            }


            .order-section p {
                font-size: 14px;
            }


            .order-section .order-btn {
                font-size: 13px;

                padding: 10px 20px;
            }

        }

    </style>

</head>


<body>


    

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <section class="hero">

        <div class="hero-content">

            <a
                href="<?php echo e(route('menu')); ?>"
                class="hero-button"
            >
                🍕 Order Now
            </a>

        </div>

    </section>


    

    <section class="features">


        <div class="feature">

            <div class="feature-icon">
                🍕
            </div>


            <div class="feature-content">

                <h3>
                    Fresh Pizza
                </h3>

                <p>
                    Freshly prepared pizza made
                    with delicious ingredients.
                </p>

            </div>

        </div>



        <div class="feature">

            <div class="feature-icon">
                🚚
            </div>


            <div class="feature-content">

                <h3>
                    Fast Delivery
                </h3>

                <p>
                    Get your favorite pizza delivered
                    right to your location.
                </p>

            </div>

        </div>



        <div class="feature">

            <div class="feature-icon">
                ❤️
            </div>


            <div class="feature-content">

                <h3>
                    Made With Love
                </h3>

                <p>
                    We prepare every pizza with care
                    for our customers.
                </p>

            </div>

        </div>


    </section>


    

    <section class="order-section">

        <h2>
            Hungry for Pizza?
        </h2>


        <p>
            Choose your favorite pizza and
            order now from Abuyog Andrea Pizza!
        </p>


        <a
            href="<?php echo e(route('menu')); ?>"
            class="order-btn"
        >
            🍕 View Our Menu
        </a>

    </section>


    

    <footer>

        © <?php echo e(date('Y')); ?>


        <span>
            Abuyog Andrea Pizza
        </span>

        All Rights Reserved.

    </footer>


</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/home.blade.php ENDPATH**/ ?>