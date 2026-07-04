<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Pengembalian Barang</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:32px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                <tr>
                    <td style="background-color:#800000;padding:32px 40px;text-align:center;">
                        <p style="margin:0 0 4px 0;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:#D4AF37;font-weight:700;">SANGGAR RANTIANG TAGOK</p>
                        <h1 style="margin:0;font-size:26px;font-weight:700;color:#ffffff;">Sanggar Rantiang Tagok</h1>
                        <p style="margin:12px 0 0 0;font-size:13px;color:rgba(255,255,255,0.75);">Sistem Informasi Sanggar Rantiang Tagok</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#FFF3CD;padding:14px 40px;border-bottom:1px solid #FFD700;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#856404;text-align:center;">⏰ &nbsp; PENGINGAT PENGEMBALIAN — BESOK</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 8px 0;font-size:15px;color:#555555;">Halo, <strong style="color:#333333;">{{ $pemesanan->nama_pemesan }}</strong></p>
                        <p style="margin:0 0 28px 0;font-size:15px;color:#555555;line-height:1.6;">
                            Ini adalah pengingat bahwa barang sewa kamu harus dikembalikan
                            <strong style="color:#800000;">besok</strong>. Pastikan barang sudah siap dikembalikan tepat waktu ya.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAF3E0;border-radius:10px;border:1px solid #E8D9A0;margin-bottom:28px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 16px 0;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#800000;">Detail Sewa</p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;width:140px;">Kode Pesanan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;font-family:monospace;">{{ $pemesanan->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Barang Disewa</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;">
                                                {{ $detail->barang?->nama_barang ?? 'Barang Sewa' }}
                                                @if($detail->jumlah > 1)
                                                    <span style="color:#888;font-weight:400;">({{ $detail->jumlah }} unit)</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Tanggal Ambil</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $detail->tanggal_ambil?->translatedFormat('d F Y') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Batas Kembali</td>
                                            <td style="padding:6px 0;font-size:14px;font-weight:700;color:#800000;">{{ $detail->tanggal_kembali?->translatedFormat('d F Y') ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF0F0;border-radius:8px;border-left:4px solid #800000;margin-bottom:28px;">
                            <tr>
                                <td style="padding:14px 18px;">
                                    <p style="margin:0;font-size:13px;color:#800000;line-height:1.6;">
                                        <strong>Keterlambatan pengembalian</strong> dapat dikenakan biaya tambahan sesuai ketentuan sanggar. Jika ada kendala, segera hubungi kami.
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
                            Terima kasih telah mempercayai Sanggar Rantiang Tagok.<br>
                            Sampai jumpa kembali! 🎭
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#f8f8f8;padding:20px 40px;border-top:1px solid #eeeeee;text-align:center;">
                        <p style="margin:0 0 4px 0;font-size:12px;color:#999;">Email ini dikirim otomatis oleh sistem Sanggar Rantiang Tagok.</p>
                        <p style="margin:0;font-size:12px;color:#bbb;">Sanggar Rantiang Tagok &bull; Sistem Informasi Layanan Seni</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>