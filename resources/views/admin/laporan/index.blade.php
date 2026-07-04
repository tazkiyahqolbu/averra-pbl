@extends('admin.layouts.app')

@section('title', 'Laporan & Statistik')

@section('content')
@php
$summary = [
    [
        'label' => 'Pendapatan Bulan Ini',
        'value' => 'Rp ' . number_format($pendapatanBulanIni,0,',','.')
    ],
    [
        'label' => 'Total Pemesanan',
        'value' => $totalPemesanan
    ],
    [
        'label' => 'Pemesanan Selesai',
        'value' => $pemesananSelesai
    ],
    [
        'label' => 'Pemesanan Dibatalkan',
        'value' => $pemesananDibatalkan
    ],
    [
        'label' => 'Rata-rata Nilai Order',
        'value' => 'Rp ' . number_format($rataOrder,0,',','.')
    ],
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

        <a href="{{ route('admin.laporan.export') }}"
        class="admin-btn-primary">
            Export Excel
        </a>
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
                <p class="font-heading text-2xl font-bold text-[#4A0F1A]">{{ $item['value'] }}</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-[#4A2E28]">{{ $item['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="admin-card p-6">
    <h2 class="admin-title mb-4 text-xl">
        Grafik Pendapatan
    </h2>

    <div class="flex h-64 items-end gap-3 rounded-2xl border border-dashed border-[#E2D4C0] bg-[#FAF3E0] p-6">

    @foreach($grafikPendapatan as $item)

        @php
            $height = ($item['total'] / $maxPendapatan) * 100;
        @endphp

        <div class="flex flex-1 flex-col items-center h-full">

            {{-- Nominal --}}
            @if($item['total'] > 0)
                <span class="mb-2 text-[11px] font-semibold text-[#4A0F1A]">
                    Rp {{ number_format($item['total']/1000000,1) }} jt
                </span>
            @else
                <span class="mb-2 h-[18px]"></span>
            @endif

            {{-- Area batang --}}
            <div class="flex-1 flex items-end justify-center w-full">

                <div
                    class="w-10 rounded-t-xl bg-[#4A0F1A] hover:bg-[#731827] transition-all duration-300 cursor-pointer"
                    style="height: {{ $height }}%;">
                </div>

            </div>

            {{-- Nama bulan --}}
            <span class="mt-2 text-xs font-medium">
                {{ $item['bulan'] }}
            </span>

        </div>

    @endforeach

    </div>
    </div>

    <div class="admin-card p-6">
        <h2 class="admin-title mb-4 text-xl">Item Terpopuler</h2>
        <div class="space-y-3">
            @foreach ($popularItems as $item)
                <div class="flex items-center justify-between rounded-2xl bg-[#FAF3E0] p-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#4A0F1A] text-sm font-bold text-white">
                            {{ $loop->iteration }}
                        </span>
                        <div>
                        <p class="font-semibold text-[#4A2E28]">
                            {{ $item['name'] }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $item['jenis'] }}
                        </p>
                    </div>
                    </div>
                    <span class="admin-muted text-sm">{{ $item['count'] }} kali dipesan</span>
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
                                @php

                    $statusClass = match($trx['status']) {

                        'selesai' => 'badge-active',

                        'dibatalkan' => 'badge-inactive',

                        default => 'badge-warning',

                    };

                    @endphp

                    <span class="{{ $statusClass }}">
                        {{ ucfirst($trx['status']) }}
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
