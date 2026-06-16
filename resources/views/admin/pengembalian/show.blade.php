@extends('admin.layouts.app')

@section('title', 'Pemeriksaan Pengembalian')

@section('content')
<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">#RET-20260613-001</h1>
            <p class="admin-subtitle mt-1 text-sm">Form pemeriksaan kondisi barang dan denda.</p>
        </div>

        <span class="badge-warning">Belum Diperiksa</span>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="space-y-5 xl:col-span-2">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Informasi Pengembalian</h2>
                <div class="grid gap-3 md:grid-cols-2">
                    <p><span class="admin-muted text-sm">Pesanan</span><br><strong>#AVR-20260610-002</strong></p>
                    <p><span class="admin-muted text-sm">Customer</span><br><strong>Siti Rahmah</strong></p>
                    <p><span class="admin-muted text-sm">Item</span><br><strong>Kamera Canon EOS + Tripod</strong></p>
                    <p><span class="admin-muted text-sm">Jadwal Kembali</span><br><strong>13 Juni 2026</strong></p>
                    <p><span class="admin-muted text-sm">Tanggal Kembali</span><br><strong>13 Juni 2026 ✅ Tepat Waktu</strong></p>
                </div>
            </div>

            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Form Pemeriksaan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="admin-label">Kondisi Barang *</label>
                        <div class="grid gap-3 md:grid-cols-2">
                            @foreach (['Baik — tidak ada kerusakan', 'Rusak Ringan — kerusakan minor', 'Rusak Berat — perlu perbaikan signifikan', 'Hilang — barang tidak dikembalikan'] as $condition)
                                <label class="flex items-center gap-3 rounded-2xl border border-[#decba5] bg-[#fffdf7] p-4 text-sm">
                                    <input type="radio" name="kondisi" class="h-4 w-4">
                                    <span>{{ $condition }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="admin-label">Catatan Kerusakan</label>
                        <textarea class="admin-textarea" placeholder="Isi jika ada kerusakan atau catatan tambahan..."></textarea>
                    </div>

                    <div>
                        <label class="admin-label">Foto Bukti Kondisi</label>
                        <input type="file" class="admin-file">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Perhitungan Denda</h2>

                <div class="space-y-4">
                    <div>
                        <label class="admin-label">Denda Keterlambatan</label>
                        <input type="text" class="admin-input" value="Rp 0" readonly>
                    </div>

                    <div>
                        <label class="admin-label">Denda Kerusakan</label>
                        <input type="text" class="admin-input" placeholder="Rp 0">
                    </div>

                    <div>
                        <label class="admin-label">Total Denda</label>
                        <input type="text" class="admin-input font-bold" placeholder="Rp 0">
                    </div>
                </div>
            </div>

            <div class="admin-card p-5">
                <button class="admin-btn-primary w-full">Simpan Hasil Pemeriksaan</button>
                <a href="{{ route('admin.pengembalian.index') }}" class="admin-btn-secondary mt-2 w-full">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
