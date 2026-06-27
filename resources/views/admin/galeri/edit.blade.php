@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')
<section class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-2xl">Edit Galeri</h1>
            <p class="admin-subtitle mt-1">Perbarui data dokumentasi kegiatan sanggar.</p>
        </div>
    </div>

    <form action="{{ route('admin.galeri.update',$galeri->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="admin-card space-y-6 p-6">
        @csrf
        @method('PUT')
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="admin-label">Judul Galeri</label>
                <input
                type="text"
                name="judul"
                value="{{ old('judul',$galeri->judul) }}"
                class="admin-input">
            </div>

            <div>
                <label class="admin-label">Kategori</label>
                <input
                type="text"
                name="kategori"
                value="{{ old('kategori',$galeri->kategori) }}"
                class="admin-input">
            </div>

            <div>
                <label class="admin-label">Jenis Media</label>
                <select name="jenis_media" class="admin-select">
            <option
            value="foto"
            {{ $galeri->jenis_media=='foto' ? 'selected':'' }}>
            Foto
            </option>

            <option
            value="video"
            {{ $galeri->jenis_media=='video' ? 'selected':'' }}>
            Video
            </option>
            </select>
            </div>

            <div>
                <label class="admin-label">Status Unggulan</label>
                <input
                type="checkbox"
                name="unggulan"
                value="1"
                {{ $galeri->unggulan ? 'checked':'' }}>
            </div>
        </div>

        <div>
            <label class="admin-label">Media Saat Ini</label>
            <div class="flex items-center gap-4">
                <div class="admin-thumb-lg flex items-center justify-center text-xs font-semibold text-[#4A2E28]">
                    @if($galeri->jenis_media=='foto')

                <img
                src="{{ asset('storage/'.$galeri->media_path) }}"
                class="admin-thumb-lg object-cover">

                @else

                <video
                class="admin-thumb-lg"
                controls>

                <source
                src="{{ asset('storage/'.$galeri->media_path) }}">

                </video>

                @endif
                </div>
                <input type="file" name="media_path" class="admin-file" accept="image/*,video/*">
            </div>
        </div>

        <div>
            <label class="admin-label">Keterangan</label>
            <textarea
            name="keterangan"
            class="admin-textarea">{{ old('keterangan',$galeri->keterangan) }}</textarea>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-[#E2D4C0] pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.galeri.index') }}" class="admin-btn-secondary">Kembali</a>
            <button type="submit" class="admin-btn-primary">
            Update Galeri
            </button>
        </div>
    </form>
</section>
@endsection
