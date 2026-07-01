<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembatalan Ditolak</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:32px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                <tr>
                    <td style="background-color:#800000;padding:32px 40px;text-align:center;">
                        <p style="margin:0 0 4px 0;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:#D4AF37;font-weight:700;">SANGGAR RANTIANG TAGOK</p>
                        <h1 style="margin:0;font-size:26px;font-weight:700;color:#ffffff;">SILART</h1>
                        <p style="margin:12px 0 0 0;font-size:13px;color:rgba(255,255,255,0.75);">Sistem Informasi Sanggar Rantiang Tagok</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#FFF0F0;padding:14px 40px;border-bottom:1px solid #F5C6CB;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#800000;text-align:center;">❌ &nbsp; PERMINTAAN PEMBATALAN DITOLAK</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 8px 0;font-size:15px;color:#555555;">Halo, <strong style="color:#333333;">{{ $pembatalan->user->name }}</strong></p>
                        <p style="margin:0 0 28px 0;font-size:15px;color:#555555;line-height:1.6;">
                            Mohon maaf, permintaan pembatalan pesanan Anda dengan kode <strong style="color:#800000;">#{{ $pembatalan->pemesanan->kode_pemesanan }}</strong> <strong>tidak dapat disetujui</strong>.
                        </p>
                        @if($pembatalan->catatan_admin)
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF0F0;border-radius:8px;border-left:4px solid #800000;margin-bottom:28px;">
                            <tr>
                                <td style="padding:14px 18px;">
                                    <p style="margin:0 0 4px 0;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#800000;">Alasan Penolakan</p>
                                    <p style="margin:0;font-size:13px;color:#800000;line-height:1.6;">{{ $pembatalan->catatan_admin }}</p>
                                </td>
                            </tr>
                        </table>
                        @endif
                        <p style="margin:0 0 28px 0;font-size:14px;color:#555;line-height:1.6;">
                            Pesanan Anda tetap aktif dan akan diproses sesuai jadwal. Jika ada pertanyaan, silakan hubungi kami.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('user.pemesanan.show', $pembatalan->pemesanan_id) }}" style="display:inline-block;background-color:#800000;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:8px;">Lihat Detail Pesanan</a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
                            Salam, <strong>Sanggar Rantiang Tagok</strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#f8f8f8;padding:20px 40px;border-top:1px solid #eeeeee;text-align:center;">
                        <p style="margin:0 0 4px 0;font-size:12px;color:#999;">Email ini dikirim otomatis oleh sistem SILART.</p>
                        <p style="margin:0;font-size:12px;color:#bbb;">Sanggar Rantiang Tagok &bull; Sistem Informasi Layanan Seni</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>