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
        Schema::create('header_menu_colors', function (Blueprint $table) {
            $table->id();
            $table->string('header_color')->nullable(true)->default('#000');
            $table->string('header_background')->nullable(true)->default('#000');
            $table->string('header_menu_background')->nullable(true)->default('#fff');
            $table->string('header_background_hover')->nullable(true)->default('#fff');
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
        Schema::dropIfExists('header_menu_colors');
    }
};
