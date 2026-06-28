@component('mail::message')
# Pembayaran Berhasil!

Halo **{{ $pesanan->nama_pemesan }}**,

Pembayaran {{ $tahap === 'pelunasan' ? 'pelunasan' : 'DP' }} untuk pesanan Anda telah berhasil diverifikasi.

| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pesanan->kode_pemesanan }} |
| Tanggal Pakai | {{ $pesanan->tanggal_pakai->format('d M Y') }} |
| Status Pesanan | {{ $tahap === 'pelunasan' ? 'Selesai' : 'Berlangsung' }} |
| Total Harga | Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} |

@if($tahap !== 'pelunasan')
Silakan lakukan pelunasan pembayaran sebelum tanggal pakai.

@component('mail::button', ['url' => route('user.pemesanan.show', $pesanan->id)])
Lihat Detail Pesanan
@endcomponent

@else
Terima kasih telah menggunakan layanan kami. Sampai jumpa di acara Anda!
@endif

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent