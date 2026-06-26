@extends('admin.layouts.app')

@section('title', 'Edit Kategori Jasa')

@section('content')

<div class="admin-section">

    <div>
        <h1 class="admin-title text-3xl">
            Edit Kategori Jasa
        </h1>

        <p class="admin-subtitle mt-1 text-sm">
            Perbarui kategori jasa.
        </p>
    </div>

    <form
        action="{{ route('admin.kategori-jasa.update', $kategori->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card p-6 space-y-5">

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
                value="{{ old('nama', $kategori->nama) }}">
        </div>

        <div>
            <label class="admin-label">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                rows="4"
                class="admin-textarea">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        @if($kategori->ikon_path)
            <div>
                <label class="admin-label">
                    Ikon Saat Ini
                </label>

                <img
                    src="{{ asset('storage/'.$kategori->ikon_path) }}"
                    width="120"
                    class="rounded-lg border">
            </div>
        @endif

        <div>
            <label class="admin-label">
                Ganti Ikon
            </label>

            <input
                type="file"
                name="ikon_path"
                class="admin-file">
        </div>

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('admin.kategori-jasa.index') }}"
                class="admin-btn-secondary">
                Batal
            </a>

            <button
                type="submit"
                class="admin-btn-primary">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection
