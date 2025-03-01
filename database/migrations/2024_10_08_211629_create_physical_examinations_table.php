<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalExaminationsTable extends Migration
{
    public function up()
    {
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->boolean('p_check')->default(0)->nullable();
            $table->boolean('i_check')->default(0)->nullable();
            $table->boolean('c_check')->default(0)->nullable();
            $table->boolean('k_check')->default(0)->nullable();
            $table->boolean('l_check')->default(0)->nullable();
            $table->boolean('e_check')->default(0)->nullable();
            $table->text('e_comments')->nullable();
            $table->text('cvs_comments')->nullable();
            $table->text('rs_comments')->nullable();
            $table->text('cns_comments')->nullable();
            $table->text('abdomen_comments')->nullable();
            $table->text('skin_comments')->nullable();
            $table->text('genitourinary')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('physical_examinations');
    }
}
