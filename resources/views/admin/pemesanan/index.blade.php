@extends('admin.layouts.app')

@section('title', 'Pemesanan')

@section('content')
@php
    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'badge-warning'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
        'berlangsung'  => ['label' => 'Berlangsung',         'class' => 'badge-active'],
        'selesai'      => ['label' => 'Selesai',             'class' => 'badge-neutral'],
        'dibatalkan'   => ['label' => 'Dibatalkan',          'class' => 'badge-inactive'],
    ];

    $tabs = [
        'semua'        => 'Semua',
        'menunggu'     => 'Menunggu Konfirmasi',
        'dikonfirmasi' => 'Menunggu Pembayaran',
        'berlangsung'  => 'Berlangsung',
        'pengembalian' => 'Pengembalian',
        'selesai'      => 'Selesai',
        'dibatalkan'   => 'Dibatalkan',
    ];

    $activeTab = request('status', 'semua');
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Pemesanan</h1>
            <p class="admin-subtitle mt-1 text-sm">Kelola pesanan masuk, konfirmasi, penolakan, dan status pemesanan pelanggan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card p-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach($tabs as $slug => $label)
                <a href="{{ route('admin.pemesanan.index', ['status' => $slug]) }}"
                   class="rounded-full border px-4 py-2 font-semibold transition
                   {{ $activeTab === $slug
                        ? 'border-transparent bg-gradient-to-br from-[#6B1625] to-[#3A0A12] text-white shadow-[0_3px_10px_rgba(74,15,26,0.3)]'
                        : 'border-[#E2D4C0] text-[#4A0F1A] hover:bg-[#FAF3E0]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        @forelse($pemesanans as $pemesanan)
            @php
                $detail    = $pemesanan->detailPemesanans->first();
                $itemName  = $detail?->barang?->nama_barang
                          ?? $detail?->jasa?->nama_jasa
                          ?? $detail?->paket?->nama_paket
                          ?? '-';
                $jenisLabel = $pemesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Acara';
                $metode     = $pemesanan->pembayarans->first()?->tahap === 'langsung' ? 'Lunas' : 'DP 50%';
                $badge      = $statusMap[$pemesanan->status] ?? ['label' => ucfirst($pemesanan->status), 'class' => 'badge-neutral'];
            @endphp

            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-heading text-xl font-bold text-[#4A0F1A]">#{{ $pemesanan->kode_pemesanan }}</h2>
                            <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>
                        <p class="text-sm text-[#4A2E28] flex items-center gap-1.5"><i data-lucide="user" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> {{ $pemesanan->user?->nama }} <span class="text-[#E2D4C0] mx-1">|</span> <i data-lucide="phone" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> {{ $pemesanan->user?->no_hp ?? '-' }}</p>
                        <p class="text-sm text-[#4A2E28] flex items-center gap-1.5"><i data-lucide="clipboard-list" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> {{ $itemName }} <span class="text-[#4A2E28]">[{{ $jenisLabel }}]</span></p>
                        <p class="text-sm text-[#4A2E28] flex items-center gap-1.5"><i data-lucide="calendar" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> Pelaksanaan: {{ $pemesanan->tanggal_pakai?->format('d M Y') ?? '-' }} <span class="text-[#E2D4C0] mx-1">|</span> <i data-lucide="map-pin" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> {{ $pemesanan->zonaLokasi?->nama_zona ?? '-' }}</p>
                        <p class="text-sm text-[#4A2E28] flex items-center gap-1.5"><i data-lucide="wallet" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> Total: <strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong> <span class="text-[#4A2E28]">(Metode: {{ $metode }})</span></p>
                        <p class="text-xs text-[#4A2E28] flex items-center gap-1.5"><i data-lucide="clock" class="h-3 w-3 text-[#4A2E28]/40 shrink-0"></i> Dipesan: {{ $pemesanan->created_at->format('d M Y, H.i') }}</p>
                    </div>

                    <div class="flex flex-wrap items-start gap-2">
                        <a href="{{ route('admin.pemesanan.show', $pemesanan->id) }}" class="admin-btn-secondary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-card p-10 text-center">
                <p class="font-medium text-[#4A2E28]/60">Tidak ada pemesanan untuk filter ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
