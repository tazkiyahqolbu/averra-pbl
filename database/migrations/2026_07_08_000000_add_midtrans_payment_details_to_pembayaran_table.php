<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('gateway_status');
            $table->string('bank')->nullable()->after('payment_type');
            $table->string('va_number')->nullable()->after('bank');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'bank', 'va_number']);
        });
    }
};
