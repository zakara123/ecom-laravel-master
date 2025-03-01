<?php

namespace App\Http\Controllers;

use App\Models\BankInformation;
use App\Models\Company;
use App\Models\OnlineStockApi;
use App\Models\PayementMethodSales;
use App\Models\Products;
use App\Models\ProductSettings;
use App\Models\SalesInvoiceCounter;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Email_smtp;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::latest()->orderBy('id', 'DESC')->paginate(10);
        $paymentMethodSales = PayementMethodSales::where('payment_method', '!=', 'Credit Note')->where('payment_method', '!=', 'Debit Note')->paginate(10);
        $company = Company::latest()->first();
        $email_smtp = Email_smtp::latest()->first();
        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $merchant = BankInformation::latest()->first();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $backoffice_order_mail = Setting::where("key", "send_backoffice_order_mail")->first();
        $onlineshop_order_mail = Setting::where("key", "send_onlineshop_order_mail")->first();
        $onlineshop_order_mail_admin = Setting::where("key", "send_onlineshop_order_mail_admin")->first();
        $backoffice_order_mail_admin = Setting::where("key", "send_backoffice_order_mail_admin")->first();
        $email_cc_admin = Setting::where("key", "email_cc_admin")->first();
        $email_bcc_admin = Setting::where("key", "email_bcc_admin")->first();
        $order_status_change_to_admin = Setting::where("key", "order_status_change_to_admin")->first();

        self::defaultMRAEbsSetting();

        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
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
        $ebs_vatType = Setting::where("key", "ebs_vatType")->first();
        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();
        $ebs_invoiceCounter = SalesInvoiceCounter::max('id');
        if ($ebs_invoiceCounter == null) $ebs_invoiceCounter = 0;

        $vatrate = Setting::where("key", "vatrate")->first();
        $vat_rate_setting = [];

        if (isset($vatrate->value) && $vatrate->value) {
            $vat_rate_explode = explode(",", $vatrate->value);
            foreach ($vat_rate_explode as $k => $vtv) {
                $value_vtv = $vtv;
                array_push($vat_rate_setting, trim($value_vtv));
            }
        }

        return view('settings.index', compact([
            'stores',
            'company',
            'paymentMethodSales',
            'email_smtp',
            'enable_online_shop',
            'merchant',
            'display_logo',
            'backoffice_order_mail',
            'onlineshop_order_mail',
            'ebs_mra_einvoincing',
            'email_cc_admin',
            'onlineshop_order_mail_admin',
            'backoffice_order_mail_admin',
            'order_status_change_to_admin',
            'email_bcc_admin',
            'ebs_typeOfPerson',
            'ebs_transactionType',
            'ebs_invoiceIdentifier',
            'ebs_invoiceTypeDesc',
            'ebs_mraId',
            'ebs_areaCode',
            'ebs_mraUsername',
            'ebs_mraPassword',
            'ebs_token_url',
            'ebs_transmit_url',
            'ebs_vatType',
            'ebs_trainingmode',
            'ebs_invoiceCounter',
            'vatrate',
            'vat_rate_setting'
        ]));
    }

    public function addUpdateEmailSmtp(Request $request)
    {
        $this->validate($request, [
            'smtp_username' => 'required',
            'smtp_username' => 'required'
        ]);

        if (empty($request->id)) {
            $email_smtp = Email_smtp::updateOrCreate([
                'username' => $request->smtp_username,
                'password' => $request->smtp_password
            ]);
        } else {
            $email_smtp = Email_smtp::find($request->id);
            $email_smtp->update([
                'username' => $request->smtp_username,
                'password' => $request->smtp_password
            ]);
        }


        return redirect()->back()->with('success', 'Email SMTP Settings updated Successfully');
    }

    public function addUpdateMCBConfiguration(Request $request)
    {
        $this->validate($request, [
            'merchantID' => 'required',
            'merchantPassword' => 'required'
        ]);
        $setting_bankinfo = null;
        if (isset($request->id_bankinfo)) $setting_bankinfo = BankInformation::find($request->id_bankinfo);


        if (!$setting_bankinfo) {
            BankInformation::updateOrCreate([
                'merchantID' => $request->merchantID,
                'merchantPassword' => $request->merchantPassword
            ]);
        } else {
            $setting_bankinfo->update([
                'merchantID' => $request->merchantID,
                'merchantPassword' => $request->merchantPassword
            ]);
        }

        return redirect()->back()->with('success', 'MCB Settings updated Successfully');
    }

    public function addUpdateVATRate(Request $request)
    {
        $stringRate = implode(',', $request->vatrate);
        $vatrate = Setting::where("key", "vatrate")->first();
        if (!$vatrate) {
            $set = Setting::updateOrCreate([
                'key' => 'vatrate',
                'value' => ' '
            ]);
        } else {
            $vatrate->update([
                'value' => $stringRate
            ]);
        }

        return redirect()->back()->with('success', 'VAT RATE Settings Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);


        Store::updateOrCreate([
            'name' => $request->stores,
            'pickup_location' => $request->pickup_location,
            'is_online' => $request->is_online,
            'is_default' => $request->is_default,
            'vat_type' => $request->vat_type,
        ]);
        // $category->save();

        return redirect()->route('settings.index')->with('messageStore', 'Store Created Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateCompany(Request $request, $id)
    {
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'tan' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        }

        ///check email
        /* $bool = $this->check_email_domain($request->company_email);
        if(!$bool){
            $host = $this->get_simple_host();
            return redirect()->route('settings.index')->with('error_message', 'Contact Email for General Queries should have same domain as current site, ex: xxxx@'.$host);
        } */
        $src = null;
        $company = Company::find($id);
        if ($request->has('company_logo')) {
            $image = $request->file('company_logo');

            $slug = self::transform_slug($request->company_name);
            $imageName = $slug . '-logo-' . time() . rand(1, 1000) . '.' . $image->extension();
            $image->move(public_path('files/logo'), $imageName);
            $src = '/files/logo/' . $imageName;
        } else $src = $company->logo;


        $company->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'brn_number' => $request->brn_number,
            'vat_number' => $request->vat_number,
            'tan' => $request->tan,
            'company_email' => $request->company_email,
            'order_email' => $request->order_email,
            'company_phone' => $request->company_phone,
            'company_fax' => $request->company_fax,
            'whatsapp_number' => $request->whatsapp_number,
            'logo' => $src
        ]);

        return redirect()->route('settings.index')->with('success', 'Company Updated Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function check_email_domain($email)
    {
        // Extract the domain from the email address
        $email_parts = explode('@', $email);

        // Ensure the email has a valid domain part
        if (count($email_parts) !== 2) {
            return false;
        }

        $email_domain = $email_parts[1];

        // Get the current server's host name
        $host = request()->getHttpHost();

        // Normalize both domains for comparison
        $normalized_email_domain = strtolower($email_domain);
        $normalized_host = strtolower($host);

        // Extract all possible subdomains, including the full host
        $host_parts = explode('.', $normalized_host);
        $possible_domains = [];
        for ($i = 0; $i <= count($host_parts) - 2; $i++) {
            $possible_domains[] = implode('.', array_slice($host_parts, $i));
        }
        $possible_domains[] = $normalized_host; // add the exact host domain as well

        // Check if the email's domain is any of the possible subdomains or the exact domain
        return in_array($normalized_email_domain, $possible_domains);
    }

    /*public function check_email_domain($email){

        $email_domain = explode('@',  $email);
        $email_domain = $email_domain[1];
        //echo $_SERVER['SERVER_NAME'];die;
        $host = request()->getHttpHost();
        //echo $host;die;
        $host_names = explode(".", $host);
        $bottom_host_name = $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1];
        if($bottom_host_name == $email_domain){
            return true;
        }else{
            return false;
        }
    }*/
    public function get_simple_host()
    {
        $host = request()->getHttpHost();
        //echo $host;die;
        $host_names = explode(".", $host);
        $bottom_host_name = $host_names[count($host_names) - 2] . "." . $host_names[count($host_names) - 1];
        return $bottom_host_name;
    }

    public function addCompany(Request $request)
    {
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'tan' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        }


        ///check email
        /* $bool = $this->check_email_domain($request->company_email);
        if(!$bool){
            $host = $this->get_simple_host();
            return redirect()->route('settings.index')->with('error_message', 'Contact Email for General Queries should have same domain as current site, ex: xxxx@'.$host);
        } */

        $src = null;

        if ($request->has('company_logo')) {
            $image = $request->file('company_logo');

            $slug = self::transform_slug($request->company_name);
            $imageName = $slug . '-logo-' . time() . rand(1, 1000) . '.' . $image->extension();
            $image->move(public_path('files/logo'), $imageName);
            $src = '/files/logo/' . $imageName;
        }

        Company::updateOrCreate([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'brn_number' => $request->brn_number,
            'vat_number' => $request->vat_number,
            'tan' => $request->tan,
            'company_email' => $request->company_email,
            'order_email' => $request->order_email,
            'company_phone' => $request->company_phone,
            'company_fax' => $request->company_fax,
            'whatsapp_number' => $request->whatsapp_number,
            'logo' => $src,
        ]);
        return redirect()->route('settings.index')->with('success', 'Company Created Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addPaymentMethodSales(Request $request)
    {

        $this->validate($request, [
            'payment_method' => 'required',

        ]);


        $slug = self::transform_slug($request->payment_method);

        $is_default = 'no';

        if (request()->has('is_default') === false) $is_default = 'no';
        else $is_default = 'yes';

        $is_on_bo_sales_order = 'yes';

        if (request()->has('is_on_bo_sales_order') === false) $is_on_bo_sales_order = 'no';
        else $is_on_bo_sales_order = 'yes';

        $is_on_online_shop_order = 'yes';

        if (request()->has('is_on_online_shop_order') === false) $is_on_online_shop_order = 'no';
        else $is_on_online_shop_order = 'yes';

        PayementMethodSales::updateOrCreate([
            'slug' => $slug,
            'payment_method' => $request->payment_method,
            'text_email' => $request->text_email,
            'text_email_before' => $request->text_email_before,
            'text_email_before_invoice' => $request->text_email_before_invoice,
            'text_email_after_invoice' => $request->text_email_after_invoice,
            'text_pdf_before' => $request->text_pdf_before,
            'text_pdf_after' => $request->text_pdf_after,
            'text_pdf_before_invoice' => $request->text_pdf_before_invoice,
            'text_pdf_after_invoice' => $request->text_pdf_after_invoice,
            'thankyou' => $request->thankyou,
            'failed' => $request->failed,
            'is_default' => $is_default,
            'is_on_bo_sales_order' => $is_on_bo_sales_order,
            'is_on_online_shop_order' => $is_on_online_shop_order

        ]);

        return redirect()->route('settings.index')->with('success', 'Payement Method Created Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentMethodSales(Request $request, $id)
    {
        //dd($request->payment_method);die;
        $this->validate($request, [
            'payment_method' => 'required',
            'credentials.entityId' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.clientId' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.clientSecret' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.merchantId' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.allowlistedDomain' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.authenticationEndpoint' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
            'credentials.checkoutEndpoint' => $request->payment_method == 'Peach Payment' ? 'required' : 'nullable',
        ]);


        $payementMethode = PayementMethodSales::find($id);

        $slug = self::transform_slug($request->payment_method);

        /* $is_on_bo_sales_order = 'yes';

        if(request()->has('is_on_bo_sales_order') === false) $is_on_bo_sales_order = 'no';
        else $is_on_bo_sales_order = 'yes';

        $is_on_online_shop_order = 'yes';

        if(request()->has('is_on_online_shop_order') === false) $is_on_online_shop_order = 'no';
        else $is_on_online_shop_order = 'yes'; */

        $payementMethode->update([
            'slug' => $slug,
            'payment_method' => $request->payment_method,
            'text_email' => $request->text_email,
            'text_email_before' => $request->text_email_before,
            'text_email_before_invoice' => $request->text_email_before_invoice,
            'text_email_after_invoice' => $request->text_email_after_invoice,
            'text_pdf_before' => $request->text_pdf_before,
            'text_pdf_after' => $request->text_pdf_after,
            'text_pdf_before_invoice' => $request->text_pdf_before_invoice,
            'text_pdf_after_invoice' => $request->text_pdf_after_invoice,
            'thankyou' => $request->thankyou,
            'failed' => $request->failed,
            /* ,
            'is_on_bo_sales_order'=> $is_on_bo_sales_order,
            'is_on_online_shop_order'=> $is_on_online_shop_order */
        ]);
        return redirect()->route('settings.index')->with('success', 'Payement Method updated Successfully');
    }

    public function updateIsOnlineInStore(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) abort(404);

        if (request()->has('is_online') === false) {
            $request->request->add(['is_online' => 'no']);
        } else $request->request->add(['is_online' => 'yes']);

        $store->update([
            'is_online' => $request->is_online
        ]);

        return redirect()->route('settings.index')->with('success', 'Store updated Successfully');
    }

    public function updateIsOnNewSalePage(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) abort(404);

        $type = 'error_message';
        $message = 'Error while updating store.';
        if ((int)$id == 1) {
            if ($store->is_on_newsale_page == 'no') {
                $store->update(['is_on_newsale_page' => 'yes']);
            }
            // because warehouse cannot be disabled
            $message = 'Default store cannot be disabled';
        } else {
            if (request()->has('is_on_newsale_page') === false) {
                $request->request->add(['is_on_newsale_page' => 'no']);
            } else $request->request->add(['is_on_newsale_page' => 'yes']);

            $store->update([
                'is_on_newsale_page' => $request->is_on_newsale_page
            ]);
            $type = 'success';
            $message = 'Store updated Successfully';
        }

        return redirect()->route('settings.index')->with($type, $message);
    }

    public function updatePickupLocation(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) abort(404);

        if (request()->has('pickup_location') === false) {
            $request->request->add(['pickup_location' => 'no']);
        } else $request->request->add(['pickup_location' => 'yes']);

        $store->update([
            'pickup_location' => $request->pickup_location
        ]);

        return redirect()->route('settings.index')->with('success', 'Pickup Location updated Successfully');
    }

    public function updateEnableOnlineShop(Request $request)
    {
        $onlineshop = Setting::find($request->id);

        if (!$onlineshop) {
            Setting::updateOrCreate([
                'key' => 'display_online_shop_product',
                'value' => 'no'
            ]);
        } else {
            if ($onlineshop->value == "yes") {
                $onlineshop->update([
                    'value' => "no"
                ]);
            } else {
                $onlineshop->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->route('settings.index')->with('success', 'Online Shop Setting updated Successfully');
    }


    public function updateDisplayLogoPdf()
    {
        $display = Setting::where("key", "display_logo_in_pdf")->first();

        if (!$display) {
            $set = Setting::updateOrCreate([
                'key' => 'display_logo_in_pdf',
                'value' => 'yes'
            ]);
        } else {
            if ($display->value == "yes") {
                $display->update([
                    'value' => "no"
                ]);
            } else {
                $display->update([
                    'value' => "yes"
                ]);
            }
        }

        /// return redirect()->back()->with('success', 'Setting Saved Successfully');
        header('Content-Type: application/json');
        echo json_encode([
            "msg" => "Operation success",
            "error" => false
        ]);
        die;
    }

    public function updateEnableProductStockFromApi(Request $request)
    {
        $fromapi = Setting::where("key", "product_stock_from_api")->first();

        if (!$fromapi) {
            $set = Setting::updateOrCreate([
                'key' => 'product_stock_from_api',
                'value' => 'yes'
            ]);
        } else {
            if ($fromapi->value == "yes") {
                $fromapi->update([
                    'value' => "no"
                ]);
            } else {
                $fromapi->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateSendBackofficeOrderMail(Request $request)
    {
        $send_email = Setting::where("key", "send_backoffice_order_mail")->first();

        if (!$send_email) {
            $set = Setting::updateOrCreate([
                'key' => 'send_backoffice_order_mail',
                'value' => 'yes'
            ]);
        } else {
            if ($send_email->value == "yes") {
                $send_email->update([
                    'value' => "no"
                ]);
            } else {
                $send_email->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateTrainingMode(Request $request)
    {
        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();

        if (!$ebs_trainingmode) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_trainingmode',
                'value' => 'Off'
            ]);
        } else {
            if ($ebs_trainingmode->value == "On") {
                $ebs_trainingmode->update([
                    'value' => "Off"
                ]);
            } else {
                $ebs_trainingmode->update([
                    'value' => "On"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateSendBackofficeOrderMailAdmin(Request $request)
    {
        $send_email = Setting::where("key", "send_backoffice_order_mail_admin")->first();

        if (!$send_email) {
            $set = Setting::updateOrCreate([
                'key' => 'send_backoffice_order_mail_admin',
                'value' => 'yes'
            ]);
        } else {
            if ($send_email->value == "yes") {
                $send_email->update([
                    'value' => "no"
                ]);
            } else {
                $send_email->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateOnlineshopOrderMail(Request $request)
    {
        $send_email = Setting::where("key", "send_onlineshop_order_mail")->first();

        if (!$send_email) {
            $set = Setting::updateOrCreate([
                'key' => 'send_onlineshop_order_mail',
                'value' => 'yes'
            ]);
        } else {
            if ($send_email->value == "yes") {
                $send_email->update([
                    'value' => "no"
                ]);
            } else {
                $send_email->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateOnlineshopOrderMailAdmin(Request $request)
    {
        $setting = Setting::where("key", "send_onlineshop_order_mail_admin")->first();

        if (!$setting) {
            $set = Setting::updateOrCreate([
                'key' => 'send_onlineshop_order_mail_admin',
                'value' => 'yes'
            ]);
        } else {
            if ($setting->value == "yes") {
                $setting->update([
                    'value' => "no"
                ]);
            } else {
                $setting->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateOrderStatusChangeToAdmin(Request $request)
    {
        $setting = Setting::where("key", "order_status_change_to_admin")->first();

        if (!$setting) {
            $set = Setting::updateOrCreate([
                'key' => 'order_status_change_to_admin',
                'value' => 'yes'
            ]);
        } else {
            if ($setting->value == "yes") {
                $setting->update([
                    'value' => "no"
                ]);
            } else {
                $setting->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updateEmailCcAdmin(Request $request)
    {
        $email_cc_admin = Setting::where("key", "email_cc_admin")->first();
        $email_bcc_admin = Setting::where("key", "email_bcc_admin")->first();

        if (!$email_cc_admin) {
            if (!empty($request->email_cc_admin)) {
                $set = Setting::updateOrCreate([
                    'key' => 'email_cc_admin',
                    'value' => $request->email_cc_admin
                ]);
            }
        } else {
            if (empty($request->email_cc_admin)) {
                $email_cc_admin->delete();
            } else {
                $email_cc_admin->update([
                    'value' => $request->email_cc_admin
                ]);
            }
        }

        if (!$email_bcc_admin) {
            if (!empty($request->email_bcc_admin)) {
                $set = Setting::updateOrCreate([
                    'key' => 'email_bcc_admin',
                    'value' => $request->email_bcc_admin
                ]);
            }
        } else {
            if (empty($request->email_bcc_admin)) {
                $email_bcc_admin->delete();
            } else {
                $email_bcc_admin->update([
                    'value' => $request->email_bcc_admin
                ]);
            }
        }

        $company = Company::orderBy('id', 'desc')->first();
        if (empty($company)) {
            $bool = $this->check_email_domain($request->order_email);
            if (!$bool) {
                $host = $this->get_simple_host();
                return redirect()->route('settings.index')->with('error_message', 'Sending Email field should have same domain as current site, ex: xxxx@' . $host);
            }
            Company::updateOrCreate([
                'company_name' => 'Shop Ecom',
                'company_address' => 'Mauritius',
                'brn_number' => '',
                'vat_number' => '',
                'tan' => '',
                'company_email' => '',
                'order_email' => $request->order_email,
                'company_phone' => '',
                'company_fax' => '',
                'whatsapp_number' => ''
            ]);
        } else {
            $bool = $this->check_email_domain($request->order_email);
            if (!$bool) {
                $host = $this->get_simple_host();
                return redirect()->route('settings.index')->with('error_message', 'Sending Email field should have same domain as current site, ex: xxxx@' . $host);
            }
            $company->update([
                'order_email' => $request->order_email
            ]);
        }

        return redirect()->back()->with('success', 'Email Admin Saved Successfully');
    }

    public function defaultMRAEbsSetting()
    {
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $ebs_transactionType = Setting::where("key", "ebs_transactionType")->first();
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_mraId = Setting::where("key", "ebs_mraId")->first();
        $areaCode = Setting::where("key", "ebs_areaCode")->first();
        $ebs_invoiceTypeDesc = Setting::where("key", "ebs_invoiceTypeDesc")->first();
        $ebsMraUsername = Setting::where("key", "ebs_mraUsername")->first();
        $ebsMraPassword = Setting::where("key", "ebs_mraPassword")->first();
        $ebs_token_url = Setting::where("key", "ebs_token_url")->first();
        $ebs_transmit_url = Setting::where("key", "ebs_transmit_url")->first();
        $ebs_vatType = Setting::where("key", "ebs_vatType")->first();
        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();
        $ebs_invoiceCounter = Setting::where("key", "ebs_invoiceCounter")->first();
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        $vatrate = Setting::where("key", "vatrate")->first();


        if (!$vatrate) {
            $set = Setting::updateOrCreate([
                'key' => 'vatrate',
                'value' => ' '
            ]);
        }

        if (!$ebs_mra_einvoincing) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_mra_einvoincing',
                'value' => 'Off'
            ]);
        }
        if (!$ebs_invoiceCounter) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_invoiceCounter',
                'value' => 1
            ]);
        }


        if (!$ebs_trainingmode) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_trainingmode',
                'value' => 'Off'
            ]);
        }
        if (!$ebs_typeOfPerson) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_typeOfPerson',
                'value' => 'NVTR'
            ]);
        }

        if (!$ebs_vatType) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_vatType',
                'value' => ''
            ]);
        }

        if (!$ebs_invoiceTypeDesc) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_invoiceTypeDesc',
                'value' => 'STD'
            ]);
        }

        if (!$ebs_transactionType) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_transactionType',
                'value' => 'B2C'
            ]);
        }

        if (!$ebs_invoiceIdentifier) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_invoiceIdentifier',
                'value' => ' '
            ]);
        }

        if (!$ebs_mraId) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraId',
                'value' => ' '
            ]);
        }

        if (!$areaCode) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_areaCode',
                'value' => ' '
            ]);
        }

        if (!$ebsMraUsername) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraUsername',
                'value' => ' '
            ]);
        }

        if (!$ebsMraPassword) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraPassword',
                'value' => ' '
            ]);
        }

        if (!$ebs_token_url) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_token_url',
                'value' => ' '
            ]);
        }

        if (!$ebs_transmit_url) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_transmit_url',
                'value' => ' '
            ]);
        }
    }

    public function updateMRAEbsSetting(Request $request)
    {

        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        $ebs_transactionType = Setting::where("key", "ebs_transactionType")->first();
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_mraId = Setting::where("key", "ebs_mraId")->first();
        $areaCode = Setting::where("key", "ebs_areaCode")->first();
        $ebs_invoiceTypeDesc = Setting::where("key", "ebs_invoiceTypeDesc")->first();
        $ebsMraUsername = Setting::where("key", "ebs_mraUsername")->first();
        $ebsMraPassword = Setting::where("key", "ebs_mraPassword")->first();
        $ebs_token_url = Setting::where("key", "ebs_token_url")->first();
        $ebs_transmit_url = Setting::where("key", "ebs_transmit_url")->first();
        $ebs_vatType = Setting::where("key", "ebs_vatType")->first();
        $ebs_trainingmode = Setting::where("key", "ebs_trainingmode")->first();
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();


        if (!$ebs_mra_einvoincing) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_mra_einvoincing',
                'value' => 'Off'
            ]);
        } else {
            if ($request->ebs_mra_einvoincing == "On") {
                $ebs_mra_einvoincing->update([
                    'value' => "On"
                ]);
            } else {
                $ebs_mra_einvoincing->update([
                    'value' => "Off"
                ]);
            }
        }

        if (!$ebs_trainingmode) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_trainingmode',
                'value' => 'Off'
            ]);
        } else {
            if ($request->ebs_trainingmode == "On") {
                $ebs_trainingmode->update([
                    'value' => "On"
                ]);
            } else {
                $ebs_trainingmode->update([
                    'value' => "Off"
                ]);
            }
        }


        if (!$ebs_typeOfPerson) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_typeOfPerson',
                'value' => $request->ebs_typeOfPerson
            ]);
        } else {
            $ebs_typeOfPerson->update([
                'value' => $request->ebs_typeOfPerson
            ]);
        }

        if (!$ebs_vatType) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_vatType',
                'value' => $request->vat_type
            ]);
        } else {
            $ebs_vatType->update([
                'value' => $request->vat_type
            ]);
        }

        if (!empty($request->ebs_typeOfPerson)) {
            $stores = Store::all();

            foreach ($stores as $store) {
                $store_store = Store::find($store->id);
                $store_store->update([
                    'vat_type'  => $request->vat_type,
                ]);
            }
            /*if ($request->ebs_typeOfPerson == 'VATR'){

            }else {

            }*/
        }

        if (!$ebs_invoiceTypeDesc) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_invoiceTypeDesc',
                'value' => $request->ebs_invoiceTypeDesc
            ]);
        } else {
            $ebs_invoiceTypeDesc->update([
                'value' => $request->ebs_invoiceTypeDesc
            ]);
        }

        if (!$ebs_transactionType) {
            $set = Setting::updateOrCreate([
                'key' => 'ebs_transactionType',
                'value' => $request->ebs_transactionType
            ]);
        } else {
            $ebs_transactionType->update([
                'value' => $request->ebs_transactionType
            ]);
        }

        if (!$ebs_invoiceIdentifier) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_invoiceIdentifier',
                'value' => $request->ebs_invoiceIdentifier
            ]);
        } else {

            $ebs_invoiceIdentifier->update([
                'value' => $request->ebs_invoiceIdentifier
            ]);
        }

        if (!$ebs_mraId) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraId',
                'value' => $request->ebs_mraId
            ]);
        } else {

            $ebs_mraId->update([
                'value' => $request->ebs_mraId
            ]);
        }

        if (!$areaCode) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_areaCode',
                'value' => $request->ebs_areaCode
            ]);
        } else {

            $areaCode->update([
                'value' => $request->ebs_areaCode
            ]);
        }

        if (!$ebsMraUsername) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraUsername',
                'value' => $request->ebs_mraUsername
            ]);
        } else {

            $ebsMraUsername->update([
                'value' => $request->ebs_mraUsername
            ]);
        }

        if (!$ebsMraPassword) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_mraPassword',
                'value' => $request->ebs_mraPassword
            ]);
        } else {

            $ebsMraPassword->update([
                'value' => $request->ebs_mraPassword
            ]);
        }

        if (!$ebs_token_url) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_token_url',
                'value' => $request->ebs_token_url
            ]);
        } else {

            $ebs_token_url->update([
                'value' => $request->ebs_token_url
            ]);
        }

        if (!$ebs_transmit_url) {

            $set = Setting::updateOrCreate([
                'key' => 'ebs_transmit_url',
                'value' => $request->ebs_transmit_url
            ]);
        } else {

            $ebs_transmit_url->update([
                'value' => $request->ebs_transmit_url
            ]);
        }


        $company = Company::orderBy('id', 'desc')->first();
        if (empty($company)) {
            Company::updateOrCreate([
                'company_name' => 'Shop Ecom',
                'company_address' => 'Mauritius',
                'brn_number' => '',
                'vat_number' => '',
                'tan' => '',
                'company_email' => '',
                'order_email' => $request->order_email,
                'company_phone' => '',
                'company_fax' => '',
                'whatsapp_number' => ''
            ]);
        }

        return redirect()->back()->with('success', 'MRA EBS Setting Saved Successfully');
    }

    public function updatePrivacyPolicy(Request $request)
    {
        $privacy_policy = Setting::where("key", "privacy_policy")->first();

        if (!$privacy_policy) {
            $set = Setting::updateOrCreate([
                'key' => 'privacy_policy',
                'value' => $request->privacy_policy
            ]);
        } else {
            $privacy_policy->update([
                'value' => $request->privacy_policy
            ]);
        }

        return redirect()->back()->with('success', 'Privacy Policy Saved Successfully');
    }

    public function updateReturnPolicy(Request $request)
    {
        $return_policy = Setting::where("key", "return_policy")->first();

        if (!$return_policy) {
            $set = Setting::updateOrCreate([
                'key' => 'return_policy',
                'value' => $request->return_policy
            ]);
        } else {
            $return_policy->update([
                'value' => $request->return_policy
            ]);
        }

        return redirect()->back()->with('success', 'Return Policy Saved Successfully');
    }

    public function updateTermsConditions(Request $request)
    {
        $terms_conditions = Setting::where("key", "terms_conditions")->first();

        if (!$terms_conditions) {
            $set = Setting::updateOrCreate([
                'key' => 'terms_conditions',
                'value' => $request->terms_conditions
            ]);
        } else {
            $terms_conditions->update([
                'value' => $request->terms_conditions
            ]);
        }

        return redirect()->back()->with('success', 'Terms and Conditions Saved Successfully');
    }

    public function updateCodeAddedHeader(Request $request)
    {
        $code_added_header = Setting::where("key", "code_added_header")->first();

        if (!$code_added_header) {
            $set = Setting::updateOrCreate([
                'key' => 'code_added_header',
                'value' => $request->code_added_header
            ]);
        } else {
            $code_added_header->update([
                'value' => $request->code_added_header
            ]);
        }

        return redirect()->back()->with('success', 'Code Added to Header of All Pages Saved Successfully');
    }

    public function updateCodeStickyHeader(Request $request)
    {
        $sticky_banner_header = Setting::where("key", "sticky_banner_header")->first();

        if (!$sticky_banner_header) {
            $set = Setting::updateOrCreate([
                'key' => 'sticky_banner_header',
                'value' => $request->sticky_banner_header
            ]);
        } else {
            $sticky_banner_header->update([
                'value' => $request->sticky_banner_header
            ]);
        }

        return redirect()->back()->with('success', 'Sticky Banner Code Added to Header of All Pages Saved Successfully');
    }

    public function updateEnableStockRequiredDisplayOnlineProduct(Request $request)
    {
        $stock_required = Setting::where("key", "stock_required_online_shop")->first();

        if (!$stock_required) {
            Setting::updateOrCreate([
                'key' => 'stock_required_online_shop',
                'value' => 'yes'
            ]);
        } else {
            if ($stock_required->value == "yes") {
                $stock_required->update([
                    'value' => "no"
                ]);
            } else {
                $stock_required->update([
                    'value' => "yes"
                ]);
            }
        }

        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }

    public function updatePaymentMethodSalesBOSales(Request $request, $id)
    {
        $payementMethode = PayementMethodSales::find($id);
        if (!$payementMethode) abort(404);

        $is_on_bo_sales_order = 'yes';

        if (request()->has('is_on_bo_sales_order') === false) $is_on_bo_sales_order = 'no';
        else $is_on_bo_sales_order = 'yes';

        $payementMethode->update([
            'is_on_bo_sales_order' => $is_on_bo_sales_order
        ]);

        return redirect()->route('settings.index')->with('success', 'Payement Method updated Successfully');
    }

    public function updatePaymentMethodSalesOnlineShop(Request $request, $id)
    {
        $payementMethode = PayementMethodSales::find($id);
        if (!$payementMethode) abort(404);

        $is_on_online_shop_order = 'yes';

        if (request()->has('is_on_online_shop_order') === false) $is_on_online_shop_order = 'no';
        else $is_on_online_shop_order = 'yes';

        $payementMethode->update([
            'is_on_online_shop_order' => $is_on_online_shop_order
        ]);

        return redirect()->route('settings.index')->with('success', 'Payement Method updated Successfully');
    }

    public function updateShopName(Request $request)
    {
        $this->validate($request, [
            'store_name_meta' => 'required'
        ]);
        $shop_name = Setting::where("key", "store_name_meta")->first();
        if (!$shop_name) {
            Setting::updateOrCreate([
                'key' => 'store_name_meta',
                'value' => $request->store_name_meta
            ]);
        } else {
            $shop_name->update([
                'value' => $request->store_name_meta
            ]);
        }
        return redirect()->back()->with('success', 'Shop Name Updated Successfully');
    }

    public function updateShopDescription(Request $request)
    {
        $this->validate($request, [
            'store_description_meta' => 'required'
        ]);
        $shop_description = Setting::where("key", "store_description_meta")->first();
        if (!$shop_description) {
            Setting::updateOrCreate([
                'key' => 'store_description_meta',
                'value' => $request->store_description_meta
            ]);
        } else {
            $shop_description->update([
                'value' => $request->store_description_meta
            ]);
        }
        return redirect()->back()->with('success', 'Shop Description Updated Successfully');
    }

    public function updateImageRequiredOnlineShop(Request $request)
    {
        $required = Setting::where("key", "image_required_for_product_onlineshop")->first();
        if (!$required) {
            Setting::updateOrCreate([
                'key' => 'image_required_for_product_onlineshop',
                'value' => 'yes'
            ]);
        } else {
            if ($required->value == "yes") {
                $required->update([
                    'value' => "no"
                ]);
            } else {
                $required->update([
                    'value' => "yes"
                ]);
            }
        }
        return redirect()->back()->with('success', 'Setting Updated Successfully');
    }

    public function updateShopMeta(Request $request)
    {
        $this->validate($request, [
            'store_name_meta' => 'required'
        ]);

        Setting::updateOrCreate(
            ['key' => 'store_theme'],
            ['value' => $request->store_theme]
        );

        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $shop_favicon = Setting::where("key", "store_favicon")->first();
        if (!$shop_name) {
            Setting::updateOrCreate([
                'key' => 'store_name_meta',
                'value' => $request->store_name_meta
            ]);
        } else {
            $shop_name->update([
                'value' => $request->store_name_meta
            ]);
        }
        if (!$shop_description) {
            $store_description_meta = $request->store_description_meta;
            if (empty($store_description_meta)) $store_description_meta = " ";
            Setting::updateOrCreate([
                'key' => 'store_description_meta',
                'value' => $store_description_meta
            ]);
        } else {
            $store_description_meta = $request->store_description_meta;
            if (empty($store_description_meta)) $store_description_meta = " ";
            $shop_description->update([
                'value' => $store_description_meta
            ]);
        }


        if (!$shop_favicon) {
            $shop_favicon_src = "";
            if ($request->has('store_favicon')) {
                $path = public_path('files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                $image = $request->file('store_favicon');
                $imageName = 'favicon-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()))), $imageName);
                $shop_favicon_src = '/files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $imageName;
            }
            if (empty($shop_favicon) && !empty($shop_favicon_src)) {
                Setting::updateOrCreate([
                    'key' => 'store_favicon',
                    'value' => $shop_favicon_src
                ]);
            }
        } else {
            $shop_favicon_src = "";
            if ($request->has('store_favicon')) {
                $path = public_path('files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $image = $request->file('store_favicon');
                $imageName = 'favicon-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()))), $imageName);
                $shop_favicon_src = '/files/favicon/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $imageName;
            }
            if (!empty($shop_favicon_src)) {
                $shop_favicon->update([
                    'value' => $shop_favicon_src
                ]);
            }
        }


        return redirect()->back()->with('success', 'Shop Updated Successfully');
    }

    public function updateEnableFilteringOnlineShop(Request $request)
    {
        $required = Setting::where("key", "filtered_required_for_product_onlineshop")->first();
        if (!$required) {
            Setting::updateOrCreate([
                'key' => 'filtered_required_for_product_onlineshop',
                'value' => 'yes'
            ]);
        } else {
            if ($required->value == "yes") {
                $required->update([
                    'value' => "no"
                ]);
            } else {
                $required->update([
                    'value' => "yes"
                ]);
            }
        }
        return redirect()->back()->with('success', 'Setting Updated Successfully');
    }

    public function onlineSettings()
    {
        $online_stock_api = OnlineStockApi::latest()->first();
        $stock = [];
        $product = [];
        if ($online_stock_api != NULL) {
            $login = $online_stock_api->username;
            $password = $online_stock_api->password;
            $url = $online_stock_api->api_url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $result = curl_exec($ch);
            curl_close($ch);
            $stock = json_decode($result);
            if (isset($stock->upc)) {
                $stock_line = Stock::where('barcode_value', $stock->upc)->latest()->first();
                if ($stock_line != NULL)
                    $product = Products::find($stock_line->products_id);
            }
        }
        $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
        $stock_required_online_shop = Setting::where("key", "stock_required_online_shop")->first();
        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $store_favicon = Setting::where("key", "store_favicon")->first();
        $image_required_for_product_onlineshop = Setting::where("key", "image_required_for_product_onlineshop")->first();
        $product_settings = ProductSettings::where('name', 'product_per_page')->first();
        $filtering = Setting::where("key", "filtered_required_for_product_onlineshop")->first();

        $privacy_policy = Setting::where("key", "privacy_policy")->first();
        $terms_conditions = Setting::where("key", "terms_conditions")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();
        $sticky_banner_header = Setting::where("key", "sticky_banner_header")->first();
        $return_policy = Setting::where("key", "return_policy")->first();
        $themes = [
            'default' => 'Default',
            'troketia' => 'Troketia',
            'care-connect' => 'Care Connect',
        ];
        $settings = Setting::get();
        return view('stock.online', compact(['themes', 'settings', 'online_stock_api', 'stock', 'product', 'product_stock_from_api', 'stock_required_online_shop', 'shop_name', 'shop_description', 'store_favicon', 'image_required_for_product_onlineshop', 'product_settings', 'filtering', 'privacy_policy', 'terms_conditions', 'code_added_header', 'sticky_banner_header', 'return_policy']));
    }

    protected function get_favicon_store()
    {
        $shop_favicon = url('front/img/ECOM_L.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        return $shop_favicon;
    }

    protected function get_favicon_store_fo()
    {
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        return $shop_favicon;
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
}
