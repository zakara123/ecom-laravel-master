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
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('is_default', array('yes','no'))->default('no')->nullable(false);
        });
        DB::table('customers')->insert(
            array(
                'company_name' => 'Guest',
                'name' => 'Guest',
                'is_default' => 'yes'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('customers')->where('is_default', 'yes')->delete();
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};
