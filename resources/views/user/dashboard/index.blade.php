@extends('user.layouts.app')

@section('content')
    {{-- Header --}}
    <div class="mb-7">
        <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— DASHBOARD —</p>
        <h1 class="mt-1 font-serif text-3xl font-light text-[#4A0F1A]">
            Selamat datang, <em class="not-italic font-medium">{{ $user?->nama ?? 'Tamu' }}</em>
        </h1>
        <div class="mt-3 h-[1px] w-16 bg-gradient-to-r from-[#C8960C] to-transparent"></div>
    </div>

    {{-- Profil singkat --}}
    <div
        class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] px-6 py-5">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 shrink-0 rounded-full overflow-hidden bg-[#4A0F1A] flex items-center justify-center">
                @if ($user?->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
                        class="h-full w-full object-cover">
                @else
                    <span
                        class="text-base font-bold text-[#FAF3E0]">{{ strtoupper(substr($user?->nama ?? 'U', 0, 1)) }}</span>
                @endif
            </div>

            <div>
                <p class="font-serif text-base font-medium text-[#4A0F1A]">{{ $user?->nama ?? '' }}</p>
                <p class="text-sm text-[#4A2E28]/70">{{ $user?->email ?? '' }}</p>
            </div>
        </div>
        <a href="{{ route('user.profile.index') }}"
            class="rounded-full border border-[#4A0F1A]/25 bg-white px-4 py-2 text-xs font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200 w-full sm:w-auto text-center">
            Edit Profil
        </a>
    </div>

    {{-- Statistik pemesanan --}}
    <div class="mb-4 rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
        <div class="mb-4 flex items-center justify-between">
            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Pemesanan Saya</p>
            <a href="{{ route('user.pemesanan.index') }}"
                class="text-xs font-medium text-[#C8960C] hover:text-[#B8983A] transition">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ([['label' => 'Menunggu Konfirmasi', 'count' => $statusCounts['konfirmasi'], 'numColor' => 'text-amber-600', 'bg' => 'bg-amber-50', 'border' => 'border-amber-200'], ['label' => 'Menunggu Pembayaran', 'count' => $statusCounts['pembayaran'], 'numColor' => 'text-blue-600', 'bg' => 'bg-blue-50', 'border' => 'border-blue-200'], ['label' => 'Berlangsung', 'count' => $statusCounts['berlangsung'], 'numColor' => 'text-green-700', 'bg' => 'bg-green-50', 'border' => 'border-green-200'], ['label' => 'Selesai', 'count' => $statusCounts['selesai'], 'numColor' => 'text-[#4A0F1A]', 'bg' => 'bg-[#FAF3E0]', 'border' => 'border-[#E2D4C0]']] as $stat)
                <div class="rounded-xl border {{ $stat['border'] }} {{ $stat['bg'] }} p-4 text-center">
                    <p class="font-serif text-3xl font-light {{ $stat['numColor'] }}">{{ $stat['count'] }}</p>
                    <p class="mt-1.5 text-[9px] font-semibold uppercase tracking-[0.15em] text-[#4A2E28] leading-tight">
                        {{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Pengembalian --}}
    @if ($statusCounts['pengembalian'] > 0)
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4">
            <div class="flex items-center gap-3">
                <i data-lucide="package-open" class="h-5 w-5 text-orange-600 shrink-0"></i>
                <div>
                    <p class="text-sm font-semibold text-orange-800">
                        {{ $statusCounts['pengembalian'] }} barang dalam proses pengembalian
                    </p>
                    <p class="text-xs text-orange-600 mt-0.5">Pastikan barang dikembalikan sebelum batas waktu</p>
                </div>
            </div>
            <a href="{{ route('user.pemesanan.index', ['status' => 'pengembalian']) }}"
                class="shrink-0 rounded-full border border-orange-400 bg-white px-4 py-1.5 text-xs font-semibold text-orange-700 shadow-sm hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-200 w-full sm:w-auto text-center">
                Cek
            </a>
        </div>
    @else
        <div
            class="mb-4 flex items-center gap-3 rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] px-5 py-4">
            <i data-lucide="package-check" class="h-5 w-5 text-green-600 shrink-0"></i>
            <p class="text-sm text-[#4A2E28]">Tidak ada barang yang perlu dikembalikan saat ini.</p>
        </div>
    @endif

    {{-- Shortcut --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('public.katalog.index') }}"
            class="group flex items-center gap-4 rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-5 hover:border-[#C8960C]/60 hover:shadow-md transition">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#4A0F1A] text-[#FAF3E0] group-hover:bg-[#7B1C2E] transition">
                <i data-lucide="calendar-plus" class="h-5 w-5"></i>
            </div>
            <div>
                <p class="font-semibold text-[#4A0F1A]">Pesan Paket Acara</p>
                <p class="text-xs text-[#4A2E28]/70 mt-0.5">Jasa, paket pernikahan & pertunjukan</p>
            </div>
            <i data-lucide="arrow-right"
                class="h-4 w-4 text-[#C8960C]/60 ml-auto group-hover:text-[#C8960C] transition"></i>
        </a>
        <a href="{{ route('public.katalog.index') }}"
            class="group flex items-center gap-4 rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-5 hover:border-[#C8960C]/60 hover:shadow-md transition">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#4A0F1A] text-[#FAF3E0] group-hover:bg-[#7B1C2E] transition">
                <i data-lucide="shirt" class="h-5 w-5"></i>
            </div>
            <div>
                <p class="font-semibold text-[#4A0F1A]">Sewa Barang</p>
                <p class="text-xs text-[#4A2E28]/70 mt-0.5">Kostum, properti & alat musik</p>
            </div>
            <i data-lucide="arrow-right"
                class="h-4 w-4 text-[#C8960C]/60 ml-auto group-hover:text-[#C8960C] transition"></i>
        </a>
    </div>
@endsection
