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
        Schema::create('patient_home_medical_equipment', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to patient table
            $table->unsignedBigInteger('type'); // Type of medical equipment
            $table->text('note')->nullable(); // Note about the equipment
            $table->unsignedBigInteger('action_done_by'); // Who performed the action
            $table->unsignedBigInteger('created_by'); // Who created the record
            $table->timestamp('created_at')->useCurrent(); // Timestamp of record creation
            $table->timestamp('updated_at')->useCurrent()->nullable(); // Optional timestamp for updates

            // Optionally, add foreign key constraints if needed
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_home_medical_equipment');
    }
};
