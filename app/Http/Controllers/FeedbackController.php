<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => [
                'nullable',
                'integer',
                'exists:orders,id',
            ],

            'type' => [
                'required',
                'in:feedback,concern',
            ],

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'message' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'concern' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $orderId = null;

        /*
        |--------------------------------------------------------------------------
        | Check selected order
        |--------------------------------------------------------------------------
        */
        if (!empty($validated['order_id'])) {

            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return back()
                    ->with('error', 'Invalid order selected.')
                    ->withInput();
            }

            if ($order->status !== 'delivered') {
                return back()
                    ->with(
                        'error',
                        'You can only submit feedback for delivered orders.'
                    )
                    ->withInput();
            }

            $orderId = $order->id;

            $existingFeedback = Feedback::where('user_id', Auth::id())
                ->where('order_id', $order->id)
                ->exists();

            if ($existingFeedback) {
                return back()
                    ->with(
                        'error',
                        'You have already submitted feedback for this order.'
                    )
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Require message or concern
        |--------------------------------------------------------------------------
        */
        if (
            empty($validated['message']) &&
            empty($validated['concern'])
        ) {
            return back()
                ->with(
                    'error',
                    'Please tell us about your experience or concern.'
                )
                ->withInput();
        }

        $message = $validated['message'] ?? null;
        $concern = $validated['concern'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | If type is concern, save message as concern
        |--------------------------------------------------------------------------
        */
        if (
            $validated['type'] === 'concern' &&
            empty($concern) &&
            !empty($message)
        ) {
            $concern = $message;
            $message = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Create feedback
        |--------------------------------------------------------------------------
        */
        Feedback::create([
            'user_id' => Auth::id(),
            'order_id' => $orderId,
            'type' => $validated['type'],
            'rating' => $validated['rating'],
            'message' => $message,
            'concern' => $concern,
            'status' => 'pending',
            'admin_reply' => null,
        ]);

        return back()->with(
            'feedback_success',
            'Thank you! Your feedback has been submitted and is waiting for admin review.'
        );
    }
}