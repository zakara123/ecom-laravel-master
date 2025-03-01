<?php

namespace App\Imports;

use App\Models\Banking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportBanking implements ToModel, WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    protected $type_file;

    public function __construct($type){
        $this->type_file = $type;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // TODO: Implement model() method.
        if ($this->type_file == 'MCB PDF Converted to XLS');
            self::import_mcb_convert_xls($row);

    }

    private function import_mcb_convert_xls($rows){
        $date = date('Y-m-d',strtotime(''));
        if ($rows[0])
            $date = date('Y-m-d', strtotime(str_replace('/','-',trim($rows[0]))));

        $reference = trim($rows[2]);
        $description = trim($rows[2]);
        $debit = (float)str_replace(',','.',trim($rows[4]));
        $credit = (float)str_replace(',','.',trim($rows[5]));

        $is_inserable = 0;
        $amount = 0;
        $date_null = date('Y-m-d',strtotime(''));
        if (($date != $date_null) && ($debit != 0 || $credit != 0)){
            if ($debit) $amount = $debit;
            if ($credit) $amount = $credit;
            $check_exitst = Banking::where('reference','=',$reference)
                ->where('description','=',$description)
                ->where('credit','=',$debit)
                ->where('debit','=',$credit)
                ->where('date','=',$date)
                ->where('amount','=',$amount)
                ->get();
            if (count($check_exitst) <= 0)
                $is_inserable = 1;
        }
        if ($is_inserable) {
            Banking::create([
                'debit' => $credit,
                'credit' =>$debit,
                'amount' =>$amount,
                'date' =>$date,
                'reference' =>$reference,
                'description' =>$description,
            ]);
        }

    }
}
