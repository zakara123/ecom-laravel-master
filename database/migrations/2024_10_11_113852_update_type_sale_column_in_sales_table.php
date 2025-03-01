<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTypeSaleColumnInSalesTable extends Migration
{
    public function up()
    {
        // Step 1: Modify the ENUM field to allow the new values
        DB::statement("ALTER TABLE `sales` CHANGE `type_sale` `type_sale` ENUM('Online Sales','New Sales Page','ONLINE_SALE','BACK_OFFICE_SALE') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");

        // Step 2: Update the existing values
        DB::table('sales')->where('type_sale', 'Online Sales')->update(['type_sale' => 'ONLINE_SALE']);
        DB::table('sales')->where('type_sale', 'New Sales Page')->update(['type_sale' => 'BACK_OFFICE_SALE']);

        // Step 3: Drop the old ENUM values by modifying the ENUM column again
        DB::statement("ALTER TABLE `sales` CHANGE `type_sale` `type_sale` ENUM('ONLINE_SALE','BACK_OFFICE_SALE') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");
    }

    public function down()
    {
        // Rollback: Revert the changes
        Schema::table('sales', function (Blueprint $table) {
            DB::statement("ALTER TABLE `sales` CHANGE `type_sale` `type_sale` ENUM('Online Sales','New Sales Page') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");
        });
    }
}
