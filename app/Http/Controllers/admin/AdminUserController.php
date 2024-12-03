<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $users = User::with('role')->get(); // Pastikan Anda memiliki relasi role di model User
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $roles = Role::all(); // Ambil semua peran
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        
        //'/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.ac\.id$/'

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role_id == Role::where('name', 'mahasiswa')->first()->id) {
                        if (!preg_match('/^[a-zA-Z0-9._%+-]+@(ui\.ac\.id|itb\.ac\.id|ugm\.ac\.id|ipb\.ac\.id|its\.ac\.id|undip\.ac\.id|unair\.ac\.id|unhas\.ac\.id|uns\.ac\.id|unsri\.ac\.id|unpad\.ac\.id|ub\.ac\.id|usu\.ac\.id|unand\.ac\.id|untan\.ac\.id|unmul\.ac\.id|unsyiah\.ac\.id|unram\.ac\.id|unja\.ac\.id|unsrat\.ac\.id)$/', $value)) {
                            $fail('The email must be a valid university email address.');
                        }
                    }
                },
            ],
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Validasi peran
        ], [
            'email.regex' => 'The email must be a valid university email address.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Simpan peran pengguna
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $roles = Role::all(); // Ambil semua peran
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role_id == Role::where('name', 'mahasiswa')->first()->id) {
                        if (!preg_match('/^[a-zA-Z0-9._%+-]+@(ui\.ac\.id|itb\.ac\.id|ugm\.ac\.id|ipb\.ac\.id|its\.ac\.id|undip\.ac\.id|unair\.ac\.id|unhas\.ac\.id|uns\.ac\.id|unsri\.ac\.id|unpad\.ac\.id|ub\.ac\.id|usu\.ac\.id|unand\.ac\.id|untan\.ac\.id|unmul\.ac\.id|unsyiah\.ac\.id|unram\.ac\.id|unja\.ac\.id|unsrat\.ac\.id)$/', $value)) {
                            $fail('The email must be a valid university email address.');
                        }
                    }
                },
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Validasi peran
        ], [
            'email.regex' => 'The email must be a valid university email address.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id, // Simpan peran pengguna
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}