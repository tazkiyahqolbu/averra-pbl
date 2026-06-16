@extends('admin.layouts.app')

@section('title', 'Kelola Barang')

@section('content')
@php
    $barang = [
        ['nama' => 'Kamera Canon EOS R50', 'kategori' => 'Kamera', 'harga' => 'Rp 200.000/hari', 'stok' => 3, 'nilai' => 'Rp 8.000.000', 'status' => 'Aktif'],
        ['nama' => 'Tripod Video', 'kategori' => 'Perlengkapan', 'harga' => 'Rp 50.000/hari', 'stok' => 5, 'nilai' => 'Rp 750.000', 'status' => 'Aktif'],
        ['nama' => 'Sound Portable', 'kategori' => 'Audio/Sound', 'harga' => 'Rp 300.000/hari', 'stok' => 1, 'nilai' => 'Rp 4.000.000', 'status' => 'Nonaktif'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Barang</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola barang sewa, stok, nilai barang, harga sewa, dan status ketersediaan.</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" class="admin-btn-primary">+ Tambah Barang</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div><label class="admin-label">Cari Barang</label><input type="text" class="admin-input" placeholder="Cari nama barang..."></div>
            <div><label class="admin-label">Kategori</label><select class="admin-select"><option>Semua</option><option>Kamera</option><option>Audio/Sound</option><option>Perlengkapan</option></select></div>
            <div><label class="admin-label">Status</label><select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select></div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($barang as $item)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-4">
                        <div class="admin-thumb flex items-center justify-center text-xl">📦</div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-xl font-bold text-gray-900">{{ $item['nama'] }}</h2>
                                <span class="{{ $item['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $item['status'] }}</span>
                            </div>
                            <p class="admin-muted mt-1 text-sm">Kategori: {{ $item['kategori'] }}</p>
                            <p class="mt-1 text-sm text-gray-700">Harga: <strong>{{ $item['harga'] }}</strong> | Stok: {{ $item['stok'] }} unit</p>
                            <p class="mt-1 text-sm text-gray-700">Nilai Barang: <strong>{{ $item['nilai'] }}</strong></p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.barang.edit') }}" class="admin-btn-secondary py-2">Edit</a>
                        <button class="{{ $item['status'] === 'Aktif' ? 'admin-btn-danger' : 'admin-btn-primary' }} py-2">{{ $item['status'] === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
