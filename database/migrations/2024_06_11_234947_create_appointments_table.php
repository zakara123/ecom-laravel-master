<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Pending');
            $table->string('order_reference')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('patient_firstname')->nullable();
            $table->string('patient_lastname')->nullable();
            $table->string('patient_email')->nullable();
            $table->string('patient_phone')->nullable();
            $table->string('type')->nullable();
            $table->string('specialist_type')->nullable();
            $table->date('patient_date_of_birth')->nullable();
            $table->string('patient_mobile_no')->nullable();
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->string('consultation_mode')->nullable();
            $table->string('phone_call_no')->nullable();
            $table->string('consultation_place')->nullable();
            $table->string('consultation_place_address')->nullable();
            $table->string('village_town')->nullable();
            $table->unsignedBigInteger('id_store');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
