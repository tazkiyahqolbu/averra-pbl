@extends('user.layouts.app')

@section('content')
@php
    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-amber-50 text-amber-700 border border-amber-200'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-blue-50 text-blue-700 border border-blue-200'],
        'berlangsung'  => ['label' => 'Berlangsung',         'class' => 'bg-green-50 text-green-700 border border-green-200'],
        'selesai'      => ['label' => 'Selesai',             'class' => 'bg-[#E2D4C0] text-[#4A2E28]'],
        'dibatalkan'   => ['label' => 'Dibatalkan',          'class' => 'bg-red-50 text-red-700 border border-red-200'],
    ];
    $tabs = [
        'semua'        => 'Semua',
        'menunggu'     => 'Konfirmasi',
        'dikonfirmasi' => 'Pembayaran',
        'berlangsung'  => 'Berlangsung',
        'pengembalian' => 'Pengembalian',
        'selesai'      => 'Selesai',
        'dibatalkan'   => 'Dibatalkan',
    ];
    $activeTab = request('status', 'semua');
@endphp

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— RIWAYAT —</p>
        <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">Pemesanan Saya</h1>
    </div>
    <a href="{{ route('user.pemesanan.create.acara') }}"
       class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-5 py-2.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.35)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.45)] hover:from-[#7B1C2E] transition-all duration-200 w-full sm:w-auto">
        <i data-lucide="plus" class="h-4 w-4"></i> Buat Pesanan
    </a>
</div>

{{-- Tabs --}}
<div class="mb-5 overflow-x-auto">
    <div class="flex items-center gap-1 whitespace-nowrap pb-1">
        @foreach($tabs as $slug => $label)
            <a href="{{ route('user.pemesanan.index', ['status' => $slug]) }}"
               class="shrink-0 rounded-full px-4 py-1.5 text-sm font-medium transition-all duration-200
                      {{ $activeTab === $slug
                          ? 'bg-gradient-to-br from-[#6B1625] to-[#3A0A12] text-[#FAF3E0] shadow-[0_3px_10px_rgba(74,15,26,0.3)]'
                          : 'text-[#4A2E28] hover:bg-[#E2D4C0]/70 hover:text-[#4A0F1A]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

{{-- Daftar --}}
<div class="space-y-3">
    @forelse($pesanans as $p)
        @php
            $detail   = $p->detailPemesanans->first();
            $itemName = $detail?->barang?->nama_barang
                     ?? $detail?->jasa?->nama_jasa
                     ?? $detail?->paket?->nama_paket
                     ?? '-';
            $jenis    = $p->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara';
            $badge    = $statusMap[$p->status] ?? ['label' => ucfirst($p->status), 'class' => 'bg-[#E2D4C0] text-[#4A2E28]'];
        @endphp
        <a href="{{ route('user.pemesanan.show', $p->id) }}"
           class="group flex items-start justify-between gap-4 rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_1px_4px_rgba(74,15,26,0.05)] p-5 transition hover:border-[#C8960C]/60 hover:shadow-md">
            <div class="flex items-start gap-4 min-w-0">
                {{-- Ikon jenis --}}
                <div class="shrink-0 mt-0.5 flex h-10 w-10 items-center justify-center rounded-xl bg-[#FAF3E0] border border-[#E2D4C0]">
                    <i data-lucide="{{ $p->jenis === 'sewa_barang' ? 'shirt' : 'calendar' }}"
                       class="h-4 w-4 text-[#4A0F1A]"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="font-semibold text-[#4A0F1A] text-sm">{{ $p->kode_pemesanan ?? ('#' . $p->id) }}</span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-semibold {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <p class="text-sm text-[#4A2E28] truncate">{{ $itemName }}</p>
                    <p class="text-xs text-[#4A2E28]/60 mt-0.5">
                        {{ $jenis }} &middot; {{ $p->tanggal_pakai?->format('d M Y') ?? '-' }}
                    </p>
                    @if($p->status === 'dibatalkan' && $p->alasan_penolakan)
                        <p class="text-xs text-red-500 mt-1 truncate">
                            <span class="font-semibold">Alasan:</span> {{ $p->alasan_penolakan }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="shrink-0 text-right">
                <p class="font-serif font-semibold text-[#C8960C]">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                <p class="text-[10px] text-[#4A2E28]/50 mt-1">{{ $p->created_at->format('d M Y') }}</p>
                <i data-lucide="chevron-right" class="h-4 w-4 text-[#4A2E28]/40 mt-1 ml-auto group-hover:text-[#C8960C] transition"></i>
            </div>
        </a>
    @empty
        <div class="py-20 text-center rounded-2xl border border-[#E2D4C0] bg-white shadow-sm">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#E2D4C0]/50">
                <i data-lucide="clipboard-x" class="h-6 w-6 text-[#C8960C]"></i>
            </div>
            <p class="font-serif text-lg text-[#4A0F1A]">Belum ada pemesanan</p>
            <p class="mt-1 text-sm text-[#4A2E28]">Mulai pesan layanan atau sewa barang dari katalog kami.</p>
            <a href="{{ route('public.katalog.index') }}"
               class="mt-5 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#D4A820] to-[#96700A] px-6 py-2.5 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(160,120,0,0.3)] hover:shadow-[0_6px_18px_rgba(160,120,0,0.4)] transition-all duration-200">
                Lihat Katalog
            </a>
        </div>
    @endforelse
</div>

@endsection
