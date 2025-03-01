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
        Schema::create('patient_allergies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->string('allergen'); // Doctor's name
            $table->string('reaction'); // Doctor's name
            $table->text('severity'); // The confidential note text
            $table->text('note'); // The confidential note text
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
        Schema::dropIfExists('patient_allergies');
    }
};
