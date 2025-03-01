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
        Schema::table('product_images', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->after('products_id')->nullable();
        });

        Schema::table('product_variation_images', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->after('product_variation_id')->nullable();
        });

        Schema::table('product_variation_thumbnails', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->after('product_variation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });
        Schema::table('product_variation_images', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });
        Schema::table('product_variation_thumbnails', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });
    }
};
