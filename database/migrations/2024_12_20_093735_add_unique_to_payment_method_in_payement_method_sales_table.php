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
        Schema::table('payement_method_sales', function (Blueprint $table) {
            $table->string('payment_method')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payement_method_sales', function (Blueprint $table) {
            $table->dropUnique(['payment_method']);
        });
    }
};
