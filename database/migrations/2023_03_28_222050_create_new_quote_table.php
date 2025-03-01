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
        Schema::create('newquotes', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('product_variation_id')->nullable(true);
            $table->string('product_name');
            $table->double('product_price',15,8);
            $table->double('order_price_bying')->nullable(true)->default(0);
            $table->integer('quantity');
            $table->string('variation')->nullable(true);
            $table->string('tax_quote')->nullable(true)->default(null); /// 15% VAT, VAT Exempt , Zero Rated
            $table->string('tax_items')->nullable(true)->default("No VAT"); /// No VAT, Included in the price, Added to the price
            $table->double('discount')->default(0); /// discount
            $table->string('quotes_type',150)->nullable(true)->default(null);
            $table->double('product_price_converted',15,8)->nullable(true)->default(0);
            $table->double('order_price_buying_converted',15,8)->nullable(true)->default(0);
            $table->string('product_unit',50)->nullable(true)->default(null);
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
        Schema::dropIfExists('newquotes');
    }
};
