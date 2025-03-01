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

class ExportStatsSales_Debtor_Payments implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
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
        $sales_payments = array();
        $sales_pay = SalesPayments::whereBetween('payment_date', [$this->date_start, $this->date_end])->get();
        foreach ($sales_pay as $sp) {
            $sale = array();
            if ($this->id_store) {
                $sale = Sales::where('id', '=', $sp->sales_id)->where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->first();
            } else {
                $sale = Sales::where('id', '=', $sp->sales_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->first();
            }

            $sales_date = date('d/m/Y', strtotime($sale->created_at));
            $invoice_number = date('Ymd', strtotime($sale->created_at)) . '-' . $sale->id;
            $customer = Customer::find($sale->customer_id);
            $customer_name = $customer->firstname . ' ' . $customer->lastname;
            $payment_date = date('d/m/Y', strtotime($sp->payment_date));
            $amount = $sp->amount;
            array_push($sales_payments, array(
                'sales_date' => $sales_date,
                'invoice_number' => $invoice_number,
                'customer_name' => $customer_name,
                'payment_date' => $payment_date,
                'amount' => $amount,
            ));
        }
        return collect($sales_payments);

    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Payments';
        return $title;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ['Sale Date', 'Invoice Number', 'Customer Name', 'Payment Date', 'Amount'];

        return $heading;
    }
}
