@extends('admin.layouts.app')

@section('title', 'Pemesanan')

@section('content')
@php
    $orders = [
        [
            'kode' => 'AVR-20260610-001',
            'status' => 'Menunggu Konfirmasi',
            'nama' => 'Tazkiyah Qolbu',
            'telepon' => '081234567890',
            'item' => 'Paket Gold Wedding',
            'jenis' => 'Acara',
            'tanggal' => '25 Juni 2026',
            'lokasi' => 'Zona B - Jl. Contoh No.1',
            'total' => 'Rp 5.500.000',
            'metode' => 'DP 50%',
            'dipesan' => '10 Juni 2026, 20.33',
        ],
        [
            'kode' => 'AVR-20260611-002',
            'status' => 'Menunggu Pembayaran',
            'nama' => 'Siti Rahmah',
            'telepon' => '082233445566',
            'item' => 'Sewa Kamera Canon EOS',
            'jenis' => 'Sewa Barang',
            'tanggal' => '28 Juni 2026',
            'lokasi' => 'Zona A - Padang',
            'total' => 'Rp 300.000',
            'metode' => 'Lunas',
            'dipesan' => '11 Juni 2026, 09.15',
        ],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Pemesanan</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Kelola pesanan masuk, konfirmasi, penolakan, dan status pemesanan pelanggan.
            </p>
        </div>
    </div>

    <div class="admin-card p-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach (['Semua', 'Menunggu Konfirmasi (3)', 'Menunggu Pembayaran', 'Berlangsung', 'Pengembalian', 'Selesai', 'Dibatalkan'] as $tab)
                <button class="rounded-full border border-[#decba5] px-4 py-2 font-semibold text-[#5A0B1A] hover:bg-[#f7efe2]">
                    {{ $tab }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-4">
            <div class="md:col-span-2">
                <label class="admin-label">Cari Pesanan</label>
                <input type="text" class="admin-input" placeholder="Cari no. pesanan / nama customer...">
            </div>

            <div>
                <label class="admin-label">Jenis</label>
                <select class="admin-select">
                    <option>Semua</option>
                    <option>Acara</option>
                    <option>Sewa Barang</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Tanggal</label>
                <input type="date" class="admin-input">
            </div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($orders as $order)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-heading text-xl font-bold text-gray-900">#{{ $order['kode'] }}</h2>
                            <span class="badge-warning">{{ $order['status'] }}</span>
                        </div>

                        <p class="text-sm text-gray-700">👤 {{ $order['nama'] }} | 📞 {{ $order['telepon'] }}</p>
                        <p class="text-sm text-gray-700">📋 {{ $order['item'] }} <span class="text-[#7a5d58]">[{{ $order['jenis'] }}]</span></p>
                        <p class="text-sm text-gray-700">📅 Pelaksanaan: {{ $order['tanggal'] }} | 📍 {{ $order['lokasi'] }}</p>
                        <p class="text-sm text-gray-700">💰 Total: {{ $order['total'] }} <span class="text-[#7a5d58]">(Metode: {{ $order['metode'] }})</span></p>
                        <p class="text-xs text-[#7a5d58]">🕐 Dipesan: {{ $order['dipesan'] }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.pemesanan.show') }}" class="admin-btn-secondary">Lihat Detail</a>
                        <button class="admin-btn-primary">Konfirmasi</button>
                        <button class="admin-btn-danger">Tolak</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
