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
        Schema::table('products', function (Blueprint $table) {
            // Rename the column
            $table->renameColumn('is_publish', 'is_publish_delete');
            $table->tinyInteger('display_online')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert the column rename
            $table->renameColumn('is_publish_delete', 'is_publish');
            $table->dropColumn('display_online');
        });
    }
};
