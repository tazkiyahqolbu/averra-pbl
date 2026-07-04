<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use App\Models\DetailPemesanan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanController extends Controller
{
    public function index()
{
    $bulanIni = Carbon::now()->month;
    $tahunIni = Carbon::now()->year;

    $pendapatanBulanIni = Pembayaran::where('status','terverifikasi')
        ->whereMonth('dibayar_pada',$bulanIni)
        ->whereYear('dibayar_pada',$tahunIni)
        ->sum('jumlah_bayar');

    $totalPemesanan = Pemesanan::count();

    $pemesananSelesai = Pemesanan::where('status','selesai')->count();

    $pemesananDibatalkan = Pemesanan::where('status','dibatalkan')->count();

    $rataOrder = Pemesanan::where('status','selesai')
        ->avg('total_harga');

    // Grafik
    $grafikPendapatan = [];

    for ($i = 1; $i <= 12; $i++) {

        $total = Pembayaran::where('status','terverifikasi')
            ->whereYear('dibayar_pada',$tahunIni)
            ->whereMonth('dibayar_pada',$i)
            ->sum('jumlah_bayar');

        $grafikPendapatan[] = [
            'bulan' => Carbon::create()->month($i)->translatedFormat('M'),
            'total' => $total,
        ];
    }

    $maxPendapatan = collect($grafikPendapatan)->max('total');

    if ($maxPendapatan == 0) {
        $maxPendapatan = 1;
    }

    $popularItems = DetailPemesanan::with([
    'barang',
    'jasa',
    'paket'
    ])
    ->get()
    ->map(function ($item) {

    if ($item->paket) {
        return [
            'nama' => $item->paket->nama_paket,
            'jenis' => 'Paket'
        ];
    }

    if ($item->barang) {
        return [
            'nama' => $item->barang->nama_barang,
            'jenis' => 'Barang'
        ];
    }

    if ($item->jasa) {
        return [
            'nama' => $item->jasa->nama_jasa,
            'jenis' => 'Jasa'
        ];
    }

    return null;

    })
    ->filter()
    ->groupBy('nama')
    ->map(function ($items, $nama) {

        return [
            'name' => $nama,
            'jenis' => $items->first()['jenis'],
            'count' => $items->count()
        ];

    })
    ->sortByDesc('count')
    ->take(5);

    $transactions = Pemesanan::with('user')
    ->latest()
    ->take(10)
    ->get()
    ->map(function ($item) {
        return [
            'kode' => $item->kode_pemesanan,
            'customer' => $item->nama_pemesan,
            'item' => $item->jenis,
            'total' => 'Rp ' . number_format($item->total_harga,0,',','.'),
            'status' => $item->status,
            'tanggal' => Carbon::parse($item->tanggal_pemesanan)->translatedFormat('d F Y'),
        ];
    });


    return view('admin.laporan.index', compact(
        'pendapatanBulanIni',
        'totalPemesanan',
        'pemesananSelesai',
        'pemesananDibatalkan',
        'rataOrder',
        'grafikPendapatan',
        'maxPendapatan',
        'popularItems',
        'transactions'
    ));
}

    public function exportExcel()
{
    $transactions = Pemesanan::latest()->get();

    $spreadsheet = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();


    // Judul laporan
    $sheet->mergeCells('A1:F1');
    $sheet->setCellValue('A1','LAPORAN TRANSAKSI AVERRA');

    $sheet->getStyle('A1')->getAlignment()->setHorizontal(
    Alignment::HORIZONTAL_CENTER
    );

    $sheet->getStyle('A2')->getAlignment()->setHorizontal(
        Alignment::HORIZONTAL_CENTER
    );

    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getFont()->setSize(16);

    // Tanggal export
    $sheet->mergeCells('A2:F2');
    $sheet->setCellValue(
        'A2',
        'Tanggal Export : '.Carbon::now()->translatedFormat('d F Y')
    );


    // Header tabel
    $sheet->setCellValue('A4','Kode Pesanan');
    $sheet->setCellValue('B4','Customer');
    $sheet->setCellValue('C4','Jenis');
    $sheet->setCellValue('D4','Total');
    $sheet->setCellValue('E4','Status');
    $sheet->setCellValue('F4','Tanggal');

    $row = 5;

    $sheet->getStyle('A4:F4')->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('4A0F1A');
    $sheet->getStyle('A4:F4')->getFont()
      ->getColor()
      ->setARGB('FFFFFF');
    $sheet->getStyle('A4:F4')->getFont()->setBold(true);

    foreach ($transactions as $trx) {

    $sheet->setCellValue('A'.$row, $trx->kode_pemesanan);
    $sheet->setCellValue('B'.$row, $trx->nama_pemesan);
    $sheet->setCellValue('C'.$row, ucfirst($trx->jenis));
    $sheet->setCellValue('D'.$row, 'Rp '.number_format($trx->total_harga,0,',','.'));
    $sheet->setCellValue('E'.$row, ucfirst($trx->status));
    $sheet->setCellValue('F'.$row, Carbon::parse($trx->tanggal_pemesanan)->translatedFormat('d F Y'));

    $row++;
}

    $lastRow = $row - 1;

$sheet->getStyle("A4:F{$lastRow}")
      ->getBorders()
      ->getAllBorders()
      ->setBorderStyle(Border::BORDER_THIN);

      foreach(range('A','F') as $column){

    $sheet->getColumnDimension($column)
          ->setAutoSize(true);

}

    $writer = new Xlsx($spreadsheet);

    $filename = 'Laporan_Transaksi.xlsx';

    $tempFile = tempnam(sys_get_temp_dir(), 'laporan');
    $writer->save($tempFile);

    return response()->download($tempFile, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Cache-Control' => 'max-age=0'
    ])->deleteFileAfterSend(true);
}
}
