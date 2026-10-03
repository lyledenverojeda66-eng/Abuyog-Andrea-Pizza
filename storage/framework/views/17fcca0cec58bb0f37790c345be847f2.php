<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Pizzas - Admin</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #222;
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .title h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .title p {
            color: #777;
            font-size: 14px;
        }

        .add-btn {
            display: inline-block;
            background: #e51b23;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 6px;
            font-weight: bold;
        }

        .add-btn:hover {
            background: #c9141b;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #e8f7e8;
            color: #247a24;
            border: 1px solid #b8dfb8;
        }

        .error {
            background: #fdeaea;
            color: #a11a1a;
            border: 1px solid #efb7b7;
        }

        .table-box {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #111;
            color: white;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .pizza-image {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .no-image {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee;
            color: #888;
            border-radius: 8px;
            font-size: 11px;
            text-align: center;
        }

        .pizza-name {
            font-weight: bold;
            color: #222;
        }

        .category {
            color: #666;
        }

        .price {
            font-weight: bold;
            color: #e51b23;
        }

        .stock {
            font-weight: bold;
        }

        .stock-zero {
            color: #d00000;
        }

        .stock-available {
            color: #228b22;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background: #e5f7e5;
            color: #218521;
        }

        .status-inactive {
            background: #fbe5e5;
            color: #b22222;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .btn {
            border: none;
            padding: 8px 11px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
        }

        .edit-btn {
            background: #ffc107;
            color: #111;
        }

        .edit-btn:hover {
            background: #e0a800;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background: #bd2130;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        @media (max-width: 700px) {
            .top {
                flex-direction: column;
                align-items: flex-start;
            }

            .add-btn {
                width: 100%;
                text-align: center;
            }

            .container {
                width: 92%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top">

        <div class="title">
            <h1>Manage Pizzas</h1>
            <p>Add, update, and manage your pizza products.</p>
        </div>

        <a href="<?php echo e(route('admin.pizzas.create')); ?>" class="add-btn">
            + Add Pizza
        </a>

    </div>

    <?php if(session('success')): ?>
        <div class="alert success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert error">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert error">
            <ul style="padding-left: 18px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="table-box">

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Pizza</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $pizzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td>
                            <?php echo e($pizza->id); ?>

                        </td>

                        <td>

                            <?php if($pizza->image): ?>

                                <img
                                    src="<?php echo e(asset($pizza->image)); ?>"
                                    alt="<?php echo e($pizza->name); ?>"
                                    class="pizza-image"
                                >

                            <?php else: ?>

                                <div class="no-image">
                                    No Image
                                </div>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div class="pizza-name">
                                <?php echo e($pizza->name); ?>

                            </div>

                            <?php if($pizza->description): ?>
                                <small style="color:#777;">
                                    <?php echo e(Str::limit($pizza->description, 45)); ?>

                                </small>
                            <?php endif; ?>

                        </td>

                        <td class="category">

                            <?php echo e($pizza->category->name ?? 'No Category'); ?>


                        </td>

                        <td class="price">

                            ₱<?php echo e(number_format($pizza->price, 2)); ?>


                        </td>

                        <td>

                            <?php if($pizza->stock <= 0): ?>

                                <span class="stock stock-zero">
                                    Out of Stock
                                </span>

                            <?php else: ?>

                                <span class="stock stock-available">
                                    <?php echo e($pizza->stock); ?>

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if($pizza->status): ?>

                                <span class="status status-active">
                                    Active
                                </span>

                            <?php else: ?>

                                <span class="status status-inactive">
                                    Inactive
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="<?php echo e(route('admin.pizzas.edit', $pizza->id)); ?>"
                                    class="btn edit-btn"
                                >
                                    Edit
                                </a>

                                <form
                                    action="<?php echo e(route('admin.pizzas.destroy', $pizza->id)); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this pizza?');"
                                >

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button
                                        type="submit"
                                        class="btn delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="8" class="empty">
                            No pizza products found.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/admin/pizzas/index.blade.php ENDPATH**/ ?>