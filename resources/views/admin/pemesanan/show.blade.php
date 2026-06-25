@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
@php
    $statusMap = [
        'menunggu'     => ['label' => 'Menunggu Konfirmasi', 'class' => 'badge-warning'],
        'dikonfirmasi' => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
        'berlangsung'  => ['label' => 'Berlangsung',         'class' => 'badge-active'],
        'selesai'      => ['label' => 'Selesai',             'class' => 'badge-neutral'],
        'dibatalkan'   => ['label' => 'Dibatalkan',          'class' => 'badge-inactive'],
    ];
    $badge = $statusMap[$pemesanan->status] ?? ['label' => ucfirst($pemesanan->status), 'class' => 'badge-neutral'];
    $jenisLabel = $pemesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Acara';

    $maskEmail = function(?string $email): string {
        if (!$email || !str_contains($email, '@')) return '-';
        [$local, $domain] = explode('@', $email, 2);
        $maskedLocal = substr($local, 0, 2) . str_repeat('*', max(2, strlen($local) - 2));
        $dotPos = strrpos($domain, '.');
        $domainName = substr($domain, 0, $dotPos);
        $tld        = substr($domain, $dotPos);
        $maskedDomain = substr($domainName, 0, 1) . str_repeat('*', max(2, strlen($domainName) - 1));
        return $maskedLocal . '@' . $maskedDomain . $tld;
    };

    $maskPhone = function(?string $phone): string {
        if (!$phone) return '-';
        $len = strlen($phone);
        return substr($phone, 0, 3) . str_repeat('*', max(2, $len - 5)) . substr($phone, -2);
    };
@endphp

