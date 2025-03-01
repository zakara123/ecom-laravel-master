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
        Schema::create('patient_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->date('date')->nullable(); // Date of diagnosis
            $table->string('diagnosis')->nullable(); // Diagnosis description
            $table->string('treatment')->nullable(); // Treatment description
            $table->string('ICDCode')->nullable(); // ICD Code for diagnosis
            $table->text('note')->nullable(); // Additional notes (optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_diagnosis');
    }
};
