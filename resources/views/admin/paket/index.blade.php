@extends('admin.layouts.app')

@section('title', 'Kelola Paket')

@section('content')

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Paket</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola paket layanan, isi paket, item opsional, harga, foto, dan status.</p>
        </div>
        <a href="{{ route('admin.paket.create') }}" class="admin-btn-primary">+ Tambah Paket</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div><label class="admin-label">Cari Paket</label><input type="text" class="admin-input" placeholder="Cari nama paket..."></div>
            <div><label class="admin-label">Kategori</label><select class="admin-select"><option>Semua</option><option>Paket Pernikahan</option><option>Paket Hiburan</option></select></div>
            <div><label class="admin-label">Status</label><select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select></div>
        </div>
    </div>

    <div class="admin-table-wrapper">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th w-16">#</th>
                        <th class="admin-table-th">Thumbnail</th>
                        <th class="admin-table-th">Nama Paket</th>
                        <th class="admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga</th>
                        <th class="admin-table-th">Keterangan Acara</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2D4C0]">
                    @forelse ($paketItems as $index => $item)
                        <tr class="hover:bg-[#FAF3E0]/50">
                            <td class="admin-table-td font-semibold text-[#4A2E28]">{{ $index + 1 }}</td>

                            <td class="admin-table-td">
                                @if (!empty($item['thumbnail_path']))
                                    <img src="{{ asset('storage/' . $item['thumbnail_path']) }}" alt="{{ $item['nama_paket'] }}" class="admin-thumb">
                                @else
                                    <div class="admin-thumb flex items-center justify-center text-xs font-semibold text-[#4A2E28]">
                                        IMG
                                    </div>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <p class="font-semibold text-gray-900">{{ $item->nama_paket }}</p>
                            </td>

                            <td class="admin-table-td">
                                {{ $item->kategori->nama ?? '-' }}
                            </td>

                            <td class="admin-table-td font-semibold text-gray-900">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="admin-table-td">{{ $item->keterangan_acara }}</td>

                            <td class="admin-table-td">
                                @if ($item->aktif)
                                    <span class="badge-active">Aktif ✓</span>

                                @else
                                    <span class="badge-inactive">● Nonaktif</span>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.paket.edit', $item->id) }}" class="admin-btn-secondary px-3 py-2 text-xs">Edit</a>
                                    <form action="{{ route('admin.paket.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="admin-btn-danger px-3 py-2 text-xs">

                                            Hapus

                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-table-td">
                                <div class="admin-empty">Belum ada data paket.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
