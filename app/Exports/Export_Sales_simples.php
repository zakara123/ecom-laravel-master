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
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Export_Sales_simples implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{

    use Exportable;


    public function __construct(){}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $sales = array();
        $sales_per = Sales::orderBy('created_at', 'DESC')->get();
        foreach ($sales_per as $sp) {
            $sale_date = date('d/m/Y', strtotime($sp->created_at));
            $sale_time = date('H:i', strtotime($sp->created_at));
            $customer_name = $sp->customer_firstname . ' ' . $sp->customer_lastname;
            $total = $sp->amount;

            array_push($sales, array(
                'sale_id' => $sp->id,
                'sales_ref' => $sp->order_reference,
                'sale_date' => $sale_date,
                'sale_time' => $sale_time,
                'customer_name' => $customer_name,
                'customer_address' => $sp->customer_address,
                'customer_email' => $sp->customer_email,
                'customer_phone' => $sp->customer_phone,
                'amount' => $total,
                'status' => $sp->status,
            ));


        }
        return collect($sales);
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
            'Sale ID', 'Sales Ref', 'Sale Date', 'Sale Time',  'Customer Name', 'Customer Address', 'Customer Email', 'Customer Phone', 'Amount', 'Status',
        ];

        return $heading;
    }


}
