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
        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_detail_id')->constrained('booking_detail')->onDelete('cascade');
            $table->date('tanggal_kembali_aktual');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang']);
            $table->text('catatan_kerusakan')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->decimal('denda_keterlambatan', 12, 2)->default(0);
            $table->decimal('denda_kerusakan', 12, 2)->default(0);
            $table->decimal('total_denda', 12, 2)->default(0);
            $table->enum('status_denda', ['tidak_ada', 'menunggu_bayar', 'lunas'])->default('tidak_ada');
            $table->foreignId('dicatat_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barang');
    }
};
