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
        Schema::create('homepage_collection_images', function (Blueprint $table) {
            $table->id();
            $table->string('title',200)->nullable(true);
            $table->string('image',200)->nullable(false);
            $table->text('description')->nullable(true);
            $table->string('link',5000)->nullable(false);
            $table->enum('active', array('yes','no'))->default('yes')->nullable(false);
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
        Schema::dropIfExists('homepage_collection_images');
    }
};
