<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->id();
            // PERBAIKAN: kategori_id → kategori_jasa_id agar konsisten dengan
            // barang (kategori_barang_id) dan paket (kategori_paket_id)
            $table->foreignId('kategori_jasa_id')
                  ->constrained('kategori_jasa')
                  ->restrictOnDelete();
            $table->string('nama_jasa');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);         // PERBAIKAN: presisi 15 digit
            $table->unsignedInteger('maks_booking_harian')->default(1);
            $table->string('thumbnail_path')->nullable(); // PERBAIKAN: url_thumbnail → thumbnail_path
            $table->boolean('aktif')->default(true)->index(); // PERBAIKAN: index untuk filter katalog publik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};
