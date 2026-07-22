<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments with counts.
     */
    public function index()
    {
        // Fetch departments and count related interns and supervisors
        $departments = Department::withCount(['interns', 'supervisors'])->latest()->paginate(15);

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Store a newly created department in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'New department added successfully.');
    }

    /**
     * Remove the specified department from the database.
     */
    public function destroy(Department $department)
    {
        // Optional: Check if department has active interns before deleting
        if ($department->interns()->count() > 0) {
            return back()->with('error', 'Cannot delete department while active interns are assigned to it.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
