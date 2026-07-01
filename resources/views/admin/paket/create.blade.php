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
                    <input id="nama_paket" name="nama_paket" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Paket Pernikahan Adat Minang" required>
                </div>

                <div>
                    <label for="kategori_paket_id" class="admin-label">Kategori Paket <span class="text-red-600">*</span></label>
                    <select id="kategori_paket_id" name="kategori_paket_id" class="admin-select focus:admin-input-focus" required>
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
                    <input id="harga" name="harga" type="number" min="0" class="admin-input focus:admin-input-focus" placeholder="Contoh: 8500000" required>
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

            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="admin-title text-xl">Isi Paket</h2>
                    <p class="admin-muted mt-1 text-sm">Pilih dari daftar jasa atau ketik nama item sendiri. Tipe "Opsional" berarti item bisa dipilih customer dengan biaya tambahan.</p>
                </div>
                <button type="button" onclick="tambahItem()" class="admin-btn-secondary">+ Tambah Item</button>
            </div>

            <div id="item-container" class="space-y-4">
                <p id="empty-notice" class="rounded-2xl border border-dashed border-[#E2D4C0] p-8 text-center admin-muted text-sm">
                    Belum ada item. Klik "+ Tambah Item" untuk menambahkan.
                </p>
            </div>
        </div>

        <div class="admin-card p-6 space-y-5">
            <div>
                <h2 class="admin-title text-xl">Foto</h2>
                <p class="admin-muted mt-1 text-sm">Upload foto utama dan foto tambahan untuk ditampilkan di katalog.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                            <div x-data="{ preview: null }">
                <label class="admin-label">Foto Utama</label>
                <input type="file" name="thumbnail_path" class="admin-file" accept="image/*"
                    @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                <div class="mt-2" x-show="preview">
                    <img :src="preview" class="h-24 w-24 object-cover rounded-lg border border-[#E2D4C0]">
                </div>
            </div>
                            <div x-data="{ items: [{ id: Date.now(), preview: null }] }">
                <label class="admin-label">Foto Tambahan</label>
                <template x-for="(item, index) in items" :key="item.id">
                    <div class="foto-item flex items-center gap-2 mb-2">
                        <input type="file" name="foto_tambahan[]" class="admin-file flex-1" accept="image/*"
                            @change="item.preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                        <img x-show="item.preview" :src="item.preview" class="h-16 w-16 rounded-lg object-cover border border-[#E2D4C0]">
                        <button type="button" x-show="items.length > 1" @click="items = items.filter(i => i.id !== item.id)"
                                class="text-red-400 hover:text-red-600 text-xs">Hapus</button>
                    </div>
                </template>
                <button type="button" @click="items.push({ id: Date.now(), preview: null })"
                        class="mt-2 flex items-center gap-1.5 text-sm text-[#C8960C] hover:text-[#B8983A] font-medium transition">
                    + Tambah Foto
                </button>
            </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3 mt-2">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="1" checked> Aktif</label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="0"> Nonaktif</label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>

@endsection
