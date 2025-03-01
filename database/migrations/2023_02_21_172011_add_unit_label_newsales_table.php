<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsales', function (Blueprint $table) {
            $table->string('product_unit',50)->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('newsales', 'product_unit'))
        {
            Schema::table('newsales', function (Blueprint $table) {
                $table->dropColumn('product_unit');
            });
        }
    }
};
