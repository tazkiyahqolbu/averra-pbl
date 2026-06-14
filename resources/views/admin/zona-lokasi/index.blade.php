@extends('admin.layouts.app')

@section('title', 'Zona Lokasi')

@section('content')
@php
    $zonaLokasis = [
        [
            'id' => 1,
            'nama_zona' => 'Dalam Kota Padang',
            'keterangan' => 'Area layanan utama dalam Kota Padang.',
            'biaya' => 0,
            'status' => true,
        ],
        [
            'id' => 2,
            'nama_zona' => 'Luar Kota Padang',
            'keterangan' => 'Area luar Kota Padang dengan tambahan transportasi.',
            'biaya' => 500000,
            'status' => true,
        ],
        [
            'id' => 3,
            'nama_zona' => 'Luar Sumatera Barat',
            'keterangan' => 'Area luar provinsi dengan penyesuaian transportasi dan akomodasi.',
            'biaya' => 1500000,
            'status' => false,
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Zona Lokasi</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengelola zona lokasi, biaya tambahan, keterangan, dan status area layanan.
            </p>
        </div>

        <a href="{{ route('admin.zona-lokasi.create') }}" class="admin-btn-primary">
            + Tambah Zona
        </a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label for="search" class="admin-label">Cari Zona</label>
                <input id="search" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Dalam Kota Padang">
            </div>

            <div>
                <label for="status" class="admin-label">Status</label>
                <select id="status" class="admin-select focus:admin-input-focus">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div>
                <label for="urutan" class="admin-label">Urutan</label>
                <select id="urutan" class="admin-select focus:admin-input-focus">
                    <option value="">Urutkan Terbaru</option>
                    <option>Biaya Terendah</option>
                    <option>Biaya Tertinggi</option>
                    <option>Nama A-Z</option>
                </select>
            </div>
        </div>
    </div>

    <div class="admin-table-wrapper">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="border-b border-[#decba5] bg-[#f9f1e6]">
                    <tr>
                        <th class="admin-table-th w-16">#</th>
                        <th class="admin-table-th">Nama Zona</th>
                        <th class="admin-table-th">Keterangan</th>
                        <th class="admin-table-th">Biaya Tambahan</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#decba5]">
                    @forelse ($zonaLokasis as $index => $zona)
                        <tr class="hover:bg-[#f9f1e6]/50">
                            <td class="admin-table-td font-semibold text-[#7a5d58]">
                                {{ $index + 1 }}
                            </td>

                            <td class="admin-table-td">
                                <p class="font-semibold text-gray-900">{{ $zona['nama_zona'] }}</p>
                            </td>

                            <td class="admin-table-td">
                                {{ $zona['keterangan'] }}
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($zona['biaya'], 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td">
                                @if ($zona['status'])
                                    <span class="badge-active">● Aktif</span>
                                @else
                                    <span class="badge-inactive">● Nonaktif</span>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.zona-lokasi.edit') }}"
                                       class="admin-btn-secondary px-3 py-2 text-xs">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="admin-btn-danger px-3 py-2 text-xs"
                                            onclick="return confirm('Yakin ingin menghapus zona lokasi ini?')">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="admin-table-td">
                                <div class="admin-empty">
                                    Belum ada data zona lokasi yang ditambahkan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
