<?php

namespace App\Imports;

use App\Models\LedgerOlderSales;
use App\Models\PayementMethodSales;
use App\Models\SalesPayments;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerSalesPayment implements ToModel, WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $order_id = trim($row['order_id']);
        $payment_date = trim($row['payment_date']);
        $payment_mode = trim($row['payment_mode']);
        $payment_reference = trim($row['payment_reference']);
        $amount = trim($row['amount']);
        $matched_transaction = trim($row['matched_transaction']);
        $is_pettycash = trim($row['is_pettycash']);


        $id_payment_method = '';
        if ($payment_mode){
            $slug = self::transform_slug($payment_mode);
            $check_method = PayementMethodSales::where('slug','=',$slug)->orderBy('id','DESC')->first();
            if (!$check_method){
                $payment_methode_in = PayementMethodSales::updateOrCreate([
                    'slug' => self::transform_slug($payment_mode),
                    'payment_method' => $payment_mode,
                ]);
                $id_payment_method = $payment_methode_in->id;
            } else $id_payment_method = $check_method->id;
        }
        $check_old_order = LedgerOlderSales::where('id_sale_import','=',$order_id)->orderBy('id','DESC')->first();
        $id_sales = 0;
        if ($check_old_order) {
            $id_sales = $check_old_order->id_sale_new;
        }
        if (!$matched_transaction) $matched_transaction = null;
        if (!$is_pettycash) $is_pettycash = null;
        if (!$payment_reference) $payment_reference = null;

        $sale_payment = SalesPayments::updateOrCreate([
            'sales_id' =>$id_sales,
            'payment_date' =>$payment_date,
            'payment_mode' =>$id_payment_method,
            'payment_reference' =>$payment_reference,
            'matched_transaction' =>$matched_transaction,
            'is_pettycash' =>$is_pettycash,
            'amount'  =>$amount
        ]);

        return $sale_payment;

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
