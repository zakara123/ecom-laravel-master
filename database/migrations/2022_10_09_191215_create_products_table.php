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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->nullable(false);
            $table->string('slug',150)->nullable(false)->unique();
            $table->longText('description')->nullable(true)->default(null);
            $table->text('short_description')->nullable(true)->default(null);
            $table->enum('is_variable_product', array('yes','no'))->default('no')->nullable(false);
            $table->float('price')->nullable(false)->comment('selling price')->default(0);
            $table->float('price_buying')->nullable(true)->comment('buying price')->default(0);
            $table->string('unit',10)->nullable(true)->default(null);
            $table->enum('attributs_for_pricing', array('yes','no'))->default('no')->nullable(false);
            $table->enum('allow_combined_value_only', array('yes','no'))->default('no')->nullable(false);
            $table->string('vat',120)->nullable(true)->default(null);
            $table->string('qr_code_src',120)->nullable(true)->default(null);
            $table->integer('id_supplier')->nullable(true)->default(null);
            $table->string('line_item_order_attributes',50)->default('Manual Position')->nullable(false);
            $table->enum('is_maintenance', array('yes','no'))->default('no')->nullable(false);
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
        // Schema::dropIfExists('stocks');
        // Schema::dropIfExists('product_variations');
        Schema::dropIfExists('products');
    }
};
