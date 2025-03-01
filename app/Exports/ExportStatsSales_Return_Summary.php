<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesPayments;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportStatsSales_Return_Summary implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{
    protected $date_start;
    protected $date_end;
    protected $id_store;

    public function __construct(string $date_s, string $date_e, int $id_store)
    {
        $this->date_start = date('Y-m-d', strtotime($date_s));
        $this->date_end = date('Y-m-d', strtotime($date_e));
        $this->id_store = $id_store;
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        $summary = array();
        $sales_per = array();
        if ($this->id_store) {
            $sales_per = Sales::where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->select(DB::raw('DATE(created_at) as date_sale'))->groupBy('date_sale')->get();
        } else {
            $sales_per = Sales::whereBetween('created_at', [$this->date_start, $this->date_end])->select(DB::raw('DATE(created_at)  as date_sale'))->groupBy('date_sale')->get();
        }
        foreach ($sales_per as $sp) {
            $sales_date = date('d/m/Y', strtotime($sp->date_sale));
            $amount = 0;
            if ($this->id_store) {
                $amount=Sales::where('id_store', '=', $this->id_store)->where(DB::raw('DATE(created_at)'),'=',$sp->date_sale)->sum('amount');
            } else {
                $amount=Sales::where(DB::raw('DATE(created_at)'),'=',$sp->date_sale)->sum('amount');
            }

            array_push($summary, array(
                'date' => $sales_date,
                'amount' => $amount,
            ));
        }
        return collect($summary);

    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = "Summarised Report";
        return $title;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = [ 'Date', 'Amount'];

        return $heading;
    }
}
