<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            // Allow NULL values for the specified columns
            $table->string('sex')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address_1')->nullable()->change();
            $table->string('village_town')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};
