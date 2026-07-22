<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Try to find an approved intern record first
        $intern = null;
        try {
            if (Schema::hasTable('interns')) {
                $intern = DB::table('interns')->where('email', $user->email)->first();
            }
        } catch (\Exception $e) {
            $intern = null;
        }

        // 2. If no approved intern record, check if they have a pending application
        if (!$intern) {
            try {
                if (Schema::hasTable('applications')) {
                    $intern = DB::table('applications')->where('user_id', $user->id)->first();
                }
            } catch (\Exception $e) {
                $intern = null;
            }
        }

        // 3. Setup safe dashboard data regardless of their status (Active, Pending, or null)
        $status = $intern->status ?? 'Not Applied';

        $internData = (object) [
            'name' => $intern->name ?? $user->name,
            'email' => $intern->email ?? $user->email,
            'university' => $intern->university ?? 'Not Provided',
            'department_name' => $intern->department_name ?? 'Not Provided',
            'registration_number' => $intern->registration_number ?? 'N/A',
            'status' => $status,
            'created_at' => $intern->created_at ?? $user->created_at,
            'updated_at' => $intern->updated_at ?? $user->updated_at,
        ];

        // 4. Safely load supervisor if assigned
        $supervisor = null;
        try {
            if (!empty($intern->supervisor_id)) {
                $supervisor = DB::table('users')->where('id', $intern->supervisor_id)->first();
            }
        } catch (\Exception $e) {
            $supervisor = null;
        }

        // 5. Safely load tasks
        $tasks = collect();
        try {
            if (Schema::hasTable('tasks') && $intern && isset($intern->id)) {
                if (Schema::hasColumn('tasks', 'intern_id')) {
                    $tasks = DB::table('tasks')->where('intern_id', $intern->id)->latest()->get();
                } elseif (Schema::hasColumn('tasks', 'user_id')) {
                    $tasks = DB::table('tasks')->where('user_id', $user->id)->latest()->get();
                }
            }
        } catch (\Exception $e) {
            $tasks = collect();
        }

        // 6. Safely load announcements
        $announcements = collect();
        try {
            if (Schema::hasTable('announcements')) {
                $announcements = DB::table('announcements')->latest()->take(5)->get();
            }
        } catch (\Exception $e) {
            $announcements = collect();
        }

        // 7. Calculate stats safely
        $totalTasks = $tasks->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $completedTasks = $tasks->where('status', 'completed')->count();

        $attendanceCount = 0;
        try {
            if (Schema::hasTable('attendances') && Schema::hasColumn('attendances', 'user_id')) {
                $attendanceCount = DB::table('attendances')->where('user_id', $user->id)->where('status', 'Present')->count();
            }
        } catch (\Exception $e) {
            $attendanceCount = 0;
        }

        $performanceScore = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) . '%' : '100%';

        $stats = [
            'total_tasks' => $totalTasks,
            'pending_tasks' => $pendingTasks,
            'completed_tasks' => $completedTasks,
            'attendance' => $attendanceCount . ' Days',
            'gpa_or_score' => $performanceScore,
        ];

        // ALWAYS return the dashboard view (no missing view errors will trigger)
        return view('student.dashboard', compact('user', 'internData', 'supervisor', 'tasks', 'announcements', 'stats'));
    }

    // Handle saving the internship application into the 'applications' table
    public function storeApplication(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'university' => 'required|string|max:255',
            'department_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255|unique:applications',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        DB::table('applications')->insert([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'university' => $request->university,
            'department_name' => $request->department_name,
            'registration_number' => $request->registration_number,
            'cv_path' => $cvPath,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully! Waiting for admin approval.');
    }
}
