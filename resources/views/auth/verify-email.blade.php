<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Email Verification - PEL</title>

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
            max-width: 440px;
            background: #ffffff;
            padding: 2.5rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: #333333;
        }

        /* Solid Brand Button */
        button.btn-primary {
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
        }

        button.btn-primary:hover {
            background: #004683;
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">

            <!-- Header section with Official Image Logo -->
            <div class="flex flex-col items-center justify-center mb-6">
                <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Official Logo" class="h-16 mb-4 object-contain">
                <h2 class="text-2xl font-poppins font-bold text-gray-900 tracking-tight text-center">Verify Your Email</h2>
            </div>

            <div class="mb-6 text-sm text-gray-600 leading-relaxed text-center">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 text-green-700 bg-green-50 border border-green-200 rounded-lg p-3 text-center text-sm font-medium">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <div class="flex items-center justify-center mt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-800 underline transition-colors">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
