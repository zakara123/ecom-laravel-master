<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('sales_payments', function (Blueprint $table) {
            //$table->decimal('due_amount', 10, 2)->nullable(); // Adjust the type and options as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_payments', function (Blueprint $table) {
           // $table->dropColumn('due_amount');
        });
    }
};
