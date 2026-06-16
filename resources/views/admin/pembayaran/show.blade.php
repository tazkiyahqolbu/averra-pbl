@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">#PAY-20260611-001</h1>
            <p class="admin-subtitle mt-1 text-sm">Detail verifikasi bukti pembayaran pelanggan.</p>
        </div>

        <span class="badge-warning">Menunggu Verifikasi</span>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="admin-card p-5 xl:col-span-2">
            <h2 class="admin-title mb-4 text-xl">Bukti Pembayaran</h2>

            <div class="flex min-h-[360px] items-center justify-center rounded-3xl border border-dashed border-[#decba5] bg-[#fff8ed]">
                <div class="text-center">
                    <p class="text-5xl">🖼️</p>
                    <p class="mt-3 font-semibold text-gray-700">Preview bukti transfer</p>
                    <p class="admin-muted text-sm">Nanti gambar asli dari upload customer tampil di sini.</p>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Informasi Pembayaran</h2>
                <div class="space-y-3 text-sm">
                    <p><span class="admin-muted">Pesanan</span><br><strong>#AVR-20260610-001 — Paket Gold Wedding</strong></p>
                    <p><span class="admin-muted">Customer</span><br><strong>Tazkiyah Qolbu</strong></p>
                    <p><span class="admin-muted">Tahap</span><br><strong>DP 50%</strong></p>
                    <p><span class="admin-muted">Jumlah</span><br><strong>Rp 2.750.000</strong></p>
                    <p><span class="admin-muted">Dikirim</span><br><strong>11 Juni 2026, 14.22</strong></p>
                    <p><span class="admin-muted">Keterangan Customer</span><br><strong>Transfer via BCA</strong></p>
                </div>
            </div>

            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Aksi Admin</h2>

                <label class="admin-label">Alasan Penolakan</label>
                <textarea class="admin-textarea" placeholder="Wajib diisi jika bukti pembayaran ditolak..."></textarea>

                <div class="mt-4 space-y-2">
                    <button class="admin-btn-primary w-full">Verifikasi Pembayaran</button>
                    <button class="admin-btn-danger w-full">Tolak Pembayaran</button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="admin-btn-secondary w-full">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
