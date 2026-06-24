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

    <form action="#" class="admin-card space-y-6 p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="admin-label">Nama Zona</label>
                <input type="text" class="admin-input" placeholder="Contoh: Dalam Kota Padang">
            </div>

            <div>
                <label class="admin-label">Biaya Tambahan</label>
                <input type="number" class="admin-input" placeholder="Contoh: 500000">
            </div>
        </div>

        <div>
            <label class="admin-label">Keterangan</label>
            <textarea class="admin-textarea" placeholder="Tulis keterangan zona lokasi..."></textarea>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-[#E2D4C0] pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.zona-lokasi.index') }}" class="admin-btn-secondary">Kembali</a>
            <button type="button" class="admin-btn-primary">Simpan Zona</button>
        </div>
    </form>
</section>
@endsection
