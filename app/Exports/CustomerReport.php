<?php

namespace App\Exports;

use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\SalesPayments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerReport implements FromCollection, WithHeadings
{
    protected $customer_id;

    public function __construct(int $id_customer)
    {
        $this->customer_id = $id_customer;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
//        ($this->customer_id)
        /*$table_pdf = "order_payment.id as payment_id,order_payment.payment_date,order_payment.payment_mode,order_payment.payment_reference,order_payment.amount as payment_amount,";
        $vatable_sql = "
            (SELECT SUM(order_products.quantity*order_products.order_price) FROM order_products WHERE order_products.order_id = orders.id) as order_subtotal,
            (SELECT SUM(order_products.quantity*order_products.order_price) FROM order_products WHERE order_products.order_id = orders.id AND order_products.vat_order = '15% VAT') as order_amount_vat,
            (SELECT SUM(order_products.quantity*order_products.order_price) FROM order_products WHERE order_products.order_id = orders.id AND order_products.vat_order = 'VAT Exempt') as order_amount_non_vat_exempt,
            (SELECT SUM(order_products.quantity*order_products.order_price) FROM order_products WHERE order_products.order_id = orders.id AND order_products.vat_order = 'Zero Rated') as order_amount_non_vat_zero,
            (SELECT SUM(order_products.quantity*(order_products.order_price / (1 - (1 / order_products.discount )))) - SUM(order_products.quantity*order_products.order_price) FROM order_products WHERE order_products.order_id =  orders.id AND discount > 0) as final_discount_price,";

        $sql = "SELECT orders.*, $table_pdf $vatable_sql payment_methods.payment_method as txt_payment_method, users.name as order_user_name FROM orders
            LEFT JOIN payment_methods ON orders.payment_methode = payment_methods.slug
            LEFT JOIN order_payment ON orders.id = order_payment.order_id
            LEFT JOIN users ON users.id = orders.user_id
            WHERE orders.customer_id = ?";*/

        $orders = Sales::where('customer_id','=',$this->customer_id)->get();

        foreach ($orders as &$sale){
            $method = PayementMethodSales::find($sale->payment_methode);
            $sale->payment_method = $method->payment_method;

            $orders_paid = SalesPayments::
            select('id as payment_id','sales_id', 'payment_date AS order_date', 'payment_mode', 'payment_reference', 'amount')
                ->where('sales_id', '=' ,$sale->id)->get();

            if (count($orders_paid))
                foreach ($orders_paid as $op) {
                    $method_ = PayementMethodSales::find($op->payment_mode);
                    $op->payment_method = $method_->payment_method;
                    $orders->push($op);
                }
        }

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ["Sales ID", "Invoice Number", "Order Date", "Order Time",
            "Delivery / Pickup Date", "Total", "Discount",
            "Vat Exempt","Vatable 0%","Vatable 15%","VAT Amount"
            ,"Amount Exclude","VAT","Subtotal","Status","Status"
            ,"Customer Name","Customer Address","Customer Email","Customer Phone",
            "Payment Mode","Payment ID","Payment Date","Payment Method",
            "Payment Reference","Payment Amount","Store","Possessed by"
            ];


        return $heading;
    }
}
