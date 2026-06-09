@extends('admin.layouts.app')

@section('title', 'Kelola Jasa')

@section('content')
@php
    /**
     * Data dummy untuk preview frontend.
     * Nanti jika backend sudah siap, bagian ini bisa dihapus dan diganti dengan data dari controller.
     */
    $jasaItems = $jasaItems ?? [
        [
            'id' => 1,
            'thumbnail_path' => null,
            'nama_jasa' => 'Dekorasi Pernikahan',
            'kategori' => 'Dekorasi',
            'harga' => 5000000,
            'maks_booking_harian' => 2,
            'aktif' => true,
        ],
        [
            'id' => 2,
            'thumbnail_path' => null,
            'nama_jasa' => 'Tari Pasambahan',
            'kategori' => 'Pertunjukan Tari',
            'harga' => 1500000,
            'maks_booking_harian' => 4,
            'aktif' => true,
        ],
        [
            'id' => 3,
            'thumbnail_path' => null,
            'nama_jasa' => 'Band Akustik',
            'kategori' => 'Musik',
            'harga' => 2500000,
            'maks_booking_harian' => 1,
            'aktif' => false,
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengelola data jasa, kategori, harga, thumbnail, dan status aktif layanan sanggar.
            </p>
        </div>

    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label for="search" class="admin-label">Cari Jasa</label>
                <input id="search" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Dekorasi Pernikahan">
            </div>

            <div>
                <label for="kategori" class="admin-label">Kategori</label>
                <select id="kategori" class="admin-select focus:admin-input-focus">
                    <option value="">Semua Kategori</option>
                    <option>Dekorasi</option>
                    <option>Pertunjukan Tari</option>
                    <option>Musik</option>
                    <option>MC</option>
                    <option>Makeup</option>
                </select>
            </div>

            <div>
                <label for="status" class="admin-label">Status</label>
                <select id="status" class="admin-select focus:admin-input-focus">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
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
                        <th class="admin-table-th">Thumbnail</th>
                        <th class="admin-table-th">Nama Jasa</th>
                        <th class="admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga</th>
                        <th class="admin-table-th">Maks Booking/Hari</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#decba5]">
                    @forelse ($jasaItems as $index => $item)
                        <tr class="hover:bg-[#f9f1e6]/50">
                            <td class="admin-table-td font-semibold text-[#7a5d58]">
                                {{ $index + 1 }}
                            </td>

                            <td class="admin-table-td">
                                @if (!empty($item['thumbnail_path']))
                                    <img src="{{ asset('storage/' . $item['thumbnail_path']) }}" alt="{{ $item['nama_jasa'] }}" class="admin-thumb">
                                @else
                                    <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#7a5d58]">
                                        IMG
                                    </div>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <p class="font-semibold text-gray-900">{{ $item['nama_jasa'] }}</p>
                            </td>

                            <td class="admin-table-td">
                                {{ $item['kategori'] }}
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td">
                                {{ $item['maks_booking_harian'] }}
                            </td>

                            <td class="admin-table-td">
                                @if ($item['aktif'])
                                    <span class="badge-active">Aktif ✓</span>
                                @else
                                    <span class="badge-inactive">Nonaktif</span>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <div class="flex justify-end gap-2">
                                    <a href="#" class="admin-btn-secondary px-3 py-2 text-xs">Edit</a>
                                    <button type="button" class="admin-btn-danger px-3 py-2 text-xs">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-table-td">
                                <div class="admin-empty">
                                    Belum ada data jasa yang ditambahkan.
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
