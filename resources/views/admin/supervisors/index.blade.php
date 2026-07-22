<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Supervisors | IMS Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { pel: { blue: '#1e3a8a', sidebar: '#112240', accent: '#e0f2fe' } } }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-900" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="bg-pel-sidebar text-slate-300 transition-all duration-300 flex flex-col z-20" :class="sidebarOpen ? 'w-64' : 'w-20'">
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
                <div class="text-white font-black text-2xl" x-show="sidebarOpen">PEL Admin</div>
                <div class="text-white font-black text-2xl mx-auto" x-show="!sidebarOpen">P</div>
            </div>
            <nav class="flex-1 py-6 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 rounded-lg hover:bg-white/5 hover:text-white">
                    <span x-show="sidebarOpen">Overview</span>
                </a>
                <a href="{{ route('admin.supervisors.index') }}" class="flex items-center px-3 py-3 rounded-lg bg-white/10 text-white border-l-4 border-blue-400">
                    <span x-show="sidebarOpen">Manage Supervisors</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">

            <!-- Professional Header with Back Button -->
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 shadow-sm">
                <h1 class="text-2xl font-bold text-gray-900">Manage Supervisors</h1>

                <!-- Back to Dashboard Button -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Active Supervisors List</h2>

                        <!-- The Button to go to your Assign Interns page -->
                        <a href="{{ route('admin.supervisors.assign') }}" class="bg-pel-blue hover:bg-blue-800 transition text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                            Assign Interns
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4">Supervisor Details</th>
                                    <th class="px-6 py-4">Department</th>
                                    <th class="px-6 py-4">Assigned Interns</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($supervisors as $supervisor)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $supervisor->name }}</td>
                                        <td class="px-6 py-4">{{ $supervisor->department->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $supervisor->interns_count ?? 0 }} Assigned
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No supervisors found</h3>
                                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new supervisor profile.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
