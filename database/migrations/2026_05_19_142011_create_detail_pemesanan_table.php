<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemesanan_id')
                ->constrained('pemesanan')
                ->cascadeOnDelete();

            $table->enum('jenis_item', ['barang', 'jasa', 'paket'])->index();

            $table->foreignId('barang_id')
                ->nullable()
                ->constrained('barang')
                ->nullOnDelete();

            $table->foreignId('jasa_id')
                ->nullable()
                ->constrained('jasa')
                ->nullOnDelete();

            $table->foreignId('paket_id')
                ->nullable()
                ->constrained('paket')
                ->nullOnDelete();

            $table->unsignedInteger('jumlah')->default(1);
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->date('tanggal_ambil')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE detail_pemesanan DROP CONSTRAINT chk_detail_pemesanan_item');
        }
        Schema::dropIfExists('detail_pemesanan');
    }
};
