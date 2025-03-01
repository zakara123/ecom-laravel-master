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
        Schema::create('payement_method_sales', function (Blueprint $table) {
            $table->id();
            $table->string('slug',160)->nullable(false);
            $table->string('payment_method',120)->nullable(false)->default(null);
            $table->longText('text_email')->nullable(true)->default(null);
            $table->longText('text_email_before')->nullable(true)->default(null);
            $table->longText('text_email_before_invoice')->nullable(true)->default(null);
            $table->longText('text_email_after_invoice')->nullable(true)->default(null);
            $table->longText('text_pdf_before')->nullable(true)->default(null);
            $table->longText('text_pdf_after')->nullable(true)->default(null);
            $table->longText('text_pdf_before_invoice')->nullable(true)->default(null);
            $table->longText('text_pdf_after_invoice')->nullable(true)->default(null);
            $table->longText('thankyou')->nullable(true)->default(null);
            $table->longText('failed')->nullable(true)->default(null);
            $table->enum('option_visibility_mail_sales', array('yes','no'))->default('yes')->nullable(true);
            $table->enum('option_visibility_mail_invoice', array('yes','no'))->default('yes')->nullable(true);
            $table->enum('option_visibility_pdf_sales', array('yes','no'))->default('yes')->nullable(true);
            $table->enum('option_visibility_pdf_invoice', array('yes','no'))->default('yes')->nullable(true);
            $table->enum('display_delivery_options', array('yes','no'))->default('no')->nullable(true);
            $table->enum('is_deleted', array('yes','no'))->default('no')->nullable(true);
            $table->enum('is_on_online_shop_order', array('yes','no'))->default('yes');
            $table->enum('is_on_bo_sales_order', array('yes','no'))->default('yes');
            $table->enum('is_default', array('yes','no'))->default('no');
            $table->timestamps();
        });
        DB::table('payement_method_sales')->insert(
            array(
                array(
                    'slug' => 'cash',
                    'payment_method' => 'Cash',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'true',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                ),
                array(
                    'slug' => 'credit-sale',
                    'payment_method' => 'Credit Sale',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'true',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                ),
                array(
                    'slug' => 'cheque',
                    'payment_method' => 'Cheque',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'true',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                ),
                array(
                    'slug' => 'bank-transfer',
                    'payment_method' => 'Bank Transfer',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'true',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                ),
                array(
                    'slug' => 'debit-credit-card',
                    'payment_method' => 'Debit/Credit Card',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'true',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                ),
                
                array(
                    'slug' => 'payment-due',
                    'payment_method' => 'Payment Due',
                    'is_default' => 'yes',
                    'is_on_online_shop_order' => 'no',
                    'is_on_bo_sales_order' => 'yes',
                    'created_at'=>date('Y-m-d H:i:s')
                )
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
        Schema::dropIfExists('payement_method_sales');
    }
};
