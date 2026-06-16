@extends('admin.layouts.app')

@section('title', 'Kelola Jasa')

@section('content')
@php
    $jasa = [
        ['nama' => 'MC Pernikahan', 'kategori' => 'MC', 'harga' => 'Rp 1.500.000', 'maks' => 2, 'status' => 'Aktif'],
        ['nama' => 'Pertunjukan Tari Pasambahan', 'kategori' => 'Pertunjukan Tari', 'harga' => 'Rp 2.000.000', 'maks' => 4, 'status' => 'Aktif'],
        ['nama' => 'Make Up Pengantin', 'kategori' => 'Makeup', 'harga' => 'Rp 3.000.000', 'maks' => 1, 'status' => 'Nonaktif'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola data jasa, kategori, harga, batas booking harian, foto, dan status layanan.</p>
        </div>
        <a href="{{ route('admin.jasa.create') }}" class="admin-btn-primary">+ Tambah Jasa</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label class="admin-label">Cari Jasa</label>
                <input type="text" class="admin-input" placeholder="Cari nama jasa...">
            </div>
            <div>
                <label class="admin-label">Kategori</label>
                <select class="admin-select"><option>Semua</option><option>MC</option><option>Pertunjukan Tari</option><option>Makeup</option></select>
            </div>
            <div>
                <label class="admin-label">Status</label>
                <select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($jasa as $item)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-4">
                        <div class="admin-thumb flex items-center justify-center text-xl">🛎️</div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-xl font-bold text-gray-900">{{ $item['nama'] }}</h2>
                                <span class="{{ $item['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $item['status'] }}</span>
                            </div>
                            <p class="admin-muted mt-1 text-sm">Kategori: {{ $item['kategori'] }}</p>
                            <p class="mt-1 text-sm text-gray-700">Harga: <strong>{{ $item['harga'] }}</strong> | Maks. Booking/Hari: {{ $item['maks'] }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.jasa.edit', 1) }}" class="admin-btn-secondary py-2">Edit</a>
                        <button class="{{ $item['status'] === 'Aktif' ? 'admin-btn-danger' : 'admin-btn-primary' }} py-2">
                            {{ $item['status'] === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
