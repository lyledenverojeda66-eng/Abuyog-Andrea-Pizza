<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display all approved customer reviews.
     *
     * GET /reviews
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')
            ->where('status', 'approved')
            ->where('type', 'feedback')
            ->whereNotNull('rating')
            ->latest()
            ->paginate(12);

        return view('reviews.index', compact('feedbacks'));
    }

    /**
     * Store customer feedback or concern.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login first before sending feedback or concern.'
                );
        }

        $validated = $request->validate([
            'order_id' => [
                'nullable',
                'integer',
                'exists:orders,id',
            ],
            'rating' => [
                'nullable',
                'integer',
                'min:1',
                'max:5',
            ],
            'type' => [
                'required',
                'in:feedback,concern',
            ],
            'concern' => [
                'nullable',
                'string',
                'max:100',
            ],
            'message' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        // Check selected order belongs to the logged-in user.
        $order = null;

        if (!empty($validated['order_id'])) {
            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Invalid order selected.'
                    );
            }

            // Feedback is allowed only after delivery.
            if (
                $validated['type'] === 'feedback' &&
                $order->status !== 'delivered'
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'You can only give feedback after your order has been delivered.'
                    );
            }

            // Prevent duplicate feedback for the same order.
            if ($validated['type'] === 'feedback') {
                $existingFeedback = Feedback::where(
                    'user_id',
                    Auth::id()
                )
                    ->where('order_id', $order->id)
                    ->where('type', 'feedback')
                    ->first();

                if ($existingFeedback) {
                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'You have already submitted feedback for this order.'
                        );
                }
            }
        }

        // Validate rating for feedback.
        $rating = null;

        if ($validated['type'] === 'feedback') {
            if (empty($validated['rating'])) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please select a rating from 1 to 5 stars.'
                    );
            }

            $rating = (int) $validated['rating'];
        }

        // Validate concern category for concerns.
        $concern = null;

        if ($validated['type'] === 'concern') {
            if (empty($validated['concern'])) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please select the type of concern.'
                    );
            }

            $concern = $validated['concern'];
        }

        // Save feedback or concern.
        Feedback::create([
            'user_id' => Auth::id(),
            'order_id' => $validated['order_id'] ?? null,
            'rating' => $rating,
            'message' => $validated['message'],
            'concern' => $concern,
            'type' => $validated['type'],
            'status' => 'pending',
            'admin_reply' => null,
        ]);

        if ($validated['type'] === 'concern') {
            return back()->with(
                'success',
                'Your concern has been sent to the admin successfully!'
            );
        }

        return back()->with(
            'success',
            'Thank you! Your feedback has been submitted and is waiting for approval.'
        );
    }

    /**
     * Store general customer feedback.
     *
     * POST /customer/feedback/general
     */
    public function storeGeneral(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login first before sending feedback.'
                );
        }

        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'message' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'order_id' => null,
            'type' => 'feedback',
            'rating' => (int) $validated['rating'],
            'message' => $validated['message'],
            'concern' => null,
            'status' => 'pending',
            'admin_reply' => null,
        ]);

        return back()->with(
            'success',
            'Thank you! Your feedback has been submitted and is waiting for admin approval.'
        );
    }
}