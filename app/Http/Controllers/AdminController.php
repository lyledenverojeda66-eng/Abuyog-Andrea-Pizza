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
use Illuminate\Support\Facades\DB;

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

        $totalSales = Order::whereIn('status', $salesStatuses)
            ->sum('total_amount');

        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();

        $readyForDeliveryOrders = Order::where(
            'status',
            'ready_for_delivery'
        )->count();

        $outForDeliveryOrders = Order::where(
            'status',
            'out_for_delivery'
        )->count();

        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalCustomers = User::where('role', 'customer')->count();
        $totalPizzas = Pizza::count();

        $pendingFeedback = Feedback::where('status', 'pending')->count();
        $totalFeedback = Feedback::count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
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
        ));
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

        return view('admin.pizzas.index', compact('pizzas'));
    }

    public function createPizza()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.pizzas.create', compact('categories'));
    }

    public function storePizza(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable'],
        ]);

        $validated['status'] = $request->has('status');

        Pizza::create($validated);

        return redirect()
            ->route('admin.pizzas')
            ->with('success', 'Pizza added successfully!');
    }

    public function editPizza(Pizza $pizza)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.pizzas.edit',
            compact('pizza', 'categories')
        );
    }

    public function updatePizza(Request $request, Pizza $pizza)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable'],
        ]);

        $validated['status'] = $request->has('status');

        $pizza->update($validated);

        return redirect()
            ->route('admin.pizzas')
            ->with('success', 'Pizza updated successfully!');
    }

    public function destroyPizza(Pizza $pizza)
    {
        $pizza->delete();

        return redirect()
            ->route('admin.pizzas')
            ->with('success', 'Pizza deleted successfully!');
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

        return view('admin.orders', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        $order->load([
            'user',
            'orderItems.pizza',
            'payment',
            'delivery',
        ]);

        return view('admin.order-show', compact('order'));
    }

    /**
     * Update order status and create a delivery record
     * when a delivery order becomes confirmed.
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,preparing,ready_for_delivery,out_for_delivery,delivered,cancelled',
            ],
        ]);

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'status' => $validated['status'],
            ]);

            // Use delivery_option, the column referenced by Reports.
            if (
                $validated['status'] === 'confirmed'
                && $order->delivery_option === 'delivery'
            ) {
                Delivery::firstOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status' => 'pending',
                        'payment_status' => 'pending',
                    ]
                );
            }
        });

        return back()->with(
            'success',
            'Order status updated successfully!'
        );
    }

    public function approvePayment(Order $order)
    {
        if ($order->status !== 'ready_for_delivery') {
            return back()->with(
                'error',
                'Payment can only be approved when the order is Ready for Delivery.'
            );
        }

        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'No payment record found for this order.'
            );
        }

        if ($payment->status === 'paid') {
            return back()->with(
                'success',
                'Payment is already approved.'
            );
        }

        if ($payment->status === 'failed') {
            return back()->with(
                'error',
                'Failed payments cannot be approved.'
            );
        }

        $paymentMethod = strtolower(trim(
            $payment->method ?? $order->payment_method ?? ''
        ));

        if ($paymentMethod !== 'gcash') {
            return back()->with(
                'error',
                'This approval action is for GCash payments only.'
            );
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => $payment->paid_at ?? now(),
        ]);

        return back()->with(
            'success',
            'GCash payment approved successfully!'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */

    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->latest()
            ->get();

        return view('admin.customers', compact('customers'));
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        $payments = Payment::with('order.user')
            ->latest()
            ->get();

        return view('admin.payments', compact('payments'));
    }

    public function updatePaymentStatus(
        Request $request,
        Payment $payment
    ) {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,failed'],
        ]);

        $payment->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'paid'
                ? ($payment->paid_at ?? now())
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
        'order.payment',
        'rider',
    ])
        ->latest()
        ->get();

    $riders = User::where('role', 'rider')
        ->orderBy('name')
        ->get(['id', 'name', 'email']);

    return view('admin.deliveries', compact(
        'deliveries',
        'riders'
    ));
}

public function assignRider(Request $request, Delivery $delivery)
{
    $validated = $request->validate([
        'rider_id' => [
            'required',
            'integer',
            'exists:users,id',
        ],
    ]);

    // Siguraduhing rider account ang pinili.
    $rider = User::where('role', 'rider')
        ->findOrFail($validated['rider_id']);

    $delivery->update([
        'rider_id' => $rider->id,
        'rider_name' => $rider->name,
        'rider_contact' => $rider->email,
    ]);

    return redirect()
        ->route('admin.deliveries')
        ->with('success', 'Rider assigned successfully!');
}

