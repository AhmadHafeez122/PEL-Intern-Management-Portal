<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
    /**
     * Display the admin settings profile page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    /**
     * Update the admin's credentials in the database users table.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return back()->withErrors(['error' => 'User not found or unauthenticated.']);
        }

        // 1. Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Update general info
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // 3. Update password if requested
        if ($request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The provided password does not match your current password.'
                ])->withInput();
            }

            $user->password = Hash::make($request->input('new_password'));
        }

        // 4. Save changes to database
        $user->save();

        return back()->with('success', 'Profile credentials updated successfully!');
    }
}
