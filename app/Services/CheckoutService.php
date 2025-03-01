<?php

namespace App\Services;



use App\Models\BankInformation;
use App\Models\Cart;
use App\Models\Company;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\HomeCarousel;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\OnlineStockApi;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CheckoutService {

    public static function createJournalEntry($sales)
    {
        $count_journal = JournalEntry::count();
        $journal_id = $count_journal > 0 ? JournalEntry::max('journal_id') + 1 : 1;
        $date = $sales->created_at->format('Y-m-d');
        $name = 'Sales #' . $sales->id;
        $amount = $sales->amount;

        $ledger_debit = Ledger::firstOrCreate(['name' => 'Accounts Receivable'], ['id_ledger_group' => 0]);
        $ledger_credit = Ledger::firstOrCreate(['name' => 'Sales'], ['id_ledger_group' => 0]);

        JournalEntry::create([
            'id_order' => $sales->id,
            'debit' => $ledger_debit->id,
            'credit' => null,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        JournalEntry::create([
            'id_order' => $sales->id,
            'debit' => null,
            'credit' => $ledger_credit->id,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);
    }

    public static function generatePdfDocuments($sale_id)
    {
        PdfService::pdf_sale($sale_id);
        PdfService::pdf_invoice($sale_id);
        PdfService::pdf_delivery_note($sale_id);
    }

    public static function processStockApi($sales, $session_id, $store_id)
    {
        $api_enabled = Setting::where("key", "product_stock_from_api")->first();
        $online_stock_api = OnlineStockApi::latest()->first();

        $carts = Cart::where("session_id", $session_id)->get();

        foreach ($carts as $cart) {
            $line = Stock::where([
                ['products_id', $cart->product_id],
                ['store_id', $store_id],
                ['product_variation_id', $cart->product_variation_id ?? null],
            ])->first();

            $sales_products = Sales_products::create([
                'sales_id' => $sales->id,
                'product_id' => $cart->product_id,
                'product_variations_id' => $cart->product_variation_id,
                'order_price' => $cart->product_price,
                'quantity' => $cart->quantity,
                'product_name' => $cart->product_name,
                'tax_sale' => $cart->tax_sale,
                'have_stock_api' => $cart->have_stock_api,
                'product_unit' => null
            ]);

            if ($line && $api_enabled->value === "yes" && $online_stock_api && $line->barcode_value) {
                $login = $online_stock_api->username;
                $password = $online_stock_api->password;
                $url = $online_stock_api->url . 'api/stock/update?product_id=' . $cart->product_id;

                $stock = $line->stock - $cart->quantity;

                $response = Http::withBasicAuth($login, $password)
                    ->post($url, ['stock' => $stock]);

                if ($response->successful()) {
                    Stock::where([
                        ['products_id', $cart->product_id],
                        ['store_id', $store_id],
                        ['product_variation_id', $cart->product_variation_id ?? null],
                    ])->update(['stock' => $stock]);
                }
            }
        }
    }

    public static function emptyCart()
    {
        Cart::where("session_id", Session::get('session_id'))->delete();
    }

    public static function mcb_payement_view($id)
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children) {
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0) {
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child) {
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0) {
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];
        $sales = Sales::find($id);
        $sales_products = Sales_products::where("sales_id", $id)->get();
        $paymentMethode = PayementMethodSales::find($sales->payment_methode);
        $session_id = '';
        $session_indicator = '';
        $merchant = BankInformation::latest()->first();
        if ($sales->status != "Paid") {
            if ($paymentMethode && $paymentMethode->payment_method == 'Debit/Credit Card') {
                $setting_mcb_merchant_password = Setting::where('key', 'merchantPassword')->first();
                $id = $sales->id;
                $amount = $sales->amount;
                $merchantId = '0000022921';
                $password = '78dcf71a7baed14a0b09de74a19da24d';
                if ($merchant) {
                    $merchantId = $merchant->merchantID;
                    $password = $merchant->merchantPassword;
                }
                $redirectUrl = '/';

                $post_data = '{
                    "apiOperation": "INITIATE_CHECKOUT",
                    "interaction": {
                        "operation": "PURCHASE",
                        "displayControl": {
                            "billingAddress":  "HIDE",
                            "customerEmail":  "HIDE"
                        },
                        "returnUrl":  "' . route('save-mcb-payment', $sales->id) . '"
                    },
                    "order": {
                        "currency": "MUR",
                        "id": "' . $id . '",
                        "amount": ' . $amount . '
                    }
                }';

                $url = "https://fbn.gateway.mastercard.com/api/rest/version/63/merchant/" . $merchantId . "/session";

                $auth = 'merchant.' . $merchantId . ':' . $password;
                $credentials = base64_encode($auth);
                $authorization = 'Authorization: Basic ' . $credentials;

                // Prepare new cURL resource
                $crl = curl_init($url);
                curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($crl, CURLINFO_HEADER_OUT, true);
                curl_setopt($crl, CURLOPT_POST, true);
                curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

                // Set HTTP Header for POST request
                curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Authorization: Basic ' . $credentials)
                );

                // Submit the POST request
                $result = curl_exec($crl);

                // handle curl error
                //dd( $merchantId );
                if ($result === false) {
                    // throw new Exception('Curl error: ' . curl_error($crl));
                    //print_r('Curl error: ' . curl_error($crl));
                    // dd( $result );
                } else {
                    $result_tru = json_decode($result);
                    // dd( $result_tru->session->id );
                    if (!isset($result_tru->session->id) && !isset($result_tru->successIndicator)) {
                        echo $result;
                        die;
                    }
                    $session_id = $result_tru->session->id;
                    $session_indicator = $result_tru->successIndicator;

                }
                // Close cURL session handle
                curl_close($crl);
            }
        }

        $stores = Store::where('pickup_location', '=', 'yes')->get();

        $company = Company::latest()->first();
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        $store_name = "Shop Ecom";
        $shop_name_bd = Setting::where("key", "store_name_meta")->first();
        if (isset($shop_name_bd->key)) $store_name = $shop_name_bd->value;

        $store_address = "";
        $company = Company::latest()->first();
        if (isset($company->company_address)) $store_address = $company->company_address;
        return view('front.mcb_payement', compact(['headerMenuColor', 'headerMenus', 'sales',
            'sales_products', 'carts', 'stores', 'session_id', 'session_indicator', 'merchant', 'company', 'shop_favicon', 'store_name', 'store_address']));


    }

    public static function thankyou($id)
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children) {
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0) {
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child) {
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0) {
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];
        $sales = Sales::find($id);
        $sales_products = Sales_products::where("sales_id", $id)->get();
        $paymentMethode = PayementMethodSales::find($sales->payment_methode);
        $order_payment_method = PayementMethodSales::find($sales->payment_methode);
        $session_id = '';
        $session_indicator = '';
        $merchant = BankInformation::latest()->first();
        /* if($sales->status != "Paid"){
            if($paymentMethode && $paymentMethode->payment_method  == 'Debit/Credit Card'){
                $setting_mcb_merchant_password = Setting::where('key', 'merchantPassword')->first();
                $id = $sales->id;
                $amount  = $sales->amount;
                $merchantId = '0000022921';
                $password = '78dcf71a7baed14a0b09de74a19da24d';
                if($merchant) {
                    $merchantId = $merchant->merchantID;
                    $password = $merchant->merchantPassword;
                }
                $redirectUrl = '/';

                $post_data = '{
                    "apiOperation": "INITIATE_CHECKOUT",
                    "interaction": {
                        "operation": "PURCHASE",
                        "displayControl": {
                            "billingAddress":  "HIDE",
                            "customerEmail":  "HIDE"
                        }
                    },
                    "order": {
                        "currency": "MUR",
                        "id": "' . $id . '",
                        "amount": ' . $amount . '
                    }
                }';

                $url = "https://fbn.gateway.mastercard.com/api/rest/version/63/merchant/" . $merchantId . "/session";

                $auth = 'merchant.'. $merchantId . ':' . $password;
                $credentials = base64_encode($auth);
                $authorization = 'Authorization: Basic ' . $credentials;

                // Prepare new cURL resource
                $crl = curl_init($url);
                curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($crl, CURLINFO_HEADER_OUT, true);
                curl_setopt($crl, CURLOPT_POST, true);
                curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

                // Set HTTP Header for POST request
                curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $credentials)
                );

                // Submit the POST request
                $result = curl_exec($crl);

                // handle curl error
                //dd( $merchantId );
                if ($result === false) {
                    // throw new Exception('Curl error: ' . curl_error($crl));
                    //print_r('Curl error: ' . curl_error($crl));
                    // dd( $result );
                } else {
                    $result_tru = json_decode($result);
                    // dd( $result_tru->session->id );
                    if(!isset($result_tru->session->id) && !isset($result_tru->successIndicator)){
                        echo $result;die;
                    }
                    $session_id = $result_tru->session->id;
                    $session_indicator  = $result_tru->successIndicator;
                }
                // Close cURL session handle
                curl_close($crl);
            }
        }
 */
        $stores = Store::where('pickup_location', '=', 'yes')->get();

        $company = Company::latest()->first();
        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        return view('front.thankyou', compact(['headerMenuColor', 'headerMenus', 'sales',
            'sales_products', 'carts', 'stores', 'merchant', 'company', 'shop_favicon', 'order_payment_method',
            'shop_name', 'shop_description', 'code_added_header']));
    }
}


