<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL Admin Dashboard | IMS Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pel: {
                            blue: '#1e3a8a',
                            dark: '#0f172a',
                            light: '#f8fafc',
                            accent: '#e0f2fe',
                            sidebar: '#112240',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-gray-900 overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-20 lg:hidden"
             x-cloak>
        </div>

        <!-- Sidebar -->
        <aside class="bg-pel-sidebar text-slate-300 transition-all duration-300 flex flex-col fixed lg:relative z-30 h-full"
               :class="sidebarOpen ? 'w-64 translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'">

            <div class="h-20 shrink-0 flex items-center justify-between px-6 border-b border-white/10 bg-pel-sidebar">
                <!-- Expanded Logo (Responsive) -->
                <div class="flex items-center gap-3 w-full overflow-hidden" x-show="sidebarOpen">
                    <img src="{{ asset('images/pel-logo.png') }}" alt="PEL Logo" class="h-8 md:h-10 w-auto max-w-[100px] object-contain shrink-0 transition-all duration-300">
                    <div class="flex flex-col min-w-0">
                        <span class="text-white font-bold text-sm leading-tight truncate">Administrator</span>
                        <span class="text-xs text-slate-400 truncate">IMS Portal</span>
                    </div>
                </div>
                <!-- Collapsed Logo Icon -->
                <div class="mx-auto" x-show="!sidebarOpen">
                    <img src="{{ asset('images/pel-icon.png') }}" alt="P" class="h-8 object-contain">
                </div>
            </div>

            <nav class="flex-1 py-6 space-y-2 overflow-y-auto custom-scrollbar px-3">
                <!-- Overview -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Overview</span>
                </a>

                <!-- Manage Interns -->
                <a href="{{ route('admin.interns.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.interns.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Manage Interns</span>
                </a>

                <!-- Manage Supervisors -->
                <a href="{{ route('admin.supervisors.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.supervisors.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Manage Supervisors</span>
                </a>

                <!-- Applications -->
                <a href="{{ route('admin.applications.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.applications.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Applications</span>
                </a>

                <!-- Assigned Tasks (NEW) -->
                <a href="{{ route('admin.tasks.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.tasks.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Assigned Tasks</span>
                </a>

                <!-- Attendance & Logs (NEW) -->
                <a href="{{ route('admin.attendance.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.attendance.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Attendance & Logs</span>
                </a>

                <!-- System Reports -->
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-white/10 text-white font-medium border-l-4 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">System Reports</span>
                </a>
            </nav>

            <div class="p-4 mt-auto shrink-0 px-3 pb-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-3 rounded-lg bg-red-600/90 hover:bg-red-600 text-white shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="ml-3 font-semibold whitespace-nowrap" x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative w-full">

            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 shrink-0 shadow-sm z-10 w-full">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-pel-blue p-2 rounded-md bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="hidden sm:block">
                        <h1 class="text-2xl font-bold text-gray-900 leading-tight">System Overview</h1>
                        <p class="text-sm text-gray-500">Welcome back. Here is the campus-wide summary.</p>
                    </div>
                </div>

                <!-- Database User Profile Dropdown -->
                <div class="flex items-center gap-6" x-data="{ profileOpen: false }">
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 pl-4 border-l border-gray-200 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-pel-blue transition-colors">{{ auth()->user()->name ?? 'Admin User' }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@pel.com' }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-full bg-pel-blue text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-transparent group-hover:ring-blue-200 transition-all">
                                <!-- Fetch Initials from Database Name -->
                                {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                            </div>
                        </button>

                     <div x-show="profileOpen" @click.away="profileOpen = false" x-transition class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50" x-cloak>
    <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-50 hover:text-pel-blue transition-colors">Profile Settings</a>
    <div class="border-t border-gray-100 my-1"></div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Sign Out</button>
    </form>
</div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8 custom-scrollbar">

                <!-- Clickable Stat Cards Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <a href="{{ route('admin.interns.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 group-hover:text-blue-600 transition-colors">Total Interns</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $totalInterns ?? 0 }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.supervisors.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-emerald-300 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 group-hover:text-emerald-600 transition-colors">Active Supervisors</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $activeSupervisors ?? 0 }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.applications.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-amber-300 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 group-hover:text-amber-600 transition-colors">Pending Approvals</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $pendingApprovals ?? 0 }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.attendance.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-xl hover:border-cyan-300 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 group-hover:text-cyan-600 transition-colors">Overall Attendance</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $overallAttendance ?? 0 }}%</h3>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </a>
                </div>

                <!-- Split Content: Dynamic Table and Charts -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <!-- Recent Interns Table -->
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                        <div class="px-6 py-5 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4 bg-white">
                            <h2 class="text-xl font-bold text-gray-900">Recent Intern Applications</h2>
                            <a href="{{ route('admin.interns.create') }}" class="bg-pel-blue hover:bg-blue-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add New Intern
                            </a>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Intern Details</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Department</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Assigned Supervisor</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                    </tr>
                                </thead>
                               <tbody class="divide-y divide-gray-100">
    @forelse($recentInterns ?? [] as $intern)
        @php
            // Extract data safely whether $intern is an Object or an Array
            $name = data_get($intern, 'name', 'Unknown');
            $university = data_get($intern, 'university', 'N/A');
            $departmentName = data_get($intern, 'department.name', 'N/A');
            $supervisorName = data_get($intern, 'supervisor.name', 'Unassigned');
            $status = data_get($intern, 'status', 'Pending');
            $isActive = strtolower($status) === 'active';
            $initials = strtoupper(substr($name, 0, 2));
        @endphp

        <tr class="hover:bg-blue-50/50 transition-colors group">
            <td class="px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-pel-blue flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">
                    {{ $initials }}
                </div>
                <div>
                    <p class="font-bold text-gray-900 group-hover:text-pel-blue transition-colors">{{ $name }}</p>
                    <p class="text-xs text-gray-500">{{ $university }}</p>
                </div>
            </td>

            <td class="px-6 py-4 font-medium text-gray-700">{{ $departmentName }}</td>
            <td class="px-6 py-4 text-gray-700">{{ $supervisorName }}</td>

            <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold shadow-sm
                    {{ $isActive ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                    {{ ucfirst($status) }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p>No intern applications found.</p>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-100 bg-gray-50 text-center rounded-b-2xl">
                            <a href="{{ route('admin.interns.index') }}" class="text-pel-blue font-semibold text-sm hover:underline hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                                View full directory <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Database Fetched Chart Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Department Overview</h2>
                                <p class="text-sm text-gray-500 mt-1">Current intern distribution.</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col items-center justify-center relative">
                            <div class="relative w-full h-64">
                                <canvas id="departmentChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Chart Configuration script fetching data from Database Variables -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deptCtx = document.getElementById('departmentChart').getContext('2d');

            // Database-fetched variables mapped dynamically
            // Requires passing $chartLabels and $chartData arrays from your Dashboard Controller
            const dynamicLabels = {!! json_encode($chartLabels ?? ['Engineering', 'Marketing', 'IT', 'HR', 'Finance']) !!};
            const dynamicData = {!! json_encode($chartData ?? [45, 25, 15, 10, 5]) !!};

            new Chart(deptCtx, {
                type: 'doughnut',
                data: {
                    labels: dynamicLabels,
                    datasets: [{
                        data: dynamicData,
                        backgroundColor: [
                            '#1e40af', // pel-blue (dark)
                            '#3b82f6', // blue
                            '#0ea5e9', // sky
                            '#64748b', // slate
                            '#e2e8f0'  // light gray
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 8,
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
                                padding: 20,
                                font: { family: "'Inter', sans-serif", size: 12 }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 14 },
                            bodyFont: { size: 13 }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
