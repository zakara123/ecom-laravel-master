<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
           // $table->integer('product_variation_id')->nullable()->after('id_product_attributs_value');
           // $table->integer('variation_value_size_id')->nullable()->after('id_product_attributs_value');
            //$table->integer('product_variation_length_id')->nullable()->after('id_product_attributs_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {
            //
        });
    }
};
