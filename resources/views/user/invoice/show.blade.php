@extends('user.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-5 print:max-w-none print:space-y-0">

    {{-- Tombol Aksi --}}
    <div class="flex justify-between items-center print:hidden">
        <a href="{{ route('user.pemesanan.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-[#4A2E28]/70 hover:text-[#4A0F1A] transition">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Daftar Pesanan
        </a>
        <div class="flex items-center gap-2">
            @if($pesanan->isMenungguPembayaran())
                <a href="{{ route('user.pembayaran.pilih', $pesanan->id) }}"
                   class="inline-flex items-center gap-2 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-5 py-2.5 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.42)] hover:from-[#7B1C2E] transition-all duration-200">
                    <i data-lucide="credit-card" class="h-4 w-4"></i>
                    Bayar Sekarang
                </a>
            @endif
            <a href="{{ route('user.pemesanan.invoice.pdf', $pesanan->id) }}"
               class="inline-flex items-center gap-2 rounded-full border border-[#4A0F1A]/20 bg-white px-5 py-2.5 text-sm font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-white transition-all duration-200">
                <i data-lucide="download" class="h-4 w-4"></i>
                Download PDF
            </a>
        </div>
    </div>

    {{-- Lembar Invoice --}}
    <div class="rounded-3xl bg-white border border-[#E2D4C0] shadow-[0_4px_24px_rgba(74,15,26,0.07)] overflow-hidden print:rounded-none print:border-0 print:shadow-none">

        {{-- Stripe aksen atas --}}
        <div class="h-1.5 bg-gradient-to-r from-[#6B1625] via-[#C8960C] to-[#3A0A12] print:hidden"></div>

        <div class="p-8 sm:p-10">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 pb-7 mb-7 border-b border-[#E2D4C0]">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-[#C8960C]">OFFICIAL INVOICE</p>
                    <h2 class="font-serif text-3xl font-light text-[#4A0F1A] mt-1 tracking-tight">
                        #{{ $pesanan->kode_pemesanan }}
                    </h2>
                    <p class="text-xs text-[#4A2E28]/60 mt-1.5">
                        Tanggal: <span class="font-medium text-[#4A2E28]">{{ $pesanan->created_at->format('d M Y') }}</span>
                    </p>
                </div>
                <div class="text-left sm:text-right">
                    <span class="font-serif text-2xl font-bold tracking-[0.15em] text-[#4A0F1A]">SILART</span>
                    <p class="text-xs text-[#4A2E28]/60 max-w-[220px] mt-1.5 leading-relaxed sm:ml-auto">
                        Gedung Serbaguna Politeknik Negeri Padang,<br>Kampus Limau Manis, Kota Padang.
                    </p>
                </div>
            </div>

            {{-- Info Pemesan & Pelaksanaan --}}
            <div class="grid sm:grid-cols-2 gap-6 mb-8">
                <div class="rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-5 py-4 space-y-1">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-2">Ditagihkan Kepada</p>
                    <p class="font-semibold text-[#4A0F1A] text-base">{{ $pesanan->nama_pemesan }}</p>
                    <p class="text-xs text-[#4A2E28]/70 font-mono">{{ $pesanan->no_hp }}</p>
                    <p class="text-xs text-[#4A2E28]/60 leading-relaxed pt-0.5">{{ $pesanan->lokasi ?? 'Diambil langsung ke store' }}</p>
                </div>
                <div class="rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-5 py-4 space-y-1">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-2">Detail Pelaksanaan</p>
                    <p class="font-semibold text-[#4A0F1A] text-sm">
                        {{ $pesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara / Jasa' }}
                    </p>
                    <p class="text-xs text-[#4A2E28]/60 mt-1">Tanggal Penggunaan</p>
                    <p class="font-semibold text-[#4A0F1A] text-sm font-mono">
                        {{ $pesanan->tanggal_pakai ? $pesanan->tanggal_pakai->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>

            {{-- Tabel Item --}}
            <div class="overflow-hidden rounded-2xl border border-[#E2D4C0] mb-7">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="bg-[#FAF3E0] border-b border-[#E2D4C0]">
                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#4A2E28]">Nama Produk / Layanan</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#4A2E28] text-center w-24">Jml</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#4A2E28] text-right w-36">Harga Satuan</th>
                            <th class="px-5 py-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#4A2E28] text-right w-36">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2D4C0] bg-white">
                        @php $total_item_cost = 0; @endphp
                        @foreach($pesanan->detailPemesanans as $detail)
                            @php
                                $namaItem = match($detail->jenis_item) {
                                    'barang' => optional($detail->barang)->nama_barang ?? '-',
                                    'jasa'   => optional($detail->jasa)->nama_jasa ?? '-',
                                    'paket'  => optional($detail->paket)->nama_paket ?? '-',
                                    default  => '-',
                                };
                                $total_item_cost += $detail->subtotal;
                            @endphp
                            <tr>
                                <td class="px-5 py-4 font-semibold text-[#4A0F1A]">{{ $namaItem }}</td>
                                <td class="px-5 py-4 text-center font-mono text-[#4A2E28]">{{ $detail->jumlah }}</td>
                                <td class="px-5 py-4 text-right font-mono text-[#4A2E28]">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-right font-semibold font-mono text-[#4A0F1A]">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Ringkasan Total --}}
            <div class="flex flex-col items-end gap-2 max-w-sm ml-auto">
                <div class="flex justify-between w-full text-sm text-[#4A2E28]/70">
                    <span>Total Item</span>
                    <span class="font-mono font-medium text-[#4A2E28]">Rp {{ number_format($total_item_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between w-full text-sm text-[#4A2E28]/70">
                    <span>Ongkos Lokasi</span>
                    <span class="font-mono font-medium text-[#4A2E28]">Rp {{ number_format($pesanan->ongkos_lokasi ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between w-full text-base font-bold border-t border-dashed border-[#E2D4C0] pt-3 mt-1">
                    <span class="text-[#4A0F1A]">Total Keseluruhan</span>
                    <span class="font-serif text-xl text-[#C8960C] font-semibold font-mono">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Informasi Pembayaran --}}
            @if($pesanan->pembayarans->isNotEmpty())
                @php
                    $bayar = $pesanan->pembayarans->first();
                    $sudahBayar = $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
                    $sisa = $pesanan->total_harga - $sudahBayar;
                @endphp
                <div class="mt-6 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-5 py-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-3">Status Pembayaran</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-[#4A2E28]/70">
                            <span>{{ $bayar->tahap === 'langsung' ? 'Bayar Lunas' : 'DP (50%)' }}</span>
                            <span class="font-mono font-medium text-[#4A2E28]">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                        @if($bayar->tahap !== 'langsung' && $sisa > 0)
                            <div class="flex justify-between text-[#4A2E28]/70">
                                <span>Sisa Pelunasan</span>
                                <span class="font-mono font-semibold text-[#4A0F1A]">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2 pt-1">
                            @php
                                $statusBayar = $bayar->status;
                                $badgeClass = match($statusBayar) {
                                    'terverifikasi' => 'border-green-200 bg-green-50 text-green-700',
                                    'menunggu'      => 'border-amber-200 bg-amber-50 text-amber-700',
                                    'ditolak'       => 'border-red-200 bg-red-50 text-red-700',
                                    default         => 'border-[#E2D4C0] bg-white text-[#4A2E28]',
                                };
                                $badgeLabel = match($statusBayar) {
                                    'terverifikasi' => 'Terverifikasi',
                                    'menunggu'      => 'Menunggu Verifikasi',
                                    'ditolak'       => 'Ditolak',
                                    default         => ucfirst($statusBayar),
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-[10px] font-semibold {{ $badgeClass }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $badgeLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Footer print --}}
            <div class="hidden print:block border-t border-[#E2D4C0] pt-8 mt-12 text-center text-xs text-[#4A2E28]/50">
                <p>Terima kasih telah mempercayakan dekorasi dan perlengkapan event Anda bersama SILART.</p>
                <p class="mt-1 font-mono">Dokumen ini diterbitkan secara otomatis dan sah tanpa tanda tangan basah.</p>
            </div>

        </div>
    </div>

    {{-- Tombol Ulasan --}}
    @if($pesanan->status === 'selesai')
        <div class="flex justify-end print:hidden">
            <a href="{{ route('testimoni.store', ['pemesanan_id' => $pesanan->id]) }}"
               class="inline-flex items-center gap-2 rounded-full border border-[#4A0F1A]/25 bg-white px-6 py-2.5 text-sm font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
                <i data-lucide="star" class="h-4 w-4"></i>
                Berikan Ulasan & Testimoni
            </a>
        </div>
    @endif

</div>
@endsection
