@extends('user.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 my-10 animate-fade-in px-4 sm:px-0">
    
    {{-- Header Judul --}}
    <div class="border-b border-gray-100 pb-4">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600">AKUN</p>
        <h2 class="text-3xl font-bold text-red-800">Profil Saya</h2>
    </div>

    {{-- Card Utama --}}
    <div class="rounded-3xl bg-white border border-gray-200 p-8 shadow-sm relative overflow-hidden">
        {{-- Aksen Dekoratif Pojok Atas --}}
        <div class="absolute top-0 right-0 h-24 w-24 bg-red-50 rounded-bl-full pointer-events-none"></div>
        
        <div class="flex flex-col items-center sm:flex-row sm:items-start gap-6 border-b border-gray-100 pb-6 mb-6">
            {{-- Avatar Lingkaran Besar --}}
            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-red-800 text-white text-3xl font-bold shadow-sm border-2 border-amber-500/30 select-none">
                {{ mb_substr(auth()->user()->name ?? auth()->user()->nama ?? 'U', 0, 1) }}
            </div>
            
            {{-- Identitas Utama --}}
            <div class="text-center sm:text-left space-y-1">
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ auth()->user()->name ?? auth()->user()->nama ?? 'Nama Pelanggan' }}
                </h3>
                <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-0.5 text-xs font-semibold text-amber-700 border border-amber-200 capitalize">
                    ✨ @if(auth()->user() && method_exists(auth()->user(), 'getRoleNames') && auth()->user()->getRoleNames()->isNotEmpty())
                        {{ auth()->user()->getRoleNames()->first() }}
                    @else
                        Pelanggan SILART
                    @endif
                </span>
            </div>
        </div>

        {{-- Detail Informasi Akun --}}
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Informasi Kontak</h4>
        
        <div class="space-y-4 text-sm">
            {{-- Baris Email --}}
            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center py-3 border-b border-gray-100 gap-1">
                <div class="flex items-center gap-2 text-gray-500">
                    {{-- Ikon SVG Pengganti Lucide-Mail Agar Stabil Tanpa CDN Eksternal --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-800/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Alamat Email</span>
                </div>
                <div class="text-gray-900 font-medium md:text-right w-full sm:w-auto break-all">
                    {{ auth()->user()->email ?? '-' }}
                </div>
            </div>

            {{-- Baris Telepon --}}
            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center py-3 border-b border-gray-100 gap-1">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-800/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.72.55.55 0 00.1.24l1.5 3.5a1 1 0 01-.24 1.1l-1.24 1.24a15.11 15.11 0 005.67 5.67l1.24-1.24a1 1 0 011.1-.24l3.5 1.5a1 1 0 01.72.94V19a2 2 0 01-2 2h-1C9.71 21 3 14.29 3 6V5z" />
                    </svg>
                    <span>Nomor Telepon / WA</span>
                </div>
                <div class="text-gray-900 font-semibold font-mono md:text-right">
                    {{ auth()->user()->no_hp ?? auth()->user()->phone ?? '-' }}
                </div>
            </div>

            {{-- Baris Status Keanggotaan --}}
            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center py-3 gap-1">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-800/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Status Akun</span>
                </div>
                <div class="text-emerald-600 font-medium flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                    Terverifikasi
                </div>
            </div>
        </div>

        {{-- Tombol Aksi di Bagian Bawah --}}
        <div class="mt-8 pt-5 border-t border-gray-100 flex flex-wrap gap-3 justify-end">
            <a href="{{ route('user.dashboard') }}" class="rounded-full border border-gray-200 bg-gray-50 px-5 py-2.5 text-xs text-gray-700 font-semibold transition hover:bg-red-800 hover:text-white hover:border-red-800 shadow-sm">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

</div>
@endsection