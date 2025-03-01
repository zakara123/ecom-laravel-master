<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class StatsExport implements ShouldAutoSize,WithMultipleSheets
{
    use Exportable;

    protected $date_start;
    protected $date_end;

    public function __construct(string $date_s,string $date_e)
    {
        $this->date_start = $date_s;
        $this->date_end = $date_e;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ExportStatsOrders($this->date_start, $this->date_end);
        $sheets[] = new ExportStatsPayement($this->date_start, $this->date_end);


        return $sheets;
    }
}
