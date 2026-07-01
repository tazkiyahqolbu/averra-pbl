<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembatalan Disetujui</title>
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
                    <td style="background-color:#E8F5E9;padding:14px 40px;border-bottom:1px solid #A5D6A7;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#2E7D32;text-align:center;">✅ &nbsp; PERMINTAAN PEMBATALAN DISETUJUI</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 8px 0;font-size:15px;color:#555555;">Halo, <strong style="color:#333333;">{{ $pembatalan->user->name }}</strong></p>
                        <p style="margin:0 0 28px 0;font-size:15px;color:#555555;line-height:1.6;">
                            Permintaan pembatalan pesanan Anda dengan kode <strong style="color:#800000;">#{{ $pembatalan->pemesanan->kode_pemesanan }}</strong> telah <strong style="color:#2E7D32;">disetujui</strong> oleh admin.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAF3E0;border-radius:10px;border:1px solid #E8D9A0;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 16px 0;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#800000;">Detail Refund</p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;width:140px;">Kode Pesanan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;font-family:monospace;">{{ $pembatalan->pemesanan->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Jumlah Refund</td>
                                            <td style="padding:6px 0;font-size:14px;font-weight:700;color:#800000;">Rp {{ number_format($pembatalan->jumlah_refund, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Rekening Tujuan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $pembatalan->nama_bank }} &ndash; {{ $pembatalan->nomor_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Atas Nama</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $pembatalan->nama_rekening }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        @if($pembatalan->catatan_admin)
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF0F0;border-radius:8px;border-left:4px solid #800000;margin-bottom:28px;">
                            <tr>
                                <td style="padding:14px 18px;">
                                    <p style="margin:0;font-size:13px;color:#800000;line-height:1.6;">
                                        <strong>Catatan Admin:</strong> {{ $pembatalan->catatan_admin }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                        @endif
                        <p style="margin:0 0 28px 0;font-size:14px;color:#555;line-height:1.6;">
                            Dana refund akan segera diproses dan ditransfer ke rekening Anda. Mohon tunggu konfirmasi lebih lanjut.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('user.pemesanan.show', $pembatalan->pemesanan_id) }}" style="display:inline-block;background-color:#800000;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:8px;">Lihat Detail Pesanan</a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
                            Terima kasih atas kepercayaan Anda.<br>
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