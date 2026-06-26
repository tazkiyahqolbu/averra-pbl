@extends('admin.layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="admin-section">

    {{-- Header --}}
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <a href="{{ route('admin.barang.index') }}" class="mb-2 inline-flex items-center gap-1.5 text-sm text-[#C8960C] hover:text-[#B8983A]">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Barang
            </a>
            <h1 class="admin-title text-3xl">{{ $barang->nama_barang }}</h1>
            <p class="admin-subtitle mt-1 text-sm">{{ $barang->kategori->nama ?? '-' }}</p>
        </div>
        <span class="{{ $barang->aktif ? 'badge-active' : 'badge-inactive' }} text-sm px-4 py-2">
            {{ $barang->aktif ? 'Aktif ✓' : '● Nonaktif' }}
        </span>
    </div>

    <div class="grid gap-6 md:grid-cols-3">

        {{-- Kolom Kiri: Thumbnail & Foto --}}
        <div class="space-y-4">
            <div class="admin-card p-4">
                <p class="admin-label mb-3">Thumbnail</p>
                @if($barang->thumbnail_path)
                    <img src="{{ asset('storage/'.$barang->thumbnail_path) }}" class="w-full rounded-2xl object-cover" style="aspect-ratio:4/3;">
                @else
                    <div class="flex w-full items-center justify-center rounded-2xl bg-[#FAF3E0] border border-[#E2D4C0]" style="aspect-ratio:4/3;">
                        <i data-lucide="image" class="h-10 w-10 text-[#C8960C]/30"></i>
                    </div>
                @endif
            </div>

            @if($barang->fotos->isNotEmpty())
            <div class="admin-card p-4 space-y-3">
                <p class="admin-label">Foto Barang</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($barang->fotos as $foto)
                        <img src="{{ asset('storage/'.$foto->foto_path) }}" class="w-full rounded-xl object-cover" style="aspect-ratio:1/1;">
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Kolom Tengah: Informasi --}}
        <div class="space-y-4">
            <div class="admin-card p-5 space-y-4">
                <h2 class="admin-title text-lg">Informasi Barang</h2>
                <div class="divide-y divide-[#E2D4C0] text-sm">
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Kategori</span>
                        <span class="text-[#4A2E28]">{{ $barang->kategori->nama ?? '-' }}</span>
                    </div>
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Harga Sewa</span>
                        <span class="font-semibold text-[#4A0F1A]">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Nilai Barang</span>
                        <span class="text-[#4A2E28]">Rp {{ number_format($barang->nilai_barang, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Stok</span>
                        <span class="font-semibold text-[#4A0F1A]">{{ $barang->stok }} unit</span>
                    </div>
                    @if($barang->deskripsi)
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Deskripsi</span>
                        <span class="text-[#4A2E28]">{{ $barang->deskripsi }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi --}}
        <div class="space-y-4">
            <div class="admin-card p-5 space-y-5">
                <h2 class="admin-title text-lg">Aksi</h2>

                {{-- Toggle Status --}}
                <div>
                    <p class="mb-2 text-sm font-semibold text-[#4A0F1A]">Status</p>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="aktif" value="1">
                            <input type="hidden" name="nama_barang" value="{{ $barang->nama_barang }}">
                            <input type="hidden" name="kategori_barang_id" value="{{ $barang->kategori_barang_id }}">
                            <input type="hidden" name="harga" value="{{ $barang->harga }}">
                            <input type="hidden" name="nilai_barang" value="{{ $barang->nilai_barang }}">
                            <input type="hidden" name="stok" value="{{ $barang->stok }}">
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition
                                    {{ $barang->aktif ? 'border-green-400 bg-green-50 text-green-700' : 'border-[#E2D4C0] bg-white text-[#4A2E28] hover:border-green-300 hover:text-green-700' }}">
                                <span class="h-2 w-2 rounded-full {{ $barang->aktif ? 'bg-green-500' : 'bg-[#E2D4C0]' }}"></span>
                                Aktif
                            </button>
                        </form>
                        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="aktif" value="0">
                            <input type="hidden" name="nama_barang" value="{{ $barang->nama_barang }}">
                            <input type="hidden" name="kategori_barang_id" value="{{ $barang->kategori_barang_id }}">
                            <input type="hidden" name="harga" value="{{ $barang->harga }}">
                            <input type="hidden" name="nilai_barang" value="{{ $barang->nilai_barang }}">
                            <input type="hidden" name="stok" value="{{ $barang->stok }}">
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition
                                    {{ !$barang->aktif ? 'border-red-300 bg-red-50 text-red-600' : 'border-[#E2D4C0] bg-white text-[#4A2E28] hover:border-red-200 hover:text-red-600' }}">
                                <span class="h-2 w-2 rounded-full {{ !$barang->aktif ? 'bg-red-500' : 'bg-[#E2D4C0]' }}"></span>
                                Nonaktif
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-[#E2D4C0] pt-4 space-y-2">
                    <a href="{{ route('admin.barang.edit', $barang->id) }}"
                       class="admin-btn-secondary flex w-full items-center justify-center py-2.5 text-sm">
                        <i data-lucide="pencil" class="mr-2 h-4 w-4"></i> Edit Barang
                    </a>
                    <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="admin-btn-danger flex w-full items-center justify-center py-2.5 text-sm">
                            <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i> Hapus Barang
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
