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
        Schema::create('patient_advanced_directives', function (Blueprint $table) {
            $table->id();  // Auto-increment primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key, assuming patient_id is an integer
            $table->boolean('living_will')->default(false); // 1 or 0 to indicate living will status
            $table->boolean('resus_order')->default(false); // 1 or 0 to indicate resuscitation order status
            $table->boolean('elderly_home')->default(false); // 1 or 0 to indicate elderly home care status
            $table->text('funeral_plan')->nullable(); // Nullable text field for funeral plan
            $table->string('attorney_name')->nullable(); // Name of the attorney, optional field
            $table->string('attorney_email')->nullable(); // Attorney email, optional field
            $table->string('attorney_phone', 20)->nullable(); // Attorney phone number, optional
            $table->text('attorney_address')->nullable(); // Attorney address, optional
            $table->string('action_done_by')->nullable(); // Who did the action, optional
            $table->string('created_by')->nullable(); // Who created the record, optional
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_advanced_directives');
    }
};
