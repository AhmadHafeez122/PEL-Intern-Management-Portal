<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Logs | PEL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Attendance Logs</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                    &larr; Back to Dashboard
                </a>
                <a href="{{ route('admin.attendance.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    Mark Attendance
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-white flex justify-between items-center">
                <span class="font-semibold text-gray-700">
                    Showing logs for: <span class="text-gray-900">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold tracking-wider">Intern Name</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Department</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Time In</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($attendances as $record)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $record->intern->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $record->intern->department->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $record->date }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '--' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $record->status === 'Present' ? 'bg-green-50 text-green-700' : ($record->status === 'Absent' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                        {{ $record->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No attendance records found for this date.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
