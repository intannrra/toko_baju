<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan untuk mengimpor model User

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file auth/login.blade.php ada
    }

    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register'); // Pastikan file auth/register.blade.php ada
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Login berhasil.'); // Redirect ke halaman dashboard setelah login
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Proses pendaftaran
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', 'in:admin,user']
        ]);

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);

        return redirect()->route('auth.login')->with('success', 'Pendaftaran berhasil. Silakan login.'); // Redirect ke halaman login
    }

    // Proses logout
    public function logout()
    {
        Auth::logout(); // Logout pengguna
        return redirect()->route('auth.login')->with('success', 'Anda telah keluar.'); // Redirect ke halaman login setelah logout
    }
}
