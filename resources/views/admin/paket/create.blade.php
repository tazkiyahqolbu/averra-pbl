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

                <div>
                    <label class="admin-label">Status</label>
                    <div class="flex flex-wrap gap-3">
                        <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="1" checked> Aktif</label>
                        <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm"><input type="radio" name="aktif" value="0"> Nonaktif</label>
                    </div>
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

        <div class="admin-card p-6">
            <div>
                <label class="admin-label">Foto Paket</label>
                <p class="admin-muted mb-2 text-xs">Bisa upload lebih dari satu foto.</p>
                <input name="foto_paket[]" type="file" class="admin-file" multiple accept="image/*">
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
let itemCount = 0;
const jasaList = @json($jasaList ?? []);

function tambahItem() {
    const notice = document.getElementById('empty-notice');
    if (notice) notice.remove();

    const i = itemCount++;
    const container = document.getElementById('item-container');

    const jasaOptions = jasaList.length
        ? jasaList.map(j => `<option value="${j.id}" data-nama="${j.nama_jasa}">${j.nama_jasa}</option>`).join('')
        : '<option disabled>Belum ada data jasa (hubungi backend)</option>';

    container.insertAdjacentHTML('beforeend', `
        <div class="item-row rounded-2xl border border-[#E2D4C0] bg-white p-5 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-[#4A0F1A]">Item ${i + 1}</span>
                <button type="button" onclick="this.closest('.item-row').remove()" class="text-sm font-semibold text-red-500 hover:text-red-700">Hapus</button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="admin-label">Pilih dari Jasa <span class="admin-muted text-xs">(opsional — atau ketik nama di bawah)</span></label>
                    <select onchange="isiNamaDariJasa(this, ${i})" class="admin-select">
                        <option value="">-- Pilih jasa --</option>
                        ${jasaOptions}
                    </select>
                    <input type="hidden" name="jasa_id[]" id="jasa_id_${i}" value="">
                </div>
                <div class="md:col-span-2">
                    <label class="admin-label">Nama Item <span class="text-red-600">*</span></label>
                    <input id="nama_item_${i}" name="nama_item[]" type="text" class="admin-input" placeholder="Nama item (terisi otomatis jika pilih jasa di atas)">
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

function isiNamaDariJasa(select, index) {
    const selected = select.options[select.selectedIndex];
    document.getElementById('nama_item_' + index).value = selected.dataset.nama ?? '';
    document.getElementById('jasa_id_' + index).value = selected.value;
}
</script>
@endsection
