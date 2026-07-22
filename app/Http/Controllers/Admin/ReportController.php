<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf; // Required for PDF export

class ReportController extends Controller
{
    public function index()
    {
        $totalInterns = Intern::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $attendanceRate = Attendance::count() > 0
            ? round((Attendance::where('status', 'Present')->count() / Attendance::count()) * 100)
            : 0;

        return view('admin.reports.index', compact('totalInterns', 'completedTasks', 'attendanceRate'));
    }

    public function export()
    {
        // 1. Calculate stats using the exact same logic as the index method
        $totalInterns = Intern::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $attendanceRate = Attendance::count() > 0
            ? round((Attendance::where('status', 'Present')->count() / Attendance::count()) * 100)
            : 0;

        // 2. Fetch records to display in the PDF data table (e.g., list of interns)
        // Note: Remove 'with('department')' if your Intern model does not have a department relationship
        $interns = Intern::with('department')->get();

        $data = [
            'totalInterns' => $totalInterns,
            'completedTasks' => $completedTasks,
            'attendanceRate' => $attendanceRate,
            'interns' => $interns,
            'date' => now()->format('F j, Y, g:i a'),
        ];

        // 3. Load the dedicated PDF view
        $pdf = Pdf::loadView('admin.reports.pdf', $data);

        // 4. Download the file
        return $pdf->download('PEL_System_Report_' . now()->format('Y_m_d') . '.pdf');
    }
}
