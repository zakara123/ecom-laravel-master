<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sales;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sales::class);
            $table->dateTime('payment_date');
            $table->integer('payment_mode');
            $table->string('payment_reference',170)->nullable(true);
            $table->double('amount');
            $table->integer('is_pettycash')->nullable(true)->default(null);
            $table->integer('id_creditnote')->nullable(true)->default(null);
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
        Schema::dropIfExists('sales_payments');
    }
};
