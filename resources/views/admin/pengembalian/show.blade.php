@extends('admin.layouts.app')

@section('title', 'Pemeriksaan Pengembalian')

@section('content')

    <form action="{{ route('admin.pengembalian.update', $return->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="admin-section">

            <div class="admin-page-header md:flex-row md:items-center md:justify-between">

                <div>
                    <h1 class="admin-title text-3xl">
                        #{{ $return->kode_pengembalian }}
                    </h1>

                    <p class="admin-subtitle mt-1 text-sm">
                        Form pemeriksaan kondisi barang dan denda.
                    </p>
                </div>

                @php
                    $statusClass = match ($return->status_pengembalian) {
                        'selesai' => 'badge-active',
                        'diperiksa' => 'badge-warning',
                        default => 'badge-inactive',
                    };
                @endphp

                <span class="{{ $statusClass }}">
                    {{ ucfirst(str_replace('_', ' ', $return->status_pengembalian)) }}
                </span>


            </div>


            <div class="grid gap-5 xl:grid-cols-3">

                <div class="space-y-5 xl:col-span-2">

                    {{-- ===================== --}}
                    {{-- Informasi --}}
                    {{-- ===================== --}}

                    <div class="admin-card p-5">

                        <h2 class="admin-title mb-4 text-xl">
                            Informasi Pengembalian
                        </h2>

                        <div class="grid gap-3 md:grid-cols-2">

                            <p>
                                <span class="admin-muted text-sm">Pesanan</span><br>

                                <strong>
                                    #{{ $return->detailPemesanan->pemesanan->kode_pemesanan }}
                                </strong>
                            </p>

                            <p>
                                <span class="admin-muted text-sm">Customer</span><br>

                                <strong>
                                    {{ $return->detailPemesanan->pemesanan->nama_pemesan }}
                                </strong>
                            </p>

                            <p>

                                <span class="admin-muted text-sm">
                                    Item
                                </span><br>

                                <strong>

                                    @if ($return->detailPemesanan->barang)
                                        {{ $return->detailPemesanan->barang->nama_barang }}
                                    @elseif($return->detailPemesanan->jasa)
                                        {{ $return->detailPemesanan->jasa->nama_jasa }}
                                    @elseif($return->detailPemesanan->paket)
                                        {{ $return->detailPemesanan->paket->nama_paket }}
                                    @else
                                        -
                                    @endif

                                </strong>

                            </p>

                            <p>

                                <span class="admin-muted text-sm">
                                    Jadwal Kembali
                                </span><br>

                                <strong>

                                    {{ optional($return->detailPemesanan->tanggal_kembali)->translatedFormat('d F Y') ?? '-' }}

                                </strong>

                            </p>

                            <p>

                                <span class="admin-muted text-sm">
                                    Tanggal Kembali
                                </span><br>

                                <strong>

                                    {{ optional($return->tanggal_kembali_aktual)->translatedFormat('d F Y') ?? '-' }}

                                </strong>

                            </p>

                        </div>

                    </div>

                    {{-- ===================== --}}
                    {{-- Form Pemeriksaan --}}
                    {{-- ===================== --}}

                    <div class="admin-card p-5">

                        <h2 class="admin-title mb-4 text-xl">
                            Form Pemeriksaan
                        </h2>

                        <div class="space-y-4">

                            <div>

                                <label class="admin-label">
                                    Kondisi Barang *
                                </label>

                                @php

                                    $kondisiList = [
                                        'baik' => 'Baik — tidak ada kerusakan',

                                        'rusak_ringan' => 'Rusak Ringan — kerusakan minor',

                                        'rusak_berat' => 'Rusak Berat — perlu perbaikan signifikan',

                                        'hilang' => 'Hilang — barang tidak dikembalikan',
                                    ];

                                @endphp

                                <div class="grid gap-3 md:grid-cols-2">

                                    @foreach ($kondisiList as $value => $label)
                                        <label
                                            class="flex items-center gap-3 rounded-2xl border border-[#E2D4C0] bg-white p-4">

                                            <input type="radio" name="kondisi" value="{{ $value }}"
                                                {{ old('kondisi', $return->kondisi) == $value ? 'checked' : '' }}>

                                            <span>{{ $label }}</span>

                                        </label>
                                    @endforeach

                                </div>

                                @error('kondisi')
                                    <div class="text-red-500 text-sm mt-2">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>


                            <div>

                                <label class="admin-label">
                                    Catatan Kerusakan
                                </label>

                                <textarea name="catatan_kerusakan" class="admin-textarea">{{ old('catatan_kerusakan', $return->catatan_kerusakan) }}</textarea>

                                @error('catatan_kerusakan')
                                    <div class="text-red-500 text-sm mt-2">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>


                            <div>

                                <label class="admin-label">
                                    Foto Bukti Kondisi
                                </label>

                                <input type="file" name="foto_bukti_path" class="admin-file">

                                @if ($return->foto_bukti_url)
                                    <img src="{{ $return->foto_bukti_url }}" alt="Foto Bukti"
                                        class="mt-3 w-48 rounded-xl border object-cover">
                                @endif

                                @error('foto_bukti_path')
                                    <div class="text-red-500 text-sm mt-2">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===================== --}}
                {{-- Denda --}}
                {{-- ===================== --}}

                <div class="space-y-5">

                    <div class="admin-card p-5">

                        <h2 class="admin-title mb-4 text-xl">
                            Perhitungan Denda
                        </h2>

                        <div class="space-y-4">

                            <div>

                                <label class="admin-label">
                                    Denda Keterlambatan
                                </label>

                                <input type="text" id="denda_keterlambatan_display" class="admin-input" readonly
                                    data-value="{{ $return->denda_keterlambatan }}"
                                    value="Rp {{ number_format($return->denda_keterlambatan, 0, ',', '.') }}">

                            </div>

                            <div>

                                <label class="admin-label">
                                    Denda Kerusakan
                                </label>

                                <input type="number" id="denda_kerusakan_input" name="denda_kerusakan" min="0" step="1000"
                                    class="admin-input" value="{{ old('denda_kerusakan', $return->denda_kerusakan ?? 0) }}" required>

                                @error('denda_kerusakan')
                                    <div class="text-red-500 text-sm mt-2">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>

                            <div>

                                <label class="admin-label">
                                    Total Denda
                                </label>

                                <input type="text" id="total_denda_display" readonly class="admin-input font-bold"
                                    value="Rp {{ number_format($return->total_denda, 0, ',', '.') }}">

                            </div>

                        </div>

                    </div>

                    <div class="admin-card p-5">

                        <button type="submit" class="admin-btn-primary w-full">

                            Simpan Hasil Pemeriksaan

                        </button>

                        <a href="{{ route('admin.pengembalian.index') }}" class="admin-btn-secondary mt-2 w-full">

                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

    @push('scripts')
        <script>
            (function () {
                const dendaKerusakanInput = document.getElementById('denda_kerusakan_input');
                const dendaKeterlambatanDisplay = document.getElementById('denda_keterlambatan_display');
                const totalDendaDisplay = document.getElementById('total_denda_display');

                function formatRupiah(angka) {
                    return 'Rp ' + Number(angka).toLocaleString('id-ID');
                }

                function hitungTotal() {
                    const keterlambatan = parseInt(dendaKeterlambatanDisplay.dataset.value, 10) || 0;
                    const kerusakan = parseInt(dendaKerusakanInput.value, 10) || 0;
                    totalDendaDisplay.value = formatRupiah(keterlambatan + kerusakan);
                }

                dendaKerusakanInput.addEventListener('input', hitungTotal);
            })();
        </script>
    @endpush

@endsection
