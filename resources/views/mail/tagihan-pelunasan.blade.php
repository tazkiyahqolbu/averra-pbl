<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Pelunasan Sewa Barang</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
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
                    <td style="background-color:#FFF3CD;padding:14px 40px;border-bottom:1px solid #FFD700;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#856404;text-align:center;">🧾 &nbsp; TAGIHAN PELUNASAN SEWA BARANG</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 8px 0;font-size:15px;color:#555555;">Halo, <strong style="color:#333333;">{{ $pesanan->nama_pemesan }}</strong></p>
                        <p style="margin:0 0 28px 0;font-size:15px;color:#555555;line-height:1.6;">
                            Barang yang Anda sewa telah <strong style="color:#333;">diterima kembali</strong> oleh sanggar. Berikut adalah rincian tagihan pelunasan yang perlu segera diselesaikan.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAF3E0;border-radius:10px;border:1px solid #E8D9A0;margin-bottom:20px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 16px 0;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#800000;">Detail Sewa</p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;width:160px;">Kode Pesanan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;font-family:monospace;">{{ $pesanan->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Barang</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#333;">{{ $namaBarang }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Tanggal Ambil</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $tglAmbil }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Tanggal Kembali (Jadwal)</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">{{ $tglKembali }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Total Harga Sewa</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">DP Sudah Dibayar</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">Rp {{ number_format($dpDibayar, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#800000;">Sisa Sewa</td>
                                            <td style="padding:6px 0;font-size:14px;font-weight:700;color:#800000;">Rp {{ number_format($sisaSewa, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        @if($totalDenda > 0)
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF0F0;border-radius:10px;border:1px solid #F5C6CB;margin-bottom:20px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 16px 0;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#800000;">Rincian Denda</p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        @if($dendaKeterlambatan > 0)
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;width:160px;">Denda Keterlambatan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">Rp {{ number_format($dendaKeterlambatan, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                        @if($dendaKerusakan > 0)
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#888;">Denda Kerusakan</td>
                                            <td style="padding:6px 0;font-size:13px;font-weight:600;color:#333;">Rp {{ number_format($dendaKerusakan, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;font-weight:700;color:#800000;">Total Denda</td>
                                            <td style="padding:6px 0;font-size:14px;font-weight:700;color:#800000;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        @endif
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#800000;border-radius:10px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:18px 24px;text-align:center;">
                                    <p style="margin:0 0 4px 0;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.75);">Total yang Harus Dibayar</p>
                                    <p style="margin:0;font-size:24px;font-weight:700;color:#ffffff;">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0 0 20px 0;font-size:14px;color:#555;line-height:1.6;">
                            Klik tombol di bawah untuk melakukan pembayaran pelunasan melalui sistem kami.
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('user.pemesanan.show', $pesanan->id) }}" style="display:inline-block;background-color:#800000;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:8px;">Bayar Pelunasan Sekarang</a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:0;font-size:14px;color:#555;line-height:1.6;">
                            Pembayaran akan diproses melalui Midtrans. Pesanan Anda akan selesai setelah pelunasan berhasil.<br><br>
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
