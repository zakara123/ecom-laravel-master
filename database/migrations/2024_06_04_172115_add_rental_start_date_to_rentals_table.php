<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->date('rental_start_date')->nullable();
            
        });
    }

    
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('rental_start_date');
        });
    }
};
