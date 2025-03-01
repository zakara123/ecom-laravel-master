<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSliderIdToHomeComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_components', function (Blueprint $table) {
            $table->unsignedBigInteger('slider_id')->nullable()->after('id');
            // If you want to set up a foreign key, you can uncomment the following line
            // $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_components', function (Blueprint $table) {
            $table->dropColumn('slider_id');
            // If you set up a foreign key, uncomment the following line
            // $table->dropForeign(['slider_id']);
        });
    }
}
