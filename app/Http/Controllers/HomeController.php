<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Pizza;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $pizzas = Pizza::latest()->get();

        // Get all approved customer feedback for the rating summary.
        $feedbacks = Feedback::with('user')
            ->where('status', 'approved')
            ->where('type', 'feedback')
            ->whereNotNull('rating')
            ->latest()
            ->get();

        return view('home', compact(
            'banners',
            'pizzas',
            'feedbacks'
        ));
    }

    public function menu()
    {
        $pizzas = Pizza::latest()->get();

        $categories = Category::orderBy('name')->get();

        return view('menu', compact(
            'pizzas',
            'categories'
        ));
    }

    public function contact()
    {
        return view('contact');
    }
}