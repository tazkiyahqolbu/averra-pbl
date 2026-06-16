@extends('admin.layouts.app')

@section('title', 'Testimoni')

@section('content')
@php
    $testimoni = [
        [
            'rating' => 5,
            'nama' => 'Tazkiyah Qolbu',
            'item' => 'Paket Gold Wedding',
            'tanggal' => '10 Juni 2026',
            'ulasan' => 'Pelayanan sangat memuaskan, dekorasi cantik sekali! Sangat direkomendasikan untuk yang mau nikah.',
        ],
        [
            'rating' => 4,
            'nama' => 'Siti Rahmah',
            'item' => 'Sewa Kamera Canon',
            'tanggal' => '8 Juni 2026',
            'ulasan' => 'Kamera dalam kondisi baik, proses mudah.',
        ],
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Testimoni Customer</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Halaman ini hanya untuk memantau ulasan pelanggan. Tidak ada fitur publish atau sembunyikan.
        </p>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label class="admin-label">Filter Rating</label>
                <select class="admin-select">
                    <option>Semua</option>
                    <option>5 Bintang</option>
                    <option>4 Bintang</option>
                    <option>3 Bintang</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Bulan</label>
                <select class="admin-select">
                    <option>Semua</option>
                    <option>Juni 2026</option>
                    <option>Mei 2026</option>
                </select>
            </div>

            <div class="rounded-2xl bg-[#fff8ed] p-4">
                <p class="admin-muted text-sm">Rata-rata Rating</p>
                <p class="font-heading text-2xl font-bold text-gray-900">⭐ 4.7 dari 23 ulasan</p>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($testimoni as $item)
            <div class="admin-card p-5">
                <div class="mb-2 flex flex-wrap items-center gap-2">
                    <span class="text-lg">
                        {{ str_repeat('⭐', $item['rating']) }}{{ str_repeat('☆', 5 - $item['rating']) }}
                    </span>
                    <strong class="text-gray-900">{{ $item['nama'] }}</strong>
                </div>

                <p class="admin-muted text-sm">{{ $item['item'] }} | {{ $item['tanggal'] }}</p>
                <p class="mt-3 text-sm leading-6 text-gray-700">
                    “{{ $item['ulasan'] }}”
                </p>
            </div>
        @endforeach
    </div>
</div>
@endsection
