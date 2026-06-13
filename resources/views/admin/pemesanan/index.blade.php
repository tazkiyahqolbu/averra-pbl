@extends('admin.layouts.app')

@section('title', 'Data Pemesanan')

@section('content')
@php
    $pemesanans = [
        [
            'kode_pemesanan' => 'PM-20260613-001',
            'pelanggan' => 'Nur Aisyah',
            'jenis' => 'acara',
            'tanggal_pakai' => '2026-06-22',
            'lokasi' => 'Padang',
            'total_harga' => 3500000,
            'status' => 'menunggu',
            'jumlah_item' => 2,
        ],
        [
            'kode_pemesanan' => 'PM-20260613-002',
            'pelanggan' => 'Rafi Maulana',
            'jenis' => 'sewa_barang',
            'tanggal_pakai' => '2026-06-25',
            'lokasi' => 'Bukittinggi',
            'total_harga' => 1250000,
            'status' => 'dikonfirmasi',
            'jumlah_item' => 4,
        ],
        [
            'kode_pemesanan' => 'PM-20260613-003',
            'pelanggan' => 'Dina Putri',
            'jenis' => 'acara',
            'tanggal_pakai' => '2026-06-28',
            'lokasi' => 'Pariaman',
            'total_harga' => 5000000,
            'status' => 'selesai',
            'jumlah_item' => 3,
        ],
    ];

    $statusClass = [
        'menunggu' => 'badge-warning',
        'dikonfirmasi' => 'badge-active',
        'berlangsung' => 'badge-neutral',
        'selesai' => 'badge-active',
        'dibatalkan' => 'badge-inactive',
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <p class="admin-subtitle text-sm font-semibold uppercase tracking-[0.25em]">Transaksi</p>
            <h1 class="admin-title mt-2 text-3xl">Data Pemesanan</h1>
            <p class="admin-muted mt-2 text-sm">Pantau pemesanan layanan, paket acara, dan sewa barang pelanggan.</p>
        </div>

        <a href="#" class="admin-btn-primary">+ Tambah Pemesanan</a>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Total Pemesanan</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">{{ count($pemesanans) }}</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Menunggu</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Dikonfirmasi</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Selesai</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
    </div>

    <div class="admin-card p-5">
        <form class="admin-filter-grid md:grid-cols-4">
            <div>
                <label class="admin-label">Cari Pemesanan</label>
                <input type="text" class="admin-input" placeholder="Kode / nama pelanggan">
            </div>
            <div>
                <label class="admin-label">Jenis</label>
                <select class="admin-select">
                    <option>Semua Jenis</option>
                    <option>Acara</option>
                    <option>Sewa Barang</option>
                </select>
            </div>
            <div>
                <label class="admin-label">Status</label>
                <select class="admin-select">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Dikonfirmasi</option>
                    <option>Berlangsung</option>
                    <option>Selesai</option>
                    <option>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="admin-label">Tanggal Pakai</label>
                <input type="date" class="admin-input">
            </div>
        </form>
    </div>

    <div class="admin-table-wrapper overflow-x-auto">
        <table class="w-full min-w-[900px] border-collapse">
            <thead class="bg-[#f8f1e6]">
                <tr>
                    <th class="admin-table-th">Kode</th>
                    <th class="admin-table-th">Pelanggan</th>
                    <th class="admin-table-th">Jenis</th>
                    <th class="admin-table-th">Tanggal Pakai</th>
                    <th class="admin-table-th">Lokasi</th>
                    <th class="admin-table-th">Total</th>
                    <th class="admin-table-th">Status</th>
                    <th class="admin-table-th text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#decba5]">
                @foreach ($pemesanans as $pemesanan)
                    <tr>
                        <td class="admin-table-td font-semibold text-[#4a0f1a]">{{ $pemesanan['kode_pemesanan'] }}</td>
                        <td class="admin-table-td">
                            <div class="font-semibold text-gray-900">{{ $pemesanan['pelanggan'] }}</div>
                            <div class="admin-muted text-xs">{{ $pemesanan['jumlah_item'] }} item dipesan</div>
                        </td>
                        <td class="admin-table-td capitalize">{{ str_replace('_', ' ', $pemesanan['jenis']) }}</td>
                        <td class="admin-table-td">{{ \Carbon\Carbon::parse($pemesanan['tanggal_pakai'])->translatedFormat('d M Y') }}</td>
                        <td class="admin-table-td">{{ $pemesanan['lokasi'] }}</td>
                        <td class="admin-table-td font-semibold">Rp{{ number_format($pemesanan['total_harga'], 0, ',', '.') }}</td>
                        <td class="admin-table-td">
                            <span class="{{ $statusClass[$pemesanan['status']] ?? 'badge-neutral' }} capitalize">
                                {{ $pemesanan['status'] }}
                            </span>
                        </td>
                        <td class="admin-table-td">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.pemesanan.show', 1) }}" class="admin-btn-secondary px-3 py-2">Detail</a>
                                <button type="button" class="admin-btn-primary px-3 py-2">Konfirmasi</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
