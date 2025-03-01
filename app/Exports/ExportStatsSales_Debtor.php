<?php

namespace App\Exports;

use App\Models\PayementMethodSales;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportStatsSales_Debtor implements ShouldAutoSize,WithMultipleSheets
{
    use Exportable;

    protected $date_start;
    protected $date_end;
    protected $id_store;

    public function __construct(string $date_s,string $date_e, int $id_store)
    {
        $this->date_start = $date_s;
        $this->date_end = $date_e;
        $this->id_store = $id_store;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ExportStatsSales_Debtor_Customer($this->date_start, $this->date_end, $this->id_store);
        $sheets[] = new ExportStatsSales_Debtor_Payments($this->date_start, $this->date_end, $this->id_store);


        return $sheets;
    }
}
