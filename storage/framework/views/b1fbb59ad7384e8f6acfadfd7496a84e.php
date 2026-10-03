

<?php $__env->startSection('title', 'Deliveries'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">

    <div>

        <h1>🚚 Deliveries</h1>

        <p>
            Monitor customer deliveries and riders.
        </p>

    </div>

</div>


<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Order</th>
                    <th>Customer</th>
                    <th>Rider</th>
                    <th>Contact</th>
                    <th>Picked Up</th>
                    <th>Delivered</th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>

                            <strong style="color:#15803d">

                                <?php echo e($delivery->order->order_number ?? 'N/A'); ?>


                            </strong>

                        </td>

                        <td>

                            <?php echo e($delivery->order->user->name ?? 'Customer'); ?>


                        </td>

                        <td>

                            <?php echo e($delivery->rider_name ?? 'Not assigned'); ?>


                        </td>

                        <td>

                            <?php echo e($delivery->rider_contact ?? '—'); ?>


                        </td>

                        <td>

                            <?php echo e($delivery->picked_up_at
                                ? $delivery->picked_up_at->format('M d, Y h:i A')
                                : '—'); ?>


                        </td>

                        <td>

                            <?php echo e($delivery->delivered_at
                                ? $delivery->delivered_at->format('M d, Y h:i A')
                                : '—'); ?>


                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center"
                        >

                            No delivery records found.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/deliveries.blade.php ENDPATH**/ ?>