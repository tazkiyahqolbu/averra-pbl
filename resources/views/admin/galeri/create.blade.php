@extends('admin.layouts.app')

@section('title', 'Tambah Galeri')

@section('content')
<section class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-2xl">Tambah Galeri</h1>
            <p class="admin-subtitle mt-1">Tambahkan dokumentasi kegiatan sanggar untuk ditampilkan ke publik.</p>
        </div>
    </div>

    <form action="#" class="admin-card space-y-6 p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="admin-label">Judul Galeri</label>
                <input type="text" class="admin-input" placeholder="Contoh: Pernikahan Adat Minang">
            </div>

            <div>
                <label class="admin-label">Kategori</label>
                <select class="admin-select">
                    <option>Pernikahan</option>
                    <option>Hiburan</option>
                    <option>Pertunjukan</option>
                    <option>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Jenis Media</label>
                <select class="admin-select">
                    <option>Foto</option>
                    <option>Video</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Status Unggulan</label>
                <select class="admin-select">
                    <option>Tidak Unggulan</option>
                    <option>Unggulan</option>
                </select>
            </div>
        </div>

        <div>
            <label class="admin-label">Upload Media</label>
            <div class="admin-upload-box">
                <input type="file" class="admin-file" accept="image/*,video/*">
                <p class="admin-muted mt-3 text-sm">Gunakan foto atau video dokumentasi kegiatan sanggar.</p>
            </div>
        </div>

        <div>
            <label class="admin-label">Keterangan</label>
            <textarea class="admin-textarea" placeholder="Tulis keterangan singkat tentang dokumentasi ini..."></textarea>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-[#decba5] pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.galeri.index') }}" class="admin-btn-secondary">Kembali</a>
            <button type="button" class="admin-btn-primary">Simpan Galeri</button>
        </div>
    </form>
</section>
@endsection
