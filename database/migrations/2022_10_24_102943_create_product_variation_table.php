<?php
use App\Models\Products;
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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Products::class);
            $table->string('id_product_attributs_value',200)->nullable(true)->default(null);
            $table->integer('product_variation_id')->nullable(true)->default(null);
            $table->integer('variation_value_size_id')->nullable(true)->default(null);
            $table->integer('product_variation_length_id')->nullable(true)->default(null);
            $table->double('price');
            $table->double('price_buying')->nullable(true)->default(null);
            $table->integer('position')->nullable(true)->default(null);
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
        Schema::dropIfExists('product_variations');
    }
};
