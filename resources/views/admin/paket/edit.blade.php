@extends('admin.layouts.app')

@section('title', 'Edit Paket')

@section('content')
@php
    $paketItem = $paketItem ?? [
        'id' => 1,
        'kategori_paket_id' => 1,
        'nama_paket' => 'Paket Pernikahan Adat Minang',
        'deskripsi' => 'Paket lengkap untuk acara pernikahan adat Minangkabau.',
        'harga' => 8500000,
        'keterangan_acara' => 'Akad dan resepsi',
        'catatan' => 'Harga dapat berubah sesuai lokasi dan kebutuhan acara.',
        'thumbnail_path' => null,
        'aktif' => true,
        'paket_detail' => [
            [
                'nama_item' => 'Tari Pasambahan',
                'jumlah' => 1,
                'tipe' => 'wajib',
                'harga_tambahan' => 0,
                'keterangan' => 'Tari penyambutan tamu.',
            ],
            [
                'nama_item' => 'MC Acara',
                'jumlah' => 1,
                'tipe' => 'opsional',
                'harga_tambahan' => 500000,
                'keterangan' => 'MC tambahan jika dibutuhkan.',
            ],
        ],
        'foto_paket' => [
            ['foto_path' => null, 'keterangan' => 'Dokumentasi paket pernikahan', 'urutan' => 1],
            ['foto_path' => null, 'keterangan' => 'Detail acara adat', 'urutan' => 2],
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Edit Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengubah data paket, detail paket, thumbnail, dan foto paket.
            </p>
        </div>

        <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">
            ← Kembali
        </a>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                    <input id="nama_paket" name="nama_paket" type="text" value="{{ $paketItem['nama_paket'] }}" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label for="kategori_paket_id" class="admin-label">Kategori Paket <span class="text-red-600">*</span></label>
                    <select id="kategori_paket_id" name="kategori_paket_id" class="admin-select focus:admin-input-focus">
                        <option value="">Pilih kategori</option>
                        <option value="1" @selected($paketItem['kategori_paket_id'] == 1)>Pernikahan</option>
                        <option value="2" @selected($paketItem['kategori_paket_id'] == 2)>Hiburan</option>
                        <option value="3" @selected($paketItem['kategori_paket_id'] == 3)>Pertunjukan</option>
                    </select>
                </div>

                <div>
                    <label for="harga" class="admin-label">Harga <span class="text-red-600">*</span></label>
                    <input id="harga" name="harga" type="number" min="0" value="{{ $paketItem['harga'] }}" class="admin-input focus:admin-input-focus">
                </div>

                <div>
                    <label for="keterangan_acara" class="admin-label">Keterangan Acara</label>
                    <input id="keterangan_acara" name="keterangan_acara" type="text" value="{{ $paketItem['keterangan_acara'] }}" class="admin-input focus:admin-input-focus">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="admin-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="admin-textarea focus:admin-input-focus">{{ $paketItem['deskripsi'] }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="catatan" class="admin-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="admin-textarea focus:admin-input-focus">{{ $paketItem['catatan'] }}</textarea>
                </div>

                <div>
                    <label class="admin-label">Thumbnail Saat Ini</label>
                    @if (!empty($paketItem['thumbnail_path']))
                        <img src="{{ asset('storage/' . $paketItem['thumbnail_path']) }}" alt="Thumbnail {{ $paketItem['nama_paket'] }}" class="admin-preview-image">
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
                    <input id="aktif" name="aktif" type="checkbox" value="1" @checked($paketItem['aktif']) class="h-5 w-5 rounded border-[#decba5] text-[#7b1c2e]">
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
                <p class="admin-muted mt-1 text-sm">Preview item yang termasuk dalam paket.</p>
            </div>

            <div class="space-y-5">
                @foreach ($paketItem['paket_detail'] as $detail)
                    <div class="rounded-2xl border border-[#decba5] bg-[#fffdf7] p-5">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="admin-label">Nama Item</label>
                                <input name="nama_item[]" type="text" value="{{ $detail['nama_item'] }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Jumlah</label>
                                <input name="jumlah[]" type="number" min="1" value="{{ $detail['jumlah'] }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Tipe</label>
                                <select name="tipe[]" class="admin-select focus:admin-input-focus">
                                    <option value="wajib" @selected($detail['tipe'] == 'wajib')>Wajib</option>
                                    <option value="opsional" @selected($detail['tipe'] == 'opsional')>Opsional</option>
                                </select>
                            </div>

                            <div>
                                <label class="admin-label">Harga Tambahan</label>
                                <input name="harga_tambahan[]" type="number" min="0" value="{{ $detail['harga_tambahan'] }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div class="md:col-span-2">
                                <label class="admin-label">Keterangan</label>
                                <textarea name="keterangan[]" class="admin-textarea focus:admin-input-focus">{{ $detail['keterangan'] }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="mb-6">
                <h2 class="admin-title text-xl">Foto Galeri Saat Ini</h2>
                <p class="admin-muted mt-1 text-sm">Preview foto yang sudah terupload pada tabel foto_paket.</p>
            </div>

            <div class="admin-gallery-grid">
                @foreach ($paketItem['foto_paket'] as $foto)
                    <div class="admin-gallery-card">
                        @if (!empty($foto['foto_path']))
                            <img src="{{ asset('storage/' . $foto['foto_path']) }}" alt="{{ $foto['keterangan'] }}" class="h-36 w-full object-cover">
                        @else
                            <div class="flex h-36 w-full items-center justify-center bg-[#ead8b8] text-sm font-semibold text-[#7a5d58]">
                                Foto Paket
                            </div>
                        @endif

                        <div class="space-y-3 p-4">
                            <div>
                                <label class="admin-label">Keterangan</label>
                                <input type="text" value="{{ $foto['keterangan'] }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <div>
                                <label class="admin-label">Urutan</label>
                                <input type="number" min="1" value="{{ $foto['urutan'] }}" class="admin-input focus:admin-input-focus">
                            </div>

                            <button type="button" class="admin-btn-danger w-full justify-center px-3 py-2 text-xs">
                                Hapus Foto
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 border-t border-[#decba5] pt-6">
                <h3 class="font-semibold text-[#4a0f1a]">Tambah Foto Baru</h3>
                <div class="mt-4 admin-upload-box">
                    <label for="foto_paket" class="block cursor-pointer">
                        <span class="block text-base font-semibold text-[#4a0f1a]">Upload Foto Galeri Baru</span>
                        <span class="admin-muted mt-1 block text-sm">Pilih satu atau beberapa gambar tambahan.</span>
                        <input id="foto_paket" name="foto_paket[]" type="file" accept="image/*" multiple class="mt-4 w-full text-sm text-[#7a5d58]">
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.paket.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
