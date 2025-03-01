<?php

namespace App\Exports;

use App\Models\Banking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBanking implements FromCollection , WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bankings = Banking::select('id','date','reference','debit','credit','description')->orderBy('date', 'desc')->get();
        foreach ($bankings as &$banking){
            $banking->date = date('d/m/Y', strtotime($banking->date));
        }
        return $bankings;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ["Transaction ID", "Date", "Reference", "Debit", "Credit", "Description"];
        return $heading;
    }

}
