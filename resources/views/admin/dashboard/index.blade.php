@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
{{-- ═══════════════════════════════════════
         📊 TAB: RINGKASAN
         ═══════════════════════════════════════ --}}
    <div class="space-y-6">

        {{-- Stats Grid --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 animate-scale-in">
            <div class="rounded-3xl bg-[#fffdf7] border border-[#decba5] p-6 shadow-sm">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-[#7b0620]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <p class="mt-4 text-3xl font-['Playfair_Display'] font-bold text-gray-900">{{ $thisMonthBookingsCount }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Booking Bulan Ini</p>
            </div>

            <div class="rounded-3xl bg-[#fffdf7] border border-[#decba5] p-6 shadow-sm">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </div>
                <p class="mt-4 text-3xl font-['Playfair_Display'] font-bold text-amber-700">{{ $pendingBookingsCount }}</p>
                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mt-1">Pending</p>
            </div>

            <div class="rounded-3xl bg-[#fffdf7] border border-[#decba5] p-6 shadow-sm">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <p class="mt-4 text-3xl font-['Playfair_Display'] font-bold text-emerald-700">{{ $confirmedBookingsCount }}</p>
                <p class="text-xs font-medium text-emerald-600 uppercase tracking-wide mt-1">Confirmed</p>
            </div>

            <div class="rounded-3xl bg-[#fffdf7] border border-[#decba5] p-6 shadow-sm">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
                </div>
                <p class="mt-4 text-3xl font-['Playfair_Display'] font-bold text-gray-900">{{ $totalBookingsCount }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Total Booking</p>
            </div>
        </div>

        {{-- Notifikasi Booking Baru --}}
        <div class="rounded-3xl bg-[#fffdf7] border border-[#decba5] p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="h-5 w-5 text-[#7b0620]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                <h3 class="font-['Playfair_Display'] text-xl font-semibold text-gray-900">Notifikasi Booking Baru</h3>
            </div>

            @php $pendingBookings = $bookings->where('status', 'menunggu'); @endphp

            @if ($pendingBookings->isEmpty())
                <p class="text-sm text-[#7a5d58]">Tidak ada booking menunggu persetujuan.</p>
            @else
                <ul class="divide-y divide-[#decba5]">
                    @foreach ($pendingBookings->take(5) as $b)
                        <li class="py-4 flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $b->user->nama }} <span class="text-[#7a5d58] text-xs font-normal">· {{ $b->kode_pemesanan ?? $b->id }}</span></p>
                                <p class="text-xs text-[#7a5d58] mt-1">{{ $b->jenis }} · {{ $b->tanggal_pakai ?? $b->tanggal_pemesanan }} · {{ $b->lokasi }}</p>
                            </div>
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
