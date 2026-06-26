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

<div class="admin-section space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-2xl md:text-3xl">
                Kelola Jasa
            </h1>

            <p class="admin-subtitle mt-1 text-sm">
                Mengelola data jasa, kategori, harga, batas booking harian, foto, dan status layanan.
            </p>
        </div>

        <a href="{{ route('admin.jasa.create') }}"
           class="admin-btn-primary w-full justify-center sm:w-auto">
            + Tambah Jasa
        </a>
    </div>

    {{-- Filter --}}
    <div class="admin-card p-4 md:p-5">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
            <div>
                <label class="admin-label">Cari Jasa</label>
                <input
                    type="text"
                    class="admin-input"
                    placeholder="Cari nama jasa..."
                >
            </div>

            <div>
                <label class="admin-label">Kategori</label>
                <select class="admin-select">
                    <option>Semua</option>
                    <option>MC</option>
                    <option>Pertunjukan Tari</option>
                    <option>Makeup</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Status</label>
                <select class="admin-select">
                    <option>Semua</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Card List --}}
    <div class="space-y-4">
        @foreach ($jasa as $item)
            <div class="admin-card p-4 md:p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Left Content --}}
                    <div class="flex min-w-0 gap-4">
                        <div class="admin-thumb flex shrink-0 items-center justify-center bg-[#FAF3E0]">
                            <i data-lucide="sparkles" class="h-5 w-5 text-[#C8960C]/70"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-lg md:text-xl font-bold text-[#4A0F1A] break-words">
                                    {{ $item['nama'] }}
                                </h2>

                                <span class="{{ $item['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>

                            <p class="admin-muted mt-1 text-sm">
                                Kategori: {{ $item['kategori'] }}
                            </p>

                            <p class="mt-1 text-sm text-[#4A2E28] break-words">
                                Harga:
                                <strong class="text-[#4A0F1A]">
                                    {{ $item['harga'] }}
                                </strong>
                                <span class="hidden sm:inline"> | </span>
                                <span class="block sm:inline">
                                    Maks. Booking/Hari: {{ $item['maks'] }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <a href="{{ route('admin.jasa.edit', 1) }}"
                           class="admin-btn-secondary py-2 text-center">
                            Edit
                        </a>

                        <button
                            class="{{ $item['status'] === 'Aktif' ? 'admin-btn-danger' : 'admin-btn-primary' }} py-2"
                        >
                            {{ $item['status'] === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
