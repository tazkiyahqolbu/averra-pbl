@extends('admin.layouts.app')

@section('title', 'Tambah Paket')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Tambah Paket</h1>
        <p class="admin-subtitle mt-1 text-sm">Lengkapi data paket, isi paket, item opsional, dan foto katalog.</p>
    </div>

    <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Informasi Paket</h2>
                <p class="admin-muted mt-1 text-sm">Isi data utama paket yang akan tampil pada katalog.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama_paket" class="admin-label">Nama Paket <span class="text-red-600">*</span></label>
                    <input id="nama_paket" name="nama_paket" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Paket Pernikahan Adat Minang">
                </div>

                <div>
                    <label for="kategori_paket_id" class="admin-label">Kategori Paket <span class="text-red-600">*</span></label>
                    <select id="kategori_paket_id" name="kategori_paket_id" class="admin-select focus:admin-input-focus">
                        <option value="">Pilih kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="harga" class="admin-label">Harga <span class="text-red-600">*</span></label>
                    <input id="harga" name="harga" type="number" min="0" class="admin-input focus:admin-input-focus" placeholder="Contoh: 8500000">
                </div>

                <div>
                    <label for="keterangan_acara" class="admin-label">Keterangan Acara</label>
                    <input id="keterangan_acara" name="keterangan_acara" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Akad dan resepsi">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="admin-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="admin-textarea focus:admin-input-focus" placeholder="Tuliskan deskripsi paket..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="catatan" class="admin-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="admin-textarea focus:admin-input-focus" placeholder="Catatan tambahan paket jika ada..."></textarea>
                </div>

                <div>
                    <label for="thumbnail_path" class="admin-label">Thumbnail</label>
                    <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file">
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-[#E2D4C0] bg-[#ffffff] p-4">
                    <input id="aktif" name="aktif" type="checkbox" value="1" checked class="h-5 w-5 rounded border-[#E2D4C0] text-[#4A0F1A]">
                    <div>
                        <label for="aktif" class="font-semibold text-[#4a0f1a]">Paket Aktif</label>
                        <p class="admin-muted text-xs">Jika aktif, paket dapat ditampilkan pada katalog.</p>
                    </div>
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
                <div class="flex justify-between rounded-2xl bg-[#FAF3E0] p-3"><span>Fotografer 2 Orang x2</span><button class="font-semibold text-red-600">Hapus</button></div>
                <div class="flex justify-between rounded-2xl bg-[#FAF3E0] p-3"><span>MC Profesional x1</span><button class="font-semibold text-red-600">Hapus</button></div>
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
                <div class="flex justify-between rounded-2xl bg-[#FAF3E0] p-3"><span>Fotografer Extra +Rp 300.000</span><button class="font-semibold text-red-600">Hapus</button></div>
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
            <button type="button" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
