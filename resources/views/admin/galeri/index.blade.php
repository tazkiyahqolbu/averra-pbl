@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')

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
                <div class="h-44 overflow-hidden">

            @if($item->media_path)
            @if($item->jenis_media == 'foto')
                <img
                    src="{{ asset('storage/'.$item->media_path) }}"
                    class="h-full w-full object-cover">
            @else
                <video
                    class="h-full w-full object-cover"
                    controls>
                    <source
                        src="{{ asset('storage/'.$item->media_path) }}">
                </video>
            @endif
        @else
            <div class="flex h-full items-center justify-center bg-[#FAF3E0]">
                Tidak ada media
            </div>
        @endif

        </div>

                <div class="space-y-3 p-4">
                    <div>
                        <p class="font-semibold text-[#4A0F1A]">{{ $item->judul }}</p>
                        <p class="admin-muted text-sm">{{ $item->kategori }}</p>
                    </div>

                    <div class="flex gap-2">
                        <a
                        href="{{ route('admin.galeri.edit',$item->id) }}"
                        class="admin-btn-secondary flex-1 py-2">
                        Edit
                        </a>

                        <form
                        action="{{ route('admin.galeri.destroy',$item->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus foto galeri ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                        type="submit"
                        class="admin-btn-danger w-full py-2">

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
