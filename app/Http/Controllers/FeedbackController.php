<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * Detect profanity and abusive language.
     */
    private function containsInappropriateLanguage(string $message): bool
    {
        $normalized = mb_strtolower($message, 'UTF-8');

        // Treat punctuation between words as spaces.
        $normalized = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $normalized);
        $normalized = trim($normalized);

        $blockedWords = [
            // English profanity and insults
            'fuck',
            'fucking',
            'fucker',
            'shit',
            'bitch',
            'bastard',
            'asshole',
            'motherfucker',
            'dickhead',
            'dumbass',

            // Filipino profanity and abusive insults
            'putang ina',
            'putangina',
            'tangina',
            'tang ina',
            'pakyu',
            'pucha',
            'punyeta',
            'gago',
            'gaga',
            'tanga',
            'tarantado',
            'ulol',
            'leche',
            'lintik',
            'inutil',
            'bwisit',
        ];

        foreach ($blockedWords as $word) {
            $pattern = '/(?<![\p{L}\p{N}])'
                . preg_quote($word, '/')
                . '(?![\p{L}\p{N}])/u';

            if (preg_match($pattern, $normalized)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Record a violation. Ban the account on the second violation.
     */
    private function recordFeedbackViolation(): int
    {
        return DB::transaction(function () {
            $customer = User::whereKey(Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($customer->banned_at !== null) {
                return 2;
            }

            $violations = min(
                2,
                (int) $customer->feedback_violations + 1
            );

            $customer->forceFill([
                'feedback_violations' => $violations,
                'banned_at' => $violations >= 2
                    ? now()
                    : null,
            ])->save();

            return $violations;
        });
    }

    /**
     * Validate and save customer feedback or concern.
     */
    private function saveFeedback(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login first before sending feedback or concern.'
                );
        }

        $customer = User::find(Auth::id());

        if (!$customer) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'Please login again to continue.');
        }

        if ($customer->banned_at !== null) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Your account is suspended due to repeated violations of our feedback guidelines. Please contact the administrator.'
                );
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

        /*
         * Check the written message before saving it.
         * A violation is counted only when inappropriate
         * language is detected.
         */
        $message = trim($validated['message'] ?? '');

        if (
            $message !== ''
            && $this->containsInappropriateLanguage($message)
        ) {
            $violations = $this->recordFeedbackViolation();

            if ($violations >= 2) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Your account has been suspended after a second violation of our feedback guidelines. Please contact the administrator if you believe this action was made in error.'
                    );
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Warning: Your message contains inappropriate language. Please remove bad words, profanity, or abusive language before submitting. One more violation will result in account suspension.'
                );
        }

        $userId = Auth::id();
        $order = null;
        $rating = null;
        $concern = null;
        $orderId = null;

        /*
         * FEEDBACK:
         * Must belong to the logged-in customer,
         * be delivered, and have only one review per order.
         */
        if ($validated['type'] === 'feedback') {
            if (empty($validated['order_id'])) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please select a delivered order before submitting feedback.'
                    );
            }

            if (empty($validated['rating'])) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please select a rating from 1 to 5 stars.'
                    );
            }

            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', $userId)
                ->first();

            if (!$order) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'The selected order does not belong to your account.'
                    );
            }

            if ($order->status !== 'delivered') {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'You can only review an order after it has been delivered.'
                    );
            }

            $alreadyReviewed = Feedback::where('user_id', $userId)
                ->where('order_id', $order->id)
                ->where('type', 'feedback')
                ->exists();

            if ($alreadyReviewed) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'You have already submitted feedback for this order.'
                    );
            }

            $orderId = $order->id;
            $rating = (int) $validated['rating'];
        }

        /*
         * CONCERN:
         * A concern does not require a rating or delivered order.
         */
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

            if (!empty($validated['order_id'])) {
                $customerOrder = Order::where('id', $validated['order_id'])
                    ->where('user_id', $userId)
                    ->first();

                if (!$customerOrder) {
                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'The selected order does not belong to your account.'
                        );
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
            'message' => $message,
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