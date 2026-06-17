@extends('user.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 space-y-6 px-4 sm:px-0 animate-fade-in">

    {{-- Tombol Aksi --}}
    <div class="flex justify-between items-center print:hidden">
        <a href="{{ route('user.pemesanan.show', $pesanan->id) }}" class="inline-flex items-center text-xs font-semibold text-gray-600 hover:text-red-800 transition">
            ← Kembali ke Detail Pesanan
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-full bg-red-800 text-white px-5 py-2.5 text-xs font-semibold hover:bg-red-900 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h6z" />
            </svg>
            Cetak Invoice (PDF)
        </button>
    </div>

    {{-- Lembar Invoice Utama --}}
    <div class="rounded-3xl bg-white border border-gray-200 p-8 shadow-sm relative overflow-hidden print:border-0 print:shadow-none">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-6 mb-6 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600">OFFICIAL INVOICE</span>
                <h2 class="text-3xl font-black text-red-800 tracking-tight mt-0.5">#{{ $pesanan->kode_pemesanan }}</h2>
                <p class="text-xs text-gray-400 mt-1">Tanggal Transaksi: <span class="font-medium text-gray-700">{{ $pesanan->created_at->format('d M Y') }}</span></p>
            </div>
            <div class="text-left sm:text-right">
                <span class="font-bold text-2xl tracking-[0.15em] text-red-800 block">SILART</span>
                <p class="text-xs text-gray-500 max-w-xs mt-1 leading-relaxed">Gedung Serbaguna Politeknik Negeri Padang, Kampus Limau Manis, Kota Padang.</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 text-sm mb-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Ditagihkan Kepada:</p>
                <p class="font-bold text-gray-900 text-base">{{ $pesanan->nama_pemesan }}</p>
                <p class="text-gray-500 font-mono text-xs mt-0.5">{{ $pesanan->no_hp }}</p>
                <p class="text-gray-600 mt-1 text-xs leading-relaxed">{{ $pesanan->lokasi ?? 'Diambil langsung ke store' }}</p>
            </div>
            <div class="sm:text-right">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Metode Pelaksanaan:</p>
                <p class="font-semibold text-gray-900 capitalize">{{ $pesanan->kategori_order === 'acara' ? 'Event Booking Service' : 'Properti Rental Pro' }}</p>
                <p class="text-xs text-gray-500 mt-1">Tanggal Penggunaan:</p>
                <p class="font-bold text-red-800 text-xs font-mono mt-0.5">{{ $pesanan->tanggal_pakai->format('d F Y') }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 mb-6">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">Nama Produk / Jasa</th>
                        <th class="px-5 py-3 text-center w-24">Jumlah</th>
                        <th class="px-5 py-3 text-right w-36">Harga Satuan</th>
                        <th class="px-5 py-3 text-right w-36">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                    @php $total_item_cost = 0; @endphp
                    @foreach($pesanan->detailPemesanans as $item)
                        @php
                            $namaItem = match($item->jenis_item) {
                                'barang' => optional($item->barang)->nama_barang ?? '-',
                                'jasa'   => optional($item->jasa)->nama_jasa ?? '-',
                                'paket'  => optional($item->paket)->nama_paket ?? '-',
                                default  => '-',
                            };
                            $total_item_cost += $item->subtotal;
                        @endphp
                        <tr>
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $namaItem }}</td>
                            <td class="px-5 py-4 text-center font-mono">{{ $item->jumlah }}</td>
                            <td class="px-5 py-4 text-right font-mono">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-right font-bold text-gray-900 font-mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-end text-sm space-y-2 border-t border-gray-100 pt-4 max-w-md ml-auto">
            <div class="flex justify-between w-full text-gray-500">
                <span>Total Item Pemesanan:</span>
                <span class="font-mono font-medium text-gray-900">Rp {{ number_format($total_item_cost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between w-full text-gray-500">
                <span>Ongkos Distribusi / Lokasi:</span>
                <span class="font-mono font-medium text-gray-900">Rp {{ number_format($pesanan->ongkos_lokasi, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between w-full font-black text-base text-gray-900 border-t border-dashed pt-3 mt-1">
                <span class="text-red-800">TOTAL LUNAS (NET):</span>
                <span class="text-xl text-red-800 font-mono">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="hidden print:block border-t border-gray-200 pt-10 mt-16 text-center text-xs text-gray-400">
            <p>Terima kasih telah mempercayakan pengerjaan dekorasi dan perlengkapan event Anda bersama SILART.</p>
            <p class="mt-1 font-mono">Struk ini sah dikeluarkan secara sistematis dan tidak memerlukan tanda tangan basah.</p>
        </div>
    </div>

    @if($pesanan->status === 'selesai')
        <div class="text-right print:hidden">
            <a href="{{ route('testimoni.store', ['pemesanan_id' => $pesanan->id]) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 text-white px-6 py-3 text-xs font-bold hover:bg-amber-600 transition shadow-sm">
                Berikan Ulasan & Testimoni Layanan →
            </a>
        </div>
    @endif

</div>
@endsection
