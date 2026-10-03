<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total +=
                $item['price'] *
                $item['quantity'];
        }

        $deliveryOption = session(
            'delivery_option',
            'delivery'
        );

        $paymentMethod = session(
            'payment_method',
            'cash_on_delivery'
        );

        $deliveryFee = $deliveryOption === 'delivery'
            ? 50.00
            : 0.00;

        $grandTotal = $total + $deliveryFee;

        return view(
            'cart',
            compact(
                'cart',
                'total',
                'deliveryOption',
                'paymentMethod',
                'deliveryFee',
                'grandTotal'
            )
        );
    }

    public function add(Pizza $pizza)
    {
        if (!$pizza->status) {
            return back()->with(
                'error',
                $pizza->name .
                ' is currently unavailable.'
            );
        }

        if ($pizza->stock <= 0) {
            return back()->with(
                'error',
                $pizza->name .
                ' is out of stock.'
            );
        }

        $cart = session()->get(
            'cart',
            []
        );

        $currentQuantity = isset(
            $cart[$pizza->id]
        )
            ? $cart[$pizza->id]['quantity']
            : 0;

        if (
            $currentQuantity + 1 >
            $pizza->stock
        ) {
            return back()->with(
                'error',
                'You can only add up to ' .
                $pizza->stock .
                ' ' .
                $pizza->name .
                ' to your cart.'
            );
        }

        if (isset($cart[$pizza->id])) {

            $cart[$pizza->id]['quantity']++;

        } else {

            $cart[$pizza->id] = [
                'id' =>
                    $pizza->id,

                'name' =>
                    $pizza->name,

                'price' =>
                    (float) $pizza->price,

                'image' =>
                    $pizza->image,

                'quantity' =>
                    1,
            ];
        }

        session()->put(
            'cart',
            $cart
        );

        return redirect()
            ->route('cart')
            ->with(
                'success',
                $pizza->name .
                ' has been added to your cart!'
            );
    }

    public function update(
        Request $request,
        Pizza $pizza
    ) {
        $cart = session()->get(
            'cart',
            []
        );

        $quantity = (int)
            $request->quantity;

        if ($quantity < 1) {
            $quantity = 1;
        }

        if (
            $quantity >
            $pizza->stock
        ) {
            return back()->with(
                'error',
                'Only ' .
                $pizza->stock .
                ' ' .
                $pizza->name .
                ' available.'
            );
        }

        if (
            isset($cart[$pizza->id])
        ) {
            $cart[$pizza->id]['quantity']
                = $quantity;
        }

        session()->put(
            'cart',
            $cart
        );

        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Cart updated successfully!'
            );
    }

    public function remove(
        Pizza $pizza
    ) {
        $cart = session()->get(
            'cart',
            []
        );

        if (
            isset($cart[$pizza->id])
        ) {
            unset(
                $cart[$pizza->id]
            );
        }

        session()->put(
            'cart',
            $cart
        );

        return redirect()
            ->route('cart')
            ->with(
                'success',
                $pizza->name .
                ' has been removed from your cart.'
            );
    }

    public function clear()
    {
        session()->forget(
            'cart'
        );

        session()->forget(
            'delivery_option'
        );

        session()->forget(
            'payment_method'
        );

        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Your cart has been cleared.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE DELIVERY AND PAYMENT OPTION
    |--------------------------------------------------------------------------
    */

    public function saveOptions(
        Request $request
    ) {
        $request->validate([
            'delivery_option' => [
                'required',
                'in:delivery,pickup',
            ],

            'payment_method' => [
                'required',
                'in:cash_on_delivery,cash_on_pickup,gcash',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | DELIVERY
        |--------------------------------------------------------------------------
        */

        if (
            $request->delivery_option ===
            'delivery'
        ) {

            if (
                !in_array(
                    $request->payment_method,
                    [
                        'cash_on_delivery',
                        'gcash',
                    ]
                )
            ) {
                return back()->with(
                    'error',
                    'Please select a valid payment method for delivery.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PICKUP
        |--------------------------------------------------------------------------
        */

        if (
            $request->delivery_option ===
            'pickup'
        ) {

            if (
                !in_array(
                    $request->payment_method,
                    [
                        'cash_on_pickup',
                        'gcash',
                    ]
                )
            ) {
                return back()->with(
                    'error',
                    'Please select a valid payment method for pickup.'
                );
            }
        }

        session()->put(
            'delivery_option',
            $request->delivery_option
        );

        session()->put(
            'payment_method',
            $request->payment_method
        );

        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Delivery and payment options saved!'
            );
    }
}