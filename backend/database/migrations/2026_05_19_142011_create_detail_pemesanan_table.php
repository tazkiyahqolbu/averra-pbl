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
            $table->foreignId('pemesanan_id')              // ← booking_id → pemesanan_id
                  ->constrained('pemesanan')
                  ->cascadeOnDelete();
            $table->enum('jenis_item', ['barang', 'jasa', 'paket'])->index(); // ← field baru
            $table->foreignId('barang_id')->nullable()->constrained('barang')->nullOnDelete();
            $table->foreignId('jasa_id')->nullable()->constrained('jasa')->nullOnDelete();
            $table->foreignId('paket_id')->nullable()->constrained('paket')->nullOnDelete();
            $table->unsignedInteger('jumlah')->default(1);
            $table->decimal('harga', 15, 2)
                  ->comment('Snapshot harga saat pemesanan dibuat');
            $table->decimal('subtotal', 15, 2);
            $table->date('tanggal_ambil')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });

        // CHECK constraint — hanya aktif di MySQL 8.0+
        // Di SQLite (CI/testing) constraint ini tidak jalan,
        // integritas dijaga di BookingService::validasiItem()
        if (DB::getDriverName() === 'mysql') {
            DB::statement('
                ALTER TABLE detail_pemesanan
                ADD CONSTRAINT chk_detail_pemesanan_item CHECK (
                    (jenis_item = "barang" AND barang_id IS NOT NULL AND jasa_id IS NULL  AND paket_id IS NULL) OR
                    (jenis_item = "jasa"   AND jasa_id  IS NOT NULL AND barang_id IS NULL AND paket_id IS NULL) OR
                    (jenis_item = "paket"  AND paket_id IS NOT NULL AND barang_id IS NULL AND jasa_id IS NULL)
                )
            ');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE detail_pemesanan DROP CONSTRAINT chk_detail_pemesanan_item');
        }
        Schema::dropIfExists('detail_pemesanan');
    }
};
