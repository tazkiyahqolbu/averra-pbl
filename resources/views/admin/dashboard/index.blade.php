@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
@php
    $pendingPemesanans = $bookings->where('status', 'menunggu');

    $quickActions = [
        [
            'label' => 'Lihat Pemesanan',
            'route' => 'admin.pemesanan.index',
            'fallback' => '#',
        ],
        [
            'label' => 'Verifikasi Pembayaran',
            'route' => 'admin.pembayaran.index',
            'fallback' => '#',
        ],
        [
            'label' => 'Kelola Barang',
            'route' => 'admin.barang.index',
            'fallback' => '#',
        ],
    ];
@endphp

<div class="admin-section">
    @if (($pendingBookingsCount ?? 0) > 0)
        <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 text-amber-900 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="font-semibold">Ada {{ $pendingBookingsCount }} pemesanan yang menunggu konfirmasi.</p>
                    <p class="mt-1 text-sm text-amber-800">Segera cek daftar pemesanan agar pelanggan mendapat kepastian jadwal.</p>
                </div>
                <a href="{{ \Illuminate\Support\Facades\Route::has('admin.pemesanan.index') ? route('admin.pemesanan.index') : '#' }}"
                   class="inline-flex rounded-2xl bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                    Lihat Pemesanan
                </a>
            </div>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 animate-scale-in">
        <div class="admin-card p-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-[#7b1c2e]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <p class="mt-4 font-heading text-3xl font-bold text-gray-900">{{ $thisMonthBookingsCount ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-[#7a5d58]">Pemesanan Bulan Ini</p>
        </div>

        <div class="admin-card p-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            </div>
            <p class="mt-4 font-heading text-3xl font-bold text-amber-700">{{ $pendingBookingsCount ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-amber-600">Menunggu Konfirmasi</p>
        </div>

        <div class="admin-card p-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <p class="mt-4 font-heading text-3xl font-bold text-emerald-700">{{ $confirmedBookingsCount ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-emerald-600">Dikonfirmasi</p>
        </div>

        <div class="admin-card p-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
            </div>
            <p class="mt-4 font-heading text-3xl font-bold text-gray-900">{{ $totalBookingsCount ?? 0 }}</p>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-[#7a5d58]">Total Pemesanan</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="admin-card p-6 xl:col-span-1">
            <div class="mb-5">
                <h3 class="admin-title text-xl">Aksi Cepat</h3>
                <p class="admin-muted mt-1 text-sm">Navigasi cepat ke halaman admin yang sering dipakai.</p>
            </div>

            <div class="grid gap-3">
                @foreach ($quickActions as $action)
                    @php
                        $href = \Illuminate\Support\Facades\Route::has($action['route'])
                            ? route($action['route'])
                            : $action['fallback'];
                    @endphp

                    <a href="{{ $href }}" class="admin-btn-secondary justify-start">
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-6 xl:col-span-2">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="admin-title text-xl">Pemesanan Terbaru</h3>
                    <p class="admin-muted mt-1 text-sm">Data diambil dari tabel pemesanan berdasarkan waktu terbaru.</p>
                </div>
                <a href="{{ \Illuminate\Support\Facades\Route::has('admin.pemesanan.index') ? route('admin.pemesanan.index') : '#' }}"
                   class="text-sm font-semibold text-[#7b1c2e] hover:text-[#4a0f1a]">
                    Lihat semua
                </a>
            </div>

            @if ($bookings->isEmpty())
                <div class="admin-empty">
                    Belum ada data pemesanan.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="border-b border-[#decba5] bg-[#f9f1e6]">
                            <tr>
                                <th class="admin-table-th">Kode</th>
                                <th class="admin-table-th">Pelanggan</th>
                                <th class="admin-table-th">Tanggal Pakai</th>
                                <th class="admin-table-th">Jenis</th>
                                <th class="admin-table-th">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#decba5]">
                            @foreach ($bookings->take(5) as $pemesanan)
                                <tr>
                                    <td class="admin-table-td font-semibold text-gray-900">
                                        {{ $pemesanan->kode_pemesanan ?? 'PM-' . $pemesanan->id }}
                                    </td>
                                    <td class="admin-table-td">
                                        <p class="font-semibold text-gray-900">{{ $pemesanan->user?->nama ?? '-' }}</p>
                                        <p class="text-xs text-[#7a5d58]">{{ $pemesanan->no_hp ?? '-' }}</p>
                                    </td>
                                    <td class="admin-table-td">
                                        {{ optional($pemesanan->tanggal_pakai)->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="admin-table-td capitalize">
                                        {{ str_replace('_', ' ', $pemesanan->jenis ?? '-') }}
                                    </td>
                                    <td class="admin-table-td">
                                        @if ($pemesanan->status === 'menunggu')
                                            <span class="badge-warning">Menunggu</span>
                                        @elseif ($pemesanan->status === 'dikonfirmasi')
                                            <span class="badge-active">Dikonfirmasi</span>
                                        @elseif ($pemesanan->status === 'dibatalkan')
                                            <span class="badge-inactive">Dibatalkan</span>
                                        @else
                                            <span class="badge-neutral">{{ ucfirst($pemesanan->status ?? '-') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-card p-6">
        <div class="mb-5 flex items-center gap-2">
            <svg class="h-5 w-5 text-[#7b1c2e]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <h3 class="admin-title text-xl">Notifikasi Pemesanan Baru</h3>
        </div>

        @if ($pendingPemesanans->isEmpty())
            <p class="text-sm text-[#7a5d58]">Tidak ada pemesanan yang menunggu persetujuan.</p>
        @else
            <ul class="divide-y divide-[#decba5]">
                @foreach ($pendingPemesanans->take(5) as $pemesanan)
                    <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">
                                {{ $pemesanan->user?->nama ?? '-' }}
                                <span class="text-xs font-normal text-[#7a5d58]">· {{ $pemesanan->kode_pemesanan ?? $pemesanan->id }}</span>
                            </p>
                            <p class="mt-1 text-xs text-[#7a5d58]">
                                {{ str_replace('_', ' ', $pemesanan->jenis ?? '-') }} ·
                                {{ optional($pemesanan->tanggal_pakai)->format('d M Y') ?? '-' }} ·
                                {{ $pemesanan->lokasi ?? '-' }}
                            </p>
                        </div>
                        <span class="badge-warning">Menunggu</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
