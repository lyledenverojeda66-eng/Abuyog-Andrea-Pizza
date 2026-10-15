


<?php $__env->startSection('title', 'Edit Banner'); ?>

<?php $__env->startSection('content'); ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Banner</h2>
            <p class="text-muted mb-0">Update your banner details.</p>
        </div>

        <a href="<?php echo e(route('admin.banners.index')); ?>"
           class="btn btn-secondary">
            Back to Banners
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Please check the following errors:</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <form
                action="<?php echo e(route('admin.banners.update', $banner)); ?>"
                method="POST"
                enctype="multipart/form-data"
            >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label for="title" class="form-label">
                        Banner Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="<?php echo e(old('title', $banner->title)); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="3"
                    ><?php echo e(old('description', $banner->description)); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>

                    <div class="mb-3">
                        <img
                            src="<?php echo e(asset('storage/' . $banner->image)); ?>"
                            alt="Current banner"
                            style="max-width: 300px; max-height: 180px; object-fit: contain;"
                        >
                    </div>

                    <label for="image" class="form-label">
                        Replace Image (optional)
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                    >
                </div>

                <div class="mb-3">
                    <label for="button_text" class="form-label">
                        Button Text
                    </label>

                    <input
                        type="text"
                        name="button_text"
                        id="button_text"
                        class="form-control"
                        value="<?php echo e(old('button_text', $banner->button_text)); ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="button_link" class="form-label">
                        Button Link
                    </label>

                    <input
                        type="text"
                        name="button_link"
                        id="button_link"
                        class="form-control"
                        value="<?php echo e(old('button_link', $banner->button_link)); ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        class="form-control"
                        min="0"
                        value="<?php echo e(old('sort_order', $banner->sort_order)); ?>"
                    >
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        name="status"
                        id="status"
                        value="1"
                        class="form-check-input"
                        <?php echo e(old('status', $banner->status) ? 'checked' : ''); ?>

                    >

                    <label for="status" class="form-check-label">
                        Active Banner
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a
                    href="<?php echo e(route('admin.banners.index')); ?>"
                    class="btn btn-secondary"
                >
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/banners/edit.blade.php ENDPATH**/ ?>