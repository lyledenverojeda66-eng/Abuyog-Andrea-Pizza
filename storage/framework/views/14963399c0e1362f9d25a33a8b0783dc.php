

<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .payments-page {
        width: 100%;
    }

    .payments-page .page-header {
        margin-bottom: 20px;
    }

    .payments-page .page-header h1 {
        margin: 0 0 6px 0;
        line-height: 1.4;
    }

    .payments-page .page-header p {
        margin: 0;
        line-height: 1.5;
        color: #6b7280;
    }

    .payments-page .card {
        width: 100%;
    }

    .payments-page .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .payments-page table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 850px;
    }

    .payments-page table th {
        padding: 13px 16px;
        line-height: 1.4;
        white-space: nowrap;
        text-align: left;
    }

    .payments-page table td {
        padding: 14px 16px;
        line-height: 1.5;
        vertical-align: middle;
    }

    /* Order */
    .payment-order {
        font-weight: 700;
        color: #111827;
        white-space: nowrap;
    }

    /* Customer */
    .payment-customer {
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }

    /* Method */
    .payment-method {
        display: inline-block;
        white-space: nowrap;
        line-height: 1.5;
    }

    /* Amount */
    .payment-amount {
        display: inline-block;
        color: #15803d;
        font-weight: 800;
        white-space: nowrap;
        line-height: 1.5;
    }

    /* Status */
    .payments-page .status {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 5px 10px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 800;

        line-height: 1.4;
        text-transform: capitalize;

        white-space: nowrap;
    }

    /* Reference */
    .payment-reference {
        color: #4b5563;
        white-space: nowrap;
        line-height: 1.5;
    }

    /* Empty */
    .empty-payments {
        text-align: center !important;
        padding: 35px 20px !important;
        color: #6b7280;
        line-height: 1.5;
    }

    @media (max-width: 850px) {

        .payments-page table {
            min-width: 800px;
        }

        .payments-page table th,
        .payments-page table td {
            padding: 11px 13px;
        }

    }
</style>


<div class="payments-page">

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

                                <span class="payment-order">
                                    <?php echo e($payment->order->order_number ?? 'N/A'); ?>

                                </span>

                            </td>


                            

                            <td>

                                <span class="payment-customer">
                                    <?php echo e($payment->order->user->name ?? 'Customer'); ?>

                                </span>

                            </td>


                            

                            <td>

                                <span class="payment-method">

                                    <?php if($payment->method === 'gcash'): ?>

                                        📱 GCash

                                    <?php else: ?>

                                        💵 Cash

                                    <?php endif; ?>

                                </span>

                            </td>


                            

                            <td>

                                <strong class="payment-amount">

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

                                <span class="payment-reference">

                                    <?php echo e($payment->reference_number ?? '—'); ?>


                                </span>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td
                                colspan="6"
                                class="empty-payments"
                            >
                                No payments found.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/payments.blade.php ENDPATH**/ ?>