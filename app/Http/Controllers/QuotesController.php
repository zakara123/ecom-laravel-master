<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Ledger;
use App\Models\Newquote;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Quotes;
use App\Models\QuotesProducts;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Session;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $quotes = Quotes::
        select('quotes.*')
            ->where([
                ['customer_firstname', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('customer_id', '=', $s)
                            ->orWhere('customer_firstname', 'LIKE', '%' . $s . '%')
                            ->orWhere('customer_lastname', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->orderBy('quotes.id', 'DESC')->paginate(10);

        if ($request->quote_id && $ss == ''){
            $ss = $request->quote_id;
            $quotes = Quotes::
            select('quotes.*')
                ->where([
                    ['customer_firstname', '!=', Null],
                    [function ($query) use ($request) {
                        if (($sl = $request->quote_id)) {
                            $query->orWhere('id', '=', $sl)
                                ->get();
                        }
                    }]
                ])->orderBy('quotes.id', 'DESC')->paginate(10);
        }

        $status = Quotes::select('status')->distinct()->get();
        return view('quotes.index', compact(['quotes', 'ss','status']));
    }

    public function update_customer(Request $request, $id)
    {
        $quotes = Quotes::find($id);

        if (!$quotes) abort(404);

        $address2 = '';
        if(!empty($request->address2))
        $address2 = ' '.$request->address2;
        $quotes->update([
            'customer_firstname' => $request->firstname,
            'customer_lastname' => $request->lastname,
            'customer_address' => $request->address1 . $address2,
            'customer_city' => $request->city,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone
        ]);

        $customer = Customer::find($quotes->customer_id);
        if ($customer->isDirty('email')) $this->validate($request, ['email' => 'email|unique:customers']);
        $customer->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()->back()->with('message', 'Customer Updated Successfully');
    }

    public function update_quote_product(Request $request){
        $quotesProduct = QuotesProducts::find($request->id);
        if ($quotesProduct === NULL) abort(404);
        $quotesProduct->update([
            'order_price' => $request->item_unit_price,
            'quantity' => $request->item_quantity,
            'discount' => $request->discount
        ]);

        $amount = 0;
        $subtotal = 0;
        $tax_amount = 0;
        $quote = Quotes::find($quotesProduct->quotes_id);
        $quotesProducts = QuotesProducts::where("quotes_id", $quotesProduct->quotes_id)->get();
        foreach($quotesProducts as $item){
            if($item->tax_quote == "15% VAT" && $quote->tax_items != "No VAT")
            {
                if($quote->tax_items == "Included in the price"){
                    $amount = $amount + ($item->quantity * $item->order_price );
                    $subtotal = $subtotal + ($item->quantity * ($item->order_price - ($item->quantity * 0.15)));
                    $tax_amount = $tax_amount + ($item->order_price * $item->quantity * 0.15);
                }
                if($quote->tax_items == "Added to the price"){
                    $amount = $amount + ($item->quantity * ( $item->order_price + ($item->order_price * 0.15) ) );
                    $subtotal = $subtotal + ($item->order_price * $item->quantity);
                    $tax_amount = $tax_amount + ($item->order_price * $item->quantity * 0.15);
                }
            }
            else{
                $amount = $amount + ($item->order_price * $item->quantity);
                $subtotal = $subtotal + ($item->order_price * $item->quantity);
            }
        }

        $quote->update([
            'amount' => $amount,
            'subtotal' => $subtotal,
            'tax_amount' => $tax_amount
        ]);

        return redirect()->back()->with('message', 'Item updated Successfully');
    }

    public function details($id){
        $quotes = Quotes::find($id);
        if ($quotes === NULL) abort(404);
        $store = Store::find($quotes->id_store);
        $quotes_products = QuotesProducts::where("quotes_id", $id)->get();
        foreach ($quotes_products as &$item) {
            $variation = NULL;
            $variation_value_final = [];
            if (!empty($item->product_variations_id)) {
                $variation = ProductVariation::find($item->product_variations_id);

                if ($variation != NULL) {
                    $variation_value = json_decode($variation->variation_value);
                    if ($variation_value) {
                        foreach ($variation_value as $v) {
                            foreach ($v as $k => $a) {
                                $attr = Attribute::find($k);
                                $attr_val = AttributeValue::find($a);
                                if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                                $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
                    }
                }
            }
            $item->variation = $variation;
            $item->variation_value = $variation_value_final;

        }

        $this->pdf_quote($id);
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));

        $previous = Quotes::where('id', '<', $id)->orderBy('id', 'DESC')->limit(1)->first();
        $next = Quotes::where('id', '>', $id)->orderBy('id', 'ASC')->limit(1)->first();

        return view('quotes.details', compact(['quotes', 'pdf_src', 'quotes_products', 'store', 'previous', 'next']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    protected function delete_newquote($id){
        $line = Newquote::find($id);
        $line->delete();
        return true;
    }
    protected function empty_newquote(){
        $session_id = Session::get('session_id');
        if(!empty($session_id)){
            $res=Newquote::where("session_id",$session_id)->delete();
        }
        return true;
    }
    protected function add_service_item($request){
        $data = $request->all();

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
        }

        $item = new Newquote([
            'session_id' => $session_id,
            'user_id' => $request->user()->id,
            'product_id' => "-1",
            'product_variation_id' => NULL,
            'product_name' => $data['service_item'],
            'product_price' => $data['service_item_price'],
            'quantity' => $data['service_item_quantity'],
            'tax_quote' => $data['vat_service_item'],
            'tax_items' => $data['tax_items']
        ]);
        $item->save();

        return true;
    }

    public function new()
    {
        $stores = Store::where('is_on_newsale_page', 'yes')
            ->where('is_online', 'no')
            ->get();
        $store = [];
        $item_store = [];
        $store_first = "0";
        if (count($stores) === 1) {
            $store = Store::find($stores[0]->id);
            $item_store = self::get_items_store($stores[0]->id);
            session()->flash('store', $store);
            session()->flash('item_store', $item_store);
        }
        $customers = Customer::orderBy('id', 'desc')->get();
        $products = Products::get();
        $session_id = Session::get('session_id');
        $newquote = [];
        $have_sale_type = "no";
        if (!empty($session_id)) {
            $newquote = Newquote::where("session_id", $session_id)->get();
            foreach ($newquote as &$item) {
                $variation = NULL;
                $variation_value_final = [];
                if (!empty($item->product_variation_id)) {
                    $variation = ProductVariation::find($item->product_variation_id);
                    if ($variation != NULL) {
                        $variation_value = json_decode($variation->variation_value);
                        if ($variation_value) {
                            foreach ($variation_value as $v) {
                                foreach ($v as $k => $a) {
                                    $attr = Attribute::find($k);
                                    $attr_val = AttributeValue::find($a);
                                    if ($attr_val != NULL && $attr != NULL) $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                                }
                            }
                        }
                    }
                }
                $item->variation = $variation;
                $item->variation_value = $variation_value_final;
                /// check if sale have sale type
                if(!empty($item->sales_type)) $have_sale_type = "yes";
            }
        }
        $sales_type = Ledger::get();
        $suppliers = Supplier::get();
        return view('quotes.new', compact(['stores', 'customers', 'products', 'newquote', 'sales_type','suppliers', 'have_sale_type']));
    }

    protected function get_items_store($id_store){
        $products = [];
        $products = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.products_id')
        ->join('stores', 'stores.id', '=', 'stocks.store_id')
        ->select('products.*')
        ->distinct('products.id')
        ->where("stores.id",$id_store)
        ->get();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = "After Post";
        $store = [];
        $data_currency = [];
        if($request->currency != "MUR") {
            $data_currency = self::get_currency($request->currency);
        }
        $old_customer = NULL;
        $old_item = NULL;
        $item_store = Products::get();
        /// add item to table
        if($request->has('add_item'))
        {
            $this->validate($request, [
                'item' => 'required',
                'quantity' => 'required|gt:0'
            ]);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_item_new_quote($request);
            $msg = "Add Item Success";
            return redirect()->back()->with('success',$msg)->with('store',$store)->with('item_store',$item_store)->with('data_currency',$data_currency)->withInput();
        }
        //// add quote to database
        if($request->has('add_quote'))
        {
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                if(isset($request->store) && !empty($request->store)){
                    $store = Store::find($request->store);
                    $item_store = self::get_items_store($request->store);
                }
                return redirect()->back()->with('error_message','Please select items before sending orders.')->with('store',$store)->with('item_store',$item_store)->with('data_currency',$data_currency)->withInput();
            }
            $newquote = Newquote::where("session_id",$session_id)->get();
            if(count($newquote) == 0){
                if(isset($request->store) && !empty($request->store)){
                    $store = Store::find($request->store);
                    $item_store = self::get_items_store($request->store);
                }
                return redirect()->back()->with('error_message','Please select items before sending orders.')->with('store',$store)->with('item_store',$item_store)->with('data_currency',$data_currency)->withInput();
            }
            $id_quote = self::new_order($request);
            self::empty_newquote();
            $msg = "Add Quote Success";
            return redirect()->route('detail-quote', $id_quote)->with('success',$msg);
        }
        //// update item from table
        if($request->has('update_item')){
            /// code
            $this->validate($request, [
                'item_id' => 'required',
                'row_item' => 'required',
                'item_unit_price' => 'required|gt:0',
                'item_quantity' => 'required|gt:0',
                'item_vat' => 'required'
            ]);
            $newquote = Newquote::find($request->item_id);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $discount = 0;
            if(isset($request->discount) && $request->discount>0 && $request->discount<100)
            $discount = $request->discount;
            $product_price_converted = 0;
            if($request->currency != "MUR") {
                $data_currency = self::get_currency($request->currency);
                $product_price_converted = round($request->item_unit_price / $data_currency->conversion_rates->MUR,2);
            }
            $newquote->update([
                'discount'=>$discount,
                'product_name'=>$request->row_item,
                'product_price'=>$request->item_unit_price,
                'order_price_bying'=>$request->item_unit_price_buying,
                'product_price_converted' => $product_price_converted,
                'order_price_buying_converted' => 0,
                'quantity'=>$request->item_quantity,
                'tax_quote'=>$request->item_vat
            ]);
            $msg = "Item updated successfully";
        }
        /// update sales type
        if($request->has('update_quotes_type')){
            $this->validate($request, [
                'item_id_sales_type' => 'required'
            ]);
            $newquote = Newquote::find($request->item_id_sales_type);
            $newquote->update([
                'quotes_type'=>$request->quotes_type
            ]);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "Sales Type updated successfully";
        }
        /// delete item from table
        if($request->has('delete'))
        {
            self::delete_newquote($request->delete);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "Item deleted successfully";
        }
        //// add a variation item
        if($request->has('add_item_variation')){
            $this->validate($request, [
                'item' => 'required',
                'variation' => 'required',
                'quantity_variation' => 'required|gt:0'
            ]);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_item_new_quote($request);
            $msg = "Variation Item added successfully";
        }
        ///select Store from popup
        if($request->has('select_store')){
            $msg = "Store changed";
            $store = Store::find($request->store_popup);
            $item_store = self::get_items_store($request->store_popup);
            self::empty_newquote();
        }
        ///add Service Item
        if($request->has('add_service_item')){
            $this->validate($request, [
                'service_item' => 'required',
                'service_item_price' => 'required|gt:0',
                'service_item_quantity' => 'required|gt:0',
                'vat_service_item' => 'required'
            ]);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_service_item($request);
            $msg = "Service Item added successfully";
        }
        ///add new item and add stock
        if($request->has('add_new_item_main')){
            $this->validate($request, [
                'add_product_name' => 'required',
                'store' => 'required',
                'add_product_selling_price' => 'required|gt:0',
                'add_product_quantity' => 'required|gt:0',
                'add_product_vat' => 'required'
            ]);
            $old_item = self::add_main_product_stock($request);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "New Item and Stock added successfully";
        }
        /// add new customer
        if($request->has('add_new_customer')){
            $this->validate($request, [
                'customer_company_name' => 'required'
            ]);
            $customer = Customer::updateOrCreate([
                'firstname' => $request->customer_firstname,
                'lastname' => $request->customer_lastname,
                'company_name' => $request->customer_company_name,
                'address1' => $request->customer_address1,
                'address2' => $request->customer_address2,
                'country' => $request->customer_country,
                'city' => $request->customer_city,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone
            ]);
            if(isset($request->store) && !empty($request->store)){
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "New Customer added successfully";
            $old_customer = $customer->id;
        }
        //// change Store
        if(!$request->has('delete') && !$request->has('add_quote') && !$request->has('add_item_variation') && !$request->has('select_store') && !$request->has('update_item') && !$request->has('update_quotes_type') && !$request->has('add_service_item') && !$request->has('add_new_item_main') && !$request->has('add_new_customer')){
            $msg = "Store and currency changed";
            $store = Store::find($request->store);
            $item_store = self::get_items_store($request->store);
            self::empty_newquote();
        }
        return redirect()->back()->with('success',$msg)->with('store',$store)->with('item_store',$item_store)->with('data_currency',$data_currency)->with('old_customer',$old_customer)->with('old_item',$old_item)->withInput();

    }

    protected function new_order($request){
        $data = $request->all();
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            return redirect()->back()->with('error_message','Please select items before sending orders.');
        }
        $newquote = Newquote::where("session_id",$session_id)->get();
        if(count($newquote) == 0){
            return redirect()->back()->with('error_message','Please select items before sending orders.');
        }

        ///check customer
        $customer = Customer::find($data['customer']);

        $store = Store::find($data['store']);

        $address2 = "";
        if(isset($customer->address2) && !empty($customer->address2)) $address2 = ", ".$customer->address2;

        $firstname = "";
        $lastname = "";

        if(!empty($customer->company_name)){
            $firstname = $customer->company_name;
        }
        else{
            if(isset($customer->firstname))
            $firstname = $customer->firstname;
            if(isset($customer->lastname))
            $lastname = $customer->lastname;
        }

        $quotes = new Quotes([
            'delivery_date' => self::transform_date($data['delivery_date']),
            'amount' => $data['amount'],
            'subtotal' => $data['subtotal'],
            'tax_amount' => $data['vat_amount'],
            'amount_converted' => $data['amount_converted'],
            'subtotal_converted' => $data['subtotal_converted'],
            'tax_amount_converted' => $data['tax_amount_converted'],
            'currency' => $data['currency'],
            'currency_amount' => $data['currency_value'],
            'status' => "Pending",
            'order_reference' => $data['order_reference'],
            'customer_id' => $customer->id,
            'customer_firstname' => $firstname,
            'customer_lastname' => $lastname,
            'customer_address' => $customer->address1 . $address2,
            'customer_city' => $customer->city,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
            'comment' => $data['comment'],
            'tax_items' => $store->vat_type,
            'internal_note' => "",
            'id_store' => $data['store'],
            'pickup_or_delivery' => 'Delivery',
            'user_id' => $request->user()->id
        ]);

        $quotes->save();
        $id_quote = $quotes->id;

        foreach($newquote as $item){
            /// get stock line stock id

            if($item->discount != NULL) $item->discount = 0;

            $quotesProducts = new QuotesProducts([
                'quotes_id' => $id_quote,
                'product_id' => $item->product_id,
                'product_variations_id' => $item->product_variation_id,
                'order_price' => $item->product_price,
                'order_price_bying' => $item->order_price_bying,
                'order_price_converted' => $item->product_price_converted,
                'order_price_buying_converted' => $item->order_price_buying_converted,
                'product_unit' => $item->product_unit,
                'discount' => $item->discount,
                'quantity' => $item->quantity,
                'product_name' => $item->product_name,
                'tax_quote' => $item->tax_quote,
                'sales_type' => $item->sales_type
            ]);

            $quotesProducts->save();
        }

        return $id_quote;
    }

    protected function transform_date($date){
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
        return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
    }

    protected function add_item_new_quote($request){
        $data = $request->all();
        $product = Products::find($data['item']);

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
        }

        $product_variation_id = NULL;
        $price = $product->price;
        $order_price_bying = $product->price_buying;
        if(isset( $data['variation']) && !empty( $data['variation'])){
            $product_variation_id = $data['variation'];
            $product_variation = ProductVariation::find($data['variation']);
            if($product_variation){
                $price = $data['price_variation'];
                $order_price_bying = $product_variation->price_buying;
            }
        }

        $line = NULL;

        if($product_variation_id == NULL){
            $line = Newquote::where('session_id',$session_id)->where('product_id',$data['item'])->whereNull('product_variation_id')->first();
        }
        else{
            $line = Newquote::where('session_id',$session_id)->where('product_id',$data['item'])->where('product_variation_id',$product_variation_id)->first();
        }

        /// check if item exists in Newquote line
        if($line == NULL){
            $product_price_converted = 0;
            $quantity = $data['quantity'];
            if($product_variation_id != NULL) {
                $variation = ProductVariation::find($product_variation_id);
                $product_price_converted = $variation->price;
                $quantity = $data['quantity_variation'];
            }
            if($request->currency != "MUR") {
                $data_currency = self::get_currency($request->currency);
                $product_price_converted = round($product->price / $data_currency->conversion_rates->MUR,2);
            }
            $item = new Newquote([
                'session_id' => $session_id,
                'user_id' => $request->user()->id,
                'product_id' => $data['item'],
                'product_variation_id' => $product_variation_id,
                'product_name' => $product->name,
                'product_price' => $price,
                'order_price_bying' => $order_price_bying,
                'product_price_converted' => $product_price_converted,
                'order_price_buying_converted' => 0,
                'product_unit' => $product->unit_selling_label,
                'quantity' => $quantity,
                'tax_quote' => $product->vat,
                'tax_items' => $data['tax_items']
            ]);
            $item->save();
        }
        else{
            if($product_variation_id == NULL){
                $line->update([
                    'quantity' => $line->quantity + $data['quantity']
                ]);
            }
            else{
                $line->update([
                    'quantity' => $line->quantity + $data['quantity_variation']
                ]);
            }
        }

        return true;
    }


    protected function get_currency($currency){
        $url = "https://v6.exchangerate-api.com/v6/93e2c1686627b7e651c11db8/latest/". $currency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        $exchange_currency = json_decode($result);
        return $exchange_currency;
    }

    protected function add_main_product_stock($request){
        $slug = self::transform_slug($request->add_product_name);
        $supplier = NULL;
        if(!empty($request->supplier)) $supplier = $request->supplier;
        $product = new Products([
            'name' => $request->add_product_name,
            'price' => $request->add_product_selling_price,
            'price_buying' => $request->add_product_buying_price,
            'unit' => NULL,
            'vat' => $request->add_product_vat,
            'id_supplier' => $supplier,
            'slug' => $slug,
            'description' => $request->add_product_description
        ]);

        $product->save();
        $id_product = $product->id;

        ///add store
        $stock = Stock::updateOrCreate([
            'products_id' => $id_product,
            'store_id'  => $request->store,
            'product_variation_id'  => NULL,
            'quantity_stock'  => $request->add_product_quantity,
            'date_received'  => date('Y-m-d'),
            'barcode_value'  => $id_product
        ]);

        ///add stock history
        if($stock->id){
            //// add stock history
            $stock_history = Stock_history::updateOrCreate([
                'stock_id' => $stock->id,
                'type_history'  => "Update Stock",
                'quantity'  => $request->add_product_quantity,
                'quantity_previous'  => 0,
                'quantity_current'  => $request->add_product_quantity,
                'sales_id'  => NULL
            ]);
        }

        return $id_product;

    }
    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        $exists = Products::whereSlug($str)->exists();
        if($exists) return $str."-1";
        return $str;
    }


    public function pdf_quote($id_quote)
    {
        $company = Company::latest()->first();

        $quote = Quotes::find($id_quote);

        $quotes_products = QuotesProducts::where("quotes_id", $id_quote)->get();

        foreach($quotes_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if(isset($attr->attribute_name) && isset($attr_val->attribute_values))
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $pdf = PDF::loadView('pdf.quote', compact('company', 'quote', 'quotes_products', 'display_logo'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/quote-' . $id_quote . '.pdf', $pdf->output());
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
