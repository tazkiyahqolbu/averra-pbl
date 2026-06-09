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
        Schema::create('foto_jasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasa_id')->constrained('jasa')->cascadeOnDelete();
            $table->string('foto_path');
            $table->string('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();

            $table->index(['jasa_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_jasa');
    }
};
