

<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">

    <div>

        <h1>💳 Payments</h1>

        <p>
            Monitor all payment transactions.
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
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Reference</th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>
                            <?php echo e($payment->order->order_number ?? 'N/A'); ?>

                        </td>

                        <td>
                            <?php echo e($payment->order->user->name ?? 'Customer'); ?>

                        </td>

                        <td>

                            <?php if($payment->method === 'gcash'): ?>

                                📱 GCash

                            <?php else: ?>

                                💵 Cash

                            <?php endif; ?>

                        </td>

                        <td>

                            <strong style="color:#15803d">

                                ₱<?php echo e(number_format($payment->amount, 2)); ?>


                            </strong>

                        </td>

                        <td>

                            <span
                                class="status
                                <?php echo e($payment->status === 'paid'
                                    ? 'delivered'
                                    : ($payment->status === 'failed'
                                        ? 'cancelled'
                                        : 'pending')); ?>"
                            >

                                <?php echo e($payment->status); ?>


                            </span>

                        </td>

                        <td>

                            <?php echo e($payment->reference_number ?? '—'); ?>


                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center"
                        >
                            No payments found.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/payments.blade.php ENDPATH**/ ?>