@component('mail::message')
# Pesanan Anda Telah Dikonfirmasi

Halo **{{ $pemesanan->nama_pemesan }}**,

Pesanan Anda dengan kode **#{{ $pemesanan->kode_pemesanan }}** telah dikonfirmasi oleh admin. Silakan lihat invoice Anda dan lakukan pembayaran.

| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pemesanan->kode_pemesanan }} |
| Tanggal Pakai | {{ $pemesanan->tanggal_pakai->format('d M Y') }} |
| Total Harga | Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }} |

@component('mail::button', ['url' => route('user.pemesanan.invoice', $pemesanan->id)])
Lihat Invoice
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
