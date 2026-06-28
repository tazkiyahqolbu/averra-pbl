@extends('admin.layouts.app')

@section('title', 'Zona Lokasi')

@section('content')

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Zona Lokasi</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Kelola zona lokasi dan biaya tambahan berdasarkan jarak acara.
            </p>
        </div>

        <a href="{{ route('admin.zona-lokasi.create') }}" class="admin-btn-primary">

        + Tambah Zona

    </a>
    </div>

    <div class="admin-card p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th">Nama Zona</th>
                        <th class="admin-table-th">Keterangan</th>
                        <th class="admin-table-th">Biaya</th>
                        <th class="admin-table-th">Persentase</th>
                        <th class="admin-table-th">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2D4C0]">
                    @foreach ($zonaLokasi as $zona)
                        <tr>
                            <td class="admin-table-td font-semibold">{{ $zona->nama_zona }}</td>
                            <td class="admin-table-td">{{ $zona->keterangan }}</td>
                            <td class="admin-table-td">Rp {{ number_format($zona->biaya,0,',','.') }}</td>
                            <td class="admin-table-td"> {{ $zona->persentase }}% </td>
                            <td class="admin-table-td">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.zona-lokasi.edit',$zona->id) }}" class="admin-btn-secondary py-2">
                                        Edit
                                    </a>
                                    <form
                                    action="{{ route('admin.zona-lokasi.destroy',$zona->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="admin-btn-danger py-2"
                                        onclick="return confirm('Yakin ingin menghapus zona ini?')">

                                        Hapus

                                    </button>

                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr class="admin-divider my-6">

        <h2 class="admin-title mb-4 text-xl">Form Tambah/Edit Zona</h2>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="admin-label">Nama Zona *</label>
                <input type="text" class="admin-input" placeholder="Zona A">
            </div>

            <div>
                <label class="admin-label">Keterangan *</label>
                <input type="text" class="admin-input" placeholder="Dalam Kota">
            </div>

            <div>
                <label class="admin-label">Biaya *</label>
                <input type="text" class="admin-input" placeholder="Rp 30.000">
            </div>
        </div>

        <div class="mt-5 flex justify-end gap-3">
            <button class="admin-btn-secondary">Batal</button>
            <button class="admin-btn-primary">Simpan</button>
        </div>
    </div>
</div>
@endsection
