<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Contact - Abuyog Andrea Pizza</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #fff8ee;
            color: #222;
        }

        /* =====================================================
           CONTACT HEADER
        ===================================================== */

        .contact-header {
            text-align: center;
            padding: 45px 20px 30px;
        }

        .contact-header h1 {
            margin: 0 0 10px;
            font-size: 34px;
        }

        .contact-header p {
            margin: 0;
            color: #666;
            font-size: 16px;
        }


        /* =====================================================
           CONTACT INFORMATION
        ===================================================== */

        .contact-container {
            max-width: 1100px;
            margin: auto;
            padding: 0 20px 40px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .contact-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            text-align: center;
        }

        .contact-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .contact-card p {
            margin: 5px 0;
            color: #555;
            line-height: 1.5;
        }

        .contact-card a {
            color: #198754;
            text-decoration: none;
        }


        /* =====================================================
           PUBLIC CUSTOMER REVIEWS
        ===================================================== */

        .reviews-section {
            padding: 45px 20px;
            background: #fff;
        }

        .reviews-container {
            max-width: 1100px;
            margin: auto;
        }

        .reviews-title {
            text-align: center;
            margin-bottom: 8px;
        }

        .reviews-title h2 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .reviews-title p {
            margin: 0 0 30px;
            color: #666;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .review-card {
            background: #fff8ee;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #eee;
        }

        .review-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .customer-name {
            font-weight: bold;
            font-size: 16px;
        }

        .review-date {
            color: #888;
            font-size: 12px;
            white-space: nowrap;
        }

        .stars {
            color: #f5a623;
            font-size: 19px;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .review-message {
            color: #444;
            line-height: 1.6;
            font-size: 15px;
            margin-top: 10px;
        }

        .admin-reply {
            margin-top: 15px;
            padding: 12px;
            background: white;
            border-left: 4px solid #198754;
            border-radius: 5px;
        }

        .admin-reply strong {
            color: #198754;
        }

        .admin-reply p {
            margin: 6px 0 0;
            color: #555;
            line-height: 1.5;
        }

        .no-reviews {
            background: #fff8ee;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            color: #777;
        }


        /* =====================================================
           FEEDBACK SECTION
        ===================================================== */

        .feedback-section {
            padding: 45px 20px;
            background: #fff8ee;
        }

        .feedback-container {
            max-width: 650px;
            margin: auto;
        }

        .feedback-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        .feedback-box h2 {
            margin-top: 0;
            margin-bottom: 8px;
            text-align: center;
        }

        .feedback-description {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
            font-size: 15px;
        }

        .form-group textarea {
            min-height: 130px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 6px;
            background: #198754;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            opacity: .9;
        }


        /* =====================================================
           LOGIN MESSAGE
        ===================================================== */

        .login-message {
            text-align: center;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        .login-message p {
            color: #666;
        }

        .login-btn {
            display: inline-block;
            background: #198754;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }


        /* =====================================================
           SUCCESS / ERROR
        ===================================================== */

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .validation-errors {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .validation-errors ul {
            margin: 0;
            padding-left: 20px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 800px) {

            .contact-grid {
                grid-template-columns: 1fr 1fr;
            }

            .reviews-grid {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 550px) {

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .reviews-grid {
                grid-template-columns: 1fr;
            }

            .contact-header h1 {
                font-size: 28px;
            }

            .feedback-box {
                padding: 20px;
            }

        }

    </style>

</head>


<body>




<?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>




<section class="contact-header">

    <h1>
        Contact Us
    </h1>

    <p>
        We'd love to hear from you!
    </p>

</section>




<section class="contact-container">

    <div class="contact-grid">

        <div class="contact-card">

            <h3>
                📍 Location
            </h3>

            <p>
                P2W6+GXX Andrea's Pizza,
                Avenida Rizal St., Bito,
                Abuyog, 6510 Northern Leyte
            </p>

        </div>


        <div class="contact-card">

            <h3>
                📞 Phone
            </h3>

            <p>
                <a href="tel:09066151243">
                    09066151243
                </a>
            </p>

        </div>


        <div class="contact-card">

            <h3>
                ✉️ Email
            </h3>

            <p>
                <a href="mailto:Andreapizza@gmail.com">
                    Andreapizza@gmail.com
                </a>
            </p>

        </div>

    </div>

</section>




<section class="reviews-section">

    <div class="reviews-container">

        <div class="reviews-title">

            <h2>
                ⭐ Customer Reviews
            </h2>

            <p>
                See what our customers say about Abuyog Andrea Pizza.
            </p>

        </div>


        <?php if($feedbacks->count() > 0): ?>

            <div class="reviews-grid">

                <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="review-card">

                        <div class="review-top">

                            <div>

                                <div class="customer-name">
                                    <?php echo e($feedback->user->name ?? 'Customer'); ?>

                                </div>

                                <div class="stars">

                                    <?php for($i = 1; $i <= 5; $i++): ?>

                                        <?php if($i <= $feedback->rating): ?>
                                            ★
                                        <?php else: ?>
                                            ☆
                                        <?php endif; ?>

                                    <?php endfor; ?>

                                </div>

                            </div>

                            <div class="review-date">

                                <?php echo e($feedback->created_at->format('M d, Y')); ?>


                            </div>

                        </div>


                        <div class="review-message">

                            <?php if($feedback->message): ?>

                                "<?php echo e($feedback->message); ?>"

                            <?php elseif($feedback->concern): ?>

                                "<?php echo e($feedback->concern); ?>"

                            <?php endif; ?>

                        </div>


                        

                        <?php if($feedback->admin_reply): ?>

                            <div class="admin-reply">

                                <strong>
                                    Andrea's Pizza:
                                </strong>

                                <p>
                                    <?php echo e($feedback->admin_reply); ?>

                                </p>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        <?php else: ?>

            <div class="no-reviews">

                <p>
                    No customer reviews yet.
                </p>

                <p>
                    Be the first to share your experience!
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>




<section class="feedback-section">

    <div class="feedback-container">

        <?php if(auth()->guard()->check()): ?>

            <div class="feedback-box">

                <h2>
                    ⭐ Rate Your Experience
                </h2>

                <p class="feedback-description">
                    Tell us about your experience ordering from us.
                </p>


                

                <?php if(session('feedback_success')): ?>

                    <div class="success-message">

                        <?php echo e(session('feedback_success')); ?>


                    </div>

                <?php endif; ?>


                

                <?php if(session('error')): ?>

                    <div class="error-message">

                        <?php echo e(session('error')); ?>


                    </div>

                <?php endif; ?>


                

                <?php if($errors->any()): ?>

                    <div class="validation-errors">

                        <ul>

                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li>
                                    <?php echo e($error); ?>

                                </li>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>

                    </div>

                <?php endif; ?>


                <form
                    action="<?php echo e(route('feedback.store')); ?>"
                    method="POST"
                >

                    <?php echo csrf_field(); ?>


                    

                    <div class="form-group">

                        <label for="type">
                            Type
                        </label>

                        <select
                            name="type"
                            id="type"
                            required
                        >

                            <option value="">
                                Select Type
                            </option>

                            <option
                                value="feedback"
                                <?php echo e(old('type') === 'feedback' ? 'selected' : ''); ?>

                            >
                                Feedback
                            </option>

                            <option
                                value="concern"
                                <?php echo e(old('type') === 'concern' ? 'selected' : ''); ?>

                            >
                                Concern
                            </option>

                        </select>

                    </div>


                    

                    <div class="form-group">

                        <label for="rating">
                            Rating
                        </label>

                        <select
                            name="rating"
                            id="rating"
                            required
                        >

                            <option value="">
                                Select Rating
                            </option>

                            <option
                                value="5"
                                <?php echo e(old('rating') == 5 ? 'selected' : ''); ?>

                            >
                                ★★★★★ - Excellent
                            </option>

                            <option
                                value="4"
                                <?php echo e(old('rating') == 4 ? 'selected' : ''); ?>

                            >
                                ★★★★☆ - Good
                            </option>

                            <option
                                value="3"
                                <?php echo e(old('rating') == 3 ? 'selected' : ''); ?>

                            >
                                ★★★☆☆ - Average
                            </option>

                            <option
                                value="2"
                                <?php echo e(old('rating') == 2 ? 'selected' : ''); ?>

                            >
                                ★★☆☆☆ - Poor
                            </option>

                            <option
                                value="1"
                                <?php echo e(old('rating') == 1 ? 'selected' : ''); ?>

                            >
                                ★☆☆☆☆ - Very Poor
                            </option>

                        </select>

                    </div>


                    

                    <div class="form-group">

                        <label for="message">
                            Feedback or Concern
                        </label>

                        <textarea
                            name="message"
                            id="message"
                            placeholder="Tell us about your experience..."
                            required
                        ><?php echo e(old('message')); ?></textarea>

                    </div>


                    

                    <button
                        type="submit"
                        class="submit-btn"
                    >
                        Submit Feedback
                    </button>

                </form>

            </div>


        <?php else: ?>


            

            <div class="login-message">

                <h2>
                    ⭐ Share Your Experience
                </h2>

                <p>
                    You need to log in to submit feedback or a concern.
                </p>

                <a
                    href="<?php echo e(route('login')); ?>"
                    class="login-btn"
                >
                    Log In
                </a>

            </div>

        <?php endif; ?>

    </div>

</section>


</body>

</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/contact.blade.php ENDPATH**/ ?>