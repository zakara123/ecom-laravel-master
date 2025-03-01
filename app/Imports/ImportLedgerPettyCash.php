<?php

namespace App\Imports;

use App\Models\Ledger;
use App\Models\PettyCash;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerPettyCash implements ToModel, WithHeadingRow
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
        $amount = trim($row['amount']);
        $description= trim($row['description']);
        $matching_satus = trim($row['matching_satus']);
        $is_account_payable = trim($row['is_account_payable']);
        $ledger_account = trim($row['ledger_account']);
        $banking_matched = trim($row['banking_matched']);

        $id_ledger = 0;
        $ledger_checked = Ledger::where('name','=',trim($ledger_account))->orderBy('id','DESC')->first();
        if (!$ledger_checked){
            $ledger = Ledger::updateOrCreate([
                'name' => trim($ledger_account),
                'id_ledger_group' => 0,
            ]);
            $id_ledger = $ledger->id;
        } else $id_ledger = $ledger_checked->id;

        $pettycash = PettyCash::updateOrCreate([
            'debit' =>$debit,
            'credit' =>$credit,
            'amount' =>$amount,
            'date' =>$date,
            'description' =>$description,
            'matching_status' =>$matching_satus,
            'is_account_payable' =>$is_account_payable,
            'ledger_account' => $id_ledger,
            'banking_matched' =>$banking_matched
        ]);
        return $pettycash;
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
