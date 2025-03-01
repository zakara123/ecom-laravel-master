<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\SalesPayments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportStatsSales_Payments_Methods implements FromCollection, WithTitle, WithHeadings,ShouldAutoSize
{
    protected $date_start;
    protected $date_end;
    protected $id_store;
    protected $payment_method_id;

    public function __construct(string $date_s,string $date_e, int $id_store, int $payment_method_id)
    {
        $this->date_start = date('Y-m-d',strtotime($date_s));
        $this->date_end = date('Y-m-d',strtotime($date_e));
        $this->payment_method_id = $payment_method_id;
        $this->id_store = $id_store;
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        $sales = array();
        $sales_per = array();
        if ($this->id_store){

            if ($this->payment_method_id) {
                $sales_per = Sales::where('payment_methode','=', $this->payment_method_id)->where('id_store','=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->get();
                
            } else {
                $sales_per = Sales::where('id_store','=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->get();
            }
            foreach ($sales_per as $sp){
                $invoice_number = date('Ymd', strtotime($sp->created_at)).'-'.$sp->id;
                $customer = Customer::find($sp->customer_id);
                $paymodes = PayementMethodSales::find($sp->payment_methode);
                $customer_name = $customer ? trim(($customer->firstname ? $customer->firstname : '') . ' ' . ($customer->lastname ? $customer->lastname : '')) : 'Unknown Customer';
                $payment_mode = $paymodes->payment_method;
                $amount_paid = SalesPayments::where('sales_id','=',$sp->id)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');

                $amount_due = '0.00';
                if((float)$sp->amount ==  (float)$amount_paid) $amount_due = '0.00';
                elseif((int)$sp->amount) $amount_due = (float)$sp->amount - (float)$amount_paid;

                // $amount_due = $sp->amount;
                array_push($sales, array(
                    'invoice_number' => $invoice_number,
                    'customer_name' => $customer_name,
                    'payment_mode' => $payment_mode,
                    'amount_due' => $amount_due,
                    'amount_paid' => $amount_paid,
                    'remarks' => $sp->comment
                ));
            }
            
        }
        else {
            if ($this->payment_method_id) {
                $sales_per = Sales::where('payment_methode','=', $this->payment_method_id)->whereBetween('created_at', [$this->date_start, $this->date_end])->get();
                
            } else {
                $sales_per = Sales::whereBetween('created_at', [$this->date_start, $this->date_end])->get();
            }

            foreach ($sales_per as $sp){
                $invoice_number = date('Ymd', strtotime($sp->created_at)).'-'.$sp->id;
                $customer = Customer::find($sp->customer_id);
                $paymodes = PayementMethodSales::find($sp->payment_methode);
                $customer_name = $customer->firstname.' '.$sp->lastname;
                $payment_mode = $paymodes->payment_method;
                $amount_paid = SalesPayments::where('sales_id','=',$sp->id)->where('payment_mode','=', $paymodes->id)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
                $amount_due = '0.00';
                if((float)$sp->amount ==  (float)$amount_paid) $amount_due = '0.00';
                elseif((int)$sp->amount) $amount_due = (float)$sp->amount - (float)$amount_paid;
                array_push($sales, array(
                    'invoice_number' => $invoice_number,
                    'customer_name' => $customer_name,
                    'payment_mode' => $payment_mode,
                    'amount_due' => $amount_due,
                    'amount_paid' => $amount_paid,
                    'remarks' => $sp->comment
                ));
            }
            
        }
        return collect($sales);

    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'All Payment Modes';
        if ($this->payment_method_id) {
            $paymodes = PayementMethodSales::find($this->payment_method_id);
            $title = $paymodes->payment_method;
        }

        return $title;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ['Invoice Number','Customer Name','Payment Mode','Amount Due','Amount Paid','Remarks'];

        return $heading;
    }
}
