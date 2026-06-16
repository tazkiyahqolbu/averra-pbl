@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
    $adminName = Auth::user()->name ?? 'Admin Sanggar';

    $today = now()->translatedFormat('l, d F Y');

    $urgentCards = [
        [
            'title' => 'Pesanan Baru Masuk',
            'count' => 3,
            'icon' => '📋',
            'route' => 'admin.pemesanan.index',
        ],
        [
            'title' => 'Pembayaran Perlu Verif',
            'count' => 2,
            'icon' => '💳',
            'route' => 'admin.pembayaran.index',
        ],
        [
            'title' => 'Pengembalian Perlu Diperiksa',
            'count' => 1,
            'icon' => '📦',
            'route' => 'admin.pengembalian.index',
        ],
    ];

    $stats = [
        ['label' => 'Total Pemesanan', 'value' => 18],
        ['label' => 'Berlangsung', 'value' => 5],
        ['label' => 'Selesai', 'value' => 8],
        ['label' => 'Pendapatan Bulan Ini', 'value' => 'Rp 12.5jt'],
    ];

    $latestOrders = [
        ['kode' => 'AVR-001', 'customer' => 'Tazkiyah', 'item' => 'Paket Gold', 'status' => 'Menunggu'],
        ['kode' => 'AVR-002', 'customer' => 'Siti', 'item' => 'Kamera Canon', 'status' => 'Menunggu'],
        ['kode' => 'AVR-003', 'customer' => 'Zikra', 'item' => 'Paket Silver', 'status' => 'Berlangsung'],
    ];

    $routeUrl = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Selamat datang, {{ $adminName }} 👋</h1>
        <p class="admin-subtitle mt-1 text-sm">Hari ini, {{ $today }}</p>
    </div>

    <div>
        <div class="mb-3 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-orange-500"></span>
            <h2 class="text-sm font-bold uppercase tracking-wider text-orange-700">Butuh Tindakan</h2>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            @foreach ($urgentCards as $card)
                <div class="rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl">{{ $card['icon'] }}</p>
                            <h3 class="mt-3 text-sm font-semibold text-orange-900">{{ $card['title'] }}</h3>
                            <p class="mt-4 font-heading text-4xl font-bold text-orange-700">{{ $card['count'] }}</p>
                        </div>
                    </div>

                    <a href="{{ $routeUrl($card['route']) }}"
                       class="mt-5 inline-flex rounded-xl bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                        Lihat →
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <h2 class="admin-title mb-3 text-xl">Statistik Bulan Ini</h2>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="admin-card p-6">
                    <p class="font-heading text-3xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-[#7a5d58]">
                        {{ $stat['label'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card p-6">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="admin-title text-xl">Grafik Pemesanan</h2>
                <p class="admin-muted mt-1 text-sm">Preview grafik 7 hari terakhir / 30 hari terakhir.</p>
            </div>

            <div class="flex rounded-xl border border-[#decba5] bg-[#fffdf7] p-1 text-sm">
                <button class="rounded-lg bg-[#7b1c2e] px-4 py-2 font-semibold text-white">Mingguan</button>
                <button class="rounded-lg px-4 py-2 font-semibold text-[#7a5d58]">Bulanan</button>
            </div>
        </div>

        <div class="flex h-64 items-end gap-3 rounded-2xl border border-dashed border-[#decba5] bg-[#fff8ed] p-6">
            @foreach ([40, 70, 55, 90, 65, 80, 50] as $height)
                <div class="flex flex-1 items-end">
                    <div class="w-full rounded-t-xl bg-[#7b1c2e]/80" style="height: {{ $height }}%;"></div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card p-6">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="admin-title text-xl">Pesanan Terbaru</h2>
                <p class="admin-muted mt-1 text-sm">Daftar pesanan terbaru yang perlu dipantau admin.</p>
            </div>

            <a href="{{ $routeUrl('admin.pemesanan.index') }}" class="text-sm font-semibold text-[#7b1c2e] hover:text-[#4a0f1a]">
                Lihat Semua Pemesanan →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="border-b border-[#decba5] bg-[#f9f1e6]">
                    <tr>
                        <th class="admin-table-th">No. Pesanan</th>
                        <th class="admin-table-th">Customer</th>
                        <th class="admin-table-th">Item</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#decba5]">
                    @foreach ($latestOrders as $order)
                        <tr>
                            <td class="admin-table-td font-semibold text-gray-900">{{ $order['kode'] }}</td>
                            <td class="admin-table-td">{{ $order['customer'] }}</td>
                            <td class="admin-table-td">{{ $order['item'] }}</td>
                            <td class="admin-table-td">
                                @if ($order['status'] === 'Menunggu')
                                    <span class="badge-warning">{{ $order['status'] }}</span>
                                @elseif ($order['status'] === 'Berlangsung')
                                    <span class="badge-active">{{ $order['status'] }}</span>
                                @else
                                    <span class="badge-neutral">{{ $order['status'] }}</span>
                                @endif
                            </td>
                            <td class="admin-table-td">
                                <a href="{{ $routeUrl('admin.pemesanan.show') }}" class="font-semibold text-[#7b1c2e] hover:text-[#4a0f1a]">
                                    Tinjau
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
