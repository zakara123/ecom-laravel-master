<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Exports\Export_Sales_detailed;
use App\Exports\Export_Sales_simples;
use App\Models\AppointmentBillable;
use App\Models\AppointmentBillableProducts;
use App\Models\AppointmentDiagnosis;
use App\Models\AppointmentFile;
use App\Models\AppointmentLog;
use App\Models\AppointmentPayments;
use App\Models\Appointments;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\BankInformation;
use App\Models\Cart;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Doctor;
use App\Models\Email_smtp;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\MedicalAdvice;
use App\Models\MedVigilance;
use App\Models\Newsale;
use App\Models\OnlineStockApi;
use App\Models\PayementMethodSales;
use App\Models\PhysicalExamination;
use App\Models\PresentingComplaints;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\Rentals;
use App\Models\Rentals_products;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesFile;
use App\Models\SalesPayments;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Vital;
use App\Services\AppointmentLogService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDF;

use Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\SalesInvoiceCounter;
///for email

class AppointmentController extends Controller
{

    public $sales_id_c = 0;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function appointment_list(Request $request)
    {
        //echo "hi";exit;
        $salesObj = Appointments::select('appointments.*')
            //->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
            ->where([
                ['patient_firstname', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('customer_id', '=', $s)
                            ->orWhere('patient_firstname', 'LIKE', '%' . $s . '%')
                            ->orWhere('patient_lastname', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->orderBy('appointments.id', 'DESC');
        if (Auth::check() &&  Auth::User()->role == 'patient') {
            $salesObj->where('customer_id', Auth::User()->customer_id);
        }
        if (Auth::check() &&  Auth::User()->role == 'doctor') {
            $salesObj->where('doctor_id', Auth::User()->doctor_id);
        }
        $sales = $salesObj->get();

        if ($request->sale_id && $ss == '') {
            $ss = $request->sale_id;
            $salesObj = Appointments::select('sales.*')
                // ->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
                ->where([
                    ['patient_firstname', '!=', Null],
                    [function ($query) use ($request) {
                        if (($sl = $request->sale_id)) {
                            $query->orWhere('id', '=', $sl)
                                ->get();
                        }
                    }]
                ])->orderBy('appointments.id', 'DESC');
            if (Auth::check() &&  Auth::User()->role == 'patient') {
                $salesObj->where('customer_id', Auth::User()->customer_id);
            }
            if (Auth::check() &&  Auth::User()->role == 'doctor') {
                $salesObj->where('doctor_id', Auth::User()->doctor_id);
            }
            $sales = $salesObj->get();
        }

        $status = Appointments::select('status')->distinct()->get();
        return response()->json([
            'list' => $sales,
            'status' => $status
        ]);
        //return view('appointment.index', compact(['sales', 'ss', 'status']));
    }

    public function add_appointment_files_api(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
            'file_upload' => 'required',
        ]);

        $fileName = 'appointment-id-' . $request->appointment_id . '-' . $request->file('file_upload')->getClientOriginalName();

        $path = public_path('files/attachment/appointments/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request->file('file_upload')->move(public_path($path), $fileName);

        $item_src = $path . '/' . $fileName;
        AppointmentFile::create([
            'appointment_id' => $request->appointment_id,
            'name' => $fileName,
            'type' => $request->document_type,
            'src' => $item_src,
            'date_generated' => date("Y-m-d H:i:s")
        ]);

        return response()->json([
            'message' => 'File Attachment saved successfully!',
            'status' => 'success'
        ]);
    }



    public function appointment_files_list_api(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
        ]);

        $sales_files = AppointmentFile::where("appointment_id", $request->appointment_id)->get();


        return response()->json([
            'message' => 'Appointment files get successfully!',
            'status' => 'success',
            'file_list' => $sales_files
        ]);
    }

    public function appointment_payment_list_api(Request $request)
    {
        $this->validate($request, [
            'appointment_id' => 'required',
        ]);
        $id = $request->appointment_id;
        $sales = Appointments::find($id);
        if ($sales === NULL) abort(404);
        $store = Store::find($sales->id_store);

        $appointmentBillableProduct = array();
        $appointmentBillable = AppointmentBillable::where("appointment_id", $id)->first();
        if ($appointmentBillable) {
            $appointmentBillableProduct = AppointmentBillableProducts::where("appointment_billable_id", $appointmentBillable->id)->get();
        }
        $amount_paied = 0;
        $amount_due = 0;
        $sales_payments = AppointmentPayments::where("sales_id", $id)->get();
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        foreach ($sales_payments as &$payment) {
            $payment->payment_method = PayementMethodSales::find($payment->payment_mode);
        }
        if ($appointmentBillable) {
            $amount_due = $appointmentBillable->amount;
            $amount_paied = 0;
            //$amount_paied = floatval($amount_paied);
            $amount_due = floatval($amount_due);

            $amount_due = $appointmentBillable->amount;
            $amount_paied = AppointmentPayments::where("sales_id", $id)->sum('amount');
            $amount_credit = 0; //CreditNote::where("sales_id", $id)->sum('amount');
            if ($amount_paied == NULL) $amount_paied = 0;
            else $amount_paied = $amount_paied;

            if ($amount_credit == NULL) $amount_credit = 0;
            else $amount_credit = $amount_credit;

            $amount_paied = floatval($amount_paied);
            $amount_due = floatval($amount_due);
            $amount_credit = floatval($amount_credit);

            $amount_max = $amount_due;
            if ($appointmentBillable->status == 'Paid') {
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
        }
        $proformaInvoice = '';
        if (count($appointmentBillableProduct) > 0) {
            $proformaInvoice = 'appointment-proforma-' . $sales->id . '.pdf';
        }
        $paymentInovice = '';
        if ($sales->status != "Booked" && $sales->status != "Confirmed") {
            $paymentInovice = 'invoice-' . $sales->id . '.pdf';
        }
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));

        return response()->json([
            'message' => 'Appointment files retrieved successfully!',
            'status' => 'success',
            'amount_paid' => $amount_paied,
            'amount_due' => $amount_due,
            'invoice_amount' => $appointmentBillable->amount,
            'sales_payments' => $sales_payments,
            'paymentInvoice' => $paymentInovice,
            'proformaInvoice' => $proformaInvoice,
            'pdf_path' => $pdf_src

        ]);
    }

