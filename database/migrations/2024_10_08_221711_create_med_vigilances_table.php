<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedVigilancesTable extends Migration
{
    public function up()
    {
        Schema::create('med_vigilances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->date('date_investigations')->nullable();
            $table->text('investigations')->nullable();
            $table->date('date_radiology')->nullable();
            $table->text('radiology')->nullable();
            $table->date('date_equipment')->nullable();
            $table->text('equipment')->nullable();
            $table->date('date_medvigilance')->nullable();
            $table->text('medvigilance')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('med_vigilances');
    }
}
