@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Paket')

@section('content')
<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-3xl">Tambah Kategori Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">Tambahkan kategori baru untuk data paket layanan sanggar.</p>
        </div>
    </div>

    <div class="admin-card p-6">
        <form action="#"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <div>
                <label class="admin-label">Nama Kategori *</label>
                <input name="nama"
                       type="text"
                       class="admin-input"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Paket Pernikahan">
            </div>

            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea name="deskripsi"
                          rows="3"
                          class="admin-textarea"
                          placeholder="Deskripsi singkat kategori">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="admin-label">Ikon / Foto Kategori</label>
                <input name="ikon_path"
                       type="file"
                       class="admin-file"
                       accept="image/*">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="#"
                   class="admin-btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="admin-btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
