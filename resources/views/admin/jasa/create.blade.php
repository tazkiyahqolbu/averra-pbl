@extends('admin.layouts.app')

@section('title', 'Tambah Jasa')

@section('content')
<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Tambah Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Menambahkan data jasa baru sesuai struktur tabel jasa dan foto_jasa.
            </p>
        </div>

        <a href="{{ url()->previous() }}" class="admin-btn-secondary">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.jasa.store') }}"
      method="POST"
      enctype="multipart/form-data">
        @csrf

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Informasi Jasa</h2>
                <p class="admin-muted mt-1 text-sm">Isi data utama jasa yang akan tampil pada katalog layanan.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama_jasa" class="admin-label">Nama Jasa <span class="text-red-600">*</span></label>
                    <input id="nama_jasa" name="nama_jasa" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Dekorasi Pernikahan">
                </div>

                <div>
                    <label for="kategori_jasa_id" class="admin-label">Kategori Jasa <span class="text-red-600">*</span></label>
                    <select id="kategori_jasa_id" name="kategori_jasa_id" class="admin-select focus:admin-input-focus">
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
                    <input id="harga" name="harga" type="number" min="0" class="admin-input focus:admin-input-focus" placeholder="Contoh: 5000000">
                    <p class="admin-muted mt-1 text-xs">Input angka tanpa titik/koma. Contoh: 5000000.</p>
                </div>

                <div>
                    <label for="maks_booking_harian" class="admin-label">Maks Booking/Hari <span class="text-red-600">*</span></label>
                    <input id="maks_booking_harian" name="maks_booking_harian" type="number" min="1" class="admin-input focus:admin-input-focus" placeholder="Contoh: 2">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="admin-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="admin-textarea focus:admin-input-focus" placeholder="Tuliskan deskripsi singkat jasa..."></textarea>
                </div>

                <div>
                    <label for="thumbnail_path" class="admin-label">Thumbnail</label>
                    <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file">
                    <p class="admin-muted mt-1 text-xs">Gambar utama yang akan tampil di tabel dan katalog.</p>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-[#decba5] bg-[#fffdf7] p-4">
                    <input id="aktif" name="aktif" type="checkbox" value="1" checked class="h-5 w-5 rounded border-[#decba5] text-[#7b1c2e]">
                    <div>
                        <label for="aktif" class="font-semibold text-[#4a0f1a]">Jasa Aktif</label>
                        <p class="admin-muted text-xs">Jika aktif, jasa dapat ditampilkan pada halaman katalog.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Foto Galeri Jasa</h2>
                <p class="admin-muted mt-1 text-sm">Bagian ini mengikuti tabel foto_jasa: foto_path, keterangan, dan urutan.</p>
            </div>

            <div class="admin-upload-box">
                <label for="foto_jasa" class="block cursor-pointer">
                    <span class="block text-base font-semibold text-[#4a0f1a]">Upload Foto Galeri</span>
                    <span class="admin-muted mt-1 block text-sm">Pilih satu atau beberapa gambar jasa.</span>
                    <input id="foto_jasa" name="foto_jasa[]" type="file" accept="image/*" multiple class="mt-4 w-full text-sm text-[#7a5d58]">
                </label>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="keterangan_foto_1" class="admin-label">Keterangan Foto</label>
                    <input id="keterangan_foto_1" name="keterangan_foto[]" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Tampilan dekorasi utama">
                </div>

                <div>
                    <label for="urutan_foto_1" class="admin-label">Urutan</label>
                    <input id="urutan_foto_1" name="urutan_foto[]" type="number" min="1" class="admin-input focus:admin-input-focus" placeholder="Contoh: 1">
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ url()->previous() }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Jasa</button>
        </div>
    </form>
</div>
@endsection
