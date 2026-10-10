
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GcashController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| HOME - PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu', [HomeController::class, 'menu'])->name('menu');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| PUBLIC CUSTOMER CHATBOT
|--------------------------------------------------------------------------
| Public menu and customer-safe chatbot responses only.
| Never return admin reports or private customer/order information here.
*/

Route::post('/chatbot/message', [ChatbotController::class, 'chat'])
    ->middleware('throttle:20,1')
    ->name('chatbot.message');

Route::get('/chatbot/menu', [ChatbotController::class, 'menu'])
    ->middleware('throttle:60,1')
    ->name('chatbot.menu');

Route::post('/chatbot/track-order', [ChatbotController::class, 'trackOrder'])
    ->middleware(['auth', 'throttle:20,1'])
    ->name('chatbot.track-order');

/*
|--------------------------------------------------------------------------
| PUBLIC CUSTOMER REVIEWS
|--------------------------------------------------------------------------
*/

Route::get('/reviews', [FeedbackController::class, 'index'])
    ->name('reviews.index');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:10,1')
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('register.submit');

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
| Requires authentication.
*/

Route::middleware('auth')->group(function () {

    // CUSTOMER PROFILE

    Route::get('/profile', [CustomerProfileController::class, 'edit'])
        ->name('customer.profile');

    Route::put('/profile', [CustomerProfileController::class, 'update'])
        ->name('customer.profile.update');

    // CUSTOMER DASHBOARD

    Route::get('/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');

    // CART

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart');

    Route::post('/cart/add/{pizza}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/{pizza}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{pizza}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::delete('/cart', [CartController::class, 'clear'])
        ->name('cart.clear');

    // CART OPTIONS

    Route::post('/cart/options', [CartController::class, 'options'])
        ->name('cart.options');

    // CHECKOUT

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // CUSTOMER ORDERS

    Route::get('/orders', [CustomerController::class, 'orders'])
        ->name('orders');

    Route::get('/orders/{orderId}/tracking', [CustomerController::class, 'tracking'])
        ->name('orders.tracking');

    Route::get('/orders/{orderId}/confirmation', [CustomerController::class, 'confirmation'])
        ->name('customer.orders.confirmation');

    // GCASH

    Route::get('/gcash/{order}', [GcashController::class, 'show'])
        ->name('customer.gcash');

    Route::post('/gcash/{order}/pay', [GcashController::class, 'pay'])
        ->name('gcash.pay');

    Route::get('/gcash/{order}/success', [GcashController::class, 'success'])
        ->name('gcash.success');

    // CUSTOMER FEEDBACK

    Route::post('/feedback', [FeedbackController::class, 'storeGeneral'])
        ->name('customer.feedback.general');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| All routes in this group require authentication and admin middleware.
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // ADMIN CHATBOT

        Route::post('/chatbot/message', [ChatbotController::class, 'adminChat'])
            ->middleware('throttle:20,1')
            ->name('admin.chatbot.message');

        // DASHBOARD

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // ADMIN PROFILE

        Route::get('/profile', [AdminController::class, 'profile'])
            ->name('admin.profile');

        Route::put('/profile', [AdminController::class, 'updateProfile'])
            ->name('admin.profile.update');

        // PIZZAS

        Route::get('/pizzas', [AdminController::class, 'pizzas'])
            ->name('admin.pizzas');

        Route::get('/pizzas/create', [AdminController::class, 'createPizza'])
            ->name('admin.pizzas.create');

        Route::post('/pizzas', [AdminController::class, 'storePizza'])
            ->name('admin.pizzas.store');

        Route::get('/pizzas/{pizza}/edit', [AdminController::class, 'editPizza'])
            ->name('admin.pizzas.edit');

        Route::put('/pizzas/{pizza}', [AdminController::class, 'updatePizza'])
            ->name('admin.pizzas.update');

        Route::delete('/pizzas/{pizza}', [AdminController::class, 'destroyPizza'])
            ->name('admin.pizzas.destroy');

        // ORDERS

        Route::get('/orders', [AdminController::class, 'orders'])
            ->name('admin.orders');

        Route::get('/orders/{order}', [AdminController::class, 'orderShow'])
            ->name('admin.orders.show');

        // PRINT RECEIPT

        Route::get('/orders/{order}/receipt', [AdminController::class, 'orderReceipt'])
            ->name('admin.orders.receipt');

        // UPDATE ORDER STATUS

        Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])
            ->name('admin.orders.status');

        // APPROVE PAYMENT

        Route::put('/orders/{order}/approve-payment', [AdminController::class, 'approvePayment'])
            ->name('admin.orders.approve-payment');

        // CUSTOMERS

        Route::get('/customers', [AdminController::class, 'customers'])
            ->name('admin.customers');

        // PAYMENTS

        Route::get('/payments', [AdminController::class, 'payments'])
            ->name('admin.payments');

        Route::put('/payments/{payment}/status', [AdminController::class, 'updatePaymentStatus'])
            ->name('admin.payments.status');

        // DELIVERIES

        Route::get('/deliveries', [AdminController::class, 'deliveries'])
            ->name('admin.deliveries');

        Route::put('/deliveries/{delivery}/rider', [AdminController::class, 'assignRider'])
            ->name('admin.deliveries.assign-rider');

        Route::put('/deliveries/{delivery}/status', [AdminController::class, 'updateDeliveryStatus'])
            ->name('admin.deliveries.update-status');

        Route::put('/deliveries/{delivery}/payment', [AdminController::class, 'updateDeliveryPayment'])
            ->name('admin.deliveries.update-payment');

        // REPORTS

        Route::get('/reports', [AdminController::class, 'reports'])
            ->name('admin.reports');

        // ADMIN MANAGEMENT

        Route::get('/admins', [AdminController::class, 'admins'])
            ->name('admin.admins');

        Route::get('/admins/create', [AdminController::class, 'createAdmin'])
            ->name('admin.admins.create');

        Route::post('/admins', [AdminController::class, 'storeAdmin'])
            ->name('admin.admins.store');

        // FEEDBACK MANAGEMENT

        Route::get('/feedback', [AdminController::class, 'feedback'])
            ->name('admin.feedback');

        Route::get('/feedback/{id}', [AdminController::class, 'feedbackShow'])
            ->name('admin.feedback.show');

        Route::put('/feedback/{id}/approve', [AdminController::class, 'feedbackApprove'])
            ->name('admin.feedback.approve');

        Route::put('/feedback/{id}/reject', [AdminController::class, 'feedbackReject'])
            ->name('admin.feedback.reject');

        Route::put('/feedback/{id}/reply', [AdminController::class, 'feedbackReply'])
            ->name('admin.feedback.reply');

        // BANNERS

        Route::get('/banners', [BannerController::class, 'index'])
            ->name('admin.banners.index');

        Route::get('/banners/create', [BannerController::class, 'create'])
            ->name('admin.banners.create');

        Route::post('/banners', [BannerController::class, 'store'])
            ->name('admin.banners.store');

        Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])
            ->name('admin.banners.edit');

        Route::put('/banners/{banner}', [BannerController::class, 'update'])
            ->name('admin.banners.update');

        Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])
            ->name('admin.banners.destroy');

        // ACTIVATE / DEACTIVATE BANNER

        Route::match(
            ['post', 'patch'],
            '/banners/{banner}/toggle',
            [BannerController::class, 'toggle']
        )->name('admin.banners.toggle');
    });

/*
|--------------------------------------------------------------------------
| RIDER ROUTES
|--------------------------------------------------------------------------
| Only authenticated riders can access these routes.
*/

Route::middleware(['auth', 'rider'])
    ->prefix('rider')
    ->name('rider.')
    ->group(function () {

        // RIDER DASHBOARD

        Route::get('/dashboard', [RiderController::class, 'dashboard'])
            ->name('dashboard');

        // CONFIRM COD PAYMENT

        Route::put(
            '/deliveries/{delivery}/confirm-payment',
            [RiderController::class, 'confirmPayment']
        )->name('deliveries.confirm-payment');

        // UPDATE DELIVERY STATUS

        Route::put(
            '/deliveries/{delivery}/status',
            [RiderController::class, 'updateStatus']
        )->name('deliveries.update-status');
    });
