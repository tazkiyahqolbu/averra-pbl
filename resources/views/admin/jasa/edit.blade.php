@extends('admin.layouts.app')

@section('title', 'Edit Jasa')

@section('content')

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Edit Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengubah data jasa, thumbnail, status aktif, dan foto galeri jasa.
            </p>
        </div>

        <a href="{{ url()->previous() }}" class="admin-btn-secondary">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.jasa.update', $jasa->id) }}"
      method="POST"
      enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Informasi Jasa</h2>
                <p class="admin-muted mt-1 text-sm">Data sudah terisi sesuai jasa yang dipilih.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama_jasa" class="admin-label">Nama Jasa <span class="text-red-600">*</span></label>
                    <input id="nama_jasa" name="nama_jasa" type="text" value="{{ old('nama_jasa', $jasa->nama_jasa) }}" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label for="kategori_jasa_id" class="admin-label">Kategori Jasa <span class="text-red-600">*</span></label>
                    <select id="kategori_jasa_id" name="kategori_jasa_id" class="admin-select focus:admin-input-focus">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                @selected($jasa->kategori_jasa_id == $kategori->id)>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="harga" class="admin-label">Harga <span class="text-red-600">*</span></label>
                    <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $jasa->harga) }}" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label for="maks_booking_harian" class="admin-label">Maks Booking/Hari <span class="text-red-600">*</span></label>
                    <input id="maks_booking_harian" name="maks_booking_harian" type="number" min="1" value="{{ old('maks_booking_harian', $jasa->maks_booking_harian) }}" class="admin-input focus:admin-input-focus">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="admin-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="admin-textarea focus:admin-input-focus">{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Thumbnail Saat Ini</label>
                    @if ($jasa->thumbnail_path)
                        <img src="{{ asset('storage/' . $jasa->thumbnail_path) }}" alt="Thumbnail {{ $jasa['nama_jasa'] }}" class="admin-preview-image">
                    @else
                        <div class="admin-preview-image flex items-center justify-center text-sm font-semibold text-[#7a5d58]">
                            Belum ada
                        </div>
                    @endif
                </div>

                <div>
                    <label for="thumbnail_path" class="admin-label">Ganti Thumbnail</label>
                    <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file">
                    <p class="admin-muted mt-1 text-xs">Kosongkan jika tidak ingin mengganti thumbnail.</p>
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-[#decba5] bg-[#fffdf7] p-4 md:col-span-2">
                    <input id="aktif" name="aktif" type="checkbox" value="1" @checked($jasa->aktif) class="h-5 w-5 rounded border-[#decba5] text-[#7b1c2e]">
                    <div>
                        <label for="aktif" class="font-semibold text-[#4a0f1a]">Jasa Aktif</label>
                        <p class="admin-muted text-xs">Jika aktif, jasa dapat ditampilkan pada halaman katalog.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Foto Galeri Saat Ini</h2>
                <p class="admin-muted mt-1 text-sm">Preview foto yang sudah terupload pada tabel foto_jasa.</p>
            </div>

            <div class="admin-gallery-grid">
        @foreach ($jasa->fotos as $foto)
        <div class="admin-gallery-card">

            @if ($foto->foto_path)
                <img src="{{ asset('storage/' . $foto->foto_path) }}"
                    alt="{{ $foto->keterangan }}"
                    class="h-36 w-full object-cover">
            @else
                <div class="flex h-36 w-full items-center justify-center bg-[#ead8b8] text-sm font-semibold text-[#7a5d58]">
                    Foto Jasa
                </div>
            @endif

            <div class="space-y-3 p-4">

                <div>
                    <label class="admin-label">Keterangan</label>
                    <input type="text"
                        name="keterangan_foto[{{ $foto->id }}]"
                        value="{{ $foto->keterangan }}"
                        class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label class="admin-label">Urutan</label>
                    <input type="number"
                        name="urutan_foto[{{ $foto->id }}]"
                        value="{{ $foto->urutan }}"
                        min="1"
                        class="admin-input focus:admin-input-focus">
                </div>

            </div>
        </div>
    @endforeach
            </div>

            <div class="mt-6 border-t border-[#decba5] pt-6">
                <h3 class="font-semibold text-[#4a0f1a]">Tambah Foto Baru</h3>
                <div class="mt-4 admin-upload-box">
                    <label for="foto_jasa" class="block cursor-pointer">
                        <span class="block text-base font-semibold text-[#4a0f1a]">Upload Foto Galeri Baru</span>
                        <span class="admin-muted mt-1 block text-sm">Pilih satu atau beberapa gambar tambahan.</span>
                        <input id="foto_jasa" name="foto_jasa[]" type="file" accept="image/*" multiple class="mt-4 w-full text-sm text-[#7a5d58]">
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ url()->previous() }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
