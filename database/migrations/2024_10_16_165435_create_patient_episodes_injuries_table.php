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
        Schema::create('patient_episodes_injuries', function (Blueprint $table) {
             // Auto-incrementing primary key
            $table->id();
        
            // Foreign key to the patients table (you can add foreign key constraints later)
            $table->unsignedBigInteger('patient_id');

            // Injury onset date (when the injury started)
            $table->date('onset');

            // Description of the injury or episode
            $table->text('description');

            // Recovery status or date
            $table->string('recovery')->nullable(); // Can be a status or date, depending on your needs

            // Additional notes regarding the injury
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_episodes_injuries');
    }
};
