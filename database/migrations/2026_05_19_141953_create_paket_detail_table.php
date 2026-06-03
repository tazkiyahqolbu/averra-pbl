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
        Schema::create('paket_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('paket')->cascadeOnDelete();
            $table->foreignId('jasa_id')->nullable()->constrained('jasa')->nullonDelete();
            $table->string('nama_item')->nullable();
            $table->unsignedInteger('jumlah')->default(1);
            $table->enum('tipe', ['wajib', 'opsional'])->default('wajib')->index();
            $table->decimal('harga_tambahan', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_detail');
    }
};
