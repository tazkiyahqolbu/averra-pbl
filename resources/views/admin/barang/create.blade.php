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
            <div><label class="admin-label">Nama Barang *</label><input type="text" name="nama_barang" class="admin-input" placeholder="Kamera Canon EOS R50" value="{{ old('nama_barang') }}"></div>
            <div><label class="admin-label">Kategori *</label>
            <select name="kategori_barang_id" class="admin-select">
                <option value="">Pilih kategori</option>
                @foreach($kategoriBarangs as $kategori)
                    <option
                        value="{{ $kategori->id }}"
                        {{ old('kategori_barang_id') == $kategori->id ? 'selected' : '' }}>

                        {{ $kategori->nama }}

                    </option>
                @endforeach
            </select></div>
            <div><label class="admin-label">Harga Sewa (per hari) *</label><input type="number" name="harga" class="admin-input" value="{{ old('harga') }}"></div>
            <div><label class="admin-label">Nilai Barang *</label><input type="number" name="nilai_barang" class="admin-input" value="{{ old('nilai_barang') }}"></div>
            <div><label class="admin-label">Stok *</label><input type="number" name="stok" class="admin-input" min="0" value="{{ old('stok') }}"></div>
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
            <div><label class="admin-label">Foto Utama *</label><input type="file" name="thumbnail_path" class="admin-file"></div>
            <div><label class="admin-label">Foto Tambahan</label><input type="file" class="admin-file" multiple></div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
