<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Login - PEL</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <!-- Scripts (Uses your default Laravel Vite setup) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
        }

        /* Official PEL Corporate Blue Gradient Background */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #005baa 0%, #003b73 100%);
            padding: 1rem;
        }

        /* Clean White Corporate Card */
        .login-card {
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
            color: #4b5563; /* Dark gray */
            margin-bottom: 0.4rem;
        }

        /* Professional Light Inputs */
        input[type="email"], input[type="password"] {
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

        input[type="email"]:focus, input[type="password"]:focus {
            background: #ffffff;
            border-color: #005baa; /* PEL Blue Focus */
            box-shadow: 0 0 0 3px rgba(0, 91, 170, 0.15);
            outline: none;
        }

        input::placeholder {
            color: #9ca3af;
        }

        .custom-checkbox {
            accent-color: #005baa;
            width: 16px;
            height: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Solid Brand Button */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #005baa; /* Primary PEL Blue */
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 0.5rem;
        }

        button[type="submit"]:hover {
            background: #004683; /* Darker PEL Blue on hover */
        }

        /* Error Text */
        .error-text {
            color: #dc2626; /* Red for errors */
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">

            <!-- Header section with Official Image Logo -->
            <div class="flex flex-col items-center justify-center mb-8">

                <!--
                  This img tag calls the logo you placed in public/images/pel-logo.png
                  Adjust the height (h-16) if your logo needs to be bigger or smaller
                -->
               <img src="/images/pel-logo.png" alt="PEL Official Logo" class="h-16 mb-4 object-contain">
                <h2 class="text-2xl font-poppins font-bold text-gray-900 tracking-tight text-center">Internship Portal</h2>
                <p class="text-gray-500 text-sm mt-1 text-center">Sign in to access your dashboard</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-700 bg-green-50 border border-green-200 rounded-lg p-3 text-center text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Forced Student Role -->
                <input type="hidden" name="role_login_type" value="student">

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus autocomplete="username">
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex justify-between items-center mb-2 mt-4 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-700 hover:text-gray-900 transition-colors">
                        <input type="checkbox" name="remember" class="custom-checkbox border-gray-300">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[#005baa] hover:text-[#003b73] hover:underline transition-colors font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit">Log In</button>
            </form>

            <!-- Registration Link -->
            <p class="text-center text-sm mt-8 text-gray-600">
                Are you a new student?
                <a href="{{ route('register') }}" class="text-[#005baa] font-semibold hover:underline transition-colors">
                    Apply Now
                </a>
            </p>
        </div>
    </div>

</body>
</html>
