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
        value="{{ old('judul') }}"
        required>
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
    <label class="admin-label">Jenis Media <span class="text-red-600">*</span></label>

    <select
        name="jenis_media"
        id="jenis_media"
        class="admin-select"
        required
        onchange="updateAccept(this.value)">

        <option value="" disabled selected>-- Pilih jenis media --</option>
        <option value="foto" {{ old('jenis_media') === 'foto' ? 'selected' : '' }}>Foto</option>
        <option value="video" {{ old('jenis_media') === 'video' ? 'selected' : '' }}>Video</option>

    </select>
    </div>

            <div>
                <label class="admin-label">Media <span class="text-red-600">*</span></label>
                <input
                    type="file"
                    id="media_input"
                    name="media_path"
                    class="admin-file disabled:opacity-40 disabled:cursor-not-allowed"
                    accept=".jpg,.jpeg,.png"
                    disabled
                    onchange="previewMedia(this)">
                <p id="media-hint" class="mt-1 text-xs text-[#4A2E28]/50">Pilih jenis media terlebih dahulu.</p>
                <div id="media-preview" class="mt-3 hidden">
                    <img id="preview-img" class="h-48 rounded-xl object-cover border border-[#E2D4C0] hidden">
                    <video id="preview-vid" class="h-48 rounded-xl border border-[#E2D4C0] hidden" controls></video>
                </div>
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

<script>
function updateAccept(jenis) {
    const input = document.getElementById('media_input');
    const hint  = document.getElementById('media-hint');
    input.accept = jenis === 'video' ? '.mp4,.mov' : '.jpg,.jpeg,.png';
    input.value  = '';
    input.disabled = false;
    hint.classList.add('hidden');
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
