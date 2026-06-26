<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 50)->unique();
            $table->foreignId('pemesanan_id')              // ← booking_id → pemesanan_id
                  ->constrained('pemesanan')
                  ->restrictOnDelete();
            $table->enum('tahap', ['dp', 'pelunasan', 'langsung']);
            $table->unsignedTinyInteger('persen_dp')->nullable()
                  ->comment('Diisi hanya jika tahap = dp, nilai 1-100');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->timestamp('dibayar_pada');              // ← tanggal_bayar DATE → dibayar_pada TIMESTAMP
            $table->string('metode_pembayaran', 50);
            $table->string('bukti_pembayaran_path')->nullable(); // ← bukti_pembayaran → bukti_pembayaran_path
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])
                  ->default('menunggu')->index();
            $table->foreignId('diverifikasi_oleh')         // ← field baru: audit trail admin
                  ->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->text('catatan_penolakan')->nullable();  // ← field baru: alasan ditolak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
