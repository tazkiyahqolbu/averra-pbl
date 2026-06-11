@extends('admin.layouts.app')

@section('title', 'Edit Barang')

@section('content')
@php
    $kategoriBarangs = ['Kostum Tari', 'Properti Tari', 'Properti Musik'];

    $barang = [
        'nama_barang' => 'Baju Tari Piring',
        'kategori' => 'Kostum Tari',
        'deskripsi' => 'Kostum tradisional untuk pertunjukan tari piring.',
        'harga' => 150000,
        'nilai_barang' => 500000,
        'stok' => 8,
        'aktif' => true,
    ];
@endphp

<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Barang</h1>
        <p class="text-sm text-gray-500">Perbarui data katalog barang.</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ $barang['nama_barang'] }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Kategori Barang</label>
                <select name="kategori_barang_id" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
                    @foreach ($kategoriBarangs as $kategori)
                        <option value="{{ $kategori }}" @selected($barang['kategori'] === $kategori)>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa</label>
                <input type="number" name="harga" value="{{ $barang['harga'] }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Nilai Barang</label>
                <input type="number" name="nilai_barang" value="{{ $barang['nilai_barang'] }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" value="{{ $barang['stok'] }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Ganti Thumbnail</label>
                <input type="file" name="thumbnail_path" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">{{ $barang['deskripsi'] }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" @checked($barang['aktif']) class="rounded border-gray-300 text-[#5A0B1A]">
                    <span class="text-sm font-medium text-gray-700">Barang aktif ditampilkan</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Kembali
            </a>

            <button type="submit" class="rounded-xl bg-[#5A0B1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#7B1C2E]">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
