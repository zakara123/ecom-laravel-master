<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('patient_medication', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to the patients table
            $table->string('medication_type'); // Medication type (e.g., prescription, over-the-counter)
            $table->string('medication_drug_name'); // Name of the drug
            $table->string('medication_dda_drug')->nullable(); // Optional: DDA drug information
            $table->string('medication_dosage')->nullable(); // Dosage (optional)
            $table->string('medication_dosage_other')->nullable(); // Other dosage details (optional)
            $table->string('medication_frequency_of_use')->nullable(); // Frequency of use (e.g., daily, twice a day)
            $table->date('medication_started_on')->nullable(); // Date when medication started
            $table->text('medication_reason_for_taking')->nullable(); // Reason for taking medication
            $table->text('medication_side_effects')->nullable(); // Side effects (if any)
            $table->text('medication_note')->nullable(); // Additional notes
            $table->string('action_done_by')->nullable(); // Who performed the action
            $table->string('created_by')->nullable(); // Who created the entry
            //$table->timestamp('created_at')->useCurrent(); // Timestamp for creation
            $table->date('medication_used_until')->nullable(); // Date until medication was used
            $table->text('medication_discontinued_note')->nullable(); // Notes on why the medication was discontinued
            $table->text('medication_reason_discontinued')->nullable(); // Reason for discontinuing the medication
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medication');
    }
};
