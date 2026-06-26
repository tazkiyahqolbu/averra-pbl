@extends('admin.layouts.app')

@section('title', 'Kelola Barang')

@section('content')

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Barang</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola barang sewa, stok, nilai barang, harga sewa, dan status ketersediaan.</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" class="admin-btn-primary">+ Tambah Barang</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div><label class="admin-label">Cari Barang</label><input type="text" class="admin-input" placeholder="Cari nama barang..."></div>
            <div><label class="admin-label">Kategori</label><select class="admin-select"><option>Semua</option><option>Kamera</option><option>Audio/Sound</option><option>Perlengkapan</option></select></div>
            <div><label class="admin-label">Status</label><select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select></div>
        </div>
    </div>

    <div class="space-y-4">
        @foreach ($barangs as $item)
            <div class="admin-card p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex gap-4">
                        @if($item->thumbnail_path)

                        <img src="{{ asset('storage/'.$item->thumbnail_path) }}" class="admin-thumb object-cover">
                        @else
                        <div class="admin-thumb flex items-center justify-center bg-[#FAF3E0]">
                            IMG
                        </div>
                        @endif
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-heading text-xl font-bold text-[#4A0F1A]">{{ $item->nama_barang }}</h2>
                                <span class="{{ $item->aktif ? 'badge-active' : 'badge-inactive' }}">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                            <p class="admin-muted mt-1 text-sm">Kategori: {{ $item->kategori->nama }}</p>
                            <p class="mt-1 text-sm text-[#4A2E28]">Harga: <strong class="text-[#4A0F1A]">Rp {{ number_format($item->harga,0,',','.') }}</strong> | Stok: <strong class="text-[#4A0F1A]">{{ $item->stok }} unit</strong></p>
                            <p class="mt-1 text-sm text-[#4A2E28]">Nilai Barang: <strong class="text-[#4A0F1A]">Rp {{ number_format($item->nilai_barang,0,',','.') }}</strong></p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.barang.edit',$item->id) }}" class="admin-btn-secondary py-2">Edit</a>
                        <form action="{{ route('admin.barang.destroy',$item->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="admin-btn-danger py-2">

                                Hapus

                            </button>

                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
