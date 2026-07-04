@extends('admin.layouts.app')

@section('title', 'Pengembalian Barang')

@section('content')

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Pengembalian Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Pemeriksaan barang sewaan, kondisi barang, dan perhitungan denda.
        </p>
    </div>

    <div class="admin-card p-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach (['Semua', 'Belum Diperiksa (1)', 'Sedang Diperiksa', 'Selesai'] as $tab)
                <button class="rounded-full border border-[#E2D4C0] px-4 py-2 font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0]">
                    {{ $tab }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($returns as $return)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-heading text-xl font-bold text-[#4A0F1A]">#{{ $return['kode'] }}</h2>
                            <span class="badge-warning">{{ $return['status'] }}</span>
                            <h2 class="font-heading text-xl font-bold text-[#4A0F1A]">#{{ $return->kode_pengembalian }}</h2>
                            @php
                                $statusClass = match($return->status_pengembalian) {
                                    'selesai' => 'badge-active',
                                    'diperiksa' => 'badge-warning',
                                    default => 'badge-inactive',
                                };
                                @endphp

                                <span class="{{ $statusClass }}">
                                    {{ ucfirst(str_replace('_',' ', $return->status_pengembalian)) }}
                                </span>

                        </div>

                        <p class="text-sm text-[#4A2E28] flex items-center gap-1.5">Pesanan: ##{{ $return->detailPemesanan->pemesanan->kode_pemesanan }} <span class="text-[#E2D4C0] mx-1">|</span> <i data-lucide="user" class="h-3.5 w-3.5 text-[#4A2E28]/50 shrink-0"></i> {{ $return->detailPemesanan->pemesanan->nama_pemesan }}</p>
                        <p class="text-sm text-[#4A2E28]">
                            Item:

                            @if($return->detailPemesanan->barang)
                                {{ $return->detailPemesanan->barang->nama_barang }}
                            @elseif($return->detailPemesanan->jasa)
                                {{ $return->detailPemesanan->jasa->nama_jasa }}
                            @elseif($return->detailPemesanan->paket)
                                {{ $return->detailPemesanan->paket->nama_paket }}
                            @endif

                        </p>
                        <p class="text-sm text-[#4A2E28]">
                            Jadwal Kembali:
                            {{ $return->detailPemesanan->tanggal_kembali->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <a href="{{ route('admin.pengembalian.show', $return->id) }}" class="admin-btn-primary">
                        Periksa Barang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
