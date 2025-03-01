<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add new columns
            $table->text('doctor_comment')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->timestamp('doctor_date')->nullable();
            $table->text('appointment_comment')->nullable();
            
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop columns if needed
            $table->dropColumn('doctor_comment');
            $table->dropColumn('doctor_id');
            $table->dropColumn('doctor_date');
            $table->dropColumn('appointment_comment');
        });
    }
};
