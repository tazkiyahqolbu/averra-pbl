@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-gray-200 p-6 md:p-8 shadow-sm max-w-2xl mx-auto text-center my-10 animate-fade-in">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Pilih Jenis Pemesanan</h2>
    <p class="text-gray-500 text-sm mb-8">Silakan pilih layanan yang ingin Anda pesan hari ini.</p>

    <div class="grid sm:grid-cols-2 gap-6">
        {{-- Pilihan 1: Booking Acara --}}
        <a href="{{ route('user.pemesanan.create', ['type' => 'acara']) }}" 
           class="group rounded-2xl border-2 border-gray-200 p-6 hover:border-red-800 hover:shadow-md transition-all duration-300 bg-white text-left flex flex-col justify-between">
            <div>
                {{-- Icon Wrapper --}}
                <div class="w-12 h-12 bg-red-50 text-red-800 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-800 group-hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-1">Booking Acara</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Pesan paket pernikahan, engagement, dokumentasi, atau jasa event coordinator secara instan.</p>
            </div>
            <span class="mt-6 text-sm font-semibold text-red-800 inline-flex items-center gap-1 group-hover:translate-x-1.5 transition-transform duration-300">
                Pilih Jasa & Paket →
            </span>
        </a>

        {{-- Pilihan 2: Sewa Barang --}}
        <a href="{{ route('user.pemesanan.create', ['type' => 'sewa']) }}" 
           class="group rounded-2xl border-2 border-gray-200 p-6 hover:border-red-800 hover:shadow-md transition-all duration-300 bg-white text-left flex flex-col justify-between">
            <div>
                {{-- Icon Wrapper --}}
                <div class="w-12 h-12 bg-red-50 text-red-800 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-800 group-hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-1">Sewa Barang</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Rental alat-alat pesta, tenda, sound system, kursi, atau properti dekorasi secara eceran.</p>
            </div>
            <span class="mt-6 text-sm font-semibold text-red-800 inline-flex items-center gap-1 group-hover:translate-x-1.5 transition-transform duration-300">
                Pilih Barang →
            </span>
        </a>
    </div>
</div>
@endsection