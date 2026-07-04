@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
@php
    $badgeMap = [
        'menunggu'      => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
        'terverifikasi' => ['label' => 'Berhasil',             'class' => 'badge-active'],
        'ditolak'       => ['label' => 'Dibatalkan / Gagal',   'class' => 'badge-inactive'],
    ];
    $badge = $badgeMap[$pembayaran->status] ?? ['label' => ucfirst($pembayaran->status), 'class' => 'badge-neutral'];

    $tahapLabel = [
        'dp'        => 'DP 50%',
        'pelunasan' => 'Pelunasan',
        'langsung'  => 'Lunas',
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">#{{ $pembayaran->kode_transaksi }}</h1>
            <p class="admin-subtitle mt-1 text-sm">Detail transaksi pembayaran pelanggan via Midtrans.</p>
        </div>
        <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-3">

        {{-- Bukti Pembayaran --}}
        <div class="admin-card p-5 xl:col-span-2 space-y-4">
            <h2 class="admin-title text-xl">Informasi Transaksi</h2>

            @if($pembayaran->metode_pembayaran === 'midtrans')
                <div class="flex min-h-[280px] items-center justify-center rounded-3xl border border-dashed border-blue-200 bg-blue-50">
                    <div class="text-center space-y-2 p-6">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white border border-blue-200 mb-3">
                            <i data-lucide="credit-card" class="h-7 w-7 text-blue-500"></i>
                        </div>
                        <p class="font-semibold text-blue-800">Pembayaran via Midtrans</p>
                        <p class="text-sm text-blue-600">Pembayaran ini diproses otomatis melalui Midtrans.<br>Tidak ada bukti upload manual.</p>
                        @if($pembayaran->gateway_transaction_id)
                            <p class="text-xs text-blue-500 mt-2">Transaction ID: <strong>{{ $pembayaran->gateway_transaction_id }}</strong></p>
                        @endif
                    </div>
                </div>
            @elseif($pembayaran->buktiUrl)
                @if(str_ends_with(strtolower($pembayaran->bukti_pembayaran_path ?? ''), '.pdf'))
                    <div class="flex items-center justify-center rounded-3xl border border-dashed border-[#E2D4C0] bg-[#FAF3E0] p-10">
                        <div class="text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white border border-[#E2D4C0] shadow-sm mb-4">
                                <i data-lucide="file-text" class="h-8 w-8 text-[#C8960C]"></i>
                            </div>
                            <p class="font-semibold text-[#4A2E28] mb-3">Bukti pembayaran berformat PDF</p>
                            <a href="{{ $pembayaran->buktiUrl }}" target="_blank"
                               class="admin-btn-primary inline-block">Buka PDF</a>
                        </div>
                    </div>
                @else
                    <div x-data="{ open: false }">
                        <div class="rounded-3xl overflow-hidden border border-[#E2D4C0] bg-[#FAF3E0] cursor-zoom-in"
                             @click="open = true" title="Klik untuk perbesar">
                            <img src="{{ $pembayaran->buktiUrl }}" alt="Bukti Transfer"
                                 class="w-full object-contain max-h-[420px]">
                        </div>
                        <p class="text-xs text-[#4A2E28]/60 mt-2 text-center">Klik gambar untuk memperbesar</p>

                        <div x-show="open" x-cloak
                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                             @click.self="open = false"
                             x-transition>
                            <div class="relative max-w-4xl w-full">
                                <button @click="open = false"
                                        class="absolute -top-10 right-0 text-white text-3xl font-bold leading-none hover:text-gray-300">&times;</button>
                                <img src="{{ $pembayaran->buktiUrl }}" alt="Bukti Transfer"
                                     class="w-full rounded-2xl object-contain max-h-[85vh]">
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="flex min-h-[280px] items-center justify-center rounded-3xl border border-dashed border-[#E2D4C0] bg-[#FAF3E0]">
                    <div class="text-center">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white border border-[#E2D4C0] mb-3">
                            <i data-lucide="image-off" class="h-7 w-7 text-[#E2D4C0]"></i>
                        </div>
                        <p class="mt-2 font-semibold text-[#4A2E28]">Belum ada bukti yang diupload</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Panel kanan --}}
        <div class="space-y-5">

            {{-- Info Pembayaran --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Informasi Pembayaran</h2>
                <div class="space-y-3 text-sm">
                    <p>
                        <span class="admin-muted">Pesanan</span><br>
                        <strong>#{{ $pembayaran->pemesanan?->kode_pemesanan ?? '-' }}</strong>
                    </p>
                    <p>
                        <span class="admin-muted">Customer</span><br>
                        <strong>{{ $pembayaran->pemesanan?->nama_pemesan ?? $pembayaran->pemesanan?->user?->nama ?? '-' }}</strong>
                    </p>
                    <p>
                        <span class="admin-muted">No. HP</span><br>
                        <strong>{{ $pembayaran->pemesanan?->no_hp ?? $pembayaran->pemesanan?->user?->no_hp ?? '-' }}</strong>
                    </p>
                    <hr class="admin-divider">
                    <p>
                        <span class="admin-muted">Metode</span><br>
                        <strong>{{ $pembayaran->metode_pembayaran === 'midtrans' ? 'Midtrans (Online)' : 'Transfer Manual' }}</strong>
                    </p>
                    <p>
                        <span class="admin-muted">Tahap</span><br>
                        <strong>{{ $tahapLabel[$pembayaran->tahap] ?? $pembayaran->tahap }}</strong>
                    </p>
                    <p>
                        <span class="admin-muted">Jumlah</span><br>
                        <strong class="text-[#4A0F1A] text-base">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong>
                    </p>
                    <p>
                        <span class="admin-muted">Dikirim pada</span><br>
                        <strong>{{ $pembayaran->dibayar_pada?->format('d M Y, H.i') ?? '-' }}</strong>
                    </p>
                    @if($pembayaran->status === 'terverifikasi')
                        <hr class="admin-divider">
                        <p>
                            <span class="admin-muted">Diverifikasi oleh</span><br>
                            <strong>{{ $pembayaran->diverifikasiOleh?->nama ?? 'Admin' }}</strong>
                        </p>
                        <p>
                            <span class="admin-muted">Pada</span><br>
                            <strong>{{ $pembayaran->diverifikasi_pada?->format('d M Y, H.i') ?? '-' }}</strong>
                        </p>
                    @endif
                    @if($pembayaran->status === 'ditolak' && $pembayaran->catatan_penolakan)
                        <hr class="admin-divider">
                        <p>
                            <span class="admin-muted">Alasan Penolakan</span><br>
                            <span class="text-red-600 font-medium">{{ $pembayaran->catatan_penolakan }}</span>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Status --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Status Transaksi</h2>

                @if($pembayaran->status === 'terverifikasi')
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-2xl px-4 py-3">
                        <i data-lucide="check-circle" class="h-5 w-5 text-green-600 shrink-0"></i>
                        <p class="text-sm font-semibold text-green-800">Pembayaran berhasil diproses</p>
                    </div>
                @elseif($pembayaran->status === 'menunggu')
                    @if($pembayaran->metode_pembayaran === 'manual')
                        <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-2xl px-4 py-3">
                            <i data-lucide="clock" class="h-5 w-5 text-yellow-600 shrink-0"></i>
                            <p class="text-sm font-semibold text-yellow-800">Menunggu verifikasi Admin</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 mt-4">
                            <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full btn bg-green-600 text-white py-2.5 rounded-xl hover:bg-green-700 font-semibold shadow-sm transition">Verifikasi Bukti</button>
                            </form>
                            
                            <button type="button" x-data @click="document.getElementById('modalTolak').classList.remove('hidden')" class="w-full sm:w-auto btn bg-red-100 text-red-700 py-2.5 px-6 rounded-xl hover:bg-red-200 font-semibold transition border border-red-200">Tolak</button>
                        </div>

                        {{-- Modal Tolak --}}
                        <div id="modalTolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl border border-[#E2D4C0]">
                                <h3 class="text-lg font-serif font-bold text-[#4A0F1A] mb-1">Tolak Pembayaran</h3>
                                <p class="text-sm text-gray-500 mb-4">Berikan alasan mengapa bukti ini ditolak.</p>
                                <form action="{{ route('admin.pembayaran.tolak', $pembayaran->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <textarea name="catatan_penolakan" class="w-full border-[#E2D4C0] rounded-xl p-3 focus:ring-[#C8960C] focus:border-[#C8960C] text-sm" rows="3" required placeholder="Contoh: Bukti transfer buram atau tidak valid"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('modalTolak').classList.add('hidden')" class="px-5 py-2 rounded-xl text-gray-600 hover:bg-gray-100 font-medium transition">Batal</button>
                                        <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 font-medium shadow transition">Tolak Pembayaran</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @else
                        <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-2xl px-4 py-3">
                            <i data-lucide="clock" class="h-5 w-5 text-yellow-600 shrink-0"></i>
                            <p class="text-sm font-semibold text-yellow-800">Menunggu pembayaran via Midtrans</p>
                        </div>
                    @endif
                @elseif($pembayaran->status === 'ditolak')
                    <div class="flex items-center gap-2 bg-red-50 border border-red-200 rounded-2xl px-4 py-3">
                        <i data-lucide="x-circle" class="h-5 w-5 text-red-600 shrink-0"></i>
                        <p class="text-sm font-semibold text-red-800">Pembayaran dibatalkan / kadaluarsa</p>
                    </div>
                @endif

                <a href="{{ route('admin.pembayaran.index') }}" class="admin-btn-secondary w-full mt-3 block text-center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
