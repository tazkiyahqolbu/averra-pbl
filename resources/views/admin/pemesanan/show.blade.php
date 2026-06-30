@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
@php
    $statusMap = [
        'menunggu'              => ['label' => 'Menunggu Konfirmasi',   'class' => 'badge-warning'],
        'dikonfirmasi'          => ['label' => 'Menunggu Pembayaran',   'class' => 'badge-warning'],
        'berlangsung'           => ['label' => 'Berlangsung',            'class' => 'badge-active'],
        'selesai'               => ['label' => 'Selesai',               'class' => 'badge-neutral'],
        'dibatalkan'            => ['label' => 'Dibatalkan',            'class' => 'badge-inactive'],
        'menunggu_dp'           => ['label' => 'Menunggu DP',           'class' => 'badge-warning'],
        'menunggu_diambil'      => ['label' => 'Menunggu Diambil',      'class' => 'badge-warning'],
        'sedang_disewa'         => ['label' => 'Sedang Disewa',         'class' => 'badge-active'],
        'menunggu_pengembalian' => ['label' => 'Menunggu Pengembalian', 'class' => 'badge-active'],
        'menunggu_pelunasan'    => ['label' => 'Menunggu Pelunasan',    'class' => 'badge-warning'],
    ];
    $badge      = $statusMap[$pemesanan->status] ?? ['label' => ucfirst($pemesanan->status), 'class' => 'badge-neutral'];
    $jenisLabel = $pemesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Acara';
    $isSewa     = $pemesanan->jenis === 'sewa_barang';

    $maskEmail = function(?string $email): string {
        if (!$email || !str_contains($email, '@')) return '-';
        [$local, $domain] = explode('@', $email, 2);
        $maskedLocal  = substr($local, 0, 2) . str_repeat('*', max(2, strlen($local) - 2));
        $dotPos       = strrpos($domain, '.');
        $domainName   = substr($domain, 0, $dotPos);
        $tld          = substr($domain, $dotPos);
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
    @if(session('error'))
        <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-3 text-sm font-semibold text-red-800">
            {{ session('error') }}
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
                    <p><span class="admin-muted text-sm">No. HP</span><br><strong>{{ $maskPhone($pemesanan->no_hp ?? $pemesanan->user?->no_hp) }}</strong></p>
                </div>
            </div>

            {{-- Detail Pesanan --}}
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Detail Pesanan</h2>
                @php
                    $detail     = $pemesanan->detailPemesanans->first();
                    $tglAmbil   = $detail?->tanggal_ambil;
                    $tglKembali = $detail?->tanggal_kembali;
                @endphp
                <div class="grid gap-3 md:grid-cols-2 mb-4">
                    <p><span class="admin-muted text-sm">Jenis</span><br><strong>{{ $jenisLabel }}</strong></p>
                    @if($isSewa)
                        <p><span class="admin-muted text-sm">Tanggal Ambil</span><br><strong>{{ $tglAmbil ? \Carbon\Carbon::parse($tglAmbil)->format('d F Y') : '-' }}</strong></p>
                        <p><span class="admin-muted text-sm">Tanggal Kembali</span><br><strong>{{ $tglKembali ? \Carbon\Carbon::parse($tglKembali)->format('d F Y') : '-' }}</strong></p>
                        @if($tglAmbil && $tglKembali)
                            <p><span class="admin-muted text-sm">Durasi</span><br><strong>{{ \Carbon\Carbon::parse($tglAmbil)->diffInDays(\Carbon\Carbon::parse($tglKembali)) + 1 }} hari</strong></p>
                        @endif
                        <p><span class="admin-muted text-sm">Metode Pengambilan</span><br>
                            <strong>{{ $pemesanan->metode_pengambilan === 'dikirim' ? 'Dikirim ke Lokasi' : 'Ambil Sendiri ke Sanggar' }}</strong>
                        </p>
                        <p><span class="admin-muted text-sm">Metode Pengembalian</span><br>
                            <strong>{{ $pemesanan->metode_pengembalian === 'dijemput' ? 'Dijemput Tim Kami' : 'Antar Sendiri ke Sanggar' }}</strong>
                        </p>
                    @else
                        <p><span class="admin-muted text-sm">Tanggal Pakai</span><br><strong>{{ $pemesanan->tanggal_pakai ? \Carbon\Carbon::parse($pemesanan->tanggal_pakai)->format('d F Y') : '-' }}</strong></p>
                        <p><span class="admin-muted text-sm">Lokasi / Zona</span><br><strong>{{ $pemesanan->zonaLokasi?->nama_zona ?? '-' }}</strong></p>
                        <p><span class="admin-muted text-sm">Keterangan Lokasi</span><br><strong>{{ $pemesanan->lokasi ?? '-' }}</strong></p>
                    @endif
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
                        @foreach($pemesanan->detailPemesanans as $det)
                            @php
                                $nama = $det->barang?->nama_barang
                                     ?? $det->jasa?->nama_jasa
                                     ?? $det->paket?->nama_paket
                                     ?? '-';
                            @endphp
                            <tr class="border-b border-[#E2D4C0]">
                                <td class="p-2 text-[#4A2E28]">{{ $nama }}</td>
                                <td class="p-2 text-center text-[#4A2E28]">{{ $det->jumlah }}</td>
                                <td class="p-2 text-right font-semibold text-[#4A0F1A]">Rp {{ number_format($det->subtotal, 0, ',', '.') }}</td>
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
                    @if($isSewa)
                        <p class="admin-muted text-sm">DP 50%: Rp {{ number_format($pemesanan->total_harga * 0.5, 0, ',', '.') }} + Pelunasan setelah pengembalian</p>
                    @else
                        @php $tahap = $pemesanan->pembayarans->first()?->tahap; @endphp
                        <p class="admin-muted text-sm">
                            Metode Bayar: {{ $tahap === 'langsung' ? 'Lunas' : 'DP 50% (Rp ' . number_format($pemesanan->total_harga * 0.5, 0, ',', '.') . ') + Pelunasan' }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Riwayat Pembayaran --}}
            @if($pemesanan->pembayarans->isNotEmpty())
                <div class="admin-card p-5">
                    <h2 class="admin-title mb-4 text-xl">Riwayat Pembayaran</h2>
                    <div class="space-y-3">
                        @foreach($pemesanan->pembayarans->sortBy('id') as $bayar)
                            <div class="flex items-center justify-between rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm">
                                <div>
                                    <p class="font-semibold text-[#4A0F1A]">{{ strtoupper($bayar->tahap) }}</p>
                                    <p class="admin-muted text-xs">{{ $bayar->kode_transaksi }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-[#4A0F1A]">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $bayar->status_pembayaran === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($bayar->status_pembayaran) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Panel Aksi Admin --}}
        <div class="space-y-5">
            <div class="admin-card p-5">
                <h2 class="admin-title mb-4 text-xl">Aksi Admin</h2>
                <div class="flex flex-col gap-3">
                    @if($pemesanan->status === 'menunggu')
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="menunggu_dp">
                            <button type="submit" class="w-full btn bg-[#4A0F1A] text-white py-2.5 rounded-xl hover:bg-[#7B1C2E] font-semibold transition">Konfirmasi & Tagih DP</button>
                        </form>
                    @endif

                    @if($pemesanan->status === 'menunggu_diambil')
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="sedang_disewa">
                            <button type="submit" class="w-full btn bg-blue-600 text-white py-2.5 rounded-xl hover:bg-blue-700 font-semibold transition">Barang Sudah Diambil</button>
                        </form>
                    @endif

                    @if($pemesanan->status === 'sedang_disewa')
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="menunggu_pengembalian">
                            <button type="submit" class="w-full btn bg-orange-500 text-white py-2.5 rounded-xl hover:bg-orange-600 font-semibold transition">Tandai Masa Sewa Berakhir</button>
                        </form>
                    @endif

                    @if($pemesanan->status === 'menunggu_pengembalian')
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="menunggu_pelunasan">
                            <button type="submit" class="w-full btn bg-indigo-600 text-white py-2.5 rounded-xl hover:bg-indigo-700 font-semibold transition">Barang Sudah Dikembalikan</button>
                        </form>
                    @endif

                    @if($pemesanan->status === 'menunggu_pelunasan')
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="w-full btn bg-green-600 text-white py-2.5 rounded-xl hover:bg-green-700 font-semibold transition">Konfirmasi Pelunasan & Selesai</button>
                        </form>
                    @endif

                    @if(in_array($pemesanan->status, ['menunggu', 'menunggu_dp', 'menunggu_diambil']))
                        <form action="{{ route('admin.pemesanan.update-status', $pemesanan->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="dibatalkan">
                            <button type="submit" class="w-full btn bg-red-600 text-white py-2.5 rounded-xl hover:bg-red-700 font-semibold transition">Batalkan Pesanan</button>
                        </form>
                    @endif

                    <a href="{{ route('admin.pemesanan.index') }}" class="w-full text-center text-sm text-[#4A2E28] hover:underline mt-2">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
