@extends('user.layouts.app')

@section('content')

@php
    $dpVerifikasi = $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->first();
    $isPelunasan  = $dpVerifikasi !== null;
    $sisaBayar    = $isPelunasan
        ? max(0, (float) $pesanan->total_harga - (float) $dpVerifikasi->jumlah_bayar)
        : (float) $pesanan->total_harga;

    $detail        = $pesanan->detailPemesanans->first();
    $namaItem      = $detail?->barang?->nama_barang ?? $detail?->jasa?->nama_jasa ?? $detail?->paket?->nama_paket ?? '-';
    $isSewa        = $pesanan->jenis === 'sewa_barang';
    $tanggalAmbil  = $detail?->tanggal_ambil;
    $tanggalKembali = $detail?->tanggal_kembali;

    $today     = \Carbon\Carbon::today();
    $hariSisa  = $isSewa && $tanggalKembali ? $today->diffInDays($tanggalKembali, false) : null;
    $terlambat = $isSewa && $tanggalKembali && $today->gt($tanggalKembali);

    $progressPct = 0;
    if ($isSewa && $tanggalAmbil && $tanggalKembali) {
        $totalHari   = max(1, $tanggalAmbil->diffInDays($tanggalKembali) + 1);
        $hariJalan   = min($totalHari, max(0, $tanggalAmbil->diffInDays($today) + 1));
        $progressPct = round($hariJalan / $totalHari * 100);
    }

    // Status untuk tombol pembatalan
    $canCancel = in_array($pesanan->status, ['dikonfirmasi', 'menunggu_dp', 'berlangsung', 'menunggu_diambil', 'sedang_disewa']);
    $pembatalan = $pesanan->pembatalan;
    $hasPendingBatalan = $pembatalan && $pembatalan->status === 'menunggu';
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
@if(session('info'))
    <div class="mb-4 flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-800">
        <i data-lucide="info" class="h-4 w-4 shrink-0"></i>
        {{ session('info') }}
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
                    <p class="text-sm font-semibold text-red-800">Pesanan Dibatalkan</p>
                    <p class="text-xs text-red-600 mt-0.5">Pesanan ini tidak dapat diproses lebih lanjut.</p>
                    @if($pesanan->alasan_penolakan)
                        <div class="mt-3 rounded-xl border border-red-200 bg-white px-4 py-3">
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-red-500 mb-1">Keterangan</p>
                            <p class="text-sm text-red-700">{{ $pesanan->alasan_penolakan }}</p>
                        </div>
                    @endif
                    {{-- Info refund jika ada --}}
                    @if($pembatalan && $pembatalan->status === 'disetujui')
                        <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-amber-600 mb-1">Status Refund</p>
                            @if($pembatalan->bukti_transfer_path)
                                <p class="text-sm text-amber-800 font-semibold">Dana telah dikembalikan</p>
                                <p class="text-xs text-amber-600 mt-0.5">Rp {{ number_format($pembatalan->jumlah_refund, 0, ',', '.') }} ke {{ $pembatalan->nama_bank }} – {{ $pembatalan->nomor_rekening }}</p>
                            @else
                                <p class="text-sm text-amber-800">Refund Rp {{ number_format($pembatalan->jumlah_refund, 0, ',', '.') }} sedang diproses</p>
                                <p class="text-xs text-amber-600 mt-0.5">Akan ditransfer ke {{ $pembatalan->nama_bank }} – {{ $pembatalan->nomor_rekening }} a/n {{ $pembatalan->nama_rekening }}</p>
                            @endif
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
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="clock" class="h-5 w-5 text-amber-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-amber-800">Menunggu Konfirmasi Admin</p>
                <p class="text-xs text-amber-600 mt-0.5">Pesanan Anda sedang ditinjau. Kami akan mengabari dalam 1×24 jam.</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
            <h3 class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C] mb-4">Ringkasan Pesanan</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Jenis</p>
                    <p class="font-semibold text-[#4A0F1A]">{{ $isSewa ? 'Sewa Barang' : 'Paket Acara' }}</p>
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

    {{-- ─── B. MENUNGGU PEMBAYARAN DP (acara: dikonfirmasi) ─────────────────── --}}
    @if($pesanan->isMenungguPembayaran())
        <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="credit-card" class="h-5 w-5 text-blue-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-blue-800">Pesanan Dikonfirmasi — Bayar DP untuk Melanjutkan</p>
                <p class="text-xs text-blue-600 mt-0.5">Lakukan pembayaran uang muka (DP) 50% untuk mengaktifkan pesanan</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Total Pesanan</p>
                    <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">DP yang Harus Dibayar (50%)</p>
                    <p class="font-serif font-semibold text-[#4A0F1A] text-lg">Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }}</p>
                </div>
            </div>
            <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
               class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar DP Sekarang
            </a>
        </div>
    @endif

    {{-- ─── B2. MENUNGGU DP (sewa: menunggu_dp) ───────────────────────────── --}}
    @if($pesanan->isMenungguDp())
        <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="credit-card" class="h-5 w-5 text-blue-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-blue-800">Pesanan Dikonfirmasi — Bayar DP untuk Melanjutkan</p>
                <p class="text-xs text-blue-600 mt-0.5">Bayar DP 50% untuk mengkonfirmasi jadwal sewa barang</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Total Sewa</p>
                    <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">DP yang Harus Dibayar (50%)</p>
                    <p class="font-serif font-semibold text-[#4A0F1A] text-lg">Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }}</p>
                </div>
            </div>
            @if($tanggalAmbil && $tanggalKembali)
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Ambil</p>
                        <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalAmbil->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Kembali</p>
                        <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalKembali->format('d M Y') }}</p>
                    </div>
                </div>
            @endif
            <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
               class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar DP Sekarang
            </a>
        </div>
    @endif

    {{-- ─── C. BERLANGSUNG (acara) ─────────────────────────────────────────── --}}
    @if($pesanan->isBerlangsung())
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="play-circle" class="h-5 w-5 text-green-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-green-800">Acara Sedang Berlangsung</p>
                <p class="text-xs text-green-600 mt-0.5">Pelunasan 50% akan ditagihkan setelah acara selesai</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-4">
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
            <div class="rounded-xl border border-[#C8960C]/30 bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Sisa Pelunasan (setelah acara)</p>
                <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                <p class="text-xs text-[#4A2E28]/50 mt-1">Tagihan akan dikirim via email setelah acara selesai</p>
            </div>
        </div>
    @endif

    {{-- ─── C2. MENUNGGU DIAMBIL (sewa) ───────────────────────────────────── --}}
    @if($pesanan->isMenungguDiambil())
        <div class="rounded-2xl border border-indigo-200 bg-indigo-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="package" class="h-5 w-5 text-indigo-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-indigo-800">DP Lunas — Menunggu Pengambilan Barang</p>
                <p class="text-xs text-indigo-600 mt-0.5">Silakan ambil barang di sanggar sesuai jadwal</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-4">
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Barang</p>
                <p class="font-serif font-semibold text-[#4A0F1A] text-lg">{{ $namaItem }}</p>
            </div>
            @if($tanggalAmbil)
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Ambil</p>
                        <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalAmbil->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Tanggal Kembali</p>
                        <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $tanggalKembali?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            @endif
            <div class="flex items-start gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm">
                <i data-lucide="info" class="h-4 w-4 text-blue-500 mt-0.5 shrink-0"></i>
                <p class="text-blue-700">Admin akan memperbarui status otomatis setelah barang diambil. Harap tunjukkan kode pesanan Anda saat pengambilan.</p>
            </div>
        </div>
    @endif

    {{-- ─── C3. SEDANG DISEWA ──────────────────────────────────────────────── --}}
    @if($pesanan->isSedangDisewa())
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="play-circle" class="h-5 w-5 text-green-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-green-800">Barang Sedang Disewa</p>
                <p class="text-xs text-green-600 mt-0.5">Kembalikan barang sebelum atau tepat pada tanggal batas kembali</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Barang yang Disewa</p>
                <p class="font-serif font-semibold text-[#4A0F1A] text-lg">{{ $namaItem }}</p>
                @if($detail && $detail->jumlah > 1)
                    <p class="text-sm text-[#4A2E28]/60 mt-0.5">{{ $detail->jumlah }} unit</p>
                @endif
            </div>

            @if($tanggalAmbil && $tanggalKembali)
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
            @endif
        </div>
    @endif

    {{-- ─── C4. MENUNGGU PENGEMBALIAN (sewa) ──────────────────────────────── --}}
    @if($pesanan->isMenungguPengembalian())
        <div class="rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="alert-triangle" class="h-5 w-5 text-orange-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-orange-800">Segera Kembalikan Barang!</p>
                <p class="text-xs text-orange-600 mt-0.5">Masa sewa telah berakhir. Harap kembalikan barang sesegera mungkin.</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-4">
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Barang yang Disewa</p>
                <p class="font-serif font-semibold text-[#4A0F1A] text-lg">{{ $namaItem }}</p>
            </div>
            @if($tanggalKembali)
                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="text-[10px] uppercase tracking-wider text-red-500 mb-1">Batas Kembali</p>
                    <p class="font-serif font-semibold text-red-700 text-lg">{{ $tanggalKembali->format('d F Y') }}</p>
                    @if($terlambat)
                        <p class="text-xs text-red-600 mt-1">Terlambat {{ abs((int)$hariSisa) }} hari — denda akan dihitung saat pengembalian</p>
                    @endif
                </div>
            @endif
            <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm">
                <i data-lucide="info" class="h-4 w-4 text-amber-500 mt-0.5 shrink-0"></i>
                <p class="text-amber-700">Setelah barang dikembalikan, admin akan mencatat kondisi barang dan mengirimkan tagihan pelunasan via email.</p>
            </div>
        </div>
    @endif

    {{-- ─── C5. MENUNGGU PELUNASAN (acara & sewa) ──────────────────────────── --}}
    @if($pesanan->isMenungguPelunasan())
        @php
            $sudahBayar  = (float) $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
            $sisaPelunasan = max(0, (float) $pesanan->total_harga - $sudahBayar);

            // Tambah denda jika sewa
            $totalDendaPelunasan = 0;
            if ($isSewa) {
                $pengbl = $pesanan->pengembalian;
                $totalDendaPelunasan = $pengbl ? (float) $pengbl->total_denda : 0;
            }
            $grandTotal = $sisaPelunasan + $totalDendaPelunasan;
        @endphp
        <div class="rounded-2xl border border-[#C8960C]/40 bg-[#FFF8E7] px-5 py-4 flex items-center gap-3">
            <i data-lucide="clock" class="h-5 w-5 text-[#C8960C] shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-[#4A0F1A]">{{ $isSewa ? 'Barang Telah Kembali' : 'Acara Telah Selesai' }} — Lunasi Pembayaran</p>
                <p class="text-xs text-[#4A2E28]/60 mt-0.5">Selesaikan pembayaran untuk menyelesaikan pesanan Anda</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-4">
            <div class="rounded-xl border border-[#C8960C]/30 bg-[#FAF3E0] p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Sisa Pembayaran</p>
                        <p class="font-serif font-bold text-[#C8960C] text-2xl">Rp {{ number_format($sisaPelunasan, 0, ',', '.') }}</p>
                    </div>
                    @if($totalDendaPelunasan > 0)
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">+ Denda</p>
                            <p class="font-serif font-semibold text-red-600 text-lg">Rp {{ number_format($totalDendaPelunasan, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
                @if($totalDendaPelunasan > 0)
                    <div class="border-t border-[#C8960C]/20 mt-3 pt-3">
                        <div class="flex justify-between">
                            <p class="text-sm font-semibold text-[#4A0F1A]">Total yang Harus Dibayar</p>
                            <p class="font-serif font-bold text-[#4A0F1A] text-lg">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
               class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Bayar Pelunasan Sekarang
            </a>
        </div>
    @endif

    {{-- ─── D. SELESAI & TESTIMONI ─────────────────────────────────────────── --}}
    @if($pesanan->isSelesai())
        <div class="rounded-2xl border border-[#D4C4AA] bg-[#E2D4C0] px-5 py-4 flex items-center gap-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-[#4A0F1A] shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-[#4A0F1A]">Pesanan Selesai</p>
                <p class="text-xs text-[#4A2E28]/70 mt-0.5">Terima kasih telah menggunakan layanan Sanggar Rantiang Tagok</p>
            </div>
        </div>
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 mt-4">
            @if(!$pesanan->testimoni)
                <div class="text-center mb-6">
                    <h3 class="font-serif text-2xl font-light text-[#4A0F1A]">Bagaimana pengalaman Anda?</h3>
                    <p class="text-sm text-[#4A2E28]/60 mt-1">Bantu kami menjadi lebih baik dengan ulasan Anda.</p>
                </div>
                <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                      x-data="{ rating: 0, hoverRating: 0, fileName: '' }">
                    @csrf
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
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2 font-semibold">Ulasan Anda</label>
                        <textarea name="isi_testimoni" rows="4" required
                                  class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A2E28] focus:border-[#C8960C] focus:ring-1 focus:ring-[#C8960C] focus:outline-none transition-all resize-none"
                                  placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..."></textarea>
                    </div>
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
                    <p class="font-semibold text-[#4A0F1A] mt-0.5">{{ $batasKembali ? \Carbon\Carbon::parse($batasKembali)->format('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Dikembalikan</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <p class="font-semibold text-[#4A0F1A]">{{ $aktualKembali ? \Carbon\Carbon::parse($aktualKembali)->format('d F Y') : '-' }}</p>
                        @if($aktualKembali)
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $isTepatWaktu ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
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
        </div>
    @endif

    {{-- ─── F. STATUS PEMBATALAN ────────────────────────────────────────────── --}}
    @if($pembatalan && $pembatalan->status === 'menunggu')
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="hourglass" class="h-5 w-5 text-amber-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-amber-800">Permintaan Pembatalan Sedang Diproses</p>
                <p class="text-xs text-amber-600 mt-0.5">Admin akan meninjau permintaan Anda dalam 1–2 hari kerja.</p>
            </div>
        </div>
    @endif
    @if($pembatalan && $pembatalan->status === 'ditolak')
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
            <p class="text-sm font-semibold text-red-800 mb-1">Permintaan Pembatalan Ditolak</p>
            @if($pembatalan->catatan_admin)
                <p class="text-xs text-red-600">Alasan: {{ $pembatalan->catatan_admin }}</p>
            @endif
        </div>
    @endif

    {{-- ─── G. TOMBOL MINTA PEMBATALAN ─────────────────────────────────────── --}}
    @if($canCancel && !$hasPendingBatalan && $pesanan->status !== 'dibatalkan')
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
            <div class="flex items-start gap-3 mb-4">
                <i data-lucide="x-circle" class="h-5 w-5 text-red-500 mt-0.5 shrink-0"></i>
                <div>
                    <p class="text-sm font-semibold text-[#4A0F1A]">Ingin Membatalkan Pesanan?</p>
                    <p class="text-xs text-[#4A2E28]/60 mt-0.5">Pembatalan akan diproses oleh admin. Refund DP akan dikembalikan jika disetujui.</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('modal-batalkan').classList.remove('hidden')"
                    class="w-full rounded-xl border-2 border-red-200 bg-red-50 px-6 py-3 text-sm font-semibold text-red-700 hover:bg-red-100 hover:border-red-300 transition-all duration-200 flex items-center justify-center gap-2">
                <i data-lucide="x-circle" class="w-4 h-4"></i>
                Minta Pembatalan
            </button>
        </div>
    @endif

</div>

{{-- ─── MODAL PEMBATALAN ────────────────────────────────────────────────────── --}}
@if($canCancel && !$hasPendingBatalan)
<div id="modal-batalkan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" x-data>
    <div class="w-full max-w-md rounded-2xl bg-white border border-gray-200 shadow-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 border border-red-200 shrink-0">
                <i data-lucide="x-circle" class="h-5 w-5 text-red-500"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Minta Pembatalan Pesanan</h3>
                <p class="text-xs text-gray-500">#{{ $pesanan->kode_pemesanan }}</p>
            </div>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 mb-4">
            <p class="text-xs text-amber-700">Permintaan pembatalan akan ditinjau admin. Jika disetujui, refund DP akan dikembalikan ke rekening yang Anda masukkan.</p>
        </div>

        <form method="POST" action="{{ route('user.pembatalan.ajukan', $pesanan->id) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-600 mb-1.5">Alasan Pembatalan <span class="text-red-500">*</span></label>
                <textarea name="alasan" rows="3" required minlength="20" maxlength="1000"
                          placeholder="Jelaskan alasan pembatalan pesanan Anda..."
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 resize-none transition">{{ old('alasan') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Minimal 20 karakter.</p>
            </div>

            @if($isPelunasan)
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-600">Info Rekening untuk Refund DP</p>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nama Bank <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_bank" required maxlength="100"
                               placeholder="Contoh: BCA, BRI, BNI, Mandiri..."
                               value="{{ old('nama_bank') }}"
                               class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nomor Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_rekening" required maxlength="100"
                               placeholder="Masukkan nomor rekening"
                               value="{{ old('nomor_rekening') }}"
                               class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nama Pemilik Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_rekening" required maxlength="255"
                               placeholder="Sesuai nama di buku tabungan"
                               value="{{ old('nama_rekening') }}"
                               class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 transition">
                    </div>
                </div>
            @else
                <input type="hidden" name="nama_bank" value="-">
                <input type="hidden" name="nomor_rekening" value="-">
                <input type="hidden" name="nama_rekening" value="-">
            @endif

            <div class="flex gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modal-batalkan').classList.add('hidden')"
                        class="flex-1 rounded-xl border border-gray-200 bg-white py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 rounded-xl bg-red-600 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('modal-batalkan')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
</script>
@endif

@endsection