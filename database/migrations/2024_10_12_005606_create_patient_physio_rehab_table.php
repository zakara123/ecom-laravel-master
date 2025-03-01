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
        Schema::create('patient_physio_rehab', function (Blueprint $table) {
            $table->id(); // Primary key with auto-incrementing ID
            $table->unsignedBigInteger('patient_id'); // Foreign key referencing a patient
            $table->string('location'); // Name of the alternative therapy
            $table->string('type'); // Type of therapy (e.g., acupuncture, herbal)
            $table->date('date')->nullable(); // Date of the therapy
            $table->text('purpose')->nullable(); // Description or details of the therapy
            $table->text('outcome')->nullable();
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
        Schema::dropIfExists('patient_physio_rehab');
    }
};
