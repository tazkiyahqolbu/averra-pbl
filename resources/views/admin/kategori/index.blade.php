@extends('admin.layouts.app')

@section('title', 'Kategori Barang')

@section('content')
@php
    $kategoriBarangs = [
        [
            'nama' => 'Kostum Tari',
            'deskripsi' => 'Kategori untuk pakaian dan kostum pertunjukan tari.',
            'jumlah_barang' => 10,
        ],
        [
            'nama' => 'Properti Tari',
            'deskripsi' => 'Kategori untuk properti pendukung pertunjukan.',
            'jumlah_barang' => 7,
        ],
        [
            'nama' => 'Properti Musik',
            'deskripsi' => 'Kategori untuk alat musik tradisional dan pendukung acara.',
            'jumlah_barang' => 5,
        ],
    ];
@endphp

<div class="space-y-6">
    <div>
        <h1 class="admin-title text-3xl">Kategori Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk kostum dan properti.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-1">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Kategori</h2>

            <form action="#" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="nama" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="Contoh: Kostum Tari">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="Deskripsi kategori..."></textarea>
                </div>

                <button type="submit" class="w-full rounded-xl bg-[#5A0B1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#7B1C2E]">
                    Simpan Kategori
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:col-span-2">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Jumlah Barang</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($kategoriBarangs as $kategori)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $kategori['nama'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $kategori['deskripsi'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $kategori['jumlah_barang'] }}</td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
