<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Sales;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sales::class);
            $table->string('name',120)->nullable(false);
            $table->string('type',100)->nullable(false);
            $table->dateTime('date_generated')->nullable(true)->default(null);
            $table->dateTime('date_send_by_mail')->nullable(true)->default(null);
            $table->string('src',500)->nullable(false);
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
        Schema::dropIfExists('sales_files');
    }
};
