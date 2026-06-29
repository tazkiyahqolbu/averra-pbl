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
                <label class="admin-label">Judul Galeri <span class="text-red-600">*</span></label>
                <input
                type="text"
                name="judul"
                value="{{ old('judul',$galeri->judul) }}"
                class="admin-input"
                required>
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
                <label class="admin-label">Jenis Media <span class="text-red-600">*</span></label>
                <select name="jenis_media" id="jenis_media" class="admin-select"
                        required onchange="updateAccept(this.value)">
                    <option value="" disabled>-- Pilih jenis media --</option>
                    <option value="foto" {{ $galeri->jenis_media=='foto' ? 'selected':'' }}>Foto</option>
                    <option value="video" {{ $galeri->jenis_media=='video' ? 'selected':'' }}>Video</option>
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
                <input type="file" id="media_input" name="media_path" class="admin-file"
                       accept="{{ $galeri->jenis_media === 'video' ? '.mp4,.mov' : '.jpg,.jpeg,.png' }}"
                       onchange="previewMedia(this)">
                <div id="media-preview" class="mt-3 hidden">
                    <p class="mb-1 text-xs text-[#4A2E28]/60">Preview file baru:</p>
                    <img id="preview-img" class="h-48 rounded-xl object-cover border border-[#E2D4C0] hidden">
                    <video id="preview-vid" class="h-48 rounded-xl border border-[#E2D4C0] hidden" controls></video>
                </div>
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

<script>
function updateAccept(jenis) {
    const input = document.getElementById('media_input');
    input.accept = jenis === 'video' ? '.mp4,.mov' : '.jpg,.jpeg,.png';
    input.value = '';
    document.getElementById('media-preview').classList.add('hidden');
    document.getElementById('preview-img').classList.add('hidden');
    document.getElementById('preview-vid').classList.add('hidden');
}

function previewMedia(input) {
    if (!input.files[0]) return;
    const jenis = document.getElementById('jenis_media').value;
    const url = URL.createObjectURL(input.files[0]);
    const preview = document.getElementById('media-preview');
    const img = document.getElementById('preview-img');
    const vid = document.getElementById('preview-vid');

    preview.classList.remove('hidden');
    if (jenis === 'video') {
        img.classList.add('hidden');
        vid.src = url;
        vid.classList.remove('hidden');
    } else {
        vid.classList.add('hidden');
        img.src = url;
        img.classList.remove('hidden');
    }
}
</script>

@endsection
