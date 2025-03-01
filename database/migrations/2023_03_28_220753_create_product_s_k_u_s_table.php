<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Products;
use App\Models\ProductVariation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_s_k_u_s', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Products::class);
            $table->foreignIdFor(ProductVariation::class)->nullable();
            $table->string('barcode',25)->nullable(false)->default(0);
            $table->string('sku',250)->nullable(true)->default(null);
            $table->string('group',250)->nullable(true)->default(null);
            $table->string('type',250)->nullable(true)->default(null);
            $table->string('material',250)->nullable(true)->default(null);
            $table->string('colour',250)->nullable(true)->default(null);
            $table->string('stock_warehouse',11)->nullable(true)->default(null);
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
        Schema::dropIfExists('product_s_k_u_s');
    }
};
