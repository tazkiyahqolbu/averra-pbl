@extends('admin.layouts.app')

@section('title', 'Kelola Jasa')

@section('content')

@if(session('success'))
<div class="mb-4 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">Kelola Jasa</h1>
            <p class="admin-subtitle mt-1 text-sm">Mengelola data jasa, kategori, harga, batas booking harian, foto, dan status layanan.</p>
        </div>
        <a href="{{ route('admin.jasa.create') }}" class="admin-btn-primary">+ Tambah Jasa</a>
    </div>

    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div><label class="admin-label">Cari Jasa</label><input type="text" class="admin-input" placeholder="Cari nama jasa..."></div>
            <div><label class="admin-label">Kategori</label><select class="admin-select"><option>Semua</option></select></div>
            <div><label class="admin-label">Status</label><select class="admin-select"><option>Semua</option><option>Aktif</option><option>Nonaktif</option></select></div>
        </div>
    </div>

    <div class="admin-table-wrapper">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="border-b border-[#E2D4C0] bg-[#FAF3E0]">
                    <tr>
                        <th class="admin-table-th w-12">#</th>
                        <th class="hidden sm:table-cell admin-table-th">Thumbnail</th>
                        <th class="admin-table-th">Nama Jasa</th>
                        <th class="hidden md:table-cell admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga</th>
                        <th class="hidden md:table-cell admin-table-th">Maks. Booking/Hari</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2D4C0]">
                    @forelse ($jasaItems as $index => $item)
                        <tr class="hover:bg-[#FAF3E0]/50">
                            <td class="admin-table-td font-semibold text-[#4A2E28]">{{ $index + 1 }}</td>

                            <td class="hidden sm:table-cell admin-table-td">
                                @if($item->thumbnail_path)
                                    <img src="{{ asset('storage/'.$item->thumbnail_path) }}" class="admin-thumb object-cover">
                                @else
                                    <div class="admin-thumb flex items-center justify-center bg-[#FAF3E0]">
                                        <i data-lucide="image" class="h-5 w-5 text-[#C8960C]/50"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="admin-table-td">
                                <p class="font-semibold text-[#4A0F1A]">{{ $item->nama_jasa }}</p>
                            </td>

                            <td class="hidden md:table-cell admin-table-td text-[#4A2E28]">{{ $item->kategori->nama ?? '-' }}</td>

                            <td class="admin-table-td font-semibold text-[#4A0F1A]">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="hidden md:table-cell admin-table-td text-[#4A2E28]">{{ $item->maks_booking_harian }} slot/hari</td>

                            <td class="admin-table-td">
                                <span class="{{ $item->aktif ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->aktif ? 'Aktif ✓' : '● Nonaktif' }}
                                </span>
                            </td>

                            <td class="admin-table-td text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.jasa.edit', $item->id) }}"
                                       class="admin-btn-secondary px-3 py-2 text-xs">Edit</a>
                                    <form action="{{ route('admin.jasa.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus jasa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-danger px-3 py-2 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-table-td">
                                <div class="admin-empty">Belum ada data jasa.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
