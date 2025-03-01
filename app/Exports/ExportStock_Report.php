<?php

namespace App\Exports;

use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ExportStock_Report implements FromView,ShouldAutoSize
{
    use Exportable;

    /**
    * @return \Illuminate\Support\ViewErrorBag
    */
    public function view(): View
    {
        $stocks = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->leftJoin('product_variations', 'product_variations.id', '=', 'stocks.product_variation_id')
            ->select('stocks.*', 'products.name as product_name','products.price', 'stores.name')
            ->orderBy('id', 'DESC')->get();

        $generator = new BarcodeGeneratorPNG();
        foreach($stocks as $key=>$stock){
            $stock = (array) $stock;

            $stock['price_buying'] = 0;
            $stock['price_selling'] = 0;

            $stock_product_price = Products::where('id','=',$stock['products_id'])->orderBy('id','DESC')->first();
            if ($stock_product_price){
                $stock['price_buying'] = $stock_product_price->price_buying;
                $stock['price_selling'] = $stock_product_price->price;
            }

            if($stock['product_variation_id']){
                $stock_product_price_variation = ProductVariation::where('id','=',$stock['product_variation_id'])->where('products_id','=',$stock['products_id'])->orderBy('id','DESC')->first();
                if ($stock_product_price_variation){
                    $stock['price_buying'] = $stock_product_price->price_buying;
                    $stock['price_selling'] = $stock_product_price->price;
                }
            }

            $store = 'Default Store';
            if ((int)$stock['store_id']) {
                $store_s = Store::find((int)$stock['store_id']);
                $store = $store_s->name;
            }

            $stock['store'] = $store;

            $barcode_value = $stock['barcode_value'];
            if (empty($barcode_value)) $barcode_value = $stock['id'];
            $path = public_path('/files/export_stock/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost())));

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $base64_image = 'data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128));
            $file = base64_decode(preg_replace(
                '#^data:([^;]+);base64,#',
                '',
                $base64_image
            ));
            $fileName = $barcode_value;
            $extension = '.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
            $filePath = $path . '/' . $fileName . '' . $extension;
            File::put($filePath, $file);
            $stock['barcode_image'] = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128)) . '">' . $barcode_value;
            $stock['barcode_image_other'] = $filePath;
            $stock['barcode_image_value'] = $barcode_value;

            

            $stockHistory = DB::table('stock_history')->where('stock_id',$stock['id'])->orderBy('id','DESC')->first();
            if($stockHistory){
                $stock['type'] = $stockHistory->type_history;
                $stock['stock_description']= $stockHistory->stock_description;
                $stock['quantity_previous'] = $stockHistory->quantity_previous;
                $stock['quantity'] = $stockHistory->quantity;;
            }else{
                $stock['type'] = '';
                $stock['stock_description']= '';
                $stock['quantity_previous'] = '';
                $stock['quantity'] = '';
            }

            $stock = (object) $stock;
            $stocks[$key] = $stock;

        }
        return view('stock.export_stock',[ 'stocks' => $stocks]);
    }
}
