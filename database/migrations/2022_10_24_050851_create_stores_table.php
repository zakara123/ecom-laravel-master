<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable(false);
            $table->enum('pickup_location', array('yes','no'))->default('no')->nullable(false);
            $table->enum('is_online', array('yes','no'))->default('no')->nullable(false);
            $table->enum('is_default', array('yes','no'))->default('no')->nullable(false);
            $table->enum('is_on_newsale_page', array('yes','no'))->default('yes')->nullable(false);
            $table->string('vat_type',120)->nullable(true)->default(null);
            $table->timestamps();
        });
        DB::table('stores')->insert(
            array(
                'name' => 'Online Store',
                'pickup_location' => 'no',
                'is_online' => 'yes',
                'is_default' => 'no',
                'is_on_newsale_page' => 'no',
                'vat_type' => 'No VAT'
            )
        );
        DB::table('stores')->insert(
            array(
                'name' => 'Default Store',
                'pickup_location' => 'yes',
                'is_online' => 'no',
                'is_default' => 'yes',
                'is_on_newsale_page' => 'yes',
                'vat_type' => 'No VAT'
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
        Schema::dropIfExists('stores');
    }
};
