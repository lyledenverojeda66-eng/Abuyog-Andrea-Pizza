<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abuyog Andrea Pizza</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=100">

    <style>
        /* ================= RESET ================= */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            max-width: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #111;
            max-width: 100%;
            overflow-x: clip;
        }

        img {
            max-width: 100%;
        }

        /* ================= HERO SLIDER ================= */
        .hero {
            position: relative;
            width: 100%;
            height: 420px;
            overflow: hidden;
            background-color: #333;
            background-image: url('{{ isset($banners) && $banners->count() > 0 ? asset("image/banners/" . $banners->first()->image) : asset("images/andreas-pizza-banner.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity .7s ease, visibility .7s ease;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
        }

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
        }

        .hero-button,
        .promo-two .promo-button,
        .promo-three .promo-button {
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            transition: .2s;
        }

        .hero-button {
            padding: 12px 27px;
            border-radius: 25px;
            color: white;
            background: #16a34a;
            border: 2px solid white;
            box-shadow: 0 4px 14px rgba(0,0,0,.3);
        }

        .hero-button:hover {
            background: #15803d;
            transform: translateY(-2px);
        }

        /* ================= PROMO SLIDE 2 ================= */
        .slide-two {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .slide-two::before,
        .slide-three::before {
            content: "";
            position: absolute;
            inset: 0;
        }

        .slide-two::before {
            background: linear-gradient(90deg, rgba(0,0,0,.05), rgba(0,0,0,.5));
        }

        .promo-two {
            position: relative;
            z-index: 2;
            width: 570px;
            max-width: 90%;
            padding: 30px 35px;
            background: rgba(255,248,232,.97);
            border-left: 8px solid #f97316;
            border-radius: 8px 30px 30px 8px;
            box-shadow: 0 12px 35px rgba(0,0,0,.3);
        }

        .promo-two .small-title {
            display: inline-block;
            padding: 7px 17px;
            margin-bottom: 11px;
            background: #f97316;
            color: white;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
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
        }

        .promo-two p,
        .promo-three p {
            margin: 8px 0 20px;
            font-size: 15px;
            line-height: 1.6;
        }

        .promo-two p {
            color: #444;
        }

        .promo-two .promo-button {
            padding: 11px 25px;
            background: #16a34a;
            color: white;
            border-radius: 25px;
        }

        .promo-two .promo-button:hover {
            background: #15803d;
            transform: translateY(-2px);
        }

        /* ================= PROMO SLIDE 3 ================= */
        .slide-three {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 25px 9%;
        }

        .slide-three::before {
            background: linear-gradient(90deg, rgba(0,0,0,.05), rgba(0,70,35,.75));
        }

        .promo-three {
            position: relative;
            z-index: 2;
            width: 500px;
            max-width: 90%;
            padding: 32px;
            color: white;
            text-align: center;
            background: rgba(10,65,35,.93);
            border: 2px solid #facc15;
            border-radius: 22px;
            box-shadow: 0 15px 40px rgba(0,0,0,.35);
        }

        .promo-three .weekend-label {
            margin-bottom: 10px;
            color: #facc15;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .promo-three h2 {
            color: white;
            font-size: 44px;
            line-height: 1.1;
            font-weight: 900;
        }

        .promo-three h3 {
            margin: 12px 0;
            color: #facc15;
            font-size: 22px;
        }

        .promo-three p {
            color: #f5f5f5;
        }

        .promo-three .promo-button {
            padding: 12px 28px;
            color: #14532d;
            background: #facc15;
            border-radius: 25px;
        }

        .promo-three .promo-button:hover {
            background: #fde047;
            transform: translateY(-2px);
        }

        /* ================= SLIDER CONTROLS ================= */
        .slider-arrow {
            position: absolute;
            top: 50%;
            z-index: 10;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            border: 0;
            border-radius: 50%;
            color: white;
            background: rgba(0,0,0,.55);
            font-size: 28px;
            cursor: pointer;
        }

        .slider-arrow:hover {
            background: rgba(0,0,0,.85);
        }

        .slider-prev { left: 20px; }
        .slider-next { right: 20px; }

        .slider-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            z-index: 20;
            display: flex;
            gap: 8px;
            transform: translateX(-50%);
        }

        .slider-dot {
            width: 10px;
            height: 10px;
            padding: 0;
            border: 1px solid white;
            border-radius: 50%;
            background: rgba(255,255,255,.6);
            cursor: pointer;
        }

        .slider-dot.active {
            width: 30px;
            border-radius: 10px;
            background: white;
        }

        /* ================= FEATURES ================= */
        .features {
            width: 90%;
            max-width: 1050px;
            margin: 32px auto;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 125px;
            padding: 18px;
            background: white;
            border-left: 4px solid #16a34a;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,.07);
            transition: .2s;
        }

        .feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 18px rgba(0,0,0,.1);
        }

        .feature-icon {
            flex-shrink: 0;
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            font-size: 28px;
        }

        .feature-content { min-width: 0; }

        .feature-content h3 {
            margin-bottom: 6px;
            color: #16a34a;
            font-size: 18px;
        }

        .feature-content p {
            color: #555;
            font-size: 13px;
            line-height: 1.5;
        }

        /* ================= ORDER SECTION ================= */
        .order-section {
            width: 90%;
            max-width: 1050px;
            margin: 35px auto;
            padding: 32px 25px;
            color: white;
            text-align: center;
            background: linear-gradient(135deg, #087f3c, #16a34a, #22c55e);
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,.12);
        }

        .order-section h2 {
            margin-bottom: 9px;
            font-size: 28px;
        }

        .order-section p {
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.6;
        }

        .order-btn {
            display: inline-block;
            padding: 11px 24px;
            color: #15803d;
            background: white;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .order-btn:hover { background: #f0fdf4; }

        /* ================= CUSTOMER REVIEWS ================= */
        .reviews-section {
            width: 90%;
            max-width: 1050px;
            margin: 45px auto 30px;
            padding: 35px;
            background: #fff8ee;
            border-radius: 18px;
            overflow: hidden;
        }

        .reviews-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 25px;
        }

        .reviews-title h2 {
            color: #222;
            font-size: 30px;
        }

        .reviews-title a {
            color: #15803d;
            text-decoration: none;
        }

        .reviews-title a:hover { text-decoration: underline; }

        .reviews-title .all-reviews-link {
            flex-shrink: 0;
            font-size: 25px;
            font-weight: bold;
        }

        /* Rating summary */
        .rating-summary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;
            max-width: 440px;
            margin: 0 auto 32px;
            padding: 23px;
            background: white;
            border: 1px solid #eee5da;
            border-radius: 15px;
        }

        .average-rating {
            color: #222;
            font-size: 55px;
            line-height: 1;
            font-weight: 800;
        }

        .rating-details {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .rating-stars,
        .review-stars {
            color: #f5a400;
            letter-spacing: 2px;
        }

        .rating-stars { font-size: 24px; }
        .rating-count { color: #666; font-size: 13px; }

        /* Review grid */
        .review-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            width: 100%;
        }

        .review-card {
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 23px;
            background: white;
            border: 1px solid #eee5da;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(55,35,15,.06);
            overflow-wrap: anywhere;
            transition: transform .2s, box-shadow .2s;
        }

        .review-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(55,35,15,.1);
        }

        .review-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .review-user {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .review-avatar {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            min-width: 50px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #ed1c24;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }

        .review-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .review-avatar-initial {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }

        .review-user-info { min-width: 0; }

        .review-name {
            margin-bottom: 5px;
            color: #222;
            font-size: 15px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .review-stars {
            font-size: 16px;
            white-space: nowrap;
        }

        .review-date {
            flex-shrink: 0;
            color: #777;
            font-size: 11px;
            line-height: 1.5;
        }

        .review-message {
            margin-top: 20px;
            color: #444;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .review-reply {
            margin-top: 15px;
            padding: 12px 14px;
            color: #555;
            background: #f0fdf4;
            border-left: 3px solid #16a34a;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .review-reply strong {
            display: block;
            margin-bottom: 5px;
            color: #15803d;
        }

        .no-reviews {
            grid-column: 1 / -1;
            padding: 35px 20px;
            color: #777;
            text-align: center;
            background: white;
            border: 1px dashed #e4d4c3;
            border-radius: 14px;
            line-height: 1.8;
        }

        /* ================= FEEDBACK FORM ================= */
        .feedback-section {
            width: 90%;
            max-width: 1050px;
            margin: 25px auto 45px;
            padding: 30px;
            background: white;
            border-top: 4px solid #16a34a;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(0,0,0,.08);
        }

        .feedback-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .feedback-icon {
            flex-shrink: 0;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dcfce7;
            font-size: 26px;
        }

        .feedback-header h2 {
            margin-bottom: 5px;
            color: #15803d;
            font-size: 25px;
        }

        .feedback-header p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .feedback-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .feedback-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 0;
        }

        .feedback-field.full-width {
            grid-column: 1 / -1;
        }

        .feedback-field label {
            color: #222;
            font-size: 14px;
            font-weight: 700;
        }

        .feedback-field select,
        .feedback-field textarea {
            width: 100%;
            padding: 12px 13px;
            color: #222;
            background: #fafafa;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
            outline: none;
        }

        .feedback-field select { min-height: 45px; }
        .feedback-field textarea { min-height: 120px; resize: vertical; }

        .feedback-field select:focus,
        .feedback-field textarea:focus {
            border-color: #16a34a;
            background: white;
            box-shadow: 0 0 0 3px rgba(22,163,74,.1);
        }

        .feedback-stars {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .feedback-star {
            padding: 0;
            color: #cbd5e1;
            background: transparent;
            border: none;
            font-size: 34px;
            cursor: pointer;
        }

        .feedback-star.active { color: #f59e0b; }

        #ratingLabel {
            color: #666;
            font-size: 12px;
        }

        .feedback-submit {
            grid-column: 1 / -1;
            justify-self: start;
            padding: 12px 25px;
            color: white;
            background: #16a34a;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .feedback-submit:hover {
            background: #15803d;
            transform: translateY(-2px);
        }

        .feedback-note {
            grid-column: 1 / -1;
            margin-top: -8px;
            color: #777;
            font-size: 12px;
        }

        .feedback-success,
        .feedback-error {
            margin-bottom: 20px;
            padding: 13px 16px;
            border-radius: 9px;
            font-size: 14px;
            line-height: 1.7;
        }

        .feedback-success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .feedback-error {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .feedback-error ul { margin: 7px 0 0 20px; }

        .feedback-login {
            padding: 30px 20px;
            text-align: center;
            background: #f9fafb;
            border: 1px solid #eee;
            border-radius: 13px;
        }

        .feedback-login-icon {
            margin-bottom: 8px;
            font-size: 30px;
        }

        .feedback-login h3 {
            margin-bottom: 7px;
            color: #222;
            font-size: 19px;
        }

        .feedback-login p {
            margin-bottom: 18px;
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .feedback-login-btn {
            display: inline-block;
            padding: 11px 22px;
            color: white;
            background: #16a34a;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
        }

        .feedback-login-btn:hover { background: #15803d; }

        /* ================= FOOTER ================= */
        footer {
            margin-top: 30px;
            padding: 20px;
            color: white;
            background: #080808;
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
        }

        footer span {
            color: #16a34a;
            font-weight: bold;
        }

        /* ================= TABLET ================= */
        @media (max-width: 900px) {
            .hero { height: 380px; }

            .features {
                grid-template-columns: 1fr;
                max-width: 700px;
            }

            .feature { min-height: 110px; }

            .slide-three {
                justify-content: center;
                padding: 20px;
            }

            .review-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .reviews-section { padding: 25px; }
        }

        /* ================= MOBILE ================= */
        @media (max-width: 600px) {
            .hero { height: 320px; }

            .hero-button { padding: 10px 22px; font-size: 14px; }

            .promo-two {
                width: 92%;
                padding: 22px;
                border-left-width: 6px;
                border-radius: 6px 20px 20px 6px;
            }

            .promo-two .small-title { font-size: 11px; padding: 6px 12px; }
            .promo-two h2 { font-size: 38px; }
            .promo-two h3 { font-size: 18px; }
            .promo-two p { font-size: 13px; margin-bottom: 15px; }
            .promo-two .promo-button { padding: 9px 20px; font-size: 13px; }

            .slide-three { justify-content: center; padding: 15px; }

            .promo-three { width: 92%; padding: 23px 18px; border-radius: 18px; }
            .promo-three .weekend-label { font-size: 11px; letter-spacing: 2px; }
            .promo-three h2 { font-size: 34px; }
            .promo-three h3 { font-size: 17px; }
            .promo-three p { font-size: 13px; margin-bottom: 16px; }
            .promo-three .promo-button { padding: 10px 22px; font-size: 13px; }

            .slider-arrow { width: 35px; height: 35px; font-size: 22px; }
            .slider-prev { left: 10px; }
            .slider-next { right: 10px; }
            .slider-dots { bottom: 10px; }

            .features,
            .order-section,
            .reviews-section,
            .feedback-section {
                width: 92%;
            }

            .features { margin: 25px auto; gap: 12px; }
            .feature { min-height: 105px; padding: 15px; gap: 12px; }
            .feature-icon { width: 52px; height: 52px; font-size: 25px; }
            .feature-content h3 { font-size: 17px; }
            .feature-content p { font-size: 12px; }

            .order-section { margin: 28px auto; padding: 27px 18px; }
            .order-section h2 { font-size: 24px; }
            .order-section p { font-size: 14px; }

            .reviews-section {
                margin: 30px auto;
                padding: 18px 0;
            }

            .reviews-title h2 { font-size: 23px; }

            .rating-summary {
                gap: 15px;
                padding: 18px;
                margin-bottom: 22px;
            }

            .average-rating { font-size: 46px; }
            .rating-stars { font-size: 20px; }

            .review-grid { grid-template-columns: minmax(0, 1fr); gap: 15px; }
            .review-card { padding: 18px; }
            .review-avatar { width: 44px; height: 44px; min-width: 44px; }
            .review-name { font-size: 14px; }
            .review-stars { font-size: 13px; letter-spacing: 1px; }
            .review-date { font-size: 10px; }
            .review-message { font-size: 13px; margin-top: 16px; }

            .feedback-section { margin: 25px auto 35px; padding: 22px 18px; }
            .feedback-header { align-items: flex-start; gap: 11px; }
            .feedback-icon { width: 46px; height: 46px; font-size: 22px; }
            .feedback-header h2 { font-size: 20px; }
            .feedback-header p { font-size: 12px; }

            .feedback-form { grid-template-columns: minmax(0, 1fr); gap: 15px; }
            .feedback-field.full-width,
            .feedback-submit,
            .feedback-note { grid-column: 1; }

            .feedback-submit { width: 100%; }
            .feedback-note { text-align: center; }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- HERO SLIDER --}}
    <section class="hero" aria-label="Pizza promotions">

        <div class="hero-slide slide-original active">
            <div class="hero-content">
                <a href="{{ route('menu') }}" class="hero-button">
                    🍕 Order Now
                </a>
            </div>
        </div>

        <div class="hero-slide slide-two">
            <div class="promo-two">
                <div class="small-title">🔥 LIMITED PROMO</div>
                <h2>10% OFF</h2>
                <h3>SELECTED PIZZAS</h3>
                <p>Enjoy your favorite pizza and save more today!</p>
                <a href="{{ route('menu') }}" class="promo-button">
                    🍕 ORDER NOW
                </a>
            </div>
        </div>

        <div class="hero-slide slide-three">
            <div class="promo-three">
                <div class="weekend-label">✦ WEEKEND SPECIAL ✦</div>
                <h2>PIZZA<br>WEEKEND</h2>
                <h3>SAVE MORE. EAT MORE.</h3>
                <p>Make your weekend extra delicious with Abuyog Andrea Pizza!</p>
                <a href="{{ route('menu') }}" class="promo-button">
                    🍕 VIEW MENU
                </a>
            </div>
        </div>

        <button type="button" class="slider-arrow slider-prev"
                onclick="changeSlide(-1)" aria-label="Previous slide">
            ‹
        </button>

        <button type="button" class="slider-arrow slider-next"
                onclick="changeSlide(1)" aria-label="Next slide">
            ›
        </button>

        <div class="slider-dots">
            <button type="button" class="slider-dot active"
                    onclick="goToSlide(0)" aria-label="Slide 1"></button>
            <button type="button" class="slider-dot"
                    onclick="goToSlide(1)" aria-label="Slide 2"></button>
            <button type="button" class="slider-dot"
                    onclick="goToSlide(2)" aria-label="Slide 3"></button>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="features">
        <div class="feature">
            <div class="feature-icon">🍕</div>
            <div class="feature-content">
                <h3>Fresh Pizza</h3>
                <p>Freshly prepared pizza made with delicious ingredients.</p>
            </div>
        </div>

        <div class="feature">
            <div class="feature-icon">🚚</div>
            <div class="feature-content">
                <h3>Fast Delivery</h3>
                <p>Get your favorite pizza delivered right to your location.</p>
            </div>
        </div>

        <div class="feature">
            <div class="feature-icon">❤️</div>
            <div class="feature-content">
                <h3>Made With Love</h3>
                <p>We prepare every pizza with care for our customers.</p>
            </div>
        </div>
    </section>

    {{-- ORDER SECTION --}}
    <section class="order-section">
        <h2>Hungry for Pizza?</h2>
        <p>Choose your favorite pizza and order now from Abuyog Andrea Pizza!</p>
        <a href="{{ route('menu') }}" class="order-btn">🍕 View Our Menu</a>
    </section>

    {{-- CUSTOMER RATINGS AND REVIEWS --}}
    @php
        $approvedFeedbacks = collect($feedbacks ?? [])
            ->filter(function ($feedback) {
                return $feedback->status === 'approved'
                    && $feedback->type === 'feedback'
                    && !is_null($feedback->rating);
            })
            ->sortByDesc('created_at')
            ->values();

        $reviewCount = $approvedFeedbacks->count();

        $averageRating = $reviewCount > 0
            ? round($approvedFeedbacks->avg('rating'), 1)
            : 0;
    @endphp

    <section class="reviews-section" id="reviews">

        <div class="reviews-title">
            <h2>
                <a href="{{ route('reviews.index') }}">Ratings &amp; Reviews</a>
            </h2>

            <a href="{{ route('reviews.index') }}"
               class="all-reviews-link"
               aria-label="View all reviews">›</a>
        </div>

        <div class="rating-summary">
            <div class="average-rating">
                {{ number_format($averageRating, 1) }}
            </div>

            <div class="rating-details">
                <div class="rating-stars" aria-label="Average rating">
                    @for ($i = 1; $i <= 5; $i++)
                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                    @endfor
                </div>

                <div class="rating-count">
                    {{ $reviewCount }}
                    {{ $reviewCount === 1 ? 'Rating' : 'Ratings' }}
                </div>
            </div>
        </div>

        <div class="review-grid">
            @forelse ($approvedFeedbacks->take(6) as $feedback)

                @php
                    $customer = $feedback->user;
                    $customerName = $customer?->name ?? 'Customer';

                    $firstLetter = mb_strtoupper(
                        mb_substr(trim($customerName) ?: 'C', 0, 1)
                    );

                    $profilePhoto = $customer?->profile_picture;

                    $profilePhotoUrl = null;

                    if (is_string($profilePhoto) && trim($profilePhoto) !== '') {
                        if (
                            str_starts_with($profilePhoto, 'https://') ||
                            str_starts_with($profilePhoto, 'http://')
                        ) {
                            $profilePhotoUrl = $profilePhoto;
                        } else {
                            $profilePhotoUrl = asset(
                                'storage/' . ltrim($profilePhoto, '/')
                            );
                        }
                    }

                    $rating = max(0, min(5, (int) $feedback->rating));
                @endphp

                <article class="review-card">

                    <div class="review-top">

                        <div class="review-user">

                            <div class="review-avatar">

                                @if ($profilePhotoUrl)
                                    <img
                                        src="{{ $profilePhotoUrl }}"
                                        alt="{{ $customerName }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >

                                    <span class="review-avatar-initial"
                                          style="display:none;">
                                        {{ $firstLetter }}
                                    </span>
                                @else
                                    <span class="review-avatar-initial">
                                        {{ $firstLetter }}
                                    </span>
                                @endif

                            </div>

                            <div class="review-user-info">
                                <div class="review-name">
                                    {{ $customerName }}
                                </div>

                                <div class="review-stars"
                                     aria-label="{{ $rating }} out of 5 stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rating ? '★' : '☆' }}
                                    @endfor
                                </div>
                            </div>

                        </div>

                        <time class="review-date"
                              datetime="{{ $feedback->created_at?->toDateString() }}">
                            {{ $feedback->created_at?->format('M d, Y') }}
                        </time>

                    </div>

                    <p class="review-message">{{ $feedback->message }}</p>

                    @if (!empty($feedback->admin_reply))
                        <div class="review-reply">
                            <strong>Reply from Andrea's Pizza</strong>
                            {{ $feedback->admin_reply }}
                        </div>
                    @endif

                </article>

            @empty

                <div class="no-reviews">
                    <div style="font-size:32px;">⭐</div>
                    <strong>No approved reviews yet.</strong>
                    <p>Be the first to share your experience!</p>
                </div>

            @endforelse
        </div>

    </section>

    {{-- CUSTOMER FEEDBACK FORM --}}
    <section class="feedback-section">

        <div class="feedback-header">
            <div class="feedback-icon">💬</div>

            <div>
                <h2>Send Us Your Feedback</h2>
                <p>
                    Have feedback or a concern?
                    Let us know so we can improve our service.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="feedback-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="feedback-error">
                <strong>Please check the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @auth
            <form
                action="{{ route('customer.feedback.general') }}"
                method="POST"
                class="feedback-form"
                id="customerFeedbackForm"
            >
                @csrf

                <input type="hidden" name="type" value="feedback">

                <div class="feedback-field full-width">
                    <label>Rate your experience</label>

                    <div class="feedback-stars">
                        @for ($star = 1; $star <= 5; $star++)
                            <button
                                type="button"
                                class="feedback-star"
                                data-rating="{{ $star }}"
                                aria-label="Rate {{ $star }} stars"
                                aria-pressed="false"
                            >★</button>
                        @endfor
                    </div>

                    <input
                        type="hidden"
                        name="rating"
                        id="feedbackRating"
                        value="{{ old('rating') }}"
                        required
                    >

                    <small id="ratingLabel">Tap a star to rate</small>
                </div>

                <div class="feedback-field full-width">
                    <label for="order_id">Your delivered order</label>

                    <select name="order_id" id="order_id" required>
                        <option value="">Select an order</option>

                        @foreach (
                            \App\Models\Order::where('user_id', auth()->id())
                                ->where('status', 'delivered')
                                ->latest()
                                ->get() as $order
                        )
                            <option
                                value="{{ $order->id }}"
                                @selected(old('order_id') == $order->id)
                            >
                                Order #{{ $order->order_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="feedback-field full-width">
                    <label for="message">Comment (optional)</label>

                    <textarea
                        name="message"
                        id="message"
                        rows="4"
                        maxlength="1000"
                        placeholder="How was your pizza?"
                    >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="feedback-submit">
                    Submit Review
                </button>

                <p class="feedback-note">
                    Your review will appear after admin approval.
                </p>
            </form>
        @else
            <div class="feedback-login">
                <div class="feedback-login-icon">🔐</div>

                <h3>Want to leave a review?</h3>

                <p>Please log in to review your delivered order.</p>

                <a href="{{ route('login') }}" class="feedback-login-btn">
                    Login to Review
                </a>
            </div>
        @endauth

    </section>

    {{-- FOOTER --}}
    <footer>
        © {{ date('Y') }}
        <span>Abuyog Andrea Pizza</span>
        All Rights Reserved.
    </footer>

    {{-- HERO SLIDER SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentSlide = 0;

            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.slider-dot');
            let slideTimer;

            function showSlide(index) {
                if (!slides.length) return;

                currentSlide = (index + slides.length) % slides.length;

                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === currentSlide);
                });

                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentSlide);
                });
            }

            window.changeSlide = function (direction) {
                showSlide(currentSlide + direction);
                resetTimer();
            };

            window.goToSlide = function (index) {
                showSlide(index);
                resetTimer();
            };

            function resetTimer() {
                clearInterval(slideTimer);
                slideTimer = setInterval(function () {
                    showSlide(currentSlide + 1);
                }, 5000);
            }

            showSlide(0);
            resetTimer();

            /* Customer feedback star rating */
            const stars = document.querySelectorAll('.feedback-star');
            const ratingInput = document.getElementById('feedbackRating');
            const ratingLabel = document.getElementById('ratingLabel');
            const feedbackForm = document.getElementById('customerFeedbackForm');

            const labels = {
                1: 'Poor',
                2: 'Needs improvement',
                3: 'Good',
                4: 'Very good',
                5: 'Excellent'
            };

            function updateStars(rating) {
                stars.forEach(function (star) {
                    const selected = Number(star.dataset.rating) <= rating;

                    star.classList.toggle('active', selected);
                    star.setAttribute('aria-pressed', selected ? 'true' : 'false');
                });

                if (ratingLabel) {
                    ratingLabel.textContent = rating
                        ? rating + '/5 — ' + labels[rating]
                        : 'Tap a star to rate';
                }
            }

            stars.forEach(function (star) {
                star.addEventListener('click', function () {
                    ratingInput.value = star.dataset.rating;
                    updateStars(Number(ratingInput.value));
                });
            });

            updateStars(Number(ratingInput?.value) || 0);

            if (feedbackForm) {
                feedbackForm.addEventListener('submit', function (event) {
                    if (!ratingInput.value) {
                        event.preventDefault();
                        updateStars(0);

                        if (ratingLabel) {
                            ratingLabel.textContent = 'Please select a star rating first.';
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>