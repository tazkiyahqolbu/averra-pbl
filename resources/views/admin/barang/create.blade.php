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
            <div>
                <label class="admin-label">Foto Utama</label>
                <input type="file" name="thumbnail_path" class="admin-file"
                       onchange="previewFoto(this, 'preview-utama')">
                <div id="preview-utama" class="mt-2 flex gap-2 flex-wrap"></div>
            </div>
            <div>
                <label class="admin-label">Foto Tambahan</label>
                <div id="foto-tambahan-list" class="space-y-2">
                    <div class="foto-item flex items-center gap-2">
                        <input type="file" name="foto_tambahan[]" class="admin-file flex-1"
                               onchange="previewSingle(this)">
                    </div>
                </div>
                <button type="button" onclick="tambahFoto('foto-tambahan-list', 'foto_tambahan[]')"
                        class="mt-2 flex items-center gap-1.5 text-sm text-[#C8960C] hover:text-[#B8983A] font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Foto
                </button>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>
<script>
function previewFoto(input, previewId) {
    const container = document.getElementById(previewId);
    container.innerHTML = '';
    if (!input.files.length) return;
    Array.from(input.files).forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'h-24 w-24 object-cover rounded-lg border border-[#E2D4C0]';
        container.appendChild(img);
    });
}

function previewSingle(input) {
    let preview = input.parentElement.querySelector('.preview-img');
    if (!preview) {
        preview = document.createElement('img');
        preview.className = 'preview-img h-16 w-16 rounded-lg object-cover border border-[#E2D4C0] shrink-0';
        input.parentElement.appendChild(preview);
    }
    if (input.files[0]) preview.src = URL.createObjectURL(input.files[0]);
}

function tambahFoto(listId, inputName) {
    const list = document.getElementById(listId);
    const div = document.createElement('div');
    div.className = 'foto-item flex items-center gap-2';
    div.innerHTML = `
        <input type="file" name="${inputName}" class="admin-file flex-1" onchange="previewSingle(this)">
        <button type="button" onclick="this.parentElement.remove()"
                class="text-red-400 hover:text-red-600 text-xs shrink-0">Hapus</button>
    `;
    list.appendChild(div);
}
</script>

@endsection
