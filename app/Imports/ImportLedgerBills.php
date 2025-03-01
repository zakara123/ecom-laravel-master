<?php

namespace App\Imports;

use App\Models\LedgerOlderBills;
use App\Models\PayementMethodSales;
use App\Models\Store;
use App\Models\Bill;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerBills implements ToModel, WithHeadingRow
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
        $date_purchase = trim($row['date_purchase']);
        $date_modified = trim($row['date_modified']);
        $delivery_date = trim($row['delivery_date']);
        $due_date = trim($row['due_date']);
        $amount = trim($row['amount']);
        $tax_amount = trim($row['tax_amount']);
        $subtotal = trim($row['subtotal']);
        $status= trim($row['status']);
        $bill_reference = trim($row['bill_reference']);
        $comment = trim($row['comment']);
        $internal_note = trim($row['internal_note']);
        $payment_methode = trim($row['payment_methode']);
        $date_paied = trim($row['date_paied']);
        $id_supplier = trim($row['id_supplier']);
        $supplier_name = trim($row['supplier_name']);
        $supplier_phone = trim($row['supplier_phone']);
        $location_tax = trim($row['location_tax']);
        $pickup_delivery = trim($row['pickup_delivery']);
        $id_store_pickup = trim($row['id_store_pickup']);
        $store_pickup = trim($row['store_pickup']);
        $bill_type = trim($row['bill_type']);
        $date_resent_mail_sale = trim($row['date_resent_mail_sale']);
        $date_resent_mail_invoice = trim($row['date_resent_mail_invoice']);

        $supplier_id = 0;
        $supplier_nom = $supplier_email = $supplier_phone = $supplier_adress = null;
        if (trim($supplier_name) && trim($id_supplier)) {
            $check_supplier = Supplier::where('name','=',$supplier_name)->orderBy('id','DESC')->first();
            if (!$check_supplier){
                $supplier = Supplier::updateOrCreate([
                    'name' => $supplier_name,
                    'email_address' => $supplier_phone,
                    'address' => '',
                    'mobile' => $supplier_phone,
                ]);
                $supplier_id = $supplier->id;
                $supplier_nom = $supplier->name;
                $supplier_email = $supplier->email_address;
                $supplier_phone = $supplier->mobile;
                $supplier_adress = $supplier->address;

            } else {
                $supplier_id = $check_supplier->id;
                $supplier_nom = $check_supplier->name;
                $supplier_email = $check_supplier->email_address;
                $supplier_phone = $check_supplier->mobile;
                $supplier_adress = $check_supplier->address;
            }
        }
        $id_payment_method = 0;
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
        if (!$due_date) $due_date = null;
        if (!$id_store_pickup_sale) {
            $id_store_pickup_sale = 1;
            $store = Store::find(1);
            $name_store_pickup_sale = $store->name;
        }

        if (!$subtotal) $subtotal = 0;
        if (!$bill_reference) $bill_reference = null;
        if (!$comment) $comment = null;


        $check_old_order = LedgerOlderBills::where('id_bill_import','=',$id)->orderBy('id','DESC')->first();
        if (!$check_old_order) {
            $bill = Bill::updateOrCreate([
                'delivery_date' => $delivery_date,
                'due_date' => $due_date,
                'amount' => $amount,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'status' => $status,
                'bill_reference' => $bill_reference,
                'comment' => $comment,
                'payment_methode' => $id_payment_method,
                'date_paied' => $date_paied,
                'id_store' => $id_store_pickup_sale,
                'store' => $name_store_pickup_sale,
                'id_supplier' => $supplier_id,
                'supplier_name' => $supplier_nom,
                'supplier_email' => $supplier_email,
                'supplier_phone' => $supplier_phone,
                'supplier_address' => $supplier_adress,
                'created_at' => $date_purchase
            ]);
            $bill_ledger = LedgerOlderBills::updateOrCreate([
                'id_bill_import' => $id,
                'id_bill_new' => $bill->id
            ]);
            return $bill;
        }
        $bill = Bill::find($check_old_order->id_bill_new);
        return $bill;

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
