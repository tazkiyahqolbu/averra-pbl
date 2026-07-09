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

    $totalHarga    = $pembayaran->pemesanan?->total_harga ?? 0;
    $totalDibayar  = $pembayaran->pemesanan
        ? $pembayaran->pemesanan->pembayarans()->where('status', 'terverifikasi')->sum('jumlah_bayar')
        : 0;
    $sisaPelunasan = max(0, $totalHarga - $totalDibayar);
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
                @php
                    $paymentTypeLabels = [
                        'bank_transfer' => 'Transfer Bank (Virtual Account)',
                        'echannel'      => 'Mandiri Bill Payment',
                        'gopay'         => 'GoPay',
                        'qris'          => 'QRIS',
                        'credit_card'   => 'Kartu Kredit/Debit',
                        'cstore'        => 'Convenience Store',
                        'shopeepay'     => 'ShopeePay',
                        'akulaku'       => 'Akulaku PayLater',
                    ];
                    $paymentTypeLabel = $paymentTypeLabels[$pembayaran->payment_type] ?? ($pembayaran->payment_type ? ucwords(str_replace('_', ' ', $pembayaran->payment_type)) : null);
                @endphp
                <div class="flex min-h-[280px] items-center justify-center rounded-3xl border border-dashed border-blue-200 bg-blue-50">
                    <div class="text-center space-y-2 p-6">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white border border-blue-200 mb-3">
                            <i data-lucide="credit-card" class="h-7 w-7 text-blue-500"></i>
                        </div>
                        <p class="font-semibold text-blue-800">Pembayaran via Midtrans</p>

                        @if($paymentTypeLabel)
                            <p class="text-sm text-blue-700">
                                Metode: <strong>{{ $paymentTypeLabel }}</strong>
                                @if($pembayaran->bank)
                                    ({{ strtoupper($pembayaran->bank) }})
                                @endif
                            </p>
                            @if($pembayaran->va_number)
                                <p class="text-sm text-blue-700">No. Virtual Account: <strong>{{ $pembayaran->va_number }}</strong></p>
                            @endif
                        @else
                            <p class="text-sm text-blue-600">Menunggu pembayaran diproses oleh Midtrans.</p>
                        @endif

                        @if($pembayaran->gateway_transaction_id)
                            <p class="text-xs text-blue-500 mt-2">Transaction ID: <strong>{{ $pembayaran->gateway_transaction_id }}</strong></p>
                        @endif
                    </div>
                </div>
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
                    @if($sisaPelunasan > 0)
                        <p>
                            <span class="admin-muted">Sisa Pelunasan</span><br>
                            <strong class="text-amber-600 text-base">Rp {{ number_format($sisaPelunasan, 0, ',', '.') }}</strong>
                        </p>
                    @endif
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
                    <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-2xl px-4 py-3">
                        <i data-lucide="clock" class="h-5 w-5 text-yellow-600 shrink-0"></i>
                        <p class="text-sm font-semibold text-yellow-800">Menunggu pembayaran via Midtrans</p>
                    </div>
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
