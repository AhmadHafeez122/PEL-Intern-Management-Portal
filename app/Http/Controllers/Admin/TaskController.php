<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Intern;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('intern')->latest()->paginate(15);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $interns = Intern::all();
        return view('admin.tasks.create', compact('interns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'intern_id' => 'required|exists:interns,id',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        Task::create($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task successfully created and assigned.');
    }

    public function edit(Task $task)
    {
        $interns = Intern::all();
        return view('admin.tasks.edit', compact('task', 'interns'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'intern_id' => 'required|exists:interns,id',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
