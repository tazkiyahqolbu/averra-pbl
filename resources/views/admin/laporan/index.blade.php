@extends('admin.layouts.app')

@section('title', 'Laporan & Statistik')

@section('content')
@php
    $summary = [
        ['label' => 'Pendapatan Bulan Ini', 'value' => 'Rp 45.500.000'],
        ['label' => 'Total Pemesanan', 'value' => '18'],
        ['label' => 'Pemesanan Selesai', 'value' => '12'],
        ['label' => 'Pemesanan Dibatalkan', 'value' => '2'],
        ['label' => 'Rata-rata Nilai Order', 'value' => 'Rp 2.527.000'],
    ];

    $popularItems = [
        ['name' => 'Paket Gold Wedding', 'count' => '8 kali dipesan'],
        ['name' => 'Kamera Canon EOS', 'count' => '6 kali dipesan'],
        ['name' => 'Fotografer Profesional', 'count' => '5 kali dipesan'],
    ];

    $transactions = [
        ['kode' => 'AVR-001', 'customer' => 'Tazkiyah', 'item' => 'Paket Gold Wedding', 'total' => 'Rp 5.500.000', 'status' => 'Selesai', 'tanggal' => '10 Juni 2026'],
        ['kode' => 'AVR-002', 'customer' => 'Siti', 'item' => 'Kamera Canon EOS', 'total' => 'Rp 300.000', 'status' => 'Berlangsung', 'tanggal' => '12 Juni 2026'],
        ['kode' => 'AVR-003', 'customer' => 'Zikra', 'item' => 'Paket Silver', 'total' => 'Rp 3.500.000', 'status' => 'Dibatalkan', 'tanggal' => '13 Juni 2026'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Laporan & Statistik</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Ringkasan pendapatan, transaksi, item populer, dan export laporan.
            </p>
        </div>

        <button class="admin-btn-primary">Export Excel</button>
    </div>

    <div class="admin-card p-5">
        <label class="admin-label">Periode Laporan</label>
        <select class="admin-select max-w-xs">
            <option>Juni 2026</option>
            <option>Mei 2026</option>
            <option>April 2026</option>
        </select>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach ($summary as $item)
            <div class="admin-card p-5">
                <p class="font-heading text-2xl font-bold text-gray-900">{{ $item['value'] }}</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-[#4A2E28]">{{ $item['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="admin-card p-6">
        <h2 class="admin-title mb-4 text-xl">Grafik Pendapatan</h2>
        <div class="flex h-64 items-end gap-3 rounded-2xl border border-dashed border-[#E2D4C0] bg-[#FAF3E0] p-6">
            @foreach ([35, 55, 42, 75, 60, 90, 80] as $height)
                <div class="flex flex-1 items-end">
                    <div class="w-full rounded-t-xl bg-[#4A0F1A]/80" style="height: {{ $height }}%;"></div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card p-6">
        <h2 class="admin-title mb-4 text-xl">Item Terpopuler</h2>
        <div class="space-y-3">
            @foreach ($popularItems as $index => $item)
                <div class="flex items-center justify-between rounded-2xl bg-[#FAF3E0] p-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4A0F1A] text-sm font-bold text-white">
                            {{ $index + 1 }}
                        </span>
                        <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                    </div>
                    <span class="admin-muted text-sm">{{ $item['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card p-6">
        <h2 class="admin-title mb-4 text-xl">Daftar Transaksi</h2>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th">No. Pesanan</th>
                        <th class="admin-table-th">Customer</th>
                        <th class="admin-table-th">Item</th>
                        <th class="admin-table-th">Total</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2D4C0]">
                    @foreach ($transactions as $trx)
                        <tr>
                            <td class="admin-table-td font-semibold">{{ $trx['kode'] }}</td>
                            <td class="admin-table-td">{{ $trx['customer'] }}</td>
                            <td class="admin-table-td">{{ $trx['item'] }}</td>
                            <td class="admin-table-td">{{ $trx['total'] }}</td>
                            <td class="admin-table-td">
                                <span class="{{ $trx['status'] === 'Selesai' ? 'badge-active' : ($trx['status'] === 'Dibatalkan' ? 'badge-inactive' : 'badge-warning') }}">
                                    {{ $trx['status'] }}
                                </span>
                            </td>
                            <td class="admin-table-td">{{ $trx['tanggal'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
