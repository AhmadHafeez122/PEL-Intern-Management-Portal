<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Manage Applications</title>

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 text-white font-bold p-2 rounded-lg">Admin</div>
                <span class="font-bold text-xl text-gray-900">Internship Applications</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors hover:underline">
                Back to Dashboard
            </a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Enhanced Dismissible Success Message -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </p>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        <!-- Enhanced Dismissible Error Message -->
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-semibold text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900">All Student Applications</h2>
                <span class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1.5 rounded-full border border-indigo-200">
                    Total: {{ count($applications) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="px-6 py-4 font-semibold">Applicant Details</th>
                            <th class="px-6 py-4 font-semibold">University & Dept</th>
                            <th class="px-6 py-4 font-semibold">Registration No.</th>
                            <th class="px-6 py-4 font-semibold">CV / Resume</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($applications as $app)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $app->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $app->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $app->university }}</p>
                                    <p class="text-xs text-indigo-600 font-medium mt-0.5">{{ $app->department_name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4 font-mono font-medium text-gray-700">
                                    {{ $app->registration_number }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($app->cv_path)
                                        <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors px-3 py-1.5 rounded-lg border border-blue-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Download CV
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic bg-gray-50 px-2 py-1 rounded-md border border-gray-100">No CV Uploaded</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border
                                        {{ $app->status == 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                                          ($app->status == 'Rejected' ? 'bg-red-50 text-red-700 border-red-200' :
                                          'bg-amber-50 text-amber-700 border-amber-200') }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Active">
                                        <button type="submit" class="px-4 py-1.5 text-xs font-bold text-white bg-emerald-500 hover:bg-emerald-600 transition-colors rounded-lg shadow-sm border border-emerald-600">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="px-4 py-1.5 text-xs font-bold text-white bg-red-500 hover:bg-red-600 transition-colors rounded-lg shadow-sm border border-red-600">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="mt-4 text-sm font-medium text-gray-500">No student applications found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($applications, 'links'))
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>
