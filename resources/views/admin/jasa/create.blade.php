@extends('admin.layouts.app')

@section('title', 'Tambah Jasa')

@section('content')
<div class="admin-section space-y-5">
    <div>
        <h1 class="admin-title text-2xl md:text-3xl">Tambah Jasa</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Lengkapi data jasa sesuai katalog layanan Sanggar Rantiang Tagok.
        </p>
    </div>

    <form class="admin-card space-y-5 p-4 md:p-6">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div>
                <label class="admin-label">Nama Jasa *</label>
                <input type="text" class="admin-input" placeholder="Contoh: MC Pernikahan">
            </div>

            <div>
                <label class="admin-label">Kategori *</label>
                <select class="admin-select">
                    <option>Pilih kategori</option>
                    <option>MC</option>
                    <option>Pertunjukan Tari</option>
                    <option>Makeup</option>
                    <option>Band/Akustik</option>
                </select>
            </div>

            <div>
                <label class="admin-label">Harga *</label>
                <input type="text" class="admin-input" placeholder="Rp 1.500.000">
            </div>

            <div>
                <label class="admin-label">Maks. Booking/Hari *</label>
                <input type="number" class="admin-input" placeholder="4" min="1">
            </div>
        </div>

        <div>
            <label class="admin-label">Deskripsi</label>
            <textarea
                class="admin-textarea min-h-[140px]"
                placeholder="Jelaskan layanan, durasi, dan ketentuan jasa..."
            ></textarea>
        </div>

        <div>
            <label class="admin-label">Status</label>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#E2D4C0] bg-white px-4 py-4">
                    <input type="radio" name="status" checked>
                    <span>Aktif</span>
                </label>

                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-[#E2D4C0] bg-white px-4 py-4">
                    <input type="radio" name="status">
                    <span>Nonaktif</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div>
                <label class="admin-label">Foto Utama *</label>
                <label class="flex min-h-[120px] cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-[#E2D4C0] bg-white p-4 text-center text-sm text-[#4A2E28]/60">
                    <input type="file" class="hidden">
                    Klik untuk upload foto utama
                </label>
            </div>

            <div>
                <label class="admin-label">Foto Tambahan</label>
                <label class="flex min-h-[120px] cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-[#E2D4C0] bg-white p-4 text-center text-sm text-[#4A2E28]/60">
                    <input type="file" class="hidden" multiple>
                    Upload foto tambahan
                </label>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.jasa.index') }}"
               class="admin-btn-secondary w-full text-center sm:w-auto">
                Batal
            </a>

            <button type="button"
                    class="admin-btn-primary w-full sm:w-auto">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
