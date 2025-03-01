<?php

namespace App\Http\Controllers;

use App\Exports\ExportProductSku;
use App\Exports\ExportStock_Report;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\OnlineStockApi;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\ProductSettings;
use App\Models\ProductSKU;
use App\Models\ProductVariationAttribute;
use App\Models\ProductVariationImages;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Picqer\Barcode\BarcodeGeneratorPNG;

//use Picqer\Barcode\BarcodeGeneratorHTML;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_product)
    {

        
        // Fetch product
        $product = Products::findOrFail($id_product);
        $stocks = Stock::where('products_id',$id_product)->orderBy('id', 'DESC')->paginate(10);

        $generator = new BarcodeGeneratorPNG();
        foreach($stocks as $key => &$stock){
            $stock->readable_product_variations = null;
            if ($stock->product_variation_id) {
                $variationAattributes = ProductVariationAttribute::where('product_variation_id', $stock->product_variation_id)
                    ->with('attribute', 'attributeValue')
                    ->get()
                    ->map(function ($attr) {
                        return [
                            'attribute_id' => $attr->attribute_id,
                            'attribute_value_id' => $attr->attribute_value_id,
                            'attribute' => $attr->attribute->attribute_name,
                            'attribute_value' => $attr->attributeValue->attribute_values
                        ];
                    });

                // Generate readable_product_variations
                $readable_product_variations = [];
                foreach ($variationAattributes as $attribute) {
                    $readable_product_variations[] = "{$attribute['attribute']}: {$attribute['attribute_value']}";
                }
                if(!empty($readable_product_variations)){
                    $stock->readable_product_variations = implode(' | ', $readable_product_variations);
                }else{
                    $stock->readable_product_variations = "( No Variation )";
                }
            }

            $variation_value = json_decode($stock->variation_value);
            $product = Products::find($stock->products_id);
            $store = Store::find($stock->store_id);
            $stock->variation_value = [];
            if($variation_value!=NULL){
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        if($attr_val!= NULL && $attr!=NULL) $stock->variation_value = array_merge($stock->variation_value, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                    }
                }
            }

            $supplier = '';
            if ($product->id_supplier) {
                $suppliers = Supplier::find($product->id_supplier);
                $supplier = $suppliers->name;
            }

            $barcode_value = $stock->barcode_value;
            if (empty($barcode_value)) $barcode_value = $stock->id;
            $stock->barcode_image = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128)) . '">' . $barcode_value;
            $stock->product_name = $product->name;
            $stock->price = $product->price;
            $stock->name = $store->name;
            $stock->supplier = $supplier;
            /*$stock = (object) $stock;
            $stocks[$key] = $stock;*/
        }

        // Fetch variations
        $variations = ProductService::getProductVariationsByProductId($id_product);

        // Fetch stores
        $stores = Store::all();

        // Return view with compacted variables
        return view('stock.index', compact('product', 'stocks', 'stores', 'variations'));
    }

    public function stock_sheet(Request $request)
    {

        $ss = '';
        $process_imp = 0;
        if ($request->s) $ss = $request->s;
        if ($request->process_import) $process_imp = $request->process_import;
        $products_id =array();
        $products = Products::get();
        if($ss) $products = Products::where('products.name', 'LIKE', '%' . $ss . '%')->get();

        foreach ($products as $p) array_push($products_id, $p->id);

        $stocks = Stock::whereIn('products_id',$products_id)->orderBy('id', 'DESC')->paginate(10);
        $generator = new BarcodeGeneratorPNG();
        // foreach($stocks as $key => &$stock){
        //     $stock->readable_product_variations = null;
        //     if ($stock->product_variation_id) {
        //         $variationAattributes = ProductVariationAttribute::where('product_variation_id', $stock->product_variation_id)
        //             ->with('attribute', 'attributeValue')
        //             ->get()
        //             ->map(function ($attr) {
        //                 return [
        //                     'attribute_id' => $attr->attribute_id,
        //                     'attribute_value_id' => $attr->attribute_value_id,
        //                     'attribute' => $attr->attribute->attribute_name,
        //                     'attribute_value' => $attr->attributeValue->attribute_values
        //                 ];
        //             });

                    

        //         // Generate readable_product_variations
        //         $readable_product_variations = [];
        //         foreach ($variationAattributes as $attribute) {
        //             $readable_product_variations[] = "{$attribute['attribute']}: {$attribute['attribute_value']}";
        //         }
        //         $stock->readable_product_variations = implode(' | ', $readable_product_variations);
        //     }

        //     $variation_value = json_decode($stock->variation_value);
        //     $product = Products::find($stock->products_id);
        //     $store = Store::find($stock->store_id);
        //     $stock->variation_value = [];
        //     if($variation_value!=NULL){
        //         foreach ($variation_value as $v) {
        //             foreach ($v as $k => $a) {
        //                 $attr = Attribute::find($k);
        //                 $attr_val = AttributeValue::find($a);
        //                 if($attr_val!= NULL && $attr!=NULL) $stock->variation_value = array_merge($stock->variation_value, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
        //             }
        //         }
        //     }

        //     $supplier = '';
        //     if ($product->id_supplier) {
        //         $suppliers = Supplier::find($product->id_supplier);
        //         $supplier = $suppliers->name;
        //     }

        //     $barcode_value = $stock->barcode_value;
        //     if (empty($barcode_value)) $barcode_value = $stock->id;
        //     $stock->barcode_image = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128)) . '">' . $barcode_value;
        //     $stock->product_name = $product->name;
        //     $stock->price = $product->price;
        //     $stock->name = $store->name;
        //     $stock->store_name = $store->name;
        //     $stock->supplier = $supplier;
        //     /*$stock = (object) $stock;
        //     $stocks[$key] = $stock;*/
        // }


        foreach ($stocks as $key => &$stock) {
            $stock->readable_product_variations = null;
        
            // Get the product
            $product = Products::find($stock->products_id);
            $store = Store::find($stock->store_id);
        
            // Fetch the variations
            if ($product) {
                $variations = $product->variations;
                foreach ($variations as $variation) {
                    // Get human-readable variation attributes
                    $humanReadableAttributes = $variation->getHumanReadableVariationValueAttribute();
                    $readable_product_variations = [];
        
                    // Concatenate variations into a readable format
                    foreach ($humanReadableAttributes as $attribute => $value) {
                        $readable_product_variations[] = "{$attribute}: {$value}";
                    }
        
                    // Set readable_product_variations to the stock object
                    $stock->readable_product_variations = implode(' | ', $readable_product_variations);
                }
            }
        
            // Now, set other fields like product name, store name, supplier, and barcode
            if ($product) {
                $stock->product_name = $product->name;
                $stock->price = $product->price;
            }
        
            if ($store) {
                $stock->store_name = $store->name;
            }
        
            // Handling the supplier
            $supplier = '';
            if ($product->id_supplier) {
                $supplier = Supplier::find($product->id_supplier)->name ?? '';
            }
            $stock->supplier = $supplier;
        
            // Handle barcode image generation
            $barcode_value = $stock->barcode_value ?: $stock->id;
            $stock->barcode_image = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128)) . '">' . $barcode_value;
        }
        

        
        
        

        $stock_sheet_count =  Stock::orderBy('id','DESC')->count();
        $product_sku_count =  ProductSKU::orderBy('id','ASC')->count();

        $imported = 0;
        if($stock_sheet_count && ($stock_sheet_count > $product_sku_count)){
            $imported_cal = ($product_sku_count/$stock_sheet_count) * 100;
            $imported = (int)ceil($imported_cal);
        } elseif($stock_sheet_count <= $product_sku_count) {
            $imported = 100;
        }

        $stores = Store::get();

        // dd()
        
        // $pattIds = ProductAttribute::where('product_id',$stock->products_id)->pluck('attribute_id');
        // $patt = Attribute::whereIn('id',$pattIds)->get();
        //    dd($stocks);
        return view('stock.sheet', compact(['products', 'stocks', 'imported','process_imp',  'ss', 'stores']));
    }

    public function search(Request $request)
    {
        
        $ss = '';
        if ($request->s) $ss = $request->s;
        $products = Products::get();
        //$stocks = Stock::get();
        $stocks = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.products_id')
        ->join('stores', 'stores.id', '=', 'stocks.store_id')
        ->leftJoin('product_variations', 'product_variations.id', '=', 'stocks.product_variation_id')
        ->select('stocks.*', 'products.name as product_name','products.price', 'stores.name', 'product_variations.variation_value_delete')
        // ->get();
        ->orWhere('products.name', 'LIKE', '%' . $ss . '%')
        // ->orWhere('stores.name', 'LIKE', '%' . $ss . '%')
        ->orderBy('id', 'DESC')->paginate(10);

        $generator = new BarcodeGeneratorPNG();
        foreach($stocks as $key=>$stock){
            $stock = (array) $stock;
            $variation_value = json_decode($stock['variation_value_delete']);

            $stock['variation_value_delete'] = [];
            if($variation_value!=NULL){
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        if($attr_val!= NULL && $attr!=NULL) $stock['variation_value_delete'] = array_merge($stock['variation_value_delete'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                    }
                }
            }

            $barcode_value = $stock['barcode_value'];
            if (empty($barcode_value)) $barcode_value = $stock['id_stock'];
            $stock['barcode_image'] = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode_value, $generator::TYPE_CODE_128)) . '">' . $barcode_value;

            $stock = (object) $stock;
            $stocks[$key] = $stock;
        }


        $variations = DB::table('product_variations')->get();
        //var_dump($variations);die;
        foreach($variations as $key1=>$variation){
            $variation = (array) $variation;
            $variation_value = json_decode($variation['variation_value_delete']);

            $variation['variation_value_delete'] = [];
            if($variation_value!=NULL){
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        if($attr_val!= NULL && $attr!=NULL) $variation['variation_value_delete'] = array_merge($variation['variation_value_delete'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                    }
                }
            }

            $variation = (object) $variation;
            $variations[$key1] = $variation;
        }
        $stores = Store::get();
        return view('stock.search_ajax', compact(['products', 'stocks',  'ss', 'stores', 'variations']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Products::get();

        $stores = Store::get();

        return view('stock.add', compact(['products', 'stores']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_product_variations($product_id){
        $product = Products::find($product_id);
        if($product == NULL){
            header('Content-Type: application/json');
            echo json_encode([
                'product'=>[],
                'variations'=>[],
                'msg'=>'Product Not found',
                'error'=>true
            ]);die;
        }

        $product_variations = DB::table('product_variations')
            ->select(
                'product_variations.*'
            )
            ->leftJoin('stocks', 'stocks.product_variation_id', '=', 'product_variations.id')
            ->where('product_variations.products_id', $product_id)
            ->groupBy('product_variations.id')
            ->get()
            ->map(function ($variation) {
                ProductService::processVariation($variation);
                return $variation;
            });

        header('Content-Type: application/json');
        echo json_encode([
            'product'=> $product,
            'variations'=>$product_variations,
            'product_variations'=>$product_variations,
            'msg'=>'Success',
            'error'=>true
        ]);die;
    }

    public function add_stock_sheet(Request $request){


        

        $this->validate($request, [
            'product' => 'required',
            'quantity_stock'=> 'required|gt:0'
        ]);
        $variation = $request->variation;
        $existing_stock = null;
        if(!$request->has('variation') || $variation == ""){
            $variation = NULL;
            $existing_stock = Stock::where('products_id',$request->product)
            ->where('store_id',  $request->store)
            ->whereNull('product_variation_id')
            ->first();
        }
        else{
            $existing_stock = Stock::where('products_id',$request->product)
            ->where('store_id',  $request->store)
            ->where('product_variation_id',  $request->variation)
            ->first();
        }

        $date_received = self::transform_date($request->date_received);

        if(empty($variation)) $variation = NULL; /// (No Variation)

        $barcode_value = $request->product . $variation . "";
        if($request->has('barcode_value') && !empty($request->barcode_value)){
            $barcode_value = $request->barcode_value;
        }

        /* stock exists */
        if($existing_stock === NULL){
            $stock = Stock::updateOrCreate([
                'products_id' => $request->product,
                'store_id'  => $request->store,
                'product_variation_id'  => $variation,
                'quantity_stock'  => $request->quantity_stock,
                'date_received'  => $date_received,
                'sku'  => $request->sku,
                'barcode_value'  => $barcode_value
            ]);

            if($stock->id){
                //// add stock history
                $stock_history = Stock_history::updateOrCreate([
                    'stock_id' => $stock->id,
                    'type_history'  => "Update Stock",
                    'quantity'  => $request->quantity_stock,
                    'quantity_previous'  => 0,
                    'quantity_current'  => $request->quantity_stock,
                    'sales_id'  => NULL
                ]);
            }
        }
        else{
            $quantity_old = floatval($existing_stock->quantity_stock);
            $update_stock = $existing_stock->update([
                'quantity_stock' => floatval($existing_stock->quantity_stock) + floatval($request->quantity_stock)
            ]);
            $last_history = Stock_history::where('stock_id', $existing_stock->id)
                     ->get()
                     ->last();

            $quantity_previous = 0;
            $quantity_current = floatval($request->quantity_stock);

            if($last_history != NULL){
                $quantity_previous =  $last_history->quantity_current;
                $quantity_current = $quantity_previous + $quantity_current;
            }
            else{
                $quantity_previous = $quantity_old;
                $quantity_current = floatval($quantity_old) + floatval($request->quantity_stock);
            }

            /// add to stock history
            $add_history = Stock_history::updateOrCreate([
                'stock_id' => $existing_stock->id,
                'type_history'  => "Update Stock",
                'quantity'  => $request->quantity_stock,
                'quantity_previous'  => $quantity_previous,
                'quantity_current'  => $quantity_current
            ]);
        }

        return redirect()->back()->with('success','Stock created successfully');
    }



    public function store(Request $request)
    {

        // dd($request);

        $this->validate($request, [
            'store' => 'required',
            'quantity_stock'=> 'required|gt:0'
        ]);

        $variation = $request->variation;
        $existing_stock = null;
        if($variation == ""){
            $variation = NULL;
            $existing_stock = Stock::where('products_id',$request->products_id)
            ->where('store_id',  $request->store)
            ->whereNull('product_variation_id')
            ->first();
        }
        else{
            $existing_stock = Stock::where('products_id',$request->products_id)
            ->where('store_id',  $request->store)
            ->where('product_variation_id',  $request->variation)
            ->first();
        }

        /* stock exists */
        if($existing_stock === NULL){
            $date_received = self::transform_date($request->date_received);

            if(empty($variation)) $variation = NULL;

            $barcode_value = $request->product . $variation . "";
            if($request->has('barcode_value') && !empty($request->barcode_value)){
                $barcode_value = $request->barcode_value;
            }

            $stock = Stock::updateOrCreate([
                'products_id' => $request->products_id,
                'store_id'  => $request->store,
                'product_variation_id'  => $variation,
                'quantity_stock'  => $request->quantity_stock,
                'date_received'  => $date_received,
                'sku'  => $request->sku,
                'barcode_value'  => $barcode_value
            ]);
            if($stock->id){
                //// add stock history
                $stock_history = Stock_history::updateOrCreate([
                    'stock_id' => $stock->id,
                    'type_history'  => "Update Stock",
                    'quantity'  => $request->quantity_stock,
                    'quantity_previous'  => 0,
                    'quantity_current'  => $request->quantity_stock,
                    'sales_id'  => NULL
                ]);
            }
        } else {
            $quantity_old = floatval($existing_stock->quantity_stock);
            $update_stock = $existing_stock->update([
                'quantity_stock' => floatval($existing_stock->quantity_stock) + floatval($request->quantity_stock)
            ]);
            $last_history = Stock_history::where('stock_id', $existing_stock->id)
                     ->get()
                     ->last();

            $quantity_previous = 0;
            $quantity_current = floatval($request->quantity_stock);

            if($last_history != NULL){
                $quantity_previous =  $last_history->quantity_current;
                $quantity_current = $quantity_previous + $quantity_current;
            }
            else{
                $quantity_previous = $quantity_old;
                $quantity_current = floatval($quantity_old) + floatval($request->quantity_stock);
            }

            /// add to stock history
            $add_history = Stock_history::updateOrCreate([
                'stock_id' => $existing_stock->id,
                'type_history'  => "Update Stock",
                'quantity'  => $request->quantity_stock,
                'quantity_previous'  => $quantity_previous,
                'quantity_current'  => $quantity_current
            ]);
        }

        return redirect()->back()->with('success','Stock created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::find($id);
        $product = Products::find($stock->products_id);
        $store = Store::find($stock->store_id);
        $variation = ProductVariation::find($stock->product_variation_id);

        $images = array();
        if(!empty($variation->imagesVariation)) $images = $variation->imagesVariation;

        if(!empty($variation))
            ProductService::processVariation($variation);

        return view('stock.edit', compact(['stock','product','variation','store','images']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function stock_take(Request $request, $id)
     {
        $this->validate($request, [
            'quantity' => 'required|numeric|gt:0',
        ]);
        $stock = Stock::find($id);
        $quantity_previous = $stock->quantity_stock;
        if($request->has('stock_take')){
            $quantity_current = floatval( $stock->quantity_stock) - floatval($request->quantity);
            if($quantity_current < 0){
                return redirect()->back()->with('error_message','Stock Take is negative');
            }
            $stock->update([
                'quantity_stock'  => $quantity_current
            ]);

            //// add stock history
            $stock_history = Stock_history::updateOrCreate([
                'stock_id' => $id,
                'type_history'  => "Stock Take",
                'quantity'  => - floatval($request->quantity),
                'quantity_previous'  => $quantity_previous,
                'quantity_current'  => $quantity_current,
                'stock_date'  => $request->date,
                'stock_description'  => $request->description,
                'sales_id'  => NULL
            ]);
        }
        if($request->has('stock_add')){
            $quantity_current = floatval( $stock->quantity_stock) + floatval($request->quantity);
            if($quantity_current < 0){
                return redirect()->back()->with('error_message','Stock Take is negative');
            }
            $stock->update([
                'quantity_stock'  => $quantity_current
            ]);

            //// add stock history
            $stock_history = Stock_history::updateOrCreate([
                'stock_id' => $id,
                'type_history'  => "Stock Add",
                'quantity'  => floatval($request->quantity),
                'quantity_previous'  => $quantity_previous,
                'stock_description'  => $request->description,
                'quantity_current'  => $quantity_current,
                'sales_id'  => NULL
            ]);
        }

        return redirect()->back()->with('success','Stock updated successfully');

     }

     public function update_sku(Request $request, $id)
     {
        $stock = Stock::find($id);
        $stock->update([
            'sku'  => $request->sku
        ]);
        return redirect()->back()->with('success','Stock updated successfully');
     }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'quantity_stock' => 'required',
        ]);
        $stock = Stock::find($id);
        $date_received = self::transform_date($request->date_received);

        $quantity_previous = $stock->quantity_stock;
        // $stock->product_variation_id
        $stock->update([
            'quantity_stock'  => $request->quantity_stock,
            'date_received'  => $date_received,
            'sku'  => $request->sku,
            'barcode_value'  => $request->barcode_value
        ]);

        //// add stock history
        $stock_history = Stock_history::updateOrCreate([
            'stock_id' => $id,
            'type_history'  => "Update Stock",
            'quantity'  => floatval($request->quantity_stock) - floatval($quantity_previous),
            'quantity_previous'  => $quantity_previous,
            'stock_description'  => $request->description,
            'quantity_current'  => $request->quantity_stock,
            'sales_id'  => NULL
        ]);

        if ($request->has('item_variation_image')) {
            $id_variation = $request->product_variation_id;
            $slug = self::transform_slug($request->barcode_value);
            $variation = ProductVariation::find($id_variation);
            // $images = $variation->imagesVariation;
            $images = array();
            if(!empty($variation->imagesVariation)) $images =  $variation->imagesVariation;
            foreach ($images as $image) {
                $image->delete();
            }
            $path = public_path('files/product_variation/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost())));

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);

            }
            foreach ($request->file('item_variation_image') as $image) {
                $imageName = $slug . '-image-variation-product-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('files/product_variation/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))), $imageName);
                $src = '/files/product_variation/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/' . $imageName;
                $productVariationImage = new ProductVariationImages([
                    'product_variation_id' => $id_variation,
                    'src' => $src
                ]);
                $productVariationImage->save();
            }
        }

        $url = ['reload' => route('stock.edit',$stock->id)];
        return redirect()->back()->with('success','Stock updated successfully');
    }
    public function update_json(Request $request, $id)
    {
        $this->validate($request, [
            'quantity_stock' => 'required',
        ]);
        $stock = Stock::find($id);
        $date_received = self::transform_date($request->date_received);

        $quantity_previous = $stock->quantity_stock;
        // $stock->product_variation_id
        $stock->update([
            'quantity_stock'  => $request->quantity_stock,
            'date_received'  => $date_received,
            'sku'  => $request->sku,
            'barcode_value'  => $request->barcode_value
        ]);

        //// add stock history
        $stock_history = Stock_history::updateOrCreate([
            'stock_id' => $id,
            'type_history'  => "Update Stock",
            'quantity'  => floatval($request->quantity_stock) - floatval($quantity_previous),
            'quantity_previous'  => $quantity_previous,
            'stock_description'  => $request->description,
            'quantity_current'  => $request->quantity_stock,
            'sales_id'  => NULL
        ]);

        if ($request->has('item_variation_image')) {
            $id_variation = $request->product_variation_id;
            $slug = self::transform_slug($request->barcode_value);
            $variation = ProductVariation::find($id_variation);
            // $images = $variation->imagesVariation;
            $images = array();
            if(!empty($variation->imagesVariation)) $images =  $variation->imagesVariation;
            foreach ($images as $image) {
                $image->delete();
            }
            foreach ($request->file('item_variation_image') as $image) {
                $imageName = $slug . '-image-variation-product-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('files/product_variation/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))), $imageName);
                $src = '/files/product_variation/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/' . $imageName;
                $productVariationImage = new ProductVariationImages([
                    'product_variation_id' => $id_variation,
                    'src' => $src
                ]);
                $productVariationImage->save();
            }
        }

        $url = ['reload' => route('stock.edit',$stock->id)];
        die(json_encode($url));
        //return redirect()->back()->with('success','Stock updated successfully');
    }

    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        return $str;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);

        $quantity_previous = $stock->quantity_stock;

        //// add stock history
        $stock_history = Stock_history::updateOrCreate([
            'stock_id' => $id,
            'type_history'  => "Deleted Stock",
            'quantity'  => floatval($quantity_previous),
            'quantity_previous'  => $quantity_previous,
            'quantity_current'  => 0,
            'sales_id'  => NULL
        ]);

        $stock->delete();
        return redirect()->back()->with('success','Stock deleted successfully');
    }

    protected function transform_date($date){
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
        return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
    }

    protected function stock_export(){
        return (new ExportStock_Report())->download('Stock-Report-'. date('Y-m-d-H-i-s') .'.xlsx');
    }

    protected function product_sku_export(){
        return (new ExportProductSku())->download('product-sku-report-'. date('Y-m-d-H-i-s') .'.xlsx');
    }

	protected function updateImportSku(Request $request){
		ProductSKU::truncate();
		return redirect()->route('import-sku',['process'=>1]);

	}
    protected function importSku(Request $request){
        $process = $request->process;
        $offset = ProductSKU::orderBy('id','ASC')->count();
        $info_product = Stock::orderBy('id','DESC')
        ->skip($offset)->take(100+1)
        ->get();

        foreach ($info_product as $product) {
            $is_exist = ProductSKU::where('products_id','=',$product->products_id)
                ->where('product_variation_id','=',$product->product_variation_id)
                ->orderBy('id','DESC')
                ->first();
            if (!$is_exist){
                $color = $group = $type = $material = 0;

                $sku = trim(str_replace('-','',$product->sku));
                if (!empty($sku)){
                    $group = substr($sku,0,1);
                    $type = substr($sku,1,1);
                    $material = substr($sku,2,1);
                    $color = substr($sku,3,1);
                }
                $color_s = self::getCorrespondColor($color);
                $group_s = self::getCorrespondGroup($group);
                $type_s = self::getCorrespondType($type);
                $material_s = self::getCorrespondMaterial($material);
                $warehouse_stock = self::get_warehouse_stock($product);
                ProductSKU::create([
                    'products_id' =>$product->products_id,
                    'product_variation_id' =>$product->product_variation_id,
                    'barcode' => $product->barcode_value,
                    'sku'=> trim($product->sku),
                    'colour' => $color_s,
                    'material' => $material_s,
                    'group' => $group_s,
                    'stock_warehouse' => $warehouse_stock,
                    'type' => $type_s,
                ]);
            } else {
				$warehouse_stock = self::get_warehouse_stock($product);
				$is_exist->update([
                    'stock_warehouse' => $warehouse_stock,
                ]);
			}
        }
        return redirect()->route('stock-sheets',['process_import'=>$process])->with('message', 'Item Created Successfully');
        // return redirect()->back()->with('success','Sku imported successfully');
    }

    public function get_warehouse_stock($stock){
        $fromapi = Setting::where("key", "product_stock_from_api")->first();
        $stock_api = [];
        $stock_api_final = [];
        $empty_warehouse = NULL;
		$have_size = false;
        if ($fromapi != NULL && $fromapi->value == "yes") {
            set_time_limit(0);
            ini_set('max_execution_time', 6000);
            $online_stock_api = OnlineStockApi::latest()->first();
            if ($online_stock_api != NULL) {
                $login = $online_stock_api->username;
                    $password = $online_stock_api->password;
                    $url = $online_stock_api->api_url . $stock->barcode_value;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $stock_api_loc = json_decode($result);
                    $stock_api = array_merge($stock_api, [$stock_api_loc]);
            }
            $api_product = NULL;

			$i = 0;

            foreach($stock_api as $stock_ap){
                if(isset($stock_ap->stock)){
                    if($i == 0) $api_product = $stock_ap;
                    foreach($stock_ap->stock as $stock_x){
                        $arr = [
                            "location" => $stock_x->location,
                            "upc" => $stock_ap->upc,
                            "size" => "",
                            "color" => "",
                            "qty" => $stock_x->qty,
                        ];
                        if (isset($stock_ap->size) && is_string($stock_ap->size) && $stock_ap->size != "") {
                            $arr["size"] = $stock_ap->size;
                            $have_size = true;
                        }
                        if (isset($stock_ap->group5) && is_string($stock_ap->group5)) {
                            $arr["color"] = $stock_ap->group5;
                        }
                        if ($arr["location"] != "Defunct" && $arr["location"] != "Supplier Defect")
                            $stock_api_final = array_merge($stock_api_final, [$arr]);
                    }
                    $i++;
                }
            }
            usort($stock_api_final, fn($a, $b) => strcmp($a['location'], $b['location']));
			$empty_warehouse_tmp = 0;
			foreach ($stock_api_final as $line) {
				$line = (object)$line;
				if($have_size){
					$size = (float)((int)substr($stock->barcode_value,8,3)/10);
					if($line->size = $size){
						$empty_warehouse_tmp = $line->qty;
					}
				} else $empty_warehouse_tmp += $line->qty;

				if ($line->location == "Warehouse" && $line->qty > 0) $empty_warehouse_tmp = $empty_warehouse_tmp;
			}
			if(!empty($stock_api_final) && $api_product != NULL){
				$empty_warehouse = $empty_warehouse_tmp;
			}
        }
        return $empty_warehouse;
    }

    protected function getCorrespondColor($color = 0)
    {
        $colorr = "Natural, Multicolor";
        switch ($color) {
            case 9:
                $colorr = "Blue";
                break;
            case 8:
                $colorr = "Yellow, Beige, Gold";
                break;
            case 7:
                $colorr = "Green";
                break;
           case 6:
               $colorr = "Black";
                break;
           case 5:
               $colorr = "Red";
                break;
           case 4:
               $colorr = "Brown";
                break;
           case 3:
               $colorr = "Tan, Light Brown";
                break;
           case 2:
               $colorr = "Grey";
                break;
           case 1:
               $colorr = "Silver, White";
                break;
           default:
                break;

        }
        return $colorr;
    }

    protected function getCorrespondGroup($group = 0)
    {
        $groupp = "Infants";
        switch ($group) {
            case 9:
                $groupp = "Hosiery & Accessories";
                break;
            case 8:
                $groupp = "MENS";
                break;
            case 7:
                $groupp = "Women Heel Height High 51MM UP";
                break;
           case 6:
               $groupp = "Women Heel Height Medium 26-50MM";
                break;
           case 5:
               $groupp = "Women Heel Height Flat Low 0-25MM";
                break;
           case 4:
               $groupp = "Juniors";
                break;
           case 3:
               $groupp = "Children";
                break;
           case 2:
               $groupp = "Children";
                break;
           case 1:
               $groupp = "Children";
                break;
           default:
                break;

        }
        return $groupp;
    }

    protected function getCorrespondType($type = 0)
    {
        $typee = "Boots, Booties, Occupational, Shoes";
        switch ($type) {
            case 9:
                $typee = "Rainwear, Winter, Protective";
                break;
            case 8:
                $typee = "Canvas";
                break;
            case 7:
                $typee = "Slippers, Thongs";
                break;
           case 6:
               $typee = "Sandals, Chapplies";
                break;
           case 5:
               $typee = "Casuals";
                break;
           case 4:
               $typee = "";
                break;
           case 3:
               $typee = "";
                break;
           case 2:
               $typee = "";
                break;
           case 1:
               $typee = "Dress, Shoes";
                break;
           default:
                break;

        }
        return $typee;
    }

    protected function getCorrespondMaterial($mat = 0)
    {
        $matt = "All other";

        switch ($mat) {
            case 9:
                $matt = "Textile";
                break;
            case 8:
                $matt = "Patent";
                break;
            case 7:
                $matt = "Rubber";
                break;
           case 6:
               $matt = "Leather all other";
                break;
           case 5:
               $matt = "Painted Leather";
                break;
           case 4:
               $matt = "Smooth Leather";
                break;
           case 3:
               $matt = "Suede";
                break;
           case 2:
               $matt = "Plastic";
                break;
           case 1:
               $matt = "Man made";
                break;
           default:
                break;
        }
        return $matt;
    }
}
