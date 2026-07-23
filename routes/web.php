<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// -------------------------------------------------------------------------
// ADMIN CONTROLLERS
// -------------------------------------------------------------------------
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ReportController;

// -------------------------------------------------------------------------
// STUDENT/INTERN CONTROLLERS
// -------------------------------------------------------------------------
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

// =========================================================================
// PUBLIC ROUTES
// =========================================================================
Route::get('/', function () {
    return view('welcome');
});

// AI Chatbot API
use App\Http\Controllers\ChatbotController;
Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');

// =========================================================================
// SMART DASHBOARD REDIRECT (Handles login routing based on role)
// =========================================================================
Route::get('/dashboard', function (Request $request) {
    /** @var \App\Models\User $user */
    $user = $request->user();

    // Redirect admins to the admin dashboard
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Default redirect for regular users (interns/students)
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================================
// PROTECTED ADMIN ROUTES
// =========================================================================
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Main Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');

    // Master Assignment Routes
    Route::get('/assign-interns', [SupervisorController::class, 'assign'])->name('supervisors.assign');
    Route::post('/assign-interns', [SupervisorController::class, 'storeAssign'])->name('supervisors.store-assign');

    // Explicit Route for Updating Application Status (Approve / Reject)
    Route::patch('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // Standard CRUD Resource Routes
    Route::resource('interns', InternController::class);
    Route::resource('supervisors', SupervisorController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('applications', ApplicationController::class);

    // Attendance Logs & Marking
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/mark', [AttendanceController::class, 'store'])->name('attendance.store');

    // System Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

});

// =========================================================================
// PROTECTED STUDENT/INTERN ROUTES
// =========================================================================
Route::middleware(['auth', 'verified'])->prefix('student')->name('student.')->group(function () {

    // Student Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Application Form Submission
    Route::post('/application', [StudentDashboardController::class, 'storeApplication'])->name('application.store');

    // Quick Attendance Check-in
    Route::post('/attendance/checkin', function () {
        return back()->with('success', 'Checked in successfully!');
    })->name('attendance.checkin');

});

// =========================================================================
// DEFAULT PROFILE ROUTES (Laravel Breeze)
// =========================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// AUTHENTICATION ROUTES (Provided by Breeze)
// =========================================================================
require __DIR__.'/auth.php';
