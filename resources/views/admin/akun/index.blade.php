@extends('admin.layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Profil Admin</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Kelola informasi profil admin yang sedang login.
        </p>
    </div>

    <div class="admin-card p-6">
        <form class="space-y-5">
            <div class="flex items-center gap-4">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#5A0B1A] text-2xl font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

                <div>
                    <label class="admin-label">Foto Profil</label>
                    <input type="file" class="admin-file">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="admin-label">Nama *</label>
                    <input type="text" class="admin-input" value="{{ Auth::user()->name ?? 'Admin Sanggar' }}">
                </div>

                <div>
                    <label class="admin-label">Email</label>
                    <input type="email" class="admin-input bg-gray-100" value="{{ Auth::user()->email ?? 'admin@rantiang.com' }}" readonly>
                </div>

                <div>
                    <label class="admin-label">No. HP *</label>
                    <input type="text" class="admin-input" placeholder="081234567890">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" class="admin-btn-secondary">Ganti Password</button>
                <button type="button" class="admin-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
