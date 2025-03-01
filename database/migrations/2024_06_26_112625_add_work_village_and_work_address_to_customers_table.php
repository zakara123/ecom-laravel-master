<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('work_village')->nullable();
            $table->string('work_address')->nullable();
            $table->string('user_id')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('work_village');
            $table->dropColumn('work_address');
        });
    }
};
