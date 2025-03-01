<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesPayments;
use App\Models\Store;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class ExportStatsSales_Return_Detail implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
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
        $returns = array();
        $sales_per = array();
        if ($this->id_store) {
            $sales_per = Sales::where('id_store', '=', $this->id_store)->whereBetween('created_at', [$this->date_start, $this->date_end])->get();
        } else {
            $sales_per = Sales::whereBetween('created_at', [$this->date_start, $this->date_end])->get();
        }


        foreach ($sales_per as $sp) {
            $invoice_number = date('Ymd', strtotime($sp->created_at)) . '-' . $sp->id;
            $sale_date = date('d/m/Y', strtotime($sp->created_at));
            $customer = Customer::find($sp->customer_id);
            $customer_name = $customer ? trim(($customer->firstname ? $customer->firstname : '') . ' ' . ($customer->lastname ? $customer->lastname : '')) : 'Unknown Customer';

            $customer_brn_no = $customer && $customer->brn_customer ? $customer->brn_customer : " ";
            $customer_vat_no = $customer && $customer->vat_customer ? $customer->vat_customer : " ";


            $total = $sp->amount;
            $discount = Sales_products::where('sales_id', '=', $sp->id)->sum('discount');
            $vat_exempt = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', 'VAT Exempt')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_0 = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', '0% VAT')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_15 = Sales_products::where('sales_id', '=', $sp->id)->where('tax_sale', '=', '15% VAT')->select(DB::raw('sum(order_price * quantity) as total'))->first()->total;
            $vat_amount = $sp->tax_amount;
            $amount_exclude_vat = $sp->amount - ($vat_0 + $vat_15 + $vat_amount);
            array_push($returns, array(
                'sale_date' => $sale_date,
                'invoice_number' => $invoice_number,
                'customer_name' => $customer_name,
                'customer_brn_no' => $customer_brn_no,
                'customer_vat_no' => $customer_vat_no,
                'total' => $total,
                'discount' => $discount,
                'vat_exempt' => $vat_exempt,
                'vatable_0' => $vat_0,
                'vatable_15' => $vat_15,
                'vat_amount' => $vat_amount,
                'amount_exclude_vat' => $amount_exclude_vat,
                'subtotal' => $sp->subtotal
            ));
        }
        return collect($returns);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $title = "Export Return";
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
            'Order Date',
            'Invoice Number',
            'Customer Name',
            'Customer BRN No',
            'Customer VAT No',
            'Total',
            'Discount',
            'Vat Exempt',
            'Vatable 0%',
            'Vatable 15%',
            'VAT Amount',
            'Amount Exclude VAT',
            'Subtotal'
        ];
        return $heading;
    }
}
