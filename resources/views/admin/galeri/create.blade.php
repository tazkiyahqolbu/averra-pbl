@extends('admin.layouts.app')

@section('title', 'Upload Foto Galeri')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Upload Foto Galeri</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Tambahkan dokumentasi kegiatan sanggar ke galeri publik.
        </p>
    </div>

    <div class="admin-card p-6">
        <form class="space-y-5">
            <div>
                <label class="admin-label">Foto *</label>
                <input type="file" class="admin-file" multiple>
                <p class="admin-muted mt-2 text-xs">Bisa upload lebih dari satu foto.</p>
            </div>

            <div>
                <label class="admin-label">Keterangan</label>
                <input type="text" class="admin-input" placeholder="Contoh: Pernikahan Andi & Siti">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.galeri.index') }}" class="admin-btn-secondary">Batal</a>
                <button type="button" class="admin-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
