<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Interns | IMS Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
<body class="bg-slate-50 text-gray-900" x-data="{ sidebarOpen: true, selectAll: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="bg-pel-sidebar text-slate-300 transition-all duration-300 flex flex-col z-20" :class="sidebarOpen ? 'w-64' : 'w-20'">
            <div class="h-20 shrink-0 flex items-center justify-between px-6 border-b border-white/10 bg-pel-sidebar">
                <div class="flex items-center gap-3" x-show="sidebarOpen">
                    <div class="text-white font-black text-2xl tracking-widest">PEL</div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-sm leading-tight">Administrator</span>
                        <span class="text-xs text-slate-400">IMS Portal</span>
                    </div>
                </div>
                <div class="text-white font-black text-2xl mx-auto" x-show="!sidebarOpen">P</div>
            </div>

            <nav class="flex-1 py-6 space-y-1 overflow-y-auto custom-scrollbar px-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 rounded-lg text-slate-300 hover:bg-white/5 hover:text-white">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Overview</span>
                </a>
                <a href="{{ route('admin.interns.index') }}" class="flex items-center px-3 py-3 rounded-lg text-slate-300 hover:bg-white/5 hover:text-white">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Manage Interns</span>
                </a>
                <a href="{{ route('admin.supervisors.index') }}" class="flex items-center px-3 py-3 rounded-lg bg-white/10 text-white font-medium border-l-4 border-blue-400">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="ml-3 whitespace-nowrap" x-show="sidebarOpen">Manage Supervisors</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">

            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-8 shrink-0 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-pel-blue lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.supervisors.index') }}" class="text-pel-blue hover:underline text-sm font-medium">Supervisors</a>
                            <span class="text-gray-400 text-sm">/</span>
                            <span class="text-gray-500 text-sm font-medium">Assign Interns</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 leading-tight">Assign Interns to Supervisor</h1>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-8">

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
                        <ul class="list-disc pl-5 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Assignment Form Wraps Everything -->
                <form action="{{ route('admin.supervisors.store-assign') }}" method="POST">
                    @csrf

                    <!-- STEP 1: Select Supervisor -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="bg-pel-blue text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                            Select the Supervisor
                        </h2>

                        <div class="max-w-xl">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign to:</label>
                            <select name="supervisor_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-pel-blue focus:border-transparent bg-gray-50">
                                <option value="" disabled selected>-- Choose a Supervisor --</option>
                                @foreach($supervisors as $sup)
                                    <option value="{{ $sup->id }}">
                                        {{ $sup->name }} - ({{ $sup->department->name ?? 'No Dept' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- STEP 2: Select Interns -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-white">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="bg-pel-blue text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Select Unassigned Interns
                            </h2>
                            <p class="text-sm text-gray-500 mt-1 ml-8">Check the box next to the interns you want to assign to the selected supervisor.</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 w-16">
                                            <input type="checkbox" x-model="selectAll" class="w-4 h-4 text-pel-blue rounded border-gray-300 focus:ring-pel-blue">
                                        </th>
                                        <th class="px-6 py-4 font-semibold">Intern Name</th>
                                        <th class="px-6 py-4 font-semibold">University</th>
                                        <th class="px-6 py-4 font-semibold">Target Department</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($unassignedInterns as $intern)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" name="intern_ids[]" value="{{ $intern->id }}" :checked="selectAll" class="w-4 h-4 text-pel-blue rounded border-gray-300 focus:ring-pel-blue">
                                            </td>
                                            <td class="px-6 py-4 font-bold text-gray-900">{{ $intern->name }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $intern->university }}</td>
                                            <td class="px-6 py-4">
                                                <span class="bg-gray-100 text-gray-700 py-1 px-2.5 rounded-full text-xs font-semibold">
                                                    {{ $intern->department->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <p class="text-gray-500 font-medium">No unassigned interns available right now.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Button Footer -->
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
                            <a href="{{ route('admin.supervisors.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-pel-blue rounded-lg hover:bg-blue-800 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" {{ $unassignedInterns->isEmpty() ? 'disabled' : '' }}>
                                Save Assignments
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </main>
    </div>
</body>
</html>
