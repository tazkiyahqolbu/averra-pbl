@extends('admin.layouts.app')

@section('title', 'Kelola Paket')

@section('content')
@php
    $paketItems = $paketItems ?? [
        [
            'id' => 1,
            'thumbnail_path' => null,
            'nama_paket' => 'Paket Pernikahan Adat Minang',
            'kategori' => 'Pernikahan',
            'harga' => 8500000,
            'keterangan_acara' => 'Akad dan resepsi',
            'aktif' => true,
        ],
        [
            'id' => 2,
            'thumbnail_path' => null,
            'nama_paket' => 'Paket Hiburan Tari',
            'kategori' => 'Hiburan',
            'harga' => 3500000,
            'keterangan_acara' => 'Acara resmi dan hiburan',
            'aktif' => true,
        ],
        [
            'id' => 3,
            'thumbnail_path' => null,
            'nama_paket' => 'Paket Penyambutan Tamu',
            'kategori' => 'Pertunjukan',
            'harga' => 2500000,
            'keterangan_acara' => 'Penyambutan tamu undangan',
            'aktif' => false,
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Mengelola data paket, kategori paket, harga, thumbnail, dan status aktif.
            </p>
        </div>

        <a href="{{ route('admin.paket.create') }}" class="admin-btn-primary">
            + Tambah Paket
        </a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label for="search" class="admin-label">Cari Paket</label>
                <input id="search" type="text" class="admin-input focus:admin-input-focus" placeholder="Contoh: Paket Pernikahan">
            </div>

            <div>
                <label for="kategori" class="admin-label">Kategori</label>
                <select id="kategori" class="admin-select focus:admin-input-focus">
                    <option value="">Semua Kategori</option>
                    <option>Pernikahan</option>
                    <option>Hiburan</option>
                    <option>Pertunjukan</option>
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
                        <th class="admin-table-th">Nama Paket</th>
                        <th class="admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga</th>
                        <th class="admin-table-th">Keterangan Acara</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#decba5]">
                    @forelse ($paketItems as $index => $item)
                        <tr class="hover:bg-[#f9f1e6]/50">
                            <td class="admin-table-td font-semibold text-[#7a5d58]">{{ $index + 1 }}</td>

                            <td class="admin-table-td">
                                @if (!empty($item['thumbnail_path']))
                                    <img src="{{ asset('storage/' . $item['thumbnail_path']) }}" alt="{{ $item['nama_paket'] }}" class="admin-thumb">
                                @else
                                    <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#7a5d58]">
                                        IMG
                                    </div>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <p class="font-semibold text-gray-900">{{ $item['nama_paket'] }}</p>
                            </td>

                            <td class="admin-table-td">{{ $item['kategori'] }}</td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td">{{ $item['keterangan_acara'] }}</td>

                            <td class="admin-table-td">
                                @if ($item['aktif'])
                                    <span class="badge-active">Aktif ✓</span>
                                @else
                                    <span class="badge-inactive">Nonaktif</span>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.paket.edit', $item['id']) }}" class="admin-btn-secondary px-3 py-2 text-xs">Edit</a>
                                    <button type="button" class="admin-btn-danger px-3 py-2 text-xs">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-table-td">
                                <div class="admin-empty">Belum ada data paket.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
