<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Registration - PEL</title>

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
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #005baa 0%, #003b73 100%);
            padding: 2rem 1rem;
        }

        /* Clean White Corporate Card */
        .register-card {
            width: 100%;
            max-width: 480px; /* Slightly wider for registration forms */
            background: #ffffff;
            padding: 2.5rem 3rem;
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
        input[type="text"], input[type="email"], input[type="password"] {
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

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
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
            margin-top: 1rem;
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

    <div class="register-wrapper">
        <div class="register-card">

            <!-- Header section with Official Image Logo -->
            <div class="flex flex-col items-center justify-center mb-8">
                <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Official Logo" class="h-16 mb-4 object-contain">
                <h2 class="text-2xl font-poppins font-bold text-gray-900 tracking-tight text-center">Intern Registration</h2>
                <p class="text-gray-500 text-sm mt-1 text-center">Apply for your internship at PEL</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Forced Student Role -->
                <input type="hidden" name="role" value="student">

                <!-- Full Name Input -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus autocomplete="name">
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="student@example.com" required autocomplete="username">
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Create a password" required autocomplete="new-password">
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit">Create Account</button>
            </form>

            <!-- Login Link -->
            <p class="text-center text-sm mt-8 text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#005baa] font-semibold hover:underline transition-colors">
                    Log In
                </a>
            </p>
        </div>
    </div>

</body>
</html>
