<?php

use App\Models\Customer;
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
        Schema::create('customer_sales_e_b_s_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->json('jsonRequest')->nullable(true)->default(null);
            $table->string('responseId',70);
            $table->string('requestId',70);
            $table->string('status',70);
            $table->string('invoiceIdentifier',200)->nullable(true)->default(null);
            $table->mediumText('irn')->nullable(true)->default(null);
            $table->longText('qrCode')->nullable(true)->default(null);
            $table->longText('infoMessages')->nullable(true)->default(null);
            $table->longText('errorMessages')->nullable(true)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_sales_e_b_s_results');
    }
};
