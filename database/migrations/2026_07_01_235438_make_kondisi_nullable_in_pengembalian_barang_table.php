<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE pengembalian_barang MODIFY kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengembalian_barang MODIFY kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') NOT NULL");
    }
};
