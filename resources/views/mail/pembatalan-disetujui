@component('mail::message')
# Permintaan Pembatalan Disetujui

Halo **{{ $pembatalan->user->name }}**,

Permintaan pembatalan pesanan Anda dengan kode **#{{ $pembatalan->pemesanan->kode_pemesanan }}** telah **disetujui** oleh admin.

| Keterangan | Detail |
|---|---|
| Kode Pesanan | {{ $pembatalan->pemesanan->kode_pemesanan }} |
| Jumlah Refund | Rp {{ number_format($pembatalan->jumlah_refund, 0, ',', '.') }} |
| Rekening Tujuan | {{ $pembatalan->nama_bank }} – {{ $pembatalan->nomor_rekening }} |
| Atas Nama | {{ $pembatalan->nama_rekening }} |

@if($pembatalan->catatan_admin)
**Catatan Admin:** {{ $pembatalan->catatan_admin }}
@endif

Dana refund akan segera diproses dan ditransfer ke rekening Anda. Mohon tunggu konfirmasi lebih lanjut.

@component('mail::button', ['url' => route('user.pemesanan.show', $pembatalan->pemesanan_id)])
Lihat Detail Pesanan
@endcomponent

Terima kasih atas kepercayaan Anda.

Salam,<br>
**Sanggar Rantiang Tagok**
@endcomponent