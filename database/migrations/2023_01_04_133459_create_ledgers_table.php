<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->nullable(false);
            $table->integer('id_ledger_group')->nullable(true)->default(null);
            $table->boolean('is_account')->nullable(true)->default(0);
            $table->integer('ledger_number')->nullable(true)->default(null);
            $table->enum('is_locked', array('yes','no'))->default('no')->nullable(false);
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
        Schema::dropIfExists('ledgers');
    }
};
