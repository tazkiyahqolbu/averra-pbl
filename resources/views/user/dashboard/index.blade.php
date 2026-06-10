@extends('user.layouts.app')

@section('content')
<div class="space-y-8 animate-scale-in">

    {{-- 1. HEADER UTAMA: Title & Identitas Akun Login Dinamis (Marun Jauh Lebih Pekat) --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-maroon-deep/10 pb-5">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold">USER</p>
            <h2 class="font-serif text-3xl font-bold text-maroon-deep">Dashboard Pelanggan</h2>
        </div>

        <div class="flex items-center gap-3.5 sm:text-right sm:justify-end">
            <div class="text-left sm:text-right text-xs text-maroon-deep/60 font-light leading-relaxed order-2 sm:order-1">
                <span class="font-semibold text-maroon-deep text-base block">{{ auth()->user()->nama ?? auth()->user()->name }}</span>
                <span class="text-maroon-deep/70 text-xs block mt-0.5">{{ auth()->user()->no_hp ?? 'Pelanggan SILART' }}</span>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-maroon-deep text-cream font-serif text-lg font-bold shadow-sm border border-gold/20 order-1 sm:order-2">
                {{ mb_substr(auth()->user()->nama ?? auth()->user()->name ?? 'U', 0, 1) }}
            </div>
        </div>
    </div>

    {{-- 2. GRID STATISTIK / RINGKASAN --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm flex flex-col justify-between min-h-[140px] transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-maroon-deep/60">Pemesanan Bulan Ini</p>
                <div class="h-8 w-8 rounded-xl bg-maroon-deep/5 text-maroon-deep flex items-center justify-center">
                    <i data-lucide="calendar" class="h-4 w-4"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-maroon-deep tracking-tight">{{ $pemesanan->whereBetween('tanggal_pemesanan',[now()->startOfMonth(), now()->endOfMonth()])->count() }}</p>
        </div>

        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm flex flex-col justify-between min-h-[140px] transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-gold">Menunggu Konfirmasi</p>
                <div class="h-8 w-8 rounded-xl bg-gold/10 text-gold flex items-center justify-center">
                    <i data-lucide="bell" class="h-4 w-4"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-maroon-deep tracking-tight">{{ $pemesanan->where('status','Menunggu')->count() }}</p>
        </div>

        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm flex flex-col justify-between min-h-[140px] transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Dikonfirmasi</p>
                <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="h-4 w-4"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-maroon-deep tracking-tight">{{ $pemesanan->where('status','Dikonfirmasi')->count() }}</p>
        </div>

        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm flex flex-col justify-between min-h-[140px] transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-maroon-deep/60">Total Pemesanan</p>
                <div class="h-8 w-8 rounded-xl bg-maroon-deep/5 text-maroon-deep flex items-center justify-center">
                    <i data-lucide="clipboard-list" class="h-4 w-4"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-maroon-deep tracking-tight">{{ $pemesanan->count() }}</p>
        </div>
    </div>

    {{-- 3. GRID UTAMA (Aksi Cepat & Tabel Pemesanan Terbaru) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm space-y-4">
            <h3 class="font-serif text-xl font-semibold text-maroon-deep border-b border-neutral-100 pb-3">Aksi Cepat</h3>
            <div class="flex flex-col gap-2.5">
                <a href="{{ route('user.pemesanan') }}" class="w-full inline-flex items-center gap-2 rounded-full border border-maroon-deep/10 bg-cream/20 px-5 py-3 text-sm text-maroon-deep font-medium transition hover:bg-cream hover:border-maroon-deep/30">
                    <i data-lucide="eye" class="h-4 w-4 text-gold"></i> Lihat Pemesanan
                </a>
                <a href="{{ route('user.pembayaran.upload') }}" class="w-full inline-flex items-center gap-2 rounded-full bg-maroon-deep px-5 py-3 text-sm text-cream font-medium transition hover:bg-black shadow-sm">
                    <i data-lucide="upload-cloud" class="h-4 w-4 text-gold-soft"></i> Upload Pembayaran
                </a>
                <a href="{{ route('user.profile') }}" class="w-full inline-flex items-center gap-2 rounded-full border border-maroon-deep/10 bg-cream/20 px-5 py-3 text-sm text-maroon-deep font-medium transition hover:bg-cream hover:border-maroon-deep/30">
                    <i data-lucide="user" class="h-4 w-4 text-gold"></i> Profil Saya
                </a>
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-maroon-deep/5 p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between border-b border-neutral-100 pb-3 mb-4">
                <h3 class="font-serif text-xl font-semibold text-maroon-deep">Pemesanan Terbaru</h3>
                <a href="{{ route('user.pemesanan') }}" class="text-xs font-semibold text-gold hover:underline transition">Lihat semua</a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-neutral-100">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-cream/30 text-maroon-deep font-medium border-b border-neutral-100">
                        <tr>
                            <th class="px-5 py-3.5">Kode</th>
                            <th class="px-5 py-3.5">Tanggal Pakai</th>
                            <th class="px-5 py-3.5">Jenis Layanan</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-50 text-maroon-deep/90">
                        @forelse($pemesanan->take(5) as $p)
                        <tr class="hover:bg-cream/10 transition-colors">
                            <td class="px-5 py-3.5 font-semibold text-maroon-deep">{{ $p->kode_pemesanan ?? $p->id }}</td>
                            <td class="px-5 py-3.5 font-light text-neutral-600">{{ $p->tanggal_pakai ?? '-' }}</td>
                            <td class="px-5 py-3.5 font-medium">{{ $p->jenis }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex rounded-full bg-[#FEF9E7] border border-gold/10 px-3 py-1 text-xs font-medium text-gold">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-maroon-deep/50 font-light">Belum ada data pemesanan terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
