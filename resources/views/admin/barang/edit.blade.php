@extends('admin.layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Edit Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">Perbarui data barang sewa, stok, nilai barang, foto, dan status.</p>
    </div>

    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 space-y-5">

    @csrf
    @method('PUT')
        <div class="grid gap-4 md:grid-cols-2">
            <div><label class="admin-label">Nama Barang *</label><input type="text" name="nama_barang" class="admin-input" value="{{ old('nama_barang', $barang->nama_barang) }}" required></div>
            <div><label class="admin-label">Kategori *</label><select name="kategori_barang_id" class="admin-select" required>
    @foreach($kategoriBarangs as $kategori)
        <option value="{{ $kategori->id }}"
            {{ old('kategori_barang_id', $barang->kategori_barang_id) == $kategori->id ? 'selected' : '' }}> {{ $kategori->nama }}
        </option>
    @endforeach
</select></div>
            <div><label class="admin-label">Harga Sewa (per hari) *</label><input type="number" name="harga" class="admin-input" value="{{ old('harga', $barang->harga) }}" required></div>
            <div><label class="admin-label">Nilai Barang *</label><input type="number" name="nilai_barang" class="admin-input" value="{{ old('nilai_barang', $barang->nilai_barang) }}" required></div>
            <div><label class="admin-label">Stok *</label><input type="number" name="stok" min="0" class="admin-input" value="{{ old('stok', $barang->stok) }}" required></div>
        </div>

        <div><label class="admin-label">Deskripsi</label><textarea name="deskripsi" class="admin-textarea">{{ old('deskripsi', $barang->deskripsi) }}</textarea></div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="1" {{ old('aktif', $barang->aktif) ? 'checked' : '' }}> Aktif</label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="0" {{ old('aktif', $barang->aktif) == 0 ? 'checked' : '' }}> Nonaktif</label>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            {{-- Foto Utama --}}
            <div>
                <label class="admin-label">Foto Utama</label>
                @if($barang->thumbnail_path)
                    <img src="{{ Storage::url($barang->thumbnail_path) }}"
                         class="mb-2 h-32 w-32 rounded-xl object-cover border border-[#E2D4C0]">
                    <p class="mb-1 text-xs text-[#4A2E28]/60">Upload baru untuk mengganti foto di atas</p>
                @endif
                <input type="file" name="thumbnail_path" class="admin-file"
                       onchange="previewFoto(this, 'preview-utama')">
                <div id="preview-utama" class="mt-2 flex gap-2 flex-wrap"></div>
            </div>

            {{-- Foto Tambahan --}}
            <div>
                <label class="admin-label">Foto Tambahan</label>
                @if($barang->fotos->isNotEmpty())
                    <div class="mb-2 flex flex-wrap gap-2">
                        @foreach($barang->fotos as $foto)
                            <img src="{{ $foto->foto_url }}"
                                 class="h-20 w-20 rounded-lg object-cover border border-[#E2D4C0]">
                        @endforeach
                    </div>
                    <p class="mb-1 text-xs text-[#4A2E28]/60">Foto baru akan ditambahkan ke yang sudah ada</p>
                @endif

                <div id="foto-tambahan-list" class="space-y-2">
                    <div class="foto-tambahan-item flex items-center gap-2">
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
            <button type="submit" class="admin-btn-primary">Simpan Perubahan</button>
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
    if (input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
    }
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
