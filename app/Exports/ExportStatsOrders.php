<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

use DB;

class ExportStatsOrders implements FromQuery, WithTitle, WithHeadings,ShouldAutoSize
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
            return Sales::query()
                ->select('customer_firstname','customer_lastname','customer_address','customer_city','customer_email','customer_phone',
                'order_reference','status','currency','amount','tax_amount','payment_methode',
                    DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),
                    DB::raw("DATE_FORMAT(date_paied, '%d-%m-%Y') as date_paied"),
                    'store_pickup',
                    'delivery_name','delivery_fee',
                    'comment')
                ->where('created_at','>=',$this->date_start)
                ->where('created_at','<=',$this->date_end);
        }

        return Sales::query()
            ->select('customer_firstname','customer_lastname','customer_address','customer_city','customer_email','customer_phone',
                'order_reference','status','currency','amount','tax_amount','payment_methode',
                DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') as created_at"),
                DB::raw("DATE_FORMAT(date_paied, '%d/%m/%Y') as date_paied"),
                'store_pickup',
                'delivery_name','delivery_fee',
                'comment')
            ->where('created_at','>=',$this->date_start);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sales ' . $this->date_start . ' ' . $this->date_end;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ['First Name','Last Name','Address','City','Email','Phone',
            'Order Reference','Status','Currency','Amount','Tax amount','Payment Method','Date Sale','Date Paid','Store Pickup',
            'Delivery Name','Delivery Fee','Comment'];

        return $heading;
    }

}
