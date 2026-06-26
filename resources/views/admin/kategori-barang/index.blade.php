@extends('admin.layouts.app')

@section('title', 'Kategori Barang')

@section('content')
@php
    $kategori = [
        ['id' => 1, 'nama' => 'Dekorasi',         'deskripsi' => 'Perlengkapan dekorasi panggung dan pelaminan.'],
        ['id' => 2, 'nama' => 'Kostum',            'deskripsi' => 'Kostum adat dan pentas seni.'],
        ['id' => 3, 'nama' => 'Peralatan Pentas',  'deskripsi' => 'Sound system, pencahayaan, dan properti pentas.'],
    ];
@endphp

<div class="admin-section">

    {{-- Header --}}
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kategori Barang</h1>
            <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk data barang sewa.</p>
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
                            <th class="admin-table-th">Nama Kategori</th>
                            <th class="admin-table-th">Deskripsi</th>
                            <th class="admin-table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2D4C0]">
                        @foreach ($kategori as $item)
                            <tr class="hover:bg-[#FAF3E0]">
                                <td class="admin-table-td">{{ $loop->iteration }}</td>
                                <td class="admin-table-td font-semibold text-[#4A0F1A]">{{ $item['nama'] }}</td>
                                <td class="admin-table-td text-sm text-[#4A2E28]">{{ $item['deskripsi'] }}</td>
                                <td class="admin-table-td text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            onclick="fillForm('{{ $item['id'] }}', '{{ addslashes($item['nama']) }}', '{{ addslashes($item['deskripsi']) }}')"
                                            class="admin-btn-secondary px-4 py-2">Edit</button>
                                        <button
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                            class="admin-btn-danger px-4 py-2">Hapus</button>
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

            <div class="space-y-4">
                <div>
                    <label class="admin-label">Nama Kategori *</label>
                    <input id="inputNama" type="text" class="admin-input" placeholder="Contoh: Dekorasi">
                </div>

                <div>
                    <label class="admin-label">Deskripsi</label>
                    <textarea id="inputDeskripsi" rows="3" class="admin-textarea"
                        placeholder="Deskripsi singkat kategori"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="resetForm()" class="admin-btn-secondary">Batal</button>
                    <button type="button" class="admin-btn-primary">Simpan</button>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function resetForm() {
    document.getElementById('formTitle').textContent = 'Tambah Kategori';
    document.getElementById('inputNama').value = '';
    document.getElementById('inputDeskripsi').value = '';
    document.getElementById('formPanel').scrollIntoView({ behavior: 'smooth' });
}

function fillForm(id, nama, deskripsi) {
    document.getElementById('formTitle').textContent = 'Edit Kategori';
    document.getElementById('inputNama').value = nama;
    document.getElementById('inputDeskripsi').value = deskripsi;
    document.getElementById('formPanel').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endpush

@endsection
