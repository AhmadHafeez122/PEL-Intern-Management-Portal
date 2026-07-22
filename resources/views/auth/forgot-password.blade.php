<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot Password - PEL</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
        }

        /* Official PEL Corporate Blue Gradient Background */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #005baa 0%, #003b73 100%);
            padding: 1rem;
        }

        /* Clean White Corporate Card */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 2.5rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: #333333;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.4rem;
        }

        /* Professional Light Inputs */
        input[type="email"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            color: #111827;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        input[type="email"]:focus {
            background: #ffffff;
            border-color: #005baa;
            box-shadow: 0 0 0 3px rgba(0, 91, 170, 0.15);
            outline: none;
        }

        input::placeholder {
            color: #9ca3af;
        }

        /* Solid Brand Button */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #005baa;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 0.5rem;
        }

        button[type="submit"]:hover {
            background: #004683;
        }

        /* Error Text */
        .error-text {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">

            <!-- Header section with Official Image Logo -->
            <div class="flex flex-col items-center justify-center mb-6">
                <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Official Logo" class="h-16 mb-4 object-contain">
                <h2 class="text-2xl font-poppins font-bold text-gray-900 tracking-tight text-center">Reset Password</h2>
            </div>

            <div class="mb-6 text-sm text-gray-500 leading-relaxed text-center">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <!-- Session Status (Shows success message when link is sent) -->
            @if (session('status'))
                <div class="mb-6 text-green-700 bg-green-50 border border-green-200 rounded-lg p-3 text-center text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required autofocus>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit">Email Password Reset Link</button>
            </form>

            <!-- Back to Login Link -->
            <p class="text-center text-sm mt-8 text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}" class="text-[#005baa] font-semibold hover:underline transition-colors">
                    Back to Login
                </a>
            </p>
        </div>
    </div>

</body>
</html>
