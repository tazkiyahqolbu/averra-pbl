@extends('admin.layouts.app')

@section('title', 'Kelola Paket')

@section('content')
@php
    $paket = [
        ['nama' => 'Paket Gold Wedding', 'kategori' => 'Paket Pernikahan', 'harga' => 'Rp 5.000.000', 'acara' => 'Pernikahan', 'status' => 'Aktif'],
        ['nama' => 'Paket Silver Wedding', 'kategori' => 'Paket Pernikahan', 'harga' => 'Rp 3.500.000', 'acara' => 'Pernikahan', 'status' => 'Aktif'],
        ['nama' => 'Paket Hiburan Budaya', 'kategori' => 'Paket Hiburan', 'harga' => 'Rp 2.500.000', 'acara' => 'Hiburan', 'status' => 'Nonaktif'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola paket layanan, isi paket, item opsional, harga, foto, dan status.</p>
        </div>
        <a href="{{ route('admin.paket.create') }}" class="admin-btn-primary">+ Tambah Paket</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div><label class="admin-label">Cari Paket</label><input type="text" class="admin-input" placeholder="Cari nama paket..."></div>
            <div><label class="admin-label">Kategori</label><select class="admin-select"><option>Semua</option><option>Paket Pernikahan</option><option>Paket Hiburan</option></select></div>
            <div><label class="admin-label">Status</label><select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select></div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($paket as $item)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-4">
                        <div class="admin-thumb flex items-center justify-center text-xl">📦</div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-xl font-bold text-gray-900">{{ $item['nama'] }}</h2>
                                <span class="{{ $item['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $item['status'] }}</span>
                            </div>
                            <p class="admin-muted mt-1 text-sm">Kategori: {{ $item['kategori'] }} | Acara: {{ $item['acara'] }}</p>
                            <p class="mt-1 text-sm text-gray-700">Harga: <strong>{{ $item['harga'] }}</strong></p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.paket.edit') }}" class="admin-btn-secondary py-2">Edit</a>
                        <button class="{{ $item['status'] === 'Aktif' ? 'admin-btn-danger' : 'admin-btn-primary' }} py-2">{{ $item['status'] === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
