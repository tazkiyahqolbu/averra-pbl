@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
@php
    $pembayaran = [
        'kode_transaksi' => 'TRX-20260613-001',
        'kode_pemesanan' => 'PM-20260613-001',
        'pelanggan' => 'Nur Aisyah',
        'tahap' => 'dp',
        'persen_dp' => 30,
        'jumlah_bayar' => 1050000,
        'dibayar_pada' => '2026-06-13 10:15:00',
        'metode_pembayaran' => 'Transfer BRI',
        'status' => 'menunggu',
        'bukti_pembayaran_path' => null,
        'catatan_penolakan' => null,
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <p class="admin-subtitle text-sm font-semibold uppercase tracking-[0.25em]">Detail Pembayaran</p>
            <h1 class="admin-title mt-2 text-3xl">{{ $pembayaran['kode_transaksi'] }}</h1>
            <p class="admin-muted mt-2 text-sm">Cek nominal dan bukti pembayaran sebelum diverifikasi.</p>
        </div>
        <a href="{{ route('admin.pembayaran.index') }}" class="admin-btn-secondary">Kembali</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="admin-card p-6 lg:col-span-2">
            <h2 class="admin-title text-xl">Bukti Pembayaran</h2>

            <div class="mt-5 admin-upload-box">
                @if ($pembayaran['bukti_pembayaran_path'])
                    <img src="{{ asset('storage/' . $pembayaran['bukti_pembayaran_path']) }}" alt="Bukti pembayaran" class="mx-auto max-h-[420px] rounded-2xl border border-[#decba5] object-contain">
                @else
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-[#f8f1e6] text-3xl">🧾</div>
                    <p class="mt-4 font-semibold text-gray-900">Preview bukti pembayaran</p>
                    <p class="admin-muted mt-1 text-sm">Nanti bagian ini akan menampilkan gambar dari <code>bukti_pembayaran_path</code>.</p>
                @endif
            </div>
        </div>

        <div class="admin-card p-6">
            <h2 class="admin-title text-xl">Ringkasan Pembayaran</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div>
                    <p class="admin-muted">Kode Pemesanan</p>
                    <p class="font-semibold text-[#4a0f1a]">{{ $pembayaran['kode_pemesanan'] }}</p>
                </div>
                <div>
                    <p class="admin-muted">Pelanggan</p>
                    <p class="font-semibold text-gray-900">{{ $pembayaran['pelanggan'] }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="admin-muted">Tahap</p>
                        <p class="font-semibold uppercase text-gray-900">{{ $pembayaran['tahap'] }}</p>
                    </div>
                    <div>
                        <p class="admin-muted">DP</p>
                        <p class="font-semibold text-gray-900">{{ $pembayaran['persen_dp'] ? $pembayaran['persen_dp'] . '%' : '-' }}</p>
                    </div>
                </div>
                <div>
                    <p class="admin-muted">Dibayar Pada</p>
                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pembayaran['dibayar_pada'])->translatedFormat('d M Y H:i') }} WIB</p>
                </div>
                <div>
                    <p class="admin-muted">Metode</p>
                    <p class="font-semibold text-gray-900">{{ $pembayaran['metode_pembayaran'] }}</p>
                </div>
                <div class="border-t border-[#decba5] pt-3">
                    <p class="admin-muted">Jumlah Bayar</p>
                    <p class="text-2xl font-bold text-[#4a0f1a]">Rp{{ number_format($pembayaran['jumlah_bayar'], 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="admin-muted">Status</span>
                    <span class="badge-warning capitalize">{{ $pembayaran['status'] }}</span>
                </div>
            </div>

            <div class="mt-6 grid gap-3">
                <button type="button" class="admin-btn-primary w-full">Terima Pembayaran</button>
                <button type="button" class="admin-btn-danger w-full">Tolak Pembayaran</button>
            </div>
        </div>
    </div>

    <div class="admin-card p-6">
        <h2 class="admin-title text-xl">Catatan Penolakan</h2>
        <form class="mt-4 grid gap-4">
            <div>
                <label class="admin-label">Alasan jika pembayaran ditolak</label>
                <textarea class="admin-textarea" placeholder="Contoh: nominal tidak sesuai atau bukti pembayaran kurang jelas."></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" class="admin-btn-secondary">Simpan Catatan</button>
            </div>
        </form>
    </div>
</section>
@endsection
