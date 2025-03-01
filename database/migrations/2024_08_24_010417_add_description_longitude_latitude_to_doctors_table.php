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
            $table->text('description')->nullable();  // Adding description field
            $table->decimal('longitude', 10, 7)->nullable();  // Adding longitude field with precision
            $table->decimal('latitude', 10, 7)->nullable();   // Adding latitude field with precision
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['description', 'longitude', 'latitude']);  // Dropping all columns in reverse
        });
    }
};
