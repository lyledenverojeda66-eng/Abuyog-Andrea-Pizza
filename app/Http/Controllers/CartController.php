<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        /*
        |--------------------------------------------------------------------------
        | Refresh cart data from database
        |--------------------------------------------------------------------------
        | This fixes old cart session data where image was saved as null.
        */
        foreach ($cart as $pizzaId => &$item) {

            $pizza = Pizza::find($pizzaId);

            if ($pizza) {
                // Always get the latest pizza information from database
                $item['name'] = $pizza->name;
                $item['price'] = (float) $pizza->price;
                $item['image'] = $pizza->image;
            }
        }

        unset($item);

        // Save the refreshed cart back into the session
        session()->put('cart', $cart);

        $total = 0;

        foreach ($cart as $item) {
            $total += (float) $item['price'] * (int) $item['quantity'];
        }

        $deliveryOption = session('delivery_option', 'delivery');
        $paymentMethod = session('payment_method', 'cash_on_delivery');

        $deliveryFee = $deliveryOption === 'delivery' ? 50 : 0;

        $grandTotal = $total + $deliveryFee;

        return view('cart', compact(
            'cart',
            'total',
            'deliveryOption',
            'paymentMethod',
            'deliveryFee',
            'grandTotal'
        ));
    }


    public function add(Request $request, Pizza $pizza)
    {
        if (!$pizza->status) {
            return back()->with(
                'error',
                'This pizza is currently unavailable.'
            );
        }

        if ($pizza->stock <= 0) {
            return back()->with(
                'error',
                $pizza->name . ' is currently out of stock.'
            );
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        if ($quantity > $pizza->stock) {
            return back()->with(
                'error',
                'Only ' . $pizza->stock .
                ' stock is available for ' . $pizza->name . '.'
            );
        }

        $cart = session()->get('cart', []);

        /*
        |--------------------------------------------------------------------------
        | Existing item
        |--------------------------------------------------------------------------
        */
        if (isset($cart[$pizza->id])) {

            $newQuantity =
                (int) $cart[$pizza->id]['quantity'] + $quantity;

            if ($newQuantity > $pizza->stock) {
                return back()->with(
                    'error',
                    'You cannot add more than the available stock.'
                );
            }

            $cart[$pizza->id]['quantity'] = $newQuantity;

            // Refresh latest pizza information
            $cart[$pizza->id]['name'] = $pizza->name;
            $cart[$pizza->id]['price'] = (float) $pizza->price;
            $cart[$pizza->id]['image'] = $pizza->image;

        } else {

            /*
            |--------------------------------------------------------------------------
            | New item
            |--------------------------------------------------------------------------
            */
            $cart[$pizza->id] = [
                'name' => $pizza->name,
                'price' => (float) $pizza->price,
                'quantity' => $quantity,
                'image' => $pizza->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with(
            'success',
            $pizza->name . ' has been added to your cart!'
        );
    }


    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ]
        ]);

        $quantity = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if (!isset($cart[$pizza->id])) {
            return back()->with(
                'error',
                'This pizza is not in your cart.'
            );
        }

        if ($pizza->stock <= 0) {
            return back()->with(
                'error',
                $pizza->name . ' is currently out of stock.'
            );
        }

        if ($quantity > $pizza->stock) {
            return back()->with(
                'error',
                'Only ' . $pizza->stock .
                ' stock is available for ' . $pizza->name . '.'
            );
        }

        $cart[$pizza->id]['quantity'] = $quantity;

        // Refresh latest pizza information
        $cart[$pizza->id]['name'] = $pizza->name;
        $cart[$pizza->id]['price'] = (float) $pizza->price;
        $cart[$pizza->id]['image'] = $pizza->image;

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Cart updated successfully!'
        );
    }


    public function remove(Pizza $pizza)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$pizza->id])) {
            unset($cart[$pizza->id]);
        }

        session()->put('cart', $cart);

        return back()->with(
            'success',
            $pizza->name . ' has been removed from your cart.'
        );
    }


    public function clear()
    {
        session()->forget('cart');

        session()->forget([
            'delivery_option',
            'payment_method'
        ]);

        return redirect()
            ->route('cart')
            ->with(
                'success',
                'Your cart has been cleared.'
            );
    }


    public function options(Request $request)
    {
        $validated = $request->validate([
            'delivery_option' => [
                'required',
                'in:delivery,pickup'
            ],
            'payment_method' => [
                'required',
                'in:cash_on_delivery,cash_on_pickup,gcash'
            ],
        ]);

        $deliveryOption = $validated['delivery_option'];
        $paymentMethod = $validated['payment_method'];

        if (
            $deliveryOption === 'delivery' &&
            $paymentMethod === 'cash_on_pickup'
        ) {
            return back()
                ->with(
                    'error',
                    'Cash on Pickup is only available for pickup orders.'
                )
                ->withInput();
        }

        if (
            $deliveryOption === 'pickup' &&
            $paymentMethod === 'cash_on_delivery'
        ) {
            return back()
                ->with(
                    'error',
                    'Cash on Delivery is only available for delivery orders.'
                )
                ->withInput();
        }

        session([
            'delivery_option' => $deliveryOption,
            'payment_method' => $paymentMethod,
        ]);

        return back()->with(
            'success',
            'Order options saved successfully!'
        );
    }
}