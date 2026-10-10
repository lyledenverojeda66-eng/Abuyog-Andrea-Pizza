<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Abuyog Andrea Pizza</title>

<link rel="icon" type="image/x-icon"
      href="<?php echo e(asset('favicon.ico')); ?>?v=100">
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
            font-family:
                Arial,
                Helvetica,
                sans-serif;

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

            /*
             * ADMIN BANNER:
             * Kapag may active banner sa admin,
             * iyon ang gagamitin.
             *
             * Kapag walang active banner,
             * original image ang gagamitin.
             */

            background-image:
                url('<?php if(isset($banners) && $banners->count() > 0): ?><?php echo e(asset('image/banners/' . $banners->first()->image)); ?><?php else: ?><?php echo e(asset('images/andreas-pizza-banner.jpg')); ?><?php endif; ?>');

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;
        }


        /* =========================
           SLIDES
        ========================= */

        .hero-slide {
            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            opacity: 0;

            visibility: hidden;

            transition:
                opacity 0.7s ease,
                visibility 0.7s ease;
        }


        .hero-slide.active {
            opacity: 1;

            visibility: visible;
        }


        /* =========================
           SLIDE 1
        ========================= */

        .slide-original {
            display: flex;

            align-items: flex-end;

            justify-content: center;

            padding-bottom: 28px;
        }


        .slide-original .hero-content {
            position: relative;

            z-index: 2;

            width: 100%;
            height: 100%;

            display: flex;

            align-items: flex-end;

            justify-content: center;

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
                0 4px 14px
                rgba(0, 0, 0, 0.30);

            transition: 0.2s;
        }


        .hero-button:hover {
            background: #15803d;

            transform:
                translateY(-2px);
        }


        /* =========================
           SLIDE 2
        ========================= */

        .slide-two {
            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;
        }


        .slide-two::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(0, 0, 0, 0.05),
                    rgba(0, 0, 0, 0.50)
                );
        }


        .promo-two {
            position: relative;

            z-index: 2;

            width: 570px;

            max-width: 90%;

            padding: 30px 35px;

            background:
                rgba(255, 248, 232, 0.97);

            border-left:
                8px solid #f97316;

            border-radius:
                8px 30px 30px 8px;

            box-shadow:
                0 12px 35px
                rgba(0, 0, 0, 0.30);

            text-align: left;
        }


        .promo-two .small-title {
            display: inline-block;

            background: #f97316;

            color: white;

            padding: 7px 17px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;

            letter-spacing: 1px;

            margin-bottom: 11px;
        }


        .promo-two h2 {
            color: #15803d;

            font-size: 50px;

            line-height: 1;

            font-weight: 900;
        }


        .promo-two h3 {
            margin: 9px 0;

            color: #ea580c;

            font-size: 23px;

            font-weight: 800;
        }


        .promo-two p {
            margin: 8px 0 20px;

            color: #444;

            font-size: 15px;

            line-height: 1.5;
        }


        .promo-two .promo-button {
            display: inline-block;

            padding: 11px 25px;

            background: #16a34a;

            color: white;

            text-decoration: none;

            border-radius: 25px;

            font-weight: bold;

            border: 2px solid #16a34a;

            transition: 0.2s;
        }


        .promo-two .promo-button:hover {
            background: #15803d;

            border-color: #15803d;

            transform:
                translateY(-2px);
        }


        /* =========================
           SLIDE 3
        ========================= */

        .slide-three {
            display: flex;

            align-items: center;

            justify-content: flex-end;

            padding: 25px 9%;
        }


        .slide-three::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(0, 0, 0, 0.05),
                    rgba(0, 70, 35, 0.75)
                );
        }


        .promo-three {
            position: relative;

            z-index: 2;

            width: 500px;

            max-width: 90%;

            padding: 32px;

            text-align: center;

            color: white;

            background:
                rgba(10, 65, 35, 0.93);

            border:
                2px solid #facc15;

            border-radius: 22px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.35);
        }


        .promo-three .weekend-label {
            color: #facc15;

            font-size: 14px;

            font-weight: 800;

            letter-spacing: 3px;

            margin-bottom: 10px;
        }


        .promo-three h2 {
            font-size: 44px;

            line-height: 1;

            font-weight: 900;

            color: white;
        }


        .promo-three h3 {
            margin: 12px 0;

            color: #facc15;

            font-size: 22px;

            font-weight: 800;
        }


        .promo-three p {
            margin: 10px 0 21px;

            font-size: 15px;

            line-height: 1.5;

            color: #f5f5f5;
        }


        .promo-three .promo-button {
            display: inline-block;

            padding: 12px 28px;

            background: #facc15;

            color: #14532d;

            text-decoration: none;

            border-radius: 25px;

            font-weight: 900;

            transition: 0.2s;
        }


        .promo-three .promo-button:hover {
            background: #fde047;

            transform:
                translateY(-2px);
        }


        /* =========================
           SLIDER ARROWS
        ========================= */

        .slider-arrow {
            position: absolute;

            top: 50%;

            transform:
                translateY(-50%);

            z-index: 10;

            width: 42px;

            height: 42px;

            border: none;

            border-radius: 50%;

            background:
                rgba(0, 0, 0, 0.55);

            color: white;

            font-size: 28px;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            transition: 0.2s;
        }


        .slider-arrow:hover {
            background:
                rgba(0, 0, 0, 0.85);

            transform:
                translateY(-50%)
                scale(1.05);
        }


        .slider-prev {
            left: 20px;
        }


        .slider-next {
            right: 20px;
        }


        /* =========================
           SLIDER DOTS
        ========================= */

        .slider-dots {
            position: absolute;

            bottom: 15px;

            left: 50%;

            transform:
                translateX(-50%);

            z-index: 20;

            display: flex;

            align-items: center;

            gap: 8px;
        }


        .slider-dot {
            width: 10px;

            height: 10px;

            padding: 0;

            border-radius: 50%;

            border:
                1px solid white;

            background:
                rgba(255, 255, 255, 0.60);

            cursor: pointer;

            transition: 0.25s;
        }


        .slider-dot.active {
            width: 30px;

            border-radius: 10px;

            background: white;
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

            border-left:
                4px solid #16a34a;

            box-shadow:
                0 4px 14px
                rgba(0, 0, 0, 0.07);

            transition: 0.2s;
        }


        .feature:hover {
            transform:
                translateY(-3px);

            box-shadow:
                0 7px 18px
                rgba(0, 0, 0, 0.10);
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

            border:
                1px solid #bbf7d0;
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
                0 6px 20px
                rgba(0, 0, 0, 0.12);
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

            transform:
                translateY(-2px);
        }


        /* =====================================================
           RATINGS & REVIEWS
        ===================================================== */

        .reviews-section {
            width: 90%;

            max-width: 1050px;

            margin: 45px auto 25px;
        }


        .reviews-title {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 25px;
        }


        .reviews-title h2 {
            font-size: 30px;

            color: #111;
        }


        .reviews-title span {
            color: #999;

            font-size: 32px;
        }


        .rating-summary {
            display: flex;

            align-items: center;

            gap: 45px;

            margin-bottom: 35px;
        }


        .average-rating {
            font-size: 65px;

            font-weight: 800;

            line-height: 1;

            color: #222;
        }


        .rating-details {
            display: flex;

            flex-direction: column;

            gap: 8px;
        }


        .rating-stars {
            color: #f5a400;

            font-size: 28px;

            letter-spacing: 3px;
        }


        .rating-count {
            color: #777;

            font-size: 14px;

            font-weight: 600;
        }


        .review-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 22px;
        }


        .review-card {
            background: #f1f1f1;

            border-radius: 18px;

            padding: 25px;

            min-height: 150px;
        }


        .review-top {
            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 15px;
        }


        .review-user {
            display: flex;

            align-items: center;

            gap: 13px;
        }


        .review-avatar {
            width: 52px;

            height: 52px;

            min-width: 52px;

            border-radius: 50%;

            background: #ef1f2d;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            font-weight: bold;
        }


        .review-name {
            font-size: 16px;

            font-weight: 700;

            margin-bottom: 5px;
        }


        .review-stars {
            color: #f5a400;

            font-size: 16px;

            letter-spacing: 2px;
        }


        .review-date {
            color: #777;

            font-size: 12px;

            white-space: nowrap;
        }


        .review-message {
            margin-top: 22px;

            color: #333;

            font-size: 14px;

            line-height: 1.5;
        }


        .review-reply {
            margin-top: 15px;

            padding: 12px;

            background: white;

            border-left:
                3px solid #16a34a;

            border-radius: 7px;

            font-size: 13px;

            color: #555;
        }


        .review-reply strong {
            color: #15803d;
        }


        .no-reviews {
            background: white;

            border-radius: 12px;

            padding: 25px;

            text-align: center;

            color: #777;
        }


        /* =====================================================
           CUSTOMER FEEDBACK
        ===================================================== */

        .feedback-section {
            width: 90%;

            max-width: 1050px;

            margin: 25px auto 45px;

            padding: 30px;

            background: white;

            border-radius: 16px;

            border-top:
                4px solid #16a34a;

            box-shadow:
                0 5px 18px
                rgba(0, 0, 0, 0.08);
        }


        .feedback-header {
            display: flex;

            align-items: center;

            gap: 15px;

            margin-bottom: 25px;
        }


        .feedback-icon {
            width: 55px;

            height: 55px;

            min-width: 55px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #dcfce7;

            font-size: 26px;
        }


        .feedback-header h2 {
            color: #15803d;

            font-size: 25px;

            margin-bottom: 5px;
        }


        .feedback-header p {
            color: #666;

            font-size: 14px;

            line-height: 1.5;
        }


        /* =========================
           FEEDBACK FORM
        ========================= */

        .feedback-form {
            width: 100%;

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;
        }


        .feedback-field {
            display: flex;

            flex-direction: column;

            gap: 7px;
        }


        .feedback-field:nth-child(3) {
            grid-column:
                1 / -1;
        }


        .feedback-field label {
            color: #222;

            font-size: 14px;

            font-weight: 700;
        }


        .feedback-field select,
        .feedback-field textarea {
            width: 100%;

            border:
                1px solid #d1d5db;

            border-radius: 9px;

            background: #fafafa;

            padding: 11px 13px;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 14px;

            color: #222;

            outline: none;

            transition: 0.2s;
        }


        .feedback-field select {
            height: 45px;

            cursor: pointer;
        }


        .feedback-field textarea {
            resize: vertical;

            min-height: 120px;
        }


        .feedback-field select:focus,
        .feedback-field textarea:focus {
            border-color: #16a34a;

            background: white;

            box-shadow:
                0 0 0 3px
                rgba(
                    22,
                    163,
                    74,
                    0.10
                );
        }


        /* =========================
           SUBMIT
        ========================= */

        .feedback-submit {
            grid-column:
                1 / -1;

            width: fit-content;

            border: none;

            border-radius: 25px;

            background: #16a34a;

            color: white;

            padding: 12px 25px;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: 0.2s;
        }


        .feedback-submit:hover {
            background: #15803d;

            transform:
                translateY(-2px);
        }


        .feedback-note {
            grid-column:
                1 / -1;

            color: #777;

            font-size: 12px;

            margin-top: -8px;
        }


        /* =========================
           SUCCESS
        ========================= */

        .feedback-success {
            margin-bottom: 20px;

            padding: 13px 16px;

            border-radius: 9px;

            background: #dcfce7;

            color: #166534;

            border:
                1px solid #bbf7d0;

            font-size: 14px;

            font-weight: 600;
        }


        /* =========================
           ERROR
        ========================= */

        .feedback-error {
            margin-bottom: 20px;

            padding: 13px 16px;

            border-radius: 9px;

            background: #fee2e2;

            color: #991b1b;

            border:
                1px solid #fecaca;

            font-size: 13px;
        }


        .feedback-error ul {
            margin:
                7px 0 0 18px;
        }


        /* =========================
           LOGIN
        ========================= */

        .feedback-login {
            text-align: center;

            background: #f9fafb;

            border-radius: 13px;

            padding: 30px 20px;

            border:
                1px solid #eeeeee;
        }


        .feedback-login-icon {
            font-size: 30px;

            margin-bottom: 8px;
        }


        .feedback-login h3 {
            color: #222;

            font-size: 19px;

            margin-bottom: 7px;
        }


        .feedback-login p {
            color: #666;

            font-size: 14px;

            margin-bottom: 18px;

            line-height: 1.5;
        }


        .feedback-login-btn {
            display: inline-block;

            background: #16a34a;

            color: white;

            text-decoration: none;

            padding: 11px 22px;

            border-radius: 25px;

            font-size: 14px;

            font-weight: 700;

            transition: 0.2s;
        }


        .feedback-login-btn:hover {
            background: #15803d;

            transform:
                translateY(-2px);
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


            .slide-three {
                justify-content: center;

                padding: 20px;
            }


            .review-grid {
                grid-template-columns: 1fr;
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


            .slide-original {
                padding-bottom: 22px;
            }


            .hero-button {
                padding: 10px 22px;

                font-size: 14px;
            }


            .slide-two {
                padding: 15px;
            }


            .promo-two {
                width: 92%;

                padding: 22px;

                border-left-width: 6px;

                border-radius:
                    6px 20px 20px 6px;
            }


            .promo-two .small-title {
                font-size: 11px;

                padding: 6px 12px;
            }


            .promo-two h2 {
                font-size: 38px;
            }


            .promo-two h3 {
                font-size: 18px;
            }


            .promo-two p {
                font-size: 13px;

                margin-bottom: 15px;
            }


            .promo-two .promo-button {
                padding: 9px 20px;

                font-size: 13px;
            }


            .slide-three {
                justify-content: center;

                padding: 15px;
            }


            .promo-three {
                width: 92%;

                padding: 23px 18px;

                border-radius: 18px;
            }


            .promo-three .weekend-label {
                font-size: 11px;

                letter-spacing: 2px;
            }


            .promo-three h2 {
                font-size: 34px;
            }


            .promo-three h3 {
                font-size: 17px;
            }


            .promo-three p {
                font-size: 13px;

                margin-bottom: 16px;
            }


            .promo-three .promo-button {
                padding: 10px 22px;

                font-size: 13px;
            }


            .slider-arrow {
                width: 35px;

                height: 35px;

                font-size: 22px;
            }


            .slider-prev {
                left: 10px;
            }


            .slider-next {
                right: 10px;
            }


            .slider-dots {
                bottom: 10px;
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


            /* REVIEWS */

            .reviews-section {
                width: 92%;

                margin: 35px auto 20px;
            }


            .reviews-title h2 {
                font-size: 24px;
            }


            .rating-summary {
                gap: 20px;

                margin-bottom: 25px;
            }


            .average-rating {
                font-size: 50px;
            }


            .rating-stars {
                font-size: 21px;
            }


            .review-card {
                padding: 20px;

                min-height: 135px;
            }


            .review-avatar {
                width: 45px;

                height: 45px;

                min-width: 45px;

                font-size: 17px;
            }


            .review-name {
                font-size: 14px;
            }


            .review-stars {
                font-size: 13px;
            }


            .review-message {
                font-size: 13px;
            }


            /* FEEDBACK */

            .feedback-section {
                width: 92%;

                margin: 30px auto;

                padding: 22px 18px;

                border-radius: 14px;
            }


            .feedback-header {
                align-items: flex-start;

                gap: 11px;
            }


            .feedback-icon {
                width: 46px;

                height: 46px;

                min-width: 46px;

                font-size: 22px;
            }


            .feedback-header h2 {
                font-size: 21px;
            }


            .feedback-header p {
                font-size: 12px;
            }


            .feedback-form {
                grid-template-columns: 1fr;

                gap: 15px;
            }


            .feedback-field:nth-child(3) {
                grid-column: auto;
            }


            .feedback-submit {
                grid-column: auto;

                width: 100%;
            }


            .feedback-note {
                grid-column: auto;

                text-align: center;
            }


            .feedback-login {
                padding: 25px 15px;
            }

        }

    </style>

</head>


<body>


    

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <section class="hero">


        

        <div class="hero-slide slide-original active">

            <div class="hero-content">

                <a
                    href="<?php echo e(route('menu')); ?>"
                    class="hero-button"
                >
                    🍕 Order Now
                </a>

            </div>

        </div>


        

        <div class="hero-slide slide-two">

            <div class="promo-two">

                <div class="small-title">
                    🔥 LIMITED PROMO
                </div>

                <h2>
                    10% OFF
                </h2>

                <h3>
                    SELECTED PIZZAS
                </h3>

                <p>
                    Enjoy your favorite pizza
                    and save more today!
                </p>

                <a
                    href="<?php echo e(route('menu')); ?>"
                    class="promo-button"
                >
                    🍕 ORDER NOW
                </a>

            </div>

        </div>


        

        <div class="hero-slide slide-three">

            <div class="promo-three">

                <div class="weekend-label">
                    ✦ WEEKEND SPECIAL ✦
                </div>

                <h2>
                    PIZZA
                    <br>
                    WEEKEND
                </h2>

                <h3>
                    SAVE MORE. EAT MORE.
                </h3>

                <p>
                    Make your weekend extra delicious
                    with Abuyog Andrea Pizza!
                </p>

                <a
                    href="<?php echo e(route('menu')); ?>"
                    class="promo-button"
                >
                    🍕 VIEW MENU
                </a>

            </div>

        </div>


        

        <button
            type="button"
            class="slider-arrow slider-prev"
            onclick="changeSlide(-1)"
            aria-label="Previous slide"
        >
            ‹
        </button>


        

        <button
            type="button"
            class="slider-arrow slider-next"
            onclick="changeSlide(1)"
            aria-label="Next slide"
        >
            ›
        </button>


        

        <div class="slider-dots">

            <button
                type="button"
                class="slider-dot active"
                onclick="goToSlide(0)"
                aria-label="Slide 1"
            ></button>

            <button
                type="button"
                class="slider-dot"
                onclick="goToSlide(1)"
                aria-label="Slide 2"
            ></button>

            <button
                type="button"
                class="slider-dot"
                onclick="goToSlide(2)"
                aria-label="Slide 3"
            ></button>

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


    

    <section class="reviews-section">


        <div class="reviews-title">
    <h2>
        <a href="<?php echo e(route('reviews.index')); ?>">
            Ratings & Reviews
        </a>
    </h2>

    <a href="<?php echo e(route('reviews.index')); ?>" aria-label="View all reviews">
        ›
    </a>
</div>


        <?php

            /*
            |--------------------------------------------------------------------------
            | GET APPROVED REVIEWS
            |--------------------------------------------------------------------------
            |
            | This fallback keeps the page working even if the controller
            | does not pass a $feedbacks variable.
            |
            */

            $publicFeedbacks =
                isset($feedbacks)
                    ? $feedbacks
                    : collect();

            $approvedFeedbacks =
                $publicFeedbacks
                    ->where('status', 'approved')
                    ->where('type', 'feedback')
                    ->whereNotNull('rating');

            $reviewCount =
                $approvedFeedbacks->count();

            $averageRating =
                $reviewCount > 0
                    ? round(
                        $approvedFeedbacks->avg('rating'),
                        1
                    )
                    : 0;

        ?>


        <div class="rating-summary">


            <div class="average-rating">

                <?php echo e(number_format($averageRating, 1)); ?>


            </div>


            <div class="rating-details">

                <div class="rating-stars">

                    <?php for($i = 1; $i <= 5; $i++): ?>

                        <?php if($i <= round($averageRating)): ?>

                            ★

                        <?php else: ?>

                            ☆

                        <?php endif; ?>

                    <?php endfor; ?>

                </div>


                <div class="rating-count">

                    <?php echo e($reviewCount); ?>


                    <?php echo e($reviewCount == 1 ? 'Rating' : 'Ratings'); ?>


                </div>

            </div>

        </div>


        <?php if($reviewCount > 0): ?>


            <div class="review-grid">


                <?php $__currentLoopData = $approvedFeedbacks->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    <?php

                        $customerName =
                            optional($feedback->user)->name
                            ?? 'Customer';

                        $firstLetter =
                            strtoupper(
                                substr(
                                    $customerName,
                                    0,
                                    1
                                )
                            );

                    ?>


                    <div class="review-card">


                        <div class="review-top">


                            <div class="review-user">


                                <div class="review-avatar">

                                    <?php echo e($firstLetter); ?>


                                </div>


                                <div>

                                    <div class="review-name">

                                        <?php echo e($customerName); ?>


                                    </div>


                                    <div class="review-stars">

                                        <?php for(
                                            $i = 1;
                                            $i <= 5;
                                            $i++
                                        ): ?>

                                            <?php if(
                                                $i <=
                                                (int) $feedback->rating
                                            ): ?>

                                                ★

                                            <?php else: ?>

                                                ☆

                                            <?php endif; ?>

                                        <?php endfor; ?>

                                    </div>

                                </div>


                            </div>


                            <div class="review-date">

                                <?php echo e(optional($feedback->created_at)->format('M d, Y')); ?>


                            </div>


                        </div>


                        <div class="review-message">

                            <?php echo e($feedback->message); ?>


                        </div>


                        <?php if(
                            !empty(
                                $feedback->admin_reply
                            )
                        ): ?>

                            <div class="review-reply">

                                <strong>
                                    Admin Reply:
                                </strong>

                                <?php echo e($feedback->admin_reply); ?>


                            </div>

                        <?php endif; ?>


                    </div>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </div>


        <?php else: ?>


            <div class="no-reviews">

                ⭐ No approved reviews yet.
                Be the first to share your experience!

            </div>


        <?php endif; ?>


    </section>


    

    <section class="feedback-section">


        <div class="feedback-header">


            <div class="feedback-icon">
                💬
            </div>


            <div>

                <h2>
                    Send Us Your Feedback
                </h2>

                <p>
                    Have feedback or a concern?
                    Let us know so we can improve our service.
                </p>

            </div>


        </div>


        

        <?php if(session('success')): ?>

            <div class="feedback-success">

                ✅

                <?php echo e(session('success')); ?>


            </div>

        <?php endif; ?>


        

        <?php if($errors->any()): ?>

            <div class="feedback-error">

                <strong>
                    Please check the following:
                </strong>


                <ul>

                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li>
                            <?php echo e($error); ?>

                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>

            </div>

        <?php endif; ?>


        <?php if(auth()->guard()->check()): ?>


            <form
                action="<?php echo e(route('customer.feedback.general')); ?>"
                method="POST"
                class="feedback-form"
            >

                <?php echo csrf_field(); ?>


                

                <div class="feedback-field">

                    <label for="type">
                        What would you like to send?
                    </label>


                    <select
                        name="type"
                        id="type"
                        required
                    >

                        <option value="">
                            Select an option
                        </option>


                        <option
                            value="feedback"
                            <?php echo e(old('type') === 'feedback' ? 'selected' : ''); ?>

                        >
                            ⭐ Feedback
                        </option>


                        <option
                            value="concern"
                            <?php echo e(old('type') === 'concern' ? 'selected' : ''); ?>

                        >
                            ⚠️ Concern
                        </option>

                    </select>

                </div>


                

                <div class="feedback-field">

                    <label for="rating">
                        Rate your experience
                    </label>


                    <select
                        name="rating"
                        id="rating"
                    >

                        <option value="">
                            Select rating
                        </option>


                        <option
                            value="5"
                            <?php echo e(old('rating') == 5 ? 'selected' : ''); ?>

                        >
                            ★★★★★ — Excellent
                        </option>


                        <option
                            value="4"
                            <?php echo e(old('rating') == 4 ? 'selected' : ''); ?>

                        >
                            ★★★★☆ — Very Good
                        </option>


                        <option
                            value="3"
                            <?php echo e(old('rating') == 3 ? 'selected' : ''); ?>

                        >
                            ★★★☆☆ — Good
                        </option>


                        <option
                            value="2"
                            <?php echo e(old('rating') == 2 ? 'selected' : ''); ?>

                        >
                            ★★☆☆☆ — Needs Improvement
                        </option>


                        <option
                            value="1"
                            <?php echo e(old('rating') == 1 ? 'selected' : ''); ?>

                        >
                            ★☆☆☆☆ — Poor
                        </option>

                    </select>

                </div>


                

                <div class="feedback-field">

                    <label for="message">
                        Your message
                    </label>


                    <textarea
                        name="message"
                        id="message"
                        rows="5"
                        maxlength="2000"
                        placeholder="Tell us about your experience or concern..."
                        required
                    ><?php echo e(old('message')); ?></textarea>

                </div>


                

                <button
                    type="submit"
                    class="feedback-submit"
                >
                    📩 Send to Admin
                </button>


                <p class="feedback-note">

                    Your message will be reviewed by our admin
                    before it appears publicly.

                </p>


            </form>


        <?php else: ?>


            <div class="feedback-login">


                <div class="feedback-login-icon">
                    🔐
                </div>


                <h3>
                    Want to send feedback?
                </h3>


                <p>
                    Please log in to your customer account
                    to send feedback or report a concern.
                </p>


                <a
                    href="<?php echo e(route('login')); ?>"
                    class="feedback-login-btn"
                >
                    Login to Send Feedback
                </a>


            </div>


        <?php endif; ?>


    </section>


    

    <footer>

        © <?php echo e(date('Y')); ?>


        <span>
            Abuyog Andrea Pizza
        </span>

        All Rights Reserved.

    </footer>


    

    <script>

        let currentSlide = 0;


        const slides =
            document.querySelectorAll(
                '.hero-slide'
            );


        const dots =
            document.querySelectorAll(
                '.slider-dot'
            );


        function showSlide(index) {

            if (
                index >=
                slides.length
            ) {

                currentSlide = 0;

            }

            else if (
                index < 0
            ) {

                currentSlide =
                    slides.length - 1;

            }

            else {

                currentSlide = index;

            }


            slides.forEach(
                (slide, i) => {

                    slide.classList.toggle(
                        'active',
                        i === currentSlide
                    );

                }
            );


            dots.forEach(
                (dot, i) => {

                    dot.classList.toggle(
                        'active',
                        i === currentSlide
                    );

                }
            );

        }


        function changeSlide(direction) {

            showSlide(
                currentSlide + direction
            );

        }


        function goToSlide(index) {

            showSlide(index);

        }


        setInterval(
            function () {

                changeSlide(1);

            },
            5000
        );

    </script>


</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/home.blade.php ENDPATH**/ ?>