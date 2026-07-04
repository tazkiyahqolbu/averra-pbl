@extends('user.layouts.app')

@section('content')

@php
    $dpVerifikasi = $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->first();
    $isPelunasan  = $dpVerifikasi !== null;
    $sisaBayar    = $isPelunasan
        ? max(0, (float) $pesanan->total_harga - (float) $dpVerifikasi->jumlah_bayar)
        : (float) $pesanan->total_harga;
@endphp

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— DETAIL —</p>
        <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">{{ $pesanan->kode_pemesanan }}</h1>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('user.pemesanan.index') }}"
           class="inline-flex items-center gap-1.5 rounded-full border border-[#4A0F1A]/20 bg-white px-4 py-2 text-xs font-medium text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i> Kembali
        </a>
        @if(!$pesanan->isMenungguKonfirmasi())
            <a href="{{ route('user.pemesanan.invoice', $pesanan->id) }}" target="_blank"
               class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-4 py-2 text-xs font-semibold text-[#FAF3E0] shadow-[0_4px_12px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_16px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                <i data-lucide="file-text" class="h-3.5 w-3.5"></i> Invoice
            </a>
        @endif
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-4 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
        <i data-lucide="check-circle" class="h-4 w-4 shrink-0"></i>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
        <i data-lucide="x-circle" class="h-4 w-4 shrink-0"></i>
        {{ session('error') }}
    </div>
@endif

<div class="space-y-4">

    {{-- ─── STATUS DIBATALKAN ────────────────────────────────────────────────── --}}
    @if($pesanan->status === 'dibatalkan')
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-5">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100 border border-red-200 shrink-0 mt-0.5">
                    <i data-lucide="x-circle" class="h-4 w-4 text-red-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-red-800">Pesanan Ditolak / Dibatalkan</p>
                    <p class="text-xs text-red-600 mt-0.5">Pesanan ini tidak dapat diproses lebih lanjut.</p>
                    @if($pesanan->alasan_penolakan)
                        <div class="mt-3 rounded-xl border border-red-200 bg-white px-4 py-3">
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-red-500 mb-1">Alasan dari Admin</p>
                            <p class="text-sm text-red-700">{{ $pesanan->alasan_penolakan }}</p>
                        </div>
                    @endif
                    <a href="{{ route('public.katalog.index') }}"
                       class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-[#4A0F1A] px-5 py-2 text-xs font-semibold text-[#FAF3E0] hover:bg-[#7B1C2E] transition">
                        <i data-lucide="search" class="h-3 w-3"></i>
                        Lihat Layanan Lain
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── A. MENUNGGU KONFIRMASI ─────────────────────────────────────────── --}}
    @if($pesanan->isMenungguKonfirmasi())
        {{-- Status Banner --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="clock" class="h-5 w-5 text-amber-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-amber-800">Menunggu Konfirmasi Admin</p>
                <p class="text-xs text-amber-600 mt-0.5">Pesanan Anda sedang ditinjau. Kami akan mengabari dalam 1×24 jam.</p>
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
            <h3 class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C] mb-4">Ringkasan Pesanan</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Jenis</p>
                    <p class="font-semibold text-[#4A0F1A]">{{ $pesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Tanggal</p>
                    <p class="font-semibold text-[#4A0F1A]">{{ $pesanan->tanggal_pakai?->format('d M Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Total</p>
                    <p class="font-serif font-semibold text-[#C8960C]">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @endif

{{-- ─── B. MENUNGGU PEMBAYARAN (dikonfirmasi) ──────────────────────────── --}}
@if($pesanan->isMenungguPembayaran())
    <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 flex items-center gap-3">
        <i data-lucide="credit-card" class="h-5 w-5 text-blue-600 shrink-0"></i>
        <div>
            <p class="text-sm font-semibold text-blue-800">Pesanan Dikonfirmasi — Lanjutkan Pembayaran</p>
            <p class="text-xs text-blue-600 mt-0.5">Silakan pilih metode pembayaran untuk melanjutkan</p>
        </div>
    </div>

    <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Total Pesanan</p>
                <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">DP 50%</p>
                <p class="font-serif font-semibold text-[#4A0F1A] text-lg">Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }}</p>
            </div>
        </div>

        @if(session('info'))
            <div class="flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-800">
                <i data-lucide="info" class="h-4 w-4 shrink-0"></i>
                {{ session('info') }}
            </div>
        @endif

        <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
           class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
            <i data-lucide="credit-card" class="w-4 h-4"></i>
            Bayar Sekarang
        </a>
    </div>
@endif

    {{-- ─── C. BERLANGSUNG / SIKLUS SEWA ───────────────────────────────────── --}}
    {{-- Catatan: status menunggu_dp / menunggu_pelunasan tidak pernah sampai sini,
         karena PemesananController@show sudah redirect ke halaman invoice untuk status itu. --}}
    @if(in_array($pesanan->status, ['berlangsung', 'menunggu_diambil', 'sedang_disewa', 'menunggu_pengembalian']))
        @php
            $dpVerif         = $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->first();
            $pelunasanRecord = $pesanan->pembayarans->where('tahap', 'pelunasan')->sortBy('id')->last();
            $sisaBayar       = (float) $pesanan->total_harga - (float) ($dpVerif?->jumlah_bayar ?? 0);

            $detail          = $pesanan->detailPemesanans->first();
            $namaItem        = $detail?->barang?->nama_barang
                            ?? $detail?->jasa?->nama_jasa
                            ?? $detail?->paket?->nama_paket
                            ?? '-';
            $tanggalAmbil    = $detail?->tanggal_ambil;
            $tanggalKembali  = $detail?->tanggal_kembali;
            $isSewa          = $pesanan->jenis === 'sewa_barang';
            $sudahDiambil    = in_array($pesanan->status, ['sedang_disewa', 'menunggu_pengembalian']);

            $today           = \Carbon\Carbon::today();
            $hariSisa        = $isSewa && $tanggalKembali ? $today->diffInDays($tanggalKembali, false) : null;
            $terlambat       = $isSewa && $tanggalKembali && $today->gt($tanggalKembali);

            $progressPct = 0;
            if ($isSewa && $tanggalAmbil && $tanggalKembali) {
                $totalHari   = max(1, $tanggalAmbil->diffInDays($tanggalKembali) + 1);
                $hariJalan   = min($totalHari, max(0, $tanggalAmbil->diffInDays($today) + 1));
                $progressPct = round($hariJalan / $totalHari * 100);
            }

            // Bayar Pelunasan hanya diizinkan controller saat status berlangsung (acara)
            $bisaBayarPelunasan = $pesanan->status === 'berlangsung';

            $bannerMap = [
                'berlangsung'            => ['border-green-200 bg-green-50', 'text-green-600', 'text-green-800', 'text-green-600', 'play-circle', 'Sedang Berlangsung', 'Persiapan acara sedang berlangsung'],
                'menunggu_diambil'       => ['border-blue-200 bg-blue-50', 'text-blue-600', 'text-blue-800', 'text-blue-600', 'package-check', 'Menunggu Pengambilan Barang', 'DP sudah diverifikasi, silakan ambil barang sesuai jadwal.'],
                'sedang_disewa'          => ['border-green-200 bg-green-50', 'text-green-600', 'text-green-800', 'text-green-600', 'play-circle', 'Sedang Disewa', 'Barang sedang dalam masa sewa.'],
                'menunggu_pengembalian'  => ['border-orange-200 bg-orange-50', 'text-orange-600', 'text-orange-800', 'text-orange-600', 'alert-triangle', 'Segera Kembalikan Barang', 'Barang sudah jatuh tempo, mohon segera dikembalikan.'],
            ];
            [$bannerBox, $bannerIcon, $bannerTitle, $bannerDesc, $iconName, $bannerText, $bannerSubtext] = $bannerMap[$pesanan->status];
        @endphp

        {{-- Status Banner --}}
        <div class="rounded-2xl border {{ $bannerBox }} px-5 py-4 flex items-center gap-3">
            <i data-lucide="{{ $iconName }}" class="h-5 w-5 {{ $bannerIcon }} shrink-0"></i>
            <div>
                <p class="text-sm font-semibold {{ $bannerTitle }}">{{ $bannerText }}</p>
                <p class="text-xs {{ $bannerDesc }} mt-0.5">{{ $bannerSubtext }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            {{-- Item info --}}
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">
                    {{ $isSewa ? 'Barang yang Disewa' : 'Paket yang Dipesan' }}
                </p>
                <p class="font-serif font-semibold text-[#4A0F1A] text-lg">{{ $namaItem }}</p>
                @if($detail && $detail->jumlah > 1)
                    <p class="text-sm text-[#4A2E28]/60 mt-0.5">{{ $detail->jumlah }} unit</p>
                @endif
            </div>

            @if($isSewa && !$sudahDiambil && $tanggalAmbil)
                {{-- Jadwal Pengambilan (sebelum barang diambil) --}}
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Jadwal Pengambilan</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalAmbil->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Metode Pengambilan</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">
                                {{ $pesanan->lokasi ? 'Dikirim ke alamat' : 'Ambil sendiri' }}
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($isSewa && $sudahDiambil && $tanggalAmbil && $tanggalKembali)
                {{-- Countdown --}}
                @php
                    $countdownBg = $terlambat
                        ? 'border-red-300 bg-red-50'
                        : ($hariSisa <= 2 ? 'border-orange-200 bg-orange-50' : 'border-[#E2D4C0] bg-[#FAF3E0]');
                @endphp
                <div class="rounded-xl border {{ $countdownBg }} p-5">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Batas Pengembalian</p>
                            <p class="font-serif font-semibold text-[#4A0F1A] text-lg">{{ $tanggalKembali->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            @if($terlambat)
                                <p class="font-serif text-4xl font-light text-red-600">{{ abs((int)$hariSisa) }}</p>
                                <p class="text-xs font-semibold text-red-500">hari terlambat</p>
                            @elseif($hariSisa === 0)
                                <p class="font-serif text-2xl font-light text-orange-600">Hari ini</p>
                                <p class="text-xs font-semibold text-orange-500">batas pengembalian</p>
                            @else
                                <p class="font-serif text-4xl font-light text-[#4A0F1A]">{{ $hariSisa }}</p>
                                <p class="text-xs font-semibold text-[#4A2E28]/50">hari lagi</p>
                            @endif
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div>
                        <div class="flex justify-between text-xs text-[#4A2E28]/50 mb-1.5">
                            <span>{{ $tanggalAmbil->format('d M') }}</span>
                            <span>{{ $tanggalKembali->format('d M') }}</span>
                        </div>
                        <div class="w-full bg-[#E2D4C0] rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-500
                                {{ $terlambat ? 'bg-red-500' : ($hariSisa <= 2 ? 'bg-orange-400' : 'bg-[#4A0F1A]') }}"
                                 style="width: {{ min(100, $progressPct) }}%"></div>
                        </div>
                        <p class="text-[10px] text-[#4A2E28]/60 mt-1 text-right">{{ $progressPct }}% masa sewa berjalan</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4 text-sm">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Ambil</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalAmbil->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Metode Pengambilan</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">
                                {{ $pesanan->lokasi ? 'Dikirim ke alamat' : 'Ambil sendiri' }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($terlambat)
                    <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                        <i data-lucide="alert-triangle" class="h-4 w-4 text-red-500 mt-0.5 shrink-0"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-700">Pengembalian terlambat {{ abs((int)$hariSisa) }} hari</p>
                            <p class="text-xs text-red-600 mt-0.5">Segera kembalikan barang untuk menghindari denda keterlambatan.</p>
                        </div>
                    </div>
                @endif

            @else
                {{-- Acara --}}
                @if($pesanan->tanggal_pakai)
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Acara</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $pesanan->tanggal_pakai->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Lokasi</p>
                            <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $pesanan->lokasi ?? 'Di Sanggar' }}</p>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Pelunasan --}}
            @if($isPelunasan && $bisaBayarPelunasan)
                <div class="border-t border-[#E2D4C0] pt-5 space-y-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Pelunasan Pembayaran</p>
                    <div class="rounded-xl border border-[#C8960C]/30 bg-[#FAF3E0] p-4">
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Sisa Pelunasan</p>
                        <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
                    class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                        Bayar Pelunasan
                    </a>
                </div>
            @elseif($isPelunasan && !$bisaBayarPelunasan)
                <div class="border-t border-[#E2D4C0] pt-4 flex items-center gap-2 text-sm font-semibold text-[#4A2E28]/70">
                    <i data-lucide="info" class="h-4 w-4 text-[#C8960C] shrink-0"></i>
                    DP terverifikasi. Sisa pembayaran akan ditagih setelah barang dikembalikan.
                </div>
            @else
                <div class="border-t border-[#E2D4C0] pt-4 flex items-center gap-2 text-sm font-semibold text-green-700">
                    <i data-lucide="check-circle" class="h-4 w-4"></i>
                    Pembayaran lunas telah terverifikasi
                </div>
            @endif
        </div>
    @endif

    {{-- ─── D. SELESAI & TESTIMONI ─────────────────────────────────────────── --}}
    @if($pesanan->isSelesai())
        {{-- Status Banner --}}
        <div class="rounded-2xl border border-[#D4C4AA] bg-[#E2D4C0] px-5 py-4 flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-[#4A0F1A] shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-[#4A0F1A]">Pesanan Selesai</p>
                <p class="text-xs text-[#4A2E28]/70 mt-0.5">Terima kasih telah menggunakan layanan Sanggar Rantiang Tagok</p>
            </div>
        </div>

        {{-- Testimoni --}}
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 mt-4">
            @if(!$pesanan->testimoni)
                <div class="text-center mb-6">
                    <h3 class="font-serif text-2xl font-light text-[#4A0F1A]">Bagaimana pengalaman Anda?</h3>
                    <p class="text-sm text-[#4A2E28]/60 mt-1">Bantu kami menjadi lebih baik dengan ulasan Anda.</p>
                </div>
                <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                      x-data="{ rating: 0, hoverRating: 0, fileName: '' }">
                    @csrf

                    {{-- Star rating --}}
                    <div class="text-center">
                        <div class="flex justify-center gap-2" x-on:mouseleave="hoverRating = 0">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        x-on:click="rating = {{ $i }}"
                                        x-on:mouseenter="hoverRating = {{ $i }}"
                                        class="text-4xl transition-all duration-200 transform hover:scale-110"
                                        x-bind:class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-[#C8960C] drop-shadow-md' : 'text-[#E2D4C0]'">
                                    ★
                                </button>
                            @endfor
                        </div>
                        <p class="text-xs text-[#4A2E28]/60 mt-2" x-text="rating > 0 ? rating + ' Bintang' : 'Pilih penilaian'"></p>
                        <input type="hidden" name="rating" x-bind:value="rating" required>
                    </div>

                    {{-- Ulasan --}}
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2 font-semibold">Ulasan Anda</label>
                        <textarea name="isi_testimoni" rows="4" required
                                  class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A2E28] focus:border-[#C8960C] focus:ring-1 focus:ring-[#C8960C] focus:outline-none transition-all resize-none"
                                  placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..."></textarea>
                    </div>

                    {{-- Media Upload --}}
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2 font-semibold">Upload Foto/Video (Opsional)</label>
                        <div class="relative group">
                            <label class="flex flex-col items-center justify-center w-full h-32 rounded-xl border-2 border-dashed border-[#E2D4C0] bg-[#FAF3E0]/50 hover:bg-[#FAF3E0] hover:border-[#C8960C] transition-all cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i data-lucide="upload-cloud" class="w-8 h-8 text-[#C8960C] mb-2 group-hover:scale-110 transition-transform"></i>
                                    <p class="text-sm text-[#4A2E28]/70" x-show="!fileName"><span class="font-semibold text-[#4A0F1A]">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-sm text-[#4A0F1A] font-semibold" x-show="fileName" x-text="fileName"></p>
                                    <p class="text-xs text-[#4A2E28]/50 mt-1" x-show="!fileName">PNG, JPG, MP4 (Max. 10MB)</p>
                                </div>
                                <input type="file" name="media" accept="image/*,video/*" class="hidden" x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" />
                            </label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200 flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            @else
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Ulasan Anda</p>
                    <div class="flex gap-1 text-lg text-[#C8960C]">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $pesanan->testimoni->rating ? 'drop-shadow-sm' : 'text-[#E2D4C0]' }}">★</span>
                        @endfor
                    </div>
                </div>
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4 relative">
                    <i data-lucide="quote" class="absolute top-4 right-4 w-6 h-6 text-[#C8960C] opacity-20"></i>
                    <p class="text-sm text-[#4A2E28] italic relative z-10">"{{ $pesanan->testimoni->isi_testimoni }}"</p>
                    @if($pesanan->testimoni->fotos->isNotEmpty())
                        <div class="mt-3 flex gap-2 flex-wrap">
                            @foreach($pesanan->testimoni->fotos as $foto)
                                <img src="{{ Storage::url($foto->foto_path) }}"
                                     alt="foto testimoni"
                                     class="h-20 w-20 rounded-xl object-cover border border-[#E2D4C0]">
                            @endforeach
                        </div>
                    @endif
                    <p class="text-[10px] text-[#4A2E28]/50 mt-3 font-semibold">{{ $pesanan->testimoni->created_at->format('d F Y, H:i') }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- ─── E. PENGEMBALIAN BARANG ─────────────────────────────────────────── --}}
    @if(optional($pesanan->pengembalian)->id)
        @php
            $peng          = $pesanan->pengembalian;
            $batasKembali  = optional($peng)->tanggal_kembali_jadwal;
            $aktualKembali = optional($peng)->tanggal_kembali_aktual;
            $isTepatWaktu  = true;
            if ($batasKembali && $aktualKembali) {
                $isTepatWaktu = \Carbon\Carbon::parse($aktualKembali)->lte(\Carbon\Carbon::parse($batasKembali));
            }
            $dendaAmount = optional($peng)->total_denda;
            $dendaStatus = optional($peng)->status_denda;
        @endphp

        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            <div class="border-b border-[#E2D4C0] pb-4">
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Pengembalian Barang</p>
                <h3 class="font-serif text-xl font-light text-[#4A0F1A] mt-0.5">Status Pengembalian</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Batas Kembali</p>
                    <p class="font-semibold text-[#4A0F1A] mt-0.5">
                        {{ $batasKembali ? \Carbon\Carbon::parse($batasKembali)->format('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Dikembalikan</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <p class="font-semibold text-[#4A0F1A]">
                            {{ $aktualKembali ? \Carbon\Carbon::parse($aktualKembali)->format('d F Y') : '-' }}
                        </p>
                        @if($aktualKembali)
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                {{ $isTepatWaktu ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                {{ $isTepatWaktu ? 'Tepat Waktu' : 'Terlambat' }}
                            </span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Kondisi</p>
                    <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $peng->kondisi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Status Pemeriksaan</p>
                    <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ ucfirst($peng->status_pengembalian ?? 'Sedang diperiksa') }}</p>
                </div>
            </div>

            @if($peng->catatan_kerusakan)
                <div class="flex items-start gap-3 rounded-xl border border-orange-200 bg-orange-50 p-4 text-sm">
                    <i data-lucide="alert-circle" class="h-4 w-4 text-orange-500 mt-0.5 shrink-0"></i>
                    <div>
                        <p class="font-semibold text-orange-700">Catatan Kerusakan</p>
                        <p class="text-orange-600 mt-0.5">{{ $peng->catatan_kerusakan }}</p>
                    </div>
                </div>
            @endif

            @if($dendaAmount > 0)
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-5 space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Denda Kerusakan</p>
                            <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($dendaAmount, 0, ',', '.') }}</p>
                        </div>
                        <i data-lucide="alert-triangle" class="h-5 w-5 text-orange-500"></i>
                    </div>
                    <div class="rounded-xl border border-[#C8960C]/30 bg-white p-4">
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Transfer ke</p>
                        <p class="font-serif font-semibold text-[#4A0F1A]">Bank BCA — 1234567890</p>
                        <p class="text-xs text-[#4A2E28]/50">a.n AVERRA EVENT</p>
                    </div>

                    @if($dendaStatus === 'lunas')
                        <div class="flex items-center gap-2 text-sm font-semibold text-green-700">
                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                            Denda sudah dibayar
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-sm font-semibold text-orange-700">
                            <i data-lucide="info" class="h-4 w-4 shrink-0"></i>
                            Denda ini akan otomatis disertakan pada saat pelunasan lewat halaman pembayaran.
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif


    {{-- ─── AJUKAN PEMBATALAN ───────────────────────────────────────────────── --}}
    @php
        $bisaBatal = in_array($pesanan->status, ['menunggu', 'dikonfirmasi', 'menunggu_dp', 'berlangsung', 'menunggu_diambil', 'sedang_disewa']);
        $sudahAjukan = $pesanan->pembatalan && $pesanan->pembatalan->status === 'menunggu';
    @endphp
    @if($bisaBatal)
        <div class="rounded-2xl border border-red-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-red-700 mb-1">Batalkan Pesanan</h3>
            @if($sudahAjukan)
                <p class="text-sm text-[#4A2E28]/70">Permintaan pembatalan sudah diajukan dan sedang ditinjau oleh admin.</p>
            @else
                <p class="text-xs text-[#4A2E28]/60 mb-4">
                    DP yang sudah dibayar <strong>tidak dikembalikan</strong> jika pembatalan disetujui.
                </p>
                <form action="{{ route('user.pembatalan.ajukan', $pesanan->id) }}" method="POST" class="space-y-3"
                      x-data="{ open: false }">
                    @csrf
                    <button type="button" @click="open = !open"
                            class="text-sm font-medium text-red-600 hover:text-red-800 underline underline-offset-2 transition">
                        <span x-text="open ? 'Tutup Form' : 'Ajukan Pembatalan'"></span>
                    </button>
                    <div x-show="open" x-transition class="space-y-3 pt-1">
                        <div>
                            <label class="block text-xs font-semibold text-[#4A2E28] mb-1">Alasan Pembatalan <span class="text-red-500">*</span></label>
                            <textarea name="alasan" rows="3" minlength="10" required
                                      placeholder="Ceritakan alasan pembatalan (min. 10 karakter)..."
                                      class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-2.5 text-sm text-[#4A2E28] placeholder-[#4A2E28]/40 focus:border-red-300 focus:outline-none resize-none"></textarea>
                        </div>
                        <button type="submit"
                                class="w-full rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                            Kirim Permintaan Pembatalan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @endif

</div>
@endsection
