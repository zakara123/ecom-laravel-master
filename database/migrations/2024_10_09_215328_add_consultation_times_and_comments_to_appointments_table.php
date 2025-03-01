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
        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('consultation_start_time')->nullable();
            $table->timestamp('consultation_end_time')->nullable();
            $table->text('consultation_end_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('consultation_start_time');
            $table->dropColumn('consultation_end_time');
            $table->dropColumn('consultation_end_comments');
        });
    }
};
