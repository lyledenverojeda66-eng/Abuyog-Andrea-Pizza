<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Feedback</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .navbar {
            background: #111;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 18px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .table-box {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #111;
            color: white;
        }

        .stars {
            color: #f5a623;
            font-size: 18px;
            white-space: nowrap;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .approved {
            background: #d4edda;
            color: #155724;
        }

        .rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .btn {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            margin: 2px;
        }

        .view {
            background: #222;
            color: white;
        }

        .approve {
            background: #198754;
            color: white;
        }

        .reject {
            background: #dc3545;
            color: white;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>ABUYOG ANDREA PIZZA - ADMIN</strong>

    <div>
        <a href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>

        <a href="{{ route('admin.feedback') }}">
            Feedback
        </a>
    </div>
</div>

<div class="container">

    <h1>Customer Feedback & Concerns</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-box">

        @if($feedbacks->count())

            <table>

                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Rating</th>
                        <th>Message / Concern</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($feedbacks as $feedback)

                    <tr>

                        <td>
                            <strong>
                                {{ $feedback->user->name ?? 'Customer' }}
                            </strong>

                            <br>

                            <small>
                                {{ $feedback->created_at->format('M d, Y') }}
                            </small>
                        </td>

                        <td>
                            {{ ucfirst($feedback->type) }}
                        </td>

                        <td>
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $feedback->rating ? '★' : '☆' }}
                                @endfor
                            </span>
                        </td>

                        <td>

                            @if($feedback->message)
                                {{ $feedback->message }}
                            @elseif($feedback->concern)
                                {{ $feedback->concern }}
                            @else
                                —
                            @endif

                        </td>

                        <td>

                            <span class="status {{ $feedback->status }}">
                                {{ ucfirst($feedback->status) }}
                            </span>

                        </td>

                        <td>

                            <a
                                href="{{ route('admin.feedback.show', $feedback->id) }}"
                                class="btn view"
                            >
                                View
                            </a>

                            @if($feedback->status !== 'approved')

                                <form
                                    action="{{ route('admin.feedback.approve', $feedback->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="btn approve"
                                    >
                                        Approve
                                    </button>
                                </form>

                            @endif

                            @if($feedback->status !== 'rejected')

                                <form
                                    action="{{ route('admin.feedback.reject', $feedback->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="btn reject"
                                    >
                                        Reject
                                    </button>
                                </form>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">
                No customer feedback yet.
            </div>

        @endif

    </div>

</div>

</body>
</html>