<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Dikonfirmasi</title>
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
                    <td style="background-color:#E3F2FD;padding:14px 40px;border-bottom:1px solid #90CAF9;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#1565C0;text-align:center;">📄 &nbsp; PESANAN ANDA TELAH DIKONFIRMASI</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 8px 0;font-size:15px;color:#555555;">Halo, <strong style="color:#333333;">{{ $pemesanan->nama_pemesan }}</strong></p>
                        <p style="margin:0 0 28px 0;font-size:15px;color:#555555;line-height:1.6;">
                            Pesanan Anda dengan kode <strong style="color:#800000;">#{{ $pemesanan->kode_pemesanan }}</strong> telah dikonfirmasi oleh admin. Silakan lihat invoice Anda dan lakukan pembayaran.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAF3E0;border-radius:10px;border:1px solid #E8D9A0;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 16px 0;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#800000;">Detail Pesanan</p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;width:140px;">Kode Pesanan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;font-family:monospace;">{{ $pemesanan->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Tanggal Pakai</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $pemesanan->tanggal_pakai->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Total Harga</td>
                                            <td style="padding:6px 0;font-size:14px;font-weight:700;color:#800000;">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('user.pemesanan.invoice', $pemesanan->id) }}" style="display:inline-block;background-color:#800000;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:8px;">Lihat Invoice</a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
                            Terima kasih,<br>{{ config('app.name') }}
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