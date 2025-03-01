<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesPayments;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SalesImport implements ToModel, WithHeadingRow, WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // dd($row);
        // Check if the customer already exists
        $customer = Customer::where('firstname', strtolower(str_replace(' ', '', trim($row['customer_name'] ?? ''))))->first();



        if (!$customer) {
            // If not found, create a new customer
            $customer = Customer::create([
                'firstname' => strtolower(str_replace(' ', '', trim($row['customer_name'] ?? ''))),
                'lastname' => ' ',
                'company_name' => $row['company_name'] ?? '',
                'address1' => $row['address'] ?? '',
                'address2' => ' ',
                'city' => ' ',
                'country' => ' ',
                'email' => $row['customer_email'],
                'phone' => $row['phone'] ?? '',
                'fax' => $row['fax'] ?? '',
                'brn_customer' => $row['brn_customer'] ?? '',
                'vat_customer' => $row['vat_customer'] ?? '',
                'note_customer' => $row['note_customer'] ?? '',
                'temp_password' => ' ',
                'type' => 'customer',
                'date_of_birth' => ' ',
                'work_address' => ' ',
                'work_village' => ' ',
                'other_address' => ' ',
                'other_village' => ' ',
                'whatsapp' => ' ',
                'mobile_no' => ' ',
                'user_id' => ' ',
                'nid' => ' ',
                'upi' => ' ',
                'blood_group' => ' ',
                'sex' => ' ',
            ]);
        }

        // Get customer ID
        $customerId = $customer->id;

        $paymentModes = [
            'cash' => 1,
            'credit-sale' => 2,
            'cheque' => 3,
            'bank-transfer' => 4,
            'debit-credit-card' => 5,
            'payment-due' => 6,
            'cash-sale' => 7,
            'credit-debit-card-online-payment' => 8,
            'eur-payment' => 9,
            'invoiced' => 10,
            'juice' => 11,
            'multiple-payment-methods' => 12,
            'mur-payment' => 13,
            'usd-payment' => 14,

        ];

        $payment_mode = $paymentModes[$row['payment_methode']] ?? 1;


        $orderstatus = [
            'pending' => 'Pending Payment',
            'completed' => 'Paid',
            'cancelled' => 'Cancelled'
        ];

        $order_status = $orderstatus[$row['status']];



        $salecheck = SalesPayments::where('payment_reference', $row['id'])
            ->first();


        if (!in_array($order_status, ["Cancelled", "Pending Payment"])) {

            if (!$salecheck) {
                $Sales = Sales::create([
                    'delivery_date' => $row['delivery_date'] ?? '',
                    'amount' => $row['amount'] ?? '',
                    'subtotal' => $row['subtotal'] ?? '',
                    'tax_amount' => $row['tax_amount_converted'] ?? '',
                    'currency' => $row['currency'] ?? '',
                    'status' => $order_status,
                    'order_reference' => $row['order_reference'] ?? '',
                    'customer_id' => $customerId,
                    'customer_firstname' => strtolower(str_replace(' ', '', trim($row['customer_name'] ?? ''))),
                    'customer_lastname' => ' ',
                    'customer_name' => strtolower(str_replace(' ', '', trim($row['customer_name'] ?? ''))),
                    'customer_address' => $row['address'] ?? '',
                    'customer_city' => ' ',
                    'customer_email' => $row['customer_email'] ?? '',
                    'customer_phone' => $row['phone'] ?? '',
                    'comment' => '',
                    'internal_note' => $row['internal_note'] ?? '',
                    'payment_methode' => $payment_mode,
                    'date_paied' => $row['date_paied'] ?? '',
                    'user_id' => $row['user_id'] ?? '1',
                    'id_store' => '1',
                    'tax_items' => $row['vat_amount'] ?? '',
                    'date_resent_mail_sale' => $row['date_resent_mail_sale'] ?? '',
                    'date_resent_mail_invoice' => $row['date_resent_mail_invoice'] ?? '',
                    'pickup_or_delivery' => ' ',
                    'id_store_pickup' => $row['id_store_pickup'] ?? '',
                    'store_pickup' => $row['store_pickup'] ?? '',
                    'date_pickup' => $row['delivery_pickup_date'] ?? '',
                    'id_delivery' => ' ',
                    'delivery_name' => ' ',
                    'delivery_fee' => ' ',
                    'delivery_fee_tax' => ' ',
                    'type_sale' => 'BACK_OFFICE_SALE',
                    'created_at' => $row['order_date'] ?? '',
                    'amount_converted' => $row['amount_converted'] ?? '',
                    'subtotal_converted' => $row['subtotal_converted'] ?? '',
                    'tax_amount_converted' => $row['tax_amount_converted'] ?? '',
                    'currency_amount' => $row['currency_value'] ?? '',
                ]);


                session(['orderid' => $Sales->id]);
            }



            $orderid = session('orderid');

            $payment_modepay = $paymentModes[$row['payment_mode']] ?? 1;





            $SalesPayment = SalesPayments::create([
                'sales_id' => $orderid ?? '',
                'payment_date' => $row['date_event'] ?? '',

                'payment_mode' => $payment_modepay ?? '',
                'payment_reference' => $row['id'] ?? '',
                'amount' => $row['amount_paid'] ?? '',
                'due_amount	' => $row['amount_due'] ?? '',
                'created_at' => $row['date_event'] ?? '',
            ]);
        }
    }

    /**
     * Read data in chunks of 50 rows at a time.
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
