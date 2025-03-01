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
        Schema::create('patient_opd_visits', function (Blueprint $table) {
            $table->id(); // Primary key with auto-incrementing ID
            $table->unsignedBigInteger('patient_id'); // Foreign key referencing the patient           
            $table->date('visit_date'); // Date of the OPD visit
            $table->string('doctor'); // Reason for the OPD visit
            $table->text('purpose')->nullable(); // Diagnosis made by the doctor
            $table->text('outcome')->nullable(); // Treatment prescribed during the visit
            $table->unsignedBigInteger('action_done_by'); // User who recorded the visit details
            $table->unsignedBigInteger('created_by'); // User who recorded the visit details
            $table->timestamps(); // Automatically adds `created_at` and `updated_at` fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_opd_visits');
    }
};
