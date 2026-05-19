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
        Schema::create('foto_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('paket')->onDelete('cascade');
            $table->string('url_foto');
            $table->string('keterangan')->nullable();
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_paket');
    }
};
