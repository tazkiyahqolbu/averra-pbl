@extends('admin.layouts.app')

@section('title', 'Kategori Barang')

@section('content')
@php
    $kategoriBarangs = [
        ['nama' => 'Kostum Tari', 'deskripsi' => 'Kategori untuk pakaian dan kostum pertunjukan tari.'],
        ['nama' => 'Properti Tari', 'deskripsi' => 'Kategori untuk properti pendukung pertunjukan.'],
        ['nama' => 'Properti Musik', 'deskripsi' => 'Kategori untuk alat musik tradisional dan pendukung acara.'],
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Kategori Barang</h1>
        <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk kostum dan properti sanggar.</p>
    </div>

    <div class="admin-card p-6">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Kategori Barang</h2>

        <form action="#" method="POST" class="grid gap-4 md:grid-cols-2">
            @csrf

            <div>
                <label class="admin-label">Nama Kategori</label>
                <input type="text" name="nama" class="admin-input" placeholder="Contoh: Kostum Tari">
            </div>

            <div>
                <label class="admin-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="admin-input" placeholder="Deskripsi singkat kategori">
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="button" class="admin-btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>

    <div class="admin-table-wrapper">
        <div class="border-b border-[#decba5] px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori Barang</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-[#decba5] bg-[#f8f3ea]">
                        <th class="admin-table-th">No</th>
                        <th class="admin-table-th">Nama Kategori</th>
                        <th class="admin-table-th">Deskripsi</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($kategoriBarangs as $kategori)
                        <tr class="border-b border-[#decba5] last:border-b-0 hover:bg-[#fff8ed]">
                            <td class="admin-table-td">{{ $loop->iteration }}</td>
                            <td class="admin-table-td font-semibold text-gray-900">{{ $kategori['nama'] }}</td>
                            <td class="admin-table-td">{{ $kategori['deskripsi'] }}</td>
                            <td class="admin-table-td text-right">
                                <button
                                    type="button"
                                    onclick="openEditModal('{{ $kategori['nama'] }}', '{{ $kategori['deskripsi'] }}')"
                                    class="admin-btn-secondary px-4 py-2"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div
    id="editKategoriModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
>
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl">
        <div class="border-b border-[#decba5] px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">
                Edit Kategori
            </h2>
        </div>

        <form action="#" method="POST" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="admin-label">
                    Nama Kategori
                </label>

                <input
                    id="editNamaKategori"
                    type="text"
                    class="admin-input"
                >
            </div>

            <div>
                <label class="admin-label">
                    Deskripsi
                </label>

                <textarea
                    id="editDeskripsiKategori"
                    rows="4"
                    class="admin-textarea"
                ></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="admin-btn-secondary px-4 py-2"
                >
                    Batal
                </button>

                <button
                    type="button"
                    class="admin-btn-primary"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(nama, deskripsi) {
    document.getElementById('editNamaKategori').value = nama;
    document.getElementById('editDeskripsiKategori').value = deskripsi;

    const modal = document.getElementById('editKategoriModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editKategoriModal');

    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endpush
@endsection
