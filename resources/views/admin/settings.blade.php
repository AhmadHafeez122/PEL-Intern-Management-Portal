<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Settings | PEL Admin Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand Name -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-700 text-white rounded-lg shadow-inner font-bold text-xl flex items-center justify-center">
                        P
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-lg leading-tight text-slate-900">PEL Portal</span>
                        <span class="text-xs text-slate-500 font-medium">Intern Management</span>
                    </div>
                </div>

                <!-- Navigation Actions -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition flex items-center gap-2 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Profile Settings</h1>
            <p class="text-sm text-slate-500 mt-1">Manage your administrative account details and security credentials.</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Global Error Message -->
        @if($errors->has('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ $errors->first('error') }}</span>
            </div>
        @endif

        <!-- Settings Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <div class="p-6 sm:p-8">

                    <!-- General Information Section -->
                    <div class="mb-10">
                        <h3 class="text-lg font-semibold text-slate-900 mb-5 border-b border-slate-100 pb-2">General Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('name') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('email') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-5 border-b border-slate-100 pb-2">Change Password</h3>

                        <div class="space-y-6 max-w-md">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                                <input type="password" id="current_password" name="current_password" placeholder="••••••••"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('current_password') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="mt-1.5 text-xs text-slate-500">Leave blank if you don't want to change your password.</p>
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('new_password') border-red-500 ring-1 ring-red-500 @enderror">
                                @error('new_password')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
