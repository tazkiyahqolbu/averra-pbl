<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->nullable()->index();
            $table->string('media_path');                  // ← url_media → media_path
            $table->enum('jenis_media', ['foto', 'video'])->index();
            $table->text('keterangan')->nullable();
            $table->boolean('unggulan')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
