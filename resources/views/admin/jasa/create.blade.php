@extends('admin.layouts.app')

@section('title', 'Tambah Jasa')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Tambah Jasa</h1>
        <p class="admin-subtitle mt-1 text-sm">Lengkapi data jasa sesuai katalog layanan Sanggar Rantiang Tagok.</p>
    </div>

    <form class="admin-card p-6 space-y-5">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Nama Jasa *</label>
                <input type="text" class="admin-input" placeholder="Contoh: MC Pernikahan">
            </div>
            <div>
                <label class="admin-label">Kategori *</label>
                <select class="admin-select"><option>Pilih kategori</option><option>MC</option><option>Pertunjukan Tari</option><option>Makeup</option><option>Band/Akustik</option></select>
            </div>
            <div>
                <label class="admin-label">Harga *</label>
                <input type="text" class="admin-input" placeholder="Rp 1.500.000">
            </div>
            <div>
                <label class="admin-label">Maks. Booking/Hari *</label>
                <input type="number" class="admin-input" placeholder="4" min="1">
            </div>
        </div>

        <div>
            <label class="admin-label">Deskripsi</label>
            <textarea class="admin-textarea" placeholder="Jelaskan layanan, durasi, dan ketentuan jasa..."></textarea>
        </div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="status" checked> Aktif</label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="status"> Nonaktif</label>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Foto Utama *</label>
                <input type="file" class="admin-file">
            </div>
            <div>
                <label class="admin-label">Foto Tambahan</label>
                <input type="file" class="admin-file" multiple>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.jasa.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="button" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
