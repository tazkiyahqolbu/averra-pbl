<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $pesanan->kode_pemesanan }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #4A2E28;
            background: #fff;
            padding: 40px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 2px solid #E2D4C0;
        }
        .header-left .label {
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C8960C;
            font-weight: bold;
        }
        .header-left .kode {
            font-size: 22px;
            color: #4A0F1A;
            margin-top: 4px;
        }
        .header-left .tanggal {
            font-size: 10px;
            color: #7A5C52;
            margin-top: 4px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .nama-sanggar {
            font-size: 18px;
            font-weight: bold;
            color: #4A0F1A;
            letter-spacing: 2px;
        }
        .header-right .alamat {
            font-size: 10px;
            color: #7A5C52;
            margin-top: 4px;
            line-height: 1.6;
        }

        /* ── Info Box ── */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-box {
            display: table-cell;
            width: 50%;
            background: #FAF3E0;
            border: 1px solid #E2D4C0;
            padding: 12px 16px;
            vertical-align: top;
        }
        .info-box:first-child {
            border-right: none;
        }
        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #C8960C;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .info-value {
            font-size: 12px;
            font-weight: bold;
            color: #4A0F1A;
            margin-bottom: 3px;
        }
        .info-sub {
            font-size: 10px;
            color: #7A5C52;
        }

        /* ── Tabel Item ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        thead tr {
            background: #FAF3E0;
        }
        th {
            padding: 10px 12px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4A2E28;
            font-weight: bold;
            border: 1px solid #E2D4C0;
            text-align: left;
        }
        th.center { text-align: center; }
        th.right  { text-align: right; }
        td {
            padding: 10px 12px;
            border: 1px solid #E2D4C0;
            color: #4A2E28;
            font-size: 11px;
        }
        td.center { text-align: center; }
        td.right  { text-align: right; }
        td.bold   { font-weight: bold; color: #4A0F1A; }
        tbody tr:nth-child(even) { background: #FDFAF5; }

        /* ── Ringkasan Total ── */
        .total-section {
            width: 280px;
            margin-left: auto;
            margin-bottom: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 11px;
            color: #7A5C52;
        }
        .total-row.grand {
            border-top: 1px dashed #E2D4C0;
            margin-top: 6px;
            padding-top: 10px;
            font-size: 13px;
            font-weight: bold;
            color: #4A0F1A;
        }
        .total-row.grand .amount {
            color: #C8960C;
            font-size: 15px;
        }

        /* ── Status Pembayaran ── */
        .payment-box {
            background: #FAF3E0;
            border: 1px solid #E2D4C0;
            padding: 14px 16px;
            margin-bottom: 20px;
        }
        .payment-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #C8960C;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #7A5C52;
            margin-bottom: 4px;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
            margin-top: 6px;
            border: 1px solid;
        }
        .badge-green  { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .badge-yellow { background: #fffbeb; color: #b45309; border-color: #fde68a; }
        .badge-red    { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
        .badge-gray   { background: #fff; color: #4A2E28; border-color: #E2D4C0; }

        /* ── Footer ── */
        .footer {
            border-top: 1px solid #E2D4C0;
            padding-top: 16px;
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #9A8070;
            line-height: 1.8;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="label">Official Invoice</div>
            <div class="kode">#{{ $pesanan->kode_pemesanan }}</div>
            <div class="tanggal">Tanggal: {{ $pesanan->created_at->format('d M Y') }}</div>
        </div>
        <div class="header-right">
            <div class="nama-sanggar">Sanggar Rantiang Tagok</div>
            <div class="alamat">
                Gedung Serbaguna Politeknik Negeri Padang<br>
                Kampus Limau Manis, Kota Padang
            </div>
        </div>
    </div>

    {{-- Info Pemesan & Pelaksanaan --}}
    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">Ditagihkan Kepada</div>
            <div class="info-value">{{ $pesanan->nama_pemesan }}</div>
            <div class="info-sub">{{ $pesanan->no_hp }}</div>
            <div class="info-sub">{{ $pesanan->lokasi ?? 'Diambil langsung ke store' }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">Detail Pelaksanaan</div>
            <div class="info-value">{{ $pesanan->jenis === 'sewa_barang' ? 'Sewa Barang' : 'Paket Acara / Jasa' }}</div>
            <div class="info-sub">Tanggal Penggunaan</div>
            <div class="info-sub" style="font-weight:bold; color:#4A0F1A;">
                {{ $pesanan->tanggal_pakai ? $pesanan->tanggal_pakai->format('d F Y') : '-' }}
            </div>
        </div>
    </div>

    {{-- Tabel Item --}}
    @php $total_item_cost = 0; @endphp
    <table>
        <thead>
            <tr>
                <th>Nama Produk / Layanan</th>
                <th class="center" style="width:60px;">Jml</th>
                <th class="right" style="width:130px;">Harga Satuan</th>
                <th class="right" style="width:130px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPemesanans as $detail)
                @php
                    $namaItem = match($detail->jenis_item) {
                        'barang' => optional($detail->barang)->nama_barang ?? '-',
                        'jasa'   => optional($detail->jasa)->nama_jasa ?? '-',
                        'paket'  => optional($detail->paket)->nama_paket ?? '-',
                        default  => '-',
                    };
                    $total_item_cost += $detail->subtotal;
                @endphp
                <tr>
                    <td class="bold">{{ $namaItem }}</td>
                    <td class="center">{{ $detail->jumlah }}</td>
                    <td class="right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="right bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Ringkasan Total --}}
    <div class="total-section">
        <div class="total-row">
            <span>Total Item</span>
            <span>Rp {{ number_format($total_item_cost, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Ongkos Lokasi</span>
            <span>Rp {{ number_format($pesanan->ongkos_lokasi ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand">
            <span>Total Keseluruhan</span>
            <span class="amount">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Status Pembayaran --}}
    @if($pesanan->pembayarans->isNotEmpty())
        @php
            $bayar      = $pesanan->pembayarans->first();
            $sudahBayar = $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
            $sisa       = $pesanan->total_harga - $sudahBayar;
            $badgeClass = match($bayar->status) {
                'terverifikasi' => 'badge-green',
                'menunggu'      => 'badge-yellow',
                'ditolak'       => 'badge-red',
                default         => 'badge-gray',
            };
            $badgeLabel = match($bayar->status) {
                'terverifikasi' => 'Terverifikasi',
                'menunggu'      => 'Menunggu Verifikasi',
                'ditolak'       => 'Ditolak',
                default         => ucfirst($bayar->status),
            };
        @endphp
        <div class="payment-box">
            <div class="payment-label">Status Pembayaran</div>
            <div class="payment-row">
                <span>{{ $bayar->tahap === 'langsung' ? 'Bayar Lunas' : 'DP (50%)' }}</span>
                <span>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            @if($bayar->tahap !== 'langsung' && $sisa > 0)
                <div class="payment-row">
                    <span>Sisa Pelunasan</span>
                    <span style="font-weight:bold; color:#4A0F1A;">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                </div>
            @endif
            <div><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></div>
        </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>Terima kasih telah mempercayakan dekorasi dan perlengkapan event Anda bersama Sanggar Rantiang Tagok.</p>
        <p>Dokumen ini diterbitkan secara otomatis dan sah tanpa tanda tangan basah.</p>
    </div>

</body>
</html>