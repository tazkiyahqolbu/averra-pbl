@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')
@php
    $galeri = [
        ['judul' => 'Pernikahan Andi & Siti', 'kategori' => 'Pernikahan'],
        ['judul' => 'Pertunjukan Tari Minang', 'kategori' => 'Pertunjukan'],
        ['judul' => 'Acara Hiburan Budaya', 'kategori' => 'Hiburan'],
    ];
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Galeri</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Kelola foto dokumentasi kegiatan sanggar.
            </p>
        </div>

        <a href="{{ route('admin.galeri.create') }}" class="admin-btn-primary">
            + Upload Foto
        </a>
    </div>

    <div class="admin-gallery-grid">
        @foreach ($galeri as $item)
            <div class="admin-gallery-card">
                <div class="flex h-44 items-center justify-center bg-[#FAF3E0]">
                    <i data-lucide="image" class="h-12 w-12 text-[#E2D4C0]"></i>
                </div>

                <div class="space-y-3 p-4">
                    <div>
                        <p class="font-semibold text-[#4A0F1A]">{{ $item['judul'] }}</p>
                        <p class="admin-muted text-sm">{{ $item['kategori'] }}</p>
                    </div>

                    <div class="flex gap-2">
                        <button class="admin-btn-secondary flex-1 py-2">Edit</button>
                        <button class="admin-btn-danger flex-1 py-2">Hapus</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
