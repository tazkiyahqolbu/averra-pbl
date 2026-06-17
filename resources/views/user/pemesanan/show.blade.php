@extends('user.layouts.app')

@section('content')
@php
    $pembayaranAktif = $pesanan->pembayarans->sortBy('id')->first();
    $sudahUpload     = $pembayaranAktif && $pembayaranAktif->bukti_pembayaran_path;
    $statusBukti     = $pembayaranAktif?->status;
    $isTahapLunas    = $pembayaranAktif && $pembayaranAktif->tahap === 'langsung';
    $jumlahBayar     = $pembayaranAktif ? (float) $pembayaranAktif->jumlah_bayar : (float) $pesanan->total_harga * 0.5;
@endphp

<div class="max-w-4xl mx-auto my-10 space-y-5 animate-fade-in px-4 sm:px-0">

    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">DETAIL PESANAN</p>
                <h2 class="text-2xl font-bold text-[#800000]">{{ $pesanan->kode_pemesanan }}</h2>
            </div>
            @if(!$pesanan->isMenungguKonfirmasi())
                <a href="{{ route('user.pemesanan.invoice', $pesanan->id) }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-[#800000] hover:bg-[#600000] text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-sm transition">
                    📄 Lihat Invoice
                </a>
            @endif
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-3 text-sm font-semibold text-green-800">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-3 text-sm font-semibold text-red-800">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- A. Menunggu Konfirmasi --}}
    @if($pesanan->isMenungguKonfirmasi())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 bg-[#800000] text-white p-4 rounded-xl mb-5">
                <span class="text-2xl">⏳</span>
                <div>
                    <p class="font-bold">Menunggu Konfirmasi Admin</p>
                    <p class="text-sm opacity-90">Pesanan Anda sedang ditinjau. Kami akan mengabari dalam 1×24 jam.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Jenis</p>
                    <p class="font-semibold mt-1">{{ $pesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Tanggal</p>
                    <p class="font-semibold mt-1">{{ $pesanan->tanggal_pakai?->format('d M Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Total</p>
                    <p class="font-bold text-[#800000] mt-1 text-lg">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Metode Bayar</p>
                    <p class="font-semibold mt-1">{{ $isTahapLunas ? 'Lunas' : 'DP 50%' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- B. Menunggu Pembayaran (dikonfirmasi) --}}
    @if($pesanan->isMenungguPembayaran())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-3 bg-[#800000] text-white p-4 rounded-xl">
                <span class="text-2xl">💳</span>
                <div>
                    <p class="font-bold">{{ $isTahapLunas ? 'Menunggu Pembayaran Lunas' : 'Menunggu Pembayaran DP' }}</p>
                    <p class="text-sm opacity-90">Pesanan dikonfirmasi — silakan transfer dan upload bukti pembayaran</p>
                </div>
            </div>

            {{-- Info tagihan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-[#FAF3E0] rounded-xl p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Tahap</p>
                    <p class="font-bold text-[#800000] text-lg">{{ $isTahapLunas ? 'Lunas' : 'DP 50%' }}</p>
                </div>
                <div class="bg-[#FAF3E0] rounded-xl p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Jumlah yang Harus Dibayar</p>
                    <p class="font-bold text-[#800000] text-xl">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Rekening tujuan --}}
            <div class="border border-[#D4AF37]/40 rounded-xl p-4 bg-[#FFFDF5]">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Transfer ke Rekening</p>
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <p class="font-bold text-[#800000] text-lg">Bank BCA — 1234567890</p>
                        <p class="text-sm text-gray-500">a.n AVERRA EVENT</p>
                    </div>
                    <span class="text-2xl">🏦</span>
                </div>
            </div>

            {{-- Status / Form upload --}}
            @if($statusBukti === 'menunggu' && $sudahUpload)
                {{-- Sudah upload, menunggu verifikasi --}}
                <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <span class="text-2xl mt-0.5">⏳</span>
                    <div>
                        <p class="font-semibold text-yellow-800">Bukti pembayaran sedang diverifikasi admin</p>
                        <p class="text-xs text-yellow-600 mt-1">Dikirim pada {{ $pembayaranAktif->dibayar_pada?->format('d F Y, H.i') }}</p>
                    </div>
                </div>

            @elseif($statusBukti === 'ditolak')
                {{-- Ditolak, upload ulang --}}
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                    <span class="text-2xl mt-0.5">❌</span>
                    <div>
                        <p class="font-semibold text-red-700">Bukti pembayaran ditolak</p>
                        <p class="text-sm text-red-600 mt-1">Alasan: {{ $pembayaranAktif->catatan_penolakan ?? '-' }}</p>
                    </div>
                </div>
                @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Ulang Bukti Pembayaran'])

            @else
                {{-- Belum upload --}}
                @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Bukti Pembayaran'])
            @endif
        </div>
    @endif

    {{-- C. Berlangsung --}}
    @if($pesanan->isBerlangsung())
        @php
            $dpVerif        = $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->first();
            $pelunasanRecord = $pesanan->pembayarans->where('tahap', 'pelunasan')->sortBy('id')->last();
            $sisaBayar      = (float) $pesanan->total_harga - (float) ($dpVerif?->jumlah_bayar ?? 0);

            // Info sewa: ambil dari detail pertama
            $detail         = $pesanan->detailPemesanans->first();
            $namaItem       = $detail?->barang?->nama_barang
                           ?? $detail?->jasa?->nama_jasa
                           ?? $detail?->paket?->nama_paket
                           ?? '-';
            $tanggalAmbil   = $detail?->tanggal_ambil;
            $tanggalKembali = $detail?->tanggal_kembali;
            $isSewa         = $pesanan->jenis === 'sewa_barang';

            // Countdown
            $today         = \Carbon\Carbon::today();
            $hariSisa      = $isSewa && $tanggalKembali ? $today->diffInDays($tanggalKembali, false) : null;
            $terlambat     = $isSewa && $tanggalKembali && $today->gt($tanggalKembali);

            // Progress bar sewa
            $progressPct   = 0;
            if ($isSewa && $tanggalAmbil && $tanggalKembali) {
                $totalHari  = max(1, $tanggalAmbil->diffInDays($tanggalKembali) + 1);
                $hariJalan  = min($totalHari, max(0, $tanggalAmbil->diffInDays($today) + 1));
                $progressPct = round($hariJalan / $totalHari * 100);
            }
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            {{-- Header status --}}
            <div class="flex items-center gap-3 bg-green-700 text-white p-4 rounded-xl">
                <span class="text-2xl">🟢</span>
                <div>
                    <p class="font-bold">Sedang Berlangsung</p>
                    <p class="text-sm opacity-90">
                        {{ $isSewa ? 'Barang sedang dalam masa sewa' : 'Persiapan acara sedang berlangsung' }}
                    </p>
                </div>
            </div>

            {{-- Info item --}}
            <div class="bg-[#FAF3E0] rounded-xl p-4 space-y-2">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">
                    {{ $isSewa ? 'Barang yang Disewa' : 'Paket yang Dipesan' }}
                </p>
                <p class="font-bold text-[#800000] text-lg">{{ $namaItem }}</p>
                @if($detail && $detail->jumlah > 1)
                    <p class="text-sm text-gray-500">{{ $detail->jumlah }} unit</p>
                @endif
            </div>

            @if($isSewa && $tanggalAmbil && $tanggalKembali)
                {{-- Countdown pengembalian --}}
                <div class="rounded-xl border-2 {{ $terlambat ? 'border-red-400 bg-red-50' : ($hariSisa <= 2 ? 'border-orange-300 bg-orange-50' : 'border-[#800000]/20 bg-[#FAF3E0]/40') }} p-5">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Batas Pengembalian</p>
                            <p class="font-bold text-[#800000] text-xl">{{ $tanggalKembali->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            @if($terlambat)
                                <p class="text-3xl font-black text-red-600">{{ abs((int)$hariSisa) }}</p>
                                <p class="text-sm font-bold text-red-500">hari terlambat ❌</p>
                            @elseif($hariSisa === 0)
                                <p class="text-2xl font-black text-orange-600">Hari ini</p>
                                <p class="text-sm font-bold text-orange-500">batas pengembalian ⚠️</p>
                            @else
                                <p class="text-3xl font-black text-[#800000]">{{ $hariSisa }}</p>
                                <p class="text-sm font-bold text-gray-500">hari lagi</p>
                            @endif
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>{{ $tanggalAmbil->format('d M') }}</span>
                            <span>{{ $tanggalKembali->format('d M') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-500
                                        {{ $terlambat ? 'bg-red-500' : ($hariSisa <= 2 ? 'bg-orange-400' : 'bg-[#800000]') }}"
                                 style="width: {{ min(100, $progressPct) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">{{ $progressPct }}% masa sewa berjalan</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Tanggal Ambil</p>
                            <p class="font-semibold">{{ $tanggalAmbil->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Metode Pengambilan</p>
                            <p class="font-semibold">
                                {{ $pesanan->lokasi ? 'Dikirim ke alamat' : 'Ambil sendiri' }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($terlambat)
                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                        <span class="text-xl mt-0.5">⚠️</span>
                        <div>
                            <p class="font-semibold text-red-700">Pengembalian sudah terlambat {{ abs((int)$hariSisa) }} hari</p>
                            <p class="text-sm text-red-600 mt-1">Segera kembalikan barang untuk menghindari denda keterlambatan.</p>
                        </div>
                    </div>
                @endif

            @else
                {{-- Acara --}}
                @if($pesanan->tanggal_pakai)
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider">Tanggal Acara</p>
                            <p class="font-bold text-[#800000] mt-1">{{ $pesanan->tanggal_pakai->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider">Lokasi</p>
                            <p class="font-semibold mt-1">{{ $pesanan->lokasi ?? 'Di Sanggar' }}</p>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Pelunasan (jika metode DP) --}}
            @if($pesanan->metode_bayar === 'dp')
                <div class="border-t border-gray-100 pt-4 space-y-3">
                    <p class="text-sm font-bold uppercase tracking-wider text-gray-500">Pelunasan Pembayaran</p>

                @if($pelunasanRecord && $pelunasanRecord->status === 'menunggu' && $pelunasanRecord->bukti_pembayaran_path)
                    <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <span class="text-2xl mt-0.5">⏳</span>
                        <div>
                            <p class="font-semibold text-yellow-800">Bukti pelunasan sedang diverifikasi admin</p>
                            <p class="text-xs text-yellow-600 mt-1">Dikirim pada {{ $pelunasanRecord->dibayar_pada?->format('d F Y, H.i') }}</p>
                        </div>
                    </div>
                @elseif($pelunasanRecord && $pelunasanRecord->status === 'ditolak')
                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                        <span class="text-2xl mt-0.5">❌</span>
                        <div>
                            <p class="font-semibold text-red-700">Bukti pelunasan ditolak</p>
                            <p class="text-sm text-red-600 mt-1">Alasan: {{ $pelunasanRecord->catatan_penolakan ?? '-' }}</p>
                        </div>
                    </div>
                    @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Ulang Bukti Pelunasan', 'sisaBayar' => $sisaBayar])
                @else
                    {{-- Belum upload pelunasan --}}
                    <div class="border border-[#D4AF37]/40 rounded-xl p-4 bg-[#FFFDF5]">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Sisa Pelunasan yang Harus Dibayar</p>
                        <p class="font-bold text-[#800000] text-xl">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 mt-1">Bank BCA — 1234567890 (a.n AVERRA EVENT)</p>
                    </div>
                    @include('user.pemesanan.upload-form-pembayaran', ['label' => 'Upload Bukti Pelunasan', 'sisaBayar' => $sisaBayar])
                @endif
                </div>{{-- end border-t div --}}
            @else
                <div class="border-t border-gray-100 pt-4">
                    <p class="flex items-center gap-2 font-semibold text-green-700">
                        ✅ Pembayaran lunas telah terverifikasi
                    </p>
                </div>
            @endif
        </div>
    @endif

    {{-- D. Selesai & Testimoni --}}
    @if($pesanan->isSelesai())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-3 bg-[#800000] text-white p-4 rounded-xl">
                <span class="text-2xl">✅</span>
                <div>
                    <p class="font-bold">Pesanan Selesai</p>
                    <p class="text-sm opacity-90">Terima kasih telah menggunakan layanan AVERRA</p>
                </div>
            </div>

            @if(!$pesanan->testimoni)
                <div>
                    <h3 class="font-bold text-[#800000] mb-3">Bagaimana pengalaman Anda dengan AVERRA?</h3>
                    <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="flex gap-1 text-3xl">
                            <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                        </div>
                        <textarea name="komentar" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#800000] transition text-sm" placeholder="Tulis ulasan Anda..."></textarea>
                        <button type="submit" class="bg-[#800000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-full font-semibold shadow-sm transition">
                            Kirim Penilaian
                        </button>
                    </form>
                </div>
            @else
                <div class="border border-[#800000]/20 bg-[#FAF3E0]/50 rounded-xl p-5">
                    <p class="font-bold text-[#800000]">Penilaian Anda ⭐⭐⭐⭐⭐</p>
                    <p class="italic text-gray-700 mt-2">"{{ $pesanan->testimoni->komentar }}"</p>
                    <small class="text-gray-400 block mt-2">{{ $pesanan->testimoni->created_at->format('d F Y') }}</small>
                </div>
            @endif
        </div>
    @endif

    {{-- E. Pengembalian Barang (sewa) --}}
    @if(optional($pesanan->pengembalian)->id)
        @php
            $peng = $pesanan->pengembalian;
            $kode = $pesanan->kode_pemesanan;
            $batasKembali  = optional($peng)->tanggal_kembali_jadwal;
            $aktualKembali = optional($peng)->tanggal_kembali_aktual;
            $isTepatWaktu  = true;
            if ($batasKembali && $aktualKembali) {
                $isTepatWaktu = \Carbon\Carbon::parse($aktualKembali)->lte(\Carbon\Carbon::parse($batasKembali));
            }
            $dendaAmount = optional($peng)->total_denda;
            $dendaStatus = optional($peng)->status_denda;
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div class="border-b border-gray-100 pb-4">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">PENGEMBALIAN BARANG</p>
                <h3 class="text-xl font-bold text-[#800000]">Status Pengembalian</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Batas Kembali</p>
                    <p class="font-semibold mt-1">{{ $batasKembali ? \Carbon\Carbon::parse($batasKembali)->format('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Dikembalikan</p>
                    <p class="font-semibold mt-1 flex items-center gap-2">
                        {{ $aktualKembali ? \Carbon\Carbon::parse($aktualKembali)->format('d F Y') : '-' }}
                        @if($aktualKembali)
                            <span class="{{ $isTepatWaktu ? 'text-green-600' : 'text-red-600' }} text-xs font-bold">
                                {{ $isTepatWaktu ? '✅ Tepat Waktu' : '❌ Terlambat' }}
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Kondisi</p>
                    <p class="font-semibold mt-1">{{ $peng->kondisi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Status Pemeriksaan</p>
                    <p class="font-semibold mt-1">{{ ucfirst($peng->status_pengembalian ?? 'Sedang diperiksa') }}</p>
                </div>
            </div>

            @if($peng->catatan_kerusakan)
                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-sm">
                    <p class="font-semibold text-orange-700">Catatan Kerusakan</p>
                    <p class="text-orange-600 mt-1">{{ $peng->catatan_kerusakan }}</p>
                </div>
            @endif

            @if($dendaAmount > 0)
                <div class="border border-[#800000]/20 rounded-xl p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Denda Kerusakan</p>
                            <p class="font-bold text-[#800000] text-xl mt-1">Rp {{ number_format($dendaAmount, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="bg-[#FFFDF5] border border-[#D4AF37]/40 rounded-xl p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Transfer ke</p>
                        <p class="font-bold text-[#800000]">Bank BCA — 1234567890</p>
                        <p class="text-sm text-gray-500">a.n AVERRA EVENT</p>
                    </div>

                    @if($dendaStatus === 'lunas')
                        <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl p-4">
                            <span class="text-xl">✅</span>
                            <p class="font-semibold text-green-700">Denda sudah dibayar</p>
                        </div>
                    @else
                        <form action="{{ route('user.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="pemesanan_id" value="{{ $pesanan->id }}">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📎 Upload Bukti Bayar Denda</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="file" name="bukti_pembayaran" accept="image/*,.pdf"
                                       class="flex-1 rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-[#800000] transition">
                                <button type="submit"
                                        class="bg-[#800000] hover:bg-[#600000] text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition whitespace-nowrap">
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
