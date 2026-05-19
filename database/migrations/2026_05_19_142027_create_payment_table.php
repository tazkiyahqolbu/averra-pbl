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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->enum('tahap', ['dp', 'pelunasan', 'langsung']);
            $table->unsignedTinyInteger('persen_dp')->nullable();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->date('tanggal_bayar');
            $table->string('metode_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
