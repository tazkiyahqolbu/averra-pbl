@component('mail::message')
# Tagihan Pelunasan Sewa Barang

Halo **{{ $pesanan->nama_pemesan }}**,

Barang yang Anda sewa telah **diterima kembali** oleh sanggar. Berikut adalah rincian tagihan pelunasan yang perlu segera diselesaikan.

@php
    $detail     = $pesanan->detailPemesanans->first();
    $namaBarang = $detail?->barang?->nama_barang ?? '-';
    $tglAmbil   = $detail?->tanggal_ambil?->format('d M Y') ?? '-';
    $tglKembali = $detail?->tanggal_kembali?->format('d M Y') ?? '-';

    $dpDibayar  = (float) $pesanan->pembayarans->where('tahap', 'dp')->where('status', 'terverifikasi')->sum('jumlah_bayar');
    $sisaSewa   = max(0, (float) $pesanan->total_harga - $dpDibayar);

    $pengembalian   = \App\Models\PengembalianBarang::whereHas('detailPemesanan', fn($q) => $q->where('pemesanan_id', $pesanan->id))->first();
    $dendaKeterlambatan = $pengembalian ? (float) $pengembalian->denda_keterlambatan : 0;
    $dendaKerusakan     = $pengembalian ? (float) $pengembalian->denda_kerusakan : 0;
    $totalDenda         = $pengembalian ? (float) $pengembalian->total_denda : 0;
    $totalTagihan       = $sisaSewa + $totalDenda;
@endphp

| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pesanan->kode_pemesanan }} |
| Barang | {{ $namaBarang }} |
| Tanggal Ambil | {{ $tglAmbil }} |
| Tanggal Kembali (Jadwal) | {{ $tglKembali }} |
| Total Harga Sewa | Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} |
| DP Sudah Dibayar | Rp {{ number_format($dpDibayar, 0, ',', '.') }} |
| **Sisa Sewa** | **Rp {{ number_format($sisaSewa, 0, ',', '.') }}** |

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

Pembayaran akan diproses melalui Midtrans. Pesanan Anda akan selesai setelah pelunasan berhasil.

Terima kasih atas kepercayaan Anda.

Salam,<br>
**Sanggar Rantiang Tagok**
@endcomponent
