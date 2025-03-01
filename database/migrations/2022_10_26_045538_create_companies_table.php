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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name',120)->nullable(false);
            $table->string('company_address',250)->nullable(false);
            $table->string('brn_number',120)->nullable(false);
            $table->string('vat_number',120)->nullable(true);
            $table->string('tan',120)->nullable(true);
            $table->string('company_email',250)->nullable(false);
            $table->string('order_email',250)->nullable(true)->default(null);
            $table->string('company_phone',120)->nullable(false);
            $table->string('company_fax',120)->nullable(true)->default(null);
            $table->string('whatsapp_number',120)->nullable(true);
            $table->string('logo',500)->nullable(true)->default(null);
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
        Schema::dropIfExists('companies');
    }
};
