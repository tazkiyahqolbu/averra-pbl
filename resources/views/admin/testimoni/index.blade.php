@extends('admin.layouts.app')

@section('title', 'Testimoni')

@section('content')
@php
    $testimonis = [
        ['nama' => 'Nadia Putri', 'pemesanan' => 'PMS-001', 'isi' => 'Pelayanan sangat baik, kostum rapi, dan penampilan tari sangat memeriahkan acara.', 'rating' => 5, 'dipublikasikan' => true, 'dibalas' => 'Terima kasih atas kepercayaannya.'],
        ['nama' => 'Riko Saputra', 'pemesanan' => 'PMS-002', 'isi' => 'Tim datang tepat waktu dan acara berjalan lancar.', 'rating' => 4, 'dipublikasikan' => false, 'dibalas' => null],
        ['nama' => 'Maya Sari', 'pemesanan' => 'PMS-003', 'isi' => 'Sangat puas dengan paket pernikahan yang disediakan.', 'rating' => 5, 'dipublikasikan' => true, 'dibalas' => null],
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-2xl">Testimoni</h1>
            <p class="admin-subtitle mt-1">Kelola ulasan pelanggan sebelum ditampilkan pada halaman publik.</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Total Testimoni</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ count($testimonis) }}</p>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Dipublikasikan</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">2</p>
        </div>
        <div class="admin-card p-5">
            <p class="admin-muted text-sm">Menunggu Review</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">1</p>
        </div>
    </div>

    <div class="admin-card p-4">
        <div class="admin-filter-grid md:grid-cols-3">
            <input type="text" class="admin-input" placeholder="Cari nama pelanggan...">
            <select class="admin-select">
                <option>Semua Status</option>
                <option>Dipublikasikan</option>
                <option>Belum Dipublikasikan</option>
            </select>
            <select class="admin-select">
                <option>Semua Rating</option>
                <option>5 Bintang</option>
                <option>4 Bintang</option>
                <option>3 Bintang</option>
            </select>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($testimonis as $testimoni)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#ead8b8] font-bold text-[#5A0B1A]">
                            {{ strtoupper(substr($testimoni['nama'], 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-semibold text-gray-900">{{ $testimoni['nama'] }}</h2>
                                <span class="badge-neutral">{{ $testimoni['pemesanan'] }}</span>
                                <span class="{{ $testimoni['dipublikasikan'] ? 'badge-active' : 'badge-warning' }}">
                                    {{ $testimoni['dipublikasikan'] ? 'Dipublikasikan' : 'Menunggu Review' }}
                                </span>
                            </div>

                            <p class="mt-1 text-sm text-[#c8a84e]">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $testimoni['rating'] ? '★' : '☆' }}
                                @endfor
                            </p>

                            <p class="mt-3 text-sm leading-6 text-gray-700">{{ $testimoni['isi'] }}</p>

                            @if ($testimoni['dibalas'])
                                <div class="mt-3 rounded-2xl border border-[#decba5] bg-[#fff8ed] p-3 text-sm text-gray-700">
                                    <span class="font-semibold text-[#5A0B1A]">Balasan Admin:</span>
                                    {{ $testimoni['dibalas'] }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex shrink-0 flex-wrap gap-2 lg:justify-end">
                        <button type="button" class="admin-btn-secondary">Balas</button>
                        <button type="button" class="admin-btn-primary">
                            {{ $testimoni['dipublikasikan'] ? 'Sembunyikan' : 'Publikasikan' }}
                        </button>
                        <a href="#" class="admin-btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
