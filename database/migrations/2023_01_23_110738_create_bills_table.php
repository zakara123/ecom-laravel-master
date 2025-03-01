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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->datetime('delivery_date')->nullable(true)->default(null);
            $table->datetime('due_date')->nullable(true)->default(null);
            $table->double('amount');
            $table->double('subtotal')->default(0);
            $table->double('tax_amount')->default(0);
            $table->string('status',70);
            $table->string('bill_reference',200)->nullable(true)->default(null);
            $table->mediumText('comment')->nullable(true)->default(null);
            $table->integer('payment_methode');
            $table->datetime('date_paied')->nullable(true)->default(null);
            $table->integer('user_id')->nullable(true)->default(null);
            $table->integer('id_store');
            $table->string('store',100);
            $table->string('tax_items')->nullable(true)->default("No VAT"); /// No VAT, Included in the price, Added to the price
            $table->integer('id_supplier');
            $table->string('supplier_name',200)->nullable(true)->default(null);
            $table->string('supplier_email',200)->nullable(true)->default(null);
            $table->string('supplier_phone',200)->nullable(true)->default(null);
            $table->string('supplier_address',200)->nullable(true)->default(null);
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
        Schema::dropIfExists('bills');
    }
};
