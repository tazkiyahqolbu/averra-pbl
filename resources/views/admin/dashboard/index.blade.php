@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
    $adminName = Auth::user()->nama ?? 'Admin Sanggar';
    $today     = now()->translatedFormat('l, d F Y');

    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'badge-warning'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
        'berlangsung'  => ['label' => 'Berlangsung',         'class' => 'badge-active'],
        'selesai'      => ['label' => 'Selesai',             'class' => 'badge-neutral'],
        'dibatalkan'   => ['label' => 'Dibatalkan',          'class' => 'badge-inactive'],
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Selamat datang, {{ $adminName }} 👋</h1>
        <p class="admin-subtitle mt-1 text-sm">Hari ini, {{ $today }}</p>
    </div>

    {{-- Butuh Tindakan --}}
    <div>
        <div class="mb-3 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-orange-500"></span>
            <h2 class="text-sm font-bold uppercase tracking-wider text-orange-700">Butuh Tindakan</h2>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <a href="{{ route('admin.pemesanan.index', ['status' => 'menunggu']) }}"
               class="rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-orange-700">Pesanan Baru Masuk</p>
                        <p class="mt-1 text-3xl font-bold text-orange-900">{{ $pendingBookingsCount }}</p>
                    </div>
                    <span class="text-3xl">📋</span>
                </div>
            </a>

            <a href="{{ route('admin.pembayaran.index') }}"
               class="rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-orange-700">Pembayaran Perlu Verif</p>
                        <p class="mt-1 text-3xl font-bold text-orange-900">{{ $confirmedBookingsCount }}</p>
                    </div>
                    <span class="text-3xl">💳</span>
                </div>
            </a>

            <a href="{{ route('admin.pengembalian.index') }}"
               class="rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-orange-700">Pengembalian Perlu Diperiksa</p>
                        <p class="mt-1 text-3xl font-bold text-orange-900">—</p>
                    </div>
                    <span class="text-3xl">📦</span>
                </div>
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 md:grid-cols-4">
        <div class="admin-card p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $thisMonthBookingsCount }}</p>
            <p class="admin-muted mt-1 text-xs uppercase">Pemesanan Bulan Ini</p>
        </div>
        <div class="admin-card p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $totalBookingsCount }}</p>
            <p class="admin-muted mt-1 text-xs uppercase">Total Pemesanan</p>
        </div>
        <div class="admin-card p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $pendingBookingsCount }}</p>
            <p class="admin-muted mt-1 text-xs uppercase">Menunggu Konfirmasi</p>
        </div>
        <div class="admin-card p-5 text-center">
            <p class="text-3xl font-bold text-gray-900">{{ $confirmedBookingsCount }}</p>
            <p class="admin-muted mt-1 text-xs uppercase">Menunggu Pembayaran</p>
        </div>
    </div>

    {{-- Tabel Pesanan Terbaru --}}
    <div class="admin-card p-6">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="admin-title text-xl">Pesanan Terbaru</h2>
                <p class="admin-muted mt-1 text-sm">Daftar 10 pesanan terbaru yang perlu dipantau admin.</p>
            </div>
            <a href="{{ route('admin.pemesanan.index') }}" class="text-sm font-semibold text-[#7b1c2e] hover:text-[#4a0f1a]">
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
                    @forelse($bookings as $booking)
                        @php
                            $detail   = $booking->detailPemesanans->first();
                            $itemName = $detail?->barang?->nama_barang
                                     ?? $detail?->jasa?->nama_jasa
                                     ?? $detail?->paket?->nama_paket
                                     ?? '-';
                            $badge    = $statusMap[$booking->status] ?? ['label' => ucfirst($booking->status), 'class' => 'badge-neutral'];
                        @endphp
                        <tr>
                            <td class="admin-table-td font-semibold text-gray-900">{{ $booking->kode_pemesanan }}</td>
                            <td class="admin-table-td">{{ $booking->user?->nama ?? '-' }}</td>
                            <td class="admin-table-td">{{ $itemName }}</td>
                            <td class="admin-table-td">
                                <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </td>
                            <td class="admin-table-td">
                                <a href="{{ route('admin.pemesanan.show', $booking->id) }}"
                                   class="font-semibold text-[#7b1c2e] hover:text-[#4a0f1a]">
                                    Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-table-td text-center text-gray-400">Belum ada pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
