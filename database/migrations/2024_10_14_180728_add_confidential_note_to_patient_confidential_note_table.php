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
        Schema::create('patient_confidential_note', function (Blueprint $table) {
            $table->id();
            
            // Fields you mentioned
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->date('note_date'); // Date of the note
            $table->string('note_doctor_name'); // Doctor's name
            $table->text('confidential_note'); // The confidential note text
            $table->unsignedBigInteger('action_done_by'); // Foreign key to user table
            $table->unsignedBigInteger('created_by'); // Foreign key for who created the record
            
            // Timestamps (automatically creates `created_at` and `updated_at`)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_confidential_note', function (Blueprint $table) {
            //
        });
    }
};
