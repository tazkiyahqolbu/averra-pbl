<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opsional_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')              // ← booking_id → pemesanan_id
                  ->constrained('pemesanan')
                  ->cascadeOnDelete();
            $table->foreignId('paket_detail_id')
                  ->constrained('paket_detail')
                  ->restrictOnDelete();
            $table->decimal('harga_tambahan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opsional_pemesanan');
    }
};
