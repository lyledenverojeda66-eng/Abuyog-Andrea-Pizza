<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Feedback Details</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: #111;
            color: white;
            padding: 15px 30px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            margin-bottom: 20px;
        }

        .stars {
            color: #f5a623;
            font-size: 25px;
        }

        .label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        .message {
            background: #f7f7f7;
            padding: 15px;
            border-radius: 7px;
            margin-top: 5px;
        }

        textarea {
            width: 100%;
            min-height: 130px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .reply {
            background: #198754;
            color: white;
        }

        .approve {
            background: #0d6efd;
            color: white;
        }

        .reject {
            background: #dc3545;
            color: white;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="navbar">

    <a href="{{ route('admin.dashboard') }}">
        Dashboard
    </a>

    <a href="{{ route('admin.feedback') }}">
        Customer Feedback
    </a>

</div>

<div class="container">

    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card">

        <h2>
            Customer Feedback
        </h2>

        <p>
            <strong>Customer:</strong>
            {{ $feedback->user->name ?? 'Customer' }}
        </p>

        @if($feedback->order)

            <p>
                <strong>Order:</strong>
                #{{ $feedback->order->order_number }}
            </p>

        @endif

        <p>
            <strong>Type:</strong>
            {{ ucfirst($feedback->type) }}
        </p>

        <p>
            <strong>Rating:</strong>
        </p>

        <div class="stars">

            @for($i = 1; $i <= 5; $i++)

                {{ $i <= $feedback->rating ? '★' : '☆' }}

            @endfor

        </div>

        <span class="label">
            Customer Message
        </span>

        <div class="message">

            @if($feedback->message)

                {{ $feedback->message }}

            @elseif($feedback->concern)

                {{ $feedback->concern }}

            @else

                No message.

            @endif

        </div>

        <p>

            <strong>Status:</strong>
            {{ ucfirst($feedback->status) }}

        </p>

    </div>


    @if($feedback->status !== 'approved')

        <div class="card">

            <h3>
                Approve Feedback
            </h3>

            <form
                action="{{ route('admin.feedback.approve', $feedback->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <button
                    type="submit"
                    class="btn approve"
                >
                    Approve & Publish
                </button>

            </form>

        </div>

    @endif


    @if($feedback->status !== 'rejected')

        <div class="card">

            <h3>
                Reject Feedback
            </h3>

            <form
                action="{{ route('admin.feedback.reject', $feedback->id) }}"
                method="POST"
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

        </div>

    @endif


    <div class="card">

        <h3>
            Admin Reply
        </h3>

        <form
            action="{{ route('admin.feedback.reply', $feedback->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <textarea
                name="admin_reply"
                placeholder="Write your reply to the customer..."
            >{{ old('admin_reply', $feedback->admin_reply) }}</textarea>

            @error('admin_reply')

                <p style="color:red;">
                    {{ $message }}
                </p>

            @enderror

            <button
                type="submit"
                class="btn reply"
            >
                Save Admin Reply
            </button>

        </form>

    </div>

</div>

</body>

</html>