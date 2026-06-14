@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')
@php
    $galeris = [
        ['judul' => 'Pernikahan Adat Minang', 'kategori' => 'Pernikahan', 'jenis_media' => 'foto', 'unggulan' => true, 'media_path' => null, 'keterangan' => 'Dokumentasi acara pernikahan adat Minangkabau.'],
        ['judul' => 'Pertunjukan Tari Piring', 'kategori' => 'Pertunjukan', 'jenis_media' => 'foto', 'unggulan' => false, 'media_path' => null, 'keterangan' => 'Penampilan tari tradisional untuk acara hiburan.'],
        ['judul' => 'Hiburan Acara Instansi', 'kategori' => 'Hiburan', 'jenis_media' => 'video', 'unggulan' => true, 'media_path' => null, 'keterangan' => 'Dokumentasi kegiatan sanggar bersama mitra.'],
    ];
@endphp

<section class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-2xl">Galeri</h1>
            <p class="admin-subtitle mt-1">Kelola foto dan video dokumentasi kegiatan Sanggar Rantiang Tagok.</p>
        </div>

        <a href="{{ route('admin.galeri.create') }}" class="admin-btn-primary">
            + Tambah Galeri
        </a>
    </div>

    <div class="admin-card p-4">
        <div class="admin-filter-grid md:grid-cols-3">
            <input type="text" class="admin-input" placeholder="Cari judul galeri...">
            <select class="admin-select">
                <option>Semua Kategori</option>
                <option>Pernikahan</option>
                <option>Hiburan</option>
                <option>Pertunjukan</option>
            </select>
            <select class="admin-select">
                <option>Semua Media</option>
                <option>Foto</option>
                <option>Video</option>
            </select>
        </div>
    </div>

    <div class="admin-gallery-grid">
        @foreach ($galeris as $galeri)
            <div class="admin-gallery-card flex h-full min-h-[430px] flex-col">
                <div class="flex h-44 items-center justify-center bg-[#ead8b8] text-sm font-semibold text-[#7a5d58]">
                    {{ strtoupper($galeri['jenis_media']) }}
                </div>

                <div class="flex flex-1 flex-col p-4">
                    <div class="mb-2 flex items-start justify-between gap-2">
                        <h3 class="line-clamp-2 min-h-[3.5rem] font-semibold text-gray-900">
                            {{ $galeri['judul'] }}
                        </h3>

                        @if ($galeri['unggulan'])
                            <span class="badge-warning shrink-0">Unggulan</span>
                        @else
                            <span class="badge-neutral shrink-0">Biasa</span>
                        @endif
                    </div>

                    <p class="admin-muted mb-2 text-sm">
                        {{ $galeri['kategori'] }}
                    </p>

                    <p class="admin-muted line-clamp-2 min-h-[2.75rem] text-sm">
                        {{ $galeri['keterangan'] }}
                    </p>

                    <div class="mt-auto border-t border-[#decba5] pt-3">
                        <div class="flex items-center justify-between gap-2">
                            <a href="{{ route('admin.galeri.edit') }}" class="text-sm font-semibold text-[#4a0f1a] hover:underline">
                                Edit
                            </a>

                            <button type="button" class="text-sm font-semibold text-[#7b1c2e] hover:underline">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
