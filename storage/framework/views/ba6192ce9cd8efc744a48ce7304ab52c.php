

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Banner Management</h2>
            <p class="text-muted mb-0">
                Manage the banners displayed on the customer home page.
            </p>
        </div>

        <a href="<?php echo e(route('admin.banners.create')); ?>"
           class="btn btn-primary">
            + Add Banner
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <?php if($banners->count()): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th width="90">Image</th>
                                <th>Banner</th>
                                <th width="100">Order</th>
                                <th width="120">Status</th>
                                <th width="250">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>

                                    <td>
                                        <img
                                            src="<?php echo e(asset('image/banners/' . $banner->image)); ?>"
                                            alt="<?php echo e($banner->title ?? 'Banner'); ?>"
                                            style="
                                                width:80px;
                                                height:55px;
                                                object-fit:cover;
                                                border-radius:8px;
                                                border:1px solid #ddd;
                                            "
                                        >
                                    </td>

                                    <td>

                                        <div class="fw-bold">
                                            <?php echo e($banner->title ?: 'Untitled Banner'); ?>

                                        </div>

                                        <?php if($banner->description): ?>
                                            <div class="text-muted small mt-1">
                                                <?php echo e(\Illuminate\Support\Str::limit($banner->description, 100)); ?>

                                            </div>
                                        <?php endif; ?>

                                        <?php if($banner->button_text): ?>
                                            <div class="small mt-1">
                                                Button:
                                                <strong><?php echo e($banner->button_text); ?></strong>
                                            </div>
                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <?php echo e($banner->sort_order); ?>

                                    </td>

                                    <td>

                                        <?php if($banner->status): ?>

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                Inactive
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <div class="d-flex gap-2 flex-wrap">

                                            <a
                                                href="<?php echo e(route('admin.banners.edit', $banner)); ?>"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Edit
                                            </a>

                                           <form
    action="<?php echo e(route('admin.banners.toggle', $banner)); ?>"
    method="POST"
    style="display: inline;"
>
    <?php echo csrf_field(); ?>

    <button
        type="submit"
        class="btn btn-sm btn-outline-warning"
    >
        <?php echo e($banner->status ? 'Deactivate' : 'Activate'); ?>

    </button>
</form>
                                            <form
                                                action="<?php echo e(route('admin.banners.destroy', $banner)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this banner?');"
                                            >
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="text-center py-5">

                    <div style="font-size:50px;">
                        🖼️
                    </div>

                    <h4 class="mt-3">
                        No banners yet
                    </h4>

                    <p class="text-muted">
                        Add your first banner to display it on the customer home page.
                    </p>

                    <a
                        href="<?php echo e(route('admin.banners.create')); ?>"
                        class="btn btn-primary"
                    >
                        + Add Banner
                    </a>

                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>