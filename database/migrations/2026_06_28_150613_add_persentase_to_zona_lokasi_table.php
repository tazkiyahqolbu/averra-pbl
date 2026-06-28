<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zona_lokasi', function (Blueprint $table) {

            $table->decimal('persentase',5,2)
                  ->default(0)
                  ->after('biaya');

        });
    }

    public function down(): void
    {
        Schema::table('zona_lokasi', function (Blueprint $table) {

            $table->dropColumn('persentase');

        });
    }
};
