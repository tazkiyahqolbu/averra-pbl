@extends('admin.layouts.app')

@section('title', 'Data Barang')

@section('content')
@php
    $barangs = [
        [
            'nama_barang' => 'Baju Tari Piring',
            'kategori' => 'Kostum Tari',
            'deskripsi' => 'Kostum tradisional untuk pertunjukan tari piring.',
            'harga' => 150000,
            'nilai_barang' => 500000,
            'stok' => 8,
            'aktif' => true,
        ],
        [
            'nama_barang' => 'Talempong',
            'kategori' => 'Properti Musik',
            'deskripsi' => 'Alat musik tradisional Minangkabau.',
            'harga' => 200000,
            'nilai_barang' => 1000000,
            'stok' => 5,
            'aktif' => true,
        ],
        [
            'nama_barang' => 'Payung Tari',
            'kategori' => 'Properti Tari',
            'deskripsi' => 'Properti pendukung untuk pertunjukan tari.',
            'harga' => 50000,
            'nilai_barang' => 150000,
            'stok' => 12,
            'aktif' => false,
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Barang</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengelola data kostum, properti, kategori, harga sewa, stok, dan status aktif.
            </p>
        </div>

        <a href="{{ route('admin.barang.create') }}" class="admin-btn-primary">
            + Tambah Barang
        </a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-4 lg:grid-cols-3">
            <div>
                <label class="admin-label">Cari Barang</label>
                <input
                    type="text"
                    class="admin-input"
                    placeholder="Contoh: Baju Tari Piring"
                >
            </div>

            <div>
                <label class="admin-label">Kategori</label>
                <select class="admin-select">
                    <option>Semua Kategori</option>
                    <option>Kostum Tari</option>
                    <option>Properti Tari</option>
                    <option>Properti Musik</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Status</label>
                <select class="admin-select">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
        </div>
    </div>

    <div class="admin-table-wrapper">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-[#decba5] bg-[#f8f3ea]">
                        <th class="admin-table-th">#</th>
                        <th class="admin-table-th">Thumbnail</th>
                        <th class="admin-table-th">Nama Barang</th>
                        <th class="admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga Sewa</th>
                        <th class="admin-table-th">Nilai Barang</th>
                        <th class="admin-table-th">Stok</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($barangs as $barang)
                        <tr class="border-b border-[#decba5] last:border-b-0 hover:bg-[#fff8ed]">
                            <td class="admin-table-td">
                                {{ $loop->iteration }}
                            </td>

                            <td class="admin-table-td">
                                <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#7a5d58]">
                                    IMG
                                </div>
                            </td>

                            <td class="admin-table-td">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $barang['nama_barang'] }}
                                    </p>
                                    <p class="mt-1 max-w-xs truncate text-xs text-[#7a5d58]">
                                        {{ $barang['deskripsi'] }}
                                    </p>
                                </div>
                            </td>

                            <td class="admin-table-td">
                                {{ $barang['kategori'] }}
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($barang['harga'], 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($barang['nilai_barang'], 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td">
                                {{ $barang['stok'] }}
                            </td>

                            <td class="admin-table-td">
                                @if ($barang['aktif'])
                                    <span class="badge-active">● Aktif</span>
                                @else
                                    <span class="badge-inactive">● Nonaktif</span>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.barang.edit') }}" class="admin-btn-secondary px-4 py-2">
                                        Edit
                                    </a>

                                    <button type="button" class="admin-btn-danger px-4 py-2">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (count($barangs) === 0)
            <div class="admin-empty m-5">
                Belum ada data barang yang ditambahkan.
            </div>
        @endif
    </div>
</div>
@endsection
