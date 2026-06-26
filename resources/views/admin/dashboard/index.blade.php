@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
    $adminName = Auth::user()->nama ?? Auth::user()->name ?? 'Admin Sanggar';
    $today = now()->translatedFormat('l, d F Y');

    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'badge-warning'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
        'berlangsung'  => ['label' => 'Berlangsung', 'class' => 'badge-active'],
        'selesai'      => ['label' => 'Selesai', 'class' => 'badge-neutral'],
        'dibatalkan'   => ['label' => 'Dibatalkan', 'class' => 'badge-inactive'],
    ];
@endphp

<div class="admin-section space-y-6">

    {{-- Header --}}
    <div>
        <p class="text-[10px] md:text-xs tracking-[0.25em] md:tracking-[0.4em] text-[#C8960C] uppercase font-semibold">
            — ADMIN PANEL —
        </p>

        <h1 class="admin-title mt-1 text-2xl md:text-3xl font-light break-words">
            Selamat datang, {{ $adminName }}
        </h1>

        <p class="admin-subtitle mt-1 text-sm">
            {{ $today }}
        </p>
    </div>

    {{-- Butuh Tindakan --}}
    <section>
        <div class="mb-3 flex items-center gap-2">
            <i data-lucide="alert-circle" class="h-4 w-4 text-orange-500"></i>
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-orange-700">
                Butuh Tindakan
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <a href="{{ route('admin.pemesanan.index', ['status' => 'menunggu']) }}"
               class="group rounded-2xl border border-orange-200 bg-orange-50 p-4 md:p-5 shadow-sm hover:shadow-md hover:border-orange-300 transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-orange-700">Pesanan Baru Masuk</p>
                        <p class="mt-2 font-serif text-3xl md:text-4xl font-light text-orange-900">
                            {{ $pendingBookingsCount }}
                        </p>
                    </div>
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 border border-orange-200">
                        <i data-lucide="clipboard-list" class="h-5 w-5 text-orange-600"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.pembayaran.index') }}"
               class="group rounded-2xl border border-orange-200 bg-orange-50 p-4 md:p-5 shadow-sm hover:shadow-md hover:border-orange-300 transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-orange-700">Pembayaran Perlu Verifikasi</p>
                        <p class="mt-2 font-serif text-3xl md:text-4xl font-light text-orange-900">
                            {{ $confirmedBookingsCount }}
                        </p>
                    </div>
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 border border-orange-200">
                        <i data-lucide="credit-card" class="h-5 w-5 text-orange-600"></i>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.pengembalian.index') }}"
               class="group rounded-2xl border border-orange-200 bg-orange-50 p-4 md:p-5 shadow-sm hover:shadow-md hover:border-orange-300 transition-all">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-orange-700">Pengembalian Perlu Diperiksa</p>
                        <p class="mt-2 font-serif text-3xl md:text-4xl font-light text-orange-900">—</p>
                    </div>
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 border border-orange-200">
                        <i data-lucide="package" class="h-5 w-5 text-orange-600"></i>
                    </div>
                </div>
            </a>

        </div>
    </section>

    {{-- Statistik --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['label' => 'Pemesanan Bulan Ini', 'value' => $thisMonthBookingsCount, 'icon' => 'calendar'],
            ['label' => 'Total Pemesanan', 'value' => $totalBookingsCount, 'icon' => 'layers'],
            ['label' => 'Menunggu Konfirmasi', 'value' => $pendingBookingsCount, 'icon' => 'clock'],
            ['label' => 'Menunggu Pembayaran', 'value' => $confirmedBookingsCount, 'icon' => 'banknote'],
        ] as $stat)
            <div class="admin-card p-4 md:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-[10px] md:text-[9px] font-semibold uppercase tracking-[0.15em] text-[#4A2E28]/60">
                            {{ $stat['label'] }}
                        </p>
                        <p class="mt-2 font-serif text-3xl md:text-4xl font-light text-[#4A0F1A]">
                            {{ $stat['value'] }}
                        </p>
                    </div>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#FAF3E0] border border-[#E2D4C0]">
                        <i data-lucide="{{ $stat['icon'] }}" class="h-4 w-4 text-[#C8960C]"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    {{-- Tabel Pesanan --}}
    <section class="admin-card p-4 md:p-6">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="admin-title text-lg md:text-xl">Pesanan Terbaru</h2>
                <p class="admin-subtitle mt-1 text-sm">
                    10 pesanan terbaru yang perlu dipantau.
                </p>
            </div>

            <a href="{{ route('admin.pemesanan.index') }}"
               class="text-xs font-semibold text-[#C8960C] hover:text-[#A07800]">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-[720px] w-full border-collapse">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th">No. Pesanan</th>
                        <th class="admin-table-th">Customer</th>
                        <th class="admin-table-th">Item</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2D4C0]">
                    @forelse($bookings as $booking)
                        @php
                            $detail = $booking->detailPemesanans->first();
                            $itemName = $detail?->barang?->nama_barang
                                ?? $detail?->jasa?->nama_jasa
                                ?? $detail?->paket?->nama_paket
                                ?? '-';

                            $badge = $statusMap[$booking->status]
                                ?? ['label' => ucfirst($booking->status), 'class' => 'badge-neutral'];
                        @endphp

                        <tr class="hover:bg-[#FAF3E0]/60 transition">
                            <td class="admin-table-td font-semibold text-[#4A0F1A]">
                                {{ $booking->kode_pemesanan }}
                            </td>
                            <td class="admin-table-td">
                                {{ $booking->user?->nama ?? $booking->user?->name ?? '-' }}
                            </td>
                            <td class="admin-table-td">{{ $itemName }}</td>
                            <td class="admin-table-td">
                                <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </td>
                            <td class="admin-table-td">
                                <a href="{{ route('admin.pemesanan.show', $booking->id) }}"
                                   class="text-sm font-semibold text-[#C8960C] hover:text-[#A07800]">
                                    Tinjau →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-table-td py-10 text-center text-[#4A2E28]/50">
                                Belum ada pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
