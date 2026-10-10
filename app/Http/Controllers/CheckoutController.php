<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
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
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | GET CART
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

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
        | GET ORDER OPTIONS
        |--------------------------------------------------------------------------
        */

        $deliveryOption = session(
            'delivery_option',
            'delivery'
        );

        $paymentMethod = session(
            'payment_method',
            'cash_on_delivery'
        );


        /*
        |--------------------------------------------------------------------------
        | CALCULATE SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($cart as $item) {

            $price = (float) ($item['price'] ?? 0);

            $quantity = (int) ($item['quantity'] ?? 0);

            $subtotal += $price * $quantity;
        }


        /*
        |--------------------------------------------------------------------------
        | KEEP $total FOR EXISTING CHECKOUT BLADE
        |--------------------------------------------------------------------------
        |
        | Your existing checkout.blade.php uses $total.
        | Therefore, we provide it here.
        |
        */

        $total = $subtotal;


        /*
        |--------------------------------------------------------------------------
        | DELIVERY FEE
        |--------------------------------------------------------------------------
        */

        $deliveryFee =
            $deliveryOption === 'delivery'
                ? 50
                : 0;


        /*
        |--------------------------------------------------------------------------
        | GRAND TOTAL
        |--------------------------------------------------------------------------
        */

        $totalAmount =
            $subtotal + $deliveryFee;


        /*
        |--------------------------------------------------------------------------
        | RETURN CHECKOUT VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'checkout',
            compact(
                'cart',
                'total',
                'subtotal',
                'deliveryOption',
                'paymentMethod',
                'deliveryFee',
                'totalAmount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | GET CART
        |--------------------------------------------------------------------------
        */

        $cart = session()->get('cart', []);

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
        | GET ORDER OPTIONS
        |--------------------------------------------------------------------------
        */

        $deliveryOption = session(
            'delivery_option',
            'delivery'
        );

        $paymentMethod = session(
            'payment_method',
            'cash_on_delivery'
        );


        /*
        |--------------------------------------------------------------------------
        | VALID DELIVERY OPTION
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $deliveryOption,
                [
                    'delivery',
                    'pickup',
                ],
                true
            )
        ) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Please select a valid delivery option.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALID PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $paymentMethod,
                [
                    'cash_on_delivery',
                    'cash_on_pickup',
                    'gcash',
                ],
                true
            )
        ) {

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Please select a valid payment method.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK DELIVERY / PAYMENT COMBINATION
        |--------------------------------------------------------------------------
        */

        if (
            $deliveryOption === 'delivery'
            &&
            $paymentMethod === 'cash_on_pickup'
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
            &&
            $paymentMethod === 'cash_on_delivery'
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
                'nullable',
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
        | DELIVERY ADDRESS
        |--------------------------------------------------------------------------
        */

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

        } else {

            $deliveryAddress =
                'Pickup at Abuyog Andrea Pizza';
        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATE SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($cart as $item) {

            $price = (float) ($item['price'] ?? 0);

            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1) {
                continue;
            }

            $subtotal +=
                $price * $quantity;
        }


        /*
        |--------------------------------------------------------------------------
        | DELIVERY FEE
        |--------------------------------------------------------------------------
        */

        $deliveryFee =
            $deliveryOption === 'delivery'
                ? 50
                : 0;


        /*
        |--------------------------------------------------------------------------
        | TOTAL AMOUNT
        |--------------------------------------------------------------------------
        */

        $totalAmount =
            $subtotal + $deliveryFee;


        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */

        try {

            $order = DB::transaction(
                function () use (
                    $cart,
                    $deliveryOption,
                    $paymentMethod,
                    $deliveryAddress,
                    $validated,
                    $subtotal,
                    $deliveryFee,
                    $totalAmount
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | GENERATE ORDER NUMBER
                    |--------------------------------------------------------------------------
                    */

                    do {

                        $orderNumber =
                            'AAP-' .
                            now()->format('YmdHis') .
                            '-' .
                            strtoupper(
                                Str::random(5)
                            );

                    } while (
                        Order::where(
                            'order_number',
                            $orderNumber
                        )->exists()
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ORDER
                    |--------------------------------------------------------------------------
                    */

                    $order = Order::create([

                        'user_id' =>
                            Auth::id(),

                        'order_number' =>
                            $orderNumber,

                        'subtotal' =>
                            $subtotal,

                        'delivery_fee' =>
                            $deliveryFee,

                        /*
                        |--------------------------------------------------------------------------
                        | DELIVERY OPTION
                        |--------------------------------------------------------------------------
                        */

                        'delivery_option' =>
                            $deliveryOption,

                        /*
                        |--------------------------------------------------------------------------
                        | DELIVERY METHOD
                        |--------------------------------------------------------------------------
                        |
                        | Your current database also has
                        | delivery_method, so we keep it.
                        |
                        */

                        'delivery_method' =>
                            $deliveryOption,

                        'delivery_address' =>
                            $deliveryAddress,

                        'contact_number' =>
                            $validated[
                                'contact_number'
                            ],

                        'payment_method' =>
                            $paymentMethod,

                        /*
                        |--------------------------------------------------------------------------
                        | ORDER STATUS
                        |--------------------------------------------------------------------------
                        */

                        'status' =>
                            'pending',

                        'total_amount' =>
                            $totalAmount,

                        'notes' =>
                            $validated[
                                'notes'
                            ] ?? null,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ORDER ITEMS
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $cart
                        as $pizzaId => $item
                    ) {

                        $pizzaId =
                            (int) $pizzaId;

                        $quantity =
                            (int) (
                                $item['quantity']
                                ?? 0
                            );


                        if ($quantity < 1) {
                            continue;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | GET FRESH PIZZA DATA
                        |--------------------------------------------------------------------------
                        */

                        $pizza =
                            Pizza::lockForUpdate()
                                ->find($pizzaId);


                        if (!$pizza) {

                            throw new \RuntimeException(
                                'One of the selected pizzas no longer exists.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | CHECK PIZZA STATUS
                        |--------------------------------------------------------------------------
                        */

                        if (!$pizza->status) {

                            throw new \RuntimeException(
                                $pizza->name .
                                ' is currently unavailable.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | CHECK STOCK
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $pizza->stock
                            < $quantity
                        ) {

                            throw new \RuntimeException(
                                'Only ' .
                                $pizza->stock .
                                ' stock is available for ' .
                                $pizza->name .
                                '.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | GET DATABASE PRICE
                        |--------------------------------------------------------------------------
                        */

                        $price =
                            (float) $pizza->price;


                        $itemSubtotal =
                            $price * $quantity;


                        /*
                        |--------------------------------------------------------------------------
                        | CREATE ORDER ITEM
                        |--------------------------------------------------------------------------
                        */

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
                        | REDUCE STOCK
                        |--------------------------------------------------------------------------
                        */

                        $pizza->decrement(
                            'stock',
                            $quantity
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENT METHOD
                    |--------------------------------------------------------------------------
                    */

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANT
                    |--------------------------------------------------------------------------
                    |
                    | payments.method only accepts:
                    |
                    | cash_on_delivery
                    | gcash
                    |
                    | Therefore cash_on_pickup is saved as
                    | cash_on_delivery internally.
                    |
                    */

                    $databasePaymentMethod =
                        $paymentMethod === 'gcash'
                            ? 'gcash'
                            : 'cash_on_delivery';


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE PAYMENT
                    |--------------------------------------------------------------------------
                    */

                    Payment::create([

                        'order_id' =>
                            $order->id,

                        'amount' =>
                            $totalAmount,

                        'method' =>
                            $databasePaymentMethod,

                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT
                        |--------------------------------------------------------------------------
                        |
                        | GCash starts as PENDING.
                        |
                        | It becomes PAID only after the
                        | customer submits the GCash
                        | reference number.
                        |
                        */

                        'status' =>
                            'pending',

                        'reference_number' =>
                            null,

                        'paid_at' =>
                            null,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE DELIVERY RECORD
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $deliveryOption
                        === 'delivery'
                    ) {

                        Delivery::create([

                            'order_id' =>
                                $order->id,

                            'rider_name' =>
                                null,

                            'rider_contact' =>
                                null,

                            'picked_up_at' =>
                                null,

                            'delivered_at' =>
                                null,

                            'delivery_notes' =>
                                null,

                        ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | RETURN ORDER
                    |--------------------------------------------------------------------------
                    */

                    return $order;
                }
            );

        } catch (\RuntimeException $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                )
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
        | CLEAR CART
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');

        session()->forget([
            'delivery_option',
            'payment_method',
        ]);


        /*
        |--------------------------------------------------------------------------
        | GCASH FLOW
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | DO NOT redirect to order confirmation
        | immediately when GCash is selected.
        |
        | First show the QR payment page.
        |
        */

        if (
            $paymentMethod === 'gcash'
        ) {

            return redirect()
                ->route(
                    'customer.gcash',
                    $order->id
                )
                ->with(
                    'success',
                    'Your order has been created. Please complete your GCash payment.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CASH FLOW
        |--------------------------------------------------------------------------
        |
        | Cash orders can immediately proceed
        | to the order confirmation page.
        |
        */

        return redirect()
            ->route(
                'customer.orders.confirmation',
                $order->id
            )
            ->with(
                'success',
                'Your order has been placed successfully!'
            );
    }
}