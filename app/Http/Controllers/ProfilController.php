<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfilController extends Controller
{
    // Menampilkan daftar pengguna (Read All)
    public function index()
    {
        $users = User::all();
        return view('profil.index', compact('users'));
    }

    // Menampilkan form untuk menambah pengguna baru (Create)
    public function create()
    {
        return view('profil.create');
    }

    // Menyimpan data pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menyimpan data pengguna
        $user = new User();
        $user->fill($request->only(['name', 'email', 'phone_number']));
        $user->password = Hash::make($request->password);

        // Menyimpan foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();
        return redirect()->route('profil.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit profil pengguna (Edit)
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($this->isUnauthorized($user)) {
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat mengedit profil pengguna lain!');
        }

        return view('profil.edit', compact('user'));
    }

    // Memperbarui profil pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($this->isUnauthorized($user)) {
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat memperbarui profil pengguna lain!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data pengguna
        $user->fill($request->only(['name', 'email', 'phone_number']));

        // Update password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto profil jika ada file baru
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($this->isUnauthorized($user)) {
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat menghapus pengguna lain!');
        }

        // Hapus foto profil jika ada
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();
        return redirect()->route('homes.home')->with('success', 'Pengguna berhasil dihapus!');
    }

    // Menampilkan detail profil pengguna berdasarkan ID (Show)
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profil.show', compact('user'));
    }

    // Fungsi untuk memeriksa izin akses
    private function isUnauthorized(User $user)
    {
        return Auth::id() !== $user->id && Auth::user()->role_id !== 1; // 1 = Admin
    }
}
