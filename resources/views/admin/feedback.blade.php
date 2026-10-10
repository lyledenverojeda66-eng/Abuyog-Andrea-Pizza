@extends('admin.layout')

@section('title', 'Customer Feedback')

@section('content')

<style>
    .feedback-page {
        width: 100%;
    }

    .feedback-page .page-header {
        margin-bottom: 20px;
    }

    .feedback-page .page-header h1 {
        margin: 0 0 6px;
        line-height: 1.4;
    }

    .feedback-page .page-header p {
        margin: 0;
        color: #6b7280;
        line-height: 1.5;
    }

    .feedback-card {
        width: 100%;
    }

    .feedback-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .feedback-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .feedback-table th {
        padding: 13px 15px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;

        color: #374151;
        font-size: 12px;
        font-weight: 800;

        text-align: left;
        line-height: 1.4;
        white-space: nowrap;
    }

    .feedback-table td {
        padding: 14px 15px;

        border-bottom: 1px solid #f1f5f9;

        color: #374151;
        font-size: 13px;

        line-height: 1.5;
        vertical-align: middle;
    }

    .feedback-table tbody tr:hover {
        background: #fafafa;
    }

    .feedback-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .feedback-customer {
        color: #111827;
        font-weight: 700;
        white-space: nowrap;
    }

    .feedback-email {
        margin-top: 3px;
        color: #6b7280;
        font-size: 11px;
        white-space: nowrap;
    }

    .feedback-order {
        color: #15803d;
        font-weight: 800;
        white-space: nowrap;
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

    .feedback-type.feedback {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-type.concern {
        background: #fee2e2;
        color: #991b1b;
    }

    .feedback-rating {
        color: #d97706;
        font-weight: 800;
        white-space: nowrap;
    }

    .feedback-message {
        max-width: 300px;
        color: #374151;
        line-height: 1.55;
    }

    .feedback-concern {
        max-width: 250px;
        color: #6b7280;
        line-height: 1.55;
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

    .feedback-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .feedback-status.approved {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-status.rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .feedback-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .feedback-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 34px;
        padding: 7px 11px;

        border: 0;
        border-radius: 7px;

        font-family: inherit;
        font-size: 11px;
        font-weight: 800;

        line-height: 1.4;

        cursor: pointer;
        text-decoration: none;

        white-space: nowrap;
    }

    .feedback-button:hover {
        text-decoration: none;
    }

    .feedback-approve {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-approve:hover {
        background: #bbf7d0;
        color: #14532d;
    }

    .feedback-reject {
        background: #fee2e2;
        color: #991b1b;
    }

    .feedback-reject:hover {
        background: #fecaca;
        color: #7f1d1d;
    }

    .feedback-view {
        background: #f0fdf4;
        color: #15803d;
    }

    .feedback-view:hover {
        background: #dcfce7;
        color: #166534;
    }

    .feedback-reply {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .feedback-reply:hover {
        background: #dbeafe;
        color: #1e40af;
    }

    .feedback-empty {
        padding: 40px 20px !important;
        color: #6b7280 !important;
        text-align: center !important;
    }

    .feedback-date {
        color: #6b7280;
        font-size: 12px;
        white-space: nowrap;
    }

    .feedback-replied {
        margin-top: 5px;
        color: #15803d;
        font-size: 10px;
        font-weight: 800;
    }

    @media (max-width: 700px) {
        .feedback-table {
            min-width: 950px;
        }
    }
</style>


<div class="feedback-page">

    <!-- PAGE HEADER -->

    <div class="page-header">

        <div>

            <h1>
                💬 Customer Feedback
            </h1>

            <p>
                Review, approve, reject, and reply to customer feedback and concerns.
            </p>

        </div>

    </div>


    <!-- FEEDBACK TABLE -->

    <div class="card feedback-card">

        <div class="feedback-table-wrapper">

            <table class="feedback-table">

                <thead>

                    <tr>

                        <th>
                            Customer
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Rating
                        </th>

                        <th>
                            Message
                        </th>

                        <th>
                            Concern
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($feedbacks as $feedback)

                        <tr>

                            <!-- CUSTOMER -->

                            <td>

                                <div class="feedback-customer">
                                    {{ $feedback->user->name ?? 'Customer' }}
                                </div>

                                @if($feedback->user && $feedback->user->email)

                                    <div class="feedback-email">
                                        {{ $feedback->user->email }}
                                    </div>

                                @endif

                            </td>


                            <!-- ORDER -->

                            <td>

                                @if($feedback->order)

                                    <span class="feedback-order">
                                        {{ $feedback->order->order_number }}
                                    </span>

                                @else

                                    <span>
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- TYPE -->

                            <td>

                                @if($feedback->type === 'concern')

                                    <span class="feedback-type concern">
                                        ⚠️ Concern
                                    </span>

                                @else

                                    <span class="feedback-type feedback">
                                        💬 Feedback
                                    </span>

                                @endif

                            </td>


                            <!-- RATING -->

                            <td>

                                @if($feedback->rating)

                                    <span class="feedback-rating">

                                        {{ str_repeat('⭐', (int) $feedback->rating) }}

                                        <br>

                                        {{ $feedback->rating }}/5

                                    </span>

                                @else

                                    <span>
                                        —
                                    </span>

                                @endif

                            </td>


                            <!-- MESSAGE -->

                            <td>

                                <div class="feedback-message">

                                    @if($feedback->message)

                                        {{ $feedback->message }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </td>


                            <!-- CONCERN -->

                            <td>

                                <div class="feedback-concern">

                                    @if($feedback->concern)

                                        {{ $feedback->concern }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </td>


                            <!-- STATUS -->

                            <td>

                                @if($feedback->status === 'approved')

                                    <span class="feedback-status approved">
                                        Approved
                                    </span>

                                @elseif($feedback->status === 'rejected')

                                    <span class="feedback-status rejected">
                                        Rejected
                                    </span>

                                @else

                                    <span class="feedback-status pending">
                                        Pending
                                    </span>

                                @endif


                                @if($feedback->admin_reply)

                                    <div class="feedback-replied">
                                        ✓ Replied
                                    </div>

                                @endif

                            </td>


                            <!-- DATE -->

                            <td>

                                <span class="feedback-date">

                                    {{ $feedback->created_at->format('M d, Y') }}

                                    <br>

                                    {{ $feedback->created_at->format('h:i A') }}

                                </span>

                            </td>


                            <!-- ACTIONS -->

                            <td>

                                <div class="feedback-actions">


                                    <!-- VIEW -->

                                    <a
                                        href="{{ route('admin.feedback.show', $feedback->id) }}"
                                        class="feedback-button feedback-view"
                                    >
                                        👁 View
                                    </a>


                                    <!-- APPROVE -->

                                    @if($feedback->status === 'pending')

                                        <form
                                            action="{{ route('admin.feedback.approve', $feedback->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                        >
    @csrf
    @method('PUT')

                                            @csrf

                                            <button
                                                type="submit"
                                                class="feedback-button feedback-approve"
                                                onclick="return confirm('Approve this feedback?');"
                                            >
                                                ✓ Approve
                                            </button>

                                        </form>


                                        <!-- REJECT -->

                                        <form
                                            action="{{ route('admin.feedback.reject', $feedback->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="feedback-button feedback-reject"
                                                onclick="return confirm('Reject this feedback?');"
                                            >
                                                ✕ Reject
                                            </button>

                                        </form>

                                    @endif


                                    <!-- REPLY -->

                                    <a
                                        href="{{ route('admin.feedback.show', $feedback->id) }}"
                                        class="feedback-button feedback-reply"
                                    >
                                        💬 Reply
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="feedback-empty"
                            >
                                No customer feedback or concerns found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


