@extends('user.layouts.app')

@section('content')
@php
    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-300'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-blue-100 text-blue-800 border border-blue-300'],
        'berlangsung'  => ['label' => 'Berlangsung',         'class' => 'bg-green-100 text-green-800 border border-green-300'],
        'selesai'      => ['label' => 'Selesai',             'class' => 'bg-gray-100 text-gray-700 border border-gray-300'],
        'dibatalkan'   => ['label' => 'Dibatalkan',          'class' => 'bg-red-100 text-red-800 border border-red-300'],
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

<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between gap-3">
            <h1 class="text-lg font-bold text-gray-900">Pemesanan</h1>
            <a href="{{ route('user.pemesanan.create.acara') }}"
               class="px-5 py-2.5 rounded-full text-sm font-semibold bg-[#3d0a13] text-white shadow-md hover:bg-[#2a070d] transition-all duration-300">
                + Buat Pemesanan Baru
            </a>
        </div>

        {{-- Tabs --}}
        <div class="overflow-x-auto">
            <div class="flex items-center gap-3 whitespace-nowrap">
                @foreach($tabs as $slug => $label)
                    <a href="{{ route('user.pemesanan.index', ['status' => $slug]) }}"
                       class="shrink-0 px-2.5 py-2 text-sm font-semibold transition-colors duration-150
                       {{ $activeTab === $slug
                            ? 'text-[#5D001E] border-b-2 border-[#5D001E]'
                            : 'text-gray-600 border-b-2 border-transparent hover:text-red-800 hover:border-red-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Daftar pesanan --}}
        <div class="mt-1 space-y-3">
            @forelse($pesanans as $p)
                @php
                    $detail   = $p->detailPemesanans->first();
                    $itemName = $detail?->barang?->nama_barang
                             ?? $detail?->jasa?->nama_jasa
                             ?? $detail?->paket?->nama_paket
                             ?? '-';
                    $jenis    = $p->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Acara';
                    $badge    = $statusMap[$p->status] ?? ['label' => ucfirst($p->status), 'class' => 'bg-gray-100 text-gray-700 border border-gray-300'];
                @endphp
                <a href="{{ route('user.pemesanan.show', $p->id) }}"
                   class="block p-4 rounded-2xl bg-white border border-gray-200 hover:border-[#5D001E] hover:shadow-sm transition-all">
                    <div class="flex items-start justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $p->kode_pemesanan ?? ('#' . $p->id) }}</span>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">📋 {{ $itemName }} <span class="text-gray-400">[{{ $jenis }}]</span></p>
                            <p class="text-sm text-gray-600">📅 {{ $p->tanggal_pakai?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-[#5D001E]">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $p->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="py-10 text-center text-gray-400 text-sm">
                    Belum ada pemesanan untuk filter ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
