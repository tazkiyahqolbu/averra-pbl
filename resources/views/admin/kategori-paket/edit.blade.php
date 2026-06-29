@extends('admin.layouts.app')

@section('title', 'Edit Kategori Paket')

@section('content')
<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-3xl">Edit Kategori Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">Perbarui data kategori paket layanan sanggar.</p>
        </div>
    </div>

    <div class="admin-card p-6">
        <form action="#"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="admin-label">Nama Kategori *</label>
                <input name="nama"
                       type="text"
                       class="admin-input"
                       value="{{ old('nama', $kategoriPaket->nama) }}">
            </div>

            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea name="deskripsi"
                          rows="3"
                          class="admin-textarea">{{ old('deskripsi', $kategoriPaket->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="admin-label">Ikon / Foto Kategori Baru</label>
                <input name="ikon_path"
                       type="file"
                       class="admin-file"
                       accept="image/*">
            </div>

            @if ($kategoriPaket->ikon_path)
                <div>
                    <label class="admin-label">Ikon Saat Ini</label>
                    <img src="{{ asset('storage/' . $kategoriPaket->ikon_path) }}"
                         class="admin-thumb-lg object-cover">
                    <p class="mt-1 text-xs text-[#4A2E28]">
                        Kosongkan jika tidak ingin mengganti.
                    </p>
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-2">
                <a href="#"
                   class="admin-btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="admin-btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
