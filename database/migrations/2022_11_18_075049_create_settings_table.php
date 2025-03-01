<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value')->nullable(true)->default(null);
            $table->timestamps();
        });
        DB::table('settings')->insert(
            array(
                'key' => 'product_stock_from_api',
                'value' => 'no'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'stock_required_online_shop',
                'value' => 'no'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'display_online_shop_product',
                'value' => 'yes'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'display_logo_in_pdf',
                'value' => 'no'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'store_name_meta',
                'value' => 'Shop Ecom'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'store_description_meta',
                'value' => 'Ecom, Shop, Ecommerce'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'image_required_for_product_onlineshop',
                'value' => 'no'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'send_backoffice_order_mail',
                'value' => 'yes'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'send_onlineshop_order_mail',
                'value' => 'yes'
            )
        );

        DB::table('settings')->insert(
            array(
                'key' => 'ebs_typeOfPerson',
                'value' => 'NVTR'
            )
        );
        DB::table('settings')->insert(
            array(
                'key' => 'ebs_invoiceIdentifier',
                'value' => 'Todaydate'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
