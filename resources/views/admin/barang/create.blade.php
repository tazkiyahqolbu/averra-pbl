@extends('admin.layouts.app')

@section('title', 'Tambah Barang')

@section('content')
@php
    $kategoriBarangs = ['Kostum Tari', 'Properti Tari', 'Properti Musik'];
@endphp

<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Tambah Barang</h1>
        <p class="text-sm text-gray-500">Form tambah katalog kostum atau properti.</p>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="Contoh: Baju Tari Piring">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Kategori Barang</label>
                <select name="kategori_barang_id" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
                    <option value="">Pilih kategori</option>
                    @foreach ($kategoriBarangs as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa</label>
                <input type="number" name="harga" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="150000">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Nilai Barang</label>
                <input type="number" name="nilai_barang" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="500000">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="10">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Thumbnail</label>
                <input type="file" name="thumbnail_path" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm" placeholder="Tuliskan deskripsi barang..."></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" checked class="rounded border-gray-300 text-[#5A0B1A]">
                    <span class="text-sm font-medium text-gray-700">Barang aktif ditampilkan</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.barang.index') }}" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Kembali
            </a>

            <button type="submit" class="rounded-xl bg-[#5A0B1A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#7B1C2E]">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
