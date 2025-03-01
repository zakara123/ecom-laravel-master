<?php

use App\Models\Attribute;
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
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Attribute::class);
            $table->foreignIdFor(Products::class)->default(0);
            $table->string('attribute_name',120);
            $table->string('attribute_slug',120);
            $table->string('attribute_value',120);
            $table->string('attribute_type',120);
            $table->string('visibility',120)->default('Global');
            $table->integer('posistion')->nullable(true);
            $table->float('price')->default(0);
            $table->string('specs',120)->nullable(true);
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
        Schema::dropIfExists('product_options');
    }
};
