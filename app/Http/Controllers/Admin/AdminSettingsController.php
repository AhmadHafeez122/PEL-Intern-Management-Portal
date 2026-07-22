<?php

namespace App\Http\Controllers\Admin;

// You MUST import the base Controller since this is inside the Admin subfolder
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function index(Request $request)
    {
        // Changed from 'admin.settings' to 'admin.setting' to match your blade file
        return view('admin.settings', [
            'user' => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        // Use $request->user() instead of querying the DB again with User::find()
        $user = $request->user();

        if (!$user) {
            return back()->withErrors(['error' => 'User not found or unauthenticated.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // Replaced manual check with Laravel's built-in 'current_password' rule
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('new_password')) {
            // No need for Hash::check() here anymore, the validation rule handled it
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return back()->with('success', 'Profile credentials updated successfully!');
    }
}
