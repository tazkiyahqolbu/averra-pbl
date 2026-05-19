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
        Schema::create('booking_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barang')->onDelete('set null');
            $table->foreignId('jasa_id')->nullable()->constrained('jasa')->onDelete('set null');
            $table->foreignId('paket_id')->nullable()->constrained('paket')->onDelete('set null');
            $table->unsignedInteger('jumlah')->default(1);
            $table->decimal('harga', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->date('tanggal_ambil')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_detail');
    }
};
