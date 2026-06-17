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
                        ? 'border-[#5A0B1A] bg-[#5A0B1A] text-white'
                        : 'border-[#decba5] text-[#5A0B1A] hover:bg-[#f7efe2]' }}">
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
                            <h2 class="font-heading text-xl font-bold text-gray-900">#{{ $pemesanan->kode_pemesanan }}</h2>
                            <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>
                        <p class="text-sm text-gray-700">👤 {{ $pemesanan->user?->nama }} | 📞 {{ $pemesanan->user?->no_hp ?? '-' }}</p>
                        <p class="text-sm text-gray-700">📋 {{ $itemName }} <span class="text-[#7a5d58]">[{{ $jenisLabel }}]</span></p>
                        <p class="text-sm text-gray-700">📅 Pelaksanaan: {{ $pemesanan->tanggal_pakai?->format('d M Y') ?? '-' }} | 📍 {{ $pemesanan->zonaLokasi?->nama_zona ?? '-' }}</p>
                        <p class="text-sm text-gray-700">💰 Total: <strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong> <span class="text-[#7a5d58]">(Metode: {{ $metode }})</span></p>
                        <p class="text-xs text-[#7a5d58]">🕐 Dipesan: {{ $pemesanan->created_at->format('d M Y, H.i') }}</p>
                    </div>

                    <div class="flex flex-wrap items-start gap-2">
                        <a href="{{ route('admin.pemesanan.show', $pemesanan->id) }}" class="admin-btn-secondary">Lihat Detail</a>

                        @if($pemesanan->status === 'menunggu')
                            <form method="POST" action="{{ route('admin.pemesanan.konfirmasi', $pemesanan->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="admin-btn-primary">Konfirmasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.pemesanan.tolak', $pemesanan->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="admin-btn-danger">Tolak</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-card p-10 text-center text-gray-500">
                Tidak ada pemesanan untuk filter ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
