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
                    <form method="POST" action="{{ route('admin.pemesanan.tolak', $pemesanan->id) }}" class="mt-2 space-y-2">
                        @csrf @method('PATCH')
                        <button type="submit" class="admin-btn-danger w-full">Tolak Pesanan</button>
                    </form>
                @elseif($pemesanan->status === 'dikonfirmasi')
                    <p class="text-sm text-[#4A2E28] mb-3">Pesanan sudah dikonfirmasi. Menunggu pembayaran dari customer.</p>
                    <form method="POST" action="{{ route('admin.pemesanan.tolak', $pemesanan->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="admin-btn-danger w-full">Batalkan Pesanan</button>
                    </form>
                @else
                    <p class="text-sm text-[#4A2E28]/60">Tidak ada aksi tersedia untuk status ini.</p>
                @endif

                <a href="{{ route('admin.pemesanan.index') }}" class="admin-btn-secondary w-full mt-2 block text-center">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
