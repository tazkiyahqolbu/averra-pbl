@extends('admin.layouts.app')

@section('title', 'Pembayaran')

@section('content')
@php
    $statusAktif = request('status', 'semua');
    $statusMap = [
        'semua'        => 'Semua',
        'menunggu'     => 'Menunggu Pembayaran',
        'terverifikasi'=> 'Berhasil',
        'ditolak'      => 'Dibatalkan / Gagal',
    ];
    $badgeMap = [
        'menunggu'      => 'badge-warning',
        'terverifikasi' => 'badge-active',
        'ditolak'       => 'badge-inactive',
    ];
    $tahapLabel = [
        'dp'        => 'DP 50%',
        'pelunasan' => 'Pelunasan',
        'langsung'  => 'Lunas',
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Pembayaran</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Riwayat transaksi pembayaran pelanggan via Midtrans.
        </p>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter tabs --}}
    <div class="admin-card p-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach($statusMap as $key => $label)
                <a href="{{ route('admin.pembayaran.index', ['status' => $key]) }}"
                   class="rounded-full border px-4 py-2 font-semibold transition
                          {{ $statusAktif === $key
                              ? 'border-transparent bg-gradient-to-br from-[#6B1625] to-[#3A0A12] text-white shadow-[0_3px_10px_rgba(74,15,26,0.3)]'
                              : 'border-[#E2D4C0] text-[#4A0F1A] hover:bg-[#FAF3E0]' }}">
                    {{ $label }}
                    @if($key === 'menunggu' && $countMenunggu > 0)
                        <span class="ml-1 bg-red-500 text-white rounded-full px-1.5 py-0.5 text-xs">{{ $countMenunggu }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- List pembayaran --}}
    @if($pembayarans->isEmpty())
        <div class="admin-card p-10 text-center">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#FAF3E0] border border-[#E2D4C0] mb-3">
                <i data-lucide="credit-card" class="h-6 w-6 text-[#C8960C]/60"></i>
            </div>
            <p class="font-semibold text-[#4A0F1A]">Belum ada bukti pembayaran</p>
            <p class="admin-muted text-sm mt-1">Bukti akan muncul setelah customer mengupload.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pembayarans as $pembayaran)
                @php
                    $badge = $badgeMap[$pembayaran->status] ?? 'badge-neutral';
                    $statusLabel = match($pembayaran->status) {
                        'menunggu'      => 'Menunggu Pembayaran',
                        'terverifikasi' => 'Berhasil',
                        'ditolak'       => 'Dibatalkan / Gagal',
                        default         => ucfirst($pembayaran->status),
                    };
                @endphp
                <div class="admin-card p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-lg font-bold text-[#4A0F1A]">#{{ $pembayaran->kode_transaksi }}</h2>
                                <span class="{{ $badge }}">{{ $statusLabel }}</span>
                            </div>
                            <p class="text-sm text-[#4A2E28]">
                                Pesanan: <strong>#{{ $pembayaran->pemesanan?->kode_pemesanan ?? '-' }}</strong>
                                &nbsp;|&nbsp; <i data-lucide="user" class="inline h-3.5 w-3.5 align-text-bottom text-[#4A2E28]/50"></i> <strong>{{ $pembayaran->pemesanan?->nama_pemesan ?? $pembayaran->pemesanan?->user?->nama ?? '-' }}</strong>
                            </p>
                            <p class="text-sm text-[#4A2E28]">
                                Tahap: <strong>{{ $tahapLabel[$pembayaran->tahap] ?? $pembayaran->tahap }}</strong>
                                &nbsp;|&nbsp; Jumlah: <strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong>
                            </p>
                            <p class="text-xs text-[#4A2E28]">
                                Dikirim: {{ $pembayaran->dibayar_pada?->format('d M Y, H.i') ?? '-' }}
                            </p>
                            @if($pembayaran->status === 'ditolak' && $pembayaran->catatan_penolakan)
                                <p class="text-xs text-red-600 bg-red-50 rounded-lg px-3 py-1.5 border border-red-100">
                                    Alasan ditolak: {{ $pembayaran->catatan_penolakan }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2 lg:flex-col lg:items-end">
                            <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}"
                               class="admin-btn-secondary text-sm">Lihat Detail</a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
