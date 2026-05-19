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
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('zona_id')->nullable()->constrained('zona_lokasi')->onDelete('set null');
            $table->date('tanggal_booking');
            $table->date('tanggal_pakai');
            $table->enum('jenis', ['acara', 'sewa_barang']);
            $table->string('lokasi')->nullable();
            $table->decimal('ongkos_lokasi', 12, 2)->default(0);
            $table->string('no_hp', 20);
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', [
                'menunggu',
                'dikonfirmasi',
                'berlangsung',
                'selesai',
                'dibatalkan',
            ])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
