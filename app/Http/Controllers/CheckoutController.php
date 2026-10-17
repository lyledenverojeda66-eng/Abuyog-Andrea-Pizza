<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Pizza;
use App\Services\DeliveryFeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function index(DeliveryFeeService $deliveryFeeService)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart')
                ->with('error', 'Your cart is empty.');
        }

        $deliveryOption = session('delivery_option', 'delivery');
        $paymentMethod = session('payment_method', 'cash_on_delivery');
        $deliveryAddress = session('delivery_address', '');

        $subtotal = 0;

        foreach ($cart as $item) {
            $price = (float) ($item['price'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 0);

            $subtotal += $price * $quantity;
        }

        // Retain $total for compatibility with the existing checkout view.
        $total = $subtotal;

        $deliveryFee = 0;
        $deliveryDistance = null;
        $distanceError = null;
        $deliveryQuote = null;

        if ($deliveryOption === 'delivery') {
            if (trim($deliveryAddress) === '') {
                return redirect()
                    ->route('cart')
                    ->with(
                        'error',
                        'Please enter your delivery address before checkout.'
                    );
            }

            $deliveryQuote = $deliveryFeeService->quote(
                $deliveryAddress
            );

            if (!$deliveryQuote['known']) {
                session()->forget([
                    'delivery_fee',
                    'delivery_distance_km',
                ]);

                return redirect()
                    ->route('cart')
                    ->with(
                        'error',
                        $deliveryQuote['message']
                            ?? 'Contact us to confirm the delivery fee.'
                    );
            }

            $deliveryFee = (float) $deliveryQuote['fee'];

            session([
                'delivery_address' => $deliveryAddress,
                'delivery_fee' => $deliveryFee,
            ]);

            session()->forget('delivery_distance_km');
        } else {
            $deliveryFee = 0;

            session([
                'delivery_fee' => 0,
            ]);

            session()->forget('delivery_distance_km');
        }

        $totalAmount = $subtotal + $deliveryFee;

        return view('checkout', compact(
            'cart',
            'total',
            'subtotal',
            'deliveryOption',
            'paymentMethod',
            'deliveryAddress',
            'deliveryDistance',
            'distanceError',
            'deliveryQuote',
            'deliveryFee',
            'totalAmount'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        DeliveryFeeService $deliveryFeeService
    ) {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart')
                ->with('error', 'Your cart is empty.');
        }

        $deliveryOption = session('delivery_option', 'delivery');
        $paymentMethod = session('payment_method', 'cash_on_delivery');

        /*
        |--------------------------------------------------------------------------
        | VALIDATE DELIVERY OPTION
        |--------------------------------------------------------------------------
        */

        if (!in_array($deliveryOption, ['delivery', 'pickup'], true)) {
            return redirect()
                ->route('cart')
                ->with('error', 'Please select a valid delivery option.');
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $paymentMethod,
            ['cash_on_delivery', 'cash_on_pickup', 'gcash'],
            true
        )) {
            return redirect()
                ->route('cart')
                ->with('error', 'Please select a valid payment method.');
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK DELIVERY AND PAYMENT COMPATIBILITY
        |--------------------------------------------------------------------------
        */

        if (
            $deliveryOption === 'delivery'
            && $paymentMethod === 'cash_on_pickup'
        ) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Cash on Pickup is only available for pickup orders.'
                );
        }

        if (
            $deliveryOption === 'pickup'
            && $paymentMethod === 'cash_on_delivery'
        ) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Cash on Delivery is only available for delivery orders.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE CUSTOMER INFORMATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'delivery_address' => [
                $deliveryOption === 'delivery' ? 'required' : 'nullable',
                'string',
                'max:1000',
            ],
            'contact_number' => [
                'required',
                'string',
                'max:30',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | DELIVERY ADDRESS AND BARANGAY-BASED FEE
        |--------------------------------------------------------------------------
        */

        $deliveryDistance = null;

        if ($deliveryOption === 'delivery') {
            $deliveryAddress = trim(
                $validated['delivery_address'] ?? ''
            );

            if ($deliveryAddress === '') {
                return back()
                    ->with(
                        'error',
                        'Please enter your delivery address.'
                    )
                    ->withInput();
            }

            // Always calculate the fee on the server.
            // Never trust a fee submitted by the browser or session.
            $deliveryQuote = $deliveryFeeService->quote(
                $deliveryAddress
            );

            if (!$deliveryQuote['known']) {
                session()->forget([
                    'delivery_fee',
                    'delivery_distance_km',
                ]);

                return back()
                    ->with(
                        'error',
                        $deliveryQuote['message']
                            ?? 'Contact us to confirm the delivery fee.'
                    )
                    ->withInput();
            }

            $deliveryFee = (float) $deliveryQuote['fee'];

            session([
                'delivery_address' => $deliveryAddress,
                'delivery_fee' => $deliveryFee,
            ]);

            session()->forget('delivery_distance_km');
        } else {
            $deliveryAddress = 'Pickup at Abuyog Andrea Pizza';
            $deliveryFee = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | CALCULATE SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($cart as $item) {
            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1) {
                continue;
            }

            // The final subtotal is recalculated from database prices
            // inside the transaction below.
            $price = (float) ($item['price'] ?? 0);
            $subtotal += $price * $quantity;
        }

        $totalAmount = $subtotal + $deliveryFee;

        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */

        try {
            $order = DB::transaction(function () use (
                $cart,
                $deliveryOption,
                $paymentMethod,
                $deliveryAddress,
                $validated,
                $deliveryFee
            ) {
                /*
                |--------------------------------------------------------------------------
                | VALIDATE PIZZAS AND CALCULATE DATABASE SUBTOTAL
                |--------------------------------------------------------------------------
                */

                $subtotal = 0;
                $orderItems = [];

                foreach ($cart as $pizzaId => $item) {
                    $pizzaId = (int) $pizzaId;
                    $quantity = (int) ($item['quantity'] ?? 0);

                    if ($quantity < 1) {
                        continue;
                    }

                    $pizza = Pizza::lockForUpdate()->find($pizzaId);

                    if (!$pizza) {
                        throw new \RuntimeException(
                            'One of the selected pizzas no longer exists.'
                        );
                    }

                    if (!$pizza->status) {
                        throw new \RuntimeException(
                            $pizza->name . ' is currently unavailable.'
                        );
                    }

                    if ($pizza->stock < $quantity) {
                        throw new \RuntimeException(
                            'Only ' . $pizza->stock
                            . ' stock is available for '
                            . $pizza->name . '.'
                        );
                    }

                    $price = (float) $pizza->price;
                    $itemSubtotal = $price * $quantity;

                    $subtotal += $itemSubtotal;

                    $orderItems[] = [
                        'pizza' => $pizza,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                if (empty($orderItems)) {
                    throw new \RuntimeException(
                        'Your cart does not contain any valid items.'
                    );
                }

                $totalAmount = $subtotal + $deliveryFee;

                /*
                |--------------------------------------------------------------------------
                | GENERATE ORDER NUMBER
                |--------------------------------------------------------------------------
                */

                do {
                    $orderNumber = 'AAP-'
                        . now()->format('YmdHis')
                        . '-'
                        . strtoupper(Str::random(5));
                } while (
                    Order::where('order_number', $orderNumber)->exists()
                );

                /*
                |--------------------------------------------------------------------------
                | CREATE ORDER
                |--------------------------------------------------------------------------
                */

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => $orderNumber,
                    'subtotal' => $subtotal,
                    'delivery_fee' => $deliveryFee,
                    'delivery_option' => $deliveryOption,
                    'delivery_method' => $deliveryOption,
                    'delivery_address' => $deliveryAddress,
                    'contact_number' => $validated['contact_number'],
                    'payment_method' => $paymentMethod,
                    'status' => 'pending',
                    'total_amount' => $totalAmount,
                    'notes' => $validated['notes'] ?? null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | CREATE ORDER ITEMS AND UPDATE STOCK
                |--------------------------------------------------------------------------
                */

                foreach ($orderItems as $orderItem) {
                    $pizza = $orderItem['pizza'];
                    $quantity = $orderItem['quantity'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'pizza_id' => $pizza->id,
                        'quantity' => $quantity,
                        'price' => $orderItem['price'],
                        'subtotal' => $orderItem['subtotal'],
                    ]);

                    $pizza->decrement('stock', $quantity);
                }

                /*
                |--------------------------------------------------------------------------
                | CREATE PAYMENT
                |--------------------------------------------------------------------------
                |
                | Preserve the current payments.method compatibility.
                | GCash payment is completed through the existing QR flow.
                |--------------------------------------------------------------------------
                */

                $databasePaymentMethod = $paymentMethod === 'gcash'
                    ? 'gcash'
                    : 'cash_on_delivery';

                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $totalAmount,
                    'method' => $databasePaymentMethod,
                    'status' => 'pending',
                    'reference_number' => null,
                    'paid_at' => null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | CREATE DELIVERY RECORD
                |--------------------------------------------------------------------------
                */

                if ($deliveryOption === 'delivery') {
                    Delivery::create([
                        'order_id' => $order->id,
                        'rider_name' => null,
                        'rider_contact' => null,
                        'picked_up_at' => null,
                        'delivered_at' => null,
                        'delivery_notes' => null,
                    ]);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->with(
                    'error',
                    'Something went wrong while placing your order. Please try again.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR CART AND ORDER OPTIONS
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');

        session()->forget([
            'delivery_option',
            'payment_method',
            'delivery_address',
            'delivery_distance_km',
            'delivery_fee',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GCASH QR PAYMENT FLOW
        |--------------------------------------------------------------------------
        */

        if ($paymentMethod === 'gcash') {
            return redirect()
                ->route('customer.gcash', $order->id)
                ->with(
                    'success',
                    'Your order has been created. Please complete your GCash payment.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CASH PAYMENT FLOW
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('customer.orders.confirmation', $order->id)
            ->with(
                'success',
                'Your order has been placed successfully!'
            );
    }
}
