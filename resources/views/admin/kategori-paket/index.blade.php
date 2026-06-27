@extends('admin.layouts.app')

@section('title', 'Kategori Paket')

@section('content')

<div class="admin-section">

    {{-- Header --}}
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kategori Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk data paket layanan sanggar.</p>
        </div>
        <button onclick="resetForm()" class="admin-btn-primary">+ Tambah Kategori</button>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">

        {{-- Tabel --}}
        <div class="admin-card p-6 xl:col-span-2">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                        <tr>
                            <th class="admin-table-th w-10">No</th>
                            <th class="admin-table-th w-14">Ikon</th>
                            <th class="admin-table-th">Nama Kategori</th>
                            <th class="admin-table-th">Deskripsi</th>
                            <th class="admin-table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2D4C0]">
                        @foreach ($kategoriPakets as $kategori)
                            <tr class="hover:bg-[#FAF3E0]">
                                <td class="admin-table-td">{{ $loop->iteration }}</td>
                                <td class="admin-table-td">
                                    @if ($kategori->ikon_path)
                                        <img src="{{ asset('storage/' . $kategori->ikon_path) }}"
                                            class="admin-thumb object-cover">
                                    @else
                                        <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#4A2E28]">
                                            IMG
                                        </div>
                                    @endif
                                </td>
                                <td class="admin-table-td font-semibold text-[#4A0F1A]">{{ $kategori->nama }}</td>
                                <td class="admin-table-td text-sm text-[#4A2E28]">{{ $kategori->deskripsi }}</td>
                                <td class="admin-table-td text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            onclick="fillForm(
                                                '{{ $kategori->id }}',
                                                '{{ addslashes($kategori->nama) }}',
                                                '{{ addslashes($kategori->deskripsi) }}',
                                                '{{ $kategori->ikon_path ? asset('storage/' . $kategori->ikon_path) : '' }}'
                                            )"
                                            class="admin-btn-secondary px-4 py-2">Edit</button>

                                        <form action="{{ route('admin.kategori-paket.destroy', $kategori->id) }}"
                                            method="POST"
                                            onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn-danger px-4 py-2">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Panel Form --}}
        <div id="formPanel" class="admin-card p-6">
            <h2 id="formTitle" class="admin-title mb-4 text-xl">Tambah Kategori</h2>

            <form id="kategoriForm"
                action="{{ route('admin.kategori-paket.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <span id="methodField"></span>

                <div>
                    <label class="admin-label">Nama Kategori *</label>
                    <input id="inputNama" name="nama" type="text" class="admin-input"
                        placeholder="Contoh: Paket Pernikahan">
                </div>

                <div>
                    <label class="admin-label">Deskripsi</label>
                    <textarea id="inputDeskripsi" name="deskripsi" rows="3" class="admin-textarea"
                        placeholder="Deskripsi singkat kategori"></textarea>
                </div>

                <div>
                    <label class="admin-label">Ikon / Foto Kategori</label>
                    <input id="inputIkon" name="ikon_path" type="file" class="admin-file" accept="image/*">
                </div>

                <div id="ikonPreviewWrapper" class="hidden">
                    <label class="admin-label">Ikon Saat Ini</label>
                    <div id="ikonPreview"
                        class="admin-thumb-lg flex items-center justify-center text-xs font-semibold text-[#4A2E28]">
                        IMG
                    </div>
                    <p class="mt-1 text-xs text-[#4A2E28]">Kosongkan jika tidak ingin mengganti.</p>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="resetForm()" class="admin-btn-secondary">Batal</button>
                    <button type="submit" class="admin-btn-primary">Simpan</button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
const storeUrl  = "{{ route('admin.kategori-paket.store') }}";
const updateUrl = "/admin/kategori-paket/";

function resetForm() {
    document.getElementById('formTitle').textContent      = 'Tambah Kategori';
    document.getElementById('kategoriForm').action        = storeUrl;
    document.getElementById('methodField').innerHTML      = '';
    document.getElementById('inputNama').value            = '';
    document.getElementById('inputDeskripsi').value       = '';
    document.getElementById('inputIkon').value            = '';
    document.getElementById('ikonPreviewWrapper').classList.add('hidden');
    document.getElementById('formPanel').scrollIntoView({ behavior: 'smooth' });
}

function fillForm(id, nama, deskripsi, ikonPath) {
    document.getElementById('formTitle').textContent = 'Edit Kategori';
    document.getElementById('kategoriForm').action   = updateUrl + id;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('inputNama').value      = nama;
    document.getElementById('inputDeskripsi').value = deskripsi;
    document.getElementById('inputIkon').value      = '';

    const wrapper = document.getElementById('ikonPreviewWrapper');
    const preview = document.getElementById('ikonPreview');
    if (ikonPath) {
        preview.innerHTML = `<img src="${ikonPath}" class="h-full w-full rounded-2xl object-cover">`;
        wrapper.classList.remove('hidden');
    } else {
        wrapper.classList.add('hidden');
    }

    document.getElementById('formPanel').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endpush

@endsection
