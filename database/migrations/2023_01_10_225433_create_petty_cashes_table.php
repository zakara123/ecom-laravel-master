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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->double('debit',11, 2)->nullable(false)->default(0);
            $table->double('credit',11, 2)->nullable(false)->default(0);
            $table->double('amount',11, 2)->nullable(false)->default(0);
            $table->date('date')->nullable(false)->default(now());
            $table->text('description')->nullable(true)->default(null);
            $table->integer('matching_status')->nullable(true)->default(0);
            $table->integer('is_account_payable')->nullable(true)->default(0);
            $table->integer('ledger_account')->nullable(false)->default(0);
            $table->integer('banking_matched')->nullable(true)->default(0);
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
        Schema::dropIfExists('petty_cashes');
    }
};
