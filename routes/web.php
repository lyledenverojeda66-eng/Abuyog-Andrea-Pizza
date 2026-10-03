<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GcashController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/menu', [HomeController::class, 'menu'])
    ->name('menu');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('contact');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart');

Route::post('/cart/add/{pizza}', [CartController::class, 'add'])
    ->name('cart.add');

Route::put('/cart/update/{pizza}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/remove/{pizza}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');

Route::post('/cart/options', [CartController::class, 'saveOptions'])
    ->name('cart.options');


/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Customer Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/dashboard', [
        CustomerController::class,
        'dashboard'
    ])->name('customer.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Customer Orders
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/orders', [
        CustomerController::class,
        'orders'
    ])->name('customer.orders');


    /*
    |--------------------------------------------------------------------------
    | Order Tracking
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/orders/{order}/tracking', [
        CustomerController::class,
        'tracking'
    ])->name('customer.order.tracking');


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER FEEDBACK
    |--------------------------------------------------------------------------
    */

    Route::post('/feedback', [
        FeedbackController::class,
        'store'
    ])->name('feedback.store');


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout', [
        CheckoutController::class,
        'index'
    ])->name('checkout');

    Route::post('/checkout', [
        CheckoutController::class,
        'store'
    ])->name('checkout.store');


    /*
    |--------------------------------------------------------------------------
    | GCASH / MARIBANK PAYMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/gcash/{order}', [
        GcashController::class,
        'show'
    ])->name('gcash.payment');

    Route::post('/gcash/{order}/pay', [
        GcashController::class,
        'pay'
    ])->name('gcash.pay');

    Route::get('/gcash/{order}/success', [
        GcashController::class,
        'success'
    ])->name('gcash.success');


    /*
    |--------------------------------------------------------------------------
    | ORDER CONFIRMATION
    |--------------------------------------------------------------------------
    */

    Route::get('/order/{order}/confirmation', function (\App\Models\Order $order) {

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'orderItems.pizza',
            'payment',
            'delivery',
        ]);

        return view(
            'order.confirmation',
            compact('order')
        );

    })->name('order.confirmation');

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
| NOTE:
| These currently use auth middleware.
| Admin role protection can be added separately.
|
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        AdminController::class,
        'dashboard'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PIZZA MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/pizzas', [
        AdminController::class,
        'pizzas'
    ])->name('pizzas');

    Route::get('/pizzas/create', [
        AdminController::class,
        'pizzaCreate'
    ])->name('pizzas.create');

    Route::post('/pizzas', [
        AdminController::class,
        'pizzaStore'
    ])->name('pizzas.store');

    Route::get('/pizzas/{pizza}/edit', [
        AdminController::class,
        'pizzaEdit'
    ])->name('pizzas.edit');

    Route::put('/pizzas/{pizza}', [
        AdminController::class,
        'pizzaUpdate'
    ])->name('pizzas.update');

    Route::delete('/pizzas/{pizza}', [
        AdminController::class,
        'pizzaDestroy'
    ])->name('pizzas.destroy');


    /*
    |--------------------------------------------------------------------------
    | ORDER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [
        AdminController::class,
        'orders'
    ])->name('orders');

    Route::get('/orders/{order}', [
        AdminController::class,
        'orderShow'
    ])->name('orders.show');

    Route::put('/orders/{order}/status', [
        AdminController::class,
        'updateOrderStatus'
    ])->name('orders.status');


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/customers', [
        AdminController::class,
        'customers'
    ])->name('customers');


    /*
    |--------------------------------------------------------------------------
    | PAYMENT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/payments', [
        AdminController::class,
        'payments'
    ])->name('payments');

    Route::put('/payments/{payment}/status', [
        AdminController::class,
        'updatePaymentStatus'
    ])->name('payments.status');


    /*
    |--------------------------------------------------------------------------
    | DELIVERY MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/deliveries', [
        AdminController::class,
        'deliveries'
    ])->name('deliveries');


    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', [
        AdminController::class,
        'reports'
    ])->name('reports');


    /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/admins', [
        AdminController::class,
        'admins'
    ])->name('admins');

    Route::get('/admins/create', [
        AdminController::class,
        'adminCreate'
    ])->name('admins.create');

    Route::post('/admins', [
        AdminController::class,
        'adminStore'
    ])->name('admins.store');

});


/*
|--------------------------------------------------------------------------
| STORAGE
|--------------------------------------------------------------------------
*/

Route::get('/storage/{path}', function ($path) {

    $file = storage_path(
        'app/public/' . $path
    );

    if (!file_exists($file)) {
        abort(404);
    }

    return response()->file($file);

})->where('path', '.*');


/*
|--------------------------------------------------------------------------
| HEALTH CHECK
|--------------------------------------------------------------------------
*/

Route::get('/up', function () {
    return response()->json([
        'status' => 'ok'
    ]);
});