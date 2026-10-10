@extends('admin.layout')

@section('title', 'Feedback Details')

@section('content')

<style>
    .feedback-show-page {
        width: 100%;
    }

    .feedback-show-page .page-header {
        margin-bottom: 20px;
    }

    .feedback-show-page .page-header h1 {
        margin: 0 0 6px;
        line-height: 1.4;
    }

    .feedback-show-page .page-header p {
        margin: 0;
        color: #6b7280;
        line-height: 1.5;
    }

    .feedback-show-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 20px;
        align-items: start;
    }

    .feedback-show-card {
        width: 100%;
    }

    .feedback-show-card h2 {
        margin: 0 0 18px;
        font-size: 18px;
        line-height: 1.4;
    }

    .feedback-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .feedback-info-item {
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafafa;
    }

    .feedback-info-label {
        margin-bottom: 6px;
        color: #6b7280;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.4;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .feedback-info-value {
        color: #111827;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.5;
        word-break: break-word;
    }

    .feedback-order-link {
        color: #15803d;
        text-decoration: none;
        font-weight: 800;
    }

    .feedback-order-link:hover {
        text-decoration: underline;
    }

    .feedback-type {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        line-height: 1.4;
        white-space: nowrap;
    }

    .feedback-type-feedback {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-type-concern {
        background: #fee2e2;
        color: #991b1b;
    }

    .feedback-rating {
        color: #d97706;
        font-weight: 800;
    }

    .feedback-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        line-height: 1.4;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .feedback-status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .feedback-status-approved {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .feedback-content-box {
        margin-top: 20px;
    }

    .feedback-content-label {
        margin-bottom: 7px;
        color: #374151;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.4;
    }

    .feedback-content {
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafafa;
        color: #374151;
        font-size: 13px;
        line-height: 1.65;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .feedback-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .action-card {
        width: 100%;
    }

    .action-card h2 {
        margin: 0 0 15px;
        font-size: 17px;
        line-height: 1.4;
    }

    .action-form {
        margin: 0 0 10px;
    }

    .action-form:last-child {
        margin-bottom: 0;
    }

    .action-button {
        width: 100%;
        min-height: 42px;
        padding: 10px 14px;

        border: 0;
        border-radius: 8px;

        font-family: inherit;
        font-size: 12px;
        font-weight: 800;

        line-height: 1.4;

        cursor: pointer;
    }

    .approve-button {
        background: #15803d;
        color: #fff;
    }

    .approve-button:hover {
        background: #166534;
    }

    .reject-button {
        background: #dc2626;
        color: #fff;
    }

    .reject-button:hover {
        background: #b91c1c;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 42px;
        padding: 10px 14px;

        border-radius: 8px;

        background: #f3f4f6;
        color: #374151;

        font-size: 12px;
        font-weight: 800;

        line-height: 1.4;
        text-decoration: none;
    }

    .back-button:hover {
        background: #e5e7eb;
        color: #111827;
        text-decoration: none;
    }

    .reply-form label {
        display: block;
        margin-bottom: 7px;

        color: #374151;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.4;
    }

    .reply-form textarea {
        width: 100%;
        min-height: 130px;
        padding: 11px 12px;

        border: 1px solid #d1d5db;
        border-radius: 8px;

        background: #fff;
        color: #111827;

        font-family: inherit;
        font-size: 13px;

        line-height: 1.5;

        resize: vertical;
        outline: none;
    }

    .reply-form textarea:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, .10);
    }

    .reply-submit {
        width: 100%;
        margin-top: 10px;
        min-height: 42px;
        padding: 10px 14px;

        border: 0;
        border-radius: 8px;

        background: #15803d;
        color: #fff;

        font-family: inherit;
        font-size: 12px;
        font-weight: 800;

        cursor: pointer;
    }

    .reply-submit:hover {
        background: #166534;
    }

    .existing-reply {
        margin-top: 20px;
    }

    .existing-reply-box {
        padding: 14px;

        border: 1px solid #bbf7d0;
        border-radius: 10px;

        background: #f0fdf4;

        color: #166534;
        font-size: 13px;

        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .danger-note {
        margin-top: 12px;
        padding: 11px 12px;

        border-radius: 8px;

        background: #fff7ed;
        color: #9a3412;

        font-size: 11px;
        line-height: 1.5;
    }

    @media (max-width: 900px) {
        .feedback-show-grid {
            grid-template-columns: 1fr;
        }

        .feedback-sidebar {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .feedback-info-grid {
            grid-template-columns: 1fr;
        }

        .feedback-sidebar {
            display: flex;
        }
    }
</style>


<div class="feedback-show-page">

    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h1>
                💬 Feedback Details
            </h1>

            <p>
                Review the customer's feedback or concern.
            </p>

        </div>

    </div>


    <div class="feedback-show-grid">


        <!-- =========================
             MAIN INFORMATION
        ========================== -->

        <div class="card feedback-show-card">

            <h2>
                Customer Feedback
            </h2>


            <div class="feedback-info-grid">


                <!-- CUSTOMER -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Customer
                    </div>

                    <div class="feedback-info-value">

                        {{ $feedback->user->name ?? 'Customer' }}

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Email
                    </div>

                    <div class="feedback-info-value">

                        {{ $feedback->user->email ?? '—' }}

                    </div>

                </div>


                <!-- ORDER -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Order
                    </div>

                    <div class="feedback-info-value">

                        @if($feedback->order)

                            <span class="feedback-order-link">
                                {{ $feedback->order->order_number }}
                            </span>

                        @else

                            —

                        @endif

                    </div>

                </div>


                <!-- TYPE -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Type
                    </div>

                    <div class="feedback-info-value">

                        @if($feedback->type === 'concern')

                            <span class="feedback-type feedback-type-concern">
                                ⚠️ Concern
                            </span>

                        @else

                            <span class="feedback-type feedback-type-feedback">
                                💬 Feedback
                            </span>

                        @endif

                    </div>

                </div>


                <!-- RATING -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Rating
                    </div>

                    <div class="feedback-info-value">

                        @if($feedback->rating)

                            <span class="feedback-rating">
                                {{ str_repeat('⭐', (int) $feedback->rating) }}
                                {{ $feedback->rating }}/5
                            </span>

                        @else

                            —

                        @endif

                    </div>

                </div>


                <!-- STATUS -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Status
                    </div>

                    <div class="feedback-info-value">

                        @if($feedback->status === 'approved')

                            <span class="feedback-status feedback-status-approved">
                                Approved
                            </span>

                        @elseif($feedback->status === 'rejected')

                            <span class="feedback-status feedback-status-rejected">
                                Rejected
                            </span>

                        @else

                            <span class="feedback-status feedback-status-pending">
                                Pending
                            </span>

                        @endif

                    </div>

                </div>


                <!-- DATE -->

                <div class="feedback-info-item">

                    <div class="feedback-info-label">
                        Submitted
                    </div>

                    <div class="feedback-info-value">

                        {{ $feedback->created_at->format('M d, Y h:i A') }}

                    </div>

                </div>

            </div>


            <!-- MESSAGE -->

            <div class="feedback-content-box">

                <div class="feedback-content-label">
                    Customer Message
                </div>

                <div class="feedback-content">

                    {{ $feedback->message ?: 'No message provided.' }}

                </div>

            </div>


            <!-- CONCERN -->

            @if($feedback->concern)

                <div class="feedback-content-box">

                    <div class="feedback-content-label">
                        Concern
                    </div>

                    <div class="feedback-content">

                        {{ $feedback->concern }}

                    </div>

                </div>

            @endif


            <!-- EXISTING ADMIN REPLY -->

            @if($feedback->admin_reply)

                <div class="existing-reply">

                    <div class="feedback-content-label">
                        Admin Reply
                    </div>

                    <div class="existing-reply-box">

                        {{ $feedback->admin_reply }}

                    </div>

                </div>

            @endif

        </div>


        <!-- =========================
             SIDEBAR
        ========================== -->

        <div class="feedback-sidebar">


            <!-- ACTIONS -->

            <div class="card action-card">

                <h2>
                    ⚙️ Actions
                </h2>


                <!-- APPROVE -->

                @if($feedback->status !== 'approved')

                    <form
                        action="{{ route('admin.feedback.approve', $feedback->id) }}"
                        method="POST"
                        class="action-form"
                    >
    @csrf
    @method('PUT')

                        @csrf

                        <button
                            type="submit"
                            class="action-button approve-button"
                            onclick="return confirm('Approve and publish this feedback?');"
                        >
                            ✓ Approve & Publish
                        </button>

                    </form>

                @endif


                <!-- REJECT -->

                @if($feedback->status !== 'rejected')

                    <form
                        action="{{ route('admin.feedback.reject', $feedback->id) }}"
                        method="POST"
                        class="action-form"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="action-button reject-button"
                            onclick="return confirm('Reject this feedback?');"
                        >
                            ✕ Reject Feedback
                        </button>

                    </form>

                @endif


                <!-- BACK -->

                <a
                    href="{{ route('admin.feedback') }}"
                    class="back-button"
                >
                    ← Back to Feedback
                </a>

            </div>


            <!-- ADMIN REPLY -->

            <div class="card action-card reply-form">

                <h2>
                    💬 Admin Reply
                </h2>


                <form
                    action="{{ route('admin.feedback.reply', $feedback->id) }}"
                    method="POST"
                >

                    @csrf

                    <label for="admin_reply">
                        Reply to Customer
                    </label>

                    <textarea
                        name="admin_reply"
                        id="admin_reply"
                        placeholder="Write your reply here..."
                        required
                    >{{ old('admin_reply', $feedback->admin_reply) }}</textarea>


                    <button
                        type="submit"
                        class="reply-submit"
                    >
                        💬 Save Reply
                    </button>

                </form>

            </div>


            <!-- NOTE -->

            @if($feedback->status === 'pending')

                <div class="danger-note">
                    ℹ️ This feedback is still pending approval.
                    Approve it to publish it on the customer homepage.
                </div>

            @endif


        </div>

    </div>

</div>

@endsection


