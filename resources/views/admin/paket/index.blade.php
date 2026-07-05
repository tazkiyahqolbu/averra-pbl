@extends('admin.layouts.app')

@section('title', 'Kelola Paket')

@section('content')

@if(session('success'))
<div class="mb-4 rounded-lg bg-green-100 border border-green-300 p-4 text-green-700">
    {{ session('success') }}
</div>
@endif

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
            <div>
                <label class="admin-label">Cari Paket</label>
                <div class="relative">
                    <input type="text" id="filter-nama" class="admin-input pr-10" placeholder="Cari nama paket..." oninput="filterPaket()">
                    <button type="button" onclick="filterPaket()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-[#4A2E28]/40 hover:text-[#C8960C]">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
            <div>
                <label class="admin-label">Kategori</label>
                <select id="filter-kategori" class="admin-select" onchange="filterPaket()">
                    <option value="">Semua</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
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
                        <th class="admin-table-th">Nama Paket</th>
                        <th class="hidden md:table-cell admin-table-th">Kategori</th>
                        <th class="admin-table-th">Harga</th>
                        <th class="hidden lg:table-cell admin-table-th">Keterangan Acara</th>
                        <th class="admin-table-th">Status</th>
                        <th class="admin-table-th text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2D4C0]">
                    @forelse ($paketItems as $index => $item)
                        <tr class="hover:bg-[#FAF3E0]/50 paket-row" data-nama="{{ strtolower($item->nama_paket) }}" data-kategori="{{ $item->kategori->nama ?? '' }}">
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
                                <p class="font-semibold text-[#4A0F1A]">{{ $item->nama_paket }}</p>
                            </td>

                            <td class="hidden md:table-cell admin-table-td text-[#4A2E28]">{{ $item->kategori->nama ?? '-' }}</td>

                            <td class="admin-table-td font-semibold text-[#4A0F1A]">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="hidden lg:table-cell admin-table-td text-[#4A2E28]">{{ $item->keterangan_acara ?? '-' }}</td>

                            <td class="admin-table-td">
                                <span class="{{ $item->aktif ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->aktif ? 'Aktif ✓' : '● Nonaktif' }}
                                </span>
                            </td>

                            <td class="admin-table-td text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.paket.edit', $item->id) }}"
                                       class="admin-btn-secondary px-3 py-2 text-xs">Edit</a>
                                    <form action="{{ route('admin.paket.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus paket ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-danger px-3 py-2 text-xs">Hapus</button>
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

<script>
function filterPaket() {
    const nama = document.getElementById('filter-nama').value.toLowerCase().trim();
    const kategori = document.getElementById('filter-kategori').value;
    document.querySelectorAll('.paket-row').forEach(el => {
        const cocokNama = !nama || el.dataset.nama.includes(nama);
        const cocokKategori = !kategori || el.dataset.kategori === kategori;
        el.style.display = (cocokNama && cocokKategori) ? '' : 'none';
    });
}
</script>
@endsection
