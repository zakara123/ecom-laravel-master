<?php

namespace App\Exports;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Customer;
use App\Models\Products;
use App\Models\ProductVariation;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CustomerItems implements FromCollection, WithHeadings,ShouldAutoSize, WithColumnFormatting
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

        $export_item = array();
        $sales_i = array();
        $sales = Sales::where('customer_id','=',$this->customer_id)->orderBy('id', 'desc')->pluck('id');
        $customer = Customer::find($this->customer_id);
        $customer_name = "";


        if($customer){
            if($customer->firstname || $customer->lastname) $customer_name = $customer->firstname . ' ' . $customer->lastname;
            else $customer_name = $customer->name;
        }
        if (count($sales)) {
            foreach($sales as $s) array_push($sales_i,$s);
            $products_id = Sales_products::whereIn('sales_id',$sales_i)->get();
            if (count($products_id)) {
                foreach($products_id as $product_s){
                    $sales_info = Sales::find($product_s->sales_id);
                    $product = Products::find($product_s->product_id);

                        $stock_product = DB::table('stocks')
                            ->where('products_id', $product->id)
                            ->where('product_variation_id', $product_s->product_variations_id)->orderBy('id', 'desc')->first();
                        $quantity_stock_product = '';
                        $barcode_product = '';
                        if (isset($stock_product->quantity_stock) && isset($stock_product->barcode_value)) {
                            $quantity_stock_product = $stock_product->quantity_stock;
                            $barcode_product = $stock_product->barcode_value;
                        }

                        $categoryproduct = Category_product::where('id_product', $product['id'])->get();
                        foreach ($categoryproduct as &$cp) {
                            $category = Category::find($cp->id_category);
                            $cp['category_name'] = $category->category;
                        }
                        $product['categoryproduct'] = $categoryproduct;
                        $category_ = '';
                        $supplier = '';

                        if (count($product->categoryproduct) > 0) {
                            $loop = 0;
                            foreach ($product->categoryproduct as $category) {
                                if ($loop < (count($product->categoryproduct) - 1))
                                    $category_ .= $category->category_name . ';';
                                else
                                    $category_ .= $category->category_name;

                                $loop++;
                            }
                        } else  $category_ = 'Uncategorized';

                        if ($product->id_supplier) {
                            $supplier_product = Supplier::find($product->id_supplier);
                            $supplier = $supplier_product->name;
                        }

                        $store = '';
                        $store_p = Stock::where('products_id', $product->id)
                            ->orderBy('id', 'desc')->first();

                        if ((bool)$store_p) {
                            if (isset($store_p->store_id) && is_null($store_p->store_id)){
                                $store_product = Store::find($stock->store_id);
                                $store = $store_product->name;
                            }
                        }

                        $stock_t = DB::table('stocks')
                        ->where('products_id', $product->id)
                        ->orderBy('id', 'desc')->first();
                        $sku_ss = '';
                        if($stock_t) $sku_ss = $stock_t->sku;
                        $product_variation = ProductVariation::where('products_id', $product->id)->where('id', $product_s->product_variations_id)->get();
                        if(count($product_variation)){
                            foreach ($product_variation as $key1 => $variation) {
                                $variation = (array)$variation;
                                $variation_value = $variation->variation_value;
                                $variation['variation_value'] = [];
                                if ($variation_value != NULL) {
                                    foreach ($variation_value as $v) {
                                        foreach ($v as $k => $a) {
                                            $attr = Attribute::find($k);
                                            $attr_val = AttributeValue::find($a);
                                            if (!empty($attr_val->attribute_values) && !empty($attr->attribute_name))
                                                $variation['variation_value'] = array_merge($variation['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                                        }
                                    }
                                }
                                $variation = (object)$variation;
                                $product_variation[$key1] = $variation;
                            }


                            foreach ($product_variation as $key1 => $variation) {
                                $i = 1;
                                $attribute = array();
                                $stock = DB::table('stocks')
                                    ->where('products_id', $product->id)
                                    ->where('product_variation_id', $variation->id)->orderBy('id', 'desc')->first();



                                if($stock) $sku_ss = $stock->sku;

                                array_push($attribute, $sales_info->id);
                                array_push($attribute, $sales_info->order_reference);
                                array_push($attribute, $customer_name);
                                array_push($attribute, date('d/m/Y',strtotime($sales_info->created_at)));
                                array_push($attribute, $product->id);
                                array_push($attribute, $product->name);
                                array_push($attribute, $variation->price);
                                array_push($attribute, $variation->price_buying);
                                array_push($attribute, $product->unit_selling_label);
                                array_push($attribute, $product_s->quantity);
                                array_push($attribute, $product_s->quantity * $variation->price );
                                array_push($attribute, $sales_info->amount);
                                array_push($attribute, $product->vat);
                                array_push($attribute, $product->description);
                                array_push($attribute, $sku_ss);
                                $quantity_stock = '';
                                $barcode_value = '';

                                if (isset($stock->quantity_stock) && isset($stock->barcode_value)) {
                                    $quantity_stock = $stock->quantity_stock;
                                    $barcode_value = $stock->barcode_value;
                                }
                                array_push($attribute, $barcode_value);
                                array_push($attribute, '');
                                array_push($attribute, $supplier);
                                array_push($attribute, $store);
                                foreach ($variation->variation_value as $key => $var) {
                                    array_push($attribute, $var['attribute']);
                                    array_push($attribute, $var['attribute_value']);
                                }
                                array_push($export_item, $attribute);
                            }

                        } else {
                            array_push($export_item, array(
                                $sales_info->id,
                                $sales_info->order_reference,
                                $customer_name,
                                date('d/m/Y',strtotime($sales_info->created_at)),
                                $product->id,
                                $product->name,
                                $product->price,
                                $product->price_buying,
                                $product->unit_selling_label,
                                $product_s->quantity,
                                $product_s->quantity * $product->price ,
                                $sales_info->amount,
                                $product->vat,
                                $product->description,
                                $sku_ss,
                                $barcode_product,
                                $category_,
                                $supplier,
                                $store

                            ));
                        }

                }
            }
        }
        return collect($export_item);
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        $heading = ["Sales ID", "Sale Ref", "Customer Name", "Sale Date",
        "ID", "Name", "Selling price", "Buying price", "Unit",
        "Quantity","Line Amount","Order Amount",
         "VAT", "Description", "SKU", "Barcode",
         "Category", "Supplier", "Store"];
        $deep = sizeof(Attribute::all());
        for ($i = 1; $i <= $deep; $i++) {
            array_push($heading, trim("Attribute name " . $i));
            array_push($heading, trim("Attribute value " . $i));
        }
        return $heading;
    }
}
