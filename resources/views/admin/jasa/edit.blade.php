@extends('admin.layouts.app')

@section('title', 'Edit Jasa')

@section('content')
<div class="admin-section space-y-5">
    <div>
        <h1 class="admin-title text-2xl md:text-3xl">Edit Jasa</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Perbarui data jasa, harga, foto, dan status layanan.
        </p>
    </div>

    {{-- Gunakan form create di atas --}}
    {{-- Bedanya hanya tombol submit --}}

    <form class="admin-card space-y-5 p-4 md:p-6">
        {{-- copy seluruh isi form create di atas --}}

        <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.jasa.index') }}"
               class="admin-btn-secondary w-full text-center sm:w-auto">
                Batal
            </a>

            <button type="button"
                    class="admin-btn-primary w-full sm:w-auto">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
