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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',150)->nullable(true);
            $table->string('lastname',150)->nullable(true);
            $table->string('name',150)->nullable(true);
            $table->string('company_name',150)->nullable(true);
            $table->string('address1',150)->nullable(true);
            $table->string('address2',150)->nullable(true);
            $table->string('city',150)->nullable(true);
            $table->string('country',150)->nullable(true);
            $table->string('email',120)->nullable(true);
            $table->string('phone',120)->nullable(true);
            $table->string('fax',100)->nullable(true);
            $table->string('brn_customer',100)->nullable(true);
            $table->string('vat_customer',180)->nullable(true);
            $table->string('note_customer',180)->nullable(true);
            $table->string('temp_password',250)->nullable(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