public function updateDeliveryStatus(
    Request $request,
    Delivery $delivery
) {
    $validated = $request->validate([
        'status' => [
            'required',
            'in:pending,preparing,ready_for_pickup,picked_up,out_for_delivery,delivered',
        ],
    ]);

    $status = $validated['status'];

    DB::transaction(function () use ($delivery, $status) {
        $delivery->status = $status;

        if (
            in_array($status, ['picked_up', 'out_for_delivery'], true)
            && !$delivery->picked_up_at
        ) {
            $delivery->picked_up_at = now();
        }

        if ($status === 'delivered' && !$delivery->delivered_at) {
            $delivery->delivered_at = now();
        }

        $delivery->save();

        $orderStatus = [
            'preparing' => 'preparing',
            'ready_for_pickup' => 'ready_for_delivery',
            'picked_up' => 'out_for_delivery',
            'out_for_delivery' => 'out_for_delivery',
            'delivered' => 'delivered',
        ][$status] ?? null;

        if ($orderStatus && $delivery->order) {
            $delivery->order->update([
                'status' => $orderStatus,
            ]);
        }
    });

    return redirect()
        ->route('admin.deliveries')
        ->with('success', 'Delivery status updated successfully!');
}

public function updateDeliveryPayment(
    Request $request,
    Delivery $delivery
) {
    $validated = $request->validate([
        'payment_status' => [
            'required',
            'in:pending,paid,failed',
        ],
    ]);

    $order = $delivery->order;

    if (!$order) {
        return redirect()
            ->route('admin.deliveries')
            ->with('error', 'The delivery has no linked order.');
    }

    $payment = $order->payment;

    if (!$payment) {
        return redirect()
            ->route('admin.deliveries')
            ->with('error', 'No payment record exists for this order.');
    }

    $status = $validated['payment_status'];

    DB::transaction(function () use (
        $payment,
        $delivery,
        $status
    ) {
        $payment->update([
            'status' => $status,
            'paid_at' => $status === 'paid'
                ? ($payment->paid_at ?? now())
                : null,
        ]);

        $delivery->update([
            'payment_status' => $status,
            'payment_received_at' => $status === 'paid'
                ? ($delivery->payment_received_at ?? now())
                : null,
        ]);
    });

    return redirect()
        ->route('admin.deliveries')
        ->with(
            'success',
            'Delivery payment status updated successfully!'
        );
}
    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

    public function reports(Request $request)
    {
        $period = $request->query('period', 'daily');

        if (!in_array($period, [
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'manual',
        ], true)) {
            $period = 'daily';
        }

        $reportPeriodText = match ($period) {
            'daily' => 'Daily Report',
            'weekly' => 'Weekly Report',
            'monthly' => 'Monthly Report',
            'yearly' => 'Yearly Report',
            'manual' => 'Custom Date Range Report',
            default => 'Daily Report',
        };

        $salesStatuses = [
            'confirmed',
            'preparing',
            'ready_for_delivery',
            'out_for_delivery',
            'delivered',
        ];

        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        switch ($period) {
            case 'daily':
                $selectedDate = $request->query(
                    'date',
                    now()->toDateString()
                );

                try {
                    $startDate = \Carbon\Carbon::parse(
                        $selectedDate
                    )->startOfDay();
                } catch (\Throwable $e) {
                    $startDate = now()->startOfDay();
                }

                $endDate = $startDate->copy()->endOfDay();
                break;

            case 'weekly':
                $selectedWeek = $request->query(
                    'week',
                    now()->startOfWeek()->toDateString()
                );

                try {
                    $startDate = \Carbon\Carbon::parse(
                        $selectedWeek
                    )->startOfWeek();
                } catch (\Throwable $e) {
                    $startDate = now()->startOfWeek();
                }

                $endDate = $startDate->copy()->endOfWeek();
                break;

            case 'monthly':
                $selectedMonth = $request->query(
                    'month',
                    now()->format('Y-m')
                );

                try {
                    $startDate = \Carbon\Carbon::createFromFormat(
                        '!Y-m',
                        $selectedMonth
                    )->startOfMonth();
                } catch (\Throwable $e) {
                    $startDate = now()->startOfMonth();
                }

                $endDate = $startDate->copy()->endOfMonth();
                break;

            case 'yearly':
                $selectedYear = $request->query(
                    'year',
                    now()->year
                );

                if (
                    !is_numeric($selectedYear)
                    || (int) $selectedYear < 2000
                    || (int) $selectedYear > 2100
                ) {
                    $selectedYear = now()->year;
                }

                $startDate = \Carbon\Carbon::create(
                    (int) $selectedYear,
                    1,
                    1
                )->startOfDay();

                $endDate = $startDate->copy()->endOfYear();
                break;

            case 'manual':
                try {
                    $startDate = \Carbon\Carbon::parse(
                        $request->query(
                            'start_date',
                            now()->startOfMonth()->toDateString()
                        )
                    )->startOfDay();
                } catch (\Throwable $e) {
                    $startDate = now()->startOfMonth();
                }

                try {
                    $endDate = \Carbon\Carbon::parse(
                        $request->query(
                            'end_date',
                            now()->toDateString()
                        )
                    )->endOfDay();
                } catch (\Throwable $e) {
                    $endDate = now()->endOfDay();
                }

                if ($startDate->gt($endDate)) {
                    [$startDate, $endDate] = [
                        $endDate->copy()->startOfDay(),
                        $startDate->copy()->endOfDay(),
                    ];
                }
                break;
        }

        $periodOrders = Order::whereBetween('created_at', [
            $startDate,
            $endDate,
        ]);

        $totalOrders = (clone $periodOrders)->count();

        $totalSales = (clone $periodOrders)
            ->whereIn('status', $salesStatuses)
            ->sum('total_amount');

        $averageSale = $totalOrders > 0
            ? $totalSales / $totalOrders
            : 0;

        $pendingOrders = (clone $periodOrders)
            ->where('status', 'pending')
            ->count();

        $deliveredOrders = (clone $periodOrders)
            ->where('status', 'delivered')
            ->count();

        $cancelledOrders = (clone $periodOrders)
            ->where('status', 'cancelled')
            ->count();

        $totalCustomers = User::where('role', 'customer')->count();
        $totalPizzas = Pizza::count();

        $cashSales = (clone $periodOrders)
            ->whereIn('status', $salesStatuses)
            ->whereIn('payment_method', [
                'cash_on_delivery',
                'cash_on_pickup',
            ])
            ->sum('total_amount');

        $gcashSales = (clone $periodOrders)
            ->whereIn('status', $salesStatuses)
            ->where('payment_method', 'gcash')
            ->sum('total_amount');

        $deliverySales = (clone $periodOrders)
            ->whereIn('status', $salesStatuses)
            ->where('delivery_option', 'delivery')
            ->sum('total_amount');

        $pickupSales = (clone $periodOrders)
            ->whereIn('status', $salesStatuses)
            ->where('delivery_option', 'pickup')
            ->sum('total_amount');

        $transactions = (clone $periodOrders)
            ->with(['user', 'payment', 'delivery'])
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SALES AND ORDERS TREND CHART
        |--------------------------------------------------------------------------
        */

        $chartLabels = [];
        $chartSales = [];
        $chartOrders = [];

        $chartStart = $startDate->copy()->startOfDay();
        $chartEnd = $endDate->copy()->startOfDay();

        $days = min(
            max($chartStart->diffInDays($chartEnd) + 1, 1),
            366
        );

        if ($period === 'daily') {
            $days = 7;
            $chartStart = $endDate->copy()->subDays(6)->startOfDay();
        }

        for ($i = 0; $i < $days; $i++) {
            $date = $chartStart->copy()->addDays($i);

            $chartLabels[] = $date->format('M d');

            $dailyOrders = Order::whereBetween('created_at', [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay(),
            ]);

            $chartSales[] = (float) (clone $dailyOrders)
                ->whereIn('status', $salesStatuses)
                ->sum('total_amount');

            $chartOrders[] = (int) (clone $dailyOrders)->count();
        }

        $chartData = $chartSales;

        /*
        |--------------------------------------------------------------------------
        | ORDER STATUS CHART
        |--------------------------------------------------------------------------
        */

        $statusLabels = [
            'Pending',
            'Confirmed',
            'Preparing',
            'Ready for Delivery',
            'Out for Delivery',
            'Delivered',
            'Cancelled',
        ];

        $statusData = [
            (clone $periodOrders)->where('status', 'pending')->count(),
            (clone $periodOrders)->where('status', 'confirmed')->count(),
            (clone $periodOrders)->where('status', 'preparing')->count(),
            (clone $periodOrders)->where('status', 'ready_for_delivery')->count(),
            (clone $periodOrders)->where('status', 'out_for_delivery')->count(),
            (clone $periodOrders)->where('status', 'delivered')->count(),
            (clone $periodOrders)->where('status', 'cancelled')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHODS CHART
        |--------------------------------------------------------------------------
        */

        $paymentLabels = ['Cash', 'GCash'];

        $paymentData = [
            (float) $cashSales,
            (float) $gcashSales,
        ];

        /*
        |--------------------------------------------------------------------------
        | DELIVERY VS PICKUP CHART
        |--------------------------------------------------------------------------
        */

        $deliveryLabels = ['Delivery', 'Pickup'];

        $deliveryData = [
            (float) $deliverySales,
            (float) $pickupSales,
        ];

        /*
        |--------------------------------------------------------------------------
        | TOP SELLING PIZZAS CHART
        |--------------------------------------------------------------------------
        */

        $topPizzaLabels = [];
        $topPizzaData = [];

        $topPizzas = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('pizzas', 'pizzas.id', '=', 'order_items.pizza_id')
            ->whereBetween('orders.created_at', [
                $startDate,
                $endDate,
            ])
            ->whereIn('orders.status', $salesStatuses)
            ->select(
                'pizzas.name',
                DB::raw('SUM(order_items.quantity) as quantity_sold')
            )
            ->groupBy('pizzas.id', 'pizzas.name')
            ->orderByDesc('quantity_sold')
            ->limit(5)
            ->get();

        foreach ($topPizzas as $pizza) {
            $topPizzaLabels[] = $pizza->name;
            $topPizzaData[] = (int) $pizza->quantity_sold;
        }

        return view('admin.reports', compact(
            'period',
            'reportPeriodText',
            'totalOrders',
            'totalSales',
            'averageSale',
            'pendingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalCustomers',
            'totalPizzas',
            'cashSales',
            'gcashSales',
            'deliverySales',
            'pickupSales',
            'transactions',
            'chartLabels',
            'chartData',
            'chartSales',
            'chartOrders',
            'statusLabels',
            'statusData',
            'paymentLabels',
            'paymentData',
            'deliveryLabels',
            'deliveryData',
            'topPizzaLabels',
            'topPizzaData'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT
    |--------------------------------------------------------------------------
    */

    public function admins()
    {
        $admins = User::whereIn('role', [
            'admin',
            'super_admin',
        ])
            ->latest()
            ->get();

        return view('admin.admins', compact('admins'));
    }

    public function createAdmin()
    {
        return view('admin.admin-create');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => ['required', 'in:admin,super_admin'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.admins')
            ->with('success', 'Admin account created successfully!');
    }
/*
|--------------------------------------------------------------------------
| ADMIN PROFILE
|--------------------------------------------------------------------------
*/

public function profile()
{
    $admin = auth()->user();

    return view('admin.profile', compact('admin'));
}


public function updateProfile(Request $request)
{
    $admin = auth()->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email,' . $admin->id,
        ],
        'phone' => ['nullable', 'string', 'max:30'],
        'address' => ['nullable', 'string', 'max:500'],
        'profile_picture' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ]);

    // Ihiwalay ang file sa ordinaryong user information.
    $profilePicture = $request->file('profile_picture');

    unset($validated['profile_picture']);

    // I-upload ang bagong profile picture kung mayroon.
    if ($profilePicture) {
        $path = $profilePicture->store(
            'profile-pictures',
            'public'
        );

        // Burahin ang lumang picture pagkatapos ng successful upload.
        if ($admin->profile_picture) {
            Storage::disk('public')->delete(
                $admin->profile_picture
            );
        }

        $validated['profile_picture'] = $path;
    }

    // I-save ang updated information.
    $admin->fill($validated);
    $admin->save();

    return redirect()
        ->route('admin.profile')
        ->with('success', 'Admin profile updated successfully!');
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

        return view('admin.feedback', compact('feedbacks'));
    }

    public function feedbackShow($id)
    {
        $feedback = Feedback::with([
            'user',
            'order',
        ])->findOrFail($id);

        return view('admin.feedback-show', compact('feedback'));
    }

    public function feedbackApprove($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.feedback')
            ->with('success', 'Feedback approved successfully!');
    }

    public function feedbackReject($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.feedback')
            ->with('success', 'Feedback rejected successfully!');
    }

    public function feedbackReply(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_reply' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'admin_reply' => $validated['admin_reply'],
        ]);

        return redirect()
            ->route('admin.feedback.show', $feedback->id)
            ->with('success', 'Admin reply saved successfully!');
    }
}