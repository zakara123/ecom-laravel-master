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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->nullable(false);
            $table->string('address',150)->nullable(true)->default(null);
            $table->string('brn',150)->nullable(true)->default(null);
            $table->string('vat',150)->nullable(true)->default(null);
            $table->string('halal_certified',150)->nullable(true)->default(null);
            $table->string('order_email',150)->nullable(true)->default(null);
            $table->string('credit_limit',150)->nullable(true)->default(null);
            $table->string('name_person',150)->nullable(true)->default(null);
            $table->string('email_address',150)->nullable(true)->default(null);
            $table->string('mobile',150)->nullable(true)->default(null);
            $table->string('office_phone',150)->nullable(true)->default(null);
            $table->enum('status', array('enabled','disabled'))->default('enabled')->nullable(false);
            $table->string('payment_frequency',150)->nullable(true)->default(null);
            $table->string('ordering_frequency',150)->nullable(true)->default(null);
            $table->string('delivery_days',150)->nullable(true)->default(null);
            $table->enum('central_kitchen', array('yes','no'))->default('no')->nullable(false);
            $table->string('vat_supplier',150)->nullable(true)->default(null);
            $table->string('bank_name',150)->nullable(true)->default(null);
            $table->string('account_name',150)->nullable(true)->default(null);
            $table->string('account_number',200)->nullable(true)->default(null);
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
        Schema::dropIfExists('suppliers');
    }
};
