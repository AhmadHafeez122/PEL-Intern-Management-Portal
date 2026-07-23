<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL Admin Dashboard | IMS Portal</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind & Alpine & Chart.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                            teal: '#0d9488',
                            sidebar: '#0b1b33'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #1e293b; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-inter overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/60 z-40 lg:hidden"
             x-cloak>
        </div>

        <!-- Sidebar -->
        <aside class="bg-pel-sidebar text-slate-300 transition-all duration-300 flex flex-col fixed lg:relative z-50 h-full border-r border-slate-800"
               :class="sidebarOpen ? 'w-72 translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'">

            <!-- Sidebar Header / Logo -->
            <div class="h-20 shrink-0 flex items-center justify-between px-6 border-b border-slate-800 bg-[#091526]">
                <div class="flex items-center gap-3 w-full overflow-hidden" x-show="sidebarOpen">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Logo" class="h-9 w-auto object-contain bg-white/10 p-1.5 rounded-lg border border-white/5" />
                    <div class="flex flex-col min-w-0">
                        <span class="text-white font-poppins font-bold text-sm leading-tight truncate">Administrator</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">IMS Console</span>
                    </div>
                </div>
                <div class="mx-auto" x-show="!sidebarOpen">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="P" class="h-8 object-contain">
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 py-6 space-y-1.5 overflow-y-auto custom-scrollbar px-4">
                
                <!-- Overview -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Overview</span>
                </a>

                <!-- Manage Interns -->
                <a href="{{ route('admin.interns.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.interns.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Manage Interns</span>
                </a>

                <!-- Manage Supervisors -->
                <a href="{{ route('admin.supervisors.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.supervisors.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Supervisors</span>
                </a>

                <!-- Applications -->
                <a href="{{ route('admin.applications.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.applications.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Applications</span>
                </a>

                <!-- Assigned Tasks -->
                <a href="{{ route('admin.tasks.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.tasks.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Assigned Tasks</span>
                </a>

                <!-- Attendance & Logs -->
                <a href="{{ route('admin.attendance.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.attendance.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">Attendance Logs</span>
                </a>

                <!-- System Reports -->
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-pel-blue text-white font-semibold shadow-md shadow-pel-blue/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="ml-3 font-medium text-sm whitespace-nowrap" x-show="sidebarOpen">System Reports</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Signout -->
            <div class="p-4 shrink-0 px-4 pb-6 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 rounded-xl bg-red-600/95 hover:bg-red-600 text-white shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative w-full">

            <!-- Top Dashboard Header -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-8 shrink-0 shadow-sm z-10 w-full">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-pel-blue p-2 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-poppins font-bold text-gray-900 leading-tight">Admin Control Panel</h1>
                        <p class="text-xs text-gray-500 mt-0.5">Welcome back to Pak Elektron Limited Internship Management System.</p>
                    </div>
                </div>

                <!-- Admin Profile Info -->
                <div class="flex items-center gap-4" x-data="{ profileOpen: false }">
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 focus:outline-none group pl-4 border-l border-gray-200">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-900 leading-tight group-hover:text-pel-blue transition-colors">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">Super Admin</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-pel-dark text-white flex items-center justify-center font-bold text-sm shadow-md transition-all group-hover:bg-pel-blue">
                                {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                            </div>
                        </button>

                        <div x-show="profileOpen" @click.away="profileOpen = false" x-transition class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ route('admin.settings') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 hover:text-pel-blue transition-colors">Profile Settings</a>
                            <div class="border-t border-gray-100 my-1.5"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable dashboard content -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-8 custom-scrollbar">

                <!-- Stats card row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    <a href="{{ route('admin.interns.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-blue-200 transition-all cursor-pointer relative overflow-hidden">
                        <div class="relative z-10 space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Interns</p>
                            <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $totalInterns ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-pel-blue flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.supervisors.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-emerald-200 transition-all cursor-pointer relative overflow-hidden">
                        <div class="relative z-10 space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Supervisors</p>
                            <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $activeSupervisors ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.applications.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-amber-200 transition-all cursor-pointer relative overflow-hidden">
                        <div class="relative z-10 space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Approvals</p>
                            <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $pendingApprovals ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.attendance.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md hover:border-cyan-200 transition-all cursor-pointer relative overflow-hidden">
                        <div class="relative z-10 space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Overall Attendance</p>
                            <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $overallAttendance ?? 0 }}%</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </a>
                </div>

                <!-- Splitted tables and charts -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <!-- Recent applications table -->
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center gap-4">
                            <h2 class="text-lg font-bold text-gray-900">Recent Applications</h2>
                            <a href="{{ route('admin.interns.create') }}" class="bg-pel-blue hover:bg-blue-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-2 hover:-translate-y-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Add Intern
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 font-bold tracking-wider">Intern Details</th>
                                        <th class="px-6 py-4 font-bold tracking-wider">Department</th>
                                        <th class="px-6 py-4 font-bold tracking-wider">Supervisor</th>
                                        <th class="px-6 py-4 font-bold tracking-wider text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentInterns ?? [] as $intern)
                                        @php
                                            $name = data_get($intern, 'name', 'Unknown');
                                            $university = data_get($intern, 'university', 'N/A');
                                            $departmentName = data_get($intern, 'department.name', 'N/A');
                                            $supervisorName = data_get($intern, 'supervisor.name', 'Unassigned');
                                            $status = data_get($intern, 'status', 'Pending');
                                            $isActive = strtolower($status) === 'active';
                                            $initials = strtoupper(substr($name, 0, 2));
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4 flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-pel-blue flex items-center justify-center font-bold text-xs shadow-sm">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900 leading-none">{{ $name }}</p>
                                                    <p class="text-[11px] text-gray-500 mt-1">{{ $university }}</p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-gray-700">{{ $departmentName }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $supervisorName }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold shadow-sm
                                                    {{ $isActive ? 'bg-green-50 text-green-700 border border-green-200/55' : 'bg-amber-50 text-amber-700 border border-amber-200/55' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                <p class="text-sm font-semibold">No intern applications registered</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="p-4 border-t border-gray-100 bg-gray-50/50 text-center">
                            <a href="{{ route('admin.interns.index') }}" class="text-pel-blue font-bold text-xs hover:underline hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                                Open Intern Directory
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Doughnut distribution chart -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Departments</h2>
                                <p class="text-xs text-gray-500 mt-1">Intern distribution by domain.</p>
                            </div>
                            <div class="p-2 bg-blue-50 text-pel-blue rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                            </div>
                        </div>

                        <div class="flex-1 flex items-center justify-center">
                            <div class="relative w-full h-64">
                                <canvas id="departmentChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Chart dynamic scripts using exact controller variables -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deptCtx = document.getElementById('departmentChart').getContext('2d');

            const dynamicLabels = {!! json_encode($deptChartLabels ?? ['Engineering', 'IT', 'Business']) !!};
            const dynamicData = {!! json_encode($deptChartData ?? [0, 0, 0]) !!};

            new Chart(deptCtx, {
                type: 'doughnut',
                data: {
                    labels: dynamicLabels,
                    datasets: [{
                        data: dynamicData,
                        backgroundColor: [
                            '#005baa',
                            '#0d9488',
                            '#f59e0b',
                            '#0a2540',
                            '#64748b'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6,
                        cutout: '70%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: 10 },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 16,
                                font: { family: "'Inter', sans-serif", size: 11, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(10, 37, 64, 0.95)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
