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
        Schema::table('products', function (Blueprint $table) {
            $table->string('price', 8)
                ->default('0')
                ->comment('selling price')
                ->change();

            $table->string('price_buying', 8)
                ->nullable()
                ->default('0')
                ->comment('buying price')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert to the previous state (if you know the original types)
            $table->decimal('price', 10, 2)
                ->change();

            $table->decimal('price_buying', 10, 2)
                ->nullable()
                ->change();
        });
    }
};
