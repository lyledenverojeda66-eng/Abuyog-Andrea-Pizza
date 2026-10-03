<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GcashController extends Controller
{
    /**
     * Show GCash / MariBank payment page.
     */
    public function show(Order $order)
    {
        // Make sure the order belongs to the logged-in customer.
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Load payment and order items.
        $order->load([
            'orderItems.pizza',
            'payment',
        ]);

        return view(
            'gcash.payment',
            compact('order')
        );
    }

    /**
     * Submit payment reference number.
     */
    public function pay(Request $request, Order $order)
    {
        // Make sure the order belongs to the logged-in customer.
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate reference number.
        $request->validate([
            'reference_number' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        // Find payment record.
        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'Payment record was not found.'
            );
        }

        // Save reference number.
        // Keep status as pending because admin still needs
        // to verify the payment.
        $payment->update([
            'reference_number' => $request->reference_number,
            'status' => 'pending',
        ]);

        return redirect()
            ->route(
                'gcash.success',
                $order
            )
            ->with(
                'success',
                'Your payment reference has been submitted successfully.'
            );
    }

    /**
     * Show payment submitted page.
     */
    public function success(Order $order)
    {
        // Make sure the order belongs to the logged-in customer.
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load([
            'orderItems.pizza',
            'payment',
        ]);

        return view(
            'gcash.success',
            compact('order')
        );
    }
}