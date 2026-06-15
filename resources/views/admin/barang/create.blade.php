@extends('admin.layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Tambah Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">Lengkapi data barang sewa sesuai kebutuhan katalog dan pengembalian.</p>
    </div>

    <form class="admin-card p-6 space-y-5">
        <div class="grid gap-4 md:grid-cols-2">
            <div><label class="admin-label">Nama Barang *</label><input type="text" class="admin-input" placeholder="Kamera Canon EOS R50"></div>
            <div><label class="admin-label">Kategori *</label><select class="admin-select"><option>Pilih kategori</option><option>Kamera</option><option>Audio/Sound</option><option>Tenda & Venue</option><option>Perlengkapan</option></select></div>
            <div><label class="admin-label">Harga Sewa (per hari) *</label><input type="text" class="admin-input" placeholder="Rp 200.000"></div>
            <div><label class="admin-label">Nilai Barang *</label><input type="text" class="admin-input" placeholder="Rp 8.000.000"></div>
            <div><label class="admin-label">Stok *</label><input type="number" class="admin-input" min="0" placeholder="3"></div>
        </div>

        <div><label class="admin-label">Deskripsi</label><textarea class="admin-textarea" placeholder="Jelaskan spesifikasi dan kondisi barang..."></textarea></div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#decba5] bg-[#fffdf7] px-4 py-3 text-sm"><input type="radio" name="status" checked> Aktif</label>
                <label class="rounded-2xl border border-[#decba5] bg-[#fffdf7] px-4 py-3 text-sm"><input type="radio" name="status"> Nonaktif</label>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div><label class="admin-label">Foto Utama *</label><input type="file" class="admin-file"></div>
            <div><label class="admin-label">Foto Tambahan</label><input type="file" class="admin-file" multiple></div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="button" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
