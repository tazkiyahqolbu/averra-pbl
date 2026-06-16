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
                    <input id="nama_paket" name="nama_paket" type="text" value="{{ old('nama_paket', $paket->nama_paket) }}" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label for="kategori_paket_id" class="admin-label">Kategori Paket <span class="text-red-600">*</span></label>
                    <select id="kategori_paket_id" name="kategori_paket_id" class="admin-select focus:admin-input-focus">
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
                    <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $paket->harga) }}" class="admin-input focus:admin-input-focus">
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
                        <div class="admin-preview-image flex items-center justify-center text-sm font-semibold text-[#7a5d58]">
                            Belum ada
                        </div>
                    @endif
                </div>

                <div>
                    <label for="thumbnail_path" class="admin-label">Ganti Thumbnail</label>
                    <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="admin-file">
                </div>

                <div class="flex items-center gap-3 rounded-2xl border border-[#decba5] bg-[#fffdf7] p-4 md:col-span-2">
                    <input id="aktif" name="aktif" type="checkbox" value="1" @checked($paket->aktif) class="h-5 w-5 rounded border-[#decba5] text-[#7b1c2e]">
                    <div>
                        <label for="aktif" class="font-semibold text-[#4a0f1a]">Paket Aktif</label>
                        <p class="admin-muted text-xs">Jika aktif, paket dapat ditampilkan pada katalog.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card p-6 space-y-4">
            <h2 class="admin-title text-xl">Isi Paket</h2>
            <div class="grid gap-3 md:grid-cols-4">
                <select class="admin-select"><option>Jasa</option><option>Barang</option></select>
                <select class="admin-select md:col-span-2"><option>Pilih item</option><option>MC Profesional</option><option>Dekorasi Pelaminan</option></select>
                <input type="number" class="admin-input" placeholder="Qty">
            </div>

            <div class="space-y-5">
                @foreach ($paket->paketDetails as $detail)
                    <div class="rounded-2xl border border-[#decba5] bg-[#fffdf7] p-5">
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
            <h2 class="admin-title text-xl">Item Opsional</h2>
            <div class="grid gap-3 md:grid-cols-3">
                <select class="admin-select"><option>Pilih item opsional</option><option>Fotografer Extra</option><option>Dekorasi Outdoor</option></select>
                <input type="text" class="admin-input" placeholder="Harga tambahan">
                <button type="button" class="admin-btn-secondary">+ Tambah</button>
            </div>

            <div class="admin-gallery-grid">
                @foreach ($paket->fotos as $foto)
                    <div class="admin-gallery-card">
                        @if ($foto->foto_path)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" alt="{{ $foto->keterangan }}" class="h-36 w-full object-cover">
                        @else
                            <div class="flex h-36 w-full items-center justify-center bg-[#ead8b8] text-sm font-semibold text-[#7a5d58]">
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
                            onclick="return confirm('Yakin ingin menghapus foto ini?')">

                                Hapus Foto

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="admin-label">Foto Utama *</label><input type="file" class="admin-file"></div>
                <div><label class="admin-label">Foto Tambahan</label><input type="file" class="admin-file" multiple></div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="button" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
