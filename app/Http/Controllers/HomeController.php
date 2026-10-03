<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\Pizza;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $pizzas = Pizza::where('status', true)
            ->orderBy('id')
            ->get();

        $feedbacks = Feedback::with('user')
            ->where('status', 'approved')
            ->where('type', 'feedback')
            ->whereNotNull('rating')
            ->whereNotNull('message')
            ->latest()
            ->take(6)
            ->get();

        return view(
            'home',
            compact(
                'pizzas',
                'feedbacks'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MENU
    |--------------------------------------------------------------------------
    */
    public function menu()
    {
        $categories = Category::where('status', true)
            ->with([
                'pizzas' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->get();

        return view(
            'menu',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONTACT
    |--------------------------------------------------------------------------
    */
    public function contact()
    {
        $feedbacks = Feedback::with('user')
            ->where('status', 'approved')
            ->whereNotNull('rating')
            ->latest()
            ->take(12)
            ->get();

        return view(
            'contact',
            compact('feedbacks')
        );
    }
}