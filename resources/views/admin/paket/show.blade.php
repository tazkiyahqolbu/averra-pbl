@extends('admin.layouts.app')

@section('title', 'Detail Paket')

@section('content')
<div class="admin-section">

    {{-- Header --}}
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <a href="{{ route('admin.paket.index') }}" class="mb-2 inline-flex items-center gap-1.5 text-sm text-[#C8960C] hover:text-[#B8983A]">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Daftar Paket
            </a>
            <h1 class="admin-title text-3xl">{{ $paket->nama_paket }}</h1>
            <p class="admin-subtitle mt-1 text-sm">{{ $paket->kategori->nama ?? '-' }}</p>
        </div>
        <span class="{{ $paket->aktif ? 'badge-active' : 'badge-inactive' }} text-sm px-4 py-2">
            {{ $paket->aktif ? 'Aktif ✓' : '● Nonaktif' }}
        </span>
    </div>

    <div class="grid gap-6 md:grid-cols-3">

        {{-- Kolom Kiri: Thumbnail & Foto --}}
        <div class="space-y-4">
            <div class="admin-card p-4">
                <p class="admin-label mb-3">Thumbnail</p>
                @if($paket->thumbnail_path)
                    <img src="{{ asset('storage/'.$paket->thumbnail_path) }}" class="w-full rounded-2xl object-cover" style="aspect-ratio:4/3;">
                @else
                    <div class="flex w-full items-center justify-center rounded-2xl bg-[#FAF3E0] border border-[#E2D4C0]" style="aspect-ratio:4/3;">
                        <i data-lucide="image" class="h-10 w-10 text-[#C8960C]/30"></i>
                    </div>
                @endif
            </div>

            @if($paket->fotos->isNotEmpty())
            <div class="admin-card p-4 space-y-3">
                <p class="admin-label">Foto Paket</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($paket->fotos as $foto)
                        <img src="{{ asset('storage/'.$foto->foto_path) }}" class="w-full rounded-xl object-cover" style="aspect-ratio:1/1;">
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Kolom Tengah: Informasi --}}
        <div class="space-y-4">
            <div class="admin-card p-5 space-y-4">
                <h2 class="admin-title text-lg">Informasi Paket</h2>
                <div class="divide-y divide-[#E2D4C0] text-sm">
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Kategori</span>
                        <span class="text-[#4A2E28]">{{ $paket->kategori->nama ?? '-' }}</span>
                    </div>
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Harga</span>
                        <span class="font-semibold text-[#4A0F1A]">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Keterangan Acara</span>
                        <span class="text-[#4A2E28]">{{ $paket->keterangan_acara ?? '-' }}</span>
                    </div>
                    @if($paket->deskripsi)
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Deskripsi</span>
                        <span class="text-[#4A2E28]">{{ $paket->deskripsi }}</span>
                    </div>
                    @endif
                    @if($paket->catatan)
                    <div class="flex py-3">
                        <span class="w-36 shrink-0 font-semibold text-[#4A0F1A]">Catatan</span>
                        <span class="text-[#4A2E28]">{{ $paket->catatan }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Isi Paket --}}
            @if($paket->paketDetails->isNotEmpty())
            <div class="admin-card p-5 space-y-3">
                <h2 class="admin-title text-lg">Isi Paket</h2>
                @php
                    $wajib    = $paket->paketDetails->where('tipe', 'wajib');
                    $opsional = $paket->paketDetails->where('tipe', 'opsional');
                @endphp
                @if($wajib->isNotEmpty())
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#4A2E28]/60">Item Wajib</p>
                    <ul class="space-y-2">
                        @foreach($wajib as $detail)
                        <li class="flex items-center justify-between rounded-xl bg-[#FAF3E0] px-4 py-2.5 text-sm">
                            <span class="font-medium text-[#4A0F1A]">
                                {{ $detail->nama_item ?? $detail->jasa?->nama_jasa ?? '-' }}
                                @if($detail->jumlah > 1)
                                    <span class="text-[#4A2E28]/60">× {{ $detail->jumlah }}</span>
                                @endif
                            </span>
                            @if($detail->keterangan)
                                <span class="text-xs text-[#4A2E28]/50">{{ $detail->keterangan }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @endif
                @if($opsional->isNotEmpty())
                    <p class="mt-3 text-xs font-semibold uppercase tracking-wider text-[#4A2E28]/60">Item Opsional</p>
                    <ul class="space-y-2">
                        @foreach($opsional as $detail)
                        <li class="flex items-center justify-between rounded-xl bg-[#FAF3E0] px-4 py-2.5 text-sm">
                            <span class="font-medium text-[#4A0F1A]">
                                {{ $detail->nama_item ?? $detail->jasa?->nama_jasa ?? '-' }}
                                @if($detail->jumlah > 1)
                                    <span class="text-[#4A2E28]/60">× {{ $detail->jumlah }}</span>
                                @endif
                            </span>
                            @if($detail->harga_tambahan > 0)
                                <span class="font-semibold text-[#C8960C]">+Rp {{ number_format($detail->harga_tambahan, 0, ',', '.') }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Aksi --}}
        <div class="space-y-4">
            <div class="admin-card p-5 space-y-5">
                <h2 class="admin-title text-lg">Aksi</h2>

                {{-- Toggle Status --}}
                <div>
                    <p class="mb-2 text-sm font-semibold text-[#4A0F1A]">Status</p>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="aktif" value="1">
                            <input type="hidden" name="nama_paket" value="{{ $paket->nama_paket }}">
                            <input type="hidden" name="kategori_paket_id" value="{{ $paket->kategori_paket_id }}">
                            <input type="hidden" name="harga" value="{{ $paket->harga }}">
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition
                                    {{ $paket->aktif ? 'border-green-400 bg-green-50 text-green-700' : 'border-[#E2D4C0] bg-white text-[#4A2E28] hover:border-green-300 hover:text-green-700' }}">
                                <span class="h-2 w-2 rounded-full {{ $paket->aktif ? 'bg-green-500' : 'bg-[#E2D4C0]' }}"></span>
                                Aktif
                            </button>
                        </form>
                        <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="aktif" value="0">
                            <input type="hidden" name="nama_paket" value="{{ $paket->nama_paket }}">
                            <input type="hidden" name="kategori_paket_id" value="{{ $paket->kategori_paket_id }}">
                            <input type="hidden" name="harga" value="{{ $paket->harga }}">
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition
                                    {{ !$paket->aktif ? 'border-red-300 bg-red-50 text-red-600' : 'border-[#E2D4C0] bg-white text-[#4A2E28] hover:border-red-200 hover:text-red-600' }}">
                                <span class="h-2 w-2 rounded-full {{ !$paket->aktif ? 'bg-red-500' : 'bg-[#E2D4C0]' }}"></span>
                                Nonaktif
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-[#E2D4C0] pt-4 space-y-2">
                    <a href="{{ route('admin.paket.edit', $paket->id) }}"
                       class="admin-btn-secondary flex w-full items-center justify-center py-2.5 text-sm">
                        <i data-lucide="pencil" class="mr-2 h-4 w-4"></i> Edit Paket
                    </a>
                    <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST"
                          onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus paket ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="admin-btn-danger flex w-full items-center justify-center py-2.5 text-sm">
                            <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i> Hapus Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
