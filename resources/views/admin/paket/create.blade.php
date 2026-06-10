@extends('admin.layouts.app')

@section('title', 'Tambah Paket')

@section('content')
<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Tambah Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Menambahkan data paket sesuai tabel paket, paket_detail, dan foto_paket.
            </p>
        </div>

        <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">
            ← Kembali
        </a>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <option value="1">Pernikahan</option>
                        <option value="2">Hiburan</option>
                        <option value="3">Pertunjukan</option>
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

                <div class="flex items-center gap-3 rounded-2xl border border-[#decba5] bg-[#fffdf7] p-4">
                    <input id="aktif" name="aktif" type="checkbox" value="1" checked class="h-5 w-5 rounded border-[#decba5] text-[#7b1c2e]">
                    <div>
                        <label for="aktif" class="font-semibold text-[#4a0f1a]">Paket Aktif</label>
                        <p class="admin-muted text-xs">Jika aktif, paket dapat ditampilkan pada katalog.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Detail Isi Paket</h2>
                <p class="admin-muted mt-1 text-sm">Mengikuti tabel paket_detail: nama_item, jumlah, tipe, harga_tambahan, dan keterangan.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="admin-label">Nama Item</label>
                    <input name="nama_item[]" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Tari Pasambahan">
                </div>

                <div>
                    <label class="admin-label">Jumlah</label>
                    <input name="jumlah[]" type="number" min="1" value="1" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label class="admin-label">Tipe</label>
                    <select name="tipe[]" class="admin-select focus:admin-input-focus">
                        <option value="wajib">Wajib</option>
                        <option value="opsional">Opsional</option>
                    </select>
                </div>

                <div>
                    <label class="admin-label">Harga Tambahan</label>
                    <input name="harga_tambahan[]" type="number" min="0" value="0" class="admin-input focus:admin-input-focus">
                </div>

                <div class="md:col-span-2">
                    <label class="admin-label">Keterangan Item</label>
                    <textarea name="keterangan[]" class="admin-textarea focus:admin-input-focus" placeholder="Keterangan item paket..."></textarea>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Foto Galeri Paket</h2>
                <p class="admin-muted mt-1 text-sm">Mengikuti tabel foto_paket: foto_path, keterangan, dan urutan.</p>
            </div>

            <div class="admin-upload-box">
                <label for="foto_paket" class="block cursor-pointer">
                    <span class="block text-base font-semibold text-[#4a0f1a]">Upload Foto Galeri</span>
                    <span class="admin-muted mt-1 block text-sm">Pilih satu atau beberapa gambar paket.</span>
                    <input id="foto_paket" name="foto_paket[]" type="file" accept="image/*" multiple class="mt-4 w-full text-sm text-[#7a5d58]">
                </label>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Paket</button>
        </div>
    </form>
</div>
@endsection
