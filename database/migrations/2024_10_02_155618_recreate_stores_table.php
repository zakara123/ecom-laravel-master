<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('stores');

        // Recreate the stores table
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->enum('pickup_location', ['yes', 'no'])->default('no');
            $table->enum('is_online', ['yes', 'no'])->default('no');
            $table->enum('is_default', ['yes', 'no'])->default('no');
            $table->enum('is_on_newsale_page', ['yes', 'no'])->default('no');
            $table->string('vat_type')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Insert data
        DB::table('stores')->insert([
            [
                'name' => 'Warehouse',
                'pickup_location' => 'yes',
                'is_online' => 'yes',
                'is_default' => 'yes',
                'is_on_newsale_page' => 'yes',
                'vat_type' => 'No VAT',
                'created_at' => now(),
                'updated_at' => '2024-09-30 15:50:38',
            ]
        ]);

        // handle stocks table
        DB::table('stocks')->update(['store_id' => 1]);

        // handle appointment_billable table
        DB::table('appointment_billable')->update(['id_store' => 1]);

        // handle appointments table
        DB::table('appointments')->update(['id_store' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the stores table
        Schema::dropIfExists('stores');
    }
};
