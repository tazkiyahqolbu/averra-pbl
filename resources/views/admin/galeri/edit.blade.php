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

    <form action="#" class="admin-card space-y-6 p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="admin-label">Judul Galeri</label>
                <input type="text" class="admin-input" value="Pernikahan Adat Minang">
            </div>

            <div>
                <label class="admin-label">Kategori</label>
                <select class="admin-select">
                    <option selected>Pernikahan</option>
                    <option>Hiburan</option>
                    <option>Pertunjukan</option>
                    <option>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Jenis Media</label>
                <select class="admin-select">
                    <option selected>Foto</option>
                    <option>Video</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Status Unggulan</label>
                <select class="admin-select">
                    <option>Tidak Unggulan</option>
                    <option selected>Unggulan</option>
                </select>
            </div>
        </div>

        <div>
            <label class="admin-label">Media Saat Ini</label>
            <div class="flex items-center gap-4">
                <div class="admin-thumb-lg flex items-center justify-center text-xs font-semibold text-[#7a5d58]">FOTO</div>
                <input type="file" class="admin-file" accept="image/*,video/*">
            </div>
        </div>

        <div>
            <label class="admin-label">Keterangan</label>
            <textarea class="admin-textarea">Dokumentasi acara pernikahan adat Minangkabau.</textarea>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-[#decba5] pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.galeri.index') }}" class="admin-btn-secondary">Kembali</a>
            <button type="button" class="admin-btn-primary">Update Galeri</button>
        </div>
    </form>
</section>
@endsection
