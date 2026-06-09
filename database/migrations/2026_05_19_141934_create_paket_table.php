<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_paket_id')
                  ->constrained('kategori_paket')
                  ->restrictOnDelete();
            $table->string('nama_paket');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);              // ← presisi 15
            $table->string('keterangan_acara')->nullable();
            $table->text('catatan')->nullable();
            $table->string('thumbnail_path')->nullable();  // ← url_thumbnail → thumbnail_path
            $table->boolean('aktif')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
