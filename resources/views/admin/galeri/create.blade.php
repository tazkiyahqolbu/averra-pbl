@extends('admin.layouts.app')

@section('title', 'Upload Foto Galeri')

@section('content')
<div class="admin-section">

    <div class="admin-card p-6">
        <form
        action="{{ route('admin.galeri.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5">
        @csrf

        <div>
    <label class="admin-label">Judul *</label>

    <input
        type="text"
        name="judul"
        class="admin-input"
        value="{{ old('judul') }}">
    </div>

    <div>
    <label class="admin-label">Kategori</label>

    <input
        type="text"
        name="kategori"
        class="admin-input"
        value="{{ old('kategori') }}">
    </div>

    <div>
    <label class="admin-label">Jenis Media</label>

    <select
        name="jenis_media"
        class="admin-select">

        <option value="foto">Foto</option>
        <option value="video">Video</option>

    </select>
    </div>

            <div>
                <label class="admin-label">Media *</label>
                <input
                    type="file"
                    name="media_path"
                    class="admin-file"
                    accept="image/*,video/*">
            </div>

            <div>
                <label class="admin-label">Keterangan</label>
                <textarea
                name="keterangan"
                class="admin-textarea">{{ old('keterangan') }}</textarea>
            </div>

            <div>
            <label class="admin-label">
            <input type="checkbox" name="unggulan" value="1">
            Unggulan
            </label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.galeri.index') }}" class="admin-btn-secondary">Batal</a>
                <button
                type="submit"
                class="admin-btn-primary">
                Simpan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
