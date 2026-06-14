@extends('user.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 my-10 animate-fade-in px-4 sm:px-0">
    
    {{-- Header Atas --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">RIWAYAT</p>
            <h2 class="text-3xl font-bold text-[#5D001E]">Daftar Pemesanan</h2>
        </div>
        <div>
            <a href="{{ route('public.katalog.index') }}"
   class="inline-flex items-center rounded-full bg-[#5D001E] text-white px-5 py-2.5 text-xs font-semibold hover:bg-[#4A0F1A] transition shadow-md border border-[#D4AF37]">
    + Buat Pemesanan Baru
</a>
        </div>
    </div>

    {{-- Daftar Kartu Pemesanan --}}
    <div class="grid gap-4">
        @forelse ($pemesanans as $p)
            <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4 transition hover:border-[#5D001E]/30 hover:shadow-md">
                
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-gray-900 text-lg">{{ $p->kode_pemesanan }}</span>
                        
                        {{-- Status Badge (Maroon Theme) --}}
                        @if($p->status === 'menunggu')
                            <span class="rounded-full bg-[#FAF3E0] border border-[#D4AF37]/50 px-2.5 py-0.5 text-xs font-medium text-[#5D001E]">Menunggu</span>
                        @elseif($p->status === 'dikonfirmasi')
                            <span class="rounded-full bg-blue-50 border border-blue-200 px-2.5 py-0.5 text-xs font-medium text-blue-800">Dikonfirmasi</span>
                        @elseif($p->status === 'berlangsung')
                            <span class="rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 text-xs font-medium text-emerald-800">Berlangsung</span>
                        @elseif($p->status === 'selesai')
                            <span class="rounded-full bg-gray-100 border border-gray-200 px-2.5 py-0.5 text-xs font-medium text-gray-700">Selesai</span>
                        @else
                            <span class="rounded-full bg-rose-50 border border-rose-200 px-2.5 py-0.5 text-xs font-medium text-rose-800">Dibatalkan</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 font-medium">
                        <div>Tanggal Sesi: <span class="text-gray-800 font-semibold">{{ is_string($p->tanggal_pakai) ? $p->tanggal_pakai : $p->tanggal_pakai->format('d M Y') }}</span></div>
                        <div>Kategori: <span class="text-[#5D001E] uppercase font-bold text-[10px] bg-[#FAF3E0] px-2 py-0.5 rounded">{{ $p->kategori_order }}</span></div>
                    </div>
                </div>

                {{-- Sisi Kanan: Nominal & Tombol Aksi --}}
<div class="flex items-center justify-between md:justify-end gap-6 border-t md:border-t-0 pt-4 md:pt-0">
    <div class="text-left md:text-right">
        <span class="block text-[10px] uppercase tracking-wider text-gray-400 font-bold">Total Pembayaran</span>
        <span class="text-lg font-extrabold text-[#5D001E]">Rp{{ number_format($p->total_harga, 0, ',', '.') }}</span>
    </div>
    
    <div class="flex flex-col gap-2">
        {{-- Tombol Lihat Detail (Selalu muncul) --}}
        <a href="{{ route('user.pemesanan.show', $p->id) }}" 
           class="inline-flex justify-center rounded-full border border-[#5D001E] bg-white px-4 py-2 text-xs font-semibold text-[#5D001E] hover:bg-[#5D001E] hover:text-white transition shadow-sm">
            Lihat Detail
        </a>

        {{-- TOMBOL INVOICE (Hanya muncul jika sudah dikonfirmasi atau selesai) --}}
        @if(in_array($p->status, ['dikonfirmasi', 'selesai']))
            <a href="{{ route('user.pemesanan.invoice', $p->id) }}" 
               target="_blank"
               class="inline-flex justify-center rounded-full bg-[#D4AF37] text-[#5D001E] px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-[#C8A84B] transition shadow-sm">
                Lihat Invoice
            </a>
        @endif
    </div>
</div>
        @empty
            <div class="text-center py-16 rounded-2xl border-2 border-dashed border-gray-200 bg-white p-6">
                <p class="text-gray-500 font-medium text-sm">Belum ada riwayat transaksi pemesanan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection