<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Departments | PEL Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { pel: { blue: '#1e3a8a', sidebar: '#112240' } }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-900">

    <div class="max-w-7xl mx-auto px-6 py-10">

        <!-- Header & Action -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Departments Management</h1>
                <p class="text-sm text-gray-500 mt-1">Organize company divisions and track assigned staff and interns.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">
                &larr; Back to Dashboard
            </a>
        </div>

        <!-- Success & Error Notifications -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-medium shadow-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span class="text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded">Success</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl text-sm font-medium shadow-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <span class="text-xs font-bold uppercase tracking-wider bg-red-100 text-red-800 px-2 py-0.5 rounded">Notice</span>
            </div>
        @endif

        <!-- Grid Layout: Add Department Form & Table -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Add Department Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Add New Department</h2>

                <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Department Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-pel-blue/20 focus:border-pel-blue transition-all"
                            placeholder="e.g. Research & Development">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3 bg-pel-blue text-white rounded-xl text-sm font-semibold hover:bg-blue-900 transition-colors shadow-sm">
                        Create Department
                    </button>
                </form>
            </div>

            <!-- Right Column: Departments Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50/70 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold">Department Name</th>
                                <th class="px-6 py-4 font-bold text-center">Supervisors</th>
                                <th class="px-6 py-4 font-bold text-center">Interns Assigned</th>
                                <th class="px-6 py-4 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($departments as $dept)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $dept->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg text-xs">
                                            {{ $dept->supervisors_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-xs">
                                            {{ $dept->interns_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                        No departments found. Use the form on the left to add one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                @if($departments->hasPages())
                    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                        {{ $departments->links() }}
                    </div>
                @endif
            </div>

        </div>

    </div>

</body>
</html>
