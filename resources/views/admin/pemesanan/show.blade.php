@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
@php
    $pemesanan = [
        'kode_pemesanan' => 'PM-20260613-001',
        'pelanggan' => 'Nur Aisyah',
        'email' => 'aisyah@example.com',
        'no_hp' => '081234567890',
        'tanggal_pemesanan' => '2026-06-13',
        'tanggal_pakai' => '2026-06-22',
        'jenis' => 'acara',
        'lokasi' => 'Padang',
        'zona' => 'Dalam Kota Padang',
        'ongkos_lokasi' => 0,
        'catatan' => 'Acara pernikahan di gedung serbaguna. Butuh tim datang pukul 08.00 WIB.',
        'total_harga' => 3500000,
        'status' => 'menunggu',
    ];

    $details = [
        ['jenis_item' => 'paket', 'nama' => 'Paket Pernikahan Adat Minang', 'jumlah' => 1, 'harga' => 3000000, 'subtotal' => 3000000],
        ['jenis_item' => 'jasa', 'nama' => 'MC Acara', 'jumlah' => 1, 'harga' => 500000, 'subtotal' => 500000],
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <p class="admin-subtitle text-sm font-semibold uppercase tracking-[0.25em]">Detail Pemesanan</p>
            <h1 class="admin-title mt-2 text-3xl">{{ $pemesanan['kode_pemesanan'] }}</h1>
            <p class="admin-muted mt-2 text-sm">Periksa detail pesanan sebelum dikonfirmasi atau ditolak.</p>
        </div>
        <a href="{{ route('admin.pemesanan.index') }}" class="admin-btn-secondary">Kembali</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="admin-card p-6 lg:col-span-2">
            <h2 class="admin-title text-xl">Informasi Pemesanan</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div>
                    <p class="admin-muted text-sm">Pelanggan</p>
                    <p class="font-semibold text-gray-900">{{ $pemesanan['pelanggan'] }}</p>
                </div>
                <div>
                    <p class="admin-muted text-sm">No HP</p>
                    <p class="font-semibold text-gray-900">{{ $pemesanan['no_hp'] }}</p>
                </div>
                <div>
                    <p class="admin-muted text-sm">Tanggal Pesan</p>
                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pemesanan['tanggal_pemesanan'])->translatedFormat('d M Y') }}</p>
                </div>
                <div>
                    <p class="admin-muted text-sm">Tanggal Pakai</p>
                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pemesanan['tanggal_pakai'])->translatedFormat('d M Y') }}</p>
                </div>
                <div>
                    <p class="admin-muted text-sm">Jenis</p>
                    <p class="font-semibold capitalize text-gray-900">{{ str_replace('_', ' ', $pemesanan['jenis']) }}</p>
                </div>
                <div>
                    <p class="admin-muted text-sm">Zona Lokasi</p>
                    <p class="font-semibold text-gray-900">{{ $pemesanan['zona'] }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="admin-muted text-sm">Lokasi</p>
                    <p class="font-semibold text-gray-900">{{ $pemesanan['lokasi'] }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="admin-muted text-sm">Catatan</p>
                    <p class="text-gray-700">{{ $pemesanan['catatan'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <h2 class="admin-title text-xl">Ringkasan</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="admin-muted">Status</span>
                    <span class="badge-warning capitalize">{{ $pemesanan['status'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="admin-muted">Ongkos Lokasi</span>
                    <span class="font-semibold">Rp{{ number_format($pemesanan['ongkos_lokasi'], 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-[#decba5] pt-3 flex justify-between gap-4">
                    <span class="admin-muted">Total Harga</span>
                    <span class="text-lg font-bold text-[#4a0f1a]">Rp{{ number_format($pemesanan['total_harga'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6 grid gap-3">
                <button type="button" class="admin-btn-primary w-full">Konfirmasi Pemesanan</button>
                <button type="button" class="admin-btn-danger w-full">Tolak Pemesanan</button>
            </div>
        </div>
    </div>

    <div class="admin-table-wrapper overflow-x-auto">
        <table class="w-full min-w-[720px] border-collapse">
            <thead class="bg-[#f8f1e6]">
                <tr>
                    <th class="admin-table-th">Item</th>
                    <th class="admin-table-th">Jenis</th>
                    <th class="admin-table-th">Jumlah</th>
                    <th class="admin-table-th">Harga</th>
                    <th class="admin-table-th text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#decba5]">
                @foreach ($details as $detail)
                    <tr>
                        <td class="admin-table-td font-semibold text-gray-900">{{ $detail['nama'] }}</td>
                        <td class="admin-table-td capitalize">{{ $detail['jenis_item'] }}</td>
                        <td class="admin-table-td">{{ $detail['jumlah'] }}</td>
                        <td class="admin-table-td">Rp{{ number_format($detail['harga'], 0, ',', '.') }}</td>
                        <td class="admin-table-td text-right font-semibold">Rp{{ number_format($detail['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
