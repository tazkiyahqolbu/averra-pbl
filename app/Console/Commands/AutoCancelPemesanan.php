<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCancelPemesanan extends Command
{
    protected $signature   = 'pemesanan:auto-cancel';
    protected $description = 'Batalkan otomatis pesanan yang tidak dikonfirmasi admin dalam 24 jam';

    public function handle(): int
    {
        $batas = Carbon::now()->subHours(24);

        $pesanans = Pemesanan::where('status', 'menunggu')
            ->where('created_at', '<=', $batas)
            ->with(['detailPemesanans.barang'])
            ->get();

        if ($pesanans->isEmpty()) {
            $this->info('Tidak ada pesanan yang perlu dibatalkan.');
            return Command::SUCCESS;
        }

        $jumlah = 0;
        foreach ($pesanans as $pesanan) {
            $pesanan->update([
                'status'           => 'dibatalkan',
                'alasan_penolakan' => 'Pesanan dibatalkan otomatis karena tidak dikonfirmasi admin dalam 1×24 jam.',
            ]);

            foreach ($pesanan->detailPemesanans as $detail) {
                if ($detail->barang_id && $detail->barang) {
                    $detail->barang->increment('stok', $detail->jumlah);
                }
            }

            $this->info("✓ Dibatalkan otomatis: {$pesanan->kode_pemesanan}");
            $jumlah++;
        }

        $this->newLine();
        $this->info("Selesai. Total dibatalkan: {$jumlah} pesanan.");
        return Command::SUCCESS;
    }
}