    public function index(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $salesObj = Appointments::select('appointments.*')
            //->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
            ->where([
                ['patient_firstname', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('customer_id', '=', $s)
                            ->orWhere('patient_firstname', 'LIKE', '%' . $s . '%')
                            ->orWhere('patient_lastname', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])->orderBy('appointments.id', 'DESC');
        if (Auth::check() &&  Auth::User()->role == 'patient') {
            $salesObj->where('customer_id', Auth::User()->customer_id);
        }
        if (Auth::check() &&  Auth::User()->role == 'doctor') {
            $salesObj->where('doctor_id', Auth::User()->doctor_id);
        }
        $sales = $salesObj->paginate(10);

        if ($request->sale_id && $ss == '') {
            $ss = $request->sale_id;
            $salesObj = Appointments::select('sales.*')
                // ->join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
                ->where([
                    ['patient_firstname', '!=', Null],
                    [function ($query) use ($request) {
                        if (($sl = $request->sale_id)) {
                            $query->orWhere('id', '=', $sl)
                                ->get();
                        }
                    }]
                ])->orderBy('appointments.id', 'DESC');
            if (Auth::check() &&  Auth::User()->role == 'patient') {
                $salesObj->where('customer_id', Auth::User()->customer_id);
            }
            if (Auth::check() &&  Auth::User()->role == 'doctor') {
                $salesObj->where('doctor_id', Auth::User()->doctor_id);
            }
            $sales = $salesObj->paginate(10);
        }

        $status = Appointments::select('status')->distinct()->get();
        return view('appointment.index', compact(['sales', 'ss', 'status']));
    }

    public function search(Request $request)
    {
        $ss = $fs = '';
        if ($request->s) $ss = $request->s;
        if ($request->fs) $fs = $request->fs;

        $sales = Appointments::
            //join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
            where([
                ['patient_firstname', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('customer_id', '=', $s)
                            ->orWhere('patient_firstname', 'LIKE', '%' . $s . '%')
                            ->orWhere('patient_lastname', 'LIKE', '%' . $s . '%')
                            ->orWhereRaw("CONCAT(patient_firstname, ' ', patient_lastname) LIKE ?", ['%' . $s . '%'])
                            ->get();
                    }
                }]
            ])
            ->orderBy('appointments.id', 'DESC')->paginate(10);

        if ($request->fs && $request->fs != 'all') {
            $sales = Appointments::
                //join('payement_method_sales', 'payement_method_sales.id', '=', 'sales.payment_methode')
                where([
                    ['patient_firstname', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->s)) {
                            $query->orWhere('customer_id', '=', $s)
                                ->orWhere('patient_firstname', 'LIKE', '%' . $s . '%')
                                ->orWhere('patient_lastname', 'LIKE', '%' . $s . '%')
                                ->orWhereRaw("CONCAT(patient_firstname, ' ', patient_lastname) LIKE ?", ['%' . $s . '%'])
                                ->get();
                        }
                    }]
                ])->where('status', '=', $fs)
                ->orderBy('appointments.id', 'DESC')->paginate(10);
        }

        return view('appointment.search_ajax', compact(['sales', 'ss', 'fs']));
    }

    public function createAppointmentRequest(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();

            ///check customer
            $customer = Customer::where("email", $data['email'])->where('type', 'Patient')->first();
            $phone_call_no = null;
            if (@$data['method_of_communication'] == 'Phone Call') {
                $phone_call_no = @$data['phone_call_no_cell'];
            } else {
                $phone_call_no = @$data['phone_call_no_whats'];
            }

            $addressField = 'address1';
            $villageField = 'address2';
            if (@$data['consultation_place'] == 'At work') {
                $addressField = 'work_address';
                $villageField = 'work_village';
            } else if (@$data['consultation_place'] == 'Other location') {
                $addressField = 'other_address';
                $villageField = 'other_village';
            } else {
                $addressField = 'address1';
                $villageField = 'address2';
            }

            if ($customer === null) {

                $lastCustomer =  Customer::where('type', 'Patient')->latest()->first();

                $count = $lastCustomer ? (int) substr($lastCustomer->upi, 6) : 0;
                $upi = date('Y') . sprintf('%07d', $count + 1);

                $customer = Customer::updateOrCreate([
                    'name' => $data['first_name'],
                    'company_name' => $data['first_name'],
                    'firstname' => $data['first_name'],
                    'lastname' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone_no'],
                    'mobile_no' => $data['mobile_no'],
                    'date_of_birth' => @$data['date_of_birth'],
                    'type' => 'patient',
                    'fax' => NULL,
                    'upi' => $upi,
                    $addressField => @$data['consultation_place_address'],
                    $villageField => @$data['village_town'],
                    'brn_customer' => NULL,
                    'vat_customer' => NULL,
                    'note_customer' => NULL,
                    'temp_password' => NULL
                ]);


                if (!empty($data['email'])) {
                    ///check customer on user table
                    $user = User::firstWhere("email", $data['email']);
                    if (!$user) {
                        $password = "123456789";
                        $user = User::updateOrCreate([
                            'name' => $data['first_name'] . " " . $data['last_name'],
                            'email' => $data['email'],
                            'phone' => $data['phone_no'],
                            'login' => $data['email'],
                            'role' => "patient",
                            'password' => Hash::make($password),
                        ]);

                        DB::table('customers')->where('id', $customer->id)->update(array('user_id' => $user->id));
                    }
                }
            }
            $appointmentDate = null;
            $doctorStatus = 'Yet to be assigned';
            if (@$data['doctor_id'] > 0) {
                $doctorStatus = 'ASSIGNED';
                $appointmentDate = date('Y-m-d H:i:s');
            }
            $store = Store::where('is_online', '=', 'yes')->first();
            $sales = new Appointments([
                'status' => "REQUESTED",
                "doctor_status" => $doctorStatus,
                'order_reference' => "",
                'customer_id' => $customer->id,
                'patient_firstname' => $data['first_name'],
                'patient_lastname' => $data['last_name'],
                'patient_email' => $data['email'],
                'patient_phone' => $data['phone_no'],
                'type' => @$data['type'],
                'specialist_type' => @$data['specialist_type'],
                'patient_date_of_birth' => @$data['date_of_birth'],
                'patient_mobile_no' => @$data['mobile_no'],
                'appointment_date' => @$data['appointment_date'],
                'appointment_time' => @$data['appointment_time'],
                'consultation_mode' => @$data['consultation_mode'],
                'method_of_communication' => @$data['method_of_communication'],
                'phone_call_no' => $phone_call_no,
                'consultation_place' => @$data['consultation_place'],
                'consultation_place_address' => @$data['consultation_place_address'],
                'doctor_id' => @$data['doctor_id'],
                'village_town' => @$data['village_town'],
                'id_store' => $store->id ?: "",
                'doctor_date' => $appointmentDate,
            ]);
            $sales->save();
            $id_sale = $sales->id;

            $apptLogData['appointment_id'] = $id_sale;
            $apptLogData['status'] = 'REQUESTED';
            $apptLogDetail['appointment_comment'] = $doctorStatus;
            if ($doctorStatus == 'Yet to be assigned') {
                $apptLogDetail['appointment_comment'] = "Requested for " . date('d/m/Y', strtotime($data['appointment_date']));
            }
            if (@$data['doctor_id'] > 0) {
                $apptLogData['status'] = $doctorStatus;
                $apptLogDetail['appointment_comment'] = ucfirst(strtolower($doctorStatus)) . " for " . date('d/m/Y', strtotime($data['appointment_date']));
            }
            $apptLogDetail['doctor_comment'] = $request->doctor_comment;
            $apptLogData['appointment_details'] = json_encode($apptLogDetail);
            AppointmentLogService::log($apptLogData);
        }

        //$this->send_email_rental($id_sale, "");

        $msg = "Appointment request sent successfully. Our team will be in touch with you soon";
        return redirect()->to('/appointment-request')->with('success', $msg);
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

        $fileName = 'appointment-id-' . $request->sales_id . '-' . $request->file('file_upload')->getClientOriginalName();

        $path = public_path('files/attachment/appointments/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request->file('file_upload')->move(public_path($path), $fileName);

        $item_src = $path . '/' . $fileName;
        AppointmentFile::create([
            'appointment_id' => $request->sales_id,
            'name' => $fileName,
            'type' => $request->document_type,
            'src' => $item_src,
            'date_generated' => date("Y-m-d H:i:s")
        ]);

        return redirect()->back()->with('success', 'File Attachment saved successfully!');
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


    public function updateCustomer(Request $request, $id)
    {
        $sales = Appointments::find($id);

        if (!$sales) abort(404);

        $address2 = '';
        if (!empty($request->address2))
            $address2 = ' ' . $request->address2;
        $sales->update([
            'patient_firstname' => $request->firstname,
            'patient_lastname' => $request->lastname,
            'patient_address' => $request->address1 . $address2,
            'patient_city' => $request->city,
            'patient_email' => $request->email,
            'patient_phone' => $request->phone
        ]);

        $customer = Customer::find($sales->customer_id);
        if ($customer->isDirty('email')) $this->validate($request, ['email' => 'email|unique:customers']);
        $customer->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile_no' => $request->mobile_no
        ]);

        return redirect()->back()->with('message', 'Customer Updated Successfully');
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

    public function update_appointment_comment(Request $request, $id)
    {
        $sales = Appointments::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "appointment_comment" => $request->appointment_comment
        ]);

        return redirect()->route('detail-appointment', $id)->with('success', 'Comment save successfully!');
    }

    public function appointment_doctor_assign(Request $request, $id)
    {
        $this->validate($request, [
            'doctor_id' => 'required'
        ]);

        $sales = Appointments::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "doctor_id" => $request->doctor_id,
            "doctor_status" => 'ASSIGNED',
            "doctor_comment" => $request->doctor_comment,
            "appointment_comment" => 'Assigned by ' . Auth::user()->name,
            "doctor_date" => date('Y-m-d H:i:s'),
        ]);

        $apptLogData['appointment_id'] = $id;
        $apptLogData['status'] = 'ASSIGNED';
        $apptLogData['appointment_details'] = json_encode(['doctor_comment' => $request->doctor_comment, "appointment_comment" => 'Assigned by ' . Auth::user()->name . " for " . date('d/m/Y', strtotime($sales->appointment_date)) . " " . date('H:i', strtotime($sales->appointment_time))]);
        AppointmentLogService::log($apptLogData);

        return redirect()->route('detail-appointment', $id)->with('success', 'Doctor assigned successfully!');
    }

    public function appointment_update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);

        $appointment = Appointments::find($id);

        if (!$appointment) abort(404);

        $updateApptData["status"] = $request->status;

        if (!empty($request->new_date)) {
            $updateApptData["appointment_date"] = date('Y-m-d', strtotime($request->new_date));
            $updateApptData["appointment_time"] = date('H:i:s', strtotime($request->new_date));
            $updateApptData["doctor_date"] = date('Y-m-d H:i:s', strtotime($request->new_date));
        }

        if (Auth::User()->role == 'doctor' && in_array($request->status, ['BOOKED', 'RESCHEDULED'])) {
            $updateApptData["doctor_status"] = 'CONFIRMED';
        }

        $invoiceNumber = $appointment->invoice_number;
        if (!$appointment->invoice_number && $request->status == 'Pending Payment') {
            $ebs_invoiceIdentifier = Setting::where("key", "ebs_invoiceIdentifier")->first();

            $requestId = 1;
            $invoiceCounter = new SalesInvoiceCounter();
            $invoiceCounter->sales_id = $id;
            $invoiceCounter->is_sales = 'appointment';
            $invoiceCounter->save();
            $ebs_invoiceCounter = SalesInvoiceCounter::max('id');
            if ($ebs_invoiceCounter) {
                $requestId = $ebs_invoiceCounter;
            }
            $invoiceNumber = $ebs_invoiceIdentifier->value . '' . $requestId;

            $updateApptData["invoice_number"] = $invoiceNumber;
            $this->pdf_sale($id);
        }
        $appointment->update($updateApptData);

        if ($request->status == 'REJECTED') {
            $appointmentComment = "Rejected by " . Auth::user()->name . " for " . date('d/m/Y', strtotime($appointment->appointment_date)) . " " . date('H:i', strtotime($appointment->appointment_time));
            $updateApptData["appointment_comment"] = $appointmentComment;
        } elseif (in_array($request->status, ['BOOKED'])) {
            $appointmentComment = "Confirmed by " . Auth::user()->name . " for " . date('d/m/Y', strtotime($appointment->appointment_date)) . " " . date('H:i', strtotime($appointment->appointment_time));
            $updateApptData["appointment_comment"] = $appointmentComment;
        } else {
            $appointmentComment = ucfirst(strtolower($request->status)) . " by " . Auth::user()->name . " for " . date('d/m/Y', strtotime($appointment->appointment_date)) . " " . date('H:i', strtotime($appointment->appointment_time));
            $updateApptData["appointment_comment"] = $appointmentComment;
        }

        $apptLogData['appointment_id'] = $id;
        $apptLogData['status'] = strtoupper($request->status);
        $apptLogData['appointment_details'] = json_encode(['doctor_comment' => $request->doctor_comment, 'appointment_comment' => $appointmentComment]);
        AppointmentLogService::log($apptLogData);

        return redirect()->route('detail-appointment', $id)->with('success', 'Status updated successfully!');
    }
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'status' => 'required'
        ]);

        $sales = Sales::find($id);

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
        }
        // $this->pdf_sale($id);
        //$this->pdf_invoice($id);
        //$this->pdf_delivery_note($id);
        return redirect()->route('detail-sale', $id)->with('success', 'Status updated successfully!');
    }


    public function destroy_appointment($id)
    {
        $appointments = Appointments::find($id);
        $appointments->delete();
        return redirect()->route('appointment-lists')->with('message', 'Appointment Deleted Successfully');
    }

    public function saveFrontSale(Request $request)
    {
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

            if ($customer === null) {

                $this->validate($request, [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'email' => 'email|unique:customers',
                    /* 'phone' => 'digits:10', */
                ]);
                $customer = Customer::updateOrCreate([
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

                if (!empty($data['email'])) {
                    ///check customer on user table
                    $customer = User::firstWhere("email", $data['email']);
                    if ($customer === null) {
                        $password = "123456789";
                        $customer = User::updateOrCreate([
                            'name' => $data['firstname'] . " " . $data['lastname'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'login' => $data['email'],
                            'role' => "customer",
                            'password' => Hash::make($password),
                        ]);
                    }
                }
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
                'status' => "Pending",
                'order_reference' => "",
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

            //$this->pdf_sale($id_sale);
            //$this->pdf_invoice($id_sale);
            //$this->pdf_delivery_note($id_sale);

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
                if ($paymentMethode && $paymentMethode->payment_method != 'Debit/Credit Card')
                    $send_mail = $this->send_email($id_sale, "");
            }

            //return redirect()->back()->with('success','Sale sent successfully!');

            if ($paymentMethode && $paymentMethode->payment_method == 'Debit/Credit Card') {
                return $this->mcb_payement_view($id_sale);
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
        //$this->pdf_sale($id_sale);
        //$this->pdf_invoice($id_sale);
        //$this->pdf_delivery_note($id_sale);
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

    public function details_delete($id)
    {
        $doctor_list = Doctor::get();
        $sales = Appointments::find($id);
        if ($sales === NULL) abort(404);
        $store = Store::find($sales->id_store);
        $customer = Customer::find($sales->customer_id);
        $appointmentBillableProduct = array();
        $appointmentBillable = AppointmentBillable::where("appointment_id", $id)->first();
        if ($appointmentBillable) {
            $appointmentBillableProduct = AppointmentBillableProducts::where("appointment_billable_id", $appointmentBillable->id)->get();
        }
        $sales_files = AppointmentFile::where("appointment_id", $id)->get();
        $path = public_path('/pdf/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));


        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $doctor_name = Doctor::where('id', $sales->doctor_id)->first();
        if ($doctor_name) {
            $sales->doctor_name = $doctor_name->first_name . ' ' . $doctor_name->last_name;
        } else {
            $sales->doctor_name = '';
        }
        //$this->pdf_sale($id);
        //$this->pdf_invoice($id);
        //$this->pdf_delivery_note($id);
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));


        $amount_paied = 0;
        $amount_due = 0;
        $sales_payments = AppointmentPayments::where("sales_id", $id)->get();
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        foreach ($sales_payments as &$payment) {
            $payment->payment_method = PayementMethodSales::find($payment->payment_mode);
        }
        if ($appointmentBillable) {
            $amount_due = $appointmentBillable->amount;
            $amount_paied = 0;
            //$amount_paied = floatval($amount_paied);
            $amount_due = floatval($amount_due);

            $amount_due = $appointmentBillable->amount;
            $amount_paied = AppointmentPayments::where("sales_id", $id)->sum('amount');
            $amount_credit = 0; //CreditNote::where("sales_id", $id)->sum('amount');
            if ($amount_paied == NULL) $amount_paied = 0;
            else $amount_paied = $amount_paied;

            if ($amount_credit == NULL) $amount_credit = 0;
            else $amount_credit = $amount_credit;

            $amount_paied = floatval($amount_paied);
            $amount_due = floatval($amount_due);
            $amount_credit = floatval($amount_credit);

            $amount_max = $amount_due;
            if ($appointmentBillable->status == 'Paid') {
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
        }

        $appointmentLogs = AppointmentLog::where('appointment_id', '=', $id)->get();
        $previous = Appointments::where('id', '<', $id)->orderBy('id', 'DESC')->limit(1)->first();
        $next = Appointments::where('id', '>', $id)->orderBy('id', 'ASC')->limit(1)->first();
        return view('appointment.details', compact(['doctor_name','customer', 'appointmentLogs', 'payment_mode', 'sales_payments', 'appointmentBillable', 'appointmentBillableProduct', 'sales_files', 'doctor_list', 'sales', 'pdf_src', 'amount_paied', 'amount_due', 'store',  'previous', 'next']));
    }

    public function details($id)
    {
        // Fetch appointment details
        $sales = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors

        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin') {
            if (Auth::user()->role === 'doctor') {
                if (empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id) {
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if (empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id) {
                    abort(404);
                }
            }
        }

        // Pre-fetch all required models in one go to avoid multiple queries
        $store = Store::find($sales->id_store);
        $customer = Customer::find($sales->customer_id);
        $doctor_list = Doctor::all();
        $doctor_name = Doctor::find($sales->doctor_id);
        $sales->doctor_name = $doctor_name ? $doctor_name->first_name . ' ' . $doctor_name->last_name : '';

        // Fetch appointment billables and products
        $appointmentBillable = AppointmentBillable::where('appointment_id', $id)->first();
        $appointmentBillableProduct = $appointmentBillable ? AppointmentBillableProducts::where('appointment_billable_id', $appointmentBillable->id)->get() : [];

        // Fetch appointment files
        $sales_files = AppointmentFile::where('appointment_id', $id)->get();

        // Handle directory creation logic once
        $path = public_path('/pdf/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())));
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $pdf_src = str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()));

        // Calculate payment details
        $amount_paied = AppointmentPayments::where('sales_id', $id)->sum('amount') ?? 0;
        $amount_due = $appointmentBillable ? floatval($appointmentBillable->amount) : 0;
        $amount_credit = 0;  // Future implementation for credits

        if ($appointmentBillable) {
            $status = $appointmentBillable->status;
            $amount_max = ($status === 'Paid') ? $amount_paied : $amount_due;

            if ($amount_paied && $amount_credit) {
                $amount_due -= $amount_credit;
                $amount_paied -= $amount_credit;
            } elseif ($amount_paied) {
                $amount_due -= $amount_paied;
            }
        }

        // Fetch appointment logs and sales payments
        $appointmentLogs = AppointmentLog::where('appointment_id', $id)->get();
        $sales_payments = AppointmentPayments::where('sales_id', $id)->get();
        foreach ($sales_payments as $payment) {
            $payment->payment_method = PayementMethodSales::find($payment->payment_mode);
        }

        // Fetch payment modes for sales orders
        $payment_mode = PayementMethodSales::where('is_on_bo_sales_order', 'yes')->get();

        // Previous and next appointments
        $previous = Appointments::where('id', '<', $id)->latest('id')->first();
        $next = Appointments::where('id', '>', $id)->first();

        // Return the view with the compact data
        return view('appointment.details', compact([
            'customer',
            'appointmentLogs',
            'payment_mode',
            'sales_payments',
            'appointmentBillable',
            'appointmentBillableProduct',
            'sales_files',
            'doctor_list',
            'sales',
            'pdf_src',
            'amount_paied',
            'amount_due',
            'store',
            'previous',
            'next',
            'doctor_name'
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
        $appointment = Appointments::where('id', $id_sale)->first();
        $quote = AppointmentBillable::where('appointment_id', $id_sale)->first();
        $quotes_products = [];
        if (!empty($quote))
            $quotes_products = AppointmentBillableProducts::where("appointment_billable_id", $quote->id)->get();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $ebs_typeOfPerson = Setting::where("key", "ebs_typeOfPerson")->first();


        //
        // Generate the PDF performa
        $pdf = PDF::loadView('pdf.appointment_proforma', compact('ebs_typeOfPerson', 'appointment', 'company', 'quote', 'quotes_products', 'display_logo'));

        // Determine the file path
        $fileName = 'appointment-proforma-' . $id_sale . '.pdf';
        $filePath = '/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $fileName;
        //echo $filePath;
        // Check if the file already exists
        if (Storage::disk('public_pdf')->exists($filePath)) {
            Storage::disk('public_pdf')->delete($filePath);
        }

        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/appointment-proforma-' . $id_sale . '.pdf', $pdf->output());

        // Generate the PDF invocie
        $pdf = PDF::loadView('pdf.appointment', compact('ebs_typeOfPerson', 'appointment', 'company', 'quote', 'quotes_products', 'display_logo'));

        // Determine the file path
        $fileName = 'appointment-' . $id_sale . '.pdf';
        $filePath = '/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $fileName;
        //echo $filePath;
        // Check if the file already exists
        if (Storage::disk('public_pdf')->exists($filePath)) {
            Storage::disk('public_pdf')->delete($filePath);
        }
        return  Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/appointment-' . $id_sale . '.pdf', $pdf->output());
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
                $variation = ProductVariation::find($item->product_variations_id);
                $variation_value_final = [];
                if ($variation != NULL) {
                    $variation_value = json_decode($variation->variation_value);

                    foreach ($variation_value as $v) {
                        foreach ($v as $k => $a) {
                            $attr = Attribute::find($k);
                            $attr_val = AttributeValue::find($a);
                            if (isset($attr->attribute_name) && isset($attr_val->attribute_values))
                                $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        }
                    }
                }
                $item->variation_value = $variation_value_final;
            }
        }

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $order_payment_method = PayementMethodSales::find($sale->payment_methode);

        $pdf = PDF::loadView('pdf.invoice', compact('company', 'sale', 'sales_products', 'display_logo', 'order_payment_method', 'vat_type'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/invoice-' . $id_sale . '.pdf', $pdf->output());
    }

    public function pdf_delivery_note($id_sale)
    {
        $company = Company::latest()->first();

        $sale = Sales::find($id_sale);

        $sales_products = Sales_products::where("sales_id", $id_sale)->get();

        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();

        $pdf = PDF::loadView('pdf.delivery_note', compact('company', 'sale', 'sales_products', 'display_logo'));
        return Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/delivery-note-' . $id_sale . '.pdf', $pdf->output());
    }

    public function resend_email($sales_id)
    {
        $sales = Sales::find($sales_id);
        if ($sales === NULL) return false;

        if ($sales->status == "Pending") $this->send_email($sales_id, "");
        if ($sales->status == "Paid") $this->send_paid_mail($sales_id);

        return redirect()->back()->with('success', 'Email resent successfully!');
    }

    public function send_email_rental($sales_id, $text_before_order = "")
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

        $sales = Rentals::find($sales_id);

        if ($sales === NULL) return false;

        $sales->update([
            "date_resent_mail_sale" => $date_resent_mail_sale,
            "date_resent_mail_invoice" => $date_resent_mail_invoice
        ]);


        //// sales products + product variations
        $sales_products = Rentals_products::where("sales_id", $sales_id)->get();


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

        ///html item list
        $my_items_list = '<div class="my_table">
		<table style="width:100%;">
			<tr>
			<th>Items</th>
			<th>Unit Price (Rs)</th>

			</tr>';
        foreach ($sales_products as $item) {

            /// amount with VAT calculation
            $amount = number_format(floatval($item->order_price));

            $my_items_list = $my_items_list . '<tr>
            <td style="max-width:40%;">' . $item->product_name . '</td>
            <td>' . number_format(floatval($item->order_price), 2, '.', ',') . '</td>
            </tr>';
        }


        $vat_type = "No VAT";



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
		<title>Rental Request #' . $sales_id . '</title>
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
                <br><br>Rental Request Number: ' . $sales_id . '
                <br>Rental Request Date: ' . date_format(date_create($sales->created_at), "d/m/Y") . '

            </td>
			</tr>
		</table>

		</body>
		</html>
		';



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
        Dear ' . @$customer_name . ',
        ' . @$text_before_order . '
        ' . @$text_email_before . '
        <br><br>
        <h3><b>Rental Request Summary</b></h3>
        <br>' . @$my_items_list . '
        <br>
        ' . @$comment . '
        ' . @$text_email_after . '

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
            $mail->Subject = "Submission #" . $sales_id . " - " . $company_sub;
            //$mail->SMTPDebug = true;
            $mail->Body = $mailContent;
            // $mail->AddAttachment($path, $file_name, $encoding = 'base64', $type = 'application/pdf');
            //echo $from_mail;die;
            if (!$mail->send()) {
                // unlink($path);
                return $mail->ErrorInfo;
            } else {
                // unlink($path);
                return true;
            }
        } else {
            // unlink($path);
            return false;
        }
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
                $variation = ProductVariation::find($item->product_variations_id);

                if ($variation != NULL) {
                    $variation_value = json_decode($variation->variation_value);
                    if ($variation_value) {
                        foreach ($variation_value as $v) {
                            foreach ($v as $k => $a) {
                                $attr = Attribute::find($k);
                                $attr_val = AttributeValue::find($a);
                                if (isset($attr->attribute_name) && isset($attr_val->attribute_values))
                                    $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
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
            <td>' . $item->tax_sale . '</td>
            <td>' . $amount . '</td>
            </tr>';
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
        $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>15% VAT ' . $vat_type . ' (Rs)</b></td><td>' . number_format((float)$sales->tax_amount, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td><td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td><td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
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
        Dear ' . $customer_name . ',
        ' . $text_before_order . '
        ' . $text_email_before . '
        <br><br>
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

        /*
                if ((isset($backoffice_order_mail->value) && $backoffice_order_mail->value == "yes") || (isset($onlineshop_order_mail->value) && $onlineshop_order_mail->value == "yes")) {
                    if (!empty($sales->customer_email)) {
                        $to_email = $sales->customer_email;
                        if (is_null($sales->user_id)) {
                            if (isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == "yes") {
                                if (isset($company->order_email) && !empty($company->order_email)) $cc_email = $company->order_email;
                            }
                        } else {
                            if (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == "yes") {
                                if (isset($company->order_email) && !empty($company->order_email)) $cc_email = $company->order_email;
                            }
                        }
                    } else {
                        if (isset($company->order_email) && !empty($company->order_email)) { /// check email admin
                            if (is_null($sales->user_id)) {
                                if (isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == "yes") {
                                    $to_email = $company->order_email;
                                }
                            } else {
                                if (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == "yes") {
                                    $to_email = $company->order_email;
                                }
                            }
                        }
                    }
                } else {
                    if (isset($company->order_email) && !empty($company->order_email)) { /// check email admin
                        if (is_null($sales->user_id)) {
                            if (isset($onlineshop_order_mail_admin->value) && $onlineshop_order_mail_admin->value == "yes") {
                                $to_email = $company->order_email;
                            }
                        } else {
                            if (isset($backoffice_order_mail_admin->value) && $backoffice_order_mail_admin->value == "yes") {
                                $to_email = $company->order_email;
                            }
                        }
                    }
                } */

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

    /*  public function test_email(){
        //Create an instance; passing `true` enables exceptions
       $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->Encoding = "base64";
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.zeptomail.com";
            $mail->Port = 587;
            $mail->Username = "emailapikey";
            $mail->Password = 'wSsVR610/xOlB6ooyTT8LrtuzwwEDwikFRh40VqovyL+F/rE8sc9lhWdU1WgHKIcGDFgFmcVoegtmBoE1GYNjYsvmVoECyiF9mqRe1U4J3x17qnvhDzDWG1alBOML4IKxghtk2RiEcgq+g==';
            $mail->SMTPSecure = 'TLS';
            $mail->isSMTP();
            $mail->IsHTML(true);
            $mail->CharSet = "UTF-8";
            $mail->From = "zeptomail@ecom.mu";
            $mail->addAddress('rakotonindrinapierre@gmail.com');
            $mail->Body = "Test email <b>sent</b> successfully.";
            $mail->Subject = "Test Email";
            $mail->SMTPDebug = 1;
            $mail->Debugoutput = function ($str, $level) {
                echo "debug level $level; message: $str";
                echo "<br>";
            };
            if (!$mail->Send()) {
                var_dump($mail->ErrorInfo);
            } else {
                echo "Successfully sent";
            }
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "mail sent";
        self::send_email("3","");
        $this->send_email("3","");

    }*/

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
                $variation = ProductVariation::find($item->product_variations_id);

                if ($variation != NULL) {
                    $variation_value = json_decode($variation->variation_value);
                    if ($variation_value) {
                        foreach ($variation_value as $v) {
                            foreach ($v as $k => $a) {
                                $attr = Attribute::find($k);
                                $attr_val = AttributeValue::find($a);
                                if (isset($attr->attribute_name) && isset($attr_val->attribute_values))
                                    $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                            }
                        }
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
            <td>' . $item->quantity . '</td>
            <td>' . $item->tax_sale . '</td>
            <td>' . $amount . '</td>
            </tr>';
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
        $my_items_list = $my_items_list . '
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>15% VAT ' . $vat_type . ' (Rs)</b></td><td>' . number_format((float)$sales->tax_amount, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Subtotal (Rs)</b></td><td>' . number_format((float)$sales->subtotal, 2, '.', ',') . '</td>
                    </tr>
                    <tr>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
                        <td style="background: white;border-bottom-color: white;border-left-color: white;"></td>
                        <td><b>Total (Rs)</b></td><td>' . number_format((float)$sales->amount, 2, '.', ',') . '</td>
                    </tr>
                </table>
            </div>
        ';
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

        PDF::loadHTML($html)->save('pdf_attachments/invoice-' . $sales_id . '.pdf');

        // $path = $_SERVER['DOCUMENT_ROOT'] . '/pdf_attachments/invoice-' . $sales_id . '.pdf';
        // $path = "https://bata.mu".'/pdf_attachments/invoice-' . $sales_id . '.pdf';
        // TODO:
        $path = url('/') . '/pdf_attachments/invoice-' . $sales_id . '.pdf';
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
        Dear ' . $customer_name . ',
        ' . $text_email_before . '
        <br><br>
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
            $mail->AddAttachment($path, $file_name, $encoding = 'base64', $type = 'application/pdf');
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
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
            return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
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
        return view('front.thankyou', compact([
            'headerMenuColor',
            'headerMenus',
            'homeCarousels',
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

        return view('front.sale-saved', compact(['carts', 'headerMenus', 'homeCarousels', 'company', 'shop_favicon']));
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

    public function new_sale()
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
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order", "yes")->get();
        $session_id = Session::get('session_id');
        $newsale = [];
        $have_sale_type = "no";
        if (!empty($session_id)) {
            $newsale = Newsale::where("session_id", $session_id)->get();
            foreach ($newsale as &$item) {
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
                                    if (isset($attr->attribute_name) && isset($attr_val->attribute_values))
                                        $variation_value_final = array_merge($variation_value_final, [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                                }
                            }
                        }
                    }
                }
                $item->variation = $variation;
                $item->variation_value = $variation_value_final;
                /// check if sale have sale type
                if (!empty($item->sales_type)) $have_sale_type = "yes";
            }
        }
        $sales_type = Ledger::get();
        $suppliers = Supplier::get();
        return view('sales.new', compact(['stores', 'customers', 'products', 'payment_mode', 'newsale', 'sales_type', 'suppliers', 'have_sale_type']));
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
            foreach ($products_sales as $p) {
                if ($p->tax_sale == "15% VAT" && $tax_items != "No VAT") {
                    if ($tax_items == "Included in the price") {
                        $total_amount = $total_amount + ($p->quantity * $p->order_price);
                        $tax_amount += $p->order_price * 0.15;
                    }
                    if ($tax_items == "Added to the price") {
                        $total_amount = $total_amount + ($p->quantity * ($p->order_price + ($p->order_price * 0.15)));
                        $tax_amount += $p->order_price * 0.15;
                    }
                } else {
                    $total_amount = $total_amount + ($p->order_price * $p->quantity);
                }
            }
            $amount_converted = $subtotal_converted = $tax_amount_converted = 0;
            if ($currency != "MUR") {
                $data_currency = self::get_currency($currency);
                $amount_converted = round($item->order_price / $data_currency->conversion_rates->MUR, 2);
                $subtotal_converted = round(($total_amount - $tax_amount) / $data_currency->conversion_rates->MUR, 2);
                $tax_amount_converted = round($tax_amount / $data_currency->conversion_rates->MUR, 2);
            }
            $datas = [
                'amount' => $total_amount,
                'subtotal' => $total_amount - $tax_amount,
                'tax_amount' => $tax_amount,
                'amount_converted' => $amount_converted,
                'subtotal_converted' => $subtotal_converted,
                'tax_amount_converted' => $tax_amount_converted
            ];
            $sales->update($datas);
        }


        //$this->pdf_sale($id);
        //$this->pdf_invoice($id);
        //$this->pdf_delivery_note($id);
        return redirect()->route('detail-sale', $id)->with('message', 'Journal Sale Created Successfully');
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


    public function add_item_appointment(Request $request, $id)
    {
        $appointmentDetail = Appointments::find($id);
        if (!$appointmentDetail) abort(404);
        $appointmentBillabelID = 0;
        $appointmentBillabel = AppointmentBillable::where('appointment_id', $id)->first();
        if ($appointmentBillabel) {
            $appointmentBillabelID = $appointmentBillabel->id;
        } else {
            $appointmentBillabel = new AppointmentBillable();
            $appointmentBillabel->appointment_id = $id;
            $appointmentBillabel->save();
            $appointmentBillabelID = $appointmentBillabel->id;
        }
        $product_id = 0;
        $item_vat = $request->new_item_vat;
        $item_unit_price = $request->new_item_unit_price;
        $quantity = (int)$request->new_item_quantity;
        $rental_product_name = $request->rental_product_name;

        $currency = "MUR";

        $studentData = array();
        $studentData['appointment_billable_id'] = $appointmentBillabelID;
        $studentData['quantity'] = $quantity;
        $studentData['product_id'] = $product_id;
        $studentData['order_price'] = $item_unit_price;
        $studentData['product_name'] =  $rental_product_name;
        $studentData['tax_sale'] =  $item_vat;
        $studentData['frequency'] =  $request->new_frequency;

        //print_r($studentData);exit;
        DB::table('appointment_billable_products')->insertGetId($studentData);


        //$item = Rentals_products::where('sales_id', $id)->where('product_id', $product_id)->first();



        $products_sales = AppointmentBillableProducts::where('appointment_billable_id', $appointmentBillabelID)->get();
        $total_amount = 0;
        $tax_amount = 0;
        foreach ($products_sales as $p) {
            if ($p->tax_sale == "15% VAT") {
                $total_amount = $total_amount + ($p->quantity * $p->order_price);
                $tax_amount += ($p->order_price * $p->quantity) * 0.15;
            } else {
                $total_amount = $total_amount + ($p->order_price * $p->quantity);
            }
        }

        $datas = [
            'amount' => $total_amount + $tax_amount,
            'subtotal' => $total_amount,
            'tax_amount' => $tax_amount,
            //'tax_items'=>$item_vat
        ];
        //print_r($datas);exit;

        DB::table('appointment_billable')->where('appointment_id', $id)->update($datas);
        //$sales->update($datas);



        $this->pdf_sale($id);
        // $this->pdf_invoice($id);
        // $this->pdf_delivery_note($id);
        return redirect()->route('detail-appointment', $id)->with('message', 'Appointment updated Successfully');
    }

    public function update_item_appointment(Request $request, $id)
    {

        $appointmentDetail = Appointments::find($id);
        if (!$appointmentDetail) abort(404);


        $product_id = $request->product_id;
        //$product_variations_id = $request->product_variations_id;
        $item_vat = $request->item_vat;
        $item_unit_price = $request->item_unit_price;
        $quantity = (int)$request->item_quantity;
        $currency = $request->currency;
        $appointmentBillabel = AppointmentBillable::where('appointment_id', $id)->first();
        $item = AppointmentBillableProducts::where('appointment_billable_id', $appointmentBillabel->id)->where('id', $product_id)->first();

        if ($item) {
            $product_price_converted = 0;
            if ($currency != "MUR") {
                $data_currency = self::get_currency($currency);
                $product_price_converted = round($item->order_price / $data_currency->conversion_rates->MUR, 2);
            }
            $data = [
                'order_price' => $item_unit_price,
                'quantity' => $quantity,
                // 'product_price_converted' => $product_price_converted,
                'tax_sale' => $item_vat,
                'frequency' => $request->frequency
            ];
            DB::table('appointment_billable_products')->where('id', $item->id)->update($data);
            $item->update($data);

            $tax_items = $appointmentBillabel->tax_items;

            $total_amount = 0;
            $tax_amount = 0;
            $products_sales = AppointmentBillableProducts::where('appointment_billable_id', $appointmentBillabel->id)->get();

            $total_amount = 0;
            $tax_amount = 0;
            $subtotal = 0;
            foreach ($products_sales as $p) {
                if ($p->tax_sale == "15% VAT") {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * 0.15;
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
            DB::table('appointment_billable')->where('appointment_id', $id)->update($datas);
            //$sales->update($datas);
        }


        $this->pdf_sale($id);
        // $this->pdf_invoice($id);
        // $this->pdf_delivery_note($id);
        return redirect()->route('detail-appointment', $id)->with('message', 'Appointment Billable updated Successfully');
    }


    public function destroy_appointment_item(Request $request, $id)
    {



        $product_id = $request->id;
        //$product_variations_id = $request->product_variations_id;
        $item = AppointmentBillableProducts::where('id', $product_id)->first();
        $orderPrice = $item->order_price;
        $appointmentbillableID = $item->appointment_billable_id;
        //$appointmentBillabel = $
        if ($item) {
            $appointment_billable = DB::table('appointment_billable')->where('id', $appointmentbillableID)->first();
            AppointmentBillableProducts::where('id', $product_id)->delete();


            $total_amount = 0;
            $tax_amount = 0;
            $products_sales = AppointmentBillableProducts::where('appointment_billable_id', $appointmentbillableID)->get();

            $total_amount = 0;
            $tax_amount = 0;
            $subtotal = 0;
            foreach ($products_sales as $p) {
                if ($p->tax_sale == "15% VAT") {
                    $subtotal = $subtotal + ($p->quantity * $p->order_price);
                    $tax_amount += ($p->order_price * $p->quantity) * 0.15;
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


            DB::table('appointment_billable')->where('id', $appointmentbillableID)->update($datas);
            //$sales->update($datas);
        }


        $this->pdf_sale($appointment_billable->appointment_id);
        // $this->pdf_invoice($id);
        // $this->pdf_delivery_note($id);
        return redirect()->route('detail-appointment', $appointment_billable->appointment_id)->with('message', 'Appointment Billable deleted Successfully');
    }

    public function pdf_appointment_pending_amount(Request $request, $id_sale)
    {

        $company = Company::latest()->first();
        $appointment = Appointments::where('id', $id_sale)->first();
        $quote = AppointmentBillable::where('appointment_id', $id_sale)->first();
        $quotes_products = AppointmentBillableProducts::where("appointment_billable_id", $quote->id)->get();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();


        // Generate the PDF
        $pdf = PDF::loadView('pdf.appointment_proforma', compact('appointment', 'company', 'quote', 'quotes_products', 'display_logo'));

        // Determine the file path
        $fileName = 'appointment-proforma-' . $id_sale . '.pdf';
        $filePath = '/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $fileName;
        //echo $filePath;
        // Check if the file already exists
        if (Storage::disk('public_pdf')->exists($filePath)) {
            Storage::disk('public_pdf')->delete($filePath);
        }
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/appointment-proforma-' . $id_sale . '.pdf', $pdf->output());
        //return $pdf->download('rental-'.$id_sale.'.pdf');*/



        // Generate the PDF
        $pdf = PDF::loadView('pdf.appointment', compact('appointment', 'company', 'quote', 'quotes_products', 'display_logo'));

        // Determine the file path
        $fileName = 'appointment-' . $id_sale . '.pdf';
        $filePath = '/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $fileName;
        //echo $filePath;
        // Check if the file already exists
        if (Storage::disk('public_pdf')->exists($filePath)) {
            Storage::disk('public_pdf')->delete($filePath);
        }
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/appointment-' . $id_sale . '.pdf', $pdf->output());
        //return $pdf->download('rental-'.$id_sale.'.pdf');*/
        return redirect()->route('detail-appointment', $id_sale)->with('message', 'Appointment proforma invoice updated Successfully');



        //echo '<br />del file';
        //exit;
        //return redirect()->route('detail-rental', $id_sale)->with('message', 'Rental proforma invoice updated Successfully');

        // Store the new PDF file
        // Storage::disk('public_pdf')->put($filePath, $pdf->output());

        // Return the download response
        //return $pdf->download($fileName);


        /* $company = Company::latest()->first();


        $quote = Rentals::find($id_sale);

        $quotes_products = Rentals_products::where("sales_id", $id_sale)->get();

        $display_logo = Setting::where("key","display_logo_in_pdf")->first();

        $pdf = PDF::loadView('pdf.rental', compact('company', 'quote', 'quotes_products', 'display_logo'));
        Storage::disk('public_pdf')->put('/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/rental-' . $id_sale . '.pdf', $pdf->output());
        return $pdf->download('rental-'.$id_sale.'.pdf');*/
        // return redirect()->route('detail-rental', $id_sale)->with('message', 'Rental proforma invoice updated Successfully');
    }


    public function update_order_reference(Request $request, $id)
    {
        $sales = Appointments::find($id);

        if (!$sales) abort(404);

        $sales->update([
            "order_reference" => $request->order_reference,
        ]);

        $this->pdf_sale($id);
        //$this->pdf_invoice($id);
        //$this->pdf_delivery_note($id);

        return redirect()->route('detail-appointment', $id)->with('success', 'Order Reference Updated successfully!');
    }

    public function sendContactUs(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'query' => 'required|string',
        ]);

        // Accessing validated data
        $name = $validated['name'];
        $email = $validated['email'];
        $query = $validated['query'];

        // Fetch company details
        $company = Company::first(); // Ensure you fetch the company details before using them
        $from_mail = $company->order_email ?? 'noreply@ecom.mu';
        $company_sub = $company->company_name ?? 'Ecom';

        // Fetch SMTP settings
        $email_smtp = Email_smtp::latest()->first();
        $smtp_username = $email_smtp->username ?? env('SMTP_USERNAME');
        $smtp_password = $email_smtp->password ?? env('SMTP_PASSWORD');

        // Fetch email settings
        $email_cc_admin = Setting::where('key', 'email_cc_admin')->first();
        $email_bcc_admin = Setting::where('key', 'email_bcc_admin')->first();

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.zeptomail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient settings
            $mail->setFrom($from_mail, $company_sub);
            $mail->addReplyTo($from_mail, $company_sub);
            $mail->addAddress($email);

            // CC and BCC settings
            if ($email_cc_admin && !empty($email_cc_admin->value)) {
                $cc_email = explode(',', $email_cc_admin->value);
                foreach ($cc_email as $cc) {
                    $mail->addCC(trim($cc));
                }
            }
            if ($email_bcc_admin && !empty($email_bcc_admin->value)) {
                $bcc_email = explode(',', $email_bcc_admin->value);
                foreach ($bcc_email as $bcc) {
                    $mail->addBCC(trim($bcc));
                }
            }

            // Content settings
            $mail->isHTML(true);
            $mail->Subject = "Contact Us: $name";
            $mail->Body = nl2br($query);

            // Send the email
            $mail->send();

            // Redirect with success message
            return redirect()->route('contact-us')->with('success', 'Your message has been sent successfully. Our team will be in touch with you soon.');
        } catch (Exception $e) {
            // Log the error and redirect with error message
            \Log::error('Email sending failed: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Email sending failed: ' . $e->getMessage() . ' Please try again later.');
        }
    }
}
