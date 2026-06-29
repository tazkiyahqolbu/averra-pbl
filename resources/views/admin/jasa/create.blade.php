@extends('admin.layouts.app')

@section('title', 'Tambah Jasa')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Tambah Jasa</h1>
        <p class="admin-subtitle mt-1 text-sm">Lengkapi data jasa sesuai katalog layanan Sanggar Rantiang Tagok.</p>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <p class="font-semibold mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jasa.store') }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 space-y-5">
        @csrf

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Nama Jasa *</label>
                <input type="text" name="nama_jasa" class="admin-input" placeholder="Contoh: MC Pernikahan"
                       value="{{ old('nama_jasa') }}" required>
            </div>
            <div>
                <label class="admin-label">Kategori *</label>
                <select name="kategori_jasa_id" class="admin-select" required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_jasa_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="admin-label">Harga *</label>
                <input type="number" name="harga" class="admin-input" placeholder="1500000" min="0"
                       value="{{ old('harga') }}" required>
            </div>
            <div>
                <label class="admin-label">Maks. Booking/Hari *</label>
                <input type="number" name="maks_booking_harian" class="admin-input" placeholder="4" min="1"
                       value="{{ old('maks_booking_harian') }}" required>
            </div>
        </div>

        <div>
            <label class="admin-label">Deskripsi</label>
            <textarea name="deskripsi" class="admin-textarea" placeholder="Jelaskan layanan, durasi, dan ketentuan jasa...">{{ old('deskripsi') }}</textarea>
        </div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm">
                    <input type="radio" name="aktif" value="1" {{ old('aktif', '1') == '1' ? 'checked' : '' }}> Aktif
                </label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm">
                    <input type="radio" name="aktif" value="0" {{ old('aktif') == '0' ? 'checked' : '' }}> Nonaktif
                </label>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Foto Utama</label>
                <input type="file" name="thumbnail_path" class="admin-file" accept="image/*"
                       onchange="previewSingle(this, 'preview-utama')">
                <div id="preview-utama" class="mt-2"></div>
            </div>
            <div>
                <label class="admin-label">Foto Tambahan</label>
                <div id="foto-jasa-list" class="space-y-2">
                    <div class="foto-item flex items-center gap-2">
                        <input type="file" name="foto_jasa[]" class="admin-file flex-1" accept="image/*"
                               onchange="previewSingle(this)">
                    </div>
                </div>
                <button type="button" onclick="tambahFoto('foto-jasa-list', 'foto_jasa[]')"
                        class="mt-2 flex items-center gap-1.5 text-sm text-[#C8960C] hover:text-[#B8983A] font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Foto
                </button>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.jasa.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
function previewSingle(input, previewId) {
    if (previewId) {
        const container = document.getElementById(previewId);
        container.innerHTML = '';
        if (input.files[0]) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(input.files[0]);
            img.className = 'h-24 w-24 object-cover rounded-lg border border-[#E2D4C0]';
            container.appendChild(img);
        }
        return;
    }
    let preview = input.parentElement.querySelector('.preview-img');
    if (!preview) {
        preview = document.createElement('img');
        preview.className = 'preview-img h-16 w-16 rounded-lg object-cover border border-[#E2D4C0] shrink-0 mt-1';
        input.parentElement.appendChild(preview);
    }
    if (input.files[0]) preview.src = URL.createObjectURL(input.files[0]);
}

function tambahFoto(listId, inputName) {
    const list = document.getElementById(listId);
    const div = document.createElement('div');
    div.className = 'foto-item flex items-center gap-2';
    div.innerHTML = `
        <input type="file" name="${inputName}" class="admin-file flex-1" accept="image/*" onchange="previewSingle(this)">
        <button type="button" onclick="this.parentElement.remove()"
                class="text-red-400 hover:text-red-600 text-xs shrink-0">Hapus</button>
    `;
    list.appendChild(div);
}
</script>

@endsection
