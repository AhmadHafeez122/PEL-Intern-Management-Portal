<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $attendances = Attendance::with(['intern.department'])->whereDate('date', $date)->get();

        return view('admin.attendance.index', compact('attendances', 'date'));
    }

    public function create()
    {
        $today = Carbon::today();
        $interns = Intern::with('department')->get();
        $attendances = Attendance::whereDate('date', $today)->get()->keyBy('intern_id');

        return view('admin.attendance.create', compact('interns', 'attendances', 'today'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:Present,Absent,Leave',
            'attendance.*.time_in' => 'nullable|date_format:H:i',
        ]);

        foreach ($request->attendance as $internId => $data) {
            Attendance::updateOrCreate(
                [
                    'intern_id' => $internId,
                    'date' => $request->date
                ],
                [
                    'status' => $data['status'],
                    'time_in' => $data['status'] === 'Present' ? $data['time_in'] : null,
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance records saved successfully.');
    }
}
