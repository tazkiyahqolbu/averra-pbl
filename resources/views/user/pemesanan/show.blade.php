@extends('user.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 my-10 animate-fade-in px-4 sm:px-0">
    
    {{-- Sisi Kiri: Detail Data Item Pemesanan --}}
    <div class="md:col-span-2 rounded-3xl bg-white border border-gray-200 p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-5">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-red-800 px-2 py-0.5 bg-red-50 rounded">
                        {{ $pemesanan->kategori_order === 'acara' ? 'Booking Acara' : 'Sewa Barang' }}
                    </span>
                    <h2 class="text-xl font-semibold text-gray-900 mt-1">Detail Pemesanan</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Kode: <span class="font-mono font-bold">{{ $pemesanan->kode_pemesanan }}</span></p>
                </div>
                
                {{-- Badge Status --}}
                @if($pemesanan->status === 'menunggu')
                    <span class="rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                @elseif($pemesanan->status === 'dikonfirmasi')
                    <span class="rounded-full bg-blue-50 border border-blue-200 px-3 py-1 text-xs font-semibold text-blue-700">Dikonfirmasi</span>
                @elseif($pemesanan->status === 'berlangsung')
                    <span class="rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700">Berlangsung</span>
                @elseif($pemesanan->status === 'selesai')
                    <span class="rounded-full bg-gray-50 border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-600">Selesai</span>
                @else
                    <span class="rounded-full bg-rose-50 border border-rose-200 px-3 py-1 text-xs font-semibold text-rose-700">Dibatalkan</span>
                @endif
            </div>

            {{-- DAFTAR ITEM YANG DIPESAN DINAMIS --}}
            <div class="mb-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Item Yang Dipesan</p>
                <div class="border border-gray-200 rounded-xl divide-y divide-gray-100 overflow-hidden bg-white">
                    {{-- Iterasi relasi items melalui model pemesanan --}}
                    @foreach($pemesanan->items as $item)
                        <div class="p-3 bg-gray-50/30 flex justify-between items-center text-sm">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $item->pivot->qty ?? $item->qty ?? 1 }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <span class="font-bold text-gray-900">
                                Rp {{ number_format(($item->pivot->subtotal ?? $item->subtotal ?? ($item->price * ($item->pivot->qty ?? 1))), 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Metadata Informasi Klien --}}
            <div class="grid gap-4 text-sm border-t border-gray-100 pt-4">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Tanggal Pemesanan</p>
                        <p class="font-medium text-gray-900 mt-0.5">
                            {{ is_string($pemesanan->created_at) ? $pemesanan->created_at : $pemesanan->created_at->format('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Tanggal Penggunaan</p>
                        <p class="font-medium text-gray-900 mt-0.5">
                            {{ is_string($pemesanan->tanggal_pakai) ? \Carbon\Carbon::parse($pemesanan->tanggal_pakai)->format('d F Y') : $pemesanan->tanggal_pakai->format('d F Y') }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Lokasi Penggunaan</p>
                    <p class="font-medium text-gray-900 mt-0.5">{{ $pemesanan->lokasi ?? 'Diambil langsung ke store' }}</p>
                </div>

                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Kontak Penghubung</p>
                    <p class="font-mono font-medium text-gray-900 mt-0.5">{{ $pemesanan->no_hp }}</p>
                </div>

                @if($pemesanan->catatan)
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Catatan Tambahan</p>
                    <p class="text-gray-600 mt-0.5 italic bg-gray-50 p-2.5 rounded-xl border border-gray-100 text-xs">
                        "{{ $pemesanan->catatan }}"
                    </p>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 print:hidden">
            <a href="{{ route('user.pemesanan.index') }}" class="inline-flex items-center text-xs font-semibold text-gray-600 hover:text-red-800 transition">
                ← Kembali ke Riwayat
            </a>
        </div>
    </div>

    {{-- Sisi Kanan: Kotak Informasi Kondisional & Pembayaran --}}
    <div class="space-y-4 print:hidden">
        
        {{-- Status: Menunggu --}}
        @if($pemesanan->status === 'menunggu')
            <div class="rounded-3xl border border-amber-200 bg-amber-50/60 p-5 shadow-sm">
                <h3 class="text-xs font-bold text-amber-800 uppercase mb-2">⏳ Konfirmasi Admin</h3>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Pesanan kamu sedang menunggu peninjauan kuota tim lapangan. Kami akan mengirimkan notifikasi pembaruan rincian segera setelah disetujui.
                </p>
            </div>
        @endif

        {{-- Status: Dibatalkan --}}
        @if($pemesanan->status === 'dibatalkan' || $pemesanan->status === 'batal')
            <div class="rounded-3xl border border-rose-200 bg-rose-50 p-5 shadow-sm">
                <h3 class="text-xs font-bold text-rose-800 uppercase mb-2">❌ Pesanan Batal</h3>
                <p class="text-xs text-rose-700 leading-relaxed">
                    Pemesanan ini telah dibatalkan atau ditolak. Silakan buat permohonan penjadwalan ulang baru atau tanyakan langsung ke admin.
                </p>
            </div>
        @endif

        {{-- Komponen Rincian Invoice Finansial --}}
        @if(in_array($pemesanan->status, ['dikonfirmasi', 'berlangsung', 'selesai']))
            <div class="rounded-3xl bg-white border border-gray-200 p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-gray-900">📄 Ringkasan Invoice</h3>
                    <button onclick="window.print()" class="text-xs text-red-800 font-bold hover:underline inline-flex items-center gap-0.5">
                        🖨️ Cetak
                    </button>
                </div>
                
                <div class="text-xs space-y-2 border-b border-gray-100 pb-3 mb-3 text-gray-600">
                    <div class="flex justify-between">
                        <span>Ongkos Kirim/Lokasi:</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($pemesanan->ongkos_lokasi, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-sm text-gray-900 border-t border-dashed pt-2">
                        <span>Total Tagihan:</span>
                        <span class="text-red-800">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-3 text-[11px] text-gray-500 leading-relaxed mb-4 border border-gray-100">
                    <strong class="text-gray-700 block mb-1">💳 Info Rekening Bank BNI:</strong>
                    No. Rekening: <span class="text-gray-900 font-bold font-mono">0123-4567-89</span><br>
                    Atas Nama: <span class="text-gray-700 font-medium">PT Event Mandiri</span>
                </div>

                {{-- FORM UPLOAD: Status Dikonfirmasi (Bukti DP) --}}
                @if($pemesanan->status === 'dikonfirmasi')
                    <form action="{{ route('user.pemesanan.update', $pemesanan->id) }}" method="POST" enctype="multipart/form-data" class="grid gap-2">
                        @csrf
                        @method('PUT')
                        <label class="block text-[10px] font-bold text-gray-700 uppercase tracking-wide">Step 1: Upload Bukti DP</label>
                        <input type="file" name="bukti_dp" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-semibold file:bg-red-50 file:text-red-800 cursor-pointer" required>
                        <button type="submit" class="w-full rounded-xl bg-red-800 text-white py-2 text-xs font-semibold hover:bg-red-900 transition shadow-sm">
                            Kirim Bukti Pembayaran DP
                        </button>
                    </form>
                @endif

                {{-- FORM UPLOAD: Status Berlangsung (Bukti Pelunasan) --}}
                @if($pemesanan->status === 'berlangsung')
                    <form action="{{ route('user.pemesanan.update', $pemesanan->id) }}" method="POST" enctype="multipart/form-data" class="grid gap-2">
                        @csrf
                        @method('PUT')
                        <label class="block text-[10px] font-bold text-gray-700 uppercase tracking-wide">Step 2: Upload Pelunasan</label>
                        <input type="file" name="bukti_lunas" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-semibold file:bg-emerald-50 file:text-emerald-800 cursor-pointer" required>
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 text-white py-2 text-xs font-semibold hover:bg-emerald-700 transition shadow-sm">
                            Kirim Bukti Pelunasan
                        </button>
                    </form>
                @endif

                {{-- Status Selesai --}}
                @if($pemesanan->status === 'selesai')
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-center text-xs font-medium text-emerald-800">
                        🎉 Pemesanan lunas & selesai. Terima kasih atas kepercayaan Anda!
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>