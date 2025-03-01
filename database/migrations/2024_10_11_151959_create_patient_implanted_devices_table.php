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
        Schema::create('patient_implanted_devices', function (Blueprint $table) {
            $table->id(); // Primary key with auto-incrementing ID
            $table->unsignedBigInteger('patient_id'); // Foreign key referencing a patient
            $table->date('date_of_implanted'); // Date when the device was implanted
            $table->string('location_on_body'); // Location of the implanted device on the body
            $table->string('name'); // Name of the device
            $table->text('note')->nullable(); // Any notes (nullable field)
            $table->unsignedBigInteger('action_done_by'); // User who performed the action
            $table->unsignedBigInteger('created_by'); // User who created the record
            $table->timestamps(); // This will automatically create `created_at` and `updated_at` fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_implanted_devices');
    }
};
