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
        Schema::create('patient_surgery', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->date('date_of_surgery'); // Date of the note
            $table->string('procedure'); // Doctor's name
            $table->string('ICDCode'); // The confidential note text
            $table->string('stay_lenght_day'); // The confidential note text
            $table->string('hospital'); // The confidential note text
            $table->string('result'); // The confidential note text
            $table->string('attending_surgeon');
            $table->unsignedBigInteger('action_done_by'); // Foreign key to user table
            $table->unsignedBigInteger('created_by'); // Foreign key for who created the record

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_surgery');
    }
};
