<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Assigned Tasks | PEL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Assigned Tasks</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">&larr; Back to Dashboard</a>
                <a href="{{ route('admin.tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">Assign New Task</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Task Title</th>
                        <th class="px-6 py-4">Assigned Intern</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task->intern->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $task->status === 'Completed' ? 'bg-green-50 text-green-700' : ($task->status === 'In Progress' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-blue-600 hover:underline mr-3 font-medium">Edit</a>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this task?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">No tasks assigned yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $tasks->links() }}</div>
    </div>
</body>
</html>