<div class="admin-section">
    <div class="admin-page-header md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="admin-title text-3xl">#{{ $pemesanan->kode_pemesanan }}</h1>
            <p class="admin-subtitle mt-1 text-sm">Detail pemesanan pelanggan dan aksi admin.</p>
        </div>
        <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-3">
        <div class="space-y-5 xl:col-span-2">

            {{-- Data Pemesan --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Data Pemesan</h2>
                <div class="grid gap-3 md:grid-cols-3">
                    <p><span class="admin-muted text-sm">Nama Pemesan</span><br><strong>{{ $pemesanan->nama_pemesan ?? $pemesanan->user?->nama ?? '-' }}</strong></p>
                    <p><span class="admin-muted text-sm">Email</span><br><strong>{{ $maskEmail($pemesanan->user?->email) }}</strong></p>
                    <p><span class="admin-muted text-sm">No. HP</span><br><strong>{{ $pemesanan->no_hp ?? $pemesanan->user?->no_hp ?? '-' }}</strong></p>
                </div>
            </div>

            {{-- Detail Pesanan --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Detail Pesanan</h2>
                <div class="grid gap-3 md:grid-cols-2 mb-4">
                    <p><span class="admin-muted text-sm">Jenis</span><br><strong>{{ $jenisLabel }}</strong></p>
                    <p><span class="admin-muted text-sm">Tanggal Pakai</span><br><strong>{{ $pemesanan->tanggal_pakai?->format('d F Y') ?? '-' }}</strong></p>
                    <p><span class="admin-muted text-sm">Lokasi / Zona</span><br><strong>{{ $pemesanan->zonaLokasi?->nama_zona ?? '-' }}</strong></p>
                    <p><span class="admin-muted text-sm">Keterangan Lokasi</span><br><strong>{{ $pemesanan->lokasi ?? '-' }}</strong></p>
                </div>

                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#FAF3E0] text-left">
                            <th class="p-2 rounded-tl-lg">Item</th>
                            <th class="p-2 text-center">Jml</th>
                            <th class="p-2 text-right rounded-tr-lg">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemesanan->detailPemesanans as $detail)
                            @php
                                $nama = $detail->barang?->nama_barang
                                     ?? $detail->jasa?->nama_jasa
                                     ?? $detail->paket?->nama_paket
                                     ?? '-';
                            @endphp
                            <tr class="border-b border-[#E2D4C0]">
                                <td class="p-2 text-[#4A2E28]">{{ $nama }}</td>
                                <td class="p-2 text-center text-[#4A2E28]">{{ $detail->jumlah }}</td>
                                <td class="p-2 text-right font-semibold text-[#4A0F1A]">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($pemesanan->catatan)
                    <div class="mt-4">
                        <p class="admin-muted text-sm">Catatan</p>
                        <p class="rounded-2xl bg-[#FAF3E0] p-4 text-sm text-[#4A2E28]">{{ $pemesanan->catatan }}</p>
                    </div>
                @endif
            </div>

            {{-- Rincian Harga --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Rincian Harga</h2>
                <div class="space-y-3 text-sm">
                    @if($pemesanan->ongkos_lokasi > 0)
                        <div class="flex justify-between">
                            <span>Ongkos Lokasi ({{ $pemesanan->zonaLokasi?->nama_zona }})</span>
                            <strong>Rp {{ number_format($pemesanan->ongkos_lokasi, 0, ',', '.') }}</strong>
                        </div>
                    @endif
                    <hr class="admin-divider">
                    <div class="flex justify-between text-lg">
                        <strong>Total</strong>
                        <strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong>
                    </div>
                    @php $tahap = $pemesanan->pembayarans->first()?->tahap; @endphp
                    <p class="admin-muted text-sm">
                        Metode Bayar: {{ $tahap === 'langsung' ? 'Lunas' : 'DP 50% (Rp ' . number_format($pemesanan->total_harga * 0.5, 0, ',', '.') . ') + Pelunasan' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            {{-- Riwayat Status --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Info Pemesanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="rounded-2xl bg-[#FAF3E0] p-3">
                        <strong>{{ $pemesanan->created_at->format('d M Y H.i') }}</strong>
                        <p class="admin-muted">Pesanan masuk</p>
                    </div>
                    <div class="rounded-2xl bg-[#FAF3E0] p-3">
                        <strong class="text-[#4A2E28]">Status saat ini</strong>
                        <p class="font-semibold text-[#4A0F1A]">{{ $badge['label'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Aksi Admin --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Aksi Admin</h2>

                @if($pemesanan->status === 'menunggu')
                    <form method="POST" action="{{ route('admin.pemesanan.konfirmasi', $pemesanan->id) }}" class="space-y-2">
                        @csrf @method('PATCH')
                        <button type="submit" class="admin-btn-primary w-full">Konfirmasi Pesanan</button>
                    </form>
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                            class="admin-btn-danger w-full mt-2">
                        Tolak Pesanan
                    </button>

                @elseif($pemesanan->status === 'dikonfirmasi')
                    <p class="text-sm text-[#4A2E28] mb-3">Pesanan sudah dikonfirmasi. Menunggu pembayaran dari customer.</p>
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                            class="admin-btn-danger w-full">
                        Batalkan Pesanan
                    </button>

                @elseif($pemesanan->status === 'dibatalkan')
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm">
                        <p class="font-semibold text-red-700 mb-1">Pesanan telah ditolak/dibatalkan</p>
                        @if($pemesanan->alasan_penolakan)
                            <p class="text-red-600">Alasan: {{ $pemesanan->alasan_penolakan }}</p>
                        @endif
                    </div>

                @else
                    <p class="text-sm text-[#4A2E28]/60">Tidak ada aksi tersedia untuk status ini.</p>
                @endif

                <a href="{{ route('admin.pemesanan.index') }}" class="admin-btn-secondary w-full mt-2 block text-center">Kembali</a>
            </div>

            {{-- Validation error --}}
            @error('alasan_penolakan')
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
{{-- Modal: Alasan Penolakan/Pembatalan --}}
@if(in_array($pemesanan->status, ['menunggu', 'dikonfirmasi']))
<div id="modal-tolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white border border-gray-200 shadow-2xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 border border-red-200 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">
                    {{ $pemesanan->status === 'menunggu' ? 'Tolak Pesanan' : 'Batalkan Pesanan' }}
                </h3>
                <p class="text-xs text-gray-500">#{{ $pemesanan->kode_pemesanan }}</p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-4">
            Berikan alasan yang jelas agar pelanggan mengerti mengapa pesanan ini
            {{ $pemesanan->status === 'menunggu' ? 'ditolak' : 'dibatalkan' }}.
            Alasan ini akan ditampilkan ke pelanggan.
        </p>

        <form method="POST" action="{{ route('admin.pemesanan.tolak', $pemesanan->id) }}">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-600 mb-1.5">
                    Alasan {{ $pemesanan->status === 'menunggu' ? 'Penolakan' : 'Pembatalan' }}
                    <span class="text-red-500">*</span>
                </label>
                <textarea name="alasan_penolakan" rows="4" required minlength="10" maxlength="500"
                          placeholder="Contoh: Tanggal yang dipilih tidak tersedia, slot sudah penuh untuk periode tersebut..."
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100 resize-none transition">{{ old('alasan_penolakan') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Minimal 10 karakter, maksimal 500 karakter.</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 rounded-xl border border-gray-200 bg-white py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 rounded-xl bg-red-600 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                    Ya, {{ $pemesanan->status === 'menunggu' ? 'Tolak' : 'Batalkan' }} Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Buka ulang modal jika ada validation error
    @error('alasan_penolakan')
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tolak').classList.remove('hidden');
        });
    @enderror

    // Tutup modal klik backdrop
    document.getElementById('modal-tolak')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
</script>
@endif

@endsection
