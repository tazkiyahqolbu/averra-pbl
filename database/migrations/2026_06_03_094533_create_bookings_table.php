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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('service');
            $table->date('date');
            $table->string('location');
            $table->text('notes')->nullable();
            $table->string('groom_name')->nullable();
            $table->string('bride_name')->nullable();
            $table->string('witness_name')->nullable();
            $table->string('mahar')->nullable();
            $table->string('status')->default('Pending'); // Pending, Confirmed, Selesai, Ditolak
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
