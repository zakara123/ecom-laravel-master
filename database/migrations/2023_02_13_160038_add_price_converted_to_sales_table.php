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
        Schema::table('sales', function (Blueprint $table) {
            $table->double('amount_converted',15,8)->nullable(true)->default(0);
            $table->double('subtotal_converted',15,8)->nullable(true)->default(0);
            $table->double('tax_amount_converted',15,8)->nullable(true)->default(0);
            $table->double('currency_amount',15,8)->nullable(true)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('amount_converted');
            $table->dropColumn('subtotal_converted');
            $table->dropColumn('tax_amount_converted');
            $table->dropColumn('currency_amount');
        });
    }
};
