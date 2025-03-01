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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order')->nullable(true)->default(null);
            $table->integer('debit')->nullable(true)->default(null);
            $table->integer('credit')->nullable(true)->default(null);
            $table->double('amount')->nullable(true)->default(null);
            $table->date('date')->nullable(false)->default(now());
            $table->text('description')->nullable(true)->default(null);
            $table->string('name',500)->nullable(true)->default(null);
            $table->integer('bills')->nullable(true)->default(null);
            $table->integer('banking')->nullable(true)->default(null);
            $table->integer('journal_id')->nullable(true)->default(0);
            $table->integer('credit_card')->nullable(true)->default(null);
            $table->integer('is_pettycash')->nullable(true)->default(0);
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
        Schema::dropIfExists('journal_entries');
    }
};
