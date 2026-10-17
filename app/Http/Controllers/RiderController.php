<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RiderController extends Controller
{
    /**
     * Rider dashboard.
     */
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

    /**
     * Update delivery status.
     * A proof photo is required before delivery can be completed.
     */
    public function updateStatus(Request $request, Delivery $delivery)
    {
        abort_unless(
            (int) $delivery->rider_id === (int) auth()->id(),
            403
        );

        $validated = $request->validate([
            'status' => [
                'required',
                'in:preparing,ready_for_pickup,picked_up,out_for_delivery,delivered',
            ],
            'proof_photo' => [
                'required_if:status,delivered',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'status.required' => 'Please select a delivery status.',
            'status.in' => 'The selected delivery status is invalid.',
            'proof_photo.required_if' =>
                'Please upload a proof photo before completing the delivery.',
            'proof_photo.image' =>
                'The proof photo must be a valid image.',
            'proof_photo.mimes' =>
                'Only JPG, JPEG, PNG, and WEBP images are allowed.',
            'proof_photo.max' =>
                'The proof photo must not exceed 5 MB.',
        ]);

        $status = $validated['status'];

        $allowedNextStatuses = [
            'pending' => ['preparing'],
            'preparing' => ['ready_for_pickup'],
            'ready_for_pickup' => ['picked_up'],
            'picked_up' => ['out_for_delivery', 'delivered'],
            'out_for_delivery' => ['delivered'],
            'delivered' => [],
        ];

        if (!in_array(
            $status,
            $allowedNextStatuses[$delivery->status] ?? [],
            true
        )) {
            return back()->with(
                'error',
                'Invalid status transition. Please check the current delivery status.'
            );
        }

        $photoPath = null;

        // Store the proof photo before completing the delivery.
        if ($status === 'delivered') {
            $photoPath = $request->file('proof_photo')
                ->store('delivery-proofs', 'public');

            if (!$photoPath) {
                return back()->with(
                    'error',
                    'The proof photo could not be saved. Please try again.'
                );
            }
        }

        try {
            DB::transaction(function () use (
                $delivery,
                $status,
                $photoPath
            ) {
                $delivery->status = $status;

                if (
                    in_array($status, ['picked_up', 'out_for_delivery'], true)
                    && !$delivery->picked_up_at
                ) {
                    $delivery->picked_up_at = now();
                }

                if ($status === 'delivered') {
                    $delivery->delivered_at =
                        $delivery->delivered_at ?? now();

                    // Save the exact public storage path.
                    $delivery->proof_photo = $photoPath;
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
        } catch (\Throwable $e) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            throw $e;
        }

        // Open live GPS tracking after starting the delivery.
        if ($status === 'out_for_delivery') {
            return redirect()->route(
                'rider.deliveries.live-tracking',
                ['delivery' => $delivery->id]
            )->with(
                'success',
                'Delivery started. Allow location access to share your live GPS location.'
            );
        }

        return redirect()
            ->route('rider.dashboard')
            ->with(
                'success',
                $status === 'delivered'
                    ? 'Delivery completed successfully. The proof photo has been saved.'
                    : 'Delivery status updated successfully.'
            );
    }

    /**
     * Confirm Cash on Delivery payment.
     */
    public function confirmPayment(Delivery $delivery)
    {
        abort_unless(
            (int) $delivery->rider_id === (int) auth()->id(),
            403
        );

        $order = $delivery->order;

        if (!$order) {
            return back()->with(
                'error',
                'No linked order was found for this delivery.'
            );
        }

        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'No payment record was found for this order.'
            );
        }

        $method = strtolower(trim(
            $payment->method ?? $order->payment_method ?? ''
        ));

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
                'This payment has already been confirmed.'
            );
        }

        if ($payment->status === 'failed') {
            return back()->with(
                'error',
                'This payment failed and cannot be confirmed.'
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
            'Cash on Delivery payment confirmed successfully.'
        );
    }
}
