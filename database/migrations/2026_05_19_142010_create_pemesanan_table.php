<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemesanan', 30)->unique(); // ← kode_booking → kode_pemesanan
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('zona_id')->nullable()->constrained('zona_lokasi')->nullOnDelete();
            $table->date('tanggal_pemesanan');              // ← tanggal_booking → tanggal_pemesanan
            $table->date('tanggal_pakai')->index();
            $table->enum('jenis', ['acara', 'sewa_barang'])->index();
            $table->string('lokasi')->nullable();
            $table->decimal('ongkos_lokasi', 15, 2)->default(0);
            $table->string('no_hp', 20);
            $table->string('nama_pemesan')->nullable();
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', [
                'menunggu',
                'dikonfirmasi',
                'berlangsung',
                'selesai',
                'dibatalkan',
            ])->default('menunggu')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
