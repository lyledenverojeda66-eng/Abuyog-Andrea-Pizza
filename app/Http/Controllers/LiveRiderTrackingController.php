<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class LiveRiderTrackingController extends Controller
{
    /**
     * Customer live tracking page.
     */
    public function show($orderId)
    {
        $order = auth()->user()
            ->orders()
            ->with('delivery.rider')
            ->findOrFail($orderId);

        return view('orders.live-tracking', compact('order'));
    }

    /**
     * Customer endpoint for retrieving the rider's latest location.
     */
    public function location($orderId)
    {
        $order = auth()->user()
            ->orders()
            ->with('delivery.rider')
            ->findOrFail($orderId);

        $delivery = $order->delivery;

        if (
            !$delivery ||
            $delivery->status !== 'out_for_delivery' ||
            $delivery->rider_latitude === null ||
            $delivery->rider_longitude === null
        ) {
            return response()->json([
                'available' => false,
                'message' => 'Waiting for the rider location.',
            ]);
        }

        return response()->json([
            'available' => true,
            'latitude' => (float) $delivery->rider_latitude,
            'longitude' => (float) $delivery->rider_longitude,
            'updated_at' => $delivery->rider_location_updated_at,
            'rider_name' => $delivery->rider_name
                ?: $delivery->rider?->name
                ?: 'Assigned Rider',
        ]);
    }

    /**
     * Rider GPS sharing page.
     */
    public function riderPage(Delivery $delivery)
    {
        abort_unless(
            (int) $delivery->rider_id === (int) auth()->id(),
            403
        );

        abort_unless(
            in_array($delivery->status, ['picked_up', 'out_for_delivery'], true),
            403,
            'GPS sharing is available only during delivery.'
        );

        return view('rider.live-tracking', compact('delivery'));
    }

    /**
     * Save rider GPS coordinates.
     */
    public function updateLocation(Request $request, Delivery $delivery)
    {
        abort_unless(
            (int) $delivery->rider_id === (int) auth()->id(),
            403
        );

        abort_unless(
            in_array($delivery->status, ['picked_up', 'out_for_delivery'], true),
            403,
            'GPS sharing is available only during delivery.'
        );

        $validated = $request->validate([
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
        ]);

        $delivery->rider_latitude = $validated['latitude'];
        $delivery->rider_longitude = $validated['longitude'];
        $delivery->rider_location_updated_at = now();
        $delivery->save();

        return response()->json([
            'success' => true,
            'updated_at' => $delivery->rider_location_updated_at,
        ]);
    }
}