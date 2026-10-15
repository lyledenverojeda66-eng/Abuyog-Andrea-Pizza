<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    /**
     * Public page: approved customer reviews only.
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
     * Save feedback or concern.
     */
    public function store(Request $request)
    {
        return $this->saveFeedback($request);
    }

    /**
     * Save feedback submitted from the homepage.
     */
    public function storeGeneral(Request $request)
    {
        return $this->saveFeedback($request);
    }

    /**
     * Validate and save customer feedback or concern.
     */
    private function saveFeedback(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login first before sending feedback or concern.');
        }

        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(['feedback', 'concern']),
            ],
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
            'concern' => [
                'nullable',
                'string',
                'max:100',
            ],
           'message' => [
    'nullable',
    'string',
    'max:1000',
],
        ]);

        $userId = Auth::id();
        $order = null;
        $rating = null;
        $concern = null;
        $orderId = null;

        /*
         * FEEDBACK:
         * Must be connected to the logged-in customer's
         * delivered order, and only one feedback per order.
         */
        if ($validated['type'] === 'feedback') {
            if (empty($validated['order_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Please select a delivered order before submitting feedback.');
            }

            if (empty($validated['rating'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Please select a rating from 1 to 5 stars.');
            }

            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', $userId)
                ->first();

            if (!$order) {
                return back()
                    ->withInput()
                    ->with('error', 'The selected order does not belong to your account.');
            }

            if ($order->status !== 'delivered') {
                return back()
                    ->withInput()
                    ->with('error', 'You can only review an order after it has been delivered.');
            }

            $alreadyReviewed = Feedback::where('user_id', $userId)
                ->where('order_id', $order->id)
                ->where('type', 'feedback')
                ->exists();

            if ($alreadyReviewed) {
                return back()
                    ->withInput()
                    ->with('error', 'You have already submitted feedback for this order.');
            }

            $orderId = $order->id;
            $rating = (int) $validated['rating'];
        }

        /*
         * CONCERN:
         * A concern does not require a rating or a delivered order.
         */
        if ($validated['type'] === 'concern') {
            if (empty($validated['concern'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Please select the type of concern.');
            }

            $concern = $validated['concern'];

            // Optionally link a concern to the customer's own order.
            if (!empty($validated['order_id'])) {
                $customerOrder = Order::where('id', $validated['order_id'])
                    ->where('user_id', $userId)
                    ->first();

                if (!$customerOrder) {
                    return back()
                        ->withInput()
                        ->with('error', 'The selected order does not belong to your account.');
                }

                $orderId = $customerOrder->id;
            }
        }

        Feedback::create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'type' => $validated['type'],
            'rating' => $rating,
            'concern' => $concern,
           'message' => $validated['message'] ?? '',
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
            'Thank you! Your feedback has been submitted and is waiting for admin approval.'
        );
    }
}