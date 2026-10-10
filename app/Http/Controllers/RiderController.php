<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiderController extends Controller
{
    public function dashboard()
    {
        $deliveries = Delivery::with([
            'order.user',
            'order.payment',
            'order.orderItems.pizza',
        ])
            ->where('rider_id', auth()->id())
            ->latest()
            ->get();

        return view('rider.dashboard', compact('deliveries'));
    }
    public function updateStatus(Request $request, Delivery $delivery)
{
    // Assigned rider lamang ang puwedeng mag-update.
    abort_unless(
        (int) $delivery->rider_id === (int) auth()->id(),
        403
    );

    $validated = $request->validate([
        'status' => [
            'required',
            'in:preparing,ready_for_pickup,picked_up,out_for_delivery,delivered',
        ],
    ]);

    $status = $validated['status'];

    // Huwag payagang bumalik sa mas naunang status.
    $allowedNextStatuses = [
        'pending' => ['preparing'],
        'preparing' => ['ready_for_pickup'],
        'ready_for_pickup' => ['picked_up'],
        'picked_up' => ['out_for_delivery', 'delivered'],
        'out_for_delivery' => ['delivered'],
        'delivered' => [],
    ];

    if (
        !in_array(
            $status,
            $allowedNextStatuses[$delivery->status] ?? [],
            true
        )
    ) {
        return back()->with(
            'error',
            'Invalid status transition. Check the current delivery status.'
        );
    }

    DB::transaction(function () use ($delivery, $status) {
        $delivery->status = $status;

        if (
            in_array($status, ['picked_up', 'out_for_delivery'], true)
            && !$delivery->picked_up_at
        ) {
            $delivery->picked_up_at = now();
        }

        if ($status === 'delivered' && !$delivery->delivered_at) {
            $delivery->delivered_at = now();
        }

        $delivery->save();

        $orderStatus = [
            'preparing' => 'preparing',
            'ready_for_pickup' => 'ready_for_delivery',
            'picked_up' => 'out_for_delivery',
            'out_for_delivery' => 'out_for_delivery',
            'delivered' => 'delivered',
        ][$status] ?? null;

        if ($orderStatus && $delivery->order) {
            $delivery->order->update([
                'status' => $orderStatus,
            ]);
        }
    });

    return redirect()
        ->route('rider.dashboard')
        ->with('success', 'Delivery status updated successfully!');
}

    public function confirmPayment(Delivery $delivery)
    {
        // Only the assigned rider can confirm payment.
        abort_unless(
            (int) $delivery->rider_id === (int) auth()->id(),
            403
        );

        $order = $delivery->order;

        if (!$order) {
            return back()->with(
                'error',
                'Walang linked order ang delivery.'
            );
        }

        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'Walang payment record para sa order na ito.'
            );
        }

        // Normalize payment method.
        $method = strtolower(trim(
            $payment->method ?? $order->payment_method ?? ''
        ));

        // Rider confirmation is only for Cash on Delivery.
        $isCod = in_array($method, [
            'cash_on_delivery',
            'cod',
            'cash on delivery',
        ], true);

        if (!$isCod) {
            return back()->with(
                'error',
                'GCash payments must be verified and approved by Admin.'
            );
        }

        if ($payment->status === 'paid') {
            return back()->with(
                'success',
                'Confirmed na ang payment na ito.'
            );
        }

        if ($payment->status === 'failed') {
            return back()->with(
                'error',
                'Failed ang payment. Hindi ito maaaring kumpirmahin.'
            );
        }

        DB::transaction(function () use ($payment, $delivery) {
            $payment->update([
                'status' => 'paid',
                'paid_at' => $payment->paid_at ?? now(),
            ]);

            $delivery->update([
                'payment_status' => 'paid',
                'payment_received_at' =>
                    $delivery->payment_received_at ?? now(),
            ]);
        });

        return back()->with(
            'success',
            'COD payment confirmed! Updated na rin ang Admin payment record.'
        );
    }
}