<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pemesanan_id')              // ← booking_id → pemesanan_id
                  ->constrained('pemesanan')
                  ->cascadeOnDelete();
            $table->text('isi_testimoni');
            $table->unsignedTinyInteger('rating')->comment('Nilai 1-5');
            $table->text('dibalas')->nullable();
            $table->boolean('dipublikasikan')->default(false)->index();
            $table->timestamps();

            $table->unique(['user_id', 'pemesanan_id']);   // ← 1 user 1 testimoni per pemesanan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};
