<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with([
                'orderItems.pizza',
                'payment',
                'delivery',
            ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'customer.dashboard',
            compact(
                'user',
                'orders'
            )
        );
    }


    public function orders()
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with([
                'orderItems.pizza',
                'payment',
                'delivery',
            ])
            ->latest()
            ->get();

        return view(
            'customer.orders',
            compact('orders')
        );
    }


    public function tracking($orderId)
    {
        $user = Auth::user();

        $order = $user->orders()
            ->with([
                'orderItems.pizza',
                'payment',
                'delivery',
            ])
            ->findOrFail($orderId);

        return view(
            'customer.tracking',
            compact('order')
        );
    }


    public function confirmation($orderId)
    {
        $user = Auth::user();

        $order = $user->orders()
            ->with([
                'orderItems.pizza',
                'payment',
                'delivery',
            ])
            ->findOrFail($orderId);

        return view(
            'order-confirmation',
            compact('order')
        );
    }
}