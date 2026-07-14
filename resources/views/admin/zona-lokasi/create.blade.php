@extends('admin.layouts.app')

@section('title', 'Tambah Zona Lokasi')

@section('content')
<section class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-2xl">Tambah Zona Lokasi</h1>
            <p class="admin-subtitle mt-1">Tambahkan area layanan dan biaya tambahan berdasarkan lokasi acara.</p>
        </div>
    </div>

    <form action="{{ route('admin.zona-lokasi.store') }}" method="POST" class="admin-card space-y-6 p-6">

    @csrf
        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label class="admin-label">Nama Zona</label>
                <input type="text" name="nama_zona" class="admin-input" value="{{ old('nama_zona') }}" placeholder="Contoh: Dalam Kota Padang">
            </div>

            <div>
                <label class="admin-label">Biaya Tambahan</label>
                <input type="number" name="biaya" class="admin-input" value="{{ old('biaya',0) }}" placeholder="0">
            </div>


        <div>
        <label class="admin-label">Persentase Tambahan (%)</label>

            <input type="number" name="persentase" class="admin-input" value="{{ old('persentase',0) }}" placeholder="Contoh: 50">
        </div>
        </div>

        <div>
            <label class="admin-label">Keterangan</label>
            <textarea
            name="keterangan"
            class="admin-textarea"
            placeholder="Keterangan zona">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-[#E2D4C0] pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.zona-lokasi.index') }}" class="admin-btn-secondary">Kembali</a>
            <button type="submit" class="admin-btn-primary">Simpan Zona</button>
        </div>
    </form>
</section>
@endsection
