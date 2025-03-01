<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('nid')->nullable(); // Assuming 'email' field exists
            $table->string('upi')->nullable();   // Add 'upi' after 'nid'
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('nid');
            $table->dropColumn('upi');
        });
    }
};
