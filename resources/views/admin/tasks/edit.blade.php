<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Task | PEL Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="max-w-xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold mb-6">Edit Task</h1>

        <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Task Title</label>
                <input type="text" name="title" value="{{ $task->title }}" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ $task->description }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Assign to Intern</label>
                <select name="intern_id" required class="w-full border rounded-lg px-3 py-2 text-sm bg-white">
                    @foreach($interns as $intern)
                        <option value="{{ $intern->id }}" {{ $task->intern_id == $intern->id ? 'selected' : '' }}>{{ $intern->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" required class="w-full border rounded-lg px-3 py-2 text-sm bg-white">
                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.tasks.index') }}" class="px-4 py-2 border rounded-lg text-sm">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Update Task</button>
            </div>
        </form>
    </div>
</body>
</html>
