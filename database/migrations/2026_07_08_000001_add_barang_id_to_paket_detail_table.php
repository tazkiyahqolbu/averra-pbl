<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paket_detail', function (Blueprint $table) {
            $table->foreignId('barang_id')->nullable()->after('jasa_id')
                ->constrained('barang')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('paket_detail', function (Blueprint $table) {
            $table->dropConstrainedForeignId('barang_id');
        });
    }
};
