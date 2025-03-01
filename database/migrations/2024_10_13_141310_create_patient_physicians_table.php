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
        Schema::create('patient_physicians', function (Blueprint $table) {
            $table->id(); // Primary key with auto-incrementing ID
            $table->unsignedBigInteger('patient_id'); // Foreign key referencing the patient
            $table->string('physician_name'); // Name of the physician
            $table->string('physician_type'); // Type of physician (e.g., specialist, general)
            $table->string('physician_phone')->nullable(); // Physician's phone number
            $table->string('physician_fax')->nullable(); // Physician's fax number
            $table->string('physician_email')->nullable(); // Physician's email address
            $table->string('physician_address')->nullable(); // Physician's address
            $table->text('physician_note')->nullable(); // Additional notes about the physician
            $table->unsignedBigInteger('action_done_by'); // User who performed the action
            $table->unsignedBigInteger('created_by'); // User who created the record
            $table->timestamps(); // Automatically creates `created_at` and `updated_at` fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_physicians');
    }
};
