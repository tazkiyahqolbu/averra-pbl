@extends('admin.layouts.app')

@section('title', 'Edit Paket')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Edit Paket</h1>
        <p class="admin-subtitle mt-1 text-sm">Perbarui data paket, isi paket, item opsional, foto, dan status.</p>
    </div>

    <form class="space-y-5">
        <div class="admin-card p-6 space-y-5">
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="admin-label">Nama Paket *</label><input type="text" class="admin-input" placeholder="Paket Gold Wedding"></div>
                <div><label class="admin-label">Kategori *</label><select class="admin-select"><option>Pilih kategori</option><option>Paket Pernikahan</option><option>Paket Hiburan</option></select></div>
                <div><label class="admin-label">Harga *</label><input type="text" class="admin-input" placeholder="Rp 5.000.000"></div>
                <div><label class="admin-label">Keterangan Acara</label><input type="text" class="admin-input" placeholder="Pernikahan / Hiburan / Pertunjukan"></div>
            </div>
            <div><label class="admin-label">Deskripsi</label><textarea class="admin-textarea" placeholder="Jelaskan detail paket..."></textarea></div>
            <div><label class="admin-label">Catatan</label><textarea class="admin-textarea" placeholder="Ketentuan tambahan paket..."></textarea></div>
            <div>
                <label class="admin-label">Status</label>
                <div class="flex flex-wrap gap-3">
                    <label class="rounded-2xl border border-[#decba5] bg-[#fffdf7] px-4 py-3 text-sm"><input type="radio" name="status" checked> Aktif</label>
                    <label class="rounded-2xl border border-[#decba5] bg-[#fffdf7] px-4 py-3 text-sm"><input type="radio" name="status"> Nonaktif</label>
                </div>
            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <h2 class="admin-title text-xl">Isi Paket</h2>
            <div class="grid gap-3 md:grid-cols-4">
                <select class="admin-select"><option>Jasa</option><option>Barang</option></select>
                <select class="admin-select md:col-span-2"><option>Pilih item</option><option>MC Profesional</option><option>Dekorasi Pelaminan</option></select>
                <input type="number" class="admin-input" placeholder="Qty">
            </div>
            <button type="button" class="admin-btn-secondary">+ Tambah Item</button>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between rounded-2xl bg-[#fff8ed] p-3"><span>Fotografer 2 Orang x2</span><button class="font-semibold text-red-600">Hapus</button></div>
                <div class="flex justify-between rounded-2xl bg-[#fff8ed] p-3"><span>MC Profesional x1</span><button class="font-semibold text-red-600">Hapus</button></div>
            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <h2 class="admin-title text-xl">Item Opsional</h2>
            <div class="grid gap-3 md:grid-cols-3">
                <select class="admin-select"><option>Pilih item opsional</option><option>Fotografer Extra</option><option>Dekorasi Outdoor</option></select>
                <input type="text" class="admin-input" placeholder="Harga tambahan">
                <button type="button" class="admin-btn-secondary">+ Tambah</button>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between rounded-2xl bg-[#fff8ed] p-3"><span>Fotografer Extra +Rp 300.000</span><button class="font-semibold text-red-600">Hapus</button></div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="admin-label">Foto Utama *</label><input type="file" class="admin-file"></div>
                <div><label class="admin-label">Foto Tambahan</label><input type="file" class="admin-file" multiple></div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="button" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
