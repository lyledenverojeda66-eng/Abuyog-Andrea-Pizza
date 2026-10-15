

<?php $__env->startSection('title', 'Add Banner'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .banner-create {
        max-width: 700px;
    }

    .banner-header {
        margin-bottom: 20px;
    }

    .banner-header h1 {
        margin: 0;
        font-size: 25px;
        font-weight: 800;
        color: #111827;
    }

    .banner-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 14px;
        color: #15803d;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .banner-form {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #111827;
        font-size: 12px;
        font-weight: 800;
    }

    .form-input {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #ffffff;
        color: #111827;
        font-size: 13px;
        outline: none;
    }

    .form-input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22,163,74,.10);
    }

    .file-box {
        border: 2px dashed #bbf7d0;
        background: #f0fdf4;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .file-box input {
        width: 100%;
        font-size: 13px;
    }

    .file-help {
        margin-top: 8px;
        color: #6b7280;
        font-size: 11px;
    }

    .preview {
        display: none;
        margin-top: 15px;
    }

    .preview img {
        width: 100%;
        max-height: 260px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid #e5e7eb;
    }

    .error-message {
        margin-top: 6px;
        color: #dc2626;
        font-size: 11px;
    }

    .form-actions {
        display: flex;
        gap: 8px;
        margin-top: 22px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 7px;
        border: 0;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-save {
        background: #15803d;
        color: #ffffff;
    }

    .btn-save:hover {
        background: #166534;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    @media (max-width: 600px) {
        .banner-form {
            padding: 18px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="banner-create">

    <a
        href="<?php echo e(route('admin.banners.index')); ?>"
        class="back-link"
    >
        ← Back to Banners
    </a>

    <div class="banner-header">
        <h1>Add Banner</h1>

        <p>
            Upload a banner that will automatically appear
            on the customer home page.
        </p>
    </div>


    <form
        action="<?php echo e(route('admin.banners.store')); ?>"
        method="POST"
        enctype="multipart/form-data"
        class="banner-form"
    >

        <?php echo csrf_field(); ?>


        

        <div class="form-group">

            <label
                for="title"
                class="form-label"
            >
                Banner Title
                <span style="font-weight:400;color:#9ca3af;">
                    (Optional)
                </span>
            </label>

            <input
                type="text"
                id="title"
                name="title"
                class="form-input"
                value="<?php echo e(old('title')); ?>"
                placeholder="Example: Special Pizza Promo"
            >

            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        </div>


        

        <div class="form-group">

            <label
                for="image"
                class="form-label"
            >
                Banner Image
            </label>

            <div class="file-box">

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >

                <div class="file-help">
                    JPG, JPEG, PNG or WEBP • Maximum 5MB
                </div>

                <div
                    class="preview"
                    id="imagePreview"
                >
                    <img
                        id="previewImage"
                        src=""
                        alt="Banner Preview"
                    >
                </div>

            </div>

            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        </div>


        

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-save"
            >
                Upload Banner
            </button>

            <a
                href="<?php echo e(route('admin.banners.index')); ?>"
                class="btn btn-cancel"
            >
                Cancel
            </a>

        </div>

    </form>

</div>


<script>
    const imageInput =
        document.getElementById('image');

    const preview =
        document.getElementById('imagePreview');

    const previewImage =
        document.getElementById('previewImage');


    imageInput.addEventListener(
        'change',
        function () {

            const file = this.files[0];

            if (!file) {

                preview.style.display = 'none';

                return;
            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    previewImage.src =
                        event.target.result;

                    preview.style.display =
                        'block';
                };


            reader.readAsDataURL(file);
        }
    );
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/banners/create.blade.php ENDPATH**/ ?>