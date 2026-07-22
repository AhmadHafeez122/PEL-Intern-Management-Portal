<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\Department;
use App\Models\Intern;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = Supervisor::with('department')->withCount('interns')->latest()->paginate(15);
        return view('admin.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.supervisors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors,email|max:255',
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'required|boolean',
        ]);

        Supervisor::create($validated);

        return redirect()->route('admin.supervisors.index')
            ->with('success', 'Supervisor successfully added.');
    }

    public function edit(Supervisor $supervisor)
    {
        $departments = Department::all();
        return view('admin.supervisors.edit', compact('supervisor', 'departments'));
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:supervisors,email,' . $supervisor->id,
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'required|boolean',
        ]);

        $supervisor->update($validated);

        return redirect()->route('admin.supervisors.index')
            ->with('success', 'Supervisor updated successfully.');
    }

    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();
        return redirect()->route('admin.supervisors.index')
            ->with('success', 'Supervisor removed successfully.');
    }

    /**
     * Show the master page to assign interns to ANY supervisor.
     */
    public function assign()
    {
        // Fetch all active supervisors for the dropdown
        $supervisors = Supervisor::with('department')->get();

        // Fetch interns that do not have a supervisor assigned yet
        $unassignedInterns = Intern::whereNull('supervisor_id')->with('department')->get();

        return view('admin.supervisors.assign', compact('supervisors', 'unassignedInterns'));
    }

    /**
     * Store the assigned interns for the selected supervisor from the dropdown.
     */
    public function storeAssign(Request $request)
    {
        // Validate that both a supervisor and at least one intern were selected
        $request->validate([
            'supervisor_id' => 'required|exists:supervisors,id',
            'intern_ids' => 'required|array',
            'intern_ids.*' => 'exists:interns,id',
        ]);

        // Find the supervisor selected in the form
        $supervisor = Supervisor::findOrFail($request->supervisor_id);

        // Update all selected interns in one query
        // We also sync their department to match the supervisor's department
        Intern::whereIn('id', $request->intern_ids)->update([
            'supervisor_id' => $supervisor->id,
            'department_id' => $supervisor->department_id,
        ]);

        return redirect()->route('admin.supervisors.index')
            ->with('success', count($request->intern_ids) . ' Intern(s) successfully assigned to ' . $supervisor->name);
    }
}
