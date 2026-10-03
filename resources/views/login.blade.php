<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Abuyog Andrea Pizza</title>

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

        .login-container {
            width: 100%;
            max-width: 430px;
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

        .login-card {
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.10);
            border-top: 5px solid #16a34a;
        }

        .login-card h1 {
            text-align: center;
            color: #166534;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .login-card .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
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

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .login-btn {
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
        }

        .login-btn:hover {
            background: #15803d;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            color: #666;
        }

        .register-link a {
            color: #15803d;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
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
            .login-card {
                padding: 25px 20px;
            }

            .logo .top {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="logo">
        <div class="top">ABUYOG ANDREA</div>
        <div class="bottom">PIZZA</div>
    </div>

    <div class="login-card">

        <h1>Welcome Back!</h1>

        <p class="subtitle">
            Login to your Abuyog Andrea Pizza account
        </p>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                <ul style="margin-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

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
                    placeholder="Enter your password"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>
        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Sign Up</a>
        </div>

    </div>

    <a href="{{ route('home') }}" class="back-home">
        ← Back to Home
    </a>

</div>

</body>
</html>