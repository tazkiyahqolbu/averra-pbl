<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->cascadeOnDelete();
            $table->string('foto_path');                   // ← url_foto → foto_path
            $table->string('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();

            $table->index(['barang_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_barang');
    }
};
