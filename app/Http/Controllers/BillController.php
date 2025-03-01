<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Bill;
use App\Models\Bill_product;
use App\Models\BillFiles;
use App\Models\Bills_payment;
use App\Models\Company;
use App\Models\DebitNote;
use App\Models\Email_smtp;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\Newbill;
use App\Models\PayementMethodSales;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDF;
use PHPMailer\PHPMailer\PHPMailer;
use Session;

///for email

class BillController extends Controller
{

    /// what is not done is : send email
    /// Journal
    /// Search on bill list
    /// Add a new attachment
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $bills = Bill::
        select('bills.*', 'payement_method_sales.payment_method')
            ->join('payement_method_sales', 'payement_method_sales.id', '=', 'bills.payment_methode')
            ->where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('id_supplier', '=', $s)
                            ->orWhere('bills.id', '=', $s)
                            ->orWhere('supplier_name', 'LIKE', '%' . $s . '%')
                            ->orWhere('supplier_email', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->orderBy('bills.id', 'DESC')->paginate(10);
        if ($request->bill_id){
            $ss = $request->bill_id;
            $bills = Bill::
            select('bills.*', 'payement_method_sales.payment_method')
                ->join('payement_method_sales', 'payement_method_sales.id', '=', 'bills.payment_methode')
                ->where([
                    [function ($query) use ($request) {
                        if (($sb = $request->bill_id)) {
                            $query->orWhere('id', '=', $sb)
                                ->get();
                        }
                    }]
                ])->orderBy('bills.id', 'DESC')->paginate(10);
        }
        return view('bill.index', compact(['bills', 'ss']));
    }

    public function new(){
        $stores = Store::where('is_on_newsale_page', 'yes')
            ->where('is_online', 'no')
            ->get();
        $store_first = "0";
        if (count($stores) === 1) {
            $store = Store::find($stores[0]->id);
            session()->flash('store', $store);
        }
        $products = Products::get();
        $suppliers = Supplier::get();
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        $newbill = [];
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {
            $newbill = Newbill::where("session_id", $session_id)->get();
            foreach ($newbill as &$item) {
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
            }
        }
        $bill_type = Ledger::get();
        return view('bill.new', compact(['stores', 'suppliers', 'products', 'payment_mode', 'newbill', 'bill_type']));
    }

    protected function add_item_new_bill($request){
        $data = $request->all();

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
        }

        $product_variation_id = NULL;
        if(isset( $data['variation']) && !empty( $data['variation'])){
            $product_variation_id = $data['variation'];
        }

        $line = NULL;

        if($product_variation_id == NULL){
            $line = Newbill::where('session_id',$session_id)->where('product_id',$data['item'])->whereNull('product_variation_id')->first();
        }
        else{
            $line = Newbill::where('session_id',$session_id)->where('product_id',$data['item'])->where('product_variation_id',$product_variation_id)->first();
        }

