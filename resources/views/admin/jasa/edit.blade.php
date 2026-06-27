@extends('admin.layouts.app')

@section('title', 'Edit Jasa')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Edit Jasa</h1>
        <p class="admin-subtitle mt-1 text-sm">Perbarui data jasa, harga, foto, dan status layanan.</p>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <p class="font-semibold mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jasa.update', $jasa->id) }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Nama Jasa *</label>
                <input type="text" name="nama_jasa" class="admin-input"
                       value="{{ old('nama_jasa', $jasa->nama_jasa) }}">
            </div>
            <div>
                <label class="admin-label">Kategori *</label>
                <select name="kategori_jasa_id" class="admin-select">
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}"
                            {{ old('kategori_jasa_id', $jasa->kategori_jasa_id) == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="admin-label">Harga *</label>
                <input type="number" name="harga" class="admin-input" min="0"
                       value="{{ old('harga', $jasa->harga) }}">
            </div>
            <div>
                <label class="admin-label">Maks. Booking/Hari *</label>
                <input type="number" name="maks_booking_harian" class="admin-input" min="1"
                       value="{{ old('maks_booking_harian', $jasa->maks_booking_harian) }}">
            </div>
        </div>

        <div>
            <label class="admin-label">Deskripsi</label>
            <textarea name="deskripsi" class="admin-textarea">{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
        </div>

        <div>
            <label class="admin-label">Status</label>
            <div class="flex flex-wrap gap-3">
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm">
                    <input type="radio" name="aktif" value="1" {{ old('aktif', $jasa->aktif ? '1' : '0') == '1' ? 'checked' : '' }}> Aktif
                </label>
                <label class="rounded-2xl border border-[#E2D4C0] bg-[#ffffff] px-4 py-3 text-sm">
                    <input type="radio" name="aktif" value="0" {{ old('aktif', $jasa->aktif ? '1' : '0') == '0' ? 'checked' : '' }}> Nonaktif
                </label>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="admin-label">Foto Utama</label>
                @if($jasa->thumbnail_path)
                    <img src="{{ asset('storage/' . $jasa->thumbnail_path) }}"
                         alt="Foto utama" class="mb-2 h-24 w-24 rounded-xl object-cover border border-[#E2D4C0]">
                    <p class="text-xs admin-muted mb-1">Upload baru untuk mengganti</p>
                @endif
                <input type="file" name="thumbnail_path" class="admin-file" accept="image/*">
            </div>
            <div>
                <label class="admin-label">Foto Tambahan</label>
                @if($jasa->fotos->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach($jasa->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}"
                                 alt="foto" class="h-16 w-16 rounded-xl object-cover border border-[#E2D4C0]">
                        @endforeach
                    </div>
                @endif
                <input type="file" name="foto_jasa[]" class="admin-file" multiple accept="image/*">
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.jasa.index') }}" class="admin-btn-secondary">Batal</a>
            <button type="submit" class="admin-btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
