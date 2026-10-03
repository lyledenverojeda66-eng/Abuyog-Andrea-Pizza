<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu - Abuyog Andrea Pizza</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        /* =========================
           MENU HEADER
        ========================== */

        .menu-header {
            text-align: center;
            padding: 35px 15px 25px;
            background: #fff8ee;
        }

        .menu-header h1 {
            font-size: 32px;
            color: #ed1c24;
            margin-bottom: 8px;
            font-weight: 800;
        }

        .menu-header p {
            font-size: 14px;
            color: #666;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* =========================
           MENU CONTAINER
        ========================== */

        .menu-container {
            max-width: 1050px;
            margin: 0 auto;
            padding: 10px 15px 40px;
        }

        /* =========================
           MESSAGE
        ========================== */

        .message {
            max-width: 1050px;
            margin: 0 auto 20px;
            padding: 13px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .success-message {
            background: #e9f8ec;
            color: #207a35;
            border: 1px solid #bce5c5;
        }

        .error-message {
            background: #fdeaea;
            color: #b42323;
            border: 1px solid #f2bcbc;
        }

        /* =========================
           CATEGORY
        ========================== */

        .category-section {
            margin-bottom: 35px;
        }

        .category-title {
            font-size: 22px;
            color: #222;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 3px solid #ed1c24;
            display: inline-block;
        }

        .category-description {
            font-size: 13px;
            color: #777;
            margin-bottom: 17px;
            line-height: 1.5;
        }

        /* =========================
           PIZZA GRID
        ========================== */

        .pizza-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        /* =========================
           PIZZA CARD
        ========================== */

        .pizza-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            border: 1px solid #eee;
            transition: transform 0.2s ease,
                        box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .pizza-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        /* =========================
           PIZZA IMAGE
        ========================== */

        .pizza-image-wrapper {
            width: 100%;
            height: 155px;
            background: #f5f5f5;
            overflow: hidden;
        }

        .pizza-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        /* =========================
           PIZZA CONTENT
        ========================== */

        .pizza-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .pizza-name {
            font-size: 19px;
            font-weight: 700;
            color: #222;
            margin-bottom: 7px;
        }

        .pizza-description {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            min-height: 40px;
            margin-bottom: 10px;
        }

        .pizza-bottom {
            margin-top: auto;
        }

        .pizza-price {
            font-size: 19px;
            font-weight: 800;
            color: #ed1c24;
            margin-bottom: 6px;
        }

        .pizza-stock {
            font-size: 12px;
            color: #777;
            margin-bottom: 12px;
        }

        .pizza-stock.out {
            color: #d00000;
            font-weight: 700;
        }

        /* =========================
           ADD TO CART - GREEN
        ========================== */

        .add-btn {
            width: 100%;
            border: none;
            border-radius: 7px;
            background: #198754;
            color: white;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease,
                        transform 0.2s ease;
        }

        .add-btn:hover {
            background: #146c43;
        }

        .add-btn:active {
            transform: scale(0.98);
        }

        .add-btn.disabled {
            background: #999;
            cursor: not-allowed;
        }

        /* =========================
           EMPTY CATEGORY
        ========================== */

        .empty-category {
            background: white;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #777;
            font-size: 14px;
        }

        /* =========================
           FOOTER
        ========================== */

        .menu-footer {
            background: #111;
            color: #fff;
            text-align: center;
            padding: 20px 15px;
            margin-top: 15px;
        }

        .menu-footer p {
            font-size: 13px;
            color: #ddd;
        }

        /* =========================
           TABLET
        ========================== */

        @media (max-width: 900px) {

            .pizza-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-header h1 {
                font-size: 29px;
            }
        }

        /* =========================
           MOBILE
        ========================== */

        @media (max-width: 600px) {

            .menu-header {
                padding: 28px 15px 20px;
            }

            .menu-header h1 {
                font-size: 26px;
            }

            .menu-header p {
                font-size: 13px;
            }

            .menu-container {
                padding: 5px 12px 30px;
            }

            .pizza-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .pizza-image-wrapper {
                height: 190px;
            }

            .category-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <section class="menu-header">

        <h1>Our Pizza Menu</h1>

        <p>
            Choose your favorite pizza from Abuyog Andrea Pizza
            and enjoy delicious flavors made for every craving.
        </p>

    </section>


    

    <?php if(session('success')): ?>

        <div class="message success-message">
            <?php echo e(session('success')); ?>

        </div>

    <?php endif; ?>


    

    <?php if(session('error')): ?>

        <div class="message error-message">
            <?php echo e(session('error')); ?>

        </div>

    <?php endif; ?>


    

    <main class="menu-container">

        <?php

            /*
            |--------------------------------------------------------------------------
            | LOCAL PIZZA IMAGES
            |--------------------------------------------------------------------------
            |
            | Folder:
            | public/image/pizzas/
            |
            | Actual files:
            |
            | Beef.png
            | Ham & Cheese Pizza.png
            | Hawaiian pizza.png
            | Pepperoni pizza.png
            | bacon.png.webp
            | Vegetarian.png
            |
            */

            $pizzaImages = [

                'Ham & Cheese' =>
                    asset('image/pizzas/Ham & Cheese Pizza.png'),

                'Hawaiian' =>
                    asset('image/pizzas/Hawaiian pizza.png'),

                'Pepperoni' =>
                    asset('image/pizzas/Pepperoni pizza.png'),

                'Bacon' =>
                    asset('image/pizzas/bacon.png.webp'),

                'Beef' =>
                    asset('image/pizzas/Beef.png'),

                'Vegetarian' =>
                    asset('image/pizzas/Vegetarian.png'),

            ];

        ?>


        

        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <section class="category-section">

                <h2 class="category-title">
                    <?php echo e($category->name); ?>

                </h2>


                <?php if($category->description): ?>

                    <p class="category-description">
                        <?php echo e($category->description); ?>

                    </p>

                <?php endif; ?>


                <?php if($category->pizzas->count() > 0): ?>

                    <div class="pizza-grid">

                        <?php $__currentLoopData = $category->pizzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php

                                $image =
                                    $pizzaImages[$pizza->name]
                                    ?? asset('image/pizzas/Beef.png');

                            ?>


                            

                            <article class="pizza-card">

                                

                                <div class="pizza-image-wrapper">

                                    <img
                                        src="<?php echo e($image); ?>"
                                        alt="<?php echo e($pizza->name); ?>"
                                        class="pizza-image"
                                        loading="lazy"
                                    >

                                </div>


                                

                                <div class="pizza-content">

                                    <h3 class="pizza-name">
                                        <?php echo e($pizza->name); ?>

                                    </h3>


                                    <?php if($pizza->description): ?>

                                        <p class="pizza-description">
                                            <?php echo e($pizza->description); ?>

                                        </p>

                                    <?php else: ?>

                                        <p class="pizza-description">
                                            Delicious
                                            <?php echo e($pizza->name); ?>

                                            pizza from
                                            Abuyog Andrea Pizza.
                                        </p>

                                    <?php endif; ?>


                                    <div class="pizza-bottom">

                                        

                                        <div class="pizza-price">
                                            ₱<?php echo e(number_format((float) $pizza->price, 2)); ?>

                                        </div>


                                        

                                        <?php if($pizza->stock > 0): ?>

                                            <div class="pizza-stock">
                                                <?php echo e($pizza->stock); ?>

                                                available
                                            </div>

                                        <?php else: ?>

                                            <div class="pizza-stock out">
                                                Out of Stock
                                            </div>

                                        <?php endif; ?>


                                        

                                        <?php if($pizza->status && $pizza->stock > 0): ?>

                                            <form
                                                action="<?php echo e(route('cart.add', $pizza)); ?>"
                                                method="POST"
                                            >

                                                <?php echo csrf_field(); ?>

                                                <button
                                                    type="submit"
                                                    class="add-btn"
                                                >
                                                    Add to Cart
                                                </button>

                                            </form>

                                        <?php else: ?>

                                            <button
                                                type="button"
                                                class="add-btn disabled"
                                                disabled
                                            >
                                                Out of Stock
                                            </button>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </article>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php else: ?>

                    <div class="empty-category">
                        No pizzas available in this category.
                    </div>

                <?php endif; ?>

            </section>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <div class="empty-category">
                No pizza categories are available at the moment.
            </div>

        <?php endif; ?>

    </main>


    

    <footer class="menu-footer">

        <p>
            © <?php echo e(date('Y')); ?> Abuyog Andrea Pizza.
            All Rights Reserved.
        </p>

    </footer>

</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/menu.blade.php ENDPATH**/ ?>