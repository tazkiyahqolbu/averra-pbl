@component('mail::message')
# Tagihan Pelunasan

Halo **{{ $pesanan->nama_pemesan }}**,

@if($pesanan->jenis === 'acara')
Acara Anda telah selesai dilaksanakan. Berikut adalah rincian tagihan pelunasan yang perlu segera diselesaikan.
@else
Barang yang Anda sewa telah **diterima kembali** oleh sanggar. Berikut adalah rincian tagihan pelunasan yang perlu segera diselesaikan.
@endif

@php
    $detail    = $pesanan->detailPemesanans->first();
    $dpDibayar = (float) $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->sum('jumlah_bayar');
    $sisaBayar = max(0, (float) $pesanan->total_harga - $dpDibayar);

    if ($pesanan->jenis === 'sewa_barang') {
        $namaItem       = $detail?->barang?->nama_barang ?? '-';
        $tglAmbil       = $detail?->tanggal_ambil?->format('d M Y') ?? '-';
        $tglKembali     = $detail?->tanggal_kembali?->format('d M Y') ?? '-';
        $pengembalian   = \App\Models\PengembalianBarang::whereHas('detailPemesanan', fn($q) => $q->where('pemesanan_id', $pesanan->id))->first();
        $dendaKeterlambatan = $pengembalian ? (float) $pengembalian->denda_keterlambatan : 0;
        $dendaKerusakan     = $pengembalian ? (float) $pengembalian->denda_kerusakan : 0;
        $totalDenda         = $pengembalian ? (float) $pengembalian->total_denda : 0;
    } else {
        $namaItem       = $detail?->paket?->nama_paket ?? $detail?->jasa?->nama_jasa ?? '-';
        $totalDenda     = 0;
        $dendaKeterlambatan = 0;
        $dendaKerusakan     = 0;
    }
    $totalTagihan = $sisaBayar + $totalDenda;
@endphp

@if($pesanan->jenis === 'sewa_barang')
| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pesanan->kode_pemesanan }} |
| Barang | {{ $namaItem }} |
| Tanggal Ambil | {{ $tglAmbil }} |
| Tanggal Kembali (Jadwal) | {{ $tglKembali }} |
| Total Harga Sewa | Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} |
| DP Sudah Dibayar | Rp {{ number_format($dpDibayar, 0, ',', '.') }} |
| **Sisa Sewa** | **Rp {{ number_format($sisaBayar, 0, ',', '.') }}** |
@else
| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pesanan->kode_pemesanan }} |
| Layanan | {{ $namaItem }} |
| Tanggal Acara | {{ $pesanan->tanggal_pakai?->format('d M Y') ?? '-' }} |
| Total Harga | Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} |
| DP Sudah Dibayar | Rp {{ number_format($dpDibayar, 0, ',', '.') }} |
| **Sisa Pelunasan** | **Rp {{ number_format($sisaBayar, 0, ',', '.') }}** |
@endif

@if($totalDenda > 0)
---

**Rincian Denda:**

| Jenis Denda | Jumlah |
|---|---|
@if($dendaKeterlambatan > 0)
| Denda Keterlambatan | Rp {{ number_format($dendaKeterlambatan, 0, ',', '.') }} |
@endif
@if($dendaKerusakan > 0)
| Denda Kerusakan | Rp {{ number_format($dendaKerusakan, 0, ',', '.') }} |
@endif
| **Total Denda** | **Rp {{ number_format($totalDenda, 0, ',', '.') }}** |

@endif

---

## Total yang Harus Dibayar: Rp {{ number_format($totalTagihan, 0, ',', '.') }}

Klik tombol di bawah untuk melakukan pembayaran pelunasan melalui sistem kami.

@component('mail::button', ['url' => route('user.pemesanan.show', $pesanan->id)])
Bayar Pelunasan Sekarang
@endcomponent

Pembayaran akan diproses melalui Midtrans. Pesanan Anda akan selesai setelah pelunasan berhasil diverifikasi.

Terima kasih atas kepercayaan Anda.

Salam,<br>
**Sanggar Rantiang Tagok**
@endcomponent