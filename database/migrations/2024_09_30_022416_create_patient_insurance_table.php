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
        Schema::create('patient_insurance', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to the patient table
            $table->string('company')->nullable(); // Insurance company name
            $table->string('policy_type')->nullable(); // Type of insurance policy
            $table->string('policy_holder')->nullable(); // ID of policy holder (could be a foreign key)
            $table->string('policy_holder_name')->nullable(); // Name of the policy holder
            $table->string('insured_name')->nullable(); // Name of the insured person
            $table->string('policy_no')->nullable(); // Insurance policy number
            $table->date('start_date')->nullable(); // Start date of the insurance policy
            $table->date('end_date')->nullable(); // End date of the insurance policy
            $table->decimal('catastrophe_limit', 10, 2)->nullable(); // Catastrophe limit (e.g. max coverage for disasters)
            $table->decimal('in_patient_limit', 10, 2)->nullable(); // In-patient treatment coverage limit
            $table->decimal('out_patient_limit', 10, 2)->nullable(); // Out-patient treatment coverage limit
            $table->text('note')->nullable(); // Additional notes or comments
            $table->unsignedBigInteger('action_done_by'); // User ID of the person who performed the action
            $table->unsignedBigInteger('created_by'); // User ID of the person who created the record
            $table->timestamps(); // Automatically manage `created_at` and `updated_at` timestamps

            // Optionally, add foreign key constraints if needed
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_hospitalization');
    }
};
