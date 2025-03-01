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
        \App\Models\Store::where('name', 'Default Store')->update(['name' => 'Warehouse']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Store::where('name', 'Warehouse')->update(['name' => 'Default Store']);
    }
};
