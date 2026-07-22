<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Models\Supervisor;
use App\Models\Department;
use App\Models\Task;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Top Stat Cards Data
        $totalInterns = Intern::count();
        $activeSupervisors = Supervisor::where('is_active', true)->count();
        $pendingApprovals = Intern::where('status', 'Pending')->count();

        // 2. Attendance Calculation
        $totalAttendanceRecords = Attendance::count();
        $presentRecords = Attendance::where('status', 'Present')->count();
        $overallAttendance = $totalAttendanceRecords > 0
            ? round(($presentRecords / $totalAttendanceRecords) * 100)
            : 0; // Defaulting to 0 if no records exist

        // 3. Recent Interns for the Table
        $recentInterns = Intern::with(['department', 'supervisor'])
            ->latest()
            ->take(5)
            ->get();

        // 4. Department Distribution for Chart.js
        // Gets all departments and counts how many interns belong to each
        $departments = Department::withCount('interns')->get();

        $deptChartLabels = $departments->pluck('name')->toArray();
        $deptChartData = $departments->pluck('interns_count')->toArray();

        // Fallback if database is empty so the chart doesn't crash on a fresh install
        if (empty($deptChartLabels)) {
            $deptChartLabels = ['No Departments Yet'];
            $deptChartData = [1];
        }

        return view('admin.dashboard', compact(
            'totalInterns',
            'activeSupervisors',
            'pendingApprovals',
            'overallAttendance',
            'recentInterns',
            'deptChartLabels',
            'deptChartData'
        ));
    }
}
