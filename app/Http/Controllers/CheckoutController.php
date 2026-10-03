<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get(
            'cart',
            []
        );

        if (empty($cart)) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Your cart is empty.'
                );
        }

        $deliveryOption = session(
            'delivery_option',
            null
        );

        $paymentMethod = session(
            'payment_method',
            null
        );

        /*
        |--------------------------------------------------------------------------
        | REQUIRE CART OPTIONS FIRST
        |--------------------------------------------------------------------------
        */

        if (
            !$deliveryOption ||
            !$paymentMethod
        ) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Please select your delivery and payment option first.'
                );
        }

        $subtotal = 0;

        foreach ($cart as $item) {

            $subtotal +=
                (float) $item['price'] *
                (int) $item['quantity'];
        }


        /*
        |--------------------------------------------------------------------------
        | DELIVERY FEE
        |--------------------------------------------------------------------------
        */

        $deliveryFee =
            $deliveryOption === 'delivery'
            ? 50.00
            : 0.00;


        $total =
            $subtotal +
            $deliveryFee;


        return view(
            'checkout',
            compact(
                'cart',
                'subtotal',
                'deliveryFee',
                'total',
                'deliveryOption',
                'paymentMethod'
            )
        );
    }


    public function store(
        Request $request
    ) {

        $request->validate([
            'delivery_address' => [
                'required',
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
                'max:1000',
            ],
        ]);


        $cart = session()->get(
            'cart',
            []
        );


        if (empty($cart)) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Your cart is empty.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | GET OPTIONS FROM CART
        |--------------------------------------------------------------------------
        */

        $deliveryOption =
            session(
                'delivery_option'
            );

        $paymentMethod =
            session(
                'payment_method'
            );


        if (
            !$deliveryOption ||
            !$paymentMethod
        ) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Please select your delivery and payment option first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        if (
            $deliveryOption ===
            'delivery'
        ) {

            if (
                !in_array(
                    $paymentMethod,
                    [
                        'cash_on_delivery',
                        'gcash',
                    ]
                )
            ) {

                return redirect()
                    ->route('cart')
                    ->with(
                        'error',
                        'Invalid payment method for delivery.'
                    );
            }
        }


        if (
            $deliveryOption ===
            'pickup'
        ) {

            if (
                !in_array(
                    $paymentMethod,
                    [
                        'cash_on_pickup',
                        'gcash',
                    ]
                )
            ) {

                return redirect()
                    ->route('cart')
                    ->with(
                        'error',
                        'Invalid payment method for pickup.'
                    );
            }
        }


        try {

            $order = DB::transaction(
                function () use (
                    $request,
                    $cart,
                    $deliveryOption,
                    $paymentMethod
                ) {

                    $subtotal = 0;


                    /*
                    |--------------------------------------------------------------------------
                    | CHECK STOCK
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $cart
                        as $item
                    ) {

                        $pizza =
                            Pizza::lockForUpdate()
                                ->find(
                                    $item['id']
                                );


                        if (!$pizza) {

                            throw new \Exception(
                                'A pizza in your cart no longer exists.'
                            );
                        }


                        if (
                            !$pizza->status
                        ) {

                            throw new \Exception(
                                $pizza->name .
                                ' is currently unavailable.'
                            );
                        }


                        $quantity =
                            (int)
                            $item['quantity'];


                        if (
                            $quantity < 1
                        ) {

                            throw new \Exception(
                                'Invalid quantity for ' .
                                $pizza->name .
                                '.'
                            );
                        }


                        if (
                            $pizza->stock <
                            $quantity
                        ) {

                            throw new \Exception(
                                'Only ' .
                                $pizza->stock .
                                ' ' .
                                $pizza->name .
                                ' available.'
                            );
                        }


                        $subtotal +=
                            (float)
                            $pizza->price *
                            $quantity;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DELIVERY FEE
                    |--------------------------------------------------------------------------
                    */

                    $deliveryFee =
                        $deliveryOption ===
                        'delivery'
                        ? 50.00
                        : 0.00;


                    $total =
                        $subtotal +
                        $deliveryFee;


                    /*
                    |--------------------------------------------------------------------------
                    | ORDER NUMBER
                    |--------------------------------------------------------------------------
                    */

                    $orderNumber =
                        'AAP-' .
                        now()->format(
                            'YmdHis'
                        ) .
                        '-' .
                        strtoupper(
                            Str::random(5)
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ORDER
                    |--------------------------------------------------------------------------
                    */

                    $order =
                        Order::create([

                            'user_id' =>
                                Auth::id(),

                            'order_number' =>
                                $orderNumber,

                            'subtotal' =>
                                $subtotal,

                            'delivery_fee' =>
                                $deliveryFee,

                            'delivery_option' =>
                                $deliveryOption,

                            'total_amount' =>
                                $total,

                            'delivery_address' =>
                                $request
                                    ->delivery_address,

                            'contact_number' =>
                                $request
                                    ->contact_number,

                            'payment_method' =>
                                $paymentMethod,

                            'status' =>
                                'pending',

                            'notes' =>
                                $request->notes,
                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | ORDER ITEMS
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $cart
                        as $item
                    ) {

                        $pizza =
                            Pizza::lockForUpdate()
                                ->find(
                                    $item['id']
                                );


                        $quantity =
                            (int)
                            $item['quantity'];


                        $price =
                            (float)
                            $pizza->price;


                        $itemSubtotal =
                            $price *
                            $quantity;


                        OrderItem::create([

                            'order_id' =>
                                $order->id,

                            'pizza_id' =>
                                $pizza->id,

                            'quantity' =>
                                $quantity,

                            'price' =>
                                $price,

                            'subtotal' =>
                                $itemSubtotal,
                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | DEDUCT STOCK
                        |--------------------------------------------------------------------------
                        */

                        $pizza->decrement(
                            'stock',
                            $quantity
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE PAYMENT
                    |--------------------------------------------------------------------------
                    */

                    Payment::create([

                        'order_id' =>
                            $order->id,

                        'amount' =>
                            $total,

                        'method' =>
                            $paymentMethod ===
                            'cash_on_pickup'
                            ? 'cash_on_delivery'
                            : $paymentMethod,

                        'status' =>
                            'pending',

                        'reference_number' =>
                            null,

                        'paid_at' =>
                            null,
                    ]);


                    return $order;
                }
            );


            /*
            |--------------------------------------------------------------------------
            | CLEAR CART OPTIONS
            |--------------------------------------------------------------------------
            */

            session()->forget(
                'cart'
            );

            session()->forget(
                'delivery_option'
            );

            session()->forget(
                'payment_method'
            );


            /*
            |--------------------------------------------------------------------------
            | GCASH
            |--------------------------------------------------------------------------
            */

            if (
                $paymentMethod ===
                'gcash'
            ) {

                return redirect()
                    ->route(
                        'gcash.payment',
                        $order
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CASH
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'order.confirmation',
                    $order
                )
                ->with(
                    'success',
                    'Your order has been placed successfully!'
                );


        } catch (
            \Exception $e
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}