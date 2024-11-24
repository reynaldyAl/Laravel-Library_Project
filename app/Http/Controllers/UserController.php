<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class UserController extends Controller

{ 
      public function showProfile()
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return redirect()->route('profile')->with('error', 'User not found.');
        }
        return view('users.profile', compact('user'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return redirect()->route('profile.edit')->with('error', 'User not found.');
        }
        return view('users.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_image' => 'nullable|image',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $file = $request->file('profile_image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('images/users', $filename, 'public');
            $user->profile_image = $path;
        }

        $this->saveUser($user);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    private function saveUser(User $user)
    {
        $user->save();
    }
}