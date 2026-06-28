<?php

namespace App\Console\Commands;

use App\Mail\ReminderPengembalian;
use App\Models\Barang;
use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimReminderPengembalian extends Command
{
    protected $signature   = 'reminder:pengembalian {--test : Kirim email tes tanpa cek database} {--to= : Override email tujuan untuk keperluan pengujian}';
    protected $description = 'Kirim email reminder pengembalian barang H-1 ke pemesan';

    public function handle(): int
    {
        if ($this->option('test')) {
            return $this->handleTest();
        }

        $besok = Carbon::tomorrow()->toDateString();

        $pemesanans = Pemesanan::where('status', 'berlangsung')
            ->where('jenis', 'sewa_barang')
            ->whereHas('detailPemesanans', fn($q) => $q->whereDate('tanggal_kembali', $besok))
            ->with([
                'user',
                'detailPemesanans' => fn($q) => $q->whereDate('tanggal_kembali', $besok)->with('barang'),
            ])
            ->get();

        if ($pemesanans->isEmpty()) {
            $this->info('Tidak ada pengembalian besok. Tidak ada email dikirim.');
            return Command::SUCCESS;
        }

        $terkirim      = 0;
        $gagal         = 0;
        $overrideEmail = $this->option('to');

        foreach ($pemesanans as $pemesanan) {
            $email = $overrideEmail ?: $pemesanan->user?->email;
            if (!$email) {
                $this->warn("Pesanan {$pemesanan->kode_pemesanan}: user tidak punya email, dilewati.");
                continue;
            }

            foreach ($pemesanan->detailPemesanans as $detail) {
                try {
                    Mail::to($email)->queue(new ReminderPengembalian($pemesanan, $detail));
                    $this->info("✓ Terkirim ke {$email} — {$pemesanan->kode_pemesanan}");
                    $terkirim++;
                } catch (\Throwable $e) {
                    $this->error("✗ Gagal ke {$email}: {$e->getMessage()}");
                    $gagal++;
                }
            }
        }

        $this->newLine();
        $this->info("Selesai. Terkirim: {$terkirim} | Gagal: {$gagal}");
        return Command::SUCCESS;
    }

    private function handleTest(): int
    {
        $targetEmail = $this->option('to') ?: config('mail.from.address');
        $fakeBarang  = new Barang(['nama_barang' => 'Kostum Tari Minang (CONTOH)']);
        $fakeDetail  = new DetailPemesanan([
            'jumlah'          => 2,
            'tanggal_ambil'   => Carbon::today()->toDateString(),
            'tanggal_kembali' => Carbon::tomorrow()->toDateString(),
        ]);
        $fakeDetail->setRelation('barang', $fakeBarang);
        $fakePemesanan = new Pemesanan([
            'kode_pemesanan' => 'PMB-TEST001',
            'nama_pemesan'   => 'Pemesan Contoh',
            'status'         => 'berlangsung',
            'jenis'          => 'sewa_barang',
        ]);

        $this->info("Mengirim email tes ke: {$targetEmail} ...");
        try {
            Mail::to($targetEmail)->queue(new ReminderPengembalian($fakePemesanan, $fakeDetail));
            $this->info('✓ Email tes berhasil dikirim! Cek inbox.');
        } catch (\Throwable $e) {
            $this->error('✗ Gagal kirim: ' . $e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
