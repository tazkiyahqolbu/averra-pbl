@extends('admin.layouts.app')

@section('title', 'Blokir Tanggal')

@section('content')

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Blokir Tanggal</h1>
            <p class="admin-subtitle mt-1 text-sm">
                Atur tanggal yang tidak tersedia untuk semua layanan atau item tertentu.
            </p>
        </div>

        <a href="#form-tambah-blokir" class="admin-btn-primary">+ Tambah Blokir</a>
    </div>

    <div class="admin-card p-6">
        <div class="mb-5 max-w-sm">
            <label class="admin-label">Berlaku Untuk</label>
            <select class="admin-select">
                <option>Semua Layanan</option>
                <option>Item Tertentu</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th">Tanggal</th>
                        <th class="admin-table-th">Berlaku Untuk</th>
                        <th class="admin-table-th">Alasan</th>
                        <th class="admin-table-th">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2D4C0]">
                    @foreach ($blockedDates as $date)
                        <tr>
                            <td class="admin-table-td font-semibold">{{ $date->tanggal->format('d F Y') }}</td>
                            <td class="admin-table-td">Semua Layanan</td>
                            <td class="admin-table-td">{{ $date->keterangan }}</td>
                            <td class="admin-table-td">
                            <form action="{{ route('admin.blokir-tanggal.destroy', $date->id) }}"
                                method="POST"
                                onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus tanggal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn-danger">Hapus</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr class="admin-divider my-6">
        
        <h2 id="form-tambah-blokir" class="admin-title mb-4 text-xl">Form Tambah Blokir</h2>
<form action="{{ route('admin.blokir-tanggal.store') }}" method="POST">
    @csrf
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="admin-label">Tanggal *</label>
            <input type="date" name="tanggal" class="admin-input" required>
        </div>
        <div>
            <label class="admin-label">Keterangan</label>
            <input type="text" name="keterangan" class="admin-input" placeholder="Hari Libur / Maintenance">
        </div>
    </div>
    <div class="mt-5 flex justify-end gap-3">
        <button type="submit" class="admin-btn-primary">Simpan</button>
    </div>
</form>
        

    </div>
</div>
@endsection
