@extends('admin.layouts.app')

@section('title', 'Kategori Paket')

@section('content')
@php
    $kategoriPakets = [
        ['nama' => 'Paket Pernikahan', 'deskripsi' => 'Paket lengkap untuk acara pernikahan', 'ikon_path' => null],
        ['nama' => 'Paket Sunatan', 'deskripsi' => 'Paket lengkap untuk acara sunatan', 'ikon_path' => null],
        ['nama' => 'Paket Ulang Tahun', 'deskripsi' => 'Paket hiburan untuk ulang tahun', 'ikon_path' => null],
        ['nama' => 'Paket Acara Kantor', 'deskripsi' => 'Paket hiburan untuk acara perusahaan', 'ikon_path' => null],
    ];
@endphp

<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Kategori Paket</h1>
        <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk data paket layanan sanggar.</p>
    </div>

    <div class="admin-card p-6">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Kategori Paket</h2>

            <form action="#" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
             @csrf

            <div>
                <label class="admin-label">Nama Kategori</label>
                <input type="text" name="nama" class="admin-input" placeholder="Contoh: Paket Pernikahan">
            </div>

            <div>
                <label class="admin-label">Ikon / Foto Kategori</label>
                <input type="file" name="ikon_path" class="admin-file">
            </div>

            <div class="md:col-span-2">
                <label class="admin-label">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="admin-textarea" placeholder="Deskripsi singkat kategori"></textarea>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="button" class="admin-btn-primary">Simpan Kategori</button>
            </div>
            </form>
    </div>

    <div class="admin-table-wrapper">
        <div class="border-b border-[#decba5] px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori Paket</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-[#decba5] bg-[#f8f3ea]">
                        <th class="admin-table-th">No</th>
                        <th class="admin-table-th">Ikon</th>
                        <th class="admin-table-th">Nama Kategori</th>
                        <th class="admin-table-th">Deskripsi</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($kategoriPakets as $kategori)
                        <tr class="border-b border-[#decba5] last:border-b-0 hover:bg-[#fff8ed]">
                            <td class="admin-table-td">{{ $loop->iteration }}</td>

                            <td class="admin-table-td">
                                <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#7a5d58]">
                                    IMG
                                </div>
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                {{ $kategori['nama'] }}
                            </td>

                            <td class="admin-table-td">
                                {{ $kategori['deskripsi'] }}
                            </td>

                            <td class="admin-table-td text-right">
                                <button type="button" onclick="openEditModal (
                                    '{{ $kategori['nama'] }}',
                                    '{{ $kategori['deskripsi'] }}',
                                    '{{ $kategori['ikon_path'] ?? '' }}' )"
                                    class="admin-btn-secondary px-4 py-2" >
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
                Edit Kategori Paket
            </h2>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4 p-6">
            @csrf
            @method('PUT')

            <div>
                <label class="admin-label">Nama Kategori</label>
                <input
                    id="editNamaKategori"
                    name="nama"
                    type="text"
                    class="admin-input"
                >
            </div>

            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea
                    id="editDeskripsiKategori"
                    name="deskripsi"
                    rows="4"
                    class="admin-textarea"
                ></textarea>
            </div>

            <div>
                <label class="admin-label">Ikon / Foto Saat Ini</label>

                <div
                    id="editIkonPreview"
                    class="admin-thumb-lg flex items-center justify-center text-xs font-semibold text-[#7a5d58]"
                >
                    IMG
                </div>
            </div>

            <div>
                <label class="admin-label">Ganti Ikon / Foto Kategori</label>
                <input
                    id="editIkonKategori"
                    name="ikon_path"
                    type="file"
                    class="admin-file"
                    accept="image/*"
                >
                <p class="mt-2 text-xs text-[#7a5d58]">
                    Kosongkan jika tidak ingin mengganti ikon/foto.
                </p>
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
function openEditModal(nama, deskripsi, ikonPath = '') {
    document.getElementById('editNamaKategori').value = nama;
    document.getElementById('editDeskripsiKategori').value = deskripsi;

    const preview = document.getElementById('editIkonPreview');

    if (ikonPath) {
        preview.innerHTML = `<img src="${ikonPath}" alt="${nama}" class="h-full w-full rounded-2xl object-cover">`;
    } else {
        preview.innerHTML = 'IMG';
    }

    const modal = document.getElementById('editKategoriModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editKategoriModal');

    modal.classList.remove('flex');
    modal.classList.add('hidden');

    document.getElementById('editIkonKategori').value = '';
}
</script>
@endpush
@endsection
