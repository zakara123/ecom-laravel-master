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
        Schema::create('appointment_files', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id');
            $table->string('name');
            $table->string('type');
            $table->string('src');
            $table->timestamp('date_generated')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('appointment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_files');
    }
};
