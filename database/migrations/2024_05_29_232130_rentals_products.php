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
        Schema::create('rentals_products', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_id');
            $table->integer('product_id');
            $table->integer('product_variations_id')->nullable(true)->default(null);
            $table->double('order_price')->nullable(false);
            $table->double('quantity')->nullable(false);
            $table->string('product_name',150)->nullable(false);
            $table->string('product_unit',50)->nullable(true)->default(null);
            $table->string('tax_sale')->nullable(true)->default(null);/// 15% VAT, VAT Exempt , Zero Rated
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
        Schema::dropIfExists('rentals_products');
    }
};
