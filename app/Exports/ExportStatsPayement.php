<?php

namespace App\Exports;

use App\Models\SalesPayments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

use DB;

class ExportStatsPayement implements FromQuery, WithTitle, WithHeadings
{
    protected $date_start;
    protected $date_end;

    public function __construct(string $date_s,string $date_e)
    {
        $this->date_start = date('Y-m-d',strtotime($date_s));
        $this->date_end = date('Y-m-d',strtotime($date_e));
    }

    /**
     * @return Builder
     */
    public function query()
    {
        if ($this->date_end != date('Y-m-d', strtotime(''))){

            return SalesPayments::query()
                ->select( 'sales_id', DB::raw("DATE_FORMAT(payment_date, '%d/%m/%Y') as payment_date"), 'payment_mode', 'payment_reference', 'amount')
                ->where('payment_date','>=',$this->date_start)
                ->where('payment_date','<=',$this->date_end);
        }

        return SalesPayments::query()
            ->select( 'sales_id', DB::raw("DATE_FORMAT(payment_date, '%d/%m/%Y') as payment_date"), 'payment_mode', 'payment_reference', 'amount')
            ->where('payment_date','>=',$this->date_start);

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Payment ' . $this->date_start . ' ' . $this->date_end;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ['Sales Id', 'Payment Date', 'Payment Mode', 'Payment Reference', 'Amount'];

        return $heading;
    }
}
