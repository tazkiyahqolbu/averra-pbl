<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->enum('metode_pengambilan', ['ambil_sendiri', 'dikirim'])->nullable()->after('lokasi');
            $table->enum('metode_pengembalian', ['antar_sendiri', 'dijemput'])->nullable()->after('metode_pengambilan');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['metode_pengambilan', 'metode_pengembalian']);
        });
    }
};
