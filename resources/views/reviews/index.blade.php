
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ratings & Reviews | Abuyog Andrea Pizza</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f6f8f4;
            color: #243326;
        }

        .reviews-container {
            width: 90%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #26743b;
            text-decoration: none;
            font-weight: bold;
        }

        .page-heading {
            margin-bottom: 8px;
        }

        .page-description {
            color: #6b716b;
            margin-bottom: 25px;
        }

        .review-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .review-card {
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        }

        .review-name {
            font-weight: bold;
            font-size: 16px;
        }

        .review-stars {
            color: #f5a623;
            font-size: 21px;
            margin: 8px 0;
        }

        .review-date {
            color: #858585;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .review-message {
            line-height: 1.6;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .review-reply {
            margin-top: 15px;
            padding: 12px;
            background: #edf7ee;
            border-radius: 8px;
            line-height: 1.5;
        }

        .empty-reviews {
            padding: 30px;
            text-align: center;
            background: white;
            border-radius: 12px;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            .reviews-container {
                width: 92%;
                margin: 25px auto;
            }

            .review-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <main class="reviews-container">

        <a href="{{ route('home') }}" class="back-link">
            ← Back to Home
        </a>

        <h1 class="page-heading">⭐ Ratings & Reviews</h1>

        <p class="page-description">
            Read approved customer feedback about Abuyog Andrea Pizza.
        </p>

        @if($feedbacks->count() > 0)

            <div class="review-grid">

                @foreach($feedbacks as $feedback)

                    <article class="review-card">

                        <div class="review-name">
                            {{ optional($feedback->user)->name ?? 'Customer' }}
                        </div>

                        <div class="review-stars" aria-label="{{ $feedback->rating }} out of 5 stars">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= (int) $feedback->rating ? '★' : '☆' }}
                            @endfor
                        </div>

                        <div class="review-date">
                            {{ $feedback->created_at?->format('M d, Y') }}
                        </div>

                        <div class="review-message">
                            {{ $feedback->message }}
                        </div>

                        @if($feedback->admin_reply)
                            <div class="review-reply">
                                <strong>Admin Reply:</strong>
                                {{ $feedback->admin_reply }}
                            </div>
                        @endif

                    </article>

                @endforeach

            </div>

            <div class="pagination">
                {{ $feedbacks->links() }}
            </div>

        @else

            <div class="empty-reviews">
                ⭐ No approved reviews yet.
            </div>

        @endif

    </main>

</body>
</html>