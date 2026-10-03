<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $salesStatuses = [
            'confirmed',
            'preparing',
            'ready_for_delivery',
            'out_for_delivery',
            'delivered',
        ];

        $totalOrders = Order::count();

        $totalSales = Order::whereIn(
            'status',
            $salesStatuses
        )->sum('total_amount');

        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        $confirmedOrders = Order::where(
            'status',
            'confirmed'
        )->count();

        $preparingOrders = Order::where(
            'status',
            'preparing'
        )->count();

        $readyForDeliveryOrders = Order::where(
            'status',
            'ready_for_delivery'
        )->count();

        $outForDeliveryOrders = Order::where(
            'status',
            'out_for_delivery'
        )->count();

        $deliveredOrders = Order::where(
            'status',
            'delivered'
        )->count();

        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        $totalPizzas = Pizza::count();

        $pendingFeedback = Feedback::where(
            'status',
            'pending'
        )->count();

        $totalFeedback = Feedback::count();

        $recentOrders = Order::with([
            'user',
        ])
        ->latest()
        ->take(10)
        ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalOrders',
                'totalSales',
                'pendingOrders',
                'confirmedOrders',
                'preparingOrders',
                'readyForDeliveryOrders',
                'outForDeliveryOrders',
                'deliveredOrders',
                'cancelledOrders',
                'totalCustomers',
                'totalPizzas',
                'pendingFeedback',
                'totalFeedback',
                'recentOrders'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PIZZAS
    |--------------------------------------------------------------------------
    */

    public function pizzas()
    {
        $pizzas = Pizza::with('category')
            ->latest()
            ->get();

        return view(
            'admin.pizzas.index',
            compact('pizzas')
        );
    }

    public function createPizza()
    {
        $categories = Category::where(
            'status',
            true
        )
        ->orderBy('name')
        ->get();

        return view(
            'admin.pizzas.create',
            compact('categories')
        );
    }

    public function storePizza(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
            ],
        ]);

        $validated['status'] =
            $request->has('status');

        Pizza::create($validated);

        return redirect()
            ->route('admin.pizzas')
            ->with(
                'success',
                'Pizza added successfully!'
            );
    }

    public function editPizza(Pizza $pizza)
    {
        $categories = Category::where(
            'status',
            true
        )
        ->orderBy('name')
        ->get();

        return view(
            'admin.pizzas.edit',
            compact(
                'pizza',
                'categories'
            )
        );
    }

    public function updatePizza(
        Request $request,
        Pizza $pizza
    ) {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
            ],
        ]);

        $validated['status'] =
            $request->has('status');

        $pizza->update($validated);

        return redirect()
            ->route('admin.pizzas')
            ->with(
                'success',
                'Pizza updated successfully!'
            );
    }

    public function destroyPizza(Pizza $pizza)
    {
        $pizza->delete();

        return redirect()
            ->route('admin.pizzas')
            ->with(
                'success',
                'Pizza deleted successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        $orders = Order::with([
            'user',
            'orderItems.pizza',
            'payment',
            'delivery',
        ])
        ->latest()
        ->get();

        return view(
            'admin.orders',
            compact('orders')
        );
    }

    public function orderShow(Order $order)
    {
        $order->load([
            'user',
            'orderItems.pizza',
            'payment',
            'delivery',
        ]);

        return view(
            'admin.order-show',
            compact('order')
        );
    }

    public function updateOrderStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,preparing,ready_for_delivery,out_for_delivery,delivered,cancelled',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Order status updated successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */

    public function customers()
    {
        $customers = User::where(
            'role',
            'customer'
        )
        ->withCount('orders')
        ->latest()
        ->get();

        return view(
            'admin.customers',
            compact('customers')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        $payments = Payment::with([
            'order.user',
        ])
        ->latest()
        ->get();

        return view(
            'admin.payments',
            compact('payments')
        );
    }

    public function updatePaymentStatus(
        Request $request,
        Payment $payment
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,paid,failed',
            ],
        ]);

        $payment->update([
            'status' => $validated['status'],

            'paid_at' =>
                $validated['status'] === 'paid'
                    ? now()
                    : null,
        ]);

        return back()->with(
            'success',
            'Payment status updated successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELIVERIES
    |--------------------------------------------------------------------------
    */

    public function deliveries()
    {
        $deliveries = Delivery::with([
            'order.user',
        ])
        ->latest()
        ->get();

        return view(
            'admin.deliveries',
            compact('deliveries')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

    public function reports()
    {
        $salesStatuses = [
            'confirmed',
            'preparing',
            'ready_for_delivery',
            'out_for_delivery',
            'delivered',
        ];

        /*
        |--------------------------------------------------------------------------
        | ORDER REPORTS
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::count();

        $totalSales = Order::whereIn(
            'status',
            $salesStatuses
        )->sum('total_amount');

        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        $deliveredOrders = Order::where(
            'status',
            'delivered'
        )->count();

        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER / PIZZA REPORTS
        |--------------------------------------------------------------------------
        */

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        $totalPizzas = Pizza::count();


        /*
        |--------------------------------------------------------------------------
        | PAYMENT REPORTS
        |--------------------------------------------------------------------------
        */

        $cashSales = Order::whereIn(
            'status',
            $salesStatuses
        )
        ->whereIn(
            'payment_method',
            [
                'cash_on_delivery',
                'cash_on_pickup',
            ]
        )
        ->sum('total_amount');

        $gcashSales = Order::whereIn(
            'status',
            $salesStatuses
        )
        ->where(
            'payment_method',
            'gcash'
        )
        ->sum('total_amount');


        /*
        |--------------------------------------------------------------------------
        | DELIVERY / PICKUP REPORTS
        |--------------------------------------------------------------------------
        */

        $deliverySales = Order::whereIn(
            'status',
            $salesStatuses
        )
        ->where(
            'delivery_option',
            'delivery'
        )
        ->sum('total_amount');

        $pickupSales = Order::whereIn(
            'status',
            $salesStatuses
        )
        ->where(
            'delivery_option',
            'pickup'
        )
        ->sum('total_amount');


        /*
        |--------------------------------------------------------------------------
        | RETURN REPORT VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.reports',
            compact(
                'totalOrders',
                'totalSales',
                'pendingOrders',
                'deliveredOrders',
                'cancelledOrders',
                'totalCustomers',
                'totalPizzas',
                'cashSales',
                'gcashSales',
                'deliverySales',
                'pickupSales'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT
    |--------------------------------------------------------------------------
    */

    public function admins()
    {
        $admins = User::whereIn(
            'role',
            [
                'admin',
                'super_admin',
            ]
        )
        ->latest()
        ->get();

        return view(
            'admin.admins',
            compact('admins')
        );
    }

    public function createAdmin()
    {
        return view(
            'admin.admin-create'
        );
    }

    public function storeAdmin(
        Request $request
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,super_admin',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.admins')
            ->with(
                'success',
                'Admin account created successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FEEDBACK
    |--------------------------------------------------------------------------
    */

    public function feedback()
    {
        $feedbacks = Feedback::with([
            'user',
            'order',
        ])
        ->latest()
        ->get();

        return view(
            'admin.feedback',
            compact('feedbacks')
        );
    }

    public function feedbackShow($id)
    {
        $feedback = Feedback::with([
            'user',
            'order',
        ])
        ->findOrFail($id);

        return view(
            'admin.feedback-show',
            compact('feedback')
        );
    }

    public function feedbackApprove($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.feedback')
            ->with(
                'success',
                'Feedback approved successfully!'
            );
    }

    public function feedbackReject($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.feedback')
            ->with(
                'success',
                'Feedback rejected successfully!'
            );
    }

    public function feedbackReply(
        Request $request,
        $id
    ) {
        $validated = $request->validate([
            'admin_reply' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'admin_reply' =>
                $validated['admin_reply'],
        ]);

        return redirect()
            ->route(
                'admin.feedback.show',
                $feedback->id
            )
            ->with(
                'success',
                'Admin reply saved successfully!'
            );
    }
}