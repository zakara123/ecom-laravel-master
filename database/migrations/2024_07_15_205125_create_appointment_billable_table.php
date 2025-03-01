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
        Schema::create('appointment_billable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('appointment_id')->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->double('amount')->default(0);
            $table->double('subtotal')->default(0);
            $table->double('tax_amount')->default(0);
            $table->double('duration')->default(0);
            $table->string('currency', 5)->default('MUR');
            $table->string('status', 70);
            $table->string('order_reference', 200)->nullable();
            $table->mediumText('comment')->nullable();
            $table->longText('internal_note')->nullable();
            $table->integer('payment_method')->nullable();
            $table->datetime('date_paid')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('id_store')->nullable();
            $table->string('tax_items', 200)->default('No VAT');
            $table->datetime('date_resent_mail_sale')->nullable();
            $table->datetime('date_resent_mail_invoice')->nullable();
            $table->enum('pickup_or_delivery', ['Pickup', 'Delivery'])->nullable();
            $table->integer('id_store_pickup')->nullable();
            $table->string('store_pickup', 90)->nullable();
            $table->date('date_pickup')->nullable();
            $table->integer('id_delivery')->nullable();
            $table->string('delivery_name', 100)->nullable();
            $table->double('delivery_fee')->default(0);
            $table->string('delivery_fee_tax', 200)->nullable();
            $table->enum('type_sale', ['Online Sales', 'New Sales Page']);
            $table->timestamps();
            $table->date('rental_start_date')->nullable();
            $table->date('rental_end_date')->nullable();
            $table->string('village_town', 200)->nullable();
            $table->string('delivery_address', 200)->nullable();

            $table->index('user_id');
            $table->index('type_sale');
            // Add any additional indexes or foreign keys as needed

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_billable');
    }
};
