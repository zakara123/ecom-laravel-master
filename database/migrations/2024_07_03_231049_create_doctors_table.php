<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->string('nid_passport_no');
            $table->string('sex');
            $table->string('phone');
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('village_town');
            $table->string('user_id');
            // Store password hash
            $table->string('languages')->nullable(); // Store as JSON array
            $table->string('specialities')->nullable(); // Store as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
