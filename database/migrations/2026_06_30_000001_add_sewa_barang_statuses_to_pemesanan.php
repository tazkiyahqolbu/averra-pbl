<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE pemesanan MODIFY COLUMN status ENUM(
            'menunggu',
            'dikonfirmasi',
            'berlangsung',
            'selesai',
            'dibatalkan',
            'menunggu_dp',
            'menunggu_diambil',
            'sedang_disewa',
            'menunggu_pengembalian',
            'menunggu_pelunasan'
        ) NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE pemesanan MODIFY COLUMN status ENUM(
            'menunggu',
            'dikonfirmasi',
            'berlangsung',
            'selesai',
            'dibatalkan'
        ) NOT NULL DEFAULT 'menunggu'");
    }
};
