@extends('admin.layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Tambah Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">Lengkapi data barang sewa sesuai kebutuhan katalog dan pengembalian.</p>
    </div>

    <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 space-y-5">

    @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div><label class="admin-label">Nama Barang *</label><input type="text" name="nama_barang" class="admin-input" placeholder="Kamera Canon EOS R50" value="{{ old('nama_barang') }}" required></div>
            <div><label class="admin-label">Kategori *</label>
            <select name="kategori_barang_id" class="admin-select" required>
                <option value="">Pilih kategori</option>
                @foreach($kategoriBarangs as $kategori)
                    <option
                        value="{{ $kategori->id }}"
                        {{ old('kategori_barang_id') == $kategori->id ? 'selected' : '' }}>

                        {{ $kategori->nama }}

                    </option>
                @endforeach
            </select></div>
            <div><label class="admin-label">Harga Sewa (per hari) *</label><input type="number" name="harga" class="admin-input" value="{{ old('harga') }}" required></div>
            <div><label class="admin-label">Nilai Barang *</label><input type="number" name="nilai_barang" class="admin-input" value="{{ old('nilai_barang') }}" required></div>
            <div><label class="admin-label">Stok *</label><input type="number" name="stok" class="admin-input" min="0" value="{{ old('stok') }}" required></div>
        </div>

        <div><label class="admin-label">Deskripsi</label><textarea name="deskripsi" class="admin-textarea">{{ old('deskripsi') }}</textarea></div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="1" checked> Aktif</label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="0"> Nonaktif</label>
            </div>
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

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>

@endsection
