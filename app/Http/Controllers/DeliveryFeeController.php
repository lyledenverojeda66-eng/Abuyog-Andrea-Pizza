<?php

namespace App\Http\Controllers;

use App\Services\DeliveryFeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    public function quote(
        Request $request,
        DeliveryFeeService $deliveryFeeService
    ): JsonResponse {
        $validated = $request->validate([
            'address' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        $quote = $deliveryFeeService->quote($validated['address']);

        return response()->json($quote);
    }
}
