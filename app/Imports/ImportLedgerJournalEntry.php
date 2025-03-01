<?php

namespace App\Imports;

use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\LedgerOlderBills;
use App\Models\LedgerOlderSales;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLedgerJournalEntry implements ToModel, WithHeadingRow
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
        $id_order = trim($row['id_order']);
        $debit = trim($row['debit']);
        $credit = trim($row['credit']);
        $amount = trim($row['amount']);
        $date = trim($row['date']);
        $description= trim($row['description']);
        $name = trim($row['name']);
        $bills = trim($row['bills']);
        $banking = trim($row['banking']);
        $journal_id = trim($row['journal_id']);
        $credit_card = trim($row['credit_card']);
        $is_pettycash = trim($row['is_pettycash']);

        $id_order = 0;
        $check_old_order = LedgerOlderSales::where('id_sale_import','=',$id_order)->orderBy('id','DESC')->first();
        if ($check_old_order) {
            $id_order = $check_old_order->id_sale_new;
        }
        if ($bills) {
            $check_old_bill = LedgerOlderBills::where('id_bill_import','=',$id_order)->orderBy('id','DESC')->first();
            if ($check_old_bill) {
                $id_order = $check_old_bill->id_bill_new;
            } else $bills = null;
        } else $bills = null;

        if ($debit) {
            $ledger_checked = Ledger::where('name','=',trim($debit))->orderBy('id','DESC')->first();
            $debit = $ledger_checked->id;
        }

        if ($credit) {
            $ledger_checked = Ledger::where('name','=',trim($credit))->orderBy('id','DESC')->first();
            $credit = $ledger_checked->id;
        }
        $count_journal = JournalEntry::count();
        $journal_id_new = 1;
        $last_id_journal = JournalEntry::orderBy('id','DESC')->first();
        if ($count_journal > 0) $journal_id_new = $last_id_journal->journal_id + 1;
        if (!$banking) $banking = null;

        $journal = JournalEntry::updateOrCreate([
            'id_order' => $id_order,
            'debit' => $debit,
            'credit' => $credit,
            'amount' => $amount,
            'date' => $date,
            'description' => $description,
            'name' => $name,
            'bills' => $bills,
            'banking' => $banking,
            'journal_id' => $journal_id_new,
            'credit_card' => $credit_card,
            'is_pettycash' => $is_pettycash,
        ]);
        return $journal;

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
