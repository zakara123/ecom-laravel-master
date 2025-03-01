<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\SalesPayments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportStatsSales_Debtor_Customer implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
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
        $debtors = array();
        $sales_customer = array();
        if ($this->id_store) {
            $sales_customer = Sales::where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->distinct()->get(['customer_id']);
        } else {
            $sales_customer = Sales::whereBetween('created_at', [$this->date_start, $this->date_end])->distinct()->get(['customer_id']);
        }

        foreach ($sales_customer as $sc) {
            $customer = Customer::find($sc->customer_id);
            $sale_ids = array();

            if ($this->id_store) {
                $sales_c = Sales::where('id_store', '=', $this->id_store)->where('customer_id', '=', $sc->customer_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->pluck('id');
                foreach ($sales_c as $sc_i) array_push($sale_ids, $sc_i);
                $customer_name = $customer ? trim(($customer->firstname ? $customer->firstname : '') . ' ' . ($customer->lastname ? $customer->lastname : '')) : 'Unknown Customer';
                $amount_due = Sales::where('id_store', '=', $this->id_store)->where('customer_id', '=', $sc->customer_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->sum('amount');
                $amount_paid = SalesPayments::whereIn('sales_id', $sales_c)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
                $remaining = (float)$amount_due - (float)$amount_paid;
                array_push($debtors, array(
                    'customer_name' => $customer_name,
                    'amount_due' => $amount_due,
                    'amount_paid' => $amount_paid,
                    'remaining' => $remaining
                ));
            } else {
                $sales_c = Sales::where('customer_id', '=', $sc->customer_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->pluck('id');
                foreach ($sales_c as $sc_i) array_push($sale_ids, $sc_i);
                $customer_name = $customer->firstname . ' ' . $customer->lastname;
                $amount_due = Sales::where('customer_id', '=', $sc->customer_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->sum('amount');
                $amount_paid = SalesPayments::whereIn('sales_id', $sales_c)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
                $remaining = (float)$amount_due - (float)$amount_paid;
                array_push($debtors, array(
                    'customer_name' => $customer_name,
                    'amount_due' => $amount_due,
                    'amount_paid' => $amount_paid,
                    'remaining' => $remaining
                ));
            }


        }
        return collect($debtors);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Sale Debtors';
        return $title;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ['Customer Name', 'Amount Due', 'Amount Paid', 'Remaining'];
        return $heading;
    }
}
