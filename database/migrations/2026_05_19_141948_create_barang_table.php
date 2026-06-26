<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id')
                  ->constrained('kategori_barang')
                  ->restrictOnDelete();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->decimal('nilai_barang', 15, 2)->default(0)
                  ->comment('Nilai ganti rugi jika hilang/rusak berat');
            $table->unsignedInteger('stok')->default(0)->index();
            $table->string('thumbnail_path')->nullable();
            $table->boolean('aktif')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
