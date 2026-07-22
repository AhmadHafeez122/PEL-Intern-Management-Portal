<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Interns | PEL Admin Dashboard</title>

    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pel: { blue: '#1e3a8a', sidebar: '#112240' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-900">

    <!-- Added x-data for Alpine.js search state -->
    <div x-data="{ searchQuery: '' }" class="max-w-7xl mx-auto px-6 py-10">

        <!-- Header & Action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Manage Interns</h1>
                <p class="text-sm text-gray-500 mt-1">View, track, and manage all registered student interns across PEL departments.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                    &larr; Back to Dashboard
                </a>
                <a href="{{ route('admin.interns.create') }}" class="px-5 py-2.5 bg-pel-blue text-white rounded-xl text-sm font-semibold hover:bg-blue-900 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Intern
                </a>
            </div>
        </div>

        <!-- Success Message Notification -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-700 hover:text-emerald-900 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="mb-4 flex justify-between items-center">
            <div class="relative w-full md:w-96 text-gray-400 focus-within:text-pel-blue transition-colors">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search by intern name or registration no..."
                    class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-pel-blue focus:border-pel-blue outline-none text-gray-900 transition-all shadow-sm bg-white"
                >
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/70 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-bold">Intern Details</th>
                            <th class="px-6 py-4 font-bold">Registration / Univ</th>
                            <th class="px-6 py-4 font-bold">Department</th>
                            <th class="px-6 py-4 font-bold">Supervisor</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($interns as $intern)
                            <!-- Alpine.js filter logic: searches name OR registration number -->
                            <tr
                                x-show="searchQuery === '' ||
                                        '{{ strtolower($intern->name) }}'.includes(searchQuery.toLowerCase()) ||
                                        '{{ strtolower($intern->registration_number) }}'.includes(searchQuery.toLowerCase())"
                                class="hover:bg-slate-50/80 transition-colors"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                            {{ strtoupper(substr($intern->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $intern->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $intern->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-mono text-xs font-semibold text-gray-800">{{ $intern->registration_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $intern->university }}</p>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-700">
                                    {{ $intern->department->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $intern->supervisor->name ?? 'Unassigned' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                        {{ $intern->status == 'Active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                        {{ $intern->status == 'Pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                        {{ $intern->status == 'Completed' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                        {{ $intern->status == 'Rejected' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}">
                                        {{ $intern->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.interns.edit', $intern->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.interns.destroy', $intern->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this intern record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    No interns found in the database. Click "Add New Intern" to register one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if(method_exists($interns, 'hasPages') && $interns->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                    {{ $interns->links() }}
                </div>
            @endif
        </div>

    </div>

</body>
</html>
