<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_testimoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimoni_id')->constrained('testimoni')->cascadeOnDelete();
            $table->string('foto_path');                   // ← url_foto → foto_path
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();

            $table->index(['testimoni_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_testimoni');
    }
};
