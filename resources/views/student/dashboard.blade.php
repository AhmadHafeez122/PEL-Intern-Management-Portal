<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Intern Dashboard | PEL Internship Portal</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    
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
<body class="bg-gray-50 text-gray-800 font-inter min-h-screen flex flex-col">

    <!-- Top Corporate Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Brand logo & info -->
                <a href="/" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Logo" class="h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                    <div class="flex flex-col text-left">
                        <span class="font-poppins font-bold text-base leading-tight tracking-wide text-pel-dark">Pak Elektron</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Internship Portal</span>
                    </div>
                </a>

                <!-- User actions & Logout -->
                <div class="flex items-center space-x-6">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-bold text-gray-900 leading-tight">{{ $user->name }}</span>
                        <span class="text-xs text-gray-500 font-medium mt-0.5">{{ $user->email }}</span>
                    </div>
                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-all duration-200">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content wrapper -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 lg:px-8 py-10 space-y-8">

        <!-- Global Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-sm text-sm font-semibold flex items-center gap-3 animate-fade-in-up">
                <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm text-sm font-semibold animate-fade-in-up">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── STATE 1: NOT APPLIED (Show Premium Form) ────────────────────────── --}}
        @if($internData->status === 'Not Applied')
            <div class="max-w-2xl mx-auto bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 relative overflow-hidden transition-all hover:shadow-2xl">
                <!-- Top Accent Line -->
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pel-blue to-teal-400"></div>

                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-poppins font-extrabold text-gray-900">Internship Application Form</h1>
                    <p class="text-sm text-gray-500 mt-2">Submit your educational details and CV/Resume to start your internship at PEL.</p>
                </div>

                <form method="POST" action="{{ route('student.application.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Full Name</label>
                            <input type="text" value="{{ $user->name }}" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Email Address</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed text-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">University / Institution</label>
                        <input type="text" name="university" required placeholder="e.g., UET Lahore, NUST, FAST" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 focus:bg-white transition-all" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Applied Department</label>
                            <select name="department_name" required 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 focus:bg-white transition-all">
                                <option value="">Select Domain</option>
                                <option value="Computer Science">Computer Science / IT</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Electrical Engineering">Electrical Engineering</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Business Administration">Business Administration</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Registration / Roll Number</label>
                            <input type="text" name="registration_number" required placeholder="e.g., PEL-2026-CS88" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pel-blue/30 focus:border-pel-blue/50 focus:bg-white transition-all" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Upload CV / Resume (PDF, DOCX)</label>
                        <div class="relative flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-pel-blue/50 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-xs text-gray-500"><span class="font-bold text-pel-blue">Click to upload</span> or drag and drop</p>
                                    <p class="text-[10px] text-gray-400 mt-1">PDF, DOC, or DOCX up to 2MB</p>
                                </div>
                                <input type="file" name="cv" accept=".pdf,.doc,.docx" required class="hidden" />
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 px-4 bg-gradient-to-r from-pel-blue to-blue-700 text-white rounded-xl font-bold text-base shadow-lg shadow-pel-blue/30 hover:shadow-xl hover:from-blue-600 hover:to-blue-800 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150">
                        Submit Application
                    </button>
                </form>
            </div>

        {{-- ── STATE 2: PENDING OR REJECTED ──────────────────────────────────── --}}
        @elseif($internData->status === 'Pending' || $internData->status === 'Rejected')
            <div class="max-w-xl mx-auto bg-white rounded-3xl border border-gray-100 shadow-xl p-10 text-center relative overflow-hidden transition-all hover:shadow-2xl">
                <!-- Color-coded border top -->
                <div class="absolute top-0 inset-x-0 h-2 {{ $internData->status === 'Rejected' ? 'bg-red-500' : 'bg-amber-400' }}"></div>

                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center rounded-2xl shadow-md transition-transform hover:scale-105 {{ $internData->status === 'Rejected' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-500 border border-amber-100' }}">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($internData->status === 'Rejected')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                </div>

                <h1 class="text-3xl font-poppins font-extrabold text-gray-900 mb-2">
                    {{ $internData->status === 'Rejected' ? 'Application Status' : 'Under Review' }}
                </h1>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8">
                    {{ $internData->status === 'Rejected' 
                        ? 'We regret to inform you that your application has been rejected for this cycle. Feel free to re-apply in future intakes.' 
                        : 'Your internship application is currently under review by the PEL Human Resources team. We will notify you once approved.' }}
                </p>

                <div class="bg-gray-50 rounded-2xl p-6 text-left border border-gray-100 text-sm space-y-3">
                    <div class="flex justify-between items-center border-b border-gray-200/60 pb-3">
                        <span class="text-gray-500 font-semibold">Applied Department</span>
                        <span class="font-bold text-gray-900">{{ $internData->department_name }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200/60 pb-3">
                        <span class="text-gray-500 font-semibold">Registration Code</span>
                        <span class="font-mono font-bold text-gray-900">{{ $internData->registration_number }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-gray-500 font-semibold">Review Status</span>
                        <span class="px-3 py-1 text-xs font-bold rounded-full uppercase {{ $internData->status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $internData->status }}
                        </span>
                    </div>
                </div>
            </div>

        {{-- ── STATE 3: ACTIVE INTERN DASHBOARD ──────────────────────────────── --}}
        @else
            <!-- Hero Welcome Card -->
            <div class="bg-gradient-to-r from-pel-dark via-[#0d3868] to-pel-blue rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden transition-all hover:shadow-2xl">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10">
                    <div class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider text-blue-200 mb-4 border border-white/10">
                        Active Internship Portal
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-poppins font-extrabold tracking-tight">Welcome Back, {{ explode(' ', $internData->name)[0] }}!</h1>
                    <p class="text-blue-100 mt-2 text-sm sm:text-base font-light max-w-2xl">
                        Your internship placement is verified. Monitor tasks assigned by your supervisor, track attendance, and stay updated with campus notices.
                    </p>
                </div>
            </div>

            <!-- Dashboard Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Total Tasks</span>
                    <p class="text-3xl font-black text-pel-blue">{{ $stats['total_tasks'] }}</p>
                </div>
                <!-- Stat 2 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Performance</span>
                    <p class="text-3xl font-black text-teal-600">{{ $stats['gpa_or_score'] }}</p>
                </div>
                <!-- Stat 3 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Attendance</span>
                    <p class="text-3xl font-black text-indigo-600">{{ $stats['attendance'] }}</p>
                </div>
                <!-- Stat 4 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Pending Tasks</span>
                    <p class="text-3xl font-black text-amber-500">{{ $stats['pending_tasks'] }}</p>
                </div>
            </div>

            <!-- Two Column Dashboard Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Profile & Tasks -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Placement Info -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4 hover:shadow-md transition-all">
                        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Intern Profile Data</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Verified Department</p>
                                <p class="text-sm font-bold text-gray-800">{{ $internData->department_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Intern Registration Code</p>
                                <p class="text-sm font-mono font-bold text-pel-blue">{{ $internData->registration_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Widget -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-900">Assigned Tasks</h2>
                            <span class="px-2.5 py-1 text-xs font-bold bg-pel-blue/15 text-pel-blue rounded-lg">Live</span>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($tasks as $task)
                                <div class="p-6 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                    <div class="flex-1 space-y-1">
                                        <h3 class="text-base font-bold text-gray-900">{{ $task->title ?? 'Untitled Task' }}</h3>
                                        <p class="text-sm text-gray-500 leading-relaxed">{{ Str::limit($task->description ?? 'No details provided.', 120) }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-full border {{ ($task->status ?? 'pending') === 'Completed' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                                            {{ ucfirst($task->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                                    <p class="text-sm font-semibold">No tasks assigned yet</p>
                                    <p class="text-xs text-gray-400 mt-1">Supervisors assign tasks from the admin console.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Supervisor & Announcements -->
                <div class="space-y-8">
                    
                    <!-- Supervisor info card -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4 block">Assigned Supervisor</h2>
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-pel-blue to-blue-700 text-white text-base font-black w-12 h-12 rounded-xl flex items-center justify-center shadow-md">
                                {{ $supervisor ? strtoupper(substr($supervisor->name, 0, 2)) : 'NA' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm sm:text-base leading-tight">{{ $supervisor ? $supervisor->name : 'Not Assigned' }}</p>
                                <p class="text-xs font-medium text-gray-500 mt-1">Corporate Supervisor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Announcements widget -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-6 block">Announcements</h2>
                        <div class="space-y-6">
                            @forelse($announcements as $announcement)
                                <div class="space-y-1.5">
                                    <span class="text-[10px] font-bold text-pel-blue uppercase tracking-wider block">{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}</span>
                                    <h4 class="font-bold text-sm text-gray-900 leading-snug">{{ $announcement->title }}</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed">{{ $announcement->body }}</p>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    <p class="text-xs italic">No announcements posted</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        @endif

    </main>

</body>
</html>
