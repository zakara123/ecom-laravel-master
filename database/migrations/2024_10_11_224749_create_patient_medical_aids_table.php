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
        Schema::create('patient_medical_aids', function (Blueprint $table) {
            $table->id(); // Primary key with auto-incrementing ID
            $table->unsignedBigInteger('patient_id'); // Foreign key referencing a patient
            $table->boolean('presc_glasses')->default(0); // Prescribed glasses (1 for yes, 0 for no)
            $table->boolean('hearing_aids')->default(0); // Hearing aids (1 for yes, 0 for no)
            $table->boolean('dentures')->default(0); // Dentures (1 for yes, 0 for no)
            $table->boolean('prosthesis')->default(0); // Prosthesis (1 for yes, 0 for no)
            $table->text('note')->nullable(); // Any additional notes (nullable)
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
        Schema::dropIfExists('patient_medical_aids');
    }
};
