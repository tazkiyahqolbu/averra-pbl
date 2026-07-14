<?php

namespace Tests\Feature\Scheduler;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderPengembalian;
use Carbon\Carbon;
use Tests\TestCase;

class KirimReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_reminder_email_is_sent_for_tomorrow_return()
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'test@example.com']);
        
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-REM01',
            'user_id' => $user->id,
            'tanggal_pemesanan' => Carbon::now()->subDays(2)->toDateString(),
            'tanggal_pakai' => Carbon::now()->subDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '081234567890',
            'total_harga' => 10000,
            'status' => 'sedang_disewa',
        ]);

        DetailPemesanan::create([
            'pemesanan_id' => $pesanan->id,
            'jenis_item' => 'barang',
            'jumlah' => 1,
            'harga' => 10000,
            'subtotal' => 10000,
            'tanggal_ambil' => Carbon::now()->subDays(2)->toDateString(),
            'tanggal_kembali' => Carbon::tomorrow()->toDateString(), // return date is tomorrow
        ]);

        $exitCode = Artisan::call('reminder:pengembalian');
        $this->assertEquals(0, $exitCode);

        Mail::assertQueued(ReminderPengembalian::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
