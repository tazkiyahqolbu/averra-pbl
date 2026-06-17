@extends('user.layouts.app')

@section('content')
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-lg font-bold text-gray-900">Pemesanan</h1>
            </div>

           <a href="{{ route('public.katalog.index') }}" 
                class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 bg-[#3d0a13] text-white shadow-md hover:bg-[#2a070d]">
                + Buat Pemesanan Baru
            </a>

        </div>

        <div class="overflow-x-auto">
            <div class="flex items-center gap-3 whitespace-nowrap">
                @php
                    $tabs = [
                        'Semua' => 'semua',
                        'Menunggu Konfirmasi' => 'menunggu',
                        'Menunggu Pembayaran' => 'dikonfirmasi',
                        'Berlangsung' => 'berlangsung',
                        'Pengembalian' => 'pengembalian',
                        'Selesai' => 'selesai',
                        'Dibatalkan' => 'dibatalkan'
                    ];
                @endphp

                @foreach($tabs as $label => $slug)
                    <a href="{{ route('user.pemesanan.index', ['status' => $slug]) }}"
                       class="shrink-0 px-2.5 py-2 text-sm font-semibold transition-colors duration-150
                       {{ request('status', 'semua') == $slug
                            ? 'text-[#5D001E] border-b-2 border-[#5D001E]'
                            : 'text-gray-600 border-b-2 border-transparent hover:text-red-800 hover:border-red-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Placeholder daftar pesanan agar halaman tidak terlihat kosong saat klik tab --}}
        @if(isset($pesanans) && $pesanans->count())
            <div class="mt-1 space-y-3">
                @foreach($pesanans as $p)
                    <a href="{{ route('user.pemesanan.show', $p->id) }}"
                       class="block p-4 rounded-2xl bg-white border border-gray-200 hover:border-red-800">
                        <div class="font-semibold">{{ $p->kode_pemesanan ?? ('#' . $p->id) }}</div>
                        <div class="text-sm text-gray-600">{{ $p->status }}</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

