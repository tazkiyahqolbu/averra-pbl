@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">#AVR-20260610-001</h1>
            <p class="admin-subtitle mt-1 text-sm">Detail pemesanan pelanggan dan aksi admin.</p>
        </div>

        <span class="badge-warning">Menunggu Konfirmasi</span>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="space-y-5 xl:col-span-2">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Data Pemesan</h2>
                <div class="grid gap-3 md:grid-cols-3">
                    <p><span class="admin-muted text-sm">Nama</span><br><strong>Tazkiyah Qolbu</strong></p>
                    <p><span class="admin-muted text-sm">Email</span><br><strong>tazkiyah@email.com</strong></p>
                    <p><span class="admin-muted text-sm">No. HP</span><br><strong>081234567890</strong></p>
                </div>
            </div>

            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Detail Pesanan</h2>
                <div class="grid gap-3 md:grid-cols-2">
                    <p><span class="admin-muted text-sm">Jenis</span><br><strong>Acara</strong></p>
                    <p><span class="admin-muted text-sm">Item</span><br><strong>Paket Gold Wedding</strong></p>
                    <p><span class="admin-muted text-sm">Tanggal</span><br><strong>25 Juni 2026</strong></p>
                    <p><span class="admin-muted text-sm">Lokasi</span><br><strong>Zona B — Jl. Contoh No.1, Padang</strong></p>
                </div>

                <div class="mt-4">
                    <p class="admin-muted text-sm">Catatan</p>
                    <p class="rounded-2xl bg-[#fff8ed] p-4 text-sm text-gray-700">
                        Tema rustic, outdoor.
                    </p>
                </div>
            </div>

            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Rincian Harga</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span>Paket Gold Wedding</span>
                        <strong>Rp 5.000.000</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkos Lokasi Zona B</span>
                        <strong>Rp 500.000</strong>
                    </div>
                    <hr class="admin-divider">
                    <div class="flex justify-between text-lg">
                        <strong>Total</strong>
                        <strong>Rp 5.500.000</strong>
                    </div>
                    <p class="admin-muted text-sm">Metode Bayar: DP 50% (Rp 2.750.000) + Pelunasan</p>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Riwayat Status</h2>
                <div class="space-y-3 text-sm">
                    <div class="rounded-2xl bg-[#fff8ed] p-3">
                        <strong>10 Jun 2026 20.33</strong>
                        <p class="admin-muted">Pesanan masuk</p>
                    </div>
                    <p class="admin-muted">Belum ada aksi admin.</p>
                </div>
            </div>

            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Aksi Admin</h2>

                <label class="admin-label">Catatan untuk Customer</label>
                <textarea class="admin-textarea" placeholder="Isi alasan jika pesanan ditolak atau pesan tambahan jika dikonfirmasi..."></textarea>

                <div class="mt-4 space-y-2">
                    <button class="admin-btn-primary w-full">Konfirmasi Pesanan</button>
                    <button class="admin-btn-danger w-full">Tolak Pesanan</button>
                    <a href="{{ route('admin.pemesanan.index') }}" class="admin-btn-secondary w-full">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
