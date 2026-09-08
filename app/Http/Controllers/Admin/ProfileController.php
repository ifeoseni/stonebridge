<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the admin profile & password screen
     */
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update user name and email
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('profile_success', 'Profile information updated successfully.');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('password_success', 'Your password has been changed successfully.');
    }
}
