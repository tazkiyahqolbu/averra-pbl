@extends('user.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 bg-white p-8 rounded-3xl border border-gray-200">
    <!-- Header Status -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-2xl font-bold text-[#800000]">Status: {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}</h2>
        @if(!$pesanan->isMenungguKonfirmasi())
            <a href="{{ route('user.pemesanan.invoice', $pesanan->id) }}" target="_blank"
               class="inline-flex items-center gap-2 bg-[#800000] hover:bg-[#600000] text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition">
                📄 Lihat Invoice
            </a>
        @endif
    </div>

    <!-- A. Status: Menunggu Konfirmasi -->
    @if($pesanan->isMenungguKonfirmasi())
        <div class="bg-[#800000] text-white p-4 rounded-xl mb-6 font-bold">⏳ MENUNGGU KONFIRMASI ADMIN</div>
        <p>Pesanan Anda sedang ditinjau. Kami akan mengabari dalam 1x24 jam.</p>
        <button class="mt-4 text-[#800000] font-semibold underline hover:text-[#600000]">[Batalkan Pesanan]</button>
    @endif

    <!-- B. Status: Menunggu Pembayaran -->
    @if($pesanan->isMenungguPembayaran())
        <div class="bg-[#800000] text-white p-4 rounded-xl mb-6 font-bold">💳 MENUNGGU PEMBAYARAN DP</div>
        <div class="border p-4 rounded-xl">
            <p class="font-semibold text-[#800000]">Opsi Pembayaran</p>
            <ul class="mt-2 list-disc list-inside text-sm text-gray-800">
                <li><span class="font-semibold">DP dulu (50%)</span> → upload DP → verifikasi → upload pelunasan → verifikasi</li>
                <li><span class="font-semibold">Lunas langsung</span> → upload sekali → verifikasi → selesai</li>
            </ul>

            <div class="mt-4">
                <p><span class="font-semibold">Persentase DP:</span> 50%</p>
                <p class="mt-1">Tahap saat ini: <span class="font-semibold">dp</span></p>
            </div>

            <div class="mt-4">
                @php $dpAmount = $pesanan->total_harga * 0.5; @endphp
                <p>Yang harus dibayar sekarang (DP 50%): <span class="font-bold text-[#800000]">Rp {{ number_format($dpAmount, 0, ',', '.') }}</span></p>
                <p>Transfer ke: <span class="font-bold text-[#800000]">Bank BCA - 1234567890 (a.n AVERRA EVENT)</span></p>
                <div class="mt-4">
                    <label class="font-semibold text-sm">UPLOAD BUKTI PEMBAYARAN</label>
                    <input type="file" class="block w-full border mt-2 focus:border-[#800000] focus:ring-[#800000] rounded-lg">
                </div>
            </div>
        </div>
    @endif
        

    <!-- C. Status: Berlangsung -->
    @if($pesanan->isBerlangsung())
        <div class="bg-[#800000] text-white p-4 rounded-xl mb-6 font-bold">🟢 BERLANGSUNG</div>
        <div class="border p-4 rounded-xl mb-4 bg-white">
            <p class="font-semibold text-[#800000]">Alur saat Berlangsung</p>
            <ul class="mt-2 list-disc list-inside text-sm text-gray-800">
                <li>sewa barang + dikirim</li>
                <li>Admin kirim barang → update info pengiriman</li>
            </ul>
        </div>

        @if($pesanan->metode_bayar == 'dp')
            <div class="border p-4 rounded-xl">
                @php $sisaPelunasan = $pesanan->total_harga * 0.5; @endphp
                <p>Sisa yang harus dibayar: <span class="font-bold text-[#800000]">Rp {{ number_format($sisaPelunasan, 0, ',', '.') }}</span></p>
                <button class="mt-3 bg-[#800000] hover:bg-[#600000] text-white px-5 py-2 rounded-lg font-semibold shadow-md transition">Kirim Bukti Pelunasan</button>
            </div>
        @else
            <p class="font-bold text-[#800000]">✅ Pembayaran Lunas Terverifikasi</p>
        @endif
    @endif

    <!-- D. Status: Selesai & Testimoni -->
    @if($pesanan->isSelesai())
        <div class="bg-[#800000] text-white p-4 rounded-xl mb-6 font-bold">✅ SELESAI</div>
        
        @if(!$pesanan->testimoni)
            <h3 class="font-bold text-[#800000]">Bagaimana pengalaman Anda dengan AVERRA?</h3>
            <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="flex gap-2 my-2 text-2xl">
                    <span>⭐⭐⭐⭐⭐</span>
                </div>
                <textarea name="komentar" class="w-full border p-3 rounded-lg focus:border-[#800000] focus:ring-[#800000]" placeholder="Tulis ulasan Anda..."></textarea>
                <button type="submit" class="mt-3 bg-[#800000] hover:bg-[#600000] text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">Kirim Penilaian</button>
            </form>
        @else
            <div class="border border-[#800000]/30 bg-[#FAF3E0]/30 p-5 rounded-xl">
                <p class="font-bold text-[#800000]">Penilaian Anda: ⭐⭐⭐⭐⭐</p>
                <p class="italic text-gray-700 mt-2">"{{ $pesanan->testimoni->komentar }}"</p>
                <small class="text-gray-500 block mt-2">Ditulis: {{ $pesanan->testimoni->created_at->format('d F Y') }}</small>
            </div>
        @endif
    @endif

    {{-- H. PENGEMBALIAN BARANG --}}
    @if(optional($pesanan->pengembalian)->id)
        <div class="mt-8 border-t border-gray-100 pt-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h3 class="text-xl font-bold text-[#800000]">H&nbsp; PENGEMBALIAN BARANG</h3>
            </div>

            {{-- Tab --}}
            <div class="mt-4 flex items-center gap-3 text-sm font-semibold text-gray-600 overflow-x-auto pb-2">
                @php
                    $tabs = [
                        'Semua' => 'all',
                        'Belum Dikembalikan' => 'belum',
                        'Sedang Diperiksa' => 'diperiksa',
                        'Selesai' => 'selesai',
                    ];
                @endphp
                @foreach($tabs as $label => $key)
                    <span class="px-4 py-2 rounded-full border whitespace-nowrap {{ $key === 'diperiksa' ? 'border-[#800000] text-[#800000] bg-[#FAF3E0]' : 'border-gray-200 bg-white' }}">
                        {{ $label }}
                    </span>
                @endforeach
            </div>

            @php
                $peng = $pesanan->pengembalian;
                $kode = $pesanan->kode_pemesanan ?? ('#AVR-' . date('Ymd') . '-00' . $pesanan->id);
                $batasKembali = optional($peng)->tanggal_kembali_jadwal;
                $aktualKembali = optional($peng)->tanggal_kembali_aktual;
                $statusLabel = 'Sedang Diperiksa';
                $dendaStatus = optional($peng)->status_denda;
                $dendaAmount = optional($peng)->denda;
                
                // Cek ketepatan waktu
                $isTepatWaktu = true;
                if ($batasKembali && $aktualKembali) {
                    $isTepatWaktu = \Carbon\Carbon::parse($aktualKembali)->lte(\Carbon\Carbon::parse($batasKembali));
                }
            @endphp

            {{-- Kartu Pengembalian --}}
            <div class="mt-5 bg-white rounded-2xl border border-[#800000]/20 p-5 shadow-sm">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-mono font-semibold">{{ $kode }}</span>
                        <span class="text-[#800000] font-bold">🔵 {{ $statusLabel }}</span>
                    </div>
                    <div class="text-gray-800 font-semibold mt-1">{{ $pesanan->kategori_order ?? 'Kamera Canon EOS' }} + Tripod</div>
                    <div class="text-sm text-gray-700">Batas Kembali: {{ $batasKembali ? \Carbon\Carbon::parse($batasKembali)->format('d F Y') : '-' }}</div>
                    <div class="text-sm text-gray-700">Dikembalikan: {{ $aktualKembali ? \Carbon\Carbon::parse($aktualKembali)->format('d F Y') : '-' }}</div>
                    <div class="text-sm text-gray-700">Metode: {{ $peng && $peng->metode ? $peng->metode : 'Antar Sendiri' }}</div>

                    <div class="pt-2 flex justify-end">
                        <span class="text-[#800000] font-semibold underline hover:text-[#600000] cursor-pointer">[Lihat Detail]</span>
                    </div>
                </div>
            </div>

            {{-- Detail Pengembalian --}}
            <div class="mt-5 bg-[#FAF3E0]/30 rounded-2xl border border-[#800000]/20 p-5 shadow-sm">
                <div class="text-lg font-bold mb-3 text-[#800000]">Detail Pengembalian</div>
                <div class="font-mono font-semibold">{{ $kode }}</div>

                <div class="mt-4 space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1">
                        <div class="font-semibold text-[#800000] sm:col-span-1">Item:</div>
                        <div class="text-gray-800 sm:col-span-3">
                            <div>{{ $pesanan->nama_layanan ?? $pesanan->kategori_order ?? 'Kamera Canon EOS' }}</div>
                            <div class="text-sm">Tripod Aluminum 170cm</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1 items-center">
                        <div class="font-semibold text-[#800000] sm:col-span-1">Tanggal Kembali Jadwal:</div>
                        <div class="text-sm text-gray-800 sm:col-span-3">
                            {{ $batasKembali ? \Carbon\Carbon::parse($batasKembali)->format('d F Y') : '-' }}
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1 items-center">
                        <div class="font-semibold text-[#800000] sm:col-span-1">Tanggal Kembali Aktual:</div>
                        <div class="text-sm text-gray-800 sm:col-span-3 flex items-center gap-2">
                            {{ $aktualKembali ? \Carbon\Carbon::parse($aktualKembali)->format('d F Y') : '-' }}
                            @if($aktualKembali)
                                @if($isTepatWaktu)
                                    <span class="font-medium text-green-700">✅ Tepat Waktu</span>
                                @else
                                    <span class="font-medium text-red-600">❌ Terlambat</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1 items-center">
                        <div class="font-semibold text-[#800000] sm:col-span-1">Status Pemeriksaan:</div>
                        <div class="text-sm text-gray-800 sm:col-span-3">
                            Sedang diperiksa admin
                        </div>
                    </div>

                    <div class="mt-4 border-t border-[#800000]/20 pt-4">
                        <div class="font-bold text-[#800000] mb-2 text-center bg-white py-1 rounded border border-gray-200 shadow-sm uppercase tracking-wider text-xs">━━━ HASIL PEMERIKSAAN (setelah admin isi) ━━━</div>
                        <div class="text-sm text-gray-800 bg-white p-4 rounded-lg border border-gray-200 grid grid-cols-1 sm:grid-cols-4 gap-2">
                            <div class="font-semibold sm:col-span-1">Kondisi:</div>
                            <div class="sm:col-span-3">{{ $peng->kondisi ?? 'Rusak Ringan' }}</div>
                            <div class="font-semibold sm:col-span-1 mt-1 sm:mt-0">Catatan:</div>
                            <div class="sm:col-span-3 mt-1 sm:mt-0">{{ $peng->catatan ?? 'Tutup lensa retak' }}</div>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-[#800000]/20 pt-4">
                        <div class="text-sm text-gray-800 space-y-2">
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-1">
                                <div class="font-semibold text-[#800000] sm:col-span-1">Denda Kerusakan:</div>
                                <div class="sm:col-span-3 font-bold text-lg">Rp {{ $dendaAmount ? number_format($dendaAmount, 0, ',', '.') : '150.000' }}</div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-1">
                                <div class="font-semibold text-[#800000] sm:col-span-1">Status Denda:</div>
                                <div class="sm:col-span-3 font-bold">⚠️ {{ $dendaStatus === 'dibayar' ? 'Sudah Dibayar' : 'Belum Dibayar' }}</div>
                            </div>
                            <div class="mt-3 bg-white p-3 rounded-lg border border-gray-200">
                                <span class="font-semibold block mb-1">Transfer ke:</span> 
                                <span class="font-bold text-[#800000] text-lg">Bank BCA — 1234567890</span> (a.n AVERRA EVENT)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-[#800000]/20 pt-4">
                    <div class="font-bold text-[#800000] mb-3 text-center bg-white py-1 rounded border border-gray-200 shadow-sm uppercase tracking-wider text-xs">━━━ UPLOAD BUKTI BAYAR DENDA ━━━</div>
                    <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📎 Pilih File</label>
                            <input type="file" class="block w-full border border-gray-300 focus:border-[#800000] focus:ring-[#800000] bg-gray-50 rounded-lg p-2 text-sm" />
                        </div>

                        <div>
                            <button type="button" class="w-full sm:w-auto bg-[#800000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-lg font-semibold shadow-md transition whitespace-nowrap">
                                Kirim Bukti Pembayaran Denda
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
