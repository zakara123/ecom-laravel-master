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
        Schema::create('bankings', function (Blueprint $table) {
            $table->id();
            $table->double('debit')->nullable(false)->default(0);
            $table->double('credit')->nullable(false)->default(0);
            $table->double('amount')->nullable(false)->default(0);
            $table->date('date')->nullable(false)->default(now());
            $table->text('description')->nullable(true)->default(null);
            $table->text('reference')->nullable(true)->default(null);
            $table->integer('matching_status')->nullable(true)->default(0);
            $table->integer('petty_cash_matched')->nullable(true)->default(0);
            $table->integer('is_manual')->nullable(true)->default(0);
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
        Schema::dropIfExists('bankings');
    }
};
