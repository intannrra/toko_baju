<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Autentikasi pengguna
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Regenerasi sesi untuk keamanan
            return redirect()->route('homes.home')->with('success', 'Login berhasil.');
        }

        // Jika gagal login
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
            'password' => ['required', 'string', Password::min(8)],
            'role' => ['required', 'string', 'in:admin,user'], // Validasi role
        ]);

        // Cek apakah email sudah terdaftar
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->route('auth.register')->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
            'role' => $request->role, // Menetapkan role pengguna
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('auth.login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus sesi aktif
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('auth.login')->with('success', 'Anda telah keluar.');
    }
}
