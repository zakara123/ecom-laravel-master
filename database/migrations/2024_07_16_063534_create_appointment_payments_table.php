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
        Schema::create('appointment_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->date('payment_date');
            $table->string('payment_mode', 200);
            $table->string('payment_reference', 200)->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('due_amount', 10, 2);
            $table->tinyInteger('is_pettycash')->default(0);
            $table->string('matched_transaction', 200)->nullable();
            $table->unsignedBigInteger('id_creditnote')->nullable();
            $table->timestamps();

            // Indexes or foreign keys can be added here if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_payments');
    }
};
