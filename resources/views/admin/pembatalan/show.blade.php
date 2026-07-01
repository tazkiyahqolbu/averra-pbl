@extends('admin.layouts.app')

@section('title', 'Detail Pembatalan')

@section('content')
<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-3xl">Detail Pembatalan</h1>
            <p class="admin-subtitle mt-1 text-sm">#{{ $pembatalan->pemesanan->kode_pemesanan }}</p>
        </div>
        @if($pembatalan->status === 'menunggu')
            <span class="badge-warning">Menunggu Tinjauan</span>
        @elseif($pembatalan->status === 'disetujui')
            <span class="badge-active">Disetujui</span>
        @else
            <span class="badge-inactive">Ditolak</span>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-3 text-sm font-semibold text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="space-y-5 xl:col-span-2">

            {{-- Info Pengaju --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Data Pengaju</h2>
                <div class="grid gap-3 md:grid-cols-2 text-sm">
                    <div>
                        <p class="admin-muted">Nama</p>
                        <p class="font-semibold">{{ $pembatalan->user->name }}</p>
                    </div>
                    <div>
                        <p class="admin-muted">Kode Pesanan</p>
                        <p class="font-semibold">
                            <a href="{{ route('admin.pemesanan.show', $pembatalan->pemesanan_id) }}" class="text-[#4A0F1A] underline">
                                #{{ $pembatalan->pemesanan->kode_pemesanan }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="admin-muted">Jenis Pesanan</p>
                        <p class="font-semibold">{{ $pembatalan->pemesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Acara' }}</p>
                    </div>
                    <div>
                        <p class="admin-muted">Total Pesanan</p>
                        <p class="font-semibold">Rp {{ number_format($pembatalan->pemesanan->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="admin-muted">DP Sudah Dibayar</p>
                        @php $dpBayar = $pembatalan->pemesanan->pembayarans->where('tahap','dp')->where('status','terverifikasi')->sum('jumlah_bayar'); @endphp
                        <p class="font-semibold">Rp {{ number_format($dpBayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="admin-muted">Diajukan</p>
                        <p class="font-semibold">{{ $pembatalan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Alasan --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-3 text-xl">Alasan Pembatalan</h2>
                <div class="rounded-2xl bg-[#FAF3E0] p-4 text-sm text-[#4A2E28]">
                    {{ $pembatalan->alasan }}
                </div>
            </div>

        </div>

        <div class="space-y-5">
            {{-- Aksi Admin --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Aksi Admin</h2>

                @if($pembatalan->status === 'menunggu')
                    <button type="button" onclick="document.getElementById('modal-setujui').classList.remove('hidden')"
                            class="admin-btn-primary w-full mb-2">
                        Setujui Pembatalan
                    </button>
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                            class="admin-btn-danger w-full">
                        Tolak Pembatalan
                    </button>
                @elseif($pembatalan->status === 'disetujui')
                    <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm">
                        <p class="font-semibold text-green-700 mb-1">Pembatalan Disetujui</p>
                        <p class="text-green-600">DP tidak dikembalikan.</p>
                        <p class="text-green-600">Diproses: {{ $pembatalan->diproses_pada?->format('d M Y, H:i') }}</p>
                        @if($pembatalan->catatan_admin)
                            <p class="text-green-600 mt-1">{{ $pembatalan->catatan_admin }}</p>
                        @endif
                    </div>
                @else
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm">
                        <p class="font-semibold text-red-700 mb-1">Pembatalan Ditolak</p>
                        @if($pembatalan->catatan_admin)
                            <p class="text-red-600">{{ $pembatalan->catatan_admin }}</p>
                        @endif
                    </div>
                @endif

                <a href="{{ route('admin.pembatalan.index') }}" class="admin-btn-secondary w-full mt-3 block text-center">Kembali</a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Setujui --}}
@if($pembatalan->status === 'menunggu')
<div id="modal-setujui" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white border border-gray-200 shadow-2xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Setujui Pembatalan</h3>
        <p class="text-sm text-gray-500 mb-4">DP yang sudah dibayar (Rp {{ number_format($dpBayar ?? 0, 0, ',', '.') }}) tidak dikembalikan ke customer.</p>
        <form method="POST" action="{{ route('admin.pembatalan.setujui', $pembatalan->id) }}">
            @csrf @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-600 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan_admin" rows="3" maxlength="500"
                              placeholder="Catatan untuk customer..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-green-300 focus:outline-none focus:ring-2 focus:ring-green-100 resize-none transition">{{ old('catatan_admin') }}</textarea>
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="button" onclick="document.getElementById('modal-setujui').classList.add('hidden')"
                        class="flex-1 rounded-xl border border-gray-200 bg-white py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 rounded-xl bg-green-600 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition">
                    Setujui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tolak --}}
<div id="modal-tolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white border border-gray-200 shadow-2xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tolak Permintaan Pembatalan</h3>
        <form method="POST" action="{{ route('admin.pembatalan.tolak', $pembatalan->id) }}">
            @csrf @method('PATCH')
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-600 mb-1.5">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="catatan_admin" rows="4" required minlength="10" maxlength="500"
                          placeholder="Jelaskan alasan penolakan..."
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 resize-none transition">{{ old('catatan_admin') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Minimal 10 karakter.</p>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 rounded-xl border border-gray-200 bg-white py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 rounded-xl bg-red-600 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('#modal-setujui, #modal-tolak').forEach(modal => {
        modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });
    });
</script>
@endif

@endsection
