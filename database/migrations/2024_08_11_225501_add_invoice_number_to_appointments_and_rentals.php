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
        // Add invoice_number to appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('invoice_number')->nullable(); // Change 'some_existing_column' to the column after which you want to add 'invoice_number'
        });

        // Add invoice_number to rentals table
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('invoice_number')->nullable(); // Change 'some_existing_column' to the column after which you want to add 'invoice_number'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_and_rentals', function (Blueprint $table) {
            //
        });
    }
};
