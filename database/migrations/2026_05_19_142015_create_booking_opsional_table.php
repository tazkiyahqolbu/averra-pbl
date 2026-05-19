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
        Schema::create('booking_opsional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->foreignId('paket_detail_id')->constrained('paket_detail')->onDelete('cascade');
            $table->decimal('harga_tambahan', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_opsional');
    }
};
