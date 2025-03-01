<?php

namespace App\Exports;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportProductSku implements FromView,ShouldAutoSize
{
    use Exportable;

    /**
     * @return \Illuminate\Support\ViewErrorBag
     */
    public function view(): View
    {
        $data = [];
        $products_sku = DB::table('product_s_k_u_s')
            ->join('products', 'products.id', '=', 'product_s_k_u_s.products_id')
            ->leftJoin('product_variations', 'product_variations.id', '=', 'product_s_k_u_s.product_variation_id')
            ->whereNotNull('product_s_k_u_s.stock_warehouse')
            ->select('product_s_k_u_s.products_id','product_s_k_u_s.product_variation_id',
            'product_s_k_u_s.sku','product_s_k_u_s.barcode',
            'product_s_k_u_s.group','product_s_k_u_s.type',
            'product_s_k_u_s.material','product_s_k_u_s.colour','product_s_k_u_s.stock_warehouse',
             'products.name as product_name')
            ->distinct('products_id','product_variation_id')
            ->groupBy('product_s_k_u_s.products_id','product_s_k_u_s.product_variation_id',
            'product_s_k_u_s.sku','product_s_k_u_s.barcode',
            'product_s_k_u_s.group','product_s_k_u_s.type',
            'product_s_k_u_s.material','product_s_k_u_s.colour','product_s_k_u_s.stock_warehouse'
            ,'products.name')
            ->orderBy('product_s_k_u_s.products_id', 'ASC')
            ->chunk(100, function ($results) use (&$data) {
                foreach ($results as $ps) {
                    $ps = (array) $ps;

                    $variation_value = json_decode($ps['variation_value']);

                    $ps['variation_value'] = [];
                    if($variation_value!=NULL){
                        foreach ($variation_value as $v) {
                            foreach ($v as $k => $a) {
                                $attr = Attribute::find($k);
                                $attr_val = AttributeValue::find($a);
                                if($attr_val!= NULL && $attr!=NULL) $ps['variation_value'] = array_merge($ps['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
                    }
                    $ps['size'] = (float) ((int)substr($ps['barcode'],8,3)/10);
                    $data[] = (object)$ps;
                }
            }, $shouldQueue = false);


        /*foreach($products_sku as $key=>$ps){
            $ps = (array) $ps;

            $variation_value = json_decode($ps['variation_value']);

            $ps['variation_value'] = [];
            if($variation_value!=NULL){
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        if($attr_val!= NULL && $attr!=NULL) $ps['variation_value'] = array_merge($ps['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                    }
                }
            }

            $ps = (object) $ps;
            $products_sku[$key] = $ps;
        }*/
        return view('stock.export_sku',[ 'product_sku' => $data]);
    }
}
