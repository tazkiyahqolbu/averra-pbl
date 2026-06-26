@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Barang')

@section('content')

<div class="admin-section">

    <div>
        <h1 class="admin-title text-3xl">
            Tambah Kategori Barang
        </h1>

        <p class="admin-subtitle mt-1 text-sm">
            Tambahkan kategori baru untuk barang sewa.
        </p>
    </div>

    <form
        action="{{ route('admin.kategori-barang.store') }}"
        method="POST"
        class="admin-card p-6 space-y-5"
    >

        @csrf

        <div>
            <label class="admin-label">
                Nama Kategori *
            </label>

            <input
                type="text"
                name="nama"
                class="admin-input"
                value="{{ old('nama') }}"
                placeholder="Contoh: Dekorasi"
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
            >{{ old('deskripsi') }}</textarea>
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
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection
