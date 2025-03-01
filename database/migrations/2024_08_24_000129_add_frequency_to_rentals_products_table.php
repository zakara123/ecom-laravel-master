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
        Schema::table('rentals_products', function (Blueprint $table) {
            $table->string('frequency')->nullable(); // Adjust the column type as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rentals_products', function (Blueprint $table) {
            $table->dropColumn('frequency');
        });
    }
};
