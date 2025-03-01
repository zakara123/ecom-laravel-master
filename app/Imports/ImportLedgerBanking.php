<?php

namespace App\Imports;

use App\Models\Banking;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerBanking implements ToModel, WithHeadingRow
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
        $credit = trim($row['credit']);
        $debit = trim($row['debit']);
        $date = trim($row['date']);
        $reference = trim($row['reference']);
        $amount = trim($row['amount']);
        $description= trim($row['description']);
        $matching_satus = trim($row['matching_satus']);
        $petty_cash_matched = trim($row['petty_cash_matched']);
        $is_manual = trim($row['is_manual']);

        $banking = Banking::updateOrCreate([
            'debit' =>$debit,
            'credit' =>$credit,
            'amount' =>$amount,
            'date' =>$date,
            'reference' =>$reference,
            'description' =>$description,
            'matching_status' =>$matching_satus,
            'petty_cash_matched' =>$petty_cash_matched,
            'is_manual' => $is_manual
        ]);
        return $banking;
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
