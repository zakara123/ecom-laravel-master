<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentMethodSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists = DB::table('payement_method_sales')
            ->where('payment_method', 'Peach Payment')
            ->exists();

        // Insert only if it doesn't exist
        if (!$exists) {
            DB::table('payement_method_sales')->insert([
                'slug' => 'peach-payment',
                'is_gateway' => 'yes',
                'payment_method' => 'Peach Payment',
                'credentials' => json_encode([
                    'entityId' => '8ac7a4c89309bab101930b3225f40242',
                    'clientId' => '1343cf6864fd7a1f6e21dbb6a46d2c',
                    'clientSecret' => 'yo9D+SjLZB5Jhs+HoduRNRpdONCYyJGqhSSRMceCcB10JQ58tFVPr/LtiWgL4FRG9v/dgAxefUsKWVNnk1VKhg==',
                    'merchantId' => '4d0de6d8c3e544e6b2297cf44d470c22',
                    'allowlistedDomain' => 'http://localhost:8000/peach-payment.php',
                    'authenticationEndpoint' => 'https://sandbox-dashboard.peachpayments.com/api/oauth/token',
                    'checkoutEndpoint' => 'https://testsecure.peachpayments.com',
                ]),
                'text_email' => null,
                'text_email_before' => null,
                'text_email_before_invoice' => null,
                'text_email_after_invoice' => null,
                'text_pdf_before' => null,
                'text_pdf_after' => null,
                'text_pdf_before_invoice' => null,
                'text_pdf_after_invoice' => null,
                'thankyou' => null,
                'failed' => null,
                'option_visibility_mail_sales' => 'yes',
                'option_visibility_mail_invoice' => 'yes',
                'option_visibility_pdf_sales' => 'yes',
                'option_visibility_pdf_invoice' => 'yes',
                'display_delivery_options' => 'no',
                'is_deleted' => 'no',
                'is_on_online_shop_order' => 'yes',
                'is_on_bo_sales_order' => 'yes',
                'is_default' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
