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
        Schema::create('bill_products', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id');
            $table->integer('product_id');
            $table->integer('product_variations_id')->nullable(true)->default(null);
            $table->double('order_price');
            $table->double('quantity');
            $table->string('product_name',150)->nullable(false);
            $table->string('product_unit',50)->nullable(true)->default(null);
            $table->string('tax_sale')->nullable(true)->default(null);/// 15% VAT, VAT Exempt , Zero Rated
            $table->integer('stock_id')->nullable(true)->default(null);
            $table->double('discount')->default(0);
            $table->string('bills_type',150)->nullable(true)->default(null);
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
        Schema::dropIfExists('bill_products');
    }
};
