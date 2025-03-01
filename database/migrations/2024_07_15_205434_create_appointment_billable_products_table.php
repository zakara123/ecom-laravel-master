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
        Schema::create('appointment_billable_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('appointment_billable_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_variations_id')->nullable();
            $table->double('order_price');
            $table->double('quantity');
            $table->string('product_name', 150);
            $table->string('product_unit', 50)->nullable();
            $table->string('tax_sale', 200)->nullable();
            $table->timestamps();
            $table->string('frequency', 200)->nullable();

            // Foreign key constraints
           // $table->foreign('appointment_billable_id')->references('id')->on('appointment_billable')->onDelete('cascade');
            // Add other foreign key constraints as needed

            $table->index('product_id');
            // Add any additional indexes as needed

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
        Schema::dropIfExists('appointment_billable_products');
    }
};
