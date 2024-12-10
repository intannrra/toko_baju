@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Profil Pengguna</h2>

    {{-- Pesan Sukses dan Error --}}
    @if(session('success') || session('error'))
        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    {{-- Form untuk Menampilkan dan Mengedit Profil --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Kolom untuk Foto Profil --}}
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Foto Profil" class="img-thumbnail" width="150">
                        @endif
                    </div>
                    {{-- Pilihan untuk Mengganti Foto --}}
                    <input type="file" class="form-control mb-2" id="profile_picture" name="profile_picture">
                    <button type="submit" class="btn btn-secondary w-100">Change photo</button>
                </div>

                {{-- Kolom untuk Form Edit Data Pengguna --}}
                <div class="col-md-8">
                    <form action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        {{-- Nomor Handphone --}}
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>

                        {{-- Alamat Rumah --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Rumah</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (opsional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Hapus Profil --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('profil.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100">Hapus Profil</button>
            </form>
        </div>
    </div>
</div>
@endsection
