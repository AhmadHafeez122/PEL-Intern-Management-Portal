<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class InternController extends Controller
{
    /**
     * Display a listing of all interns.
     */
    public function index()
    {
        // Eager load relationships to prevent N+1 queries and paginate results
        $interns = Intern::with(['department', 'supervisor'])->latest()->paginate(15);

        return view('admin.interns.index', compact('interns'));
    }

    /**
     * Show the form for creating a new intern.
     */
    public function create()
    {
        // Pass departments and supervisors to the view for the dropdowns
        $departments = Department::all();
        $supervisors = Supervisor::where('is_active', true)->get();

        return view('admin.interns.create', compact('departments', 'supervisors'));
    }

    /**
     * Store a newly created intern in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:interns,email|max:255',
            'university' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:interns,registration_number|max:50',
            'department_id' => 'required|exists:departments,id',
            'supervisor_id' => 'nullable|exists:supervisors,id',
            'status' => 'required|in:Pending,Active,Completed,Rejected',
        ]);

        Intern::create($validated);

        return redirect()->route('admin.interns.index')
            ->with('success', 'New intern successfully registered.');
    }

    /**
     * Display the specified intern profile with their tasks and attendance.
     */
    public function show(Intern $intern)
    {
        // Load related tasks and attendance for the profile view
        $intern->load(['department', 'supervisor', 'tasks', 'attendances']);

        return view('admin.interns.show', compact('intern'));
    }

    /**
     * Show the form for editing the specified intern.
     */
    public function edit(Intern $intern)
    {
        $departments = Department::all();
        $supervisors = Supervisor::where('is_active', true)->get();

        return view('admin.interns.edit', compact('intern', 'departments', 'supervisors'));
    }

    /**
     * Update the specified intern in the database.
     */
    public function update(Request $request, Intern $intern)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Ignore the current intern's email and registration number during unique validation
            'email' => 'required|email|max:255|unique:interns,email,' . $intern->id,
            'university' => 'required|string|max:255',
            'registration_number' => 'required|string|max:50|unique:interns,registration_number,' . $intern->id,
            'department_id' => 'required|exists:departments,id',
            'supervisor_id' => 'nullable|exists:supervisors,id',
            'status' => 'required|in:Pending,Active,Completed,Rejected',
        ]);

        $intern->update($validated);

        return redirect()->route('admin.interns.index')
            ->with('success', 'Intern profile updated successfully.');
    }

    /**
     * Remove the specified intern from the database.
     */
    public function destroy(Intern $intern)
    {
        $intern->delete();

        return redirect()->route('admin.interns.index')
            ->with('success', 'Intern record permanently deleted.');
    }
}
