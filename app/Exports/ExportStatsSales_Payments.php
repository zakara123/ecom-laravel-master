<?php

namespace App\Exports;

use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\SalesPayments;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportStatsSales_Payments implements ShouldAutoSize, WithMultipleSheets
{
    use Exportable;

    protected $date_start;
    protected $date_end;
    protected $id_store;

    public function __construct(string $date_s, string $date_e, int $id_store)
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
        $payement_methodes = PayementMethodSales::orderBy('id', 'Asc')->get();
        if (!$this->id_store) {
            foreach ($payement_methodes as &$pm) {
                $total_pending = Sales::where('status', '=', 'Pending')->where('payment_methode', '=', $pm->id)->whereBetween('created_at', [$this->date_start, $this->date_end])->sum('amount');
                $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
                $pm->pending = $total_pending;
                $pm->paid = $total_paid;
            }
        } else {
            foreach ($payement_methodes as &$pm) {
                $total_pending = Sales::where('status', '=', 'Pending')->where('payment_methode', '=', $pm->id)->where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->sum('amount');

                $id_sale = Sales::where('status', '=', 'Paid')->where('payment_methode', '=', $pm->id)->where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->select('id')->get();

                $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)
                    ->whereIn('sales_id', $id_sale->pluck('id')) // Corrected here
                    ->whereBetween('payment_date', [$this->date_start, $this->date_end])
                    ->sum('amount');




                $pm->pending = $total_pending;
                $pm->paid = $total_paid;
            }
        }

        foreach ($payement_methodes as $p) {
            if ($p->pending || $p->paid)
                $sheets[] = new ExportStatsSales_Payments_Methods($this->date_start, $this->date_end, $this->id_store, $p->id);
        }
        $sheets[] = new ExportStatsSales_Payments_Methods($this->date_start, $this->date_end, $this->id_store, 0);


        return $sheets;
    }
}
