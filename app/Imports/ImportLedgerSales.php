<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\LedgerOlderSales;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerSales implements ToModel, WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $id = trim($row['id']);
        $order_date = trim($row['order_date']);
        $delivery_date = trim($row['delivery_date']);
        $amount = trim($row['amount']);
        $amount_given = trim($row['amount_given']);
        $tax_amount = trim($row['tax_amount']);
        $subtotal = trim($row['subtotal']);
        $currency = trim($row['currency']);
        $currency_value = trim($row['currency_value']);
        $amount_converted = trim($row['amount_converted']);
        $tax_amount_converted = trim($row['tax_amount_converted']);
        $subtotal_converted = trim($row['subtotal_converted']);
        $status = trim($row['status']);
        $order_reference = trim($row['order_reference']);
        $customer_id = trim($row['customer_id']);
        $customer_name = trim($row['customer_name']);
        $customer_address = trim($row['customer_address']);
        $customer_email = trim($row['customer_email']);
        $customer_phone = trim($row['customer_phone']);
        $comment = trim($row['comment']);
        $internal_note = trim($row['internal_note']);
        $payment_methode = trim($row['payment_methode']);
        $date_paied = trim($row['date_paied']);
        $location_tax = trim($row['location_tax']);
        $pickup_delivery= trim($row['pickup_delivery']);
        $id_store_pickup = trim($row['id_store_pickup']);
        $store_pickup = trim($row['store_pickup']);
        $date_resent_mail_sale = trim($row['date_resent_mail_sale']);
        $date_resent_mail_invoice = trim($row['date_resent_mail_invoice']);

        $customer_firtname = $customer_lastname = null;
        if (trim($customer_name)) {
            $check_customer = Customer::where('firstname','=',$customer_name)->orWhere('lastname','=',$customer_name)->orderBy('id','DESC')->first();
            if (!$check_customer){
                $customer = Customer::updateOrCreate([
                    'firstname' => $customer_name,
                    'address1' => $customer_address,
                    'email' => $customer_email,
                    'phone' => $customer_phone,
                ]);
                $customer_id = $customer->id;
                $customer_firtname = $customer->firstname;
                $customer_lastname = $customer->lastname;
            } else {
                $customer_id = $check_customer->id;
                $customer_firtname = $check_customer->firstname;
                $customer_lastname = $check_customer->lastname;
            }
        }
        if (!$customer_id) $customer_id = 0;
        $id_payment_method = null;
        if ($payment_methode){
            $payment_methode_methode = strtoupper(str_replace('-',' ',$payment_methode));
            $check_method = PayementMethodSales::where('slug','=',$payment_methode)->orderBy('id','DESC')->first();
            if (!$check_method){
                $payment_methode_in = PayementMethodSales::updateOrCreate([
                    'slug' => self::transform_slug($payment_methode),
                    'payment_method' => $payment_methode_methode,
                ]);
                $id_payment_method = $payment_methode_in->id;
            } else $id_payment_method = $check_method->id;
        }

        $id_store_pickup_sale = $name_store_pickup_sale = null;
        if ($id_store_pickup && $store_pickup){
            $check_store_pickup = Store::where('name','=',$store_pickup)->orderBy('id','DESC')->first();
            if (!$check_store_pickup){
                $store_pick_in = Store::updateOrCreate([
                    'name' => $store_pickup,
                ]);
                $id_store_pickup_sale = $store_pick_in->id;
                $name_store_pickup_sale = $store_pick_in->name;
            } else {
                $id_store_pickup_sale = $check_store_pickup->id;
                $name_store_pickup_sale = $check_store_pickup->name;
            }
        }
        if (!$delivery_date) $delivery_date = null;
        if (!$date_paied) $date_paied = null;
        if (!$date_resent_mail_sale) $date_resent_mail_sale = null;
        if (!$date_resent_mail_invoice) $date_resent_mail_invoice = null;
        if (!$pickup_delivery) $pickup_delivery = 'Pickup';


        $check_old_order = LedgerOlderSales::where('id_sale_import','=',$id)->orderBy('id','DESC')->first();
        if (!$check_old_order) {

            $sale = Sales::updateOrCreate([
                'delivery_date' => $delivery_date,
                'amount' => $amount,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'currency' => $currency,
                'amount_converted' => $amount_converted,
                'subtotal_converted' => $subtotal_converted,
                'tax_amount_converted' => $tax_amount_converted,
                'status' => strtoupper($status),
                'order_reference' => $order_reference,
                'customer_id' => $customer_id,
                'customer_firstname' => $customer_firtname,
                'customer_lastname' =>$customer_lastname,
                'customer_address' =>$customer_address,
                'customer_city' => '',
                'customer_email' =>$customer_email,
                'customer_phone' =>$customer_phone,
                'comment' =>$comment,
                'internal_note' =>$internal_note,
                'payment_methode' =>$id_payment_method,
                'date_paied' => $date_paied,
                'date_resent_mail_sale' => $date_resent_mail_sale,
                'date_resent_mail_invoice' => $date_resent_mail_invoice,
                'pickup_or_delivery' => $pickup_delivery,
                'id_store_pickup' =>$id_store_pickup_sale,
                'id_store' => 1,
                'store_pickup' =>$name_store_pickup_sale,
                'created_at' => $order_date
            ]);
            $sale_ledger = LedgerOlderSales::updateOrCreate([
                'id_sale_import' => $id,
                'id_sale_new' => $sale->id
            ]);
            return $sale;
        }
        $sale = Sales::find($check_old_order->id_sale_new);
        return $sale;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(Date::excelToDateTimeObject($value));
        } catch (ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        return $str;
    }

    protected function vatTransform($vat)
    {
        if ($vat == '0') {
            $vat = 'Zero Rated';
        } elseif ($vat == 'Ex' || $vat == 'ex') {
            $vat = 'VAT Exempt';
        } elseif ($vat > 0 && is_numeric($vat)) {
            $vat = $vat . '% VAT';
        }
        return $vat;
    }
}
