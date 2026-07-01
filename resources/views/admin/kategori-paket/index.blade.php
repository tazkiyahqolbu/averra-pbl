@extends('admin.layouts.app')

@section('title', 'Kategori Paket')

@section('content')
    <div class="admin-section">

        <div class="admin-page-header md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="admin-title text-3xl">Kategori Paket</h1>
                <p class="admin-subtitle mt-1 text-sm">Kelola kategori untuk data paket layanan sanggar.</p>
            </div>
            <a href="{{ route('admin.kategori.create', 'paket') }}" class="admin-btn-primary">+ Tambah Kategori</a>
        </div>

        <div class="admin-card p-6">
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
                        @forelse ($kategori as $kategori)
                            <tr class="hover:bg-[#FAF3E0]">
                                <td class="admin-table-td">{{ $loop->iteration }}</td>
                                <td class="admin-table-td font-semibold text-[#4A0F1A]">{{ $kategori->nama }}</td>
                                <td class="admin-table-td text-sm text-[#4A2E28]">{{ $kategori->deskripsi }}</td>
                                <td class="admin-table-td text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.kategori.edit', ['tipe' => 'paket', 'id' => $item->id]) }}"
                                            class="admin-btn-secondary px-4 py-2">Edit</a>
                                        <form
                                            action="{{ route('admin.kategori.destroy', ['tipe' => 'paket', 'id' => $item->id]) }}"
                                            method="POST"
                                            onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn-danger px-4 py-2">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="admin-table-td text-center text-[#7C6A58] py-8">Belum ada data
                                    kategori paket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
