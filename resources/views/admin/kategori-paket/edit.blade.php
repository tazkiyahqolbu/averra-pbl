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
            <form action="{{ route('admin.kategori.update', ['tipe' => 'paket', 'id' => $kategori->id]) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="admin-label">Nama Kategori *</label>
                    <input name="nama" type="text" class="admin-input" value="{{ old('nama', $kategoriPaket->nama) }}"
                        required>
                </div>

                <div>
                    <label class="admin-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="admin-textarea">{{ old('deskripsi', $kategoriPaket->deskripsi) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.kategori.index', 'paket') }}" class="admin-btn-secondary">Kembali</a>
                    <button type="submit" class="admin-btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
