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
        Schema::table('stock_history', function (Blueprint $table) {
            // Add new columns
            $table->string('stock_description')->nullable();
            $table->date('stock_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_history', function (Blueprint $table) {
            // Drop columns in case of rollback
            $table->dropColumn(['stock_description', 'stock_date']);
        });
    }
};
