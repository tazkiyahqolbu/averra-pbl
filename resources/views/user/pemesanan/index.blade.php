@extends('user.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 my-10 animate-fade-in px-4 sm:px-0">
    
    {{-- Header Atas --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600">RIWAYAT</p>
            <h2 class="text-3xl font-bold text-red-800">Daftar Pemesanan</h2>
        </div>
        <div>
            <a href="{{ route('user.pemesanan.pilihjenis') }}" class="inline-flex items-center rounded-full bg-red-800 text-white px-5 py-2.5 text-xs font-semibold hover:bg-red-900 transition shadow-sm border border-amber-500/20">
                + Buat Pemesanan Baru
            </a>
        </div>
    </div>

    {{-- Daftar Kartu Pemesanan Dinamis --}}
    <div class="grid gap-4">
        @forelse ($pemesanans as $p)
            <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4 transition hover:border-red-800/20">
                
                {{-- Info Utama Pemesanan --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-gray-900 text-lg tracking-wide">{{ $p->kode_pemesanan }}</span>
                        
                        {{-- Badge Status Order --}}
                        @if($p->status === 'menunggu')
                            <span class="rounded-full bg-amber-50 border border-amber-200 px-2.5 py-0.5 text-xs font-medium text-amber-700">Menunggu</span>
                        @elseif($p->status === 'dikonfirmasi')
                            <span class="rounded-full bg-blue-50 border border-blue-200 px-2.5 py-0.5 text-xs font-medium text-blue-700">Dikonfirmasi</span>
                        @elseif($p->status === 'berlangsung')
                            <span class="rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Berlangsung</span>
                        @elseif($p->status === 'selesai')
                            <span class="rounded-full bg-gray-50 border border-gray-200 px-2.5 py-0.5 text-xs font-medium text-gray-600">Selesai</span>
                        @else
                            <span class="rounded-full bg-rose-50 border border-rose-200 px-2.5 py-0.5 text-xs font-medium text-rose-700">Dibatalkan</span>
                        @endif
                    </div>

                    {{-- Detail Meta Data --}}
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 font-medium">
                        {{-- Menggunakan format tanggal bawaan Carbon atau DB string --}}
                        <div>Tanggal Sesi: <span class="text-gray-700">{{ is_string($p->tanggal_pakai) ? $p->tanggal_pakai : $p->tanggal_pakai->format('d M Y') }}</span></div>
                        <div>Kategori: <span class="text-gray-700 uppercase font-semibold text-[10px] bg-gray-100 px-2 py-0.5 rounded">{{ $p->kategori_order }}</span></div>
                    </div>
                </div>

                {{-- Sisi Kanan: Nominal & Tombol Aksi --}}
                <div class="flex items-center justify-between md:justify-end gap-6 border-t md:border-t-0 pt-4 md:pt-0">
                    <div class="text-left md:text-right">
                        <span class="block text-[10px] uppercase tracking-wider text-gray-400 font-bold">Total Pembayaran</span>
                        <span class="text-lg font-extrabold text-red-800">Rp{{ number_format($p->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <a href="{{ route('user.pemesanan.show', $p->id) }}" class="inline-flex rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-red-800 hover:text-white hover:border-red-800 transition shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            {{-- Kondisi jika tabel pemesanan di database masih kosong --}}
            <div class="text-center py-16 rounded-2xl border-2 border-dashed border-gray-200 bg-white p-6">
                <div class="text-gray-300 mb-3 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium text-sm">Belum ada riwayat transaksi pemesanan ditemukan.</p>
                <p class="text-gray-400 text-xs mt-1">Seluruh data orderan paket acara atau sewa properti kamu akan muncul di sini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection