<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Customer;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\Newsale;
use App\Models\PayementMethodSales;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesEBSResults;
use App\Models\SalesInvoiceCounter;
use App\Models\SalesPayments;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use function Ramsey\Collection\Map\replace;

class NewSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $msg = "After Post";
        $store = [];
        $data_currency = [];
        if ($request->currency != "MUR") {
            $data_currency = self::get_currency($request->currency);
        }
        $session_id = Session::get('session_id');

        $old_customer = NULL;
        $old_item = NULL;
        $item_store = Products::get();
        /// add item to table
        if ($request->has('add_item')) {
            $this->validate($request, [
                'item' => 'required',
                'quantity' => 'required|gt:0'
            ]);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_item_new_sale($request);
            $msg = "Add Item Success";
            return redirect()->back()->with('success', $msg)->with('store', $store)->with('item_store', $item_store)->with('data_currency', $data_currency)->withInput();
        }
        //// add sale to database
        if ($request->has('add_sale')) {
            if (empty($session_id)) {
                if (isset($request->store) && !empty($request->store)) {
                    $store = Store::find($request->store);
                    $item_store = self::get_items_store($request->store);
                }
                return redirect()->back()->with('error_message', 'Please select items before sending orders.')->with('store', $store)->with('item_store', $item_store)->with('data_currency', $data_currency)->withInput();
            }
            $newsale = Newsale::where("session_id", $session_id)->get();
            if (count($newsale) == 0) {
                if (isset($request->store) && !empty($request->store)) {
                    $store = Store::find($request->store);
                    $item_store = self::get_items_store($request->store);
                }
                return redirect()->back()->with('error_message', 'Please select items before sending orders.')->with('store', $store)->with('item_store', $item_store)->with('data_currency', $data_currency)->withInput();
            }
            $id_sale = self::new_order($request);
            self::empty_newsale();
            $msg = "Add Sale Success";
            return redirect()->route('detail-sale', $id_sale)->with('success', $msg);
        }
        //// update item from table
        if ($request->has('update_item')) {
            $this->validate($request, [
                'item_id' => 'required',
                'item_unit_price' => 'required|gt:0',
                'item_quantity' => 'required|gt:0',
                'item_vat' => 'required'
            ], [
                'item_unit_price.gt' => 'Selling price should be greater than 0'
            ]);
            $newsale = Newsale::find($request->item_id);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            if ($newsale == "-1") {
                $this->validate($request, ['row_item' => 'required']);
            }
            $discount = 0;
            if (isset($request->discount) && $request->discount > 0 && $request->discount < 100)
                $discount = $request->discount;
            $product_price_converted = 0;
            if ($request->currency != "MUR") {
                $data_currency = self::get_currency($request->currency);
                $product_price_converted = round($request->item_unit_price / $data_currency->conversion_rates->MUR, 2);
            }
            $data = [
                'discount' => $discount,
                'product_price' => $request->item_unit_price,
                'product_price_converted' => $product_price_converted,
                'quantity' => $request->item_quantity,
                'tax_sale' => $request->item_vat
            ];
            if ($newsale == "-1") {
                $data['product_name'] = $request->row_item;
            }
            $newsale->update($data);
            $msg = "Item updated successfully";
        }

        /// update sales type
        if ($request->has('update_sales_type')) {
            $this->validate($request, [
                'item_id_sales_type' => 'required'
            ]);
            $newsale = Newsale::find($request->item_id_sales_type);
            $newsale->update([
                'sales_type' => $request->sales_type
            ]);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "Sales Type updated successfully";
        }
        /// delete item from table
        if ($request->has('delete')) {
            self::delete_newsale($request->delete);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "Item deleted successfully";
        }
        //// add a variation item
        if ($request->has('add_item_variation')) {
            $this->validate($request, [
                'item' => 'required',
                'variation' => 'required',
                'quantity_variation' => 'required|gt:0',
                'price_variation' => 'required|gt:0',
            ], [
                'price_variation.gt' => 'Selling price should be greater than 0'
            ]);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_item_new_sale($request);
            $msg = "Variation Item added successfully";
        }
        ///select Store from popup
        if ($request->has('select_store')) {
            $msg = "Store changed";
            $store = Store::find($request->store_popup);
            $item_store = self::get_items_store($request->store_popup);
            self::empty_newsale();
        }
        ///add Service Item
        if ($request->has('add_service_item')) {
            $this->validate($request, [
                'service_item' => 'required',
                'service_item_price' => 'required|gt:0',
                'service_item_quantity' => 'required|gt:0',
                'vat_service_item' => 'required'
            ], [
                'service_item_price.gt' => 'Selling price should be greater than 0'
            ]);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            self::add_service_item($request);
            $msg = "Service Item added successfully";
        }
        ///add new item and add stock
        if ($request->has('add_new_item_main')) {
            $this->validate($request, [
                'add_product_name' => 'required',
                'store' => 'required',
                'add_product_selling_price' => 'required|gt:0',
                'add_product_quantity' => 'required|gt:0',
                'add_product_vat' => 'required'
            ], [
                'add_product_selling_price.gt' => 'Selling price should be greater than 0'
            ]);
            $old_item = self::add_main_product_stock($request);
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "New Item and Stock added successfully";
        }
        /// add new customer
        if ($request->has('add_new_customer')) {
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
            if (isset($request->store) && !empty($request->store)) {
                $store = Store::find($request->store);
                $item_store = self::get_items_store($request->store);
            }
            $msg = "New Customer added successfully";
            $old_customer = $customer->id;
        }
        //// change Store
        if (!$request->has('delete') && !$request->has('add_sale') && !$request->has('add_item_variation') && !$request->has('select_store') && !$request->has('update_item') && !$request->has('update_sales_type') && !$request->has('add_service_item') && !$request->has('add_new_item_main') && !$request->has('add_new_customer')) {
            $msg = "Store and currency changed";
            $store = Store::find($request->store);
            $item_store = self::get_items_store($request->store);
            self::empty_newsale();
        }
        return redirect()->back()->with('success', $msg)->with('store', $store)->with('item_store', $item_store)->with('data_currency', $data_currency)->with('old_customer', $old_customer)->with('old_item', $old_item)->withInput();
    }

    public function updateTotalDiscount(Request $request)
    {
        $session_id = Session::get('session_id');

        if ($request->has('update_item')) {
            /// update total discount
            if ($request->has('total_discount')) {
                Newsale::where("session_id", $session_id)->update(['discount' => $request->total_discount]);
                $msg = "Total discount updated successfully";
                return redirect()->back()->with('success', $msg);
            }
        }
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
        if ($exists) return $str . "-1";
        return $str;
    }

    protected function add_main_product_stock($request)
    {
        $slug = self::transform_slug($request->add_product_name);
        $supplier = NULL;
        if (!empty($request->supplier)) $supplier = $request->supplier;
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
            'store_id' => $request->store,
            'product_variation_id' => NULL,
            'quantity_stock' => $request->add_product_quantity,
            'date_received' => date('Y-m-d'),
            'barcode_value' => $id_product
        ]);

        ///add stock history
        if ($stock->id) {
            //// add stock history
            $stock_history = Stock_history::updateOrCreate([
                'stock_id' => $stock->id,
                'type_history' => "Update Stock",
                'quantity' => $request->add_product_quantity,
                'quantity_previous' => 0,
                'quantity_current' => $request->add_product_quantity,
                'sales_id' => NULL
            ]);
        }

        return $id_product;

    }

    protected function get_currency($currency)
    {
        $url = "https://v6.exchangerate-api.com/v6/93e2c1686627b7e651c11db8/latest/" . $currency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $exchange_currency = json_decode($result);
        return $exchange_currency;
    }

    protected function add_item_new_sale($request)
    {
        $data = $request->all();

        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
        }

        $product_variation_id = NULL;
        if (isset($data['variation']) && !empty($data['variation'])) {
            $product_variation_id = $data['variation'];
        }

        $line = NULL;

        if ($product_variation_id == NULL) {
            $line = Newsale::where('session_id', $session_id)->where('product_id', $data['item'])->whereNull('product_variation_id')->first();
        } else {
            $line = Newsale::where('session_id', $session_id)->where('product_id', $data['item'])->where('product_variation_id', $product_variation_id)->first();
        }

        /// check if item exists in NewSale line
        if ($line == NULL) {
            $product = Products::find($data['item']);
            $product_price_converted = 0;
            $quantity = $data['quantity'];
            if ($product_variation_id != NULL) {
                $variation = ProductVariation::find($product_variation_id);
                $product_price_converted = $variation->price;
                $quantity = $data['quantity_variation'];
            }
            if ($request->currency != "MUR") {
                $data_currency = self::get_currency($request->currency);
                $product_price_converted = round($product->price / $data_currency->conversion_rates->MUR, 2);
            }

            $product_price = $product->price;
            if (isset($request->price_variation) && !empty($request->price_variation)) $product_price = $request->price_variation;

            $item = new Newsale([
                'session_id' => $session_id,
                'user_id' => $request->user()->id,
                'product_id' => $data['item'],
                'product_variation_id' => $product_variation_id,
                'product_name' => $product->name,
                'product_price' => $product_price,
                'product_price_converted' => $product_price_converted,
                'product_unit' => $product->unit_selling_label,
                'quantity' => $quantity,
                'tax_sale' => $product->vat,
                'tax_items' => $data['tax_items']
            ]);
            $item->save();
        } else {
            if ($product_variation_id == NULL) {
                $line->update([
                    'quantity' => $line->quantity + $data['quantity']
                ]);
            } else {
                $line->update([
                    'quantity' => $line->quantity + $data['quantity_variation']
                ]);
            }
        }

        return true;
    }

    protected function add_service_item($request)
    {
        $data = $request->all();

        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
        }

        $item = new Newsale([
            'session_id' => $session_id,
            'user_id' => $request->user()->id,
            'product_id' => "-1",
            'product_variation_id' => NULL,
            'product_name' => $data['service_item'],
            'product_price' => $data['service_item_price'],
            'quantity' => $data['service_item_quantity'],
            'tax_sale' => $data['vat_service_item'],
            'tax_items' => $data['tax_items']
        ]);
        $item->save();

        return true;
    }

    protected function delete_newsale($id)
    {
        $line = Newsale::find($id);
        $line->delete();
        return true;
    }

    protected function empty_newsale()
    {
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {
            $res = Newsale::where("session_id", $session_id)->delete();
        }
        return true;
    }

    protected function get_items_store($id_store)
    {
        $products = [];
        $products = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where("stores.id", $id_store)
            ->get();
        return $products;
    }

    protected function new_order($request)
    {
        $data = $request->all();
        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            return redirect()->back()->with('error_message', 'Please select items before sending orders.');
        }
        $newsale = Newsale::where("session_id", $session_id)->get();
        if (count($newsale) == 0) {
            return redirect()->back()->with('error_message', 'Please select items before sending orders.');
        }

        ///check customer
        $customer = Customer::find($data['customer']);

        $store = Store::find($data['store']);

        $address2 = "";
        if (isset($customer->address2) && !empty($customer->address2)) $address2 = ", " . $customer->address2;

        $firstname = "";
        $lastname = "";

        if (!empty($customer->company_name)) {
            $firstname = $customer->company_name;
        } else {
            $firstname = $customer->firstname;
            $lastname = $customer->lastname;
        }

        $sales = new Sales([
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
            'payment_methode' => $data['payment_method'],
            'pickup_or_delivery' => 'Delivery',
            'user_id' => $request->user()->id,
            'type_sale' => !empty($data['type_sale']) ? $data['type_sale'] : 'ONLINE_SALE'
        ]);

        $sales->save();
        $id_sale = $sales->id;

        // add Journal
        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $sales->created_at)));
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;
        $name = 'Sales #' . $sales->id;
        $amount = 0;

        $credit = $debit = 0;
        $ledger_debit = Ledger::where('name', '=', 'Accounts Receivable')->orderBy('id', 'DESC')->first();
        $ledger_credit = Ledger::where('name', '=', 'Sales')->orderBy('id', 'DESC')->first();
        if (!$ledger_debit) {
            $ledger_debit = Ledger::create([
                'name' => 'Accounts Receivable',
                'id_ledger_group' => 0
            ]);
        }

        if (!$ledger_credit) {
            $ledger_credit = Ledger::create([
                'name' => 'Sales',
                'id_ledger_group' => 0
            ]);
        }
        $debit = $ledger_debit->id;
        $credit = $ledger_credit->id;
        if (!empty(trim($sales->amount))) $amount = $sales->amount;
        JournalEntry::create([
            'id_order' => $sales->id,
            'debit' => $debit,
            'credit' => null,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        JournalEntry::create([
            'id_order' => $sales->id,
            'debit' => null,
            'credit' => $credit,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        ///payment method
        $paymentMethode = PayementMethodSales::find($request->payment_method);

        foreach ($newsale as $item) {
            /// get stock line stock id
            $sales_products = new Sales_products([
                'sales_id' => $id_sale,
                'product_id' => $item->product_id,
                'product_variations_id' => $item->product_variation_id,
                'order_price' => $item->product_price,
                'order_price_converted' => $item->product_price_converted,
                'product_unit' => $item->product_unit,
                'discount' => $item->discount,
                'quantity' => $item->quantity,
                'product_name' => $item->product_name,
                'tax_sale' => $item->tax_sale,
                'sales_type' => $item->sales_type
            ]);

            if (isset($item->sales_type) && !empty($item->sales_type)) {

                $credit = 0;
                $debit = 0;
                $ledger_debit = Ledger::where('name', '=', 'Accounts Receivable')->orderBy('id', 'DESC')->first();
                $ledger_credit = Ledger::where('name', '=', $item->sales_type)->orderBy('id', 'DESC')->first();
                if (!$ledger_debit) {
                    $ledger_debit = Ledger::create([
                        'name' => 'Accounts Receivable',
                        'id_ledger_group' => 0
                    ]);
                }
                if (!$ledger_credit) {
                    $ledger_debit = Ledger::create([
                        'name' => $item->sales_type,
                        'id_ledger_group' => 0
                    ]);
                }

                $debit = $ledger_debit->id;
                $credit = $ledger_credit->id;
                $amount = $item->product_price * $item->quantity;
                JournalEntry::create([
                    'id_order' => $sales->id,
                    'debit' => $debit,
                    'credit' => null,
                    'amount' => $amount,
                    'date' => $date,
                    'name' => $name,
                    'journal_id' => $journal_id,
                ]);

                JournalEntry::create([
                    'id_order' => $sales->id,
                    'debit' => null,
                    'credit' => $credit,
                    'amount' => $amount,
                    'date' => $date,
                    'name' => $name,
                    'journal_id' => $journal_id,
                ]);
            }

            $sales_products->save();
        }

        if ($request->add_sale == "Send (Draft)" || $request->add_sale == "Send (Pending)") {

            if ($request->add_sale == "Send (Draft)") {
                $sales->update([
                    'status' => "Draft"
                ]);
            }

            $backoffice_order_mail = Setting::where("key", "send_backoffice_order_mail")->first();
            $backoffice_order_mail_admin = Setting::where("key", "send_backoffice_order_mail_admin")->first();
            if ((isset($backoffice_order_mail->value) && $backoffice_order_mail->value == "yes") || (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == "yes")) {
                app('App\Http\Controllers\SalesController')->send_email($id_sale, "");
            }
            if ($paymentMethode->payment_method == "Credit Sale") {
                app('App\Http\Controllers\SalesController')->deduct_stock($id_sale);
            }
            self::mra_ebs_transaction($sales, $newsale, $customer,false);
        } else {
            $sales->update([
                'status' => "Paid"
            ]);
            $order_status_change_to_admin = Setting::where("key", "order_status_change_to_admin")->first();
            if (isset($order_status_change_to_admin->value) && $order_status_change_to_admin->value == "yes") {
                app('App\Http\Controllers\SalesController')->send_paid_mail($id_sale);
            }
            $payment_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $sales->created_at)));
            $sales_payments = SalesPayments::updateOrCreate([
                'sales_id' => $sales->id,
                'payment_date' => $payment_date,
                'payment_mode' => $sales->payment_methode,
                'payment_reference' => $sales->order_reference,
                'amount'  => $sales->amount
            ]);

            /// deduct stock
            app('App\Http\Controllers\SalesController')->deduct_stock($id_sale);
            self::mra_ebs_transaction($sales, $newsale, $customer,true);
        }

        return $id_sale;
    }

    public function mra_ebs_transaction($sales, $newSales, $customer,$paid)
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
//        $ebs_invoiceCounter = Setting::where("key", "ebs_invoiceCounter")->first();


        $ebsMraId = @$ebs_mraId->value;
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

//        $requestId = mt_rand();

        $requestId = 1;
        $invoiceCounter = new SalesInvoiceCounter();
        $invoiceCounter->sales_id = $sales->id;
        $invoiceCounter->is_sales = 'yes';
        $invoiceCounter->save();

        $ebs_invoiceCounter = SalesInvoiceCounter::max('id');
        if ($ebs_invoiceCounter){
            $requestId = $ebs_invoiceCounter;
        }

        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (!$ebs_mra_einvoincing) {
            return true;
        } else {
            if ($ebs_mra_einvoincing->value == 'Off'){
                return true;
            }
        }

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
            $id_sales = $sales->id;
            $salesEbsResult = new SalesEBSResults();
            $salesEbsResult->responseId = $ebs_invoiceIdentifier->value.$requestId;
            $salesEbsResult->invoiceIdentifier = $ebs_invoiceIdentifier->value.$requestId;
            $salesEbsResult->requestId = $requestId;
            $salesEbsResult->status = 'Down';
            $salesEbsResult->errorMessages = 'Error in Url Generate token';
            $salesEbsResult->sale_id = $id_sales;
            $salesEbsResult->save();
            return true;
        }

        $token = @$responseArray['token'];
        $mraKey = @$responseArray['key'];

        $company = Company::latest()->first();
        $buyer_name = '';
        if (!empty($customer->company_name)) {
            $buyer_name = $customer->company_name;
        } else {
            $firstname = $customer->firstname;
            $lastname = $customer->lastname;

            $buyer_name = $firstname . ' '. $lastname;
        }
        $data = [];

        foreach ($newSales as $item) {
            /// get stock line stock id

            if ($item->discount != NULL) $item->discount = 0;

            $taxCode = 'TC05';
            $vatAmt = 0;
            $amtWoVatCur = $item->product_price;

            if ($item->tax_sale == 'VAT Exempt'){
                $taxCode = 'TC03';
            }
            elseif ($item->tax_sale == '15% VAT'){
                $taxCode = 'TC01';
                $amtWoVatCur = $item->product_price - (($item->product_price* (15/100)));
                $vatAmt = $item->product_price - $amtWoVatCur;
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
                'unitPrice' => number_format((float)$item->product_price, 2, '.', ''),
                'discount' => number_format((float)$item->discount, 2, '.', '') ,
                'amtWoVatCur' => number_format((float)$amtWoVatCur, 2, '.', ''),
                'vatAmt' => number_format((float)$vatAmt, 2, '.', ''),
                'totalPrice' => number_format((float)$item->product_price * $item->quantity, 2, '.', '')
            ];

        }

        $sales_transaction = "CASH";
        $payment_slug = PayementMethodSales::find($sales->payment_methode);
        if($payment_slug->payment_method =='Debit/Credit Card') {
            $sales_transaction = "CARD";
        }
        elseif($payment_slug->payment_method =='Credit Sale' || $payment_slug->payment_method =='Credit Note') {
            $sales_transaction = "CREDIT";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cheque')) {
            $sales_transaction = "CHEQUE";
        }
        elseif(str_contains($payment_slug->payment_method, 'Bank Transfer')) {
            $sales_transaction = "BNKTRANSFER";
        }
        elseif(str_contains($payment_slug->payment_method, 'Cash')) {
            $sales_transaction = "CASH";
        }
        else {
            $sales_transaction = "OTHER";
        }

        $total_paid = 0;
        if($paid){
            $total_paid = $sales->amount;
        }


        $b_tan = '';
        if($customer->vat_customer) $b_tan = $customer->vat_customer;
        $b_brn = '';
        if($customer->brn_customer) $b_brn = $customer->brn_customer;
        $b_adr = '';
        if($customer->address1) $b_adr = $customer->address1;

        $invoiceType = 'STD';
        if(!$paid) {
            if($sales->status == 'Draft') $invoiceType = 'PRF';
        }

        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();
        if ($ebs_trainingmode->value == 'On') {
            $invoiceType = 'TRN';
        }

        $arInvoice = [
            'invoiceCounter' => $requestId,
            'transactionType' => $ebs_transactionType->value,
            'personType' => $ebs_typeOfPerson->value,
            'invoiceTypeDesc' => $invoiceType,
            'currency' => $sales->currency,
            'invoiceIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
            'invoiceRefIdentifier' => $ebs_invoiceIdentifier->value.$requestId,
            'previousNoteHash' => 'prevNote',
            'reasonStated' => '',
            'totalVatAmount' => $sales->tax_amount,
            'totalAmtWoVatCur' => $sales->subtotal,
//            'totalAmtWoVatMur' => $sales->currency,
            'invoiceTotal' => $sales->amount,
//            'discountTotalAmount' => $sales->currency,
            'totalAmtPaid' => $total_paid,
            'dateTimeInvoiceIssued' => date('Ymd H:i:s'),
            "salesTransactions" => $sales_transaction,
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
            'itemList' => $data
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

        if((isset($responseFinalArray['status']) && $responseFinalArray['status'] == 404) ||
            isset($responseFinalArray['error']) && $responseFinalArray['error'] == 'Not Found' ||
            isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description']) &&
            str_contains('url', $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])
        ){
            $id_sales = $sales->id;
            $salesEbsResult = new SalesEBSResults();
            $salesEbsResult->responseId = $ebs_invoiceIdentifier->value.$requestId;
            $salesEbsResult->invoiceIdentifier = $ebs_invoiceIdentifier->value.$requestId;
            $salesEbsResult->requestId = $requestId;
            $salesEbsResult->status = 'Down';
            $salesEbsResult->errorMessages = 'Error in URL Transmit API';
            $salesEbsResult->jsonRequest = $jsonencode;
            $salesEbsResult->sale_id = $id_sales;
            $salesEbsResult->save();
            return true;
        }

        if (($responseFinalArray && !empty($responseFinalArray)) && (isset($responseFinalArray['requestId']) && $responseFinalArray['requestId']=! null)){
            //MRA key received from generate token
            $responseId = $responseFinalArray['responseId'];
            $requestId = $responseFinalArray['requestId'];
            $status = $responseFinalArray['status'];
            $infoMessages = $responseFinalArray['infoMessages'];
            $errorMessages = $responseFinalArray['errorMessages'];
            $id_sales = $sales->id;

            $salesEbsResult = new SalesEBSResults();
            $salesEbsResult->responseId = $responseId;
            $salesEbsResult->requestId = $requestId;
            $salesEbsResult->status = $status;
            $salesEbsResult->sale_id = $id_sales;
            $salesEbsResult->jsonRequest = $jsonencode;

            if(isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $salesEbsResult->infoMessages = $infoMessages[0]['code'].' ==> '.$infoMessages[0]['description'];
            if(isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $salesEbsResult->errorMessages = $errorMessages[0]['code'].' ==> '.$errorMessages[0]['description'];

            if(isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $salesEbsResult->invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $salesEbsResult->irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $salesEbsResult->qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if(isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $salesEbsResult->errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'].' ==> '.$responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];
            $salesEbsResult->save();

            return $responseFinalArray;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax_get_items_variations($id_product, $id_store)
    {
        $products = Products::find($id_product);
        if (empty($id_store)) {
            echo json_encode(['msg' => 'Undefined Store', 'error' => true]);
            die;
        }
        $product_variation = DB::table('product_variations')->select('product_variations.*')
            ->join('stocks', 'product_variations.id', '=', 'stocks.product_variation_id')
            ->where('product_variations.products_id', $id_product)
            ->where('stocks.store_id', $id_store)
            ->get();
        foreach ($product_variation as $key1 => $variation) {
            $variation = (array)$variation;
            $variation_value = json_decode($variation['variation_value']);

            $variation['variation_value'] = [];
            $variation['variation_value_text'] = "";
            if ($variation_value != NULL) {
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        if (!empty($attr->attribute_name) && !empty($attr_val->attribute_values))
                            $variation['variation_value'] = array_merge($variation['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);

                        //// transform text
                        if (!empty($attr->attribute_name) && !empty($attr_val->attribute_values)) {
                            if (!empty($variation['variation_value_text'])) {
                                $variation['variation_value_text'] = $variation['variation_value_text'] . " ," . $attr->attribute_name . ":" . $attr_val->attribute_values;
                            } else {
                                $variation['variation_value_text'] = $attr->attribute_name . ":" . $attr_val->attribute_values;
                            }
                        }
                    }
                }
            }

            $variation['stock_id'] = NULL;
            $variation['quantity_stock'] = '0';

            $existing_stock = DB::table('stocks')->select('*')
                ->where('products_id', '=', $id_product)
                ->where('store_id', '=', $id_store)
                ->where('product_variation_id', '=', $variation['id'])
                ->first();
            if ($existing_stock != NULL) {
                $variation['stock_id'] = $existing_stock->id;
                $variation['quantity_stock'] = $existing_stock->quantity_stock;
            }

            $variation = (object)$variation;
            $product_variation[$key1] = $variation;
        }

        $product_stock = DB::table('stocks')->select('*')
            ->where('products_id', '=', $id_product)
            ->where('store_id', '=', $id_store)
            ->whereNull('product_variation_id')
            ->first();
        if ($product_stock == null) {
            $product_stock = ["quantity_stock" => 0];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "product" => $products,
            "stock" => $product_stock,
            "variation" => $product_variation,
        ]);
        die;
    }

    protected function transform_date($date)
    {
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
            return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
    }

    public function increase($id)
    {
        $newsale = Cart::find($id);
        if (null === $newsale) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'msg' => 'Not found',
                'error' => true
            ]);
            die;
        }
        $data = [
            'quantity' => $newsale->quantity + 1
        ];
        $newsale->update($data);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'msg' => 'success',
            'qty' => $data['quantity'],
            'error' => false
        ]);
        die;
    }

    public function decrease($id)
    {
        $newsale = Cart::find($id);
        if (null === $newsale) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'msg' => 'Not found',
                'error' => true
            ]);
            die;
        }
        $data = [
            'quantity' => $newsale->quantity - 1
        ];
        $newsale->update($data);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'msg' => 'success',
            'qty' => $data['quantity'],
            'error' => false
        ]);
        die;
    }

    public function cart_update_qty($id, $qty)
    {
        $newsale = Cart::find($id);
        if (null === $newsale) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'msg' => 'Not found',
                'error' => true
            ]);
            die;
        }
        $data = [
            'quantity' => $qty
        ];
        $newsale->update($data);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'msg' => 'success',
            'qty' => $data['quantity'],
            'error' => false
        ]);
        die;
    }
}
