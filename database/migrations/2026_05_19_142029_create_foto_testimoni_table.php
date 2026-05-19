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
        Schema::create('foto_testimoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimoni_id')->constrained('testimoni')->onDelete('cascade');
            $table->string('url_foto');
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_testimoni');
    }
};
