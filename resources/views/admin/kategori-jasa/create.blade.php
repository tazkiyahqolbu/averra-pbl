@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Jasa')

@section('content')

    <div class="admin-section">

        <div>
            <h1 class="admin-title text-3xl">Tambah Kategori Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">Tambahkan kategori baru untuk jasa.</p>
        </div>

        <form action="{{ route('admin.kategori.store', 'jasa') }}" method="POST" class="admin-card p-6 space-y-5">
            @csrf

            <div>
                <label class="admin-label">Nama Kategori *</label>
                <input type="text" name="nama" class="admin-input" value="{{ old('nama') }}"
                    placeholder="Contoh: Rias Pengantin" required>
            </div>

            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="admin-textarea">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.kategori.index', 'jasa') }}" class="admin-btn-secondary">Batal</a>
                <button type="submit" class="admin-btn-primary">Simpan</button>
            </div>
        </form>

    </div>

@endsection
