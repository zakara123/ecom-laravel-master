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
        Schema::create('bills_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id');
            $table->date('payment_date');
            $table->integer('payment_mode');
            $table->string('payment_reference',170)->nullable(true);
            $table->double('amount');
            $table->integer('is_pettycash')->nullable(true)->default(null);
            $table->integer('id_debitnote')->nullable(true)->default(null);
            $table->integer('matched_transaction')->nullable(true)->default(null);
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
        Schema::dropIfExists('bills_payments');
    }
};
