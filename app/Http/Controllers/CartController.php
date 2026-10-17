<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Services\DeliveryFeeService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart and calculate the barangay-based delivery fee.
     */
    public function index(DeliveryFeeService $deliveryFeeService)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $pizzaId => &$item) {
            $pizza = Pizza::find($pizzaId);

            if ($pizza) {
                $item['name'] = $pizza->name;
                $item['price'] = (float) $pizza->price;
                $item['image'] = $pizza->image;
            }
        }

        unset($item);

        session()->put('cart', $cart);

        $total = 0;

        foreach ($cart as $item) {
            $total += (float) ($item['price'] ?? 0)
                * (int) ($item['quantity'] ?? 0);
        }

        $deliveryOption = session('delivery_option', 'delivery');
        $paymentMethod = session('payment_method', 'cash_on_delivery');
        $deliveryAddress = session('delivery_address', '');

        $deliveryDistance = null;
        $deliveryFee = 0;
        $distanceError = null;
        $deliveryQuote = null;

        if ($deliveryOption === 'delivery') {
            if (trim($deliveryAddress) !== '') {
                $deliveryQuote = $deliveryFeeService->quote(
                    $deliveryAddress
                );

                if ($deliveryQuote['known']) {
                    $deliveryFee = (float) $deliveryQuote['fee'];

                    session([
                        'delivery_fee' => $deliveryFee,
                    ]);
                } else {
                    $distanceError = $deliveryQuote['message'];

                    session()->forget('delivery_fee');
                }
            } else {
                session()->forget('delivery_fee');
            }
        } else {
            $deliveryFee = 0;

            session([
                'delivery_fee' => 0,
            ]);
        }

        $grandTotal = $total + $deliveryFee;

        return view('cart', compact(
            'cart',
            'total',
            'deliveryOption',
            'paymentMethod',
            'deliveryAddress',
            'deliveryDistance',
            'distanceError',
            'deliveryFee',
            'grandTotal',
            'deliveryQuote'
        ));
    }

    /**
     * Add a pizza to the cart.
     */
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

        $cart = session()->get('cart', []);

        $existingQuantity = isset($cart[$pizza->id])
            ? (int) $cart[$pizza->id]['quantity']
            : 0;

        if (($existingQuantity + $quantity) > $pizza->stock) {
            return back()->with(
                'error',
                'Only ' . $pizza->stock
                    . ' stock is available for '
                    . $pizza->name . '.'
            );
        }

        if (isset($cart[$pizza->id])) {
            $cart[$pizza->id]['quantity'] =
                $existingQuantity + $quantity;

            $cart[$pizza->id]['name'] = $pizza->name;
            $cart[$pizza->id]['price'] = (float) $pizza->price;
            $cart[$pizza->id]['image'] = $pizza->image;
        } else {
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

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->quantity;
        $cart = session()->get('cart', []);

        if (!isset($cart[$pizza->id])) {
            return back()->with(
                'error',
                'This pizza is not in your cart.'
            );
        }

        if (!$pizza->status || $pizza->stock <= 0) {
            return back()->with(
                'error',
                $pizza->name . ' is currently unavailable.'
            );
        }

        if ($quantity > $pizza->stock) {
            return back()->with(
                'error',
                'Only ' . $pizza->stock
                    . ' stock is available for '
                    . $pizza->name . '.'
            );
        }

        $cart[$pizza->id]['quantity'] = $quantity;
        $cart[$pizza->id]['name'] = $pizza->name;
        $cart[$pizza->id]['price'] = (float) $pizza->price;
        $cart[$pizza->id]['image'] = $pizza->image;

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Cart updated successfully!'
        );
    }

    /**
     * Remove a pizza from the cart.
     */
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

    /**
     * Clear the cart and related order options.
     */
    public function clear()
    {
        session()->forget([
            'cart',
            'delivery_option',
            'payment_method',
            'delivery_address',
            'delivery_distance_km',
            'delivery_fee',
        ]);

        return redirect()
            ->route('cart')
            ->with('success', 'Your cart has been cleared.');
    }

    /**
     * Save delivery address, delivery/pickup option, and payment method
     * together using the single Save Order Options form.
     */
    public function options(
        Request $request,
        DeliveryFeeService $deliveryFeeService
    ) {
        $validated = $request->validate([
            'delivery_option' => [
                'required',
                'in:delivery,pickup',
            ],
            'payment_method' => [
                'required',
                'in:cash_on_delivery,cash_on_pickup,gcash',
            ],
            'delivery_address' => [
                'required_if:delivery_option,delivery',
                'nullable',
                'string',
                'min:3',
                'max:1000',
            ],
        ]);

        $deliveryOption = $validated['delivery_option'];
        $paymentMethod = $validated['payment_method'];

        if (
            $deliveryOption === 'delivery'
            && $paymentMethod === 'cash_on_pickup'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Cash on Pickup is only available for pickup orders.'
                );
        }

        if (
            $deliveryOption === 'pickup'
            && $paymentMethod === 'cash_on_delivery'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Cash on Delivery is only available for delivery orders.'
                );
        }

        session([
            'delivery_option' => $deliveryOption,
            'payment_method' => $paymentMethod,
        ]);

        if ($deliveryOption === 'pickup') {
            session([
                'delivery_fee' => 0,
            ]);

            session()->forget('delivery_distance_km');

            return redirect()
                ->route('cart')
                ->with(
                    'success',
                    'Order options saved successfully. No delivery fee applies to pickup orders.'
                );
        }

        $address = trim($validated['delivery_address']);

        session([
            'delivery_address' => $address,
        ]);

        session()->forget('delivery_distance_km');

        $quote = $deliveryFeeService->quote($address);

        if (
            ($quote['known'] ?? false)
            && isset($quote['fee'])
        ) {
            $fee = (float) $quote['fee'];

            session([
                'delivery_fee' => $fee,
            ]);

            return redirect()
                ->route('cart')
                ->with(
                    'success',
                    'Order options saved successfully. Delivery fee: ₱'
                    . number_format($fee, 2)
                );
        }

        session()->forget('delivery_fee');

        return redirect()
            ->route('cart')
            ->with(
                'warning',
                'Your order options and delivery address were saved, but the delivery fee could not be confirmed. '
                . ($quote['message'] ?? 'Please check your address.')
            );
    }

    /**
     * Keep the old address-saving endpoint for compatibility with
     * any existing links or forms that still use it.
     */
    public function saveAddress(
        Request $request,
        DeliveryFeeService $deliveryFeeService
    ) {
        $validated = $request->validate([
            'delivery_address' => [
                'required',
                'string',
                'min:3',
                'max:1000',
            ],
        ]);

        $address = trim($validated['delivery_address']);

        session([
            'delivery_address' => $address,
        ]);

        session()->forget('delivery_distance_km');

        $quote = $deliveryFeeService->quote($address);

        if (
            ($quote['known'] ?? false)
            && isset($quote['fee'])
        ) {
            session([
                'delivery_fee' => (float) $quote['fee'],
            ]);

            return redirect()
                ->route('cart')
                ->with(
                    'success',
                    'Delivery address saved. Delivery fee: ₱'
                    . number_format($quote['fee'], 2)
                );
        }

        session()->forget('delivery_fee');

        return redirect()
            ->route('cart')
            ->with(
                'warning',
                'Address saved. '
                . ($quote['message'] ?? 'The delivery fee could not be confirmed.')
            );
    }
}
