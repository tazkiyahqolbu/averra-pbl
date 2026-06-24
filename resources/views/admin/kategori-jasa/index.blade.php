@extends('admin.layouts.app')

@section('title', 'Kategori Jasa')

@section('content')
@php
    $kategori = [
        ['nama' => 'Paket Pernikahan', 'jumlah' => '5 item'],
        ['nama' => 'Hiburan', 'jumlah' => '3 item'],
        ['nama' => 'Pertunjukan', 'jumlah' => '8 item'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kategori Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk data jasa.</p>
        </div>
        <button class="admin-btn-primary">+ Tambah Kategori</button>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="admin-card p-6 xl:col-span-2">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                        <tr>
                            <th class="admin-table-th">Nama Kategori</th>
                            <th class="admin-table-th">Jumlah Item</th>
                            <th class="admin-table-th">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2D4C0]">
                        @foreach ($kategori as $item)
                            <tr>
                                <td class="admin-table-td font-semibold">{{ $item['nama'] }}</td>
                                <td class="admin-table-td">{{ $item['jumlah'] }}</td>
                                <td class="admin-table-td">
                                    <div class="flex gap-2">
                                        <button class="admin-btn-secondary py-2">Edit</button>
                                        <button class="admin-btn-danger py-2">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-card p-6">
            <h2 class="admin-title mb-4 text-xl">Form Tambah/Edit</h2>
            <label class="admin-label">Nama Kategori *</label>
            <input type="text" class="admin-input" placeholder="Nama kategori">
            <div class="mt-5 flex justify-end gap-3">
                <button class="admin-btn-secondary">Batal</button>
                <button class="admin-btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
