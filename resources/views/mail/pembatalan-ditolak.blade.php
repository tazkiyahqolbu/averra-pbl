@component('mail::message')
# Permintaan Pembatalan Ditolak

Halo **{{ $pembatalan->user->name }}**,

Mohon maaf, permintaan pembatalan pesanan Anda dengan kode **#{{ $pembatalan->pemesanan->kode_pemesanan }}** **tidak dapat disetujui**.

@if($pembatalan->catatan_admin)
**Alasan Penolakan:**
{{ $pembatalan->catatan_admin }}
@endif

Pesanan Anda tetap aktif dan akan diproses sesuai jadwal. Jika ada pertanyaan, silakan hubungi kami.

@component('mail::button', ['url' => route('user.pemesanan.show', $pembatalan->pemesanan_id)])
Lihat Detail Pesanan
@endcomponent

Salam,<br>
**Sanggar Rantiang Tagok**
@endcomponent