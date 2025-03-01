<?php

use App\Models\Products;
use App\Models\Store;
use App\Models\ProductVariation;

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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Products::class);
            $table->foreignIdFor(Store::class);
            $table->foreignIdFor(ProductVariation::class)->nullable();
            $table->double('quantity_stock');
            $table->enum('is_primary', array('yes','no'))->default('no')->nullable(false);
            $table->string('barcode_value',120)->nullable(true)->default(null);
            $table->string('sku',120)->nullable(true)->default(null);
            $table->date('date_received')->nullable(true)->default(null);
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
        // Schema::dropIfExists('product_variations');
        Schema::dropIfExists('stocks');
        // Schema::dropIfExists('products');
    }
};
