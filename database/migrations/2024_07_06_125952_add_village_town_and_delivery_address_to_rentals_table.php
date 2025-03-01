<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('village_town')->nullable();
            $table->string('delivery_address')->nullable();
        });
    }

    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('village_town');
            $table->dropColumn('delivery_address');
        });
    }

};
