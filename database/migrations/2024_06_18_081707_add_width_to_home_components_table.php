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
        Schema::table('home_components', function (Blueprint $table) {
            $table->unsignedBigInteger('width')->nullable()->after('id');
            // If you want to set up a foreign key, you can uncomment the following line
            // $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_components', function (Blueprint $table) {
            $table->dropColumn('width');
        });
    }
};
