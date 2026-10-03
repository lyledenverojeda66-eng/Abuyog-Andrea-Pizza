<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Abuyog Andrea Pizza</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff8ee;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 470px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo .top {
            color: #15803d;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .logo .bottom {
            color: #16a34a;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 5px;
        }

        .register-card {
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
            border-top: 5px solid #16a34a;
        }

        .register-card h1 {
            text-align: center;
            color: #166534;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px #dcfce7;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .register-btn {
            width: 100%;
            border: none;
            background: #16a34a;
            color: white;
            padding: 14px;
            border-radius: 9px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 5px;
        }

        .register-btn:hover {
            background: #15803d;
        }

        .login-link {
            text-align: center;
            margin-top: 22px;
            color: #666;
        }

        .login-link a {
            color: #15803d;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #16a34a;
            text-decoration: none;
            font-weight: bold;
        }

        .back-home:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .register-card {
                padding: 25px 20px;
            }

            .logo .top {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="register-container">

    <div class="logo">
        <div class="top">ABUYOG ANDREA</div>
        <div class="bottom">PIZZA</div>
    </div>

    <div class="register-card">

        <h1>Create Account</h1>

        <p class="subtitle">
            Sign up and start ordering your favorite pizza
        </p>

        @if($errors->any())
            <div class="error">
                <ul style="margin-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm your password"
                    required
                >
            </div>

            <button type="submit" class="register-btn">
                Create Account
            </button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </div>

    </div>

    <a href="{{ route('home') }}" class="back-home">
        ← Back to Home
    </a>

</div>

</body>
</html>