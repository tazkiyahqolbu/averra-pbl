<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_pemesanan_id')       // ← booking_detail_id → detail_pemesanan_id
                  ->constrained('detail_pemesanan')
                  ->restrictOnDelete();
            $table->date('tanggal_kembali_aktual');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang']);
            $table->text('catatan_kerusakan')->nullable();
            $table->string('foto_bukti_path')->nullable();  // ← foto_bukti → foto_bukti_path
            $table->enum('status_pengembalian', ['menunggu', 'diperiksa', 'selesai'])
                  ->default('menunggu')->index();           // ← field baru
            $table->decimal('denda_keterlambatan', 15, 2)->default(0);
            $table->decimal('denda_kerusakan', 15, 2)->default(0);
            $table->decimal('total_denda', 15, 2)->default(0);
            $table->enum('status_denda', ['tidak_ada', 'menunggu_bayar', 'lunas'])
                  ->default('tidak_ada')->index();
            $table->foreignId('dicatat_oleh')
                  ->nullable()                             // ← jadi nullable
                  ->constrained('users')
                  ->nullOnDelete();                        // ← cascade → nullOnDelete
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_barang');
    }
};
