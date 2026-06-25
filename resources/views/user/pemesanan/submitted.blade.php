<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Diterima — SILART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-[#FAF3E0]" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

@php
    $detail      = $pesanan->detailPemesanans->first();
    $namaItem    = $detail?->barang?->nama_barang
                ?? $detail?->jasa?->nama_jasa
                ?? $detail?->paket?->nama_paket
                ?? '-';
    $pembayaran  = $pesanan->pembayarans->first();
    $isTahapLunas = $pembayaran && $pembayaran->tahap === 'langsung';
    $jumlahBayar  = $pembayaran ? (float) $pembayaran->jumlah_bayar : (float) $pesanan->total_harga * 0.5;
@endphp

<div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">

    {{-- Logo kecil di atas --}}
    <a href="{{ route('user.dashboard.index') }}" class="mb-8 flex items-center gap-2.5 group">
        <div class="flex h-9 w-9 items-center justify-center rounded-full border border-[#C8960C]/50 bg-[#4A0F1A]/5 group-hover:bg-[#4A0F1A]/10 transition">
            <span class="font-serif text-base font-bold italic text-[#C8960C]">S</span>
        </div>
        <span class="font-serif text-base font-bold tracking-[0.2em] text-[#4A0F1A]">SILART</span>
    </a>

    {{-- Card utama --}}
    <div class="w-full max-w-lg rounded-3xl border border-[#E2D4C0] bg-white shadow-[0_8px_32px_rgba(74,15,26,0.08)] overflow-hidden">

        {{-- Top accent stripe --}}
        <div class="h-1.5 bg-gradient-to-r from-[#6B1625] via-[#C8960C] to-[#3A0A12]"></div>

        <div class="p-8 sm:p-10">

            {{-- Icon animasi --}}
            <div class="mb-6 flex justify-center">
                <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-amber-50 border-2 border-amber-200">
                    {{-- Lingkaran berputar di sekeliling --}}
                    <svg class="absolute inset-0 h-full w-full" style="animation: spin 3s linear infinite;" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="36" stroke="#F59E0B" stroke-width="2.5"
                                stroke-dasharray="12 8" stroke-linecap="round"/>
                    </svg>
                    <i data-lucide="clock" class="relative h-9 w-9 text-amber-500"></i>
                </div>
            </div>
            <style>
                @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
            </style>

            {{-- Judul --}}
            <div class="text-center mb-6">
                <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-[#C8960C] mb-2">PESANAN DITERIMA</p>
                <h1 class="font-serif text-3xl font-light text-[#4A0F1A] leading-tight">
                    Menunggu Konfirmasi<br><em class="not-italic font-medium">Admin</em>
                </h1>
                <p class="mt-3 text-sm text-[#4A2E28]/70 leading-relaxed">
                    Pesanan kamu sudah kami terima. Tim kami akan meninjau dan mengkonfirmasi dalam <strong class="text-[#4A0F1A]">1&times;24 jam</strong>.
                </p>
            </div>

            {{-- Divider --}}
            <div class="my-5 flex items-center gap-3">
                <div class="flex-1 h-px bg-[#E2D4C0]"></div>
                <span class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]/60">Ringkasan</span>
                <div class="flex-1 h-px bg-[#E2D4C0]"></div>
            </div>

            {{-- Info pesanan --}}
            <div class="rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-5 space-y-3 text-sm mb-6">
                <div class="flex items-center justify-between">
                    <span class="text-[#4A2E28]/60">No. Pesanan</span>
                    <span class="font-semibold text-[#4A0F1A] font-mono tracking-wide">{{ $pesanan->kode_pemesanan }}</span>
                </div>
                <div class="h-px bg-[#E2D4C0]"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[#4A2E28]/60">Layanan</span>
                    <span class="font-semibold text-[#4A0F1A] text-right max-w-[60%]">{{ $namaItem }}</span>
                </div>
                <div class="h-px bg-[#E2D4C0]"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[#4A2E28]/60">Jenis</span>
                    <span class="font-semibold text-[#4A0F1A]">{{ $pesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara' }}</span>
                </div>
                @if($pesanan->tanggal_pakai)
                    <div class="h-px bg-[#E2D4C0]"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#4A2E28]/60">Tanggal</span>
                        <span class="font-semibold text-[#4A0F1A]">{{ $pesanan->tanggal_pakai->format('d F Y') }}</span>
                    </div>
                @endif
                <div class="h-px bg-[#E2D4C0]"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[#4A2E28]/60">Total</span>
                    <span class="font-serif font-semibold text-[#C8960C] text-base">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="h-px bg-[#E2D4C0]"></div>
                <div class="flex items-center justify-between">
                    <span class="text-[#4A2E28]/60">{{ $isTahapLunas ? 'Dibayar Lunas' : 'DP yang Dibayar' }}</span>
                    <span class="font-semibold text-[#4A0F1A]">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Status chip --}}
            <div class="mb-6 flex items-center gap-2.5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                <span class="h-2 w-2 rounded-full bg-amber-400 shrink-0 animate-pulse"></span>
                <p class="text-xs font-semibold text-amber-700">Status: Menunggu konfirmasi admin</p>
            </div>

            {{-- Tombol aksi --}}
            <div class="space-y-3">
                <a href="{{ route('user.pemesanan.show', $pesanan->id) }}"
                   class="flex items-center justify-center gap-2 w-full rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.42)] hover:from-[#7B1C2E] transition-all duration-200">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    Lihat Detail Pesanan
                </a>
                <a href="{{ route('user.pemesanan.index') }}"
                   class="flex items-center justify-center gap-2 w-full rounded-full border border-[#4A0F1A]/25 bg-white px-6 py-3 text-sm font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
                    <i data-lucide="clipboard-list" class="h-4 w-4"></i>
                    Semua Pesanan Saya
                </a>
                <a href="{{ route('public.beranda') }}"
                   class="flex items-center justify-center gap-2 w-full rounded-full px-6 py-3 text-sm font-medium text-[#4A2E28]/60 hover:text-[#4A0F1A] transition-colors duration-200">
                    <i data-lucide="home" class="h-4 w-4"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    {{-- Footer hint --}}
    <p class="mt-6 text-center text-xs text-[#4A2E28]/40">
        Kamu bisa cek status pesanan kapan saja melalui menu <strong class="text-[#4A2E28]/60">Pemesanan</strong> di dashboard.
    </p>

</div>

<script>
    window.addEventListener('load', () => { lucide.createIcons(); });
</script>
</body>
</html>
