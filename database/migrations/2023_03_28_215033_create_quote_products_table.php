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
        Schema::create('quote_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quotes_id');
            $table->integer('product_id');
            $table->integer('product_variations_id')->nullable(true)->default(null);
            $table->double('order_price');
            $table->double('order_price_bying')->nullable(true)->default(0);
            $table->double('quantity');
            $table->string('product_name',150)->nullable(false);
            $table->string('product_unit',50)->nullable(true)->default(null);
            $table->string('tax_quote')->nullable(true)->default(null);/// 15% VAT, VAT Exempt , Zero Rated
            $table->double('discount')->default(0);
            $table->string('quotes_type',150)->nullable(true)->default(null);
            $table->enum('have_stock_api', array('yes','no'))->default('no')->nullable(false);
            $table->string('barcode',200)->nullable(true)->default(null);
            $table->double('order_price_converted',15,8)->nullable(true)->default(0);
            $table->double('order_price_buying_converted',15,8)->nullable(true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_products');
    }
};
