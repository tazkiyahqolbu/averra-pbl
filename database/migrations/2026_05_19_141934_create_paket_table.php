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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_paket_id')->constrained('kategori_paket')->onDelete('cascade');
            $table->string('nama_paket');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->string('keterangan_acara')->nullable();
            $table->text('catatan')->nullable();
            $table->string('url_thumbnail')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
