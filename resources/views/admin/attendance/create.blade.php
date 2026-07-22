<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mark Attendance | PEL Admin</title>

    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <!-- Alpine x-data wrapper for the search functionality -->
    <div x-data="{ searchQuery: '' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mark Attendance</h1>
            <a href="{{ route('admin.attendance.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 transition-colors">
                &larr; Back to Logs
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span>Please ensure all inputs are valid before saving.</span>
            </div>
        @endif

        <form action="{{ route('admin.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $today->format('Y-m-d') }}">

            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">

                <!-- Header with Date, Search Bar, and Save Button -->
                <div class="flex flex-col sm:flex-row justify-between items-center px-6 py-4 border-b border-gray-100 bg-white gap-4">
                    <div class="font-semibold text-gray-500 text-sm">
                        Date: <span class="text-gray-900 text-base">{{ $today->format('F j, Y') }}</span>
                    </div>

                    <!-- Live Search Input -->
                    <div class="relative w-full sm:w-72 text-gray-400 focus-within:text-blue-500 transition-colors">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input
                            type="text"
                            x-model="searchQuery"
                            placeholder="Search intern by name..."
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-gray-900 transition-all shadow-sm"
                        >
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm disabled:opacity-50" {{ $interns->isEmpty() ? 'disabled' : '' }}>
                        Save Attendance
                    </button>
                </div>

                <!-- Attendance Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-wider">Intern Name</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Department</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Time In</th>
                                <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($interns as $intern)
                                @php
                                    $record = $attendances->get($intern->id);
                                    $status = $record ? $record->status : null;
                                    $timeIn = $record && $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('H:i') : '';
                                @endphp

                                <!-- Alpine.js x-show directive filters rows based on search input -->
                                <tr x-show="searchQuery === '' || '{{ strtolower($intern->name) }}'.includes(searchQuery.toLowerCase())" class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $intern->name }}</td>
                                    <td class="px-6 py-4 text-gray-500 font-medium">{{ $intern->department->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <input
                                            type="time"
                                            name="attendance[{{ $intern->id }}][time_in]"
                                            value="{{ $timeIn }}"
                                            class="border border-gray-300 rounded-md text-sm px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-gray-700 shadow-sm"
                                        >
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- Defaults to Present if no status exists -->
                                        <select
                                            name="attendance[{{ $intern->id }}][status]"
                                            class="border border-gray-300 rounded-md text-sm px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white text-gray-700 shadow-sm cursor-pointer font-medium
                                            {{ ($status == 'Present' || !$status) ? 'text-green-600' : ($status == 'Absent' ? 'text-red-600' : 'text-amber-600') }}"
                                        >
                                            <option value="Present" class="text-green-600" {{ ($status == 'Present' || !$status) ? 'selected' : '' }}>Present</option>
                                            <option value="Absent" class="text-red-600" {{ $status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="Leave" class="text-amber-600" {{ $status == 'Leave' ? 'selected' : '' }}>Leave</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="mt-4 text-sm text-gray-500 font-medium">No interns found in the system.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
