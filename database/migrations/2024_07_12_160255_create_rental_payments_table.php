<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('rental_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->date('payment_date');
            $table->string('payment_mode');
            $table->string('payment_reference')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('due_amount', 10, 2);
            $table->boolean('is_pettycash')->default(false);
            $table->string('matched_transaction')->nullable();
            $table->unsignedBigInteger('id_creditnote')->nullable();
            $table->timestamps(); // This will create created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_payments');
    }
};
