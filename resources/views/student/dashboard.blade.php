<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Intern Dashboard - Student Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Modern Top Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 text-white font-black px-2.5 py-1.5 rounded-lg shadow-sm text-sm">IP</div>
                    <span class="font-extrabold text-lg text-slate-900 tracking-tight">Intern Portal</span>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex flex-col text-right">
                        <span class="text-sm font-bold text-slate-900">{{ $user->name }}</span>
                        <span class="text-xs text-slate-500 font-medium">{{ $user->email }}</span>
                    </div>
                    <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-red-600 transition-colors">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Global Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm text-sm font-medium">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($internData->status === 'Not Applied')
            <!-- STATE 1: NOT APPLIED (Show Application Form) -->
            <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-extrabold text-slate-900">Internship Application</h1>
                    <p class="text-sm text-slate-500 mt-2">Submit your details and CV to apply for the internship program.</p>
                </div>

                <form method="POST" action="{{ route('student.application.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">University</label>
                        <input type="text" name="university" required placeholder="e.g. UET Lahore" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Department</label>
                            <select name="department_name" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                <option value="">Select Department</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Information Technology">Information Technology</option>
                                <option value="Business Administration">Business Administration</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Reg. Number</label>
                            <input type="text" name="registration_number" required placeholder="e.g. CS-2026-001" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Upload CV (PDF/DOC)</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition">Submit Application</button>
                </form>
            </div>

        @elseif($internData->status === 'Pending' || $internData->status === 'Rejected')
            <!-- STATE 2: PENDING OR REJECTED -->
            <div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-md p-10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 {{ $internData->status === 'Rejected' ? 'bg-red-500' : 'bg-amber-400' }}"></div>
                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center rounded-full shadow-sm {{ $internData->status === 'Rejected' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-500 border border-amber-100' }}">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($internData->status === 'Rejected')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">
                    {{ $internData->status === 'Rejected' ? 'Application Rejected' : 'Application Under Review' }}
                </h1>
                <p class="text-sm text-slate-500 mb-8">
                    {{ $internData->status === 'Rejected' ? 'We regret to inform you that your application was not approved.' : 'Your application is submitted and awaiting admin approval. Please check back later.' }}
                </p>
                <div class="bg-slate-50 rounded-xl p-5 text-left border border-slate-100 text-sm">
                    <div class="flex justify-between pb-2 mb-2 border-b border-slate-200">
                        <span class="text-slate-500 font-medium">Department:</span>
                        <span class="font-bold text-slate-900">{{ $internData->department_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500 font-medium">Status:</span>
                        <span class="font-bold {{ $internData->status === 'Rejected' ? 'text-red-600' : 'text-amber-600' }} uppercase">{{ $internData->status }}</span>
                    </div>
                </div>
            </div>

        @else
            <!-- STATE 3: ACTIVE INTERN DASHBOARD -->

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-extrabold tracking-tight">Welcome back, {{ explode(' ', $internData->name)[0] }}!</h1>
                    <p class="text-blue-100 mt-2 text-sm md:text-base font-medium max-w-2xl">
                        Your internship is currently active. Track your assigned tasks, monitor your attendance, and check the latest announcements below.
                    </p>
                </div>
            </div>

            <!-- Quick Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Tasks</span>
                    <p class="text-4xl font-black text-blue-600 mt-2">{{ $stats['total_tasks'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Performance</span>
                    <p class="text-4xl font-black text-emerald-500 mt-2">{{ $stats['gpa_or_score'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Attendance</span>
                    <p class="text-4xl font-black text-indigo-500 mt-2">{{ $stats['attendance'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pending</span>
                    <p class="text-4xl font-black text-amber-500 mt-2">{{ $stats['pending_tasks'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Profile & Tasks -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Data Summary -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4 border-b border-slate-100 pb-4">Intern Profile Data</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Department</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $internData->department_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Intern Code</p>
                                <p class="text-sm font-mono font-bold text-blue-600">{{ $internData->registration_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Task List -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                            <h2 class="text-lg font-bold text-slate-900">Assigned Tasks</h2>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @forelse($tasks as $task)
                                <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-slate-900 mb-1">{{ $task->title ?? 'Untitled Task' }}</h3>
                                        <p class="text-sm text-slate-500 leading-relaxed">{{ Str::limit($task->description ?? 'No description provided.', 120) }}</p>
                                    </div>
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full border {{ ($task->status ?? 'pending') == 'completed' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                                        {{ ucfirst($task->status ?? 'Pending') }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <p class="text-sm text-slate-500">No tasks assigned yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Supervisor & Announcements -->
                <div class="space-y-8">
                    <!-- Supervisor Widget -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Assigned Supervisor</h2>
                        <div class="flex items-center gap-4">
                            <div class="bg-indigo-600 text-white text-lg font-black w-12 h-12 rounded-xl flex items-center justify-center shadow-inner">
                                {{ $supervisor ? strtoupper(substr($supervisor->name, 0, 2)) : 'NA' }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-base">{{ $supervisor ? $supervisor->name : 'Not Assigned' }}</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Project Manager</p>
                            </div>
                        </div>
                    </div>

                    <!-- Announcements -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-6">Announcements</h2>
                        <div class="space-y-6">
                            @forelse($announcements as $announcement)
                                <div>
                                    <span class="text-[11px] font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}</span>
                                    <h4 class="font-bold text-sm text-slate-900 mt-1">{{ $announcement->title }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ $announcement->body }}</p>
                                </div>
                            @empty
                                <p class="text-slate-500 text-xs italic text-center py-4">No recent announcements.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
</body>
</html>
