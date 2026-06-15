@extends('admin.layouts.app')

@section('title', 'Blokir Tanggal')

@section('content')
@php
    $blockedDates = [
        ['tanggal' => '17 Agustus 2026', 'berlaku' => 'Semua Layanan', 'alasan' => 'Hari Libur'],
        ['tanggal' => '20 Juni 2026', 'berlaku' => 'Kamera Canon EOS', 'alasan' => 'Perawatan'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Blokir Tanggal</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Atur tanggal yang tidak tersedia untuk semua layanan atau item tertentu.
            </p>
        </div>

        <button class="admin-btn-primary">+ Tambah Blokir</button>
    </div>

    <div class="admin-card p-6">
        <div class="mb-5 max-w-sm">
            <label class="admin-label">Berlaku Untuk</label>
            <select class="admin-select">
                <option>Semua Layanan</option>
                <option>Item Tertentu</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-[#decba5] bg-[#f9f1e6]">
                    <tr>
                        <th class="admin-table-th">Tanggal</th>
                        <th class="admin-table-th">Berlaku Untuk</th>
                        <th class="admin-table-th">Alasan</th>
                        <th class="admin-table-th">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#decba5]">
                    @foreach ($blockedDates as $date)
                        <tr>
                            <td class="admin-table-td font-semibold">{{ $date['tanggal'] }}</td>
                            <td class="admin-table-td">{{ $date['berlaku'] }}</td>
                            <td class="admin-table-td">{{ $date['alasan'] }}</td>
                            <td class="admin-table-td">
                                <button class="admin-btn-danger py-2">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr class="admin-divider my-6">

        <h2 class="admin-title mb-4 text-xl">Form Tambah Blokir</h2>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="admin-label">Tanggal *</label>
                <input type="date" class="admin-input">
            </div>

            <div>
                <label class="admin-label">Berlaku Untuk *</label>
                <select class="admin-select">
                    <option>Semua Layanan</option>
                    <option>Item Tertentu</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Alasan</label>
                <input type="text" class="admin-input" placeholder="Contoh: Hari Libur / Perawatan">
            </div>
        </div>

        <div class="mt-5 flex justify-end gap-3">
            <button class="admin-btn-secondary">Batal</button>
            <button class="admin-btn-primary">Simpan</button>
        </div>
    </div>
</div>
@endsection
