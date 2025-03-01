<?php

namespace App\Http\Controllers;

use App\Exports\Export_Sales_detailed;
use App\Exports\Export_Sales_simples;

use App\Imports\SalesImport;


use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\BankInformation;
use App\Models\Cart;
use App\Models\Company;
use App\Models\CreditNote;
use App\Models\Customer;
use App\Models\DebitNoteSales;
use App\Models\Delivery;
use App\Models\Email_smtp;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\Newsale;
use App\Models\OnlineStockApi;
use App\Models\PayementMethodSales;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Rentals;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesEBSResults;
use App\Models\SalesFile;
use App\Models\SalesInvoiceCounter;
use App\Models\SalesPayments;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;
use PHPMailer\PHPMailer\PHPMailer;
use Session;
use Maatwebsite\Excel\Facades\Excel;


///for email


class SalesController extends Controller
{

    public $sales_id_c = 0;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;

        $loggedInUserId = Auth::User()->id;
        $loggedInUserRole = Auth::User()->role;  // Assuming 'role' is the field for user roles

        $sales = Sales::select('sales.*', 'payement_method_sales.payment_method')
            ->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
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
            ]);
        if ($loggedInUserRole != 'admin') {
            $sales->where('user_id', $loggedInUserId);
        }
        if (isset($request->type_sale)) {
            $sales->where('type_sale', $request->type_sale);
        }

        $sales = $sales->orderBy('sales.id', 'DESC')->paginate(10);

        if ($request->sale_id && $ss == '') {
            $ss = $request->sale_id;
            $sales = Sales::select('sales.*', 'payement_method_sales.payment_method')
                ->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
                ->where([
                    ['customer_firstname', '!=', Null],
                    [function ($query) use ($request) {
                        if (($sl = $request->sale_id)) {
                            $query->orWhere('id', '=', $sl)
                                ->get();
                        }
                    }]
                ]);
            if ($loggedInUserRole != 'admin') {
                $sales->where('user_id', $loggedInUserId);
            }
            if (isset($request->type_sale)) {
                $sales->where('type_sale', $request->type_sale);
            }
            $sales = $sales->orderBy('sales.id', 'DESC')->paginate(10);
        }

        $pageTitle = 'All Sales';
        if (isset($request->type_sale) && ($request->type_sale == 'BACK_OFFICE_SALE')) {
            $pageTitle = 'Back Office Sales';
        } elseif (isset($request->type_sale) && ($request->type_sale == 'ONLINE_SALE')) {
            $pageTitle = 'Online Sales';
        }

        $status = Sales::select('status')->distinct()->get();
        return view('sales.index', compact(['pageTitle', 'sales', 'ss', 'status']));
    }

    public function search(Request $request)
    {
        $ss = $fs = '';
        if ($request->s) $ss = $request->s;
        if ($request->fs) $fs = $request->fs;

        $sales = Sales::join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
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
            ])
            ->orderBy('sales.id', 'DESC')->paginate(10);

        if ($request->fs && $request->fs != 'all') {
            $sales = Sales::join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
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
                ])->where('status', '=', $fs)
                ->orderBy('sales.id', 'DESC')->paginate(10);
        }

        return view('sales.search_ajax', compact(['sales', 'ss', 'fs']));
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
        //
    }

    public function add_sale_files(Request $request)
    {
        $this->validate($request, [
            'sales_id' => 'required',
            'file_upload' => 'required',
        ]);

        $fileName = 'sale-id-' . $request->sales_id . '-' . $request->file('file_upload')->getClientOriginalName();

        $path = public_path('files/attachment/sales/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request->file('file_upload')->move(public_path($path), $fileName);

        $item_src = $path . '/' . $fileName;
        SalesFile::create([
            'sales_id' => $request->sales_id,
            'name' => $fileName,
            'type' => $request->document_type,
            'src' => $item_src,
            'date_generated' => date("Y-m-d H:i:s")
        ]);

        return redirect()->back()->with('success', 'File Attachment saved successfully!');
    }



    public function add_credit_note(Request $request)
    {
        $this->validate($request, [
            'sales_id' => 'required',
            'creditnote_date' => 'required',
            'amount' => 'required',
        ]);

        $sales_id = $request->sales_id;
        //        $date = date("Y-m-d H:i:s");
        $date = self::transform_date($request->creditnote_date);

        $sales = Sales::find($request->sales_id);
        if ($sales === NULL) abort(404);

        $amount_due = $sales->amount;

        $amount_paied = SalesPayments::where("sales_id", $request->sales_id)->sum('amount');
        $amount_credit = CreditNote::where("sales_id", $request->sales_id)->sum('amount');

        if ($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied = $amount_paied;

        if ($amount_credit == NULL) $amount_credit = 0;
        else $amount_credit = $amount_credit;

        $amount_paied = floatval($amount_paied);
        $amount_due = floatval($amount_due);
        $amount_credit = floatval($amount_credit);

        $amount_max = $amount_due;

        if ($sales->status == 'Paid') {
            $amount_paied = $amount_due - $amount_credit;
            $amount_due = 0;

            $amount_max = $amount_paied;
        } else {
            $amount_due = $amount_due - $amount_credit;
            $amount_max = $amount_due;
        }

        if (floatval($request->amount) > ($amount_max)) {
            return redirect()->back()->with('errors', 'Your amount is more than to amount due.');
        }

        $paymentMethodes = PayementMethodSales::where('payment_method', '=', 'Credit Note')->orderBy('id', 'DESC')->first();
        if (!$paymentMethodes) {
            $slug = self::transform_slug('Credit Note');
            $paymentMethodes = PayementMethodSales::create([
                'payment_method' =>  'Credit Note',
                'slug' => $slug,
                'is_on_bo_sales_order' => 'no',
                'is_on_online_shop_order' => 'no'
            ]);
        }


        $creditNote = CreditNote::create([
            'sales_id' => $sales_id,
            'date' => $date,
            'amount' => $request->amount,
            'reason' => $request->reason
        ]);

        $sales_payments = SalesPayments::create([
            'sales_id' => $request->sales_id,
            'payment_date' => $date,
            'payment_mode' => $paymentMethodes->id,
            'payment_reference' => $request->reason,
            'id_creditnote'  => $creditNote->id,
            'amount'  => $request->amount
        ]);

        $sales = Sales::find($sales_id);

        $newSales = Sales_products::where("sales_id", $sales_id)->get();

        $customer = Customer::find($sales->customer_id);

        self::mra_ebs_transaction($sales, $newSales, $customer, true, 'Credit Note', $creditNote->id, null);

        return redirect()->back()->with('success', 'Add credit note saved successfully!');
    }

    public function add_debit_note(Request $request)
    {
        $this->validate($request, [
            'sales_id' => 'required',
            'debitnote_date' => 'required',
            'amount' => 'required',
        ]);

        $sales_id = $request->sales_id;
        $date = self::transform_date($request->debitnote_date);

        $sales = Sales::find($request->sales_id);
        if ($sales === NULL) abort(404);

        $paymentMethodes = PayementMethodSales::where('payment_method', '=', 'Debit Note')->orderBy('id', 'DESC')->first();
        if (!$paymentMethodes) {
            $slug = self::transform_slug('Debit Note');
            $paymentMethodes = PayementMethodSales::create([
                'payment_method' =>  'Debit Note',
                'slug' => $slug,
                'is_on_bo_sales_order' => 'no',
                'is_on_online_shop_order' => 'no'
            ]);
        }


        $debitNote = DebitNoteSales::create([
            'sales_id' => $sales_id,
            'date' => $date,
            'amount' => $request->amount,
            'reason' => $request->reason
        ]);

        $sales_payments = SalesPayments::create([
            'sales_id' => $request->sales_id,
            'payment_date' => $date,
            'payment_mode' => $paymentMethodes->id,
            'payment_reference' => $request->reason,
            'id_debitnote'  => $debitNote->id,
            'amount'  => $request->amount
        ]);

        $sales = Sales::find($sales_id);

        $newSales = Sales_products::where("sales_id", $sales_id)->get();

        $customer = Customer::find($sales->customer_id);

        self::mra_ebs_transaction($sales, $newSales, $customer, true, 'Credit Note', null, $debitNote->id);

        return redirect()->back()->with('success', 'Add debit note saved successfully!');
    }

    public function mra_ebs_transaction($sales, $newSales, $customer, $paid, $typeDesc = 'Standard', $creditnote = null, $debitnote = null)
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
        $certPath = base_path() . '/public/PublicKey.crt';
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

        $requestId = 1;
        $invoiceCounter = new SalesInvoiceCounter();
        $invoiceCounter->sales_id = $sales->id;
        if ($debitnote) {
            $invoiceCounter->debitnote_id = $debitnote;
            $invoiceCounter->is_debitnote = 'yes';
        } elseif ($creditnote) {
            $invoiceCounter->creditnote_id = $creditnote;
            $invoiceCounter->is_creditnote = 'yes';
        } else {
            $invoiceCounter->is_sales = 'yes';
        }
        $invoiceCounter->save();

        $ebs_invoiceCounter = SalesInvoiceCounter::max('id');
        if ($ebs_invoiceCounter) {
            $requestId = $ebs_invoiceCounter;
        }

        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (!$ebs_mra_einvoincing) {
            return true;
        } else {
            if ($ebs_mra_einvoincing->value == 'Off') {
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

        if (!isset($responseArray['token']) || !$responseArray['token']) {
            if ($debitnote) {
                $salesEbsResult = DebitNoteSales::find($debitnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value . $requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            } elseif ($creditnote) {
                $salesEbsResult = CreditNote::find($creditnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value . $requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            }
        }

        $token = $responseArray['token'];

        $mraKey = $responseArray['key'];

        $company = Company::latest()->first();
        $buyer_name = '';
        if (!empty($customer->company_name)) {
            $buyer_name = $customer->company_name;
        } else {
            $firstname = $customer->firstname;
            $lastname = $customer->lastname;

            $buyer_name = $firstname . ' ' . $lastname;
        }


        $data = [];

        foreach ($newSales as $item) {
            /// get stock line stock id

            if ($item->discount != NULL) $item->discount = 0;

            $taxCode = 'TC05';
            $vatAmt = 0;
            $amtWoVatCur = $item->order_price;

            if ($item->tax_sale == 'VAT Exempt') {
                $taxCode = 'TC03';
            } elseif ($item->tax_sale == '15% VAT') {
                $taxCode = 'TC01';
                $amtWoVatCur = $item->order_price - (($item->order_price * (15 / 100)));
                $vatAmt = $item->order_price - $amtWoVatCur;
            } elseif ($item->tax_sale == 'Zero Rated') {
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
                'discount' => number_format((float)$item->discount, 2, '.', ''),
                'amtWoVatCur' => number_format((float)$amtWoVatCur, 2, '.', ''),
                'vatAmt' => number_format((float)$vatAmt, 2, '.', ''),
                'totalPrice' => number_format((float)$item->order_price * $item->quantity, 2, '.', '')
            ];
        }


        $sales_transaction = "CASH";
        $payment_slug = PayementMethodSales::find($sales->payment_methode);
        if ($payment_slug->payment_method == 'Debit/Credit Card') {
            $sales_transaction = "CARD";
        } elseif ($payment_slug->payment_method == 'Peach Payment') {
            $sales_transaction = "PEACH";
        } elseif ($payment_slug->payment_method == 'Credit Sale' || $payment_slug->payment_method == 'Credit Note') {
            $sales_transaction = "CREDIT";
        } elseif (str_contains($payment_slug->payment_method, 'Cheque')) {
            $sales_transaction = "CHEQUE";
        } elseif (str_contains($payment_slug->payment_method, 'Bank Transfer')) {
            $sales_transaction = "BNKTRANSFER";
        } elseif (str_contains($payment_slug->payment_method, 'Cash')) {
            $sales_transaction = "CASH";
        } else {
            $sales_transaction = "OTHER";
        }

        $total_paid = 0;
        if ($paid) {
            $total_paid = $sales->amount;
        }
        $ebs_typeOfPersonDesc = 'STD';
        if ($typeDesc == 'Credit Note') {
            $ebs_typeOfPersonDesc = 'CRN';
        } elseif ($typeDesc == 'Debit Note') {
            $ebs_typeOfPersonDesc = 'DRN';
        }

        $ebs_sales_date = date('Ymd H:i:s', strtotime(str_replace('/', '-', $sales->created_at)));

        $reason = "Return of product";
        if ($creditnote) {
            $cn = CreditNote::find($creditnote);
            $reason = $cn->reason;
        }
        if ($debitnote) {
            $dn = DebitNoteSales::find($debitnote);
            $reason = $dn->reason;
        }

        $b_tan = '';
        if ($customer->vat_customer) $b_tan = $customer->vat_customer;
        $b_brn = '';
        if ($customer->brn_customer) $b_brn = $customer->brn_customer;
        $b_adr = '';
        if ($customer->address1) $b_adr = $customer->address1;

        $arInvoice = [
            'invoiceCounter' => $requestId,
            'transactionType' => $ebs_transactionType->value,
            'personType' => $ebs_typeOfPerson->value,
            'invoiceTypeDesc' => $ebs_typeOfPersonDesc,
            'currency' => $sales->currency,
            'invoiceIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
            'invoiceRefIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
            'previousNoteHash' => 'prevNote',
            'reasonStated' => $reason,
            'totalVatAmount' => number_format((float)$sales->tax_amount, 2, '.', ''),
            'totalAmtWoVatCur' => number_format((float)$sales->subtotal, 2, '.', ''),
            'invoiceTotal' => number_format((float)$sales->amount, 2, '.', ''),
            'totalAmtPaid' => number_format((float)$total_paid, 2, '.', ''),
            'dateTimeInvoiceIssued' => $ebs_sales_date,
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

        if ((isset($responseFinalArray['status']) && $responseFinalArray['status'] == 404) ||
            isset($responseFinalArray['error']) && $responseFinalArray['error'] == 'Not Found' ||
            isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description']) &&
            str_contains('url', $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])
        ) {
            if ($debitnote) {
                $salesEbsResult = DebitNoteSales::find($debitnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value . $requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'jsonRequest' => $jsonencode,
                        'errorMessages' =>  'Error in URL Transmit API',

                    ]
                );
                return true;
            } elseif ($creditnote) {
                $salesEbsResult = CreditNote::find($creditnote);
                $salesEbsResult->update(
                    [
                        'responseId' => $ebs_invoiceIdentifier->value . $requestId,
                        'invoiceIdentifier' => $ebs_invoiceIdentifier->value . $requestId,
                        'requestId' => $requestId,
                        'status' => 'Down',
                        'jsonRequest' => $jsonencode,
                        'errorMessages' =>  'Error in Url Generate token'
                    ]
                );
                return true;
            }
        }

        //MRA key received from generate token
        $responseId = $responseFinalArray['responseId'];
        $requestId = $responseFinalArray['requestId'];
        $status = $responseFinalArray['status'];
        $infoMessages = $responseFinalArray['infoMessages'];
        $errorMessages = $responseFinalArray['errorMessages'];
        $id_sales = $sales->id;
        $qrCode = $irn = $invoiceIdentifier = null;

        if ($creditnote) {
            $salesEbsResult = CreditNote::find($creditnote);
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'] . ' ==> ' . $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];

            if (isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $infoMessages = $infoMessages[0]['code'] . ' ==> ' . $infoMessages[0]['description'];
            if (isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $errorMessages = $errorMessages[0]['code'] . ' ==> ' . $errorMessages[0]['description'];

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
        } elseif ($debitnote) {
            $salesEbsResult = DebitNoteSales::find($debitnote);
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'] . ' ==> ' . $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];

            if (isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $infoMessages = $infoMessages[0]['code'] . ' ==> ' . $infoMessages[0]['description'];
            if (isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $errorMessages = $errorMessages[0]['code'] . ' ==> ' . $errorMessages[0]['description'];

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
        } else {
            $salesEbsResult = new SalesEBSResults();
            $salesEbsResult->sale_id = $id_sales;
            $salesEbsResult->responseId = $responseId;
            $salesEbsResult->requestId = $requestId;
            $salesEbsResult->status = $status;
            $salesEbsResult->jsonRequest = $jsonencode;
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'])) $salesEbsResult->invoiceIdentifier = $responseFinalArray['fiscalisedInvoices'][0]['invoiceIdentifier'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['irn'])) $salesEbsResult->irn = $responseFinalArray['fiscalisedInvoices'][0]['irn'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['qrCode'])) $salesEbsResult->qrCode = $responseFinalArray['fiscalisedInvoices'][0]['qrCode'];
            if (isset($responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'])) $salesEbsResult->errorMessages = $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['code'] . ' ==> ' . $responseFinalArray['fiscalisedInvoices'][0]['errorMessages'][0]['description'];
            if (isset($infoMessages[0]['description']) && $infoMessages[0]['description']) $salesEbsResult->infoMessages = $infoMessages[0]['code'] . ' ==> ' . $infoMessages[0]['description'];
            if (isset($errorMessages[0]['description']) && $errorMessages[0]['description']) $salesEbsResult->errorMessages = $errorMessages[0]['code'] . ' ==> ' . $errorMessages[0]['description'];

            $salesEbsResult->save();
        }
        return $responseFinalArray;
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


    public function destroy_salesfile(Request $request, $id)
    {
        $file = SalesFile::find($id);
        //unlink($file->src);
        $file->delete();
        return redirect()->back()->with('success', 'File Attachment deleted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Sales $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Sales $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sales $sales
     * @return \Illuminate\Http\Response
     */


     public function update_customer(Request $request, $id)
     {
         $sales = Sales::findOrFail($id);

         // Validate email uniqueness across both users and customers tables
         $request->validate([
             'email' => [
                 'required',
                 'email',
                 function ($attribute, $value, $fail) use ($sales) {
                     $customer = Customer::find($sales->customer_id);
                     $userExists = DB::table('users')
                         ->where('email', $value)
                         ->when($customer, fn($q) => $q->whereNot('id', $customer->user_id))
                         ->exists();

                     $customerExists = DB::table('customers')
                         ->where('email', $value)
                         ->when($customer, fn($q) => $q->whereNot('id', $customer->id))
                         ->exists();

                     if ($userExists || $customerExists) {
                         $fail('The email has already been taken.');
                     }
                 }
             ],
             'firstname' => 'required|string|max:255',
             'lastname' => 'required|string|max:255',
             'company_name' => 'nullable|string|max:255',
             'brn_customer' => 'nullable|string|max:255',
             'vat_customer' => 'nullable|string|max:255',
             'mobile_no' => 'required|string|max:20',
             'address1' => 'required|string|max:255',
             'address2' => 'nullable|string|max:255',
             'city' => 'required|string|max:255',
             'phone' => 'nullable|string|max:20',
             'password' => 'nullable|string|min:6'
         ]);

         // If customer_id is 1, create a new customer
         if ($sales->customer_id == 1) {
             $customer = Customer::create([
                 'company_name' => $request->company_name,
                 'firstname' => $request->firstname,
                 'lastname' => $request->lastname,
                 'brn_customer' => $request->brn_customer,
                 'vat_customer' => $request->vat_customer,
                 'mobile_no' => $request->mobile_no,
                 'address1' => $request->address1,
                 'address2' => $request->address2,
                 'city' => $request->city,
                 'email' => $request->email,
                 'phone' => $request->phone,
             ]);
         } else {
             $customer = Customer::findOrFail($sales->customer_id);
             $customer->update($request->only([
                 'company_name', 'firstname', 'lastname', 'brn_customer', 'vat_customer',
                 'mobile_no', 'address1', 'address2', 'city', 'email', 'phone'
             ]));
         }

         // Handle User (linked to customer)
         if (!$customer->user_id) {
             $user = User::create([
                 'name' => "{$request->firstname} {$request->lastname}",
                 'email' => $request->email,
                 'password' => Hash::make($request->password ?? 'password'),
                 'role' => 'customer',
             ]);
             $customer->update(['user_id' => $user->id]);
         } else {
             $user = User::find($customer->user_id);
             if ($user) {
                 $user->update([
                     'name' => "{$request->firstname} {$request->lastname}",
                     'email' => $request->email
                 ]);
             }
         }

         // Update Sales record
         $sales->update([
             'customer_firstname' => $request->firstname,
             'customer_lastname' => $request->lastname,
             'customer_address' => $request->address1 . ($request->address2 ? ' ' . $request->address2 : ''),
             'customer_city' => $request->city,
             'customer_email' => $request->email,
             'customer_phone' => $request->phone,
             'customer_id' => $customer->id,
         ]);

         return redirect()->back()->with('message', 'Customer Updated Successfully');
     }


    public function update_order_reference(Request $request, $id)
    {
        $sales = Sales::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "order_reference" => $request->order_reference,
        ]);

        $this->pdf_sale($id);
        $this->pdf_invoice($id);
        $this->pdf_delivery_note($id);

        return redirect()->route('detail-sale', $id)->with('success', 'Order Reference Updated successfully!');
    }

    public function deduct_stock($id_sale)
    {
        $sales = Sales::find($id_sale);
        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach ($sales_products as $item) {
            /// get stock line stock id
            $line = NULL;
            $stock_id = NULL;

            if ($item->product_id != "-1") {
                if (empty($item->product_variations_id)) {
                    $line = Stock::where('products_id', $item->product_id)
                        ->where('store_id', $sales->id_store)
                        ->whereNull('product_variation_id')
                        ->first();
                } else {
                    $line = Stock::where('products_id', $item->product_id)
                        ->where('store_id', $sales->id_store)
                        ->where('product_variation_id', $item->product_variations_id)
                        ->first();
                }
            }

            if ($line != NULL) $stock_id = $line->id;

            if ($item->product_id != "-1") {
                if ($line != NULL) {
                    $quantity_old = $line->quantity_stock;

                    $update_stock = $line->update([
                        'quantity_stock' => floatval($quantity_old) - floatval($item->quantity),
                    ]);

                    /// detect last stock history
                    $last_history = Stock_history::where('stock_id', $stock_id)
                        ->get()
                        ->last();

                    $quantity_previous = 0;
                    $quantity_current = floatval($item->quantity);

                    if ($last_history != NULL) {
                        $quantity_previous = $last_history->quantity_current;
                        $quantity_current = $quantity_previous - $quantity_current;
                    } else {
                        $quantity_previous = $quantity_old;
                        $quantity_current = floatval($quantity_old) - floatval($item->quantity);
                    }

                    /// add to stock history
                    $add_history = Stock_history::updateOrCreate([
                        'stock_id' => $stock_id,
                        'type_history' => "Deduct Stock",
                        'quantity' => $item->quantity,
                        'quantity_previous' => $quantity_previous,
                        'quantity_current' => $quantity_current,
                        'sales_id' => $id_sale
                    ]);
                }
            }
        }
    }

    public function reverse_deduct_stock($id_sale)
    {
        $sales = Sales::find($id_sale);
        $sales_products = Sales_products::where("sales_id", $id_sale)->get();
        foreach ($sales_products as $item) {
            /// get stock line stock id
            $line = NULL;
            $stock_id = NULL;

            if ($item->product_id != "-1") {
                if (empty($item->product_variations_id)) {
                    $line = Stock::where('products_id', $item->product_id)
                        ->where('store_id', $sales->id_store)
                        ->whereNull('product_variation_id')
                        ->first();
                } else {
                    $line = Stock::where('products_id', $item->product_id)
                        ->where('store_id', $sales->id_store)
                        ->where('product_variation_id', $item->product_variations_id)
                        ->first();
                }
            }

            if ($line != NULL) $stock_id = $line->id;

            if ($item->product_id != "-1") {
                if ($line != NULL) {
                    $quantity_old = $line->quantity_stock;

                    $update_stock = $line->update([
                        'quantity_stock' => floatval($quantity_old) + floatval($item->quantity),
                    ]);

                    /// detect last stock history
                    $last_history = Stock_history::where('stock_id', $stock_id)
                        ->get()
                        ->last();

                    $quantity_previous = 0;
                    $quantity_current = floatval($item->quantity);

                    if ($last_history != NULL) {
                        $quantity_previous = $last_history->quantity_current;
                        $quantity_current = $quantity_previous - $quantity_current;
                    } else {
                        $quantity_previous = $quantity_old;
                        $quantity_current = floatval($quantity_old) - floatval($item->quantity);
                    }

                    /// add to stock history
                    $add_history = Stock_history::updateOrCreate([
                        'stock_id' => $stock_id,
                        'type_history' => "Order cancelled, revert Deducted Stock",
                        'quantity' => $item->quantity,
                        'quantity_previous' => $quantity_previous,
                        'quantity_current' => $quantity_current,
                        'sales_id' => $id_sale
                    ]);
                }
            }
        }
    }

    public function update_payment_method(Request $request, $id)
    {
        $this->validate($request, [
            'payment_method' => 'required'
        ]);

        $sales = Sales::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "payment_methode" => $request->payment_method,
        ]);

        return redirect()->route('detail-sale', $id)->with('success', 'Payment Mode updated successfully!');
    }

    public function update_rental_date(Request $request, $id)
    {
        $this->validate($request, [
            'rental_start_date' => 'required'
        ]);

        $sales = Rentals::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "rental_start_date" => $request->rental_start_date,
            "rental_end_date" => $request->rental_end_date,
        ]);

        return redirect()->route('detail-rental', $id)->with('success', 'Rental Date updated successfully!');
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'status' => 'required'
        ]);

        $sales = Sales::find($id);
        $amount_paied = SalesPayments::where("sales_id", $id)->sum('amount');



        // dd($sales->amount,$amount_paied);

        if ($sales->amount < $amount_paied) {

            if (!$sales) abort(404);

            $old_status = $sales->status;

            $sales->update([
                "status" => $request->status,
            ]);



            ///payment method
            $paymentMethode = PayementMethodSales::find($sales->payment_methode);

            if ($paymentMethode->payment_method != "Credit Sale") {
                if ($request->status == "Paid" && $old_status != "Paid") {
                    $this->deduct_stock($id);
                }

                if ($request->status == "Cancelled" && $old_status == "Paid") {
                    $this->reverse_deduct_stock($id);
                }
            }

            if ($request->status != "Draft" && $old_status == "Draft") {
                $salesp = Sales::find($id);
                $newSales = Sales_products::where("sales_id", $id)->get();
                $customers = Customer::find($salesp->customer_id);
                if ($request->status == 'Paid') self::mra_ebs_transaction($salesp, $newSales, $customers, true, 'Standard', null, null);
                if ($request->status != 'Paid') self::mra_ebs_transaction($salesp, $newSales, $customers, false, 'Standard', null, null);
            }

            $order_status_change_to_admin = Setting::where("key", "order_status_change_to_admin")->first();
            if (isset($order_status_change_to_admin->value) && $order_status_change_to_admin->value == "yes") {
                if ($request->status == "Paid") $this->send_paid_mail($id);
            }

            if ($request->status == "Paid") {




                /// don't take in considaration product_stock_from_api because check is done while issued the order
                $online_stock_api = OnlineStockApi::latest()->first();
                if (!is_null($online_stock_api)) {
                    $login = $online_stock_api->username;
                    $password = $online_stock_api->password;
                    $sales_products = Sales_products::where("sales_id", $id)->get();
                    foreach ($sales_products as $item) {
                        if ($item->have_stock_api == "yes" && !empty($item->barcode)) {
                            $bool = $this->make_transfer($id, $login, $password, $item->quantity, $item->barcode);
                        }
                    }
                }

                //     $payment_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $sales->created_at)));
                //     $sales_payments = SalesPayments::updateOrCreate([
                //         'sales_id' => $sales->id,
                //         'payment_date' => $payment_date,
                //         'payment_mode' => $sales->payment_methode,
                //         'payment_reference' => $sales->order_reference,
                //         'amount'  => $sales->amount
                //     ]);
            }

            // if ($request->status == "Pending Payment"  or $request->status == "Cancelled") {
            //     $sales_payment = SalesPayments::where('sales_id', $sales->id)->delete();
            // }


            $this->pdf_sale($id);
            $this->pdf_invoice($id);
            $this->pdf_delivery_note($id);
            return redirect()->route('detail-sale', $id)->with('success', 'Status updated successfully!');
        } else {
            return redirect()->route('detail-sale', $id)->with('error_message', 'Amount still due. Please add payment to clear amount due.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Sales $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }

    public function saveFrontSale(Request $request)
    {
        // dd($request->all());
        if ($request->isMethod('post')) {
            $data = $request->all();
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                return redirect()->back()->with('error_message', 'Cart is empty! Please select products')->withInput();
            }
            $carts = Cart::where("session_id", $session_id)->get();
            if (count($carts) == 0) {
                return redirect()->back()->with('error_message', 'Cart is empty! Please select products')->withInput();
            }

            if (isset($data['pickup_or_delivery'])) {
                if ($data['pickup_or_delivery'] == "Pickup") {
                    if (empty($data['store_pickup'])) {
                        return redirect()->back()->with('error_message', 'Pickup Store is empty, you must select a store to pickup your order.')->withInput();
                    }
                    if (empty($data['pickup_date'])) {
                        return redirect()->back()->with('error_message', 'Pickup Date is empty, you must select a date.')->withInput();
                    }
                }

                if ($data['pickup_or_delivery'] == "Delivery") {
                    if (empty($data['delivery_method'])) {
                        return redirect()->back()->with('error_message', 'Delivery Method is empty, you must select a way to demivery your order.')->withInput();
                    }
                }
            }

            ///check customer
            $customer = Customer::firstWhere("email", $data['email']);

            if (empty($customer)) {
                $user = User::firstWhere("email", $data['email']);

                $this->validate($request, [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'email' => 'email|unique:customers',
                    /* 'phone' => 'digits:10', */
                ]);
                $customer = Customer::updateOrCreate([
                    'name' => $data['firstname'] . ' ' . $data['lastname'],
                    'company_name' => $data['firstname'] . ' ' . $data['lastname'],
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'address1' => $data['address1'],
                    'address2' => $data['address2'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'city' => $data['city'],
                    'country' => $data['country'],
                    'fax' => NULL,
                    'brn_customer' => NULL,
                    'vat_customer' => NULL,
                    'note_customer' => NULL,
                    'temp_password' => NULL
                ]);

                if (!empty($data['create_account']) && !empty($data['email'])) {
                    ///check customer on user table
                    if ($user === null) {
                        $password = $data['password'] ? $data['password'] : "123456789";
                        $user = User::updateOrCreate([
                            'name' => $data['firstname'] . " " . $data['lastname'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'login' => $data['email'],
                            'role' => "customer",
                            'password' => Hash::make($password),
                        ]);
                    }
                    $customer->user_id = $user->id;
                }
                $customer->save();
            }

            $id_store_pickup = NULL;
            $store_pickup = NULL;
            $date_pickup = NULL;
            $id_delivery = NULL;
            $delivery_name = NULL;
            $delivery_fee = 0;
            $delivery_vat = "VAT Exempt";

            if (isset($data['pickup_or_delivery'])) {
                if ($data['pickup_or_delivery'] == "Pickup") {
                    $store = Store::find($data['store_pickup']);
                    if ($store) {
                        $id_store_pickup = $data['store_pickup'];
                        $store_pickup = $store->name;
                        $date_pickup = self::transform_date($data['pickup_date']);
                    }
                }

                if ($data['pickup_or_delivery'] == "Delivery") {
                    $delivery = Delivery::find($data['delivery_method']);
                    if ($delivery) {
                        $id_delivery = $data['delivery_method'];
                        $delivery_name = $delivery->delivery_name;
                        $delivery_fee = $delivery->delivery_fee;
                        if (isset($delivery->vat) && !empty($delivery->vat)) $delivery_vat = $delivery->vat;
                    }
                }
            }

            $address2 = "";
            if (isset($data['address2']) && !empty($data['address2'])) $address2 = ", " . $data['address2'];

            $pickup_or_delivery = NULL;
            if (isset($data['pickup_or_delivery']) && !empty($data['pickup_or_delivery'])) $pickup_or_delivery = $data['pickup_or_delivery'];

            $sales = new Sales([
                'amount' => $data['amount'],
                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['vat_amount'],
                'currency' => "MUR",
                'status' => "Pending Payment",
                'order_reference' => "",
                'user_id' => $customer->user_id,
                'customer_id' => $customer->id,
                'customer_firstname' => $data['firstname'],
                'customer_lastname' => $data['lastname'],
                'customer_address' => $data['address1'] . $address2,
                'customer_city' => $data['city'] . " " . $data['country'],
                'customer_email' => $data['email'],
                'customer_phone' => $data['phone'],
                'comment' => $data['comment'],
                'tax_items' => $data['tax_items'],
                'internal_note' => "",
                'id_store' => $data['id_store'],
                'payment_methode' => $data['payment_methode'],
                'pickup_or_delivery' => $pickup_or_delivery,
                'id_store_pickup' => $id_store_pickup,
                'store_pickup' => $store_pickup,
                'date_pickup' => $date_pickup,
                'id_delivery' => $id_delivery,
                'delivery_name' => $delivery_name,
                'delivery_fee' => $delivery_fee,
                'delivery_fee_tax' => $delivery_vat,
                'type_sale' => 'ONLINE_SALE'

            ]);

            $sales->save();
            $id_sale = $sales->id;
            $this->sales_id_c = $sales->id;

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

            $this->pdf_sale($id_sale);
            $this->pdf_invoice($id_sale);
            $this->pdf_delivery_note($id_sale);

            ///Stock API
            $api_enabled = Setting::where("key", "product_stock_from_api")->first();
            $online_stock_api = OnlineStockApi::latest()->first();

            foreach ($carts as $cart) {
                /// get stock line stock id
                $line = NULL;
                $stock_id = NULL;

                if (empty($cart->product_variation_id)) {
                    $line = Stock::where('products_id', $cart->product_id)
                        ->where('store_id', $data['id_store'])
                        ->whereNull('product_variation_id')
                        ->first();
                } else {
                    $line = Stock::where('products_id', $cart->product_id)
                        ->where('store_id', $data['id_store'])
                        ->where('product_variation_id', $cart->product_variation_id)
                        ->first();
                }

                if ($line != NULL) $stock_id = $line->id;

                $sales_products = new Sales_products([
                    'sales_id' => $id_sale,
                    'product_id' => $cart->product_id,
                    'product_variations_id' => $cart->product_variation_id,
                    'order_price' => $cart->product_price,
                    'quantity' => $cart->quantity,
                    'product_name' => $cart->product_name,
                    'tax_sale' => $cart->tax_sale,
                    'have_stock_api' => $cart->have_stock_api,
                    'product_unit' => NULL
                ]);

                if ($line != NULL) {
                    /* $quantity_old = $line->quantity_stock;

                    $update_stock = $line->update([
                        'quantity_stock' => floatval($quantity_old) - floatval($cart->quantity),
                    ]);

                    /// detect last stock history
                    $last_history = Stock_history::where('stock_id', $stock_id)
                        ->get()
                        ->last();

                    $quantity_previous = 0;
                    $quantity_current = floatval($cart->quantity);

                    if ($last_history != NULL) {
                        $quantity_previous = $last_history->quantity_current;
                        $quantity_current = $quantity_previous - $quantity_current;
                    } else {
                        $quantity_previous = $quantity_old;
                        $quantity_current = floatval($quantity_old) - floatval($cart->quantity);
                    }

                    /// add to stock history
                    $add_history = Stock_history::updateOrCreate([
                        'stock_id' => $stock_id,
                        'type_history' => "Deduct Stock",
                        'quantity' => $cart->quantity,
                        'quantity_previous' => $quantity_previous,
                        'quantity_current' => $quantity_current,
                        'sales_id' => $id_sale
                    ]); */

                    /// API stock transfer
                    if (isset($api_enabled->value) && $api_enabled->value == "yes") {
                        if (!is_null($online_stock_api) && !empty($line->barcode_value)) {
                            $login = $online_stock_api->username;
                            $password = $online_stock_api->password;
                            $url = $online_stock_api->api_url . $line->barcode_value;
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
                            $result = curl_exec($ch);
                            curl_close($ch);
                            $stock_api_loc = json_decode($result);
                            if (isset($stock_api_loc->stock)) {
                                ///$bool = $this->make_transfer($id_sale, $login, $password, $cart->quantity, $line->barcode_value);
                                $sales_products->barcode = $line->barcode_value;
                            }
                        }
                    }
                } /* else {///  else stock don't exists, should add a new stock level?

                    $stock = Stock::updateOrCreate([
                        'products_id' => $cart->product_id,
                        'store_id' => $data['id_store'],
                        'product_variation_id' => $cart->product_variation_id,
                        'quantity_stock' => -$cart->quantity,
                        'date_received' => date('Y-m-d'),
                        'barcode_value' => $cart->product_id . $cart->product_variation_id . ""
                    ]);

                    /// add to stock history
                    $add_history = Stock_history::updateOrCreate([
                        'stock_id' => $stock->id,
                        'type_history' => "Deduct Stock",
                        'quantity' => $cart->quantity,
                        'quantity_previous' => 0,
                        'quantity_current' => -$cart->quantity,
                        'sales_id' => $id_sale
                    ]);
                } */

                $sales_products->save();
            }


            /// empty cart

            $paymentMethode = PayementMethodSales::find($sales->payment_methode);

            ///if setting OnlineshopOrderMail enabled
            $onlineshop_order_mail = Setting::where("key", "send_onlineshop_order_mail")->first();
            $onlineshop_order_mail_admin = Setting::where("key", "send_onlineshop_order_mail_admin")->first();
            if ((isset($onlineshop_order_mail->value) && $onlineshop_order_mail->value == "yes") || (isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == "yes")) {
                ///send email
                if ($paymentMethode && ($paymentMethode->payment_method != 'Debit/Credit Card' || $paymentMethode->payment_method != 'Peach Payment'))
                    $send_mail = $this->send_email($id_sale, "");
            }

            //return redirect()->back()->with('success','Sale sent successfully!');

            if ($paymentMethode && $paymentMethode->payment_method == 'Debit/Credit Card') {
                return $this->mcb_payement_view($id_sale);
            } else if ($paymentMethode && $paymentMethode->payment_method == 'Peach Payment') {
                return $this->peach_payement_view($id_sale);
            } else {
                $this->emptyCart();
                return $this->thankyou($id_sale);
            }
            //

        }
    }

    public function make_transfer($id_sale, $login, $password, $quantity, $barcode)
    {
        $url = "https://my.posterita.com/function?name=stock-transfer&domain=BataRetail";
        $data = array("order_no" => $id_sale, "lines" => [array("upc" => $barcode, "qty" => intval($quantity)),], "old_location" => "Warehouse", "new_location" => "Online Store");

        $postdata = json_encode($data);

        $ch_post = curl_init($url);
        curl_setopt($ch_post, CURLOPT_POST, 1);
        curl_setopt($ch_post, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch_post, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch_post, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch_post, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_post, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result_post = curl_exec($ch_post);

        curl_close($ch_post);
        $this->pdf_sale($id_sale);
        $this->pdf_invoice($id_sale);
        $this->pdf_delivery_note($id_sale);
        return true;
    }

    public function mcb_payment($id)
    {
        $sales = Sales::find($id);
        if ($sales === NULL) abort(404);

        $sales->update([
            "status" => "Paid",
        ]);

        /// deduct stock
        $this->deduct_stock($id);

        $this->send_paid_mail($id);

        /// don't take in considaration product_stock_from_api because check is done while issued the order
        $online_stock_api = OnlineStockApi::latest()->first();
        if (!is_null($online_stock_api)) {
            $login = $online_stock_api->username;
            $password = $online_stock_api->password;
            $sales_products = Sales_products::where("sales_id", $id)->get();
            foreach ($sales_products as $item) {
                if ($item->have_stock_api == "yes" && !empty($item->barcode)) {
                    $bool = $this->make_transfer($id, $login, $password, $item->quantity, $item->barcode);
                }
            }
        }

        $payment_date = date("Y-m-d");
        SalesPayments::updateOrCreate([
            'sales_id' => $sales->id,
            'payment_date' => $payment_date,
            'payment_mode' => $sales->payment_methode,
            'payment_reference' => "#" . $sales->id,
            'amount' => $sales->amount
        ]);
        $this->emptyCart();

        return $this->thankyou($sales->id);
    }

    public function peach_payement_view($id)
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
        $amount =  $sales->amount;
        $merchantTransactionId = 'INV-000000' . $sales->id;
        $currency = 'MUR';
        $nonce = (string) rand(100000, 999999);
        $shopperResultUrl =  route('save-peach-payment', $sales->id);

        $peach  = new PeachPaymentController();
        $req = new Request([
            'amount' => $amount,
            'currency' => $currency,
            'merchantTransactionId' => $merchantTransactionId,
            'nonce' => $nonce,
            'shopperResultUrl' => $shopperResultUrl,
        ]);
        $response = $peach->processPayment($req);
        $data = json_encode($response->getData(true));
        return view('peach.view', compact([
            'headerMenuColor',
            'headerMenus',
            'sales',
            'data',
            'sales_products',
            'carts',
            'stores',
            'company',
            'shop_favicon',
            'store_name',
            'store_address'
        ]));
    }
    public function mcb_payement_view($id)
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
                curl_setopt(
                    $crl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Authorization: Basic ' . $credentials
                    )
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
        return view('front.mcb_payement', compact([
            'headerMenuColor',
            'headerMenus',
            'sales',
            'sales_products',
            'carts',
            'stores',
            'session_id',
            'session_indicator',
            'merchant',
            'company',
            'shop_favicon',
            'store_name',
            'store_address'
        ]));
    }

    public function emptyCart()
    {
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {
            $res = Cart::where('session_id', $session_id)->delete();
        }
    }

    public function details($id)
    {
        $sales = Sales::find($id);
        // dd($sales);
        if ($sales === NULL) abort(404);
        $store = Store::find($sales->id_store);
        $salesEbs = SalesEBSResults::where("sale_id", $id)->get();
        $sales_products = Sales_products::where("sales_id", $id)->get();
        $sales_payments = SalesPayments::where("sales_id", $id)->get();
        $sales_files = SalesFile::where("sales_id", $id)->get();
        $show_stock_transfer = "no";
        $have_sale_type = "no";


        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sales->currency == "MUR") {
                $sales->amount = $sales->amount - $sales->tax_amount;
            } else {
                $sales->amount = $sales->amount - $sales->tax_amount;
                $sales->amount_converted = $sales->amount_converted - $sales->tax_amount;
            }
        }

        foreach ($sales_products as &$item) {
            $variation = NULL;
            $variation_value_final = $variation_value_text = [];
            if (!empty($item->product_variations_id)) {
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                        $variation_value_text[] = $attribute . ": " . $value;
                    }
                }

                $line = NULL;
                if ($item->product_id != "-1") {
                    if (empty($item->product_variations_id)) {
                        $line = Stock::where('products_id', $item->product_id)
                            ->where('store_id', $sales->id_store)
                            ->whereNull('product_variation_id')
                            ->first();
                    } else {
                        $line = Stock::where('products_id', $item->product_id)
                            ->where('store_id', $sales->id_store)
                            ->where('product_variation_id', $item->product_variations_id)
                            ->first();
                    }
                }
                if ($line != NULL) $item->sku = $line->sku;
                else  $item->sku = NULL;
            }
            $item->variation = $variation;
            $item->variation_value = $variation_value_final;
            $item->variation_value_text = implode(' | ', $variation_value_text);

            $item->product = Products::find($item->product_id);

            if (isset($item->have_stock_api) && $item->have_stock_api == "yes" && !empty($item->barcode)) $show_stock_transfer = "yes";
            if (!empty($item->sales_type)) $have_sale_type = "yes";
        }
        $path = public_path('/pdf/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $this->pdf_sale($id);
        $this->pdf_invoice($id);
        $this->pdf_delivery_note($id);
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));
        $order_payment_method = PayementMethodSales::find($sales->payment_methode);
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        foreach ($sales_payments as &$payment) {
            $payment->payment_method = PayementMethodSales::find($payment->payment_mode);
            $counterInvoicePayment = '';
            if ($payment->id_creditnote) {
                $cred_note = CreditNote::find($payment->id_creditnote);
                if (isset($cred_note->jsonRequest)) $payment->jsoncreditnote = $cred_note->jsonRequest;
                else $payment->jsoncreditnote = ' ';

                $ebs_invoiceCounterCreditNote = SalesInvoiceCounter::where('sales_id', $sales->id)->where('creditnote_id', $payment->id_creditnote)->where('is_creditnote', 'yes')->max('id');
                if ($ebs_invoiceCounterCreditNote) {
                    $counterInvoicePayment = $ebs_invoiceCounterCreditNote;
                }
            }

            if ($payment->id_debitnote) {
                $deb_note = DebitNoteSales::find($payment->id_debitnote);
                if (isset($deb_note->jsonRequest)) $payment->jsondebitnote = $deb_note->jsonRequest;
                else $payment->jsondebitnote = ' ';

                $ebs_invoiceCounterDebitNote = SalesInvoiceCounter::where('sales_id', $sales->id)->where('debitnote_id', $payment->id_debitnote)->where('is_debitnote', 'yes')->max('id');
                if ($ebs_invoiceCounterDebitNote) {
                    $counterInvoicePayment = $ebs_invoiceCounterDebitNote;
                }
            }
            $payment->counterInvoicePayment = $counterInvoicePayment;
        }

        $amount_due = $sales->amount;

        $amount_paied = SalesPayments::where("sales_id", $id)->sum('amount');
        $amount_credit = CreditNote::where("sales_id", $id)->sum('amount');
        $amount_debit = DebitNoteSales::where("sales_id", $id)->sum('amount');

        if ($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied = $amount_paied;

        if ($amount_credit == NULL) $amount_credit = 0;


        if ($amount_debit == NULL) $amount_debit = 0;


        $amount_paied = floatval($amount_paied);
        $amount_due = floatval($amount_due);
        $amount_credit = floatval($amount_credit);
        $amount_debit = floatval($amount_debit);

        $amount_max = $amount_due;

        if ($sales->status == 'Paid') {
            if ($amount_paied && $amount_credit) $amount_due = $amount_due - $amount_credit;
            elseif ($amount_paied) $amount_due = $amount_due - $amount_paied;

            if ($amount_paied && $amount_credit) $amount_paied -= $amount_paied;

            $amount_max = $amount_paied;
        } else {
            if ($amount_paied && $amount_credit) $amount_due = $amount_due - $amount_credit;
            elseif ($amount_paied) $amount_due = $amount_due - $amount_paied;

            if ($amount_paied && $amount_credit) $amount_paied -= $amount_paied;

            $amount_max = $amount_due;
        }

        $ledgers = Ledger::orderBy('name', 'ASC')->get();

        $journals = JournalEntry::where('id_order', '=', $id)
            ->where('is_pettycash', '=', 0)
            ->whereNull(['banking', 'credit_card'])
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'ASC')
            ->paginate(8);

        foreach ($journals as &$journal) {
            $journal_get_all_info = JournalEntry::where('journal_id', '=', $journal->journal_id)->get();
            if (count($journal_get_all_info) > 0) {
                $debit_ = $credit_ = '';
                $debit_id = $credit_id = '';
                foreach ($journal_get_all_info as $jgal) {
                    if ($jgal->debit) {
                        $debit_ = $jgal->debit;
                        $debit_id = $jgal->id;
                    }
                    if ($jgal->credit) {
                        $credit_ = $jgal->credit;
                        $credit_id = $jgal->id;
                    }
                }
                $journal->debit_c = $debit_;
                $journal->credit_c = $credit_;
                $journal->credit_id = $credit_id;
                $journal->debit_id = $debit_id;
            }


            if ($journal->debit) {
                $debit = Ledger::find($journal->debit);
                if ($debit)
                    $journal->debit_name = $debit->name;
            }
            if ($journal->credit) {
                $credit = Ledger::find($journal->credit);
                if ($credit)
                    $journal->credit_name = $credit->name;
            }
        }

        $has_typeInvoicSTD = $has_typeInvoicPRF = false;

        if ($salesEbs) {
            foreach ($salesEbs as $sebs) {
                $jdecod = json_decode($sebs->jsonRequest);
                if (isset($jdecod[0]->invoiceTypeDesc)) {
                    if ($jdecod[0]->invoiceTypeDesc == 'STD') {
                        $sebs->labelModal = 'std';
                        $has_typeInvoicSTD = true;
                    }
                    if ($jdecod[0]->invoiceTypeDesc == 'PRF') {
                        $has_typeInvoicPRF = true;
                        $sebs->labelModal = 'prf';
                    }
                } else {
                    $sebs->labelModal = '';
                }
            }
        }
        $customer = Customer::where('id', $sales->customer_id)->orderBy('id', 'ASC')->first();
        $ref_invoice = 0;

        $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id', $sales->id)->where('is_sales', 'yes')->max('id');
        if ($ebs_invoiceCounter) {
            $ref_invoice = $ebs_invoiceCounter;
        }

        $sales->invoiceCounter = $ref_invoice;

        $previous = Sales::where('id', '<', $id)->orderBy('id', 'DESC')->limit(1)->first();
        $next = Sales::where('id', '>', $id)->orderBy('id', 'ASC')->limit(1)->first();

        $vatrate = Setting::where("key", "vatrate")->first();
        $vat_rate_setting = [];

        if (isset($vatrate->value) && $vatrate->value) {
            $vat_rate_explode = explode(",", $vatrate->value);
            foreach ($vat_rate_explode as $k => $vtv) {
                $value_vtv = $vtv;
                if (!str_contains($value_vtv, '%')) $value_vtv .= '%';
                if (!str_contains($value_vtv, 'VAT')) $value_vtv .= ' VAT';
                if (!empty(trim($vtv)) && trim($vtv) !== null) array_push($vat_rate_setting, trim($value_vtv));
            }
        }


        return view('sales.details', compact([
            'ebs_typeOfPerson',
            'customer',
            'sales',
            'salesEbs',
            'pdf_src',
            'ledgers',
            'journals',
            'sales_products',
            'store',
            'order_payment_method',
            'has_typeInvoicSTD',
            'has_typeInvoicPRF',
            'vat_rate_setting',
            'payment_mode',
            'sales_payments',
            'amount_due',
            'amount_paied',
            'amount_credit',
            'amount_debit',
            'amount_max',
            'show_stock_transfer',
            'sales_files',
            'previous',
            'next',
            'have_sale_type'
        ]));
    }

    public function attachment($id_sale)
    {
        $company = Company::latest()->first();

        $sales = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        return view("pdf.attachment", compact('company', 'sales', 'sales_products'));
    }

    public function pdf_sale($id_sale)
    {

        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach ($sales_products as &$item) {
            if (!empty($item->product_variations_id)) {
                $variation_value_final = [];
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sale->currency == "MUR") {
                $sale->amount = $sale->amount - $sale->tax_amount;
            } else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }
        }

        $pdf = PDF::loadView('pdf.sale_proforma', compact('ebs_typeOfPerson', 'company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/proforma-sales-' . $id_sale . '.pdf', $pdf->output());


        $pdf = PDF::loadView('pdf.sale', compact('ebs_typeOfPerson', 'company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/invoice-' . $id_sale . '.pdf', $pdf->output());
    }

    public function pdf_invoice($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $vat_type = "No VAT";
        if ($sale->tax_items == "Included in the price") $vat_type = "Included";
        if ($sale->tax_items == "Added to the price") $vat_type = "Added";

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        foreach ($sales_products as &$item) {
            if (!empty($item->product_variations_id)) {
                $variation_value_final = [];
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $salesEbs = SalesEBSResults::where("sale_id", $id_sale)->get();
        $has_typeInvoicSTD = $has_typeInvoicPRF = false;
        $label_typeInvoicSTD = '';
        $label_typeInvoicPRF = '';
        if ($salesEbs) {
            foreach ($salesEbs as $sebs) {
                $jdecod = json_decode($sebs->jsonRequest);
                if (isset($jdecod[0]->invoiceTypeDesc)) {
                    if ($jdecod[0]->invoiceTypeDesc == 'STD') {
                        $label_typeInvoicSTD = $sebs->qrCode;
                        $has_typeInvoicSTD = true;
                    }
                    if ($jdecod[0]->invoiceTypeDesc == 'PRF') {
                        $has_typeInvoicPRF = true;
                        $label_typeInvoicPRF = $sebs->qrCode;
                    }
                } else {
                    $sebs->labelModal = '';
                }
            }
        }


        $name_invoice = 'invoice-proforma-';
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sale->currency == "MUR") {
                $sale->amount = $sale->amount - $sale->tax_amount;
            } else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }
        }


        $pdf = PDF::loadView('pdf.invoice_proforma', compact('ebs_typeOfPerson', 'salesEbs', 'has_typeInvoicPRF', 'label_typeInvoicPRF', 'company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $name_invoice . $id_sale . '.pdf', $pdf->output());

        $name_invoice = 'invoice-';
        $ref_invoice = '';
        $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();
        $ebs_invoiceCounter = SalesInvoiceCounter::where('sales_id', $id_sale)->where('is_sales', 'yes')->max('id');

        if ($ebs_invoiceIdentifier->value == 'Todaydate') {
            if ($ebs_invoiceCounter) {
                $ref_invoice = date('Ymd', strtotime($sale->created_at)) . '-' . $ebs_invoiceCounter;
            }
        } else {
            $ref_invoice = $ebs_invoiceIdentifier->value . '-' . $ebs_invoiceCounter;
            $ref_invoice = $ebs_invoiceIdentifier->value   ? $ebs_invoiceIdentifier->value . '-' . $ebs_invoiceCounter : $ebs_invoiceCounter;
        }


        // dd





        $pdf = PDF::loadView('pdf.invoice', compact('ebs_typeOfPerson', 'salesEbs', 'label_typeInvoicSTD', 'has_typeInvoicSTD', 'company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type', 'ref_invoice'));
        $pdf_invoicess = Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $name_invoice . $id_sale . '.pdf', $pdf->output());
        if ($ebs_invoiceCounter) $pdf_invoicess = Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $name_invoice . $ebs_invoiceCounter . '.pdf', $pdf->output());

        return $pdf_invoicess;
    }

    public function pdf_delivery_note($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sale->currency == "MUR") {
                $sale->amount = $sale->amount - $sale->tax_amount;
            } else {
                $sale->amount = $sale->amount - $sale->tax_amount;
                $sale->amount_converted = $sale->amount_converted - $sale->tax_amount;
            }
        }
        $pdf = PDF::loadView('pdf.delivery_note', compact('ebs_typeOfPerson', 'company', 'sale', 'sales_products', 'display_logo'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/delivery-note-' . $id_sale . '.pdf', $pdf->output());
    }

    public function resend_email($sales_id)
    {
        $sales = Sales::find($sales_id);
        if ($sales === NULL) return false;

        if ($sales->status == "Pending Payment") $this->send_email($sales_id, "");
        if ($sales->status == "Draft") $this->send_email($sales_id, "");
        if ($sales->status == "Paid") $this->send_paid_mail($sales_id);

        return redirect()->back()->with('success', 'Email resent successfully!');
    }

    public function send_email($sales_id, $text_before_order = "")
    {
        ////SMTP settings
        $email_smtp = Email_smtp::latest()->first();
        $smtp_username = "emailapikey";
        $smtp_password = "wSsVR610/xOlB6ooyTT8LrtuzwwEDwikFRh40VqovyL+F/rE8sc9lhWdU1WgHKIcGDFgFmcVoegtmBoE1GYNjYsvmVoECyiF9mqRe1U4J3x17qnvhDzDWG1alBOML4IKxghtk2RiEcgq+g==";
        if ($email_smtp != NULL) {
            $smtp_username = $email_smtp->username;
            $smtp_password = $email_smtp->password;
        }

        $date_resent_mail_sale = date('Y-m-d H:i:s');
        $date_resent_mail_invoice = date('Y-m-d H:i:s');

        $sales = Sales::find($sales_id);

        if ($sales === NULL) return false;

        $sales->update([
            "date_resent_mail_sale" => $date_resent_mail_sale,
            "date_resent_mail_invoice" => $date_resent_mail_invoice
        ]);

        ///Payment Mode + text email before and after
        $payment_mode = PayementMethodSales::find($sales->payment_methode);

        //// sales products + product variations
        $sales_products = Sales_products::where("sales_id", $sales_id)->get();
        foreach ($sales_products as &$item) {
            $variation = NULL;
            $variation_value_final = [];
            if (!empty($item->product_variations_id)) {
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
            }
            /* $item->variation = $variation; */
            $item->variation_value = $variation_value_final;
        }

        ///text before order set by user when resent mail
        if (!empty($text_before_order)) $text_before_order = "<br><br>" . $text_before_order;

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
            if (!empty($company->company_address)) $company_address = "<br>" . $company->company_address;
            else $company_address = "";
            if (!empty($company->company_email)) $company_email = "<br>" . $company->company_email;
            else $company_email = "";
            if (!empty($company->company_phone)) $company_phone = "<br>" . $company->company_phone;
            else $company_phone = "";
            if (!empty($company->company_fax)) $company_fax = "<br>FAX: " . $company->company_fax;
            else $company_fax = "";
            if (!empty($company->brn_number)) $brn_number = "<br>BRN: " . $company->brn_number;
            else $brn_number = "";
            if (!empty($company->vat_number)) $vat_number = "VAT: " . $company->vat_number;
            else $vat_number = "";
        }

        if (!empty($brn_number) && !empty($vat_number)) {
            $brn_number = $brn_number . " | " . $vat_number;
            $vat_number = "";
        }

        ///Store
        $store = Store::find($sales->id_store);

        /// about customer
        $customer_name = "";
        $customer_address = "";
        $customer_city = "";
        $customer_email = "";
        $customer_phone = "";

        ///must set
        $customer_name = $sales->customer_firstname . " " . $sales->customer_lastname;
        if (!empty($sales->customer_address)) $customer_address = "<br>" . $sales->customer_address;
        if (!empty($sales->customer_city)) $customer_city = "<br>" . $sales->customer_city;
        if (!empty($sales->customer_email)) $customer_email = "<br>" . $sales->customer_email;
        if (!empty($sales->customer_phone)) $customer_phone = "<br>" . $sales->customer_phone;

        ///text email before and after
        $text_email_before = "";
        $text_email_after = "";
        $text_pdf_before = "";
        $text_pdf_after = "";
        if (!empty($payment_mode->text_email_before)) {
            $text_email_before = "<br>" . $payment_mode->text_email_before;
        }
        if (!empty($payment_mode->text_email)) {
            $text_email_after = "<br>" . $payment_mode->text_email;
        }
        if (!empty($payment_mode->text_pdf_before)) {
            $text_pdf_before = "<br>" . $payment_mode->text_pdf_before;
        }
        if (!empty($payment_mode->text_pdf_after)) {
            $text_pdf_after = "<br>" . $payment_mode->text_pdf_after;
        }

        //Type of person
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sales->currency == "MUR") {
                $sales->amount = $sales->amount - $sales->tax_amount;
            } else {
                $sales->amount = $sales->amount - $sales->tax_amount;
                $sales->amount_converted = $sales->amount_converted - $sales->tax_amount;
            }
        }

        ///html item list
        $my_items_list = '<div class="my_table">
		<table style="width:100%;">
			<tr>
			<th>Items</th>
			<th>Unit Price (Rs)</th>
			<th>Quantity</th>';
        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list .= '<th>VAT</th>';
        }

        $my_items_list .= '
			<th>Amount (Rs)</th>
			</tr>';
        foreach ($sales_products as $item) {
            /// item unit label
            $unit_label = '';
            if (!empty($item->product_unit))
                $unit_label = ' / ' . $item->product_unit;

            /// amount with VAT calculation
            $amount = number_format(floatval($item->order_price) * floatval($item->quantity), 2, '.', ',');

            ///get attributs
            $html_attributs = '';
            foreach ($item->variation_value as $key => $var) {
                $html_attributs = $html_attributs . $var['attribute'] . ':' . $var['attribute_value'];
                if ($key !== array_key_last($item->variation_value)) $html_attributs = $html_attributs . ', ';
            }

            if (!empty($html_attributs)) $html_attributs = '<br><small style="font-size: 75%;">' . $html_attributs . '</small>';

            $my_items_list = $my_items_list . '<tr>
            <td style="max-width:40%;">' . $item->product_name . $html_attributs . '</td>
            <td>' . number_format(floatval($item->order_price), 2, '.', ',') . $unit_label . '</td>
            <td>' . $item->quantity . '</td>
            ';

            if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
                $my_items_list = $my_items_list . '<td>' . $item->tax_sale . '</td>';
            }

            $my_items_list = $my_items_list . '<td>' . $amount . '</td></tr>';
        }
        /// Delivery fee tax
        if ($sales->pickup_or_delivery == "Delivery" && is_null($sales->user_id)) {
            $my_items_list = $my_items_list . '<tr>
            <td style="max-width:40%;">Delivery Fee</td>
            <td>' . number_format(floatval($sales->delivery_fee), 2, '.', ',') . '</td>
            <td>--</td>
            <td>' . $sales->delivery_fee_tax . '</td>
            <td>' . number_format(floatval($sales->delivery_fee), 2, '.', ',') . '</td>
            </tr>';
        }

        $vat_type = "No VAT";
        if ($sales->tax_items == "Included in the price") $vat_type = "Included";
        if ($sales->tax_items == "Added to the price") $vat_type = "Added";

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>VAT ' . $vat_type . ' (Rs)</b></td>
                        <td>' . number_format((float)$sales->tax_amount, 2, '.', ',') . '</td>
                    </tr>
        ';
        }

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td>
                        <td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td>
                        <td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
        } else {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td>
                        <td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td>
                        <td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
        }



        $comment = $sales->comment;

        if (strlen($comment) > 0) $comment = '<br><div style="text-align:left">Additional Note: ' . str_replace(PHP_EOL, "<br>", $comment) . '</div><br><br>';

        $css_image = "";
        $empty_col = "";
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        if (isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty($company->logo)) {
            $css_image = '<td style="width:25%">
                <img style="width: 120px;height: auto;" src="' . public_path($company->logo) . '">
            </td>';
            /*$empty_col = '
            <td style="width:25%">
                    &nbsp;
                </td>';*/
        }

        $html = '<!DOCTYPE html>
		<html>
		<head>
        <meta charset="utf-8">
		<title>Sales Order #' . $sales_id . '</title>
		<style>
            html{
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
                <br>' . $customer_name . '
                ' . $customer_address . '
                ' . $customer_city . '
                ' . $customer_email . '
                ' . $customer_phone . '
                </td>
			<td style="width:100px"></td>
			<td style="text-align:right">
                <br><br>Order Number: ' . $sales_id . '
                <br>Order Date: ' . date_format(date_create($sales->created_at), "d/m/Y") . '
                <br>Payment Mode: ' . $payment_mode->payment_method . '
            </td>
			</tr>
		</table>
		<br><h3><div style="text-align:center">SALES ORDER</div></h3>
		' . $text_before_order . '
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

        $pdfT = PDF::loadHTML($html)->save('pdf_attachments/sale-' . $sales_id . '.pdf');
        $path = $_SERVER['DOCUMENT_ROOT'] . '/pdf_attachments/sale-' . $sales_id . '.pdf';
        $file_name = 'sale-' . $sales_id . '.pdf';
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
        Dear ' . $customer_name . ',<br/>
        ' . $text_before_order . '
        ' . $text_email_before . '<br/>
        <h3><b>Order Summary</b></h3>
        <br>' . $my_items_list . '
        <br>
        ' . $comment . '
        ' . $text_email_after . '

        </body>
        </html>
        ';

        // echo $mailContent;die;

        $from_mail = "noreply@ecom.mu";
        $company_sub = "Ecom";
        if (!empty($company->order_email)) $from_mail = $company->order_email;

        ////company subject

        $shop_name = Setting::where("key", "store_name_meta")->first();
        if (!empty($shop_name)) {
            $company_sub = $shop_name->value;
        } else {
            if (!empty($company->company_name)) $company_sub = $company->company_name;
        }

        ///email config
        $to_email = "";
        $cc_email = "";
        $bcc_email = "";

        $backoffice_order_mail = Setting::where("key", "send_backoffice_order_mail")->first();
        $onlineshop_order_mail = Setting::where("key", "send_onlineshop_order_mail")->first();
        $onlineshop_order_mail_admin = Setting::where("key", "send_onlineshop_order_mail_admin")->first();
        $backoffice_order_mail_admin = Setting::where("key", "send_backoffice_order_mail_admin")->first();

        $to_email = "";
        $email_cc_admin = [];
        $email_bcc_admin = [];

        if ((isset($backoffice_order_mail->value) && $backoffice_order_mail->value == "yes") || (isset($onlineshop_order_mail->value) && $onlineshop_order_mail->value == "yes")) {
            $to_email = $sales->customer_email;
            if ((isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == "yes") || (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == "yes")) {
                $email_cc_admin = Setting::where("key", "email_cc_admin")->first();
                $email_bcc_admin = Setting::where("key", "email_bcc_admin")->first();
            }
        }

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
            /// cc email
            if (isset($email_cc_admin->value) && !empty($email_cc_admin->value)) {
                $cc_email = explode(',', $email_cc_admin->value);
                foreach ($cc_email as $cc) {
                    $mail->AddCC(trim($cc));
                }
            }
            if (isset($email_bcc_admin->value) && !empty($email_bcc_admin->value)) {
                $bcc_email = explode(',', $email_bcc_admin->value);
                foreach ($bcc_email as $bcc) {
                    $mail->addBCC(trim($cc));
                }
            }
            $mail->Subject = "Sale #" . $sales_id . " - " . $company_sub;
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
        } else {
            unlink($path);
            return false;
        }
    }

    public function send_paid_mail($sales_id)
    {

        ////SMTP settings
        $email_smtp = Email_smtp::latest()->first();
        $smtp_username = "emailapikey";
        $smtp_password = "wSsVR610/xOlB6ooyTT8LrtuzwwEDwikFRh40VqovyL+F/rE8sc9lhWdU1WgHKIcGDFgFmcVoegtmBoE1GYNjYsvmVoECyiF9mqRe1U4J3x17qnvhDzDWG1alBOML4IKxghtk2RiEcgq+g==";
        if ($email_smtp != NULL) {
            $smtp_username = $email_smtp->username;
            $smtp_password = $email_smtp->password;
        }

        $date_resent_mail_invoice = date('Y-m-d H:i:s');

        $sales = Sales::find($sales_id);

        if ($sales === NULL) return false;

        $sales->update([
            "date_resent_mail_invoice" => $date_resent_mail_invoice
        ]);

        ///Payment Mode + text email before and after
        $payment_mode = PayementMethodSales::find($sales->payment_methode);

        //// sales products + product variations
        $sales_products = Sales_products::where("sales_id", $sales_id)->get();
        foreach ($sales_products as &$item) {
            $variation = NULL;
            $variation_value_final = [];
            if (!empty($item->product_variations_id)) {
                $variation = ProductVariation::getReadableVariationById($item->product_variations_id);

                if (!empty($variation)) {
                    foreach ($variation as $attribute => $value) {
                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attribute, "attribute_value" => $value]]);
                    }
                }
            }
            /* $item->variation = $variation; */
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
            if (!empty($company->company_address)) $company_address = "<br>" . $company->company_address;
            else $company_address = "";
            if (!empty($company->company_email)) $company_email = "<br>" . $company->company_email;
            else $company_email = "";
            if (!empty($company->company_phone)) $company_phone = "<br>" . $company->company_phone;
            else $company_phone = "";
            if (!empty($company->company_fax)) $company_fax = "<br>FAX: " . $company->company_fax;
            else $company_fax = "";
            if (!empty($company->brn_number)) $brn_number = "<br>BRN: " . $company->brn_number;
            else $brn_number = "";
            if (!empty($company->vat_number)) $vat_number = "<br>VAT: " . $company->vat_number;
            else $vat_number = "";
        }

        ///Store
        $store = Store::find($sales->id_store);

        /// about customer
        $customer_name = "";
        $customer_address = "";
        $customer_city = "";
        $customer_email = "";
        $customer_phone = "";

        ///must set
        $customer_name = $sales->customer_firstname . " " . $sales->customer_lastname;
        if (!empty($sales->customer_address)) $customer_address = "<br>" . $sales->customer_address;
        if (!empty($sales->customer_city)) $customer_city = "<br>" . $sales->customer_city;
        if (!empty($sales->customer_email)) $customer_email = "<br>" . $sales->customer_email;
        if (!empty($sales->customer_phone)) $customer_phone = "<br>" . $sales->customer_phone;

        ///text email before and after
        $text_email_before = "";
        $text_email_after = "";
        $text_pdf_before = "";
        $text_pdf_after = "";
        if (!empty($payment_mode->text_email_before_invoice)) {
            $text_email_before = "<br>" . $payment_mode->text_email_before_invoice;
        }
        if (!empty($payment_mode->text_email_after_invoice)) {
            $text_email_after = "<br>" . $payment_mode->text_email_after_invoice;
        }
        if (!empty($payment_mode->text_pdf_before_invoice)) {
            $text_pdf_before = "<br>" . $payment_mode->text_pdf_before_invoice;
        }
        if (!empty($payment_mode->text_pdf_after_invoice)) {
            $text_pdf_after = "<br>" . $payment_mode->text_pdf_after_invoice;
        }

        //Type of person
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value == 'NVTR') {
            if ($sales->currency == "MUR") {
                $sales->amount = $sales->amount - $sales->tax_amount;
            } else {
                $sales->amount = $sales->amount - $sales->tax_amount;
                $sales->amount_converted = $sales->amount_converted - $sales->tax_amount;
            }
        }



        ///html item list
        $my_items_list = '<div class="my_table">
		<table style="width:100%;">
			<tr>
			<th>Items</th>
			<th>Unit Price (Rs)</th>
			<th>Quantity</th>';

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list .= '<th>VAT</th>';
        }

        $my_items_list .= '<th>Amount (Rs)</th></tr>';
        foreach ($sales_products as $item) {
            /// amount with VAT calculation
            $amount = number_format(floatval($item->order_price) * floatval($item->quantity), 2, '.', ',');

            ///get attributs
            $html_attributs = '';
            foreach ($item->variation_value as $key => $var) {
                $html_attributs = $html_attributs . $var['attribute'] . ':' . $var['attribute_value'];
                if ($key !== array_key_last($item->variation_value)) $html_attributs = $html_attributs . ', ';
            }

            if (!empty($html_attributs)) $html_attributs = '<br><small style="font-size: 75%;">' . $html_attributs . '</small>';

            $my_items_list = $my_items_list . '<tr>
            <td style="max-width:40%;">' . $item->product_name . $html_attributs . '</td>
            <td>' . number_format(floatval($item->order_price), 2, '.', ',') . '</td>
            <td>' . $item->quantity . '</td>';

            if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
                $my_items_list = $my_items_list . '<td>' . $item->tax_sale . '</td>';
            }

            $my_items_list = $my_items_list . '<td>' . $amount . '</td></tr>';
        }
        /// Delivery fee tax
        if ($sales->pickup_or_delivery == "Delivery" && is_null($sales->user_id)) {
            $my_items_list = $my_items_list . '<tr>
            <td style="max-width:40%;">Delivery Fee</td>
            <td>' . number_format(floatval($sales->delivery_fee), 2, '.', ',') . '</td>
            <td>--</td>';

            if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
                $my_items_list = $my_items_list . '<td>' . $sales->delivery_fee_tax . '</td>';
            }

            $my_items_list = $my_items_list . '<td>' . number_format(floatval($sales->delivery_fee), 2, '.', ',') . '</td></tr>';
        }

        $vat_type = "No VAT";
        if ($sales->tax_items == "Included in the price") $vat_type = "Included";
        if ($sales->tax_items == "Added to the price") $vat_type = "Added";

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>VAT ' . $vat_type . ' (Rs)</b></td>
                        <td>' . number_format((float)$sales->tax_amount, 2, '.', ',') . '</td>
                    </tr>
        ';
        }

        if (isset($ebs_typeOfPerson->value) && $ebs_typeOfPerson->value !== 'NVTR') {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td>
                        <td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td>
                        <td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
        } else {
            $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td>
                        <td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td>
                        <td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
        }


        $comment = $sales->comment;

        if (strlen($comment) > 0) $comment = '<br><div style="text-align:left">Additional Note: ' . str_replace(PHP_EOL, "<br>", $comment) . '</div><br><br>';

        $css_image = "";
        $empty_col = "";
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        if (isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty($company->logo)) {
            $css_image = '<td style="width:25%">
                <img style="width: 120px;height: auto;" src="' . public_path($company->logo) . '">
            </td>';
            /*$empty_col = '
            <td style="width:25%">
                    &nbsp;
                </td>';*/
        }

        $html = '<!DOCTYPE html>
		<html>
		<head>
        <meta charset="utf-8">
		<title>Invoice Order #' . $sales_id . '</title>
		<style>
            html{
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
                <br>' . $customer_name . '
                ' . $customer_address . '
                ' . $customer_city . '
                ' . $customer_email . '
                ' . $customer_phone . '
                </td>
			<td style="width:100px"></td>
			<td style="text-align:right">
                <br><br>Invoice Number: ' . date('Ymd', strtotime($sales->created_at)) . '-' . $sales_id . '
                <br>Invoice Date: ' . date_format(date_create($sales->created_at), "d/m/Y") . '
                <br>Payment Mode: ' . $payment_mode->payment_method . '
            </td>
			</tr>
		</table>
		<br><h3><div style="text-align:center">INVOICE</div></h3>
        ' . $text_pdf_before . '
		<br>' . $my_items_list . '
        <br>
        ' . $comment . '
        <br>' . $text_pdf_after . '
		</body>
		</html>
		';

        $directoryPath = public_path('pdf_attachments');

        // Check if the directory exists, if not create it
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);  // Create directory and set permissions
        }

        // Now save the PDF file
        PDF::loadHTML($html)->save($directoryPath . '/invoice-' . $sales_id . '.pdf');


        // PDF::loadHTML($html)->save('pdf_attachments/invoice-' . $sales_id . '.pdf');

        // $path = $_SERVER['DOCUMENT_ROOT'] . '/pdf_attachments/invoice-' . $sales_id . '.pdf';

        // $path = "https://bata.mu" . '/pdf_attachments/invoice-' . $sales_id . '.pdf';
        $path =  url('/') . '/pdf_attachments/invoice-' . $sales_id . '.pdf';
        $file_name = 'invoice-' . $sales_id . '.pdf';

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
        Dear ' . $customer_name . ',<br>
        ' . $text_email_before . '<br>
        <h3><b>Order Summary</b></h3>
        <br>' . $my_items_list . '
        <br>
        ' . $comment . '
        <br>' . $text_email_after . '
        </body>
        </html>
        ';

        $from_mail = "noreply@ecom.mu";
        $company_sub = "Ecom";
        if (!empty($company->order_email)) $from_mail = $company->order_email;

        $to_email = "";
        //if (isset($company->order_email)) $to_email = $company->order_email;
        if (!empty($sales->customer_email)) $to_email = $sales->customer_email;

        ////company subject
        $shop_name = Setting::where("key", "store_name_meta")->first();
        if (!empty($shop_name)) {
            $company_sub = $shop_name->value;
        } else {
            if (!empty($company->company_name)) $company_sub = $company->company_name;
        }

        if (!empty($to_email)) {
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
            ///cc and bcc mail
            $email_cc_admin = Setting::where("key", "email_cc_admin")->first();
            $email_bcc_admin = Setting::where("key", "email_bcc_admin")->first();
            if (isset($email_cc_admin->value) && !empty($email_cc_admin->value)) {
                $cc_email = explode(',', $email_cc_admin->value);
                foreach ($cc_email as $cc) {
                    $mail->AddCC(trim($cc));
                }
            }
            if (isset($email_bcc_admin->value) && !empty($email_bcc_admin->value)) {
                $bcc_email = explode(',', $email_bcc_admin->value);
                foreach ($bcc_email as $bcc) {
                    $mail->addBCC(trim($cc));
                }
            }
            $mail->Subject = "Sale #" . $sales_id . " Paid - " . $company_sub;
            $mail->Body = $mailContent;

            try {
                $mail->AddAttachment($path, $file_name, $encoding = 'base64', $type = 'application/pdf');
            } catch (\Exception $e) {
                $path = public_path('pdf_attachments') . '/' . $file_name;
                $mail->AddAttachment($path, $file_name, $encoding = 'base64', $type = 'application/pdf');
            }
            if (!$mail->send()) {
                unlink($path);
                return $mail->ErrorInfo;
            } else {
                unlink($path);
                return true;
            }
        } else {
            return false;
        }
    }

    protected function transform_date($date)
    {
        //        $d = explode('/', $date);
        //        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
        //            return $d[2] . "-" . $d[1] . "-" . $d[0];
        //        else
        return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
    }

    public function thankyou($id)
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
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();


        return view('front.thankyou', compact([
            'ebs_typeOfPerson',
            'headerMenuColor',
            'headerMenus',
            'sales',
            'sales_products',
            'carts',
            'stores',
            'merchant',
            'company',
            'shop_favicon',
            'order_payment_method',
            'shop_name',
            'shop_description',
            'code_added_header'
        ]));
    }

    public function after_sale(Request $request)
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

        $company = Company::latest()->first();

        if (isset($request->checkoutVersion)) {
            if ($this->sales_id_c)
                return $this->mcb_payement($this->sales_id_c);
        }

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();
        return view('front.sale-saved', compact(['ebs_typeOfPerson', 'carts', 'headerMenus', 'homeCarousels', 'company', 'shop_favicon']));
    }

    public function failed($id)
    {
        $sales = Sales::find($id);
        $order_payment_method = PayementMethodSales::find($sales->payment_methode);
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

        $stores = Store::where('pickup_location', '=', 'yes')->get();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }

        return view('front.failed', compact(['headerMenuColor', 'headerMenus', 'homeCarousels', 'sales', 'sales_products', 'carts', 'stores', 'order_payment_method', 'shop_favicon']));
    }

    public function customer_orders($id)
    {
        $sales = Sales::latest()->where('customer_id', $id)->orderBy('id', 'DESC')->paginate(10);
        foreach ($sales as &$sale) {
            $amount_paid = 0;
            $sum_payment = DB::table("sales_payments")->where("sales_id", $sale->id)->sum('sales_payments.amount');
            ///dd($sum_payment);
            if ($sum_payment != NULL) $amount_paid = $sum_payment;
            $sale->amount_paid = $amount_paid;
        }
        $customer = Customer::find($id);
        return view('sales.customer', compact('sales', 'customer'));
    }

    public function new_sale()
    {
        $stores = Store::where('is_on_newsale_page', 'yes')->get();

        $store = $items = [];
        $item_store = [];
        $store = $stores->first();
        if (!empty($store)) {
            $item_store = ProductService::getItemsByStoreId($store->id);

            // dd($item_store);

            session()->flash('store', $store);
            session()->flash('item_store', $item_store);
        }

        $customers = Customer::latest()->get();
        $products = Products::all();
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        $session_id = Session::get('session_id');

        $newsale = [];
        $have_sale_type = "no";

        if ($session_id) {
            $newsale = Newsale::where("session_id", $session_id)->get()->map(function ($item) {
                $variation_value_final = [];
                if ($item->product_variation_id) {
                    $variation = ProductVariation::getReadableVariationById($item->product_variation_id);

                    if ($variation) {
                        foreach ($variation as $attribute => $value) {
                            $variation_value_final[] = ["attribute" => $attribute, "attribute_value" => $value];
                        }
                    }
                    $item->variation = $variation;
                }

                $item->variation_value = $variation_value_final;
                if ($item->sales_type) {
                    $GLOBALS['have_sale_type'] = "yes";
                }

                $item->product = Products::find($item->product_id);

                return $item;
            });
        }

        $sales_type = Ledger::all();
        $suppliers = Supplier::all();

        $vatrate = Setting::where("key", "vatrate")->first();
        $vat_rate_setting = [];

        if (isset($vatrate->value) && $vatrate->value) {
            $vat_rate_explode = explode(",", $vatrate->value);
            foreach ($vat_rate_explode as $k => $vtv) {
                $value_vtv = $vtv;
                if (!str_contains($value_vtv, '%')) $value_vtv .= '%';
                if (!str_contains($value_vtv, 'VAT')) $value_vtv .= ' VAT';
                array_push($vat_rate_setting, trim($value_vtv));
            }
        }

        //todo
        Customer::where('id', 1)->update([
            'firstname' => null,
            'lastname' => null,
            'name' => 'Guest',
            'company_name' => 'Guest',
            'address1' => null,
            'address2' => null,
            'city' => null,
            'country' => null,
            'email' => null,
            'phone' => null,
            'fax' => null,
            'brn_customer' => null,
            'vat_customer' => null,
            'note_customer' => null,
            'temp_password' => null,
            'is_default' => 'yes',
            'type' => 'customer',
            'date_of_birth' => null,
            'mobile_no' => null,
            'work_village' => null,
            'work_address' => null,
            'user_id' => null,
            'other_address' => null,
            'other_village' => null,
            'whatsapp' => null,
            'nid' => null,
            'upi' => null,
            'sex' => null,
            'blood_group' => null,
        ]);


        return view('sales.new', compact([
            'stores',
            'customers',
            'products',
            'payment_mode',
            'newsale',
            'sales_type',
            'suppliers',
            'have_sale_type',
            'vat_rate_setting'
        ]));

    }

    public function add_journal_sale(Request $request)
    {
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;
        $name = 'Sales #' . $request->sales_id;
        $amount = 0;
        if (!empty(trim($request->name))) $name = $request->name;
        if (!empty(trim($request->amount))) $amount = $request->amount;
        $debit = JournalEntry::create([
            'id_order' => $request->sales_id,
            'debit' => $request->debit,
            'credit' => null,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        $credit = JournalEntry::create([
            'id_order' => $request->sales_id,
            'debit' => null,
            'credit' => $request->credit,
            'amount' => $amount,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);
        return redirect()->route('detail-sale', $request->sales_id)->with('message', 'Journal Sale Created Successfully');
    }

    public function update_journal_sale(Request $request)
    {
        //        $journal = JournalEntry::find($request->journal_id);
        $journal_debit = JournalEntry::find($request->journal_id_debit);
        $journal_credit = JournalEntry::find($request->journal_id_credit);
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $amount = 0;
        if (!empty(trim($request->amount))) $amount = $request->amount;

        $journal_debit->update([
            'debit' => $request->debit,
            'credit' => null,
            'amount' => $request->amount,
            'date' => $date,
        ]);
        $journal_credit->update([
            'debit' => null,
            'credit' => $request->credit,
            'amount' => $request->amount,
            'date' => $date,
        ]);
        return redirect()->route('detail-sale', $request->sales_id)->with('message', 'Journal Sale Created Successfully');
    }

    public function update_item_qunaity_sale(Request $request)
    {
        $sales_product = Sales_products::find($request->item_id);
        if (!$sales_product) abort(404);

        $sales = Sales::find($sales_product->sales_id);
        if (!$sales) abort(404);

        $product_price_converted = 0;
        if ($sales->currency != "MUR") {
            $data_currency = self::get_currency($sales->currency);
            $product_price_converted = round($request->order_price / $data_currency->conversion_rates->MUR, 2);
        }

        $sales_product->update([
            'order_price' => $request->order_price,
            'quantity' => $request->quantity,
            'product_price_converted' => $product_price_converted,
            'tax_sale' => $sales_product->tax_sale
        ]);

        $total_amount = 0;
        $tax_amount = 0;
        $subtotal = 0;
        $products_sales = Sales_products::where('sales_id', $sales_product->sales_id)->get();

        foreach ($products_sales as $p) {
            $subtotal += ($p->quantity * $p->order_price);
            if (str_contains($p->tax_sale, "%")) {
                $rate = (float)preg_replace('/[^\d,]/', '', $p->tax_sale) / 100;
                $tax_amount += ($p->order_price * $p->quantity) * $rate;
            }
        }

        DB::table('sales')->where('id', $sales_product->sales_id)->update([
            'amount' => $subtotal + $tax_amount,
            'subtotal' => $subtotal,
            'tax_amount' => $tax_amount
        ]);

        $this->pdf_sale($sales_product->sales_id);
        $this->pdf_invoice($sales_product->sales_id);
        $this->pdf_delivery_note($sales_product->sales_id);

        return redirect()->route('detail-sale', $sales_product->sales_id)->with('message', 'Sales Item Updated Successfully');
    }

    public function update_item_sale(Request $request, $id)
    {
        $sales = Sales::find($id);

        if (!$sales) abort(404);

        $product_id = $request->product_id;
        $product_variations_id = $request->product_variations_id;
        $item_vat = $request->item_vat;
        $item_unit_price = $request->item_unit_price;
        $currency = $request->currency;
        $item = Sales_products::where('sales_id', $id)->where('product_id', $product_id)->where('product_variations_id', $product_variations_id)->first();
        if ($item) {
            $product_price_converted = 0;
            if ($currency != "MUR") {
                $data_currency = self::get_currency($currency);
                $product_price_converted = round($item->order_price / $data_currency->conversion_rates->MUR, 2);
            }
            $data = [
                'order_price' => $item_unit_price,
                'product_price_converted' => $product_price_converted,
                'tax_sale' => $item_vat
            ];
            $item->update($data);

            $tax_items = $sales->tax_items;

            $total_amount = 0;
            $tax_amount = 0;
            $products_sales = Sales_products::where('sales_id', $id)->get();

            $total_amount = 0;
            $tax_amount = 0;
            $subtotal = 0;
            foreach ($products_sales as $p) {
                if ($p->tax_sale == "15% VAT") {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * 0.15;
                } elseif (str_contains($p->tax_sale, "% VAT") || str_contains($p->tax_sale, "%")) {
                    $rate = (float)preg_replace('/[^\d,]/', '', $p->tax_sale) / 100;
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * $rate;
                } else {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                }
            }

            $datas = [
                'amount' => $subtotal + $tax_amount,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                //'tax_items'=>$item_vat
            ];
            DB::table('sales')->where('id', $id)->update($datas);
        }


        $this->pdf_sale($id);
        $this->pdf_invoice($id);
        $this->pdf_delivery_note($id);
        return redirect()->route('detail-sale', $id)->with('message', 'Journal Sale Created Successfully');
    }


    public function destroy_sale_item(Request $request, $id)
    {
        $sales_item = Sales_products::find($id);


        if (!$sales_item) abort(404);

        $sales = Sales::find($sales_item->sales_id);

        $item = Sales_products::where('id', $id)->first();
        if ($item) {

            Sales_products::where('id', $id)->delete();

            $tax_items = $sales->tax_items;

            $total_amount = 0;
            $tax_amount = 0;
            $products_sales = Sales_products::where('sales_id', $id)->get();

            $total_amount = 0;
            $tax_amount = 0;
            $subtotal = 0;
            foreach ($products_sales as $p) {
                if ($p->tax_sale == "15% VAT") {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * 0.15;
                } elseif (str_contains($p->tax_sale, "% VAT") || str_contains($p->tax_sale, "%")) {
                    $rate = (float)preg_replace('/[^\d,]/', '', $p->tax_sale) / 100;
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * $rate;
                } else {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                }
            }


            $datas = [
                'amount' => $total_amount,
                'subtotal' => $total_amount - $tax_amount,
                'tax_amount' => $tax_amount,
                //  'amount_converted'=> $amount_converted,
                //  'subtotal_converted'=> $subtotal_converted,
                //  'tax_amount_converted' => $tax_amount_converted
            ];
            $sales->update($datas);
        }


        $this->pdf_sale($sales->id);
        $this->pdf_invoice($sales->id);
        $this->pdf_delivery_note($sales->id);
        return redirect()->route('detail-sale', $sales->id)->with('message', 'Sale deleted Successfully');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_export_all_detailed(Request $request)
    {
        $date_b = date('d-m-Y-h-i-s');
        return (new Export_Sales_detailed())->download($date_b . '-all-sales-detailed' . '.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_export_all_simple(Request $request)
    {
        $date_b = date('d-m-Y-h-i-s');
        return (new Export_Sales_simples())->download($date_b . '-all-sales-simple' . '.xlsx');
    }

    public function add_item_sales(Request $request, $id)
    {
        $sales = Sales::find($id);
        if (!$sales) abort(404);


        $product_id = 0;
        //$product_variations_id = $request->product_variations_id;
        $item_vat = $request->new_item_vat;
        $item_unit_price = $request->new_item_unit_price;
        $quantity = (int)$request->new_item_quantity;
        $rental_product_name = $request->rental_product_name;

        $currency = "MUR";

        $studentData = array();
        $studentData['sales_id'] = $id;
        $studentData['quantity'] = $quantity;
        $studentData['product_id'] = $product_id;
        $studentData['order_price'] = $item_unit_price;
        $studentData['product_name'] =  $rental_product_name;
        $studentData['tax_sale'] =  $item_vat;
        //$studentData['frequency'] =  $request->new_frequency;

        //print_r($studentData);exit;
        DB::table('sales_products')->insertGetId($studentData);


        //$item = Rentals_products::where('sales_id', $id)->where('product_id', $product_id)->first();



        $products_sales = Sales_products::where('sales_id', $id)->get();
        $total_amount = 0;
        $tax_amount = 0;
        $subtotal = 0;
        foreach ($products_sales as $p) {
            if ($p->tax_sale == "15% VAT") {
                $subtotal = $subtotal + ($p->quantity * $p->order_price);
                $tax_amount += ($p->order_price * $p->quantity) * 0.15;
            } elseif (str_contains($p->tax_sale, "% VAT") || str_contains($p->tax_sale, "%")) {
                $rate = (float)preg_replace('/[^\d,]/', '', $p->tax_sale) / 100;
                $subtotal = $subtotal + ($p->quantity * $p->order_price);
                $tax_amount += ($p->order_price * $p->quantity) * $rate;
            } else {
                $subtotal = $subtotal + ($p->quantity * $p->order_price);
            }
        }

        $datas = [
            'amount' => $subtotal + $tax_amount,
            'subtotal' => $subtotal,
            'tax_amount' => $tax_amount,
            //'tax_items'=>$item_vat
        ];

        DB::table('sales')->where('id', $id)->update($datas);

        $this->pdf_sale($id);
        // $this->pdf_invoice($id);
        // $this->pdf_delivery_note($id);
        return redirect()->route('detail-sale', $id)->with('message', 'Sale Item Updated Successfully');
    }



    public function importSalesView(Request $request)
    {
        return view('sales.importSalesFile');
    }

    public function importSales(Request $request)
    {
        Excel::import(new SalesImport, $request->file('file'));
        return redirect()->route('sales.index')->with('message', 'Sales imported Successfully');
    }
}
