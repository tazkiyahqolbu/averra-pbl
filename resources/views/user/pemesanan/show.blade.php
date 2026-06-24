@extends('user.layouts.app')

@section('content')
@php
    $pembayaranAktif = $pesanan->pembayarans->sortBy('id')->first();
    $sudahUpload     = $pembayaranAktif && $pembayaranAktif->bukti_pembayaran_path;
    $statusBukti     = $pembayaranAktif?->status;
    $isTahapLunas    = $pembayaranAktif && $pembayaranAktif->tahap === 'langsung';
    $jumlahBayar     = $pembayaranAktif ? (float) $pembayaranAktif->jumlah_bayar : (float) $pesanan->total_harga * 0.5;
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
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Metode Bayar</p>
                    <p class="font-semibold text-[#4A0F1A]">{{ $isTahapLunas ? 'Lunas' : 'DP 50%' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── B. MENUNGGU PEMBAYARAN (dikonfirmasi) ──────────────────────────── --}}
    @if($pesanan->isMenungguPembayaran())
        {{-- Status Banner --}}
        <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="credit-card" class="h-5 w-5 text-blue-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-blue-800">
                    {{ $isTahapLunas ? 'Menunggu Pembayaran Lunas' : 'Menunggu Pembayaran DP' }}
                </p>
                <p class="text-xs text-blue-600 mt-0.5">Pesanan dikonfirmasi — silakan transfer dan upload bukti pembayaran</p>
            </div>
        </div>

        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6 space-y-5">
            {{-- Info tagihan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Tahap</p>
                    <p class="font-semibold text-[#4A0F1A]">{{ $isTahapLunas ? 'Lunas' : 'DP 50%' }}</p>
                </div>
                <div class="rounded-xl border border-[#C8960C]/40 bg-[#FAF3E0] p-4">
                    <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Jumlah yang Harus Dibayar</p>
                    <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Rekening --}}
            <div class="rounded-xl border border-[#C8960C]/30 bg-[#FAF3E0] p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Transfer ke Rekening</p>
                <p class="font-serif font-bold text-[#4A0F1A] text-lg">Bank BCA — 1234567890</p>
                <p class="text-sm text-[#4A2E28]/60">a.n AVERRA EVENT</p>
            </div>

            {{-- Upload status --}}
            @if($statusBukti === 'menunggu' && $sudahUpload)
                <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <i data-lucide="clock" class="h-4 w-4 text-amber-600 mt-0.5 shrink-0"></i>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Bukti pembayaran sedang diverifikasi admin</p>
                        <p class="text-xs text-amber-600 mt-1">Dikirim pada {{ $pembayaranAktif->dibayar_pada?->format('d F Y, H.i') }}</p>
                    </div>
                </div>
            @elseif($statusBukti === 'ditolak')
                <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                    <i data-lucide="x-circle" class="h-4 w-4 text-red-500 mt-0.5 shrink-0"></i>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Bukti pembayaran ditolak</p>
                        <p class="text-sm text-red-600 mt-1">Alasan: {{ $pembayaranAktif->catatan_penolakan ?? '-' }}</p>
                    </div>
                </div>
                @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Ulang Bukti Pembayaran'])
            @else
                @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Bukti Pembayaran'])
            @endif
        </div>
    @endif

    {{-- ─── C. BERLANGSUNG ─────────────────────────────────────────────────── --}}
    @if($pesanan->isBerlangsung())
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

            $today           = \Carbon\Carbon::today();
            $hariSisa        = $isSewa && $tanggalKembali ? $today->diffInDays($tanggalKembali, false) : null;
            $terlambat       = $isSewa && $tanggalKembali && $today->gt($tanggalKembali);

            $progressPct = 0;
            if ($isSewa && $tanggalAmbil && $tanggalKembali) {
                $totalHari   = max(1, $tanggalAmbil->diffInDays($tanggalKembali) + 1);
                $hariJalan   = min($totalHari, max(0, $tanggalAmbil->diffInDays($today) + 1));
                $progressPct = round($hariJalan / $totalHari * 100);
            }
        @endphp

        {{-- Status Banner --}}
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 flex items-center gap-3">
            <i data-lucide="play-circle" class="h-5 w-5 text-green-600 shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-green-800">Sedang Berlangsung</p>
                <p class="text-xs text-green-600 mt-0.5">
                    {{ $isSewa ? 'Barang sedang dalam masa sewa' : 'Persiapan acara sedang berlangsung' }}
                </p>
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

            @if($isSewa && $tanggalAmbil && $tanggalKembali)
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
            @if($pesanan->metode_bayar === 'dp')
                <div class="border-t border-[#E2D4C0] pt-5 space-y-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Pelunasan Pembayaran</p>

                    @if($pelunasanRecord && $pelunasanRecord->status === 'menunggu' && $pelunasanRecord->bukti_pembayaran_path)
                        <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <i data-lucide="clock" class="h-4 w-4 text-amber-600 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-sm font-semibold text-amber-800">Bukti pelunasan sedang diverifikasi admin</p>
                                <p class="text-xs text-amber-600 mt-1">Dikirim pada {{ $pelunasanRecord->dibayar_pada?->format('d F Y, H.i') }}</p>
                            </div>
                        </div>
                    @elseif($pelunasanRecord && $pelunasanRecord->status === 'ditolak')
                        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                            <i data-lucide="x-circle" class="h-4 w-4 text-red-500 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-sm font-semibold text-red-700">Bukti pelunasan ditolak</p>
                                <p class="text-sm text-red-600 mt-1">Alasan: {{ $pelunasanRecord->catatan_penolakan ?? '-' }}</p>
                            </div>
                        </div>
                        @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Ulang Bukti Pelunasan', 'sisaBayar' => $sisaBayar])
                    @else
                        <div class="rounded-xl border border-[#C8960C]/30 bg-[#FAF3E0] p-4">
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-1">Sisa Pelunasan</p>
                            <p class="font-serif font-bold text-[#C8960C] text-xl">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#4A2E28]/50 mt-1">Bank BCA — 1234567890 (a.n AVERRA EVENT)</p>
                        </div>
                        @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Bukti Pelunasan', 'sisaBayar' => $sisaBayar])
                    @endif
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
        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-6">
            @if(!$pesanan->testimoni)
                <h3 class="font-serif text-lg font-light text-[#4A0F1A] mb-4">Bagaimana pengalaman Anda?</h3>
                <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" class="space-y-4"
                      x-data="{ rating: 0 }">
                    @csrf
                    {{-- Star rating --}}
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Penilaian</p>
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        x-on:click="rating = {{ $i }}"
                                        class="text-2xl transition"
                                        x-bind:class="rating >= {{ $i }} ? 'text-[#C8960C]' : 'text-[#E2D4C0]'">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" x-bind:value="rating">
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Ulasan</p>
                        <textarea name="isi_testimoni" rows="3"
                                  class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A2E28] focus:border-[#C8960C] focus:outline-none transition"
                                  placeholder="Ceritakan pengalaman Anda..."></textarea>
                    </div>
                    <button type="submit"
                            class="rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-2.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                        Kirim Ulasan
                    </button>
                </form>
            @else
                <p class="text-[10px] uppercase tracking-wider text-[#C8960C] mb-3">Ulasan Anda</p>
                <div class="flex gap-0.5 mb-3 text-[#C8960C]">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $pesanan->testimoni->rating ? '' : 'opacity-25' }}">★</span>
                    @endfor
                </div>
                <p class="text-sm text-[#4A2E28] italic">"{{ $pesanan->testimoni->isi_testimoni }}"</p>
                <p class="text-xs text-[#4A2E28]/60 mt-2">{{ $pesanan->testimoni->created_at->format('d F Y') }}</p>
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
                        <form action="{{ route('user.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="pemesanan_id" value="{{ $pesanan->id }}">
                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Upload Bukti Bayar Denda</p>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="file" name="bukti_pembayaran" accept="image/*,.pdf"
                                       class="flex-1 rounded-xl border border-[#E2D4C0] bg-white px-3 py-2 text-sm text-[#4A2E28] focus:border-[#C8960C] focus:outline-none transition cursor-pointer">
                                <button type="submit"
                                        class="shrink-0 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-5 py-2 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_12px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_16px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                                    Kirim Bukti
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
