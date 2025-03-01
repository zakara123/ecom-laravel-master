<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_invoice_counters', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_id')->nullable(true);
            $table->integer('creditnote_id')->nullable(true);
            $table->integer('debitnote_id')->nullable(true);
            $table->enum('is_sales', array('yes','no'))->default('no')->nullable(false);
            $table->enum('is_creditnote', array('yes','no'))->default('no')->nullable(false);
            $table->enum('is_debitnote', array('yes','no'))->default('no')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_counters');
    }
};
