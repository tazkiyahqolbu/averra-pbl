<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_jasa', function (Blueprint $table) {
            $table->dropColumn('ikon_path');
        });

        Schema::table('kategori_paket', function (Blueprint $table) {
            $table->dropColumn('ikon_path');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_jasa', function (Blueprint $table) {
            $table->string('ikon_path')->nullable();
        });

        Schema::table('kategori_paket', function (Blueprint $table) {
            $table->string('ikon_path')->nullable();
        });
    }
};
