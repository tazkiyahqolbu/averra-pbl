@extends('user.layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start min-h-[60vh] py-4">
<div class="w-full max-w-lg">

<div class="mb-6 text-center">
    <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— PEMBAYARAN —</p>
    <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">Pilih Metode Pembayaran</h1>
</div>

@if(session('error'))
    <div class="mb-4 flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
        <i data-lucide="x-circle" class="h-4 w-4 shrink-0"></i>
        {{ session('error') }}
    </div>
@endif

<div class="space-y-4">
    {{-- Info pesanan --}}
    <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-3">Detail Pesanan</p>
        <div class="flex justify-between items-center">
            <span class="text-sm text-[#4A2E28]">{{ $pesanan->kode_pemesanan }}</span>
            <span class="font-serif font-semibold text-[#C8960C]">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($isPelunasan)
        @php
            $sudahBayar = $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
            $sisaBayar  = max(0, $pesanan->total_harga - $sudahBayar);
        @endphp
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
            <p class="text-sm font-semibold text-blue-800 mb-1">Pelunasan Sisa Pembayaran</p>
            <p class="font-serif text-2xl font-bold text-blue-700">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</p>
        </div>
        <form action="{{ route('user.pembayaran.initiate', $pesanan->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar Pelunasan via Midtrans
            </button>
        </form>
    @else
        {{-- DP 50% Only --}}
        <div class="rounded-2xl border-2 border-[#C8960C] bg-[#FAF3E0] p-5">
            <div class="flex items-start gap-3">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-[#C8960C] mt-0.5 shrink-0">
                    <i data-lucide="check" class="h-3 w-3 text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-[#4A0F1A]">Bayar DP 50%</p>
                    <p class="text-sm text-[#4A2E28]/60 mt-0.5">Uang muka untuk mengkonfirmasi pesanan Anda</p>
                    <p class="font-serif font-bold text-[#C8960C] mt-1 text-xl">Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }}</p>
                    <p class="text-xs text-[#4A2E28]/50 mt-1">Sisa Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }} dibayar setelah layanan selesai</p>
                </div>
            </div>
        </div>
        <form action="{{ route('user.pembayaran.initiate', $pesanan->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200 mt-3">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar DP via Midtrans
            </button>
        </form>
    @endif

    <a href="{{ route('user.pemesanan.show', $pesanan->id) }}"
       class="flex items-center justify-center gap-1.5 text-sm text-[#4A2E28]/60 hover:text-[#4A0F1A] transition mt-2">
        <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
        Kembali ke Detail Pesanan
    </a>
</div>

</div>
</div>
@endsection