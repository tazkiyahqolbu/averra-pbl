@extends('admin.layouts.app')

@section('title', 'Edit Paket')

@section('content')

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Edit Paket</h1>
        <p class="admin-subtitle mt-1 text-sm">Perbarui data paket, isi paket, item opsional, foto, dan status.</p>
    </div>

    <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Informasi Paket</h2>
                <p class="admin-muted mt-1 text-sm">Data sudah terisi sesuai paket yang dipilih.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama_paket" class="admin-label">Nama Paket <span class="text-red-600">*</span></label>
                    <input id="nama_paket" name="nama_paket" type="text" value="{{ old('nama_paket', $paket->nama_paket) }}" class="admin-input focus:admin-input-focus" required>
                </div>

                <div>
                    <label for="kategori_paket_id" class="admin-label">Kategori Paket <span class="text-red-600">*</span></label>
                    <select id="kategori_paket_id" name="kategori_paket_id" class="admin-select focus:admin-input-focus" required>
                        <option value="">Pilih kategori</option>
                         @foreach($kategoris as $kategori)
                        <option
                            value="{{ $kategori->id }}"
                            @selected(
                                old('kategori_paket_id',
                                $paket->kategori_paket_id)
                                == $kategori->id
                            )>

                            {{ $kategori->nama }}

                        </option>

                    @endforeach
                    </select>
                </div>

                <div>
                    <label for="harga" class="admin-label">Harga <span class="text-red-600">*</span></label>
                    <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $paket->harga) }}" class="admin-input focus:admin-input-focus" required>
                </div>

                <div>
                    <label for="keterangan_acara" class="admin-label">Keterangan Acara</label>
                    <input id="keterangan_acara" name="keterangan_acara" type="text" value="{{ old('keterangan_acara', $paket->keterangan_acara) }}" class="admin-input focus:admin-input-focus">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="admin-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="admin-textarea focus:admin-input-focus">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="catatan" class="admin-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="admin-textarea focus:admin-input-focus">{{ old('catatan', $paket->catatan) }}</textarea>
                </div>

                            <div>
                <label class="admin-label">Thumbnail Saat Ini</label>
                @if ($paket->thumbnail_path)
                <img src="{{ asset('storage/' . $paket->thumbnail_path) }}" class="admin-preview-image">
                @else
                    <div class="admin-preview-image flex items-center justify-center text-sm font-semibold text-[#4A2E28]">
                        Belum ada
                    </div>
                @endif
            </div>

            <div x-data="{ preview: null }">
                <label for="thumbnail_path" class="admin-label">Ganti Thumbnail</label>
                <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file"
                    @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                <div class="mt-2" x-show="preview">
                    <img :src="preview" class="h-24 w-24 object-cover rounded-lg border border-[#E2D4C0]">
                </div>
            </div>

                <div>
                    <label for="thumbnail_path" class="admin-label">Ganti Thumbnail</label>
                    <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file">
                </div>

                <div class="md:col-span-2">
                    <label class="admin-label">Status</label>
                    <div class="flex flex-wrap gap-3">
                        <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="1" @checked($paket->aktif)> Aktif</label>
                        <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="0" @checked(!$paket->aktif)> Nonaktif</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="admin-title text-xl">Isi Paket</h2>
                    <p class="admin-muted mt-1 text-sm">Edit item yang sudah ada atau tambah item baru.</p>
                </div>
                <button type="button" onclick="tambahItemBaru()" class="admin-btn-secondary">+ Tambah Item</button>
            </div>

            <div id="item-baru-container" class="space-y-4"></div>

            <div class="space-y-5">
                @foreach ($paket->paketDetails as $detail)
                    <div class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] p-5">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="admin-label">Nama Item</label>
                                <input name="nama_item[]" type="text" value="{{ $detail->nama_item }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Jumlah</label>
                                <input name="jumlah[]" type="number" min="1" value="{{ $detail->jumlah }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Tipe</label>
                                <select name="tipe[]" class="admin-select focus:admin-input-focus">
                                    <option value="wajib" @selected($detail->tipe == 'wajib')>Wajib</option>
                                    <option value="opsional" @selected($detail->tipe == 'opsional')>Opsional</option>
                                </select>
                            </div>

                            <div>
                                <label class="admin-label">Harga Tambahan</label>
                                <input name="harga_tambahan[]" type="number" min="0" value="{{ $detail->harga_tambahan }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div class="md:col-span-2">
                                <label class="admin-label">Keterangan</label>
                                <textarea name="keterangan[]" class="admin-textarea focus:admin-input-focus">{{ $detail->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <h2 class="admin-title text-xl">Foto Paket</h2>

            <div class="admin-gallery-grid">
                @foreach ($paket->fotos as $foto)
                    <div class="admin-gallery-card">
                        @if ($foto->foto_path)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" alt="{{ $foto->keterangan }}" class="h-36 w-full object-cover">
                        @else
                            <div class="flex h-36 w-full items-center justify-center bg-[#E2D4C0] text-sm font-semibold text-[#4A2E28]">
                                Foto Paket
                            </div>
                        @endif

                        <div class="space-y-3 p-4">
                            <div>
                                <label class="admin-label">Keterangan</label>
                                <input type="hidden" name="foto_id[]" value="{{ $foto->id }}">
                                <input type="text" name="keterangan_foto[]" value="{{ $foto->keterangan }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Urutan</label>
                                <input type="number" name="urutan_foto[]" value="{{ $foto->urutan }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <a href="{{ route('admin.paket.foto.destroy', $foto->id) }}" class="admin-btn-danger w-full justify-center px-3 py-2 text-xs"
                            onclick="return confirmDeleteLink(event, 'Apakah Anda yakin ingin menghapus foto ini?', this.href)">

                                Hapus Foto

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-6">
    <div x-data="{ items: [{ id: Date.now(), preview: null }] }">
        <label class="admin-label">Tambah Foto Baru</label>
        <p class="admin-muted mb-2 text-xs">Tambahkan satu per satu atau klik "+ Tambah Foto".</p>
        <template x-for="(item, index) in items" :key="item.id">
            <div class="foto-item flex items-center gap-2 mb-2">
                <input type="file" name="foto_paket[]" class="admin-file flex-1" accept="image/*"
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
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>

let itemBaruCount = 0;
const jasaList = @json($jasaList ?? []);

function tambahItemBaru() {
    const i = itemBaruCount++;
    const container = document.getElementById('item-baru-container');

    const jasaOptions = jasaList.length
        ? jasaList.map(j => `<option value="${j.id}" data-nama="${j.nama_jasa}">${j.nama_jasa}</option>`).join('')
        : '<option disabled>Belum ada data jasa (hubungi backend)</option>';

    container.insertAdjacentHTML('beforeend', `
        <div class="item-row rounded-2xl border border-[#E2D4C0] bg-white p-5 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-[#4A0F1A]">Item Baru ${i + 1}</span>
                <button type="button" onclick="this.closest('.item-row').remove()" class="text-sm font-semibold text-red-500 hover:text-red-700">Hapus</button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="admin-label">Pilih dari Jasa <span class="admin-muted text-xs">(opsional)</span></label>
                    <select onchange="isiNamaDariJasa(this, 'new_${i}')" class="admin-select">
                        <option value="">-- Pilih jasa --</option>
                        ${jasaOptions}
                    </select>
                    <input type="hidden" name="jasa_id[]" id="jasa_id_new_${i}" value="">
                </div>
                <div class="md:col-span-2">
                    <label class="admin-label">Nama Item <span class="text-red-600">*</span></label>
                    <input id="nama_item_new_${i}" name="nama_item[]" type="text" class="admin-input" placeholder="Nama item">
                </div>
                <div>
                    <label class="admin-label">Jumlah</label>
                    <input name="jumlah[]" type="number" min="1" value="1" class="admin-input">
                </div>
                <div>
                    <label class="admin-label">Tipe</label>
                    <select name="tipe[]" class="admin-select">
                        <option value="wajib">Wajib</option>
                        <option value="opsional">Opsional (+biaya tambahan)</option>
                    </select>
                </div>
                <div>
                    <label class="admin-label">Harga Tambahan</label>
                    <input name="harga_tambahan[]" type="number" min="0" value="0" class="admin-input">
                </div>
                <div>
                    <label class="admin-label">Keterangan</label>
                    <input name="keterangan[]" type="text" class="admin-input" placeholder="Opsional">
                </div>
            </div>
        </div>
    `);
}

function isiNamaDariJasa(select, key) {
    const selected = select.options[select.selectedIndex];
    document.getElementById('nama_item_' + key).value = selected.dataset.nama ?? '';
    document.getElementById('jasa_id_' + key).value = selected.value;
}
</script>
@endsection
