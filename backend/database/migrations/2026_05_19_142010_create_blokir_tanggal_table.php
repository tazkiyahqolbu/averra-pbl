<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blokir_tanggal', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique(); // ← tambah unique
            $table->boolean('full_block')->default(true);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blokir_tanggal');
    }
};
