<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(ui\.ac\.id|itb\.ac\.id|ugm\.ac\.id|ipb\.ac\.id|its\.ac\.id|undip\.ac\.id|unair\.ac\.id|unhas\.ac\.id|uns\.ac\.id|unsri\.ac\.id|unpad\.ac\.id|ub\.ac\.id|usu\.ac\.id|unand\.ac\.id|untan\.ac\.id|unmul\.ac\.id|unsyiah\.ac\.id|unram\.ac\.id|unja\.ac\.id|unsrat\.ac\.id)$/', // Validasi email universitas top di Indonesia
            ],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.regex' => 'The email must be a valid university email address.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();

        User::create([
            'name' => $request->name,   
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $mahasiswaRole->id, // Set role_id untuk mahasiswa
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}