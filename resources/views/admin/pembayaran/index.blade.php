@extends('admin.layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
@php
    $pembayarans = [
        [
            'kode_transaksi' => 'TRX-20260613-001',
            'kode_pemesanan' => 'PM-20260613-001',
            'pelanggan' => 'Nur Aisyah',
            'tahap' => 'dp',
            'persen_dp' => 30,
            'jumlah_bayar' => 1050000,
            'dibayar_pada' => '2026-06-13 10:15:00',
            'metode_pembayaran' => 'Transfer BRI',
            'status' => 'menunggu',
        ],
        [
            'kode_transaksi' => 'TRX-20260613-002',
            'kode_pemesanan' => 'PM-20260613-002',
            'pelanggan' => 'Rafi Maulana',
            'tahap' => 'langsung',
            'persen_dp' => null,
            'jumlah_bayar' => 1250000,
            'dibayar_pada' => '2026-06-13 11:40:00',
            'metode_pembayaran' => 'Transfer BCA',
            'status' => 'terverifikasi',
        ],
        [
            'kode_transaksi' => 'TRX-20260613-003',
            'kode_pemesanan' => 'PM-20260613-003',
            'pelanggan' => 'Dina Putri',
            'tahap' => 'pelunasan',
            'persen_dp' => null,
            'jumlah_bayar' => 2500000,
            'dibayar_pada' => '2026-06-13 13:05:00',
            'metode_pembayaran' => 'Transfer Mandiri',
            'status' => 'ditolak',
        ],
    ];

    $statusClass = [
        'menunggu' => 'badge-warning',
        'terverifikasi' => 'badge-active',
        'ditolak' => 'badge-inactive',
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <p class="admin-subtitle text-sm font-semibold uppercase tracking-[0.25em]">Transaksi</p>
            <h1 class="admin-title mt-2 text-3xl">Data Pembayaran</h1>
            <p class="admin-muted mt-2 text-sm">Verifikasi bukti pembayaran DP, pelunasan, atau pembayaran langsung.</p>
        </div>
        <a href="{{ route('admin.pemesanan.index') }}" class="admin-btn-secondary">Lihat Pemesanan</a>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Total Pembayaran</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">{{ count($pembayarans) }}</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Menunggu</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Terverifikasi</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Ditolak</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-900">1</h2>
        </div>
    </div>

    <div class="admin-card p-5">
        <form class="admin-filter-grid md:grid-cols-4">
            <div>
                <label class="admin-label">Cari Transaksi</label>
                <input type="text" class="admin-input" placeholder="Kode transaksi / pelanggan">
            </div>
            <div>
                <label class="admin-label">Tahap</label>
                <select class="admin-select">
                    <option>Semua Tahap</option>
                    <option>DP</option>
                    <option>Pelunasan</option>
                    <option>Langsung</option>
                </select>
            </div>
            <div>
                <label class="admin-label">Status</label>
                <select class="admin-select">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Terverifikasi</option>
                    <option>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="admin-label">Tanggal Bayar</label>
                <input type="date" class="admin-input">
            </div>
        </form>
    </div>

    <div class="admin-table-wrapper overflow-x-auto">
        <table class="w-full min-w-[950px] border-collapse">
            <thead class="bg-[#f8f1e6]">
                <tr>
                    <th class="admin-table-th">Transaksi</th>
                    <th class="admin-table-th">Pemesanan</th>
                    <th class="admin-table-th">Pelanggan</th>
                    <th class="admin-table-th">Tahap</th>
                    <th class="admin-table-th">Jumlah</th>
                    <th class="admin-table-th">Metode</th>
                    <th class="admin-table-th">Status</th>
                    <th class="admin-table-th text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#decba5]">
                @foreach ($pembayarans as $pembayaran)
                    <tr>
                        <td class="admin-table-td">
                            <div class="font-semibold text-[#4a0f1a]">{{ $pembayaran['kode_transaksi'] }}</div>
                            <div class="admin-muted text-xs">{{ \Carbon\Carbon::parse($pembayaran['dibayar_pada'])->translatedFormat('d M Y H:i') }} WIB</div>
                        </td>
                        <td class="admin-table-td font-semibold">{{ $pembayaran['kode_pemesanan'] }}</td>
                        <td class="admin-table-td">{{ $pembayaran['pelanggan'] }}</td>
                        <td class="admin-table-td uppercase">
                            {{ $pembayaran['tahap'] }}
                            @if ($pembayaran['persen_dp'])
                                <span class="admin-muted text-xs">({{ $pembayaran['persen_dp'] }}%)</span>
                            @endif
                        </td>
                        <td class="admin-table-td font-semibold">Rp{{ number_format($pembayaran['jumlah_bayar'], 0, ',', '.') }}</td>
                        <td class="admin-table-td">{{ $pembayaran['metode_pembayaran'] }}</td>
                        <td class="admin-table-td">
                            <span class="{{ $statusClass[$pembayaran['status']] ?? 'badge-neutral' }} capitalize">
                                {{ $pembayaran['status'] }}
                            </span>
                        </td>
                        <td class="admin-table-td">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.pembayaran.show', 1) }}" class="admin-btn-secondary px-3 py-2">Detail</a>
                                <button type="button" class="admin-btn-primary px-3 py-2">Verifikasi</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
