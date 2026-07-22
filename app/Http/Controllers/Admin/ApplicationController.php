<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of applications from the applications table.
     */
    public function index()
    {
        $applications = DB::table('applications')->latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Update application status (Approve/Reject/Pending).
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate that the request contains the correct status
        $request->validate(['status' => 'required|in:Active,Rejected,Pending']);

        $application = DB::table('applications')->where('id', $id)->first();

        if (!$application) {
            return back()->with('error', 'Application not found.');
        }

        // Use a DB transaction to ensure both tables update successfully together
        DB::transaction(function () use ($request, $id, $application) {

            // 1. Update status in the applications table
            DB::table('applications')->where('id', $id)->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            // 2. Manage the intern record
            if ($request->status === 'Active') {
                $exists = DB::table('interns')->where('email', $application->email)->exists();

                if (!$exists) {
                    // Password column removed entirely to prevent SQL errors
                    DB::table('interns')->insert([
                        'department_id' => 1,
                        'name' => $application->name,
                        'email' => $application->email,
                        'university' => $application->university,
                        'registration_number' => $application->registration_number,
                        'status' => 'Active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('interns')->where('email', $application->email)->update([
                        'status' => 'Active',
                        'updated_at' => now(),
                    ]);
                }
            } elseif ($request->status === 'Rejected') {
                DB::table('interns')->where('email', $application->email)->update([
                    'status' => 'Rejected',
                    'updated_at' => now(),
                ]);
            }

        });

        return back()->with('success', "Application successfully marked as {$request->status}.");
    }
}
