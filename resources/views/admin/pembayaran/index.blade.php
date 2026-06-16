@extends('admin.layouts.app')

@section('title', 'Pembayaran')

@section('content')
@php
    $payments = [
        [
            'kode' => 'PAY-20260611-001',
            'status' => 'Menunggu Verifikasi',
            'pesanan' => 'AVR-20260610-001',
            'customer' => 'Tazkiyah Qolbu',
            'tahap' => 'DP 50%',
            'jumlah' => 'Rp 2.750.000',
            'dikirim' => '11 Juni 2026, 14.22',
        ],
        [
            'kode' => 'PAY-20260612-002',
            'status' => 'Menunggu Verifikasi',
            'pesanan' => 'AVR-20260611-002',
            'customer' => 'Siti Rahmah',
            'tahap' => 'Lunas',
            'jumlah' => 'Rp 300.000',
            'dikirim' => '12 Juni 2026, 10.05',
        ],
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Pembayaran</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Verifikasi pembayaran DP, pelunasan, dan bukti transfer pelanggan.
        </p>
    </div>

    <div class="admin-card p-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach (['Semua', 'Menunggu Verifikasi (2)', 'Terverifikasi', 'Ditolak'] as $tab)
                <button class="rounded-full border border-[#decba5] px-4 py-2 font-semibold text-[#5A0B1A] hover:bg-[#f7efe2]">
                    {{ $tab }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($payments as $payment)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-heading text-xl font-bold text-gray-900">#{{ $payment['kode'] }}</h2>
                            <span class="badge-warning">{{ $payment['status'] }}</span>
                        </div>

                        <p class="text-sm text-gray-700">Pesanan: #{{ $payment['pesanan'] }} | 👤 {{ $payment['customer'] }}</p>
                        <p class="text-sm text-gray-700">Tahap: {{ $payment['tahap'] }} | Jumlah: {{ $payment['jumlah'] }}</p>
                        <p class="text-xs text-[#7a5d58]">Dikirim: {{ $payment['dikirim'] }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.pembayaran.show') }}" class="admin-btn-secondary">Lihat Bukti Bayar</a>
                        <button class="admin-btn-primary">Verifikasi</button>
                        <button class="admin-btn-danger">Tolak</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
