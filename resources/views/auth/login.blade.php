<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Login | PEL Internship Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Alpine.js CDN (Bulletproof fallback) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        pel: {
                            blue: '#005baa',
                            dark: '#0a2540',
                            light: '#f0f6ff',
                            accent: '#f59e0b',
                            teal: '#0d9488'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-inter h-full">

    <div class="min-h-screen flex flex-col md:flex-row overflow-hidden">
        
        <!-- Left Panel: Legacy & Marketing (Visible on md and up) -->
        <div class="hidden md:flex md:w-1/2 bg-pel-dark relative items-center justify-center p-12 text-white">
            <!-- Background effects -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <div class="absolute top-10 left-10 w-72 h-72 bg-pel-blue rounded-full filter blur-3xl opacity-20"></div>
                <div class="absolute bottom-10 right-10 w-72 h-72 bg-pel-teal rounded-full filter blur-3xl opacity-20"></div>
                <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80" alt="Industrial Innovation" class="w-full h-full object-cover opacity-15" />
                <div class="absolute inset-0 bg-gradient-to-t from-pel-dark via-pel-dark/80 to-transparent"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 max-w-lg space-y-8">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Official Logo" class="h-12 w-auto object-contain bg-white/10 backdrop-blur-md p-2 rounded-xl border border-white/10" />
                    <div class="flex flex-col text-left">
                        <span class="font-poppins font-bold text-lg leading-tight tracking-wide">Pak Elektron</span>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Internship Portal</span>
                    </div>
                </a>

                <div class="space-y-4">
                    <h2 class="text-4xl font-poppins font-extrabold tracking-tight leading-tight">
                        Bridge the Gap Between <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Theory & Practice</span>
                    </h2>
                    <p class="text-gray-300 font-light leading-relaxed">
                        Sign in to monitor your application status, manage daily tasks, track your attendance, and access expert mentorship logs.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-white/10">
                    <div>
                        <h4 class="text-2xl font-poppins font-bold text-pel-accent">500+</h4>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Annual Interns Selected</p>
                    </div>
                    <div>
                        <h4 class="text-2xl font-poppins font-bold text-teal-400">80%</h4>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Post-Intern Placement</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: Login Form -->
        <div class="flex-1 flex items-center justify-center p-8 bg-gradient-to-tr from-gray-50 to-blue-50/20 relative">
            <div class="w-full max-w-md bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 relative overflow-hidden transition-all hover:shadow-2xl">
                
                <!-- Floating top accent line -->
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pel-blue to-teal-400"></div>

                <!-- Brand logo on mobile -->
                <div class="flex md:hidden items-center justify-center gap-2 mb-6">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Logo" class="h-10 w-auto object-contain">
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-poppins font-bold text-gray-900">Welcome Back</h1>
                    <p class="text-gray-500 text-sm mt-1.5">Sign in to your student/intern account</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-xl text-center text-sm font-semibold shadow-sm animate-fade-in-up">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Forced Student Role -->
                    <input type="hidden" name="role_login_type" value="student">

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="student@example.com" required autofocus autocomplete="username"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 focus:bg-white transition-all" />
                        </div>
                        @error('email')
                            <span class="text-xs font-semibold text-red-600 animate-pulse mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-pel-blue hover:text-blue-700 font-semibold transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 focus:bg-white transition-all" />
                        </div>
                        @error('password')
                            <span class="text-xs font-semibold text-red-600 animate-pulse mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-pel-blue border-gray-300 rounded focus:ring-pel-blue/30 accent-pel-blue cursor-pointer">
                        <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors cursor-pointer select-none">Remember my session</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-pel-blue to-blue-700 text-white rounded-xl font-semibold text-sm shadow-lg shadow-pel-blue/30 hover:shadow-xl hover:from-blue-600 hover:to-blue-800 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150">
                        Sign In
                    </button>
                </form>

                <!-- Navigation link -->
                <div class="mt-8 text-center text-sm border-t border-gray-100 pt-6">
                    <p class="text-gray-500 font-medium">New applicant?</p>
                    <a href="{{ route('register') }}" class="inline-block mt-2 font-bold text-pel-blue hover:text-blue-800 border-b-2 border-transparent hover:border-pel-blue transition-all">
                        Create Portal Account
                    </a>
                </div>

            </div>
        </div>

    </div>
</body>
</html>
