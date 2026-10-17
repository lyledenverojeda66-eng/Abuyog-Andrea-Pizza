<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', true)
    ->orderByDesc('id')
    ->get();

        $pizzas = Pizza::latest()->get();

        $feedbacks = Feedback::with('user')
            ->where('status', 'approved')
            ->where('type', 'feedback')
            ->whereNotNull('rating')
            ->latest()
            ->get();

        $deliveredOrders = collect();

        if (Auth::check()) {
            $deliveredOrders = Order::where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereDoesntHave('feedback', function ($query) {
                    $query->where('type', 'feedback');
                })
                ->latest()
                ->get();
        }

        return view('home', compact(
            'banners',
            'pizzas',
            'feedbacks',
            'deliveredOrders'
        ));
    }

    public function menu()
    {
        $pizzas = Pizza::latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('menu', compact('pizzas', 'categories'));
    }

    public function contact()
    {
        return view('contact');
    }
}
