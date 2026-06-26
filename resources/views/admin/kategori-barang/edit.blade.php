@extends('admin.layouts.app')

@section('title', 'Edit Kategori Barang')

@section('content')

<div class="admin-section">

    <div>
        <h1 class="admin-title text-3xl">
            Edit Kategori Barang
        </h1>

        <p class="admin-subtitle mt-1 text-sm">
            Perbarui data kategori barang.
        </p>
    </div>

    <form
        action="{{ route('admin.kategori-barang.update', $kategori->id) }}"
        method="POST"
        class="admin-card p-6 space-y-5"
    >

        @csrf
        @method('PUT')

        <div>
            <label class="admin-label">
                Nama Kategori *
            </label>

            <input
                type="text"
                name="nama"
                class="admin-input"
                value="{{ old('nama', $kategori->nama) }}"
            >
        </div>

        <div>
            <label class="admin-label">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                class="admin-textarea"
                rows="4"
            >{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.kategori-barang.index') }}"
                class="admin-btn-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="admin-btn-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection
