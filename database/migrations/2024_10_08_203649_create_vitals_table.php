<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('circumference')->nullable();
            $table->float('bmi')->nullable();
            $table->float('pulse')->nullable();
            $table->float('sys_blood_pressure')->nullable();
            $table->float('dia_blood_pressure')->nullable();
            $table->float('mean_blood_pressure')->nullable();
            $table->float('blood_sugar')->nullable();
            $table->text('sugar_comments')->nullable();
            $table->float('respiratory_rate')->nullable();
            $table->float('spo2')->nullable();
            $table->text('spo2_comments')->nullable();
            $table->float('temperature')->nullable();
            $table->float('pain_score')->nullable();
            $table->text('pain_comments')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
}
