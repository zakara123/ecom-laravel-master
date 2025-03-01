<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesPayments;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportStatsSales_Detailed implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $sales__qqq = array();
        $sales_per = array();
        if ($this->id_store) {
            $sales_per = Sales::where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        } else {
            $sales_per = Sales::whereBetween('created_at', [$this->date_start, $this->date_end])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        }

        foreach ($sales_per as $sp) {
            $invoice_number = date('Ymd', strtotime($sp->created_at)) . '-' . $sp->id;
            $sale_date = date('d/m/Y', strtotime($sp->created_at));

            $date_pickup = '';
            if ($sp->date_pickup) $date_pickup = date('d/m/Y', strtotime($sp->date_pickup));

            $sale_time = date('H:i', strtotime($sp->created_at));
            $customer = Customer::find($sp->customer_id);
            $paymodes = PayementMethodSales::find($sp->payment_methode);
            $customer_name = $customer ? trim(($customer->firstname ? $customer->firstname : '') . ' ' . ($customer->lastname ? $customer->lastname : '')) : 'Unknown Customer';
            $payment_mode = $paymodes->payment_method;
            $total = $sp->amount;
            $amount_payment = SalesPayments::where('sales_id', '=', $sp->id)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
            $discount = Sales_products::where('sales_id', '=', $sp->id)->sum('discount');
            $vat_exempt = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', 'VAT Exempt')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_0 = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', '0% VAT')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_15 = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', '15% VAT')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_amount = $sp->tax_amount;
            $amount_exclude_vat = $sp->amount - ($vat_0 + $vat_15 + $vat_amount);
            $payments = SalesPayments::where('sales_id', '=', $sp->id)->orderBy('payment_date', 'DESC')->orderBy('id', 'DESC')->get();

            $payment_date = $payment_mehodes = $payment_id = $payment_reference = '';
            $store = Store::find($sp->id_store);
            $user = User::find($sp->user_id);
            $user_name = '';
            $store_name = '';
            if(isset($store->name) && !is_null($store->name) && !empty($store->name))  $store_name = $store->name;
            if ($user) $user_name = $user->name;

            $sales = Sales::find($sp->id);
            $amount_due = $sales->amount;
            

            if (count($payments) > 0) {
                foreach($payments as $payment) {
                    $payment_date = date('d/m/Y', strtotime($payment->payment_date));
                    $paymentmehodes = PayementMethodSales::find($payment->payment_mode);
                    $payment_mehodes = $paymentmehodes->payment_method;
                    $payment_reference = $payment->payment_reference;
                    $payment_id = $payment->id;
                    $amount_payment = SalesPayments::where('id', '=', $payment->id)->whereBetween('payment_date', [$this->date_start, $this->date_end])->sum('amount');
                   
                    $amount_due -= $amount_payment; 
                    $amount_due_l = floatval($amount_due);
                    if(empty(trim($amount_due))) $amount_due_l = '0.00';
                    if(empty(trim($amount_payment))) $amount_payment = '0.00';
                
                    array_push($sales__qqq, array(
                        'sale_id' => $sp->id,
                        'sale_ref' => $sp->order_reference,
                        'invoice_number' => $invoice_number,
                        'sale_date' => $sale_date,
                        'sale_time' => $sale_time,
                        'pickup_date' => $date_pickup,
                        'total' => $total,
                        'discount' => $discount,
                        'vat_exempt' => $vat_exempt,
                        'vatable_0' => $vat_0,
                        'vatable_15' => $vat_15,
                        'vat_amount' => $vat_amount,
                        'amount_exclude_vat' => $amount_exclude_vat,
                        'subtotal' => $sp->subtotal,
                        'status' => $sp->status,
                        'payment_id' => $payment_id,
                        'payment_date' => $payment_date,
                        'payment_mode' => $payment_mehodes,
                        'payment_reference' => $payment_reference,
                        'amount_paid' => $amount_payment,
                        'amount_due' => $amount_due_l,
                        'customer_name' => $customer_name,
                        'customer_address' => $sp->customer_address,
                        'customer_email' => $sp->customer_email,
                        'customer_phone' => $sp->customer_phone,
                        'store' => $store_name,
                        'processed_by' => $user_name
                    ));
                }
                
            } else {
                
                $amount_due -= $amount_payment; 
                $amount_due_l = floatval($amount_due);
                if(empty(trim($amount_due))) $amount_due_l = '0.00';
                if(empty(trim($amount_payment))) $amount_payment = '0.00';
                array_push($sales__qqq, array(
                    'sale_id' => $sp->id,
                    'sale_ref' => $sp->order_reference,
                    'invoice_number' => $invoice_number,
                    'sale_date' => $sale_date,
                    'sale_time' => $sale_time,
                    'pickup_date' => $date_pickup,
                    'total' => $total,
                    'discount' => $discount,
                    'vat_exempt' => $vat_exempt,
                    'vatable_0' => $vat_0,
                    'vatable_15' => $vat_15,
                    'vat_amount' => $vat_amount,
                    'amount_exclude_vat' => $amount_exclude_vat,
                    'subtotal' => $sp->subtotal,
                    'status' => $sp->status,
                    'payment_id' => $payment_id,
                    'payment_date' => $payment_date,
                    'payment_mode' => $payment_mehodes,
                    'payment_reference' => $payment_reference,
                    'amount_paid' => $amount_payment,
                    'amount_due' => $amount_due_l,
                    'customer_name' => $customer_name,
                    'customer_address' => $sp->customer_address,
                    'customer_email' => $sp->customer_email,
                    'customer_phone' => $sp->customer_phone,
                    'store' => $store_name,
                    'processed_by' => $user_name
                ));
            
            }
        }
    
        return collect($sales__qqq);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Detailed sales';
        return $title;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = [
            'Sale ID', 'Sale Ref',  'Invoice Number', 'Sale Date', 'Sale Time', 'Delivery / Pickup Date', 'Total',
            'Discount', 'Vat Exempt', 'Vatable 0%', 'Vatable 15%', 'VAT Amount', 'Amount Exclude VAT',
            'Subtotal', 'Status',
            'Payment ID', 'Payment Date',  'Payment Method','Payment Reference', 'Amount Paid','Amount Due', 
            'Customer Name', 'Customer Address', 'Customer Email', 'Customer Phone',
            'Store', 'Processed by'
        ];

        return $heading;
    }


}
