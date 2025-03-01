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
        Schema::create('patient_immunization', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to the patients table
            $table->string('injection')->nullable(); // Optional: DDA drug information
            $table->date('started_on')->nullable(); // Date when medication started
            $table->text('note')->nullable(); // Additional notes
            $table->string('action_done_by')->nullable(); // Who performed the action
            $table->string('created_by')->nullable(); // Who created the entry
            $table->timestamps();
           // $table->timestamp('updated_at')->nullable();
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
