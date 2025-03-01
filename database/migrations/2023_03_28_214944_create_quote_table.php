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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->datetime('delivery_date')->nullable(true)->default(null);
            $table->double('amount');
            $table->double('subtotal')->default(0);
            $table->double('tax_amount')->default(0);
            $table->double('amount_converted',15,8)->nullable(true)->default(0);
            $table->double('subtotal_converted',15,8)->nullable(true)->default(0);
            $table->double('tax_amount_converted',15,8)->nullable(true)->default(0);
            $table->double('currency_amount',15,8)->nullable(true)->default(0);
            $table->string('currency',5)->default("MUR");
            $table->string('status',70);
            $table->string('order_reference',200)->nullable(true)->default(null);
            $table->string('customer_id');
            $table->string('customer_firstname',200)->nullable(true)->default(null);
            $table->string('customer_lastname',200)->nullable(true)->default(null);
            $table->string('customer_name',200)->nullable(true)->default(null);
            $table->string('customer_address',200)->nullable(true)->default(null);
            $table->string('customer_city',200)->nullable(true)->default(null);
            $table->string('customer_email',200)->nullable(true)->default(null);
            $table->string('customer_phone',200)->nullable(true)->default(null);
            $table->mediumText('comment')->nullable(true)->default(null);
            $table->longText('internal_note')->nullable(true)->default(null);
            $table->datetime('date_paied')->nullable(true)->default(null);
            $table->integer('user_id')->nullable(true)->default(null);
            $table->integer('id_store');
            $table->string('tax_items')->nullable(true)->default("No VAT"); /// No VAT, Included in the price, Added to the price
            $table->datetime('date_resent_mail_quote')->nullable(true)->default(null);
            $table->datetime('date_resent_mail_invoice')->nullable(true)->default(null);
            $table->enum('pickup_or_delivery', array('Pickup','Delivery'))->nullable(true)->default(null);
            $table->integer('id_store_pickup')->nullable(true)->default(null);
            $table->string('store_pickup', 90)->nullable(true)->default(null);
            $table->date('date_pickup')->nullable(true)->default(null);
            $table->integer('id_delivery')->nullable(true)->default(null);
            $table->string('delivery_name', 100)->nullable(true)->default(null);
            $table->double('delivery_fee')->nullable(true)->default(0);
            $table->string('delivery_fee_tax')->nullable(true)->default(null);/// 15% VAT, VAT Exempt , Zero Rated
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
        Schema::dropIfExists('quotes');
    }
};
