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
        Schema::create('patient_hospitalization', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to the patient table
            $table->string('date')->nullable(); // Contact's name
            $table->string('outcome')->nullable(); // Relationship type (e.g., 2 for specific relation)
            $table->string('hospital')->nullable(); // Primary phone number
            $table->string('stay')->nullable(); // Secondary phone number, nullable
            $table->string('reason')->nullable(); // Contact's email, nullable           
            $table->unsignedBigInteger('action_done_by'); // ID of the user who performed the action
            $table->unsignedBigInteger('created_by'); // ID of the user who created the record
            $table->timestamp('created_at')->useCurrent(); // Timestamp for record creation
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
        Schema::dropIfExists('patient_hospitalization');
    }
};