        if($line == NULL){
            $product = Products::find($data['item']);
            $product_price = $product->price;
            $quantity = $data['quantity'];
            if($product_variation_id != NULL) {
                $variation = ProductVariation::find($product_variation_id);
                $product_price = $variation->price;
                $quantity = $data['quantity_variation'];
            }
            $item = new Newbill([
                'session_id' => $session_id,
                'user_id' => $request->user()->id,
                'product_id' => $data['item'],
                'product_variation_id' => $product_variation_id,
                'product_name' => $product->name,
                'product_unit' => $product->unit_rental_label,
                'product_price' => $product_price,
                'quantity' => $quantity,
                'tax_sale' => $product->vat,
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

    protected function get_items_store_supplier($id_store, $id_supplier){
        $products = [];
        if(empty($id_store) && empty($id_supplier)){
            return $products;
        }

        if(!empty($id_store) && empty($id_supplier)){
            $products = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where("stores.id",$id_store)
            ->get();
            return $products;
        }

        if(empty($id_store) && !empty($id_supplier)){
            $products = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where("products.id_supplier",$id_supplier)
            ->get();
            return $products;
        }

        if(!empty($id_store) && !empty($id_supplier)){
            $products = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where("stores.id",$id_store)
            ->where("products.id_supplier",$id_supplier)
            ->get();
            return $products;
        }

        return $products;
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

    public function details($id){
        $bills = Bill::find($id);

        if (!$bills) abort(404);

        $store = Store::find($bills->id_store);
        $bills_products = Bill_product::where("bill_id", $id)->get();
        $bill_payments = Bills_payment::where("bill_id", $id)->get();
        $bill_files = BillFiles::where("bill_id", $id)->get();
        foreach ($bill_payments as &$payment) {
            $payment->payment_method = PayementMethodSales::find($payment->payment_mode);
            if ($payment->id_debitnote){
                $deb_note = DebitNote::find($payment->id_debitnote);
                if (isset($deb_note->jsonRequest)) $payment->jsondebitnote = $deb_note->jsonRequest;
                else $payment->jsondebitnote = ' ';

            }
        }


        foreach ($bills_products as &$item) {
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
                                $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
                    }
                }
            }
            $item->variation = $variation;
            $item->variation_value = $variation_value_final;
        }
        $order_payment_method = PayementMethodSales::find($bills->payment_methode);
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();

        $amount_due = $bills->amount;

        $amount_paied = Bills_payment::select(DB::raw("sum(bills_payments.amount) as amount_paied"))->where("bill_id", $id)->first();
        $amount_debit = DebitNote::where("bill_id", $id)->sum('amount');

        if ($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied = $amount_paied->amount_paied;

        if ($amount_debit == NULL) $amount_debit = 0;

        $amount_paied = floatval($amount_paied);
        $amount_due = floatval($amount_due);
        $amount_debit = floatval($amount_debit);

        $amount_max = $amount_due;

        if($bills->status== 'Paid'){
            if($amount_paied && $amount_debit) $amount_due = $amount_due - $amount_debit;
            elseif($amount_paied) $amount_due = $amount_due - $amount_paied;

            if($amount_paied && $amount_debit) $amount_paied -= $amount_paied;

            $amount_max = $amount_paied;

        } else {
            if($amount_paied && $amount_debit) $amount_due = $amount_due - $amount_debit;
            elseif($amount_paied) $amount_due = $amount_due - $amount_paied;

            if($amount_paied && $amount_debit) $amount_paied -= $amount_paied;

            $amount_max = $amount_due;
        }


        $ledgers = Ledger::orderBy('name', 'ASC')->get();

        $path = public_path('/pdf/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $this->pdf_purchase($id);
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));

        $billsEbs = DebitNote::where("bill_id", $id)->first();

        return view('bill.details', compact(['bills', 'bills_products', 'bill_payments', 'order_payment_method',
            'amount_debit', 'amount_max', 'billsEbs',
            'store', 'payment_mode', 'ledgers', 'amount_due', 'amount_paied', 'pdf_src', 'bill_files']));
    }

    public function update_bill_reference(Request $request, $id){
        $bills = Bill::find($id);

        if (!$bills) abort(404);

        $bills->update([
            "bill_reference" => $request->bill_reference,
        ]);

        return redirect()->back()->with('success', 'Bill Reference Updated successfully!');
    }

    public function add_bill_files(Request $request){
        $this->validate($request, [
            'bill_id' => 'required',
            'file_upload' => 'required',
        ]);

        $fileName = 'bill-id-'. $request->bill_id . '-' . $request->file('file_upload')->getClientOriginalName();

        $path = public_path('files/attachment/bills/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost())));

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request->file('file_upload')->move(public_path($path), $fileName);

        $item_src = $path . '/' . $fileName;
        BillFiles::create([
            'bill_id'=>$request->bill_id,
            'name'=>$fileName,
            'type'=>$request->document_type,
            'src'=>$item_src,
            'date_generated'=>date("Y-m-d H:i:s")
        ]);

        return redirect()->back()->with('success', 'File Attachment saved successfully!');
    }

    protected function delete_newbill($id){
        $line = Newbill::find($id);
        $line->delete();
        return true;
    }

    protected function empty_newbill(){
        $session_id = Session::get('session_id');
        if(!empty($session_id)){
            $res=Newbill::where("session_id",$session_id)->delete();
        }
        return true;
    }

    protected function new_bill($request){
        $data = $request->all();
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            return redirect()->back()->with('error_message','Please select items before sending orders.');
        }
        $newbill = Newbill::where("session_id",$session_id)->get();
        if(count($newbill) == 0){
            return redirect()->back()->with('error_message','Please select items before sending orders.');
        }

        ///check supplier
        $supplier = Supplier::find($data['supplier']);

        $store = Store::find($data['store']);

        $store_name = "";
        if(isset($store->name)) $store_name = $store->name;

        $payment_methode = PayementMethodSales::find($data['payment_method']);
        $status = 'Paid';
        if($payment_methode->payment_method == 'Payment Due') $status = 'Pending';

        $bills = new Bill([
            'delivery_date' => self::transform_date($data['delivery_date']),
            'due_date' => self::transform_date($data['due_date']),
            'amount' => $data['amount'],
            'subtotal' => $data['subtotal'],
            'tax_amount' => $data['vat_amount'],
            'status' => $status,
            'bill_reference' => $data['bill_reference'],
            'id_supplier' => $supplier->id,
            'supplier_name' => $supplier->name,
            'supplier_email' => $supplier->order_email,
            'supplier_phone' => $supplier->mobile,
            'supplier_address' => $supplier->address,
            'comment' => $data['comment'],
            'tax_items' => $data['tax_items'],
            'id_store' => $data['store'],
            'store' => $store_name,
            'payment_methode' => $data['payment_method'],
            'user_id' => $request->user()->id
        ]);

        $bills->save();
        $id_bill = $bills->id;

        if ($status == 'Paid') {
            $payment_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-',  $bills->created_at)));
            $bills_payments = Bills_payment::updateOrCreate([
                'bill_id' =>  $bills->id,
                'payment_date' => $payment_date,
                'payment_mode' => $bills->payment_methode,
                'payment_reference' => $bills->bill_reference,
                'amount'  => $bills->amount
            ]);
        }

        /// add journal
        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $bills->created_at)));
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;
        $name = 'Bill #' . $bills->id;
        $amount = 0;

        $credit = $debit = 0;
        $ledger_debit = Ledger::where('name', '=', 'Bank')->orderBy('id', 'DESC')->first();
        $ledger_credit = Ledger::where('name', '=', 'Accounts Payable')->orderBy('id', 'DESC')->first();
        if (!$ledger_debit) {
            $ledger_debit = Ledger::create([
                'name' => 'Bank',
                'id_ledger_group' => 0
            ]);
        }

        if (!$ledger_credit) {
            $ledger_credit = Ledger::create([
                'name' => 'Accounts Payable',
                'id_ledger_group' => 0
            ]);
        }
        $debit = $ledger_debit->id;
        $credit = $ledger_credit->id;

        if (!empty(trim($bills->amount))) $amount = $bills->amount;

        JournalEntry::create([
            'id_order' => $bills->id,
            'debit' => $debit,
            'credit' => null,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        JournalEntry::create([
            'id_order' => $bills->id,
            'debit' => null,
            'credit' => $credit,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        /// add item
        foreach($newbill as $item){
            $bill_product = new Bill_product([
                'bill_id' => $id_bill,
                'product_id' => $item->product_id,
                'product_variations_id' => $item->product_variation_id,
                'order_price' => $item->product_price,
                'product_unit' => $item->product_unit,
                'discount' => $item->discount,
                'quantity' => $item->quantity,
                'product_name' => $item->product_name,
                'tax_sale' => $item->tax_sale,
                'bills_type' => $item->bills_type
            ]);

            $bill_product->save();
            /// send email
        }

        $send_mail = $this->send_email($id_bill);

        return  $id_bill;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = "";
        $items = [];
        $store = [];
        $supplier = [];
        $old_supplier = NULL;
        $old_item = NULL;
        /// add item new bill
        if($request->has('add_item'))
        {
            $this->validate($request, [
                'item' => 'required',
                'quantity' => 'required|gt:0'
            ]);
            self::add_item_new_bill($request);
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
            $msg = "Add Item Success";
        }
        ///add Service Item
        if($request->has('add_service_item')){
            $this->validate($request, [
                'service_item' => 'required',
                'service_item_price' => 'required|gt:0',
                'service_item_quantity' => 'required|gt:0',
                'vat_service_item' => 'required'
            ]);
            self::add_service_item($request);
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
            $msg = "Service Item added successfully";
        }
        /// delete item from table
        if($request->has('delete')){
            self::delete_newbill($request->delete);
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
            $msg = "Item deleted successfully";
        }
        if($request->has('add_bill')){
            $bill_id = self::new_bill($request);
            self::empty_newbill();
            $msg = "Bill created successfully";
            return redirect()->route('detail-bill',$bill_id)->with('success',$msg);
        }
        if($request->has('update_bill_type')){
            $msg = "Bill Type updated successfully";
            $this->validate($request, [
                'item_id_bill_type' => 'required'
            ]);
            $newbill = Newbill::find($request->item_id_bill_type);
            $newbill->update([
                'bills_type'=>$request->bill_type
            ]);
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
        }
        if($request->has('update_item')){
            $msg = "Item updated successfully";
            $bool = self::update_newbill($request);
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
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
            if($request->has('store') && $request->has('supplier')){
                $store = Store::find($request->store);
                $supplier = Supplier::find($request->supplier);
                $items = self::get_items_store_supplier($request->store, $request->supplier);
            }
            $msg = "New Item and Stock added successfully";
        }
        /// add new customer
        if($request->has('add_new_supplier')){
            $this->validate($request, [
                'supplier_company_name' => 'required'
            ]);
            $new_supplier = Supplier::updateOrCreate([
                'name' => $request->supplier_company_name,
                'address' => $request->supplier_address,
                'brn' => $request->supplier_brn,
                'vat' =>"VAT Exempt",
                'order_email' => $request->supplier_order_mail,
                'name_person' => $request->supplier_contact_person_name,
                'email_address' => $request->supplier_contact_person_email,
                'mobile' => $request->customer_phone
            ]);
            $msg = "New Customer added successfully";
            $old_supplier = $new_supplier->id;
        }
        ///select Store from popup
        if(!$request->has('add_item') && !$request->has('delete') && !$request->has('add_bill') && !$request->has('select_store') && !$request->has('update_bill_type') && !$request->has('update_item') && !$request->has('add_new_item_main') && !$request->has('add_new_supplier') && !$request->has('add_service_item')){
            $msg = "Store and supplier changed successfully";
            self::empty_newbill();
            $store = Store::find($request->store);
            $supplier = Supplier::find($request->supplier);
            $items = self::get_items_store_supplier($request->store, $request->supplier);
        }
        return redirect()->back()->with('success',$msg)->with('supplier',$supplier)->with('store',$store)->with('item_store',$items)->with('old_supplier',$old_supplier)->with('old_item',$old_item)->withInput();
    }

    protected function add_service_item($request){
        $data = $request->all();

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id',$session_id);
        }
        $item = new Newbill([
            'session_id' => $session_id,
            'user_id' => $request->user()->id,
            'product_id' => "-1",
            'product_variation_id' => NULL,
            'product_name' => $data['service_item'],
            'product_unit' => $data['unit_rental_label'] ?? null,
            'product_price' => $data['service_item_price'],
            'quantity' => $data['service_item_quantity'],
            'tax_sale' => $data['vat_service_item'],
            'tax_items' => $data['tax_items']
        ]);
        $item->save();

        return true;
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

    protected function update_newbill($request){
        $this->validate($request, [
            'item_id' => 'required',
            'item_unit_price' => 'required|gt:0',
            'item_quantity' => 'required|gt:0',
            'item_vat' => 'required'
        ]);
        $newbill = Newbill::find($request->item_id);
        $discount = 0;
        if(isset($request->discount) && $request->discount>0 && $request->discount<100)
        $discount = $request->discount;
        $newbill->update([
            'discount'=>$discount,
            'product_price'=>$request->item_unit_price,
            'quantity'=>$request->item_quantity,
            'tax_sale'=>$request->item_vat
        ]);
        return true;
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
    public function destroy_billfile(Request $request, $id){
        $file = BillFiles::find($id);
        //unlink($file->src);
        $file->delete();
        return redirect()->back()->with('success', 'File Attachment deleted successfully!');
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
        $this->validate($request, [
            'status' => 'required'
        ]);

        $bills = Bill::find($id);

        if (!$bills) abort(404);

        $bills->update([
            "status" => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status updated successfully!');
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

    public function pdf_purchase($bill_id){
        $company = Company::latest()->first();

        $bill = Bill::find($bill_id);

        $bills_products = Bill_product::where("bill_id", $bill_id)->get();

        foreach($bills_products as &$item){
            if(!empty($item->product_variations_id)){
                $variation = ProductVariation::find( $item->product_variations_id);
                $variation_value_final = [];
                if($variation!=NULL){
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($bill->payment_methode);

        $pdf = PDF::loadView('pdf.purchase', compact('company', 'bill', 'bills_products', 'display_logo', 'order_payment_method'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/purchase-' . $bill_id . '.pdf', $pdf->output());
    }

    public function send_email($id){
        ////SMTP settings
        $email_smtp = Email_smtp::latest()->first();
        $smtp_username = "emailapikey";
        $smtp_password = "wSsVR610/xOlB6ooyTT8LrtuzwwEDwikFRh40VqovyL+F/rE8sc9lhWdU1WgHKIcGDFgFmcVoegtmBoE1GYNjYsvmVoECyiF9mqRe1U4J3x17qnvhDzDWG1alBOML4IKxghtk2RiEcgq+g==";
        if ($email_smtp != NULL) {
            $smtp_username = $email_smtp->username;
            $smtp_password = $email_smtp->password;
        }

        $bill = Bill::find($id);

        if ($bill === NULL) return false;

        $payment_mode = PayementMethodSales::find($bill->payment_methode);

        $bills_products = Bill_product::where("bill_id", $id)->get();

        foreach ($bills_products as &$item) {
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
                                $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
                    }
                }
            }
            $item->variation = $variation;
            $item->variation_value = $variation_value_final;
        }

        /// Company
        $company = Company::latest()->first();
        $company_name = "Shop Ecom";
        $company_address = "<br>Mauritus";
        $company_email = "<br>noreply@ecom.mu";
        $company_phone = "<br>123456789";
        $company_fax = "";
        $brn_number = "";
        $vat_number = "";

        if ($company != NULL) {
            if (!empty($company->company_name)) $company_name = $company->company_name;
            if (!empty($company->company_address)) $company_address = "<br>" . $company->company_address; else $company_address = "";
            if (!empty($company->company_email)) $company_email = "<br>" . $company->company_email; else $company_email = "";
            if (!empty($company->company_phone)) $company_phone = "<br>" . $company->company_phone; else $company_phone = "";
            if (!empty($company->company_fax)) $company_fax = "<br>FAX: " . $company->company_fax; else $company_fax = "";
            if (!empty($company->brn_number)) $brn_number = "<br>BRN: " . $company->brn_number; else $brn_number = "";
            if (!empty($company->vat_number)) $vat_number = "<br>VAT: " . $company->vat_number; else $vat_number = "";
        }

        ///Store
        $store = Store::find($bill->id_store);

        /// about supplier
        $supplier_name = "";
        $supplier_address = "";
        $supplier_email = "";
        $supplier_phone = "";

        $supplier_name = $bill->supplier_name;
        if (!empty($bill->supplier_address)) $supplier_address = "<br>" . $bill->supplier_address;
        if (!empty($bill->supplier_email)) $supplier_email = "<br>" . $bill->supplier_email;
        if (!empty($bill->supplier_phone)) $supplier_address = "<br>" . $bill->supplier_phone;

        ///text email before and after
        $text_email_before = "";
        $text_email_after = "";
        $text_pdf_before = "";
        $text_pdf_after = "";

        if (!empty($payment_mode->text_email_before)) {
            $text_email_before = "<br><br>" . $payment_mode->text_email_before;
        }
        if (!empty($payment_mode->text_email)) {
            $text_email_after = "<br><br>" . $payment_mode->text_email;
        }
        if (!empty($payment_mode->text_pdf_before)) {
            $text_pdf_before = "<br><br>" . $payment_mode->text_pdf_before;
        }
        if (!empty($payment_mode->text_pdf_after)) {
            $text_pdf_after = "<br><br>" . $payment_mode->text_pdf_after;
        }

        ///html item list
        $my_items_list = '<div class="my_table">
		<table style="width:100%;">
			<tr>
			<th>Items</th>
			<th>Unit Price (Rs)</th>
			<th>Quantity</th>
            <th>VAT</th>
			<th>Amount (Rs)</th>
			</tr>';

        foreach ($bills_products as $item) {
            ///product unit
            $unit_label = "";
            if(!empty($item->product_unit)) $unit_label = ' / ' .$item->product_unit;

            /// amount with VAT calculation
            $amount = number_format(floatval($item->order_price) * floatval($item->quantity), 2, '.', ',');

            ///get attributs
            $html_attributs = '';
            foreach ($item->variation_value as $key => $var) {
                $html_attributs = $html_attributs . $var['attribute'] . ':' . $var['attribute_value'];
                if ($key !== array_key_last($item->variation_value)) $html_attributs = $html_attributs . ',';
            }

            if (!empty($html_attributs)) $html_attributs = '<br><small style="font-size: 75%;">' . $html_attributs . '</small>';

            $my_items_list = $my_items_list . '<tr>
            <td style="width:40%;">' . $item->product_name . $html_attributs . '</td>
            <td>' . number_format(floatval($item->order_price), 2, '.', ',') . $unit_label . '</td>
            <td>' . $item->quantity . '</td>
            <td>' . $item->tax_sale . '</td>
            <td>' . $amount . '</td>
            </tr>';

        }

        $vat_type = "No VAT";
        if ($bill->tax_items == "Included in the price") $vat_type = "Included";
        if ($bill->tax_items == "Added to the price") $vat_type = "Added";
        $my_items_list = $my_items_list . '
                <tr>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                    <td><b>15% VAT ' . $vat_type . ' (Rs)</b></td><td>' . number_format((float)$bill->tax_amount, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                    <td><b>Subtotal (Rs)</b></td><td>' . number_format((float)$bill->subtotal, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                    <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                    <td><b>Total (Rs)</b></td><td>' . number_format((float)$bill->amount, 2, '.', ',') . '</td>
                </tr>
            </table>
        </div>
        ';

        $comment = $bill->comment;
        if (strlen($comment) > 0) $comment = '<br><div style="text-align:left">Additional Note: ' . str_replace(PHP_EOL, "<br>", $comment) . '</div><br><br>';

        $css_image = "";
        $empty_col = "";
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        if (isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty($company->logo)) {
            $css_image = '<td style="width:25%">
                <img style="width: 120px;height: auto;" src="' . public_path($company->logo) . '">
            </td>';
            $empty_col = '
            <td style="width:25%">
                    &nbsp;
                </td>';
        }

        $due_date = '';
        $delivery_date = '';
        if(!empty($bill->due_date)) $due_date = '<br>Due Date: ' . date_format(date_create($bill->due_date), "d/m/Y") ;
        if(!empty($bill->delivery_date)) $delivery_date = '<br>Purchase Date: ' . date_format(date_create($bill->delivery_date), "d/m/Y") ;

        $html = '<!DOCTYPE html>
		<html>
		<head>
        <meta charset="utf-8">
		<title>Sales Order #' . $id . '</title>
		<style>
            html{
                direction: rtl;
                font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            }
            .my_table table {
                border-collapse: collapse;
                border: 2px solid rgb(200,200,200);
                letter-spacing: 1px;
                font-size: 0.8rem;
            }
            .my_table table,
            .my_table td,
            .my_table th {
                border: 1px solid rgb(190,190,190);
                padding: 10px 20px;
                text-align: center;
            }
            .my_table th {
                background-color: rgb(235,235,235);
            }
            .my_table tr:nth-child(even) td {
                background-color: rgb(250,250,250);
            }
            .my_table tr:nth-child(odd) td {
                background-color: rgb(245,245,245);
            }
            caption {
                padding: 10px;
            }

            p {
                margin-top: 0;
                margin-bottom: 0;
            }
			</style>
			</head>
			<body>
			<table style="width:100%;">
                <tr>
                ' . $css_image . '
                    <td colspan="2" style="text-align: center;">
                        <h2>' . $company_name . '</h2>
                        ' . $company_address . '
                        ' . $company_email . '
                        ' . $company_phone . '
                        ' . $company_fax . '
                        ' . $brn_number . '
                        ' . $vat_number . '
                    </td>
                    ' . $empty_col . '
                </tr>
            </table>
			<table style="width:100%">
			<tr>
                <td>
                <br><b>Bill To:</b>
                <br>' . $supplier_name . '
                ' . $supplier_address . '
                ' . $supplier_email . '
                ' . $supplier_phone . '
                </td>
			<td style="width:100px"></td>
			<td style="text-align:right">
                <br><br>Bill ID: ' . $id . '
                <br>Bill Date: ' . date_format(date_create($bill->created_at), "d/m/Y") . '
                '.$due_date.'
                '.$delivery_date.'
                <br>Payment Mode: ' . $payment_mode->payment_method . '
            </td>
			</tr>
		</table>
		<br><h3><div style="text-align:center">PURCHASE ORDER</div></h3>
		' . $text_pdf_before . '
		<br>' . $my_items_list . '
        ' . $comment . '
        ' . $text_pdf_after . '
		</body>
		</html>
		';

        $directory = public_path('pdf_attachments');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }


        PDF::loadHTML($html)->save('pdf_attachments/bill-' . $id . '.pdf');
        $path = $_SERVER['DOCUMENT_ROOT'] . '/pdf_attachments/bill-'. $id . '.pdf';
        $file_name = 'bill-' . $id . '.pdf';
        if (Storage::disk('public_pdf_attachement')->exists($file_name)) {
            $path = Storage::disk('public_pdf_attachement')->path($file_name);
        }

        $mailContent = '<html>
        <head>
        <style>
        table {
        border-collapse: collapse;
        }

        table, td, th {
            border: 1px solid black;
            text-align: center;
            max-width: 75%;
        }
        p {
            margin-top: 0;
            margin-bottom: 0;
        }
        </style>
        </head>
        <body><br>
        Dear ' . $supplier_name . ',
        ' . $text_email_before . '
        <br>
        <h3><b>Order Summary</b></h3>
        <br>' . $my_items_list . '
        <br>
        ' . $comment . '
        ' . $text_email_after . '

        </body>
        </html>';

        $from_mail = "noreply@ecom.mu";
        $company_sub = "Ecom";
        if (!empty($company->company_email)) $from_mail = $company->company_email;

         ////company subject
         $shop_name = Setting::where("key", "store_name_meta")->first();
         if (!empty($shop_name)) {
             $company_sub = $shop_name->value;
         } else {
             if (!empty($company->company_name)) $company_sub = $company->company_name;
         }

         ///email config
        $to_email = "";
        if (!empty($bill->supplier_email)) $to_email = $bill->supplier_email;

        if (isset($to_email) && !empty($to_email)) {
            ////send mail
            $mail = new PHPMailer(true);
            $mail->Encoding = "base64";
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.zeptomail.com";
            $mail->Port = 587;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = 'TLS';
            $mail->isSMTP();
            $mail->IsHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->setFrom($from_mail, $company_sub);
            $mail->addReplyTo($from_mail, $company_sub);
            $mail->addAddress($to_email);
            $mail->Subject = "Bill #" . $id . " - " . $company_sub;
            $mail->Body = $mailContent;
            $mail->AddAttachment($path, $file_name, $encoding = 'base64', $type = 'application/pdf');
            //echo $from_mail;die;
            if (!$mail->send()) {
                unlink($path);
                return $mail->ErrorInfo;
            } else {
                unlink($path);
                return true;
            }
        }
        else{
            unlink($path);
            return false;
        }
    }

    public function search(Request $request){
        $ss = '';
        if ($request->s) $ss = $request->s;
        $bills = Bill::
        select('bills.*', 'payement_method_sales.payment_method')
            ->join('payement_method_sales', 'payement_method_sales.id', '=', 'bills.payment_methode')
            ->where([
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('id_supplier', '=', $s)
                        ->orWhere('bills.id', '=', $s)
                            ->orWhere('supplier_name', 'LIKE', '%' . $s . '%')
                            ->orWhere('supplier_email', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->orderBy('bills.id', 'DESC')->paginate(10);

        return view('bill.search_ajax', compact(['bills', 'ss']));
    }

    protected function transform_date($date)
    {
//        $d = explode('/', $date);
//        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
//            return $d[2] . "-" . $d[1] . "-" . $d[0];
//        else
        return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
    }

    public function add_debit_note(Request $request)
    {
        $this->validate($request, [
            'bill_id' => 'required',
            'debitnote_date' => 'required',
            'amount' => 'required',
        ]);

        $bill_id = $request->bill_id;

        $date = self::transform_date($request->debitnote_date);

        $bill = Bill::find($request->bill_id);
        if ($bill === NULL) abort(404);

        $amount_due = $bill->amount;

        $amount_paied = Bills_payment::where("bill_id", $request->bill_id)->sum('amount');
        $amount_credit = DebitNote::where("bill_id", $request->bill_id)->sum('amount');

        if ($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied = $amount_paied;

        if ($amount_credit == NULL) $amount_credit = 0;
        else $amount_credit = $amount_credit;

        $amount_paied = floatval($amount_paied);
        $amount_due = floatval($amount_due);
        $amount_credit = floatval($amount_credit);

        $amount_max = $amount_due;

        if($bill->status== 'Paid'){
            $amount_paied = $amount_due - $amount_credit;
            $amount_due = 0;
            $amount_max = $amount_paied;
        } else {
            $amount_due = $amount_due - $amount_credit;
            $amount_max = $amount_due;
        }

        if (floatval($request->amount) > ($amount_max)){
            return redirect()->back()->with('errors', 'Your amount is more than to amount due.');
        }

        $paymentMethodes = PayementMethodSales::where('payment_method','=', 'Debit Note')->orderBy('id','DESC')->first();
        if (!$paymentMethodes){
            $slug = self::transform_slug('Debit Note');
            $paymentMethodes = PayementMethodSales::create([
                'payment_method' =>  'Debit Note',
                'slug' => $slug,
                'is_on_bo_sales_order' => 'no',
                'is_on_online_shop_order' => 'no'
            ]);
        }


        $debitnote = DebitNote::create([
            'bill_id' => $bill_id,
            'date' => $date,
            'amount' => $request->amount,
            'reason' => $request->reason
        ]);

        $bill_payments = Bills_payment::create([
            'bill_id' => $request->bill_id,
            'payment_date' => $date,
            'payment_mode' => $paymentMethodes->id,
            'payment_reference' => $request->reason,
            'id_debitnote'  => $debitnote->id,
            'amount'  => $request->amount
        ]);

        $bill = Bill::find($bill_id);

        $newBill = Bill_product::where("bill_id", $bill_id)->get();

        $supplier = Supplier::find($bill->id_supplier);

        self::mra_ebs_transaction($bill, $newBill, $supplier,true,'Debit Note',null,$debitnote->id);

        return redirect()->back()->with('success', 'Add bill credit note saved successfully!');
    }

    public function mra_ebs_transaction($bill, $newBill, $supplier,$paid,$typeDesc='Standard',$creditnote=null,$debitnote=null)
    {
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $ebs_transactionType = Setting::where("key", "ebs_transactionType")->first();
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_invoiceTypeDesc = Setting::where("key", "ebs_invoiceTypeDesc")->first();
        $ebs_mraId = Setting::where("key", "ebs_mraId")->first();
        $ebs_areaCode = Setting::where("key", "ebs_areaCode")->first();
        $ebs_mraUsername = Setting::where("key", "ebs_mraUsername")->first();
        $ebs_mraPassword = Setting::where("key", "ebs_mraPassword")->first();
        $ebs_token_url = Setting::where("key", "ebs_token_url")->first();
        $ebs_transmit_url = Setting::where("key", "ebs_transmit_url")->first();


        $ebsMraId = $ebs_mraId->value;
        $ebsMraUsername = @$ebs_mraUsername->value;
        $ebsMraPassword = @$ebs_mraPassword->value;
        $areaCode = @$ebs_areaCode->value;

        $publicKey = "";
        // Generate a random AES key
        $aesKey = openssl_random_pseudo_bytes(32); // 32 bytes for AES-256

        // Convert the AES key to Base64 string
        $aesKeyBase64 = base64_encode($aesKey);

        //echo 'AES KEY = ' .$aesKeyBase64. "<br>";
        $payload = array(
            'encryptKey' => $aesKeyBase64,
            'username' => $ebsMraUsername,
            'password' => $ebsMraPassword,
            'refreshToken' => true
        );

        // Import the certificate
        $certPath = base_path().'/public/PublicKey.crt';
        $certContent = file_get_contents($certPath);
        $cert = openssl_x509_read($certContent);

        // Extract the public key from the certificate
        // Encrypt payload using MRA public key
        $pubKeyDetails = openssl_pkey_get_details(openssl_pkey_get_public($cert));
        $publicKey = $pubKeyDetails['key'];
        $encryptedData = '';
        openssl_public_encrypt(json_encode($payload), $encryptedData, $publicKey);

        // Encode encrypted data to Base64
        $base64EncodedData = base64_encode($encryptedData);


        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (!$ebs_mra_einvoincing) {
            return true;
        } else {
            if ($ebs_mra_einvoincing->value == 'Off'){
                return true;
            }
        }

        $requestId = mt_rand();
        $postData = array(
            'requestId' => $requestId,
            'payload' => $base64EncodedData
        );
        $requestHeadersAuth = [
            'accept: application/json',
            'Content-Type: application/json',
            'ebsMraId: ' . $ebsMraId,
            'username: ' . $ebsMraUsername
        ];

        //echo '<br><br>Data to: ' . json_encode($postData) . "<br>";

        $token_url = $ebs_token_url->value;
        $transmit_url = $ebs_transmit_url->value;

        $chAuth = curl_init();
        curl_setopt($chAuth, CURLOPT_URL, $token_url);
        curl_setopt($chAuth, CURLOPT_POST, 1);
        curl_setopt($chAuth, CURLOPT_POSTFIELDS, json_encode($postData)); //Post Fields
        curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chAuth, CURLOPT_HTTPHEADER, $requestHeadersAuth);
        curl_setopt($chAuth, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chAuth, CURLOPT_SSL_VERIFYPEER, 0);
        $responseDataAuth = curl_exec($chAuth);

        //echo "<br> responseDataAuth: = " . $responseDataAuth;
        //Decode the JSON response into a PHP associative array
        $responseArray = json_decode($responseDataAuth, true);

        //MRA key received from generate token

        if(!isset($responseArray['token']) || !$responseArray['token']){
            $salesEbsResult = DebitNote::find($debitnote);
            $salesEbsResult->update(
                [
                    'responseId' => $responseArray['responseId'],
                    'requestId' => $responseArray['requestId'],
                    'status' => $responseArray['status'],
                    'errorMessages' =>  $responseArray['errors'][0]
                ]
            );
            return true;
        }

        $token = $responseArray['token'];

        $mraKey = $responseArray['key'];

        $company = Company::latest()->first();
        $buyer_name = '';
        if (!empty($supplier->name)) {
            $buyer_name = $supplier->name;
        } else {

            $buyer_name = $supplier->name_person;
        }


        $data = [];

        foreach ($newBill as $item) {
            /// get stock line stock id

            if ($item->discount != NULL) $item->discount = 0;

            $taxCode = 'TC05';
            $vatAmt = 0;
            $amtWoVatCur = $item->order_price;

            if ($item->tax_sale == 'VAT Exempt'){
                $taxCode = 'TC03';
            }
            elseif ($item->tax_sale == '15% VAT'){
                $taxCode = 'TC01';
                $amtWoVatCur = $item->order_price - (($item->order_price* (15/100)));
                $vatAmt = $item->order_price - $amtWoVatCur;
            }
            elseif ($item->tax_sale == 'Zero Rated'){
                $taxCode = 'TC02';
            }


            $data[] = [
                'itemNo' =>  $item->product_id,
                'taxCode' => $taxCode,
                'nature' => 'GOODS',
                'productCodeMra' => '',
                'productCodeOwn' => $item->product_name,
                'itemDesc' => $item->product_name,
                'quantity' => (int)$item->quantity, // Convertir en entier si nécessaire
                'unitPrice' => number_format((float)$item->order_price, 2, '.', ''),
                'discount' => number_format((float)$item->discount, 2, '.', '') ,
                'amtWoVatCur' => number_format((float)$amtWoVatCur, 2, '.', ''),
                'vatAmt' => number_format((float)$vatAmt, 2, '.', ''),
                'totalPrice' => number_format((float)$item->order_price * $item->quantity, 2, '.', '')
            ];

        }


        $bill_transaction = "CASH";
        $payment_slug = PayementMethodSales::find($bill->payment_methode);
        if($payment_slug->payment_method =='Debit/Credit Card') {
            $bill_transaction = "CARD";
        }
        elseif($payment_slug->payment_method =='Credit Sale' || $payment_slug->payment_method =='Credit Note') {
            $bill_transaction = "CREDIT";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cheque')) {
            $bill_transaction = "CHEQUE";
        }
        elseif(str_contains($payment_slug->payment_method, 'Bank Transfer')) {
            $bill_transaction = "BNKTRANSFER";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cash') || $payment_slug->payment_method =='Debit Note') {
            $bill_transaction = "CASH";
        }
        else {
            $bill_transaction = "OTHER";
        }

        $total_paid = 0;
        if($paid){
            $total_paid = $bill->amount;
        }
        $ebs_typeOfPersonDesc = 'STD';
        if($typeDesc == 'Credit Note'){
            $ebs_typeOfPersonDesc = 'CRN';
        } elseif ($typeDesc == 'Debit Note'){
            $ebs_typeOfPersonDesc = 'DRN';
        }

        $ebs_bill_date = date('Ymd H:i:s', strtotime(str_replace('/', '-', $bill->created_at)));

        $reason = "Return of product";
        if ($debitnote){
            $cn = debitnote::find($debitnote);
            $reason = $cn->reason;
        }

        $b_tan = '';
        if($supplier->vat_supplier) $b_tan = $supplier->vat_supplier;
        $b_brn = '';
        if($supplier->brn) $b_brn = $supplier->brn;
        $b_adr = '';
        if($supplier->address) $b_adr = $supplier->address;

        $arInvoice = [
            'invoiceCounter' => $requestId,
            'transactionType' => $ebs_transactionType->value,
            'personType' => $ebs_typeOfPerson->value,
            'invoiceTypeDesc' => $ebs_typeOfPersonDesc,
            'currency' => 'MUR',
            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$bill->id,
            'invoiceRefIdentifier' => $ebs_invoiceIdentifier->value.$bill->id,
            'previousNoteHash' => 'prevNote',
            'reasonStated' => $reason,
            'totalVatAmount' => number_format((float)$bill->tax_amount, 2, '.', ''),
            'totalAmtWoVatCur' => number_format((float)$bill->subtotal, 2, '.', ''),
            'invoiceTotal' => number_format((float)$bill->amount, 2, '.', ''),
            'totalAmtPaid' => number_format((float)$total_paid, 2, '.', ''),
            'dateTimeInvoiceIssued' => $ebs_bill_date,
            "salesTransactions" => $bill_transaction,
            'seller' => [
                'name' => $company->company_name,
                'tradeName' => $company->company_name,
                'tan' => $company->tan,
                'brn' => $company->brn_number,
                'businessAddr' => $company->company_address,
                'businessPhoneNo' => $company->company_phone,
            ],
            'buyer' => [
                'name' => $buyer_name,
                'tan' => $b_tan,
                'brn' => $b_brn,
                'businessAddr' => $b_adr,
            ],
            'itemList' => $data,
        ];

        $invoiceArray = array($arInvoice);

        $jsonencode = json_encode($invoiceArray);


        //algorithm should be AES-256-ECB
        $decryptedKey = openssl_decrypt($mraKey, 'AES-256-ECB', base64_decode($aesKeyBase64));

        // algorithm should be AES-256-ECB
        $encryptedInvoice = openssl_encrypt($jsonencode, 'AES-256-ECB', base64_decode($decryptedKey), OPENSSL_RAW_DATA);

        // encrypted invoice should be encoded
        $payloadInv = base64_encode($encryptedInvoice);

        $requestHeadersInv = [
            'Content-Type: application/json',
            'ebsMraId: ' . $ebsMraId,
            'username: ' . $ebsMraUsername,
            'areaCode: ' . $areaCode,
            'token: ' . $token
        ];
        $postDataInv = [
            'requestId' => $requestId,
            'requestDateTime' => date('Ymd H:i:s'),
            'signedHash' => '',
            'encryptedInvoice' => $payloadInv
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $transmit_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postDataInv)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeadersInv);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $responseData = curl_exec($ch);
        $responseFinalArray = json_decode($responseData, true);

        //MRA key received from generate token
        $responseId = $responseFinalArray['responseId'];
        $requestId = $responseFinalArray['requestId'];
        $status = $responseFinalArray['status'];
        $infoMessages = $responseFinalArray['infoMessages'];
        $errorMessages = $responseFinalArray['errorMessages'];
        $id_bill = $bill->id;
        $qrCode = $irn = $invoiceIdentifier = null;

        if ($debitnote){


            $salesEbsResult = DebitNote::find($debitnote);

            if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];

            if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
            if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];

            $salesEbsResult->update(
                [
                    'responseId' => $responseId,
                    'requestId' => $requestId,
                    'status' => $status,
                    'jsonRequest' => $jsonencode,
                    'invoiceIdentifier' => $invoiceIdentifier,
                    'irn' => $irn,
                    'qrCode' => $qrCode,
                    'infoMessages' => $infoMessages,
                    'errorMessages' => $errorMessages
                ]
            );
        }
//        else {
//            $salesEbsResult = new SalesEBSResults();
//            $salesEbsResult->sale_id = $id_sales;
//            $salesEbsResult->responseId = $responseId;
//            $salesEbsResult->requestId = $requestId;
//            $salesEbsResult->status = $status;
//            $salesEbsResult->jsonRequest = $jsonencode;
//            if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $salesEbsResult->invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
//            if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $salesEbsResult->irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
//            if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $salesEbsResult->qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
//            if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $salesEbsResult->errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];
//            if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $salesEbsResult->infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
//            if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $salesEbsResult->errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];
//
//            $salesEbsResult->save();
//        }
        return $responseFinalArray;
    }

}
