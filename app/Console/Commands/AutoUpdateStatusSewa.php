<?php

namespace App\Console\Commands;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoUpdateStatusSewa extends Command
{
    protected $signature   = 'sewa:update-status';
    protected $description = 'Auto-ubah status sewa barang: sedang_disewa → menunggu_pengembalian pada hari H pengembalian';

    public function handle(): int
    {
        $today = Carbon::today()->toDateString();

        // Ambil semua pesanan sewa yang masih sedang_disewa dan hari ini = tanggal_kembali
        $pemesanans = Pemesanan::where('jenis', 'sewa_barang')
            ->where('status', 'sedang_disewa')
            ->whereHas('detailPemesanans', fn($q) => $q->whereDate('tanggal_kembali', $today))
            ->get();

        $diproses = 0;

        foreach ($pemesanans as $pemesanan) {
            $pemesanan->update(['status' => 'menunggu_pengembalian']);
            $diproses++;
            $this->info("✓ {$pemesanan->kode_pemesanan} → menunggu_pengembalian");
        }

        if ($diproses === 0) {
            $this->info('Tidak ada pesanan yang perlu diperbarui hari ini.');
        } else {
            $this->info("Selesai. {$diproses} pesanan diperbarui ke menunggu_pengembalian.");
        }

        return Command::SUCCESS;
    }
}
