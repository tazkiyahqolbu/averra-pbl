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

<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Data Barang</h1>
            <p class="admin-subtitle mt-1 text-sm">Kelola katalog kostum dan properti sanggar.</p>
        </div>

        <a href="{{ route('admin.barang.create') }}"
           class="inline-flex items-center justify-center rounded-xl bg-[#5A0B1A] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#7B1C2E]">
            + Tambah Barang
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Harga Sewa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nilai Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($barangs as $barang)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 text-xs text-gray-400">
                                        No Img
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $barang['nama_barang'] }}</p>
                                        <p class="line-clamp-1 text-sm text-gray-500">{{ $barang['deskripsi'] }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">{{ $barang['kategori'] }}</td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                Rp {{ number_format($barang['harga'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                Rp {{ number_format($barang['nilai_barang'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">{{ $barang['stok'] }}</td>

                            <td class="px-6 py-4">
                                @if ($barang['aktif'])
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Aktif</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">Nonaktif</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.barang.edit') }}"
                                   class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
