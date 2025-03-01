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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->enum('storage', ['LOCAL', 'S3'])->nullable();
            $table->string('mimeType')->nullable();
            $table->enum('documentType', ['ATTACHMENT', 'IMPORT', 'EXPORT'])->default('ATTACHMENT');
            $table->string('label')->nullable();
            $table->longText('fileSize');
            $table->string('description', 500);
            $table->string('bucketName');
            $table->string('key', 255);
            $table->string('url', 255);
            $table->boolean('imported')->default(0);
            $table->boolean('generated')->default(0);
            $table->boolean('deleted')->default(0);
            $table->boolean('archived')->default(0);
            $table->string('name', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
