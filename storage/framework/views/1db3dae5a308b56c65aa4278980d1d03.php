

<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">

    <div>

        <h1>👥 Customers</h1>

        <p>
            Registered customer accounts.
        </p>

    </div>

</div>


<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Registered</th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>
                            <?php echo e($customer->id); ?>

                        </td>

                        <td>
                            <strong>
                                <?php echo e($customer->name); ?>

                            </strong>
                        </td>

                        <td>
                            <?php echo e($customer->email); ?>

                        </td>

                        <td>

                            <strong style="color:#15803d">
                                <?php echo e($customer->orders_count); ?>

                            </strong>

                        </td>

                        <td>
                            <?php echo e($customer->created_at->format('M d, Y')); ?>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="5"
                            style="text-align:center"
                        >
                            No customers found.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/customers.blade.php ENDPATH**/ ?>