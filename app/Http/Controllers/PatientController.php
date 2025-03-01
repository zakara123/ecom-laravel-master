<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Exports\CustomerItems;
use App\Imports\CustomersImport;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\SalesPayments;
use App\Models\Products;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Stock;
use App\Models\Category_product;
use App\Models\Category;
use App\Models\Store;
use App\Models\Sales_products;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\PatientMedication;
use App\Models\PatientDietarySupplement;
use App\Models\PatientImmunization;
use App\Models\PatientHomeMedicalEquipment;
use App\Models\PatientContacts;
use App\Models\PatientHospitalization;
use App\Models\PatientInsurance;
use App\Models\PatientImplantedDevice;
use App\Models\PatientMedicalAids;
use App\Models\PatientFamilyHistory;
use App\Models\PatientAlternativeTherapy;
use App\Models\PatientPhysioRehab;
use App\Models\PatientOPDVisits;
use App\Models\PatientPhysicians;
use App\Models\PatientConfidentialNote;
use App\Models\PatientAllergies;
use App\Models\PatientSurgery;
use App\Models\PatientDiagnosis;
use App\Models\PatientEpisodesInjuries;
use App\Models\PatientAdvancedDirectives;





use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PDF;
use DB;

class PatientController extends Controller
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
        /* company_name
        'firstname'
            'lastname' */
        // $customers = Customer::latest()->orderBy('id', 'DESC')->paginate(10);
        $customers = Customer::where('type','patient')->where([
            ['company_name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('company_name', 'LIKE', '%' . $s . '%')
                        ->orWhere('firstname', 'LIKE', '%' . $s . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy('id', 'DESC')->paginate(10);
        return view('patient.index', compact(['customers', 'ss']));
    }

    public function search(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        /* company_name
        'firstname'
            'lastname' */
        // $customers = Customer::latest()->orderBy('id', 'DESC')->paginate(10);
        $customers = Customer::where('type','patient')->where([
            ['company_name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('company_name', 'LIKE', '%' . $s . '%')
                        ->orWhere('firstname', 'LIKE', '%' . $s . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy('id', 'DESC')->paginate(10);
        return view('patient.search_ajax', compact(['customers', 'ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
              'email' => 'required|email',
             'mobile_no' => 'required',
            'nid' => 'required',
        ], [
            'firstname.required' => 'First Name is required', // Custom error message for 'firstname'
            'lastname.required' => 'Last Name is required', // Custom error message for 'lastname'
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address', // Custom error message for invalid email format
             'mobile_no.required' => 'Mobile number is required',
            'nid.required' => 'National ID is required'
        ]);
        

        $lastCustomer =  Customer::where('type','Patient')->latest()->first();

        $count = $lastCustomer ? (int) substr($lastCustomer->upi, 6) : 0;
        $upi = date('Y'). sprintf('%07d', $count + 1);

        $customer = Customer::updateOrCreate([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'company_name' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile_no' => $request->mobile_no,
            'date_of_birth' => $request->date_of_birth,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'work_address' => $request->work_address,
            'work_village' => $request->work_village,
            'other_village' => $request->other_village,
            'other_address' => $request->other_address,
            'whatsapp' => $request->whatsapp,
            'nid'=> $request->nid,
            'type'=>'patient',
            'fax' => NULL,
            'upi'=>$upi,

            ]);

            $user = User::firstWhere("email", $request->email);
            if (!$user) {
                $password = "123456789";
                $user = User::updateOrCreate([
                    'name' => $request->firstname . " " . $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->email,
                    'role' => "patient",
                    'password' => Hash::make($password),
                ]);

                DB::table('customers')->where('id',$customer->id)->update(array('user_id'=>$user->id));

            }



        return redirect()->route('patients.index')->with('message', 'Patient Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function patient_edit($id)
    {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);
        if( $customer->is_default == "yes"){
            abort(404);
        }

        return view('patient.edit', compact('customer','user'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function patient_details($id)
    {
        $customer = Customer::find($id);
        $sales = Appointments::where('customer_id', '=', $id)->orderBy('id', 'ASC')->get();
        $balance = 0;



        return view('patient.statements', compact(
            ['customer',
                'sales'
            ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => 'required'
        ]);


        $customer = Customer::find($id);
        if ($customer->isDirty('email')) $this->validate($request, ['email' => 'email|unique:customers']);
        $customer->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile_no' => $request->mobile_no,
            'date_of_birth' => $request->date_of_birth,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'work_address' => $request->work_address,
            'work_village' => $request->work_village,
            'other_village' => $request->other_village,
            'other_address' => $request->other_address,
            'whatsapp' => $request->whatsapp,
            'sex' => $request->sex,
            'blood_group' => $request->blood_group,
            'nid'=> $request->nid,
            ]);

            $user = User::find($customer->user_id);

            if ($user && $request->account_password) {
                //dd($user);
                $user->update([
                    'name' => $request->firstname . " " . $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->email,
                    'account_status'=>$request->account_status,
                    'password' => Hash::make($request->account_password),
                ]);
            }else{
                $user->update([
                    'name' => $request->firstname . " " . $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->email,
                    'account_status'=>$request->account_status,
                ]);
            }

        return redirect()->route('medical-record',$id)->with('message', 'Patient Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if( $customer->is_default == "yes"){
            abort(404);
        }
        $customer->delete();
        return redirect()->route('customer.index')->with('message', 'Customer Deleted Successfully');
    }

    public function importCustomerView(Request $request)
    {
        return view('customer.importCustomerFile');
    }

    public function customer_export_items(Request $request,$id)
    {
        return Excel::download(new CustomerItems($id), 'customer-sales-items-' . date('Y-m-d-h-i-s') . '.xlsx');
    }

    public function importCustomer(Request $request)
    {
        Excel::import(new CustomersImport, $request->file('file'));
        return redirect()->route('customer.index')->with('message', 'Item imported Successfully');
    }

    public function list_order_customer_pdf($id)
    {

        $payment30 = $this->get_customer_payment_due_days($id, "30");
        $payment60 = $this->get_customer_payment_due_days($id, "31", "60");
        $payment90 = $this->get_customer_payment_due_days($id, "61", "90");
        $payment120 = $this->get_customer_payment_due_days($id, "91", "120");
        $payment150 = $this->get_customer_payment_due_days($id, "121", "150");
        $payment365 = $this->get_customer_payment_due_days($id, "151", "365");
        $paymentmoreyear = $this->get_customer_payment_due_days($id, "365", "more");
        $payment_due_html = '<div class="my_table">
        <table style="width:100%">
            <tr>
            <th>0 - 30 Days</th>
            <th>31 - 60 Days</th>
            <th>61 - 90 Days</th>
            <th>91 - 120 Days</th>
            <th>121 - 150 Days</th>
            <th>151 - 365 Days</th>
            <th>+ 365 Days</th>
            </tr>';

        $payment_due_html = $payment_due_html . '
        <tr>
            <td>Rs ' . $payment30 . '</td>
            <td>Rs ' . $payment60 . '</td>
            <td>Rs ' . $payment90 . '</td>
            <td>Rs ' . $payment120 . '</td>
            <td>Rs ' . $payment150 . '</td>
            <td>Rs ' . $payment365 . '</td>
            <td>Rs ' . $paymentmoreyear . '</td>
        </tr></table></div>
        ';

        $history_list = '<div class="my_table">
        <table style="width:100%">
            <tr>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Payment Mode</th>
            <th>Payment Reference</th>
            <th>Order Amount</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            </tr>';

        $date_begin = '';
        $date_end = '';
        $n = 0;
        $last_history = NULL;
        $total_order_amount = 0;
        $total_payment_amount = 0;
        $total_payment_due = 0;
        $text_methode = '';
        $orders = Sales::select('id', 'amount', 'currency', 'status', 'order_reference',
            'customer_id', 'customer_firstname', 'customer_lastname', 'customer_address',
            'customer_city', 'customer_email', 'customer_phone', 'payment_methode', 'created_at as order_date')
            ->where('customer_id', '=', $id)->orderBy('id', 'ASC')->get();
        foreach ($orders as &$sale) {
            $method = PayementMethodSales::find($sale->payment_methode);
            $sale->payment_method = $method->payment_method;

            $orders_paid = SalesPayments::
            select('id as payment_id', 'sales_id', 'payment_date AS order_date', 'payment_mode', 'payment_reference', 'amount')
                ->where('sales_id', '=', $sale->id)->get();

            if (count($orders_paid))
                foreach ($orders_paid as $op) {
                    $method_ = PayementMethodSales::find($op->payment_mode);
                    if(!is_null($method_)){
                        $op->payment_method = $method_->payment_method;
                        $orders->push($op);
                    }
                }

        }
        $history_order_payement = $orders;
        $history_order_payement = collect($history_order_payement)->sortBy('order_date')->reverse();
        $a_due = 0;
        foreach ($history_order_payement as $o) {
            $date_update = date_format(date_create($o->order_date), "d/m/Y");
            $date = "";
            $payment_reference = "";
            $order_id = $o->id;
            if ($o->payment_id) $order_id = $o->payment_id;
            $invoice_id = date_format(date_create($o->order_date), "Ymd") . '-' . $order_id;
            $text_methode = $o->payment_method;
            $amount = number_format($o->amount, 2, '.', ',');
            $amount_payement = number_format(0, 2, '.', ',');

            if (isset($o->payment_id)) {
                $amount_payement = number_format($o->amount, 2, '.', ',');
                $total_order_amount += 0;
                $a_due -= $o->amount;
                $total_payment_amount += $o->amount;
            } else {
                $total_order_amount += $o->amount;
                $a_due += $o->amount;
            }
            $amount_due = number_format($a_due, 2, '.', ',');
            if (isset($o->order_date)) $date = date_format(date_create($o->order_date), "d/m/Y");
            if (isset($o->payment_reference)) $payment_reference = $o->payment_reference;

            $amount_payement_final = '';
            $amount_final = '';
            if ($amount_payement != "0.00") {
                $amount_payement_final = 'Rs ' . $amount_payement;
            } else {
                $amount_final = 'Rs ' . $amount;
            }

            if ($date == '') {
                $date = $date_update;
            }

            $history_list = $history_list . '
            <tr>

                <td>' . $date . '</td>
                <td>' . $invoice_id . '</td>
                <td>' . $text_methode . '</td>
                <td>' . $payment_reference . '</td>
                <td>' . $amount_final . '</td>
                <td>' . $amount_payement_final . '</td>
                <td>Rs ' . $amount_due . '</td>

            </tr>
            ';
            $last_history = $o;

            if ($n == 0) $date_begin = $date;
            if ($n != 0) $date_end = $date;
            $n++;
        }


        $amount_last_history = 0;
        $amount_last_paid = 0;
        $amount_last_due = 0;
        $amount_last_history = floatval($total_order_amount);
        $amount_last_paid = floatval($total_payment_amount);
        if ($amount_last_history == 0) {
            $amount_last_due = $amount_last_paid;
        } else {
            if ($amount_last_history > $amount_last_paid) {
                $amount_last_due = $amount_last_history - $amount_last_paid;
            } else {
                $amount_last_due = $amount_last_paid - $amount_last_history;
            }
        }

        $history_list = $history_list . '<tr>

            <td style="border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
            <td style="border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
            <td style="border-bottom-color: white;border-left-color: white;"></td>
            <td><b>Total</b></td>
            <td>Rs ' . number_format($amount_last_history, 2, '.', ',') . '</td>
            <td>Rs ' . number_format($amount_last_paid, 2, '.', ',') . '</td>
            <td>Rs ' . number_format($amount_last_due, 2, '.', ',') . '</td>

        </tr>';
        $history_list = $history_list . '</table></div>';


        $title = 'Customer Statements';
        if ($date_begin == $date_end) $title = 'Statement of ' . $date_begin;
        else $title = 'Statement from ' . $date_end . ' to ' . $date_begin;
        $style_bottom = "border-bottom-color: white;";

        $company = Company::first();
        $customers = Customer::find($id);
        $html_company = '';
        $html_company_name = '';
        if ($company != NULL) {
            $html_company_name = $company->company_name;
            $html_fax = '';
            $html_brn = '';
            $html_vat = '';
            if (!empty($company->company_fax)) $html_fax = ' FAX : ' . $company->company_fax;
            if (!empty($company->brn_number)) $html_brn = ' <br>BRN : ' . $company->brn_number;
            if (!empty($company->vat_number)) $html_vat = ' VAT : ' . $company->vat_number;
            $html_company = $company->company_address . '
            <br>Tel : ' . $company->company_phone . $html_fax . '
            <br>Email : ' . $company->company_email . '
            ' . $html_brn . $html_vat;
        }
        $html_brn = '';
        if (isset($customers->brn_customer) && $customers->brn_customer != '' && $customers->brn_customer != NULL) {
            $html_brn = '<br>BRN : ' . $customers->brn_customer . '';
        }
        if (isset($customers->vat_customer) && $customers->vat_customer != '' && $customers->vat_customer != NULL) {
            $html_brn = $html_brn . '<br>VAT : ' . $customers->vat_customer . '';
        }


        $customer_name = $customers->firstname . ' ' . $customers->lastname;
        if (empty($customer_name)) $customer_name = $company->company_name;

        $css_image = "";

        if (isset($company->logo) && !empty($company->logo)) {
            $css_image = '<td><img style="width: 120px;height: auto;" src="' . public_path($company->logo) . '"></td>';
        }

        $html = '<!DOCTYPE html>
		<html>
		<head>
		<title>' . $title . '</title>
		<style>
            .my_table table {
                border-collapse: collapse;
            }

            .my_table table,
            .my_table td,
            .my_table th {
                border: 1px solid black;
                text-align: center;
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

                    <td colspan="2" style="text-align: center;margin: -10%;">
                        <h2>' . $html_company_name . '</h2>
                        ' . $html_company . '
                    </td>
                </tr>
            </table>
			<table style="width:100%">
			<tr>
                <td>
                <br><br>Customer : ' . $customer_name . '
                <br>' . $customers->address . '
                <br>' . $customers->email . '
                <br>Phone Number : ' . $customers->phone . '
                ' . $html_brn . '
                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">

			</td>
			</tr>
		</table>
		<h3><div style="text-align:center">Aged Payables</div></h3>
        ' . $payment_due_html . '
        <br>
		<h3><div style="text-align:center">' . $title . '</div></h3>
        ' . $history_list . '
		</body>
		</html>
		';
//        echo $html;
        return PDF::loadHTML($html)->download($customer_name . '-' . date('Y-m-d-H-i-s') . '.pdf');


    }

    public function list_order_customer_between_pdf(Request $request, $id)
    {
        $this->validate($request, [
            'start' => 'required',
            'end' => 'required',
        ]);

        $date_start = date('Y-m-d', strtotime(str_replace('/', '-', $request->start)));
        $date_end = date('Y-m-d', strtotime(str_replace('/', '-', $request->end)));
        if ($date_end < $date_start && $request->end != '') {
            $date_f = $date_start;
            $date_start = $date_end;
            $date_end = $date_f;
        }
        $total_paided = 0;
        $total_to_paie = 0;
        $total_last_balance = 0;
        $last_paiement = 0;
        $total_paiement = 0;
        $total_order = 0;
        $last_order = 0;
        $orders = Sales::select('id', 'amount', 'currency', 'status', 'order_reference',
            'customer_id', 'customer_firstname', 'customer_lastname', 'customer_address',
            'customer_city', 'customer_email', 'customer_phone', 'payment_methode', 'created_at as order_date')
            ->where('customer_id', '=', $id)->orderBy('id', 'ASC')->get();

        $orders_h = new Collection();
        foreach ($orders as $order) {
            $date_o = date('Y-m-d', strtotime(str_replace('/', '-', $order->order_date)));
            if ($date_o >= $date_start && $date_o <= $date_end) {
                $method = PayementMethodSales::find($order->payment_methode);
                $order->payment_method = $method->payment_method;
                $orders_h->push($order);
            } else if ($date_o < $date_start) {
                $last_order += $order->amount;
            }
            $total_order += $order->amount;
        }

        foreach ($orders as $sale) {
            $orders_paid = SalesPayments::
            select('id as payment_id', 'sales_id', 'payment_date AS order_date', 'payment_mode', 'payment_reference', 'amount')
                ->where('sales_id', '=', $sale->id)->get();

            if (count($orders_paid))
                foreach ($orders_paid as $op) {
                    $method_ = PayementMethodSales::find($op->payment_mode);
                    $op->payment_method = $method_->payment_method;
                    $date_h = date('Y-m-d', strtotime(str_replace('/', '-', $op->order_date)));
                    if ($date_h >= $date_start && $date_h <= $date_end) {
                        $orders_h->push($op);
                    } else if ($date_h < $date_start) {
                        $last_paiement += $op->amount;
                        $total_paided += $op->amount;
                    }
                    $total_paiement += $op->amount;

                }
        }
        $total_to_paie = $last_order - $last_paiement;
        if ($last_paiement > $last_order) {
            $total_to_paie = $last_paiement - $last_order;
        }
        $total_last_balance = $total_order - $total_paiement;
        if ($total_paiement > $total_order) {
            $total_last_balance = $total_paiement - $total_order;
        }

        $payment30 = $this->get_customer_payment_due_days($id, "30");
        $payment60 = $this->get_customer_payment_due_days($id, "31", "60");
        $payment90 = $this->get_customer_payment_due_days($id, "61", "90");
        $payment120 = $this->get_customer_payment_due_days($id, "91", "120");
        $payment150 = $this->get_customer_payment_due_days($id, "121", "150");
        $payment365 = $this->get_customer_payment_due_days($id, "151", "365");
        $paymentmoreyear = $this->get_customer_payment_due_days($id, "365", "more");
        $payment_due_html = '<div class="my_table">
        <table style="width:100%">
            <tr>
            <th>0 - 30 Days</th>
            <th>31 - 60 Days</th>
            <th>61 - 90 Days</th>
            <th>91 - 120 Days</th>
            <th>121 - 150 Days</th>
            <th>151 - 365 Days</th>
            <th>+ 365 Days</th>
            </tr>';

        $payment_due_html = $payment_due_html . '
        <tr>
            <td>Rs ' . $payment30 . '</td>
            <td>Rs ' . $payment60 . '</td>
            <td>Rs ' . $payment90 . '</td>
            <td>Rs ' . $payment120 . '</td>
            <td>Rs ' . $payment150 . '</td>
            <td>Rs ' . $payment365 . '</td>
            <td>Rs ' . $paymentmoreyear . '</td>
        </tr></table></div>
        ';

        $history_list = '<div class="my_table">
        <table style="width:100%">
            <tr>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Payment Mode</th>
            <th>Payment Reference</th>
            <th>Order Amount</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            </tr>';

        $n = 0;
        $last_history = NULL;
        $total_order_amount = 0;
        $total_payment_amount = 0;
        $total_payment_due = 0;
        $text_methode = '';

        $history_order_payement = $orders_h;
        $history_order_payement = collect($history_order_payement)->sortBy('order_date')->reverse();

        $a_due = 0;
        foreach ($history_order_payement as $o) {
            $date_update = date_format(date_create($o->order_date), "d/m/Y");
            $date = "";
            $payment_reference = "";
            $order_id = $o->id;
            if ($o->payment_id) $order_id = $o->payment_id;
            $invoice_id = date_format(date_create($o->order_date), "Ymd") . '-' . $order_id;
            $text_methode = $o->payment_method;
            $amount = number_format($o->amount, 2, '.', ',');
            $amount_payement = number_format(0, 2, '.', ',');

            if (isset($o->payment_id)) {
                $amount_payement = number_format($o->amount, 2, '.', ',');
                $total_order_amount += 0;
                $a_due -= $o->amount;
                $total_payment_amount += $o->amount;
            } else {
                $total_order_amount += $o->amount;
                $a_due += $o->amount;
            }
            $amount_due = number_format($a_due, 2, '.', ',');
            if (isset($o->order_date)) $date = date_format(date_create($o->order_date), "d/m/Y");
            if (isset($o->payment_reference)) $payment_reference = $o->payment_reference;

            $amount_payement_final = '';
            $amount_final = '';
            if ($amount_payement != "0.00") {
                $amount_payement_final = 'Rs ' . $amount_payement;
            } else {
                $amount_final = 'Rs ' . $amount;
            }

            if ($date == '') {
                $date = $date_update;
            }

            $history_list = $history_list . '
            <tr>

                <td>' . $date . '</td>
                <td>' . $invoice_id . '</td>
                <td>' . $text_methode . '</td>
                <td>' . $payment_reference . '</td>
                <td>' . $amount_final . '</td>
                <td>' . $amount_payement_final . '</td>
                <td>Rs ' . $amount_due . '</td>

            </tr>
            ';
            $last_history = $o;
        }


        $amount_last_history = 0;
        $amount_last_paid = 0;
        $amount_last_due = 0;
        $amount_last_history = floatval($total_order_amount);
        $amount_last_paid = floatval($total_payment_amount);
        if ($amount_last_history == 0) {
            $amount_last_due = $amount_last_paid;
        } else {
            if ($amount_last_history > $amount_last_paid) {
                $amount_last_due = $amount_last_history - $amount_last_paid;
            } else {
                $amount_last_due = $amount_last_paid - $amount_last_history;
            }
        }

        $history_list = $history_list . '<tr>

            <td style="border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
            <td style="border-bottom-color: white;border-left-color: white;border-right-color: white;"></td>
            <td style="border-bottom-color: white;border-left-color: white;"></td>
            <td><b>Total</b></td>
            <td>Rs ' . number_format($amount_last_history, 2, '.', ',') . '</td>
            <td>Rs ' . number_format($amount_last_paid, 2, '.', ',') . '</td>
            <td>Rs ' . number_format($amount_last_due, 2, '.', ',') . '</td>

        </tr>';
        $history_list = $history_list . '</table></div>';


        $title = 'Customer Statements';
        if ($date_start == $date_end) $title = 'Statement of ' . date_format(date_create($date_start), "d/m/Y");
        else $title = 'Statement from ' . date_format(date_create($date_start), "d/m/Y") . ' to ' . date_format(date_create($date_end), "d/m/Y");

        $style_bottom = "border-bottom-color: white;";

        $company = Company::first();
        $customers = Customer::find($id);
        $html_company = '';
        $html_company_name = '';
        if ($company != NULL) {
            $html_company_name = $company->company_name;
            $html_fax = '';
            $html_brn = '';
            $html_vat = '';
            if (!empty($company->company_fax)) $html_fax = ' FAX : ' . $company->company_fax;
            if (!empty($company->brn_number)) $html_brn = ' <br>BRN : ' . $company->brn_number;
            if (!empty($company->vat_number)) $html_vat = ' VAT : ' . $company->vat_number;
            $html_company = $company->company_address . '
            <br>Tel : ' . $company->company_phone . $html_fax . '
            <br>Email : ' . $company->company_email . '
            ' . $html_brn . $html_vat;
        }
        $html_brn = '';
        if (isset($customers->brn_customer) && $customers->brn_customer != '' && $customers->brn_customer != NULL) {
            $html_brn = '<br>BRN : ' . $customers->brn_customer . '';
        }
        if (isset($customers->vat_customer) && $customers->vat_customer != '' && $customers->vat_customer != NULL) {
            $html_brn = $html_brn . '<br>VAT : ' . $customers->vat_customer . '';
        }


        $customer_name = $customers->firstname . ' ' . $customers->lastname;
        if (empty($customer_name)) $customer_name = $company->company_name;

        $css_image = "";

        if (isset($company->logo) && !empty($company->logo)) {
            $css_image = '<td><img style="width: 120px;height: auto;" src="' . public_path($company->logo) . '"></td>';
        }

        $html = '<!DOCTYPE html>
		<html>
		<head>
		<title>' . $title . '</title>
		<style>
            .my_table table {
                border-collapse: collapse;
            }

            .my_table table,
            .my_table td,
            .my_table th {
                border: 1px solid black;
                text-align: center;
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

                    <td colspan="2" style="text-align: center;margin: -10%;">
                        <h2>' . $html_company_name . '</h2>
                        ' . $html_company . '
                    </td>
                </tr>
            </table>
			<table style="width:100%">
			<tr>
                <td>
                <br><br>Customer : ' . $customer_name . '
                <br>' . $customers->address . '
                <br>' . $customers->email . '
                <br>Phone Number : ' . $customers->phone . '
                ' . $html_brn . '
                </td>
                <td style="width:100px"></td>
                <td style="text-align:right">

			</td>
			</tr>
		</table>
		<h3><div style="text-align:center">Aged Payables</div></h3>
        ' . $payment_due_html . '
        <br>
		<h3><div style="text-align:center">' . $title . '</div></h3>
        ' . $history_list . '
		</body>
		</html>
		';
//        echo $html;
        return PDF::loadHTML($html)->download($customer_name . '-' . date('Y-m-d-H-i-s') . '.pdf');


    }

    public function get_customer_payment_due_days($id_customer, $day_begin, $day_end = "")
    {

        $result = [];

        if ($day_end == "") {
            $result = Sales::whereBetween('created_at', [
                DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $day_begin . ' DAY)'),
                DB::raw('CURDATE()')])
                ->whereIn('status', ['pending', 'completed'])
                ->where('customer_id', '=', $id_customer)
                ->get();
        } else {
            if ($day_begin == "365") {
                $result = Sales::where('created_at', '<=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 365 DAY)'))
                    ->whereIn('status', ['pending', 'completed'])
                    ->where('customer_id', '=', $id_customer)
                    ->get();
            } else {
                Sales::whereBetween('created_at', [
                    DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $day_end . ' DAY)'),
                    DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $day_begin . ' DAY)')])
                    ->whereIn('status', ['pending', 'completed'])
                    ->where('customer_id', '=', $id_customer)
                    ->get();
            }
        }

        $sum = 0;
        foreach ($result as $r) {
            $amount_payment = 0;
            $amount_p = SalesPayments::where('sales_id', $r->id)->sum('amount');
            if ($amount_p) $amount_payment = $amount_p;
            $sum = $sum + floatval($r->amount - $amount_payment);
        }


        return number_format($sum, 2, '.', ',');
    }

    public function productCustomerView($id)
    {
        $export_item = array();
        $sales_i = array();
        $sales = Sales::where('customer_id','=',$id)->orderBy('id', 'desc')->pluck('id');
        $customer = Customer::find($id);
        $customer_name = "";


        if($customer){
            if($customer->firstname || $customer->lastname) $customer_name = $customer->firstname . ' ' . $customer->lastname;
            else $customer_name = $customer->name;
        }

        if (count($sales)) {
            foreach($sales as $s) array_push($sales_i,$s);
            $productss = Sales_products::whereIn('sales_id',$sales_i)->paginate(8);
            if (count($productss)) {
                foreach($productss as &$product_s){
                    $sales_info = Sales::find($product_s->sales_id);
                    $product = Products::find($product_s->product_id);

                    if(isset($product->id)){
                        $stock_product = DB::table('stocks')
                        ->where('products_id', $product->id)
                        ->where('product_variation_id', $product_s->product_variations_id)->orderBy('id', 'desc')->first();
                    $quantity_stock_product = '';
                    $barcode_product = '';

                    if (isset($stock_product->quantity_stock) && isset($stock_product->barcode_value)) {
                        $quantity_stock_product = $stock_product->quantity_stock;
                        $barcode_product = $stock_product->barcode_value;
                    }

                    $categoryproduct = Category_product::where('id_product', $product['id'])->get();
                    foreach ($categoryproduct as &$cp) {
                        $category = Category::find($cp->id_category);
                        $cp['category_name'] = $category->category;
                    }
                    $product['categoryproduct'] = $categoryproduct;
                    $category_ = '';
                    $supplier = '';

                    if (count($product->categoryproduct) > 0) {
                        $loop = 0;
                        foreach ($product->categoryproduct as $category) {
                            if ($loop < (count($product->categoryproduct) - 1))
                                $category_ .= $category->category_name . ';';
                            else
                                $category_ .= $category->category_name;

                            $loop++;
                        }
                    } else  $category_ = 'Uncategorized';

                    if ($product->id_supplier) {
                        $supplier_product = Supplier::find($product->id_supplier);
                        $supplier = $supplier_product->name;
                    }

                    $store = '';
                    $store_p = Stock::where('products_id', $product->id)
                        ->orderBy('id', 'desc')->first();

                    if ((bool)$store_p) {
                        if (isset($store_p->store_id) && is_null($store_p->store_id)){
                            $store_product = Store::find($stock->store_id);
                            $store = $store_product->name;
                        }
                    }

                    $stock_t = DB::table('stocks')
                    ->where('products_id', $product->id)
                    ->orderBy('id', 'desc')->first();
                    $sku_ss = '';
                    if($stock_t) $sku_ss = $stock_t->sku;
                    $product_variation = DB::table('product_variations')->where('products_id', $product->id)->where('id', $product_s->product_variations_id)->get();
                    if(count($product_variation)){
                        foreach ($product_variation as $key1 => $variation) {
                            $variation = (array)$variation;
                            $variation_value = json_decode($variation['variation_value']);
                            $variation['variation_value'] = [];
                            if ($variation_value != NULL) {
                                foreach ($variation_value as $v) {
                                    foreach ($v as $k => $a) {
                                        $attr = Attribute::find($k);
                                        $attr_val = AttributeValue::find($a);
                                        if (!empty($attr_val->attribute_values) && !empty($attr->attribute_name))
                                            $variation['variation_value'] = array_merge($variation['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                                    }
                                }
                            }
                            $variation = (object)$variation;
                            $product_variation[$key1] = $variation;
                        }


                        foreach ($product_variation as $key1 => $variation) {
                            $i = 1;
                            $attribute = array();
                            $stock = DB::table('stocks')
                                ->where('products_id', $product->id)
                                ->where('product_variation_id', $variation->id)->orderBy('id', 'desc')->first();

                            if($stock) $sku_ss = $stock->sku;
                            $product_s->sale_ref = $sales_info->order_reference;
                            $product_s->customer = $customer_name;
                            $product_s->sale_date = date('d/m/Y',strtotime($sales_info->created_at));
                            $product_s->product_name = $product->name;
                            $product_s->price_selling = $variation->price;
                            $product_s->price_buying = $variation->price_buying;
                            $product_s->unit = $product->unit_selling_label;
                            $product_s->line_amount = $product_s->quantity * $variation->price;
                            $product_s->sale_amount = $sales_info->amount;
                            $product_s->vat = $product->vat;
                            $product_s->description = $product->description;
                            $product_s->sku = $sku_ss;
                            $quantity_stock = '';
                            $barcode_value = '';

                            if (isset($stock->quantity_stock) && isset($stock->barcode_value)) {
                                $quantity_stock = $stock->quantity_stock;
                                $barcode_value = $stock->barcode_value;
                            }
                            $product_s->barcode = $barcode_value;
                            $product_s->category = '';
                            $product_s->supplier = $supplier;
                            $product_s->store = $store;
                            $product_s->variation = $variation->variation_value;
                        }

                    }
                    else {
                            $product_s->sale_ref = $sales_info->order_reference;
                            $product_s->customer = $customer_name;
                            $product_s->sale_date = date('d/m/Y',strtotime($sales_info->created_at));
                            $product_s->product_name = $product->name;
                            $product_s->price_selling = $product->price;
                            $product_s->price_buying = $product->price_buying;
                            $product_s->unit = $product->unit_selling_label;
                            $product_s->line_amount = $product_s->quantity * $product->price;
                            $product_s->sale_amount = $sales_info->amount;
                            $product_s->vat = $product->vat;
                            $product_s->description = $product->description;
                            $product_s->sku = $sku_ss;
                            $product_s->barcode = $barcode_product;
                            $product_s->category = $category_;
                            $product_s->supplier = $supplier;
                            $product_s->store = $store;
                            $product_s->variation = '';
                    }
                    }

                }
            }
        }



        return view('customer.product',compact(['productss','customer_name','customer']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_past_medication(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        /* company_name
        'firstname'
            'lastname' */
        // $customers = Customer::latest()->orderBy('id', 'DESC')->paginate(10);
        $customer = Customer::find($id);
        $customers = PatientMedication::where('medication_type','2')->orderBy('id', 'DESC')->paginate(10);
        return view('patient.post_medication', compact(['customer','customers', 'ss']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_current_medication(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientMedication::where('medication_type','1')->orderBy('id', 'DESC')->paginate(10);
        return view('patient.current_medication', compact(['customer','customers', 'ss']));
    }


    public function add_patient_past_medication(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.add_post_medication', compact(['customer']));
    }

    public function save_patient_current_medication(Request $request,$id){
        $record = new PatientMedication();
        $record->patient_id = $id;
        $record->medication_type = 1;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-current-medication',$id)->with('message', 'Patient Current Medician save Successfully');
    }


    public function save_patient_past_medication(Request $request,$id){
        $record = new PatientMedication();
        $record->patient_id = $id;
        $record->medication_type = 2;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;

        $record->medication_used_until = $request->medication_used_until;
        $record->medication_discontinued_note = $request->medication_discontinued_note;
        $record->medication_reason_discontinued = $request->medication_reason_discontinued;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-past-medication',$id)->with('message', 'Patient Past Medician save Successfully');
    }
    public function add_patient_current_medication(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.add_current_medication', compact(['customer']));
    }

    public function edit_patient_current_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $customer = Customer::find($id);
        return view('patient.edit_current_medication', compact(['customer','record']));
    }

    public function view_patient_current_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $customer = Customer::find($id);
        return view('patient.view_current_medication', compact(['customer','record']));
    }


    public function edit_patient_past_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $customer = Customer::find($id);
        return view('patient.edit_post_medication', compact(['customer','record']));
    }

    public function view_patient_past_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $customer = Customer::find($id);
        return view('patient.view_post_medication', compact(['customer','record']));
    }

    



    public function edit_save_patient_current_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $record->patient_id = $id;
        $record->medication_type = 1;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-current-medication',$id)->with('message', 'Patient Current Medician save Successfully');
    }


    public function edit_save_patient_past_medication(Request $request,$id,$recordId){
        $record = PatientMedication::find($recordId);
        $record->patient_id = $id;
        $record->medication_type = 2;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;

        $record->medication_used_until = $request->medication_used_until;
        $record->medication_discontinued_note = $request->medication_discontinued_note;
        $record->medication_reason_discontinued = $request->medication_reason_discontinued;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-past-medication',$id)->with('message', 'Patient Past Medician save Successfully');
    }




    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_current_dietary_supplement(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientDietarySupplement::where('medication_type','1')->orderBy('id', 'DESC')->paginate(10);

        return view('patient.patient_current_dietary_supplement', compact(['customer','customers', 'ss']));
    }

    public function save_patient_current_dietary_supplement(Request $request,$id){
        $record = new PatientDietarySupplement();
        $record->patient_id = $id;
        $record->medication_type = 1;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-current-dietary-supplements',$id)->with('message', 'Patient Current Dietary Supplement save Successfully');
    }

    public function add_patient_current_dietary_supplement(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.add_current_dietary_supplement', compact(['customer']));
    }

    public function edit_patient_current_dietary_supplement(Request $request,$id,$recordId){
        $record = PatientDietarySupplement::find($recordId);
        $customer = Customer::find($id);
        return view('patient.edit_current_dietary_supplement', compact(['customer','record']));
    }

    public function view_patient_current_dietary_supplement(Request $request,$id,$recordId){
        $record = PatientDietarySupplement::find($recordId);
        $customer = Customer::find($id);
        return view('patient.view_current_dietary_supplement', compact(['customer','record']));
    }

    public function edit_save_patient_current_dietary_supplement(Request $request,$id,$recordId){
        $record = PatientDietarySupplement::find($recordId);
        $record->patient_id = $id;
        $record->medication_type = 1;
        $record->medication_drug_name = $request->medication_drug_name;
        $record->medication_dda_drug = $request->medication_dda_drug;
        $record->medication_dosage = $request->medication_dosage;
        $record->medication_frequency_of_use = $request->medication_frequency_of_use;
        $record->medication_started_on = $request->medication_started_on;
        $record->medication_reason_for_taking = $request->medication_reason_for_taking;
        $record->medication_side_effects = $request->medication_side_effects;
        $record->medication_note = $request->medication_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-current-dietary-supplements',$id)->with('message', 'Patient Current Dietary Supplement save Successfully');
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_immunization(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientImmunization::orderBy('id', 'DESC')->paginate(10);

        return view('patient.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_immunization(Request $request,$id){
        $record = new PatientImmunization();
        $record->patient_id = $id;
        $record->injection = $request->injection;
        $record->started_on = $request->started_on;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-immunization',$id)->with('message', 'Patient Immunization save Successfully');
    }

    public function add_patient_immunization(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_immunization(Request $request,$id,$recordId){
        $record = PatientImmunization::find($recordId);
        $customer = Customer::find($id);
        return view('patient.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_immunization(Request $request,$id,$recordId){
        $record = PatientImmunization::find($recordId);
        $customer = Customer::find($id);
        return view('patient.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_immunization(Request $request,$id,$recordId){
        $record = PatientImmunization::find($recordId);
        $record->patient_id = $id;
        $record->injection = $request->injection;
        $record->started_on = $request->started_on;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-immunization',$id)->with('message', 'Patient Immunization save Successfully');
    }




    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_home_medical_equipment(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientHomeMedicalEquipment::orderBy('id', 'DESC')->paginate(10);

        return view('patient.home_medical_equipment.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_home_medical_equipment(Request $request,$id){
        $record = new PatientHomeMedicalEquipment();
        $record->patient_id = $id;
        $record->type = $request->type;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-home-medical-equipment',$id)->with('message', 'Patient Home Medical Equipment save Successfully');
    }

    public function add_patient_home_medical_equipment(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.home_medical_equipment.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_home_medical_equipment(Request $request,$id,$recordId){
        $record = PatientHomeMedicalEquipment::find($recordId);
        $customer = Customer::find($id);
        return view('patient.home_medical_equipment.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_home_medical_equipment(Request $request,$id,$recordId){
        $record = PatientHomeMedicalEquipment::find($recordId);
        $customer = Customer::find($id);
        return view('patient.home_medical_equipment.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_home_medical_equipment(Request $request,$id,$recordId){
        $record = PatientHomeMedicalEquipment::find($recordId);
        $record->patient_id = $id;
        $record->type = $request->type;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-home-medical-equipment',$id)->with('message', 'Patient Home Medical Equipment save Successfully');
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_emergency_contact(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientContacts::orderBy('id', 'DESC')->paginate(10);

        return view('patient.emergency_contact.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_emergency_contact(Request $request,$id){
        $record = new PatientContacts();
        $record->patient_id = $id;
        $record->contact_name = $request->contact_name;
        $record->relationship = $request->relationship;
        $record->contact_phone1 = $request->contact_phone1;
        $record->contact_phone2 = $request->contact_phone2;
        $record->contact_email = $request->contact_email;
        $record->contact_address = $request->contact_address;
        $record->contact_note = $request->contact_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-emergency-contact',$id)->with('message', 'Patient Emergency Contact save Successfully');
    }

    public function add_patient_emergency_contact(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.emergency_contact.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_emergency_contact(Request $request,$id,$recordId){
        $record = PatientContacts::find($recordId);
        $customer = Customer::find($id);
        return view('patient.emergency_contact.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_emergency_contact(Request $request,$id,$recordId){
        $record = PatientContacts::find($recordId);
        $customer = Customer::find($id);
        return view('patient.emergency_contact.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_emergency_contact(Request $request,$id,$recordId){
        $record = PatientContacts::find($recordId);
        $record->patient_id = $id;
        $record->contact_name = $request->contact_name;
        $record->relationship = $request->relationship;
        $record->contact_phone1 = $request->contact_phone1;
        $record->contact_phone2 = $request->contact_phone2;
        $record->contact_email = $request->contact_email;
        $record->contact_address = $request->contact_address;
        $record->contact_note = $request->contact_note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-emergency-contact',$id)->with('message', 'Patient Emergency Contact save Successfully');
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_hospitalization(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientHospitalization::orderBy('id', 'DESC')->paginate(10);

        return view('patient.hospitalization.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_hospitalization(Request $request,$id){
        $record = new PatientHospitalization();
        $record->patient_id = $id;
        $record->date = $request->date;
        $record->outcome = $request->outcome;
        $record->hospital = $request->hospital;
        $record->stay = $request->stay;
        $record->reason = $request->reason;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-hospitalization',$id)->with('message', 'Patient Hospitalization saved Successfully');
    }

    public function add_patient_hospitalization(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.hospitalization.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_hospitalization(Request $request,$id,$recordId){
        $record = PatientHospitalization::find($recordId);
        $customer = Customer::find($id);
        return view('patient.hospitalization.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_hospitalization(Request $request,$id,$recordId){
        $record = PatientHospitalization::find($recordId);
        $customer = Customer::find($id);
        return view('patient.hospitalization.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_hospitalization(Request $request,$id,$recordId){
        $record = PatientHospitalization::find($recordId);
        $record->patient_id = $id;
        $record->date = $request->date;
        $record->outcome = $request->outcome;
        $record->hospital = $request->hospital;
        $record->stay = $request->stay;
        $record->reason = $request->reason;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-hospitalization',$id)->with('message', 'Patient Hospitalization updated Successfully');
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_insurance(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientInsurance::orderBy('id', 'DESC')->paginate(10);

        return view('patient.insurance.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_insurance(Request $request,$id){
        $record = new PatientInsurance();
        $record->patient_id = $id;
        $record->company = $request->company;
        $record->policy_type = $request->policy_type;
        $record->policy_holder = $request->policy_holder;
        $record->policy_holder_name = $request->policy_holder_name;
        $record->insured_name = $request->insured_name;
        $record->policy_no = $request->policy_no;
        $record->start_date = $request->start_date;
        $record->end_date = $request->end_date;
        $record->catastrophe_limit = $request->catastrophe_limit;
        $record->in_patient_limit = $request->in_patient_limit;
        $record->out_patient_limit = $request->out_patient_limit;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-insurance',$id)->with('message', 'Patient Insurance saved Successfully');
    }

    public function add_patient_insurance(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.insurance.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_insurance(Request $request,$id,$recordId){
        $record = PatientInsurance::find($recordId);
        $customer = Customer::find($id);
        return view('patient.insurance.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_insurance(Request $request,$id,$recordId){
        $record = PatientInsurance::find($recordId);
        $customer = Customer::find($id);
        return view('patient.insurance.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_insurance(Request $request,$id,$recordId){
        $record = PatientInsurance::find($recordId);
        $record->patient_id = $id;
        $record->company = $request->company;
        $record->policy_type = $request->policy_type;
        $record->policy_holder = $request->policy_holder;
        $record->policy_holder_name = $request->policy_holder_name;
        $record->insured_name = $request->insured_name;
        $record->policy_no = $request->policy_no;
        $record->start_date = $request->start_date;
        $record->end_date = $request->end_date;
        $record->catastrophe_limit = $request->catastrophe_limit;
        $record->in_patient_limit = $request->in_patient_limit;
        $record->out_patient_limit = $request->out_patient_limit;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-insurance',$id)->with('message', 'Patient Insurance updated Successfully');
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_implanted_devices(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientImplantedDevice::orderBy('id', 'DESC')->paginate(10);

        return view('patient.implanted_devices.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_implanted_devices(Request $request,$id){
        $record = new PatientImplantedDevice();
        $record->patient_id = $id;
        $record->date_of_implanted = $request->date_of_implanted;
        $record->location_on_body = $request->location_on_body;
        $record->name = $request->name;
        $record->note = $request->note;
        $record->created_by = 1;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-implanted-devices',$id)->with('message', 'Patient Implanted Devices saved Successfully');
    }

    public function add_patient_implanted_devices(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.implanted_devices.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_implanted_devices(Request $request,$id,$recordId){
        $record = PatientImplantedDevice::find($recordId);
        $customer = Customer::find($id);
        return view('patient.implanted_devices.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_implanted_devices(Request $request,$id,$recordId){
        $record = PatientImplantedDevice::find($recordId);
        $customer = Customer::find($id);
        return view('patient.implanted_devices.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_implanted_devices(Request $request,$id,$recordId){
        $record = PatientImplantedDevice::find($recordId);
        $record->patient_id = $id;
        $record->date_of_implanted = $request->date_of_implanted;
        $record->location_on_body = $request->location_on_body;
        $record->name = $request->name;
        $record->note = $request->note;
        $record->created_by = 1;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-implanted-devices',$id)->with('message', 'Patient Implanted Devices updated Successfully');
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_medical_aids(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientMedicalAids::orderBy('id', 'DESC')->paginate(10);

        return view('patient.medical_aids.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_medical_aids(Request $request,$id){
        $record = new PatientMedicalAids();
        $record->patient_id = $id;
        $record->presc_glasses = $request->presc_glasses;
        $record->hearing_aids = $request->hearing_aids;
        $record->dentures = $request->dentures;
        $record->prosthesis = $request->prosthesis;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-medical-aids',$id)->with('message', 'Patient Medical Aids saved Successfully');
    }

    public function add_patient_medical_aids(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.medical_aids.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_medical_aids(Request $request,$id,$recordId){
        $record = PatientMedicalAids::find($recordId);
        $customer = Customer::find($id);
        return view('patient.medical_aids.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_medical_aids(Request $request,$id,$recordId){
        $record = PatientMedicalAids::find($recordId);
        $customer = Customer::find($id);
        return view('patient.medical_aids.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_medical_aids(Request $request,$id,$recordId){
        $record = PatientMedicalAids::find($recordId);
        $record->patient_id = $id;
        $record->presc_glasses = $request->presc_glasses;
        $record->hearing_aids = $request->hearing_aids;
        $record->dentures = $request->dentures;
        $record->prosthesis = $request->prosthesis;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-medical-aids',$id)->with('message', 'Patient Medical Aids updated Successfully');
    }




    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_family_history(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientFamilyHistory::orderBy('id', 'DESC')->paginate(10);

        return view('patient.family_history.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_family_history(Request $request,$id){
        $record = new PatientFamilyHistory();
        $record->patient_id = $id;
        $record->condition = $request->condition;
        $record->relation = $request->relation;

        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-family-history',$id)->with('message', 'Patient Family History saved Successfully');
    }

    public function add_patient_family_history(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.family_history.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_family_history(Request $request,$id,$recordId){
        $record = PatientFamilyHistory::find($recordId);
        $customer = Customer::find($id);
        return view('patient.family_history.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_family_history(Request $request,$id,$recordId){
        $record = PatientFamilyHistory::find($recordId);
        $customer = Customer::find($id);
        return view('patient.family_history.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_family_history(Request $request,$id,$recordId){
        $record = PatientFamilyHistory::find($recordId);
        $record->patient_id = $id;

        $record->condition = $request->condition;
        $record->relation = $request->relation;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-family-history',$id)->with('message', 'Family History updated Successfully');
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_alter_therapy(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientAlternativeTherapy::orderBy('id', 'DESC')->paginate(10);

        return view('patient.alter_therapy.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_alter_therapy(Request $request,$id){
        $record = new PatientAlternativeTherapy();
        $record->patient_id = $id;
        $record->location = $request->location;
        $record->type = $request->type;
        $record->date = $request->date;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-alter-therapy',$id)->with('message', 'Alternative Therapy saved Successfully');
    }

    public function add_patient_alter_therapy(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.alter_therapy.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_alter_therapy(Request $request,$id,$recordId){
        $record = PatientAlternativeTherapy::find($recordId);
        $customer = Customer::find($id);
        return view('patient.alter_therapy.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_alter_therapy(Request $request,$id,$recordId){
        $record = PatientAlternativeTherapy::find($recordId);
        $customer = Customer::find($id);
        return view('patient.alter_therapy.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_alter_therapy(Request $request,$id,$recordId){
        $record = PatientAlternativeTherapy::find($recordId);
        $record->patient_id = $id;
        $record->location = $request->location;
        $record->type = $request->type;
        $record->date = $request->date;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-alter-therapy',$id)->with('message', 'Alternative Therapy updated Successfully');
    }


     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_physio_rehab(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientPhysioRehab::orderBy('id', 'DESC')->paginate(10);

        return view('patient.physio_rehab.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_physio_rehab(Request $request,$id){
        $record = new PatientPhysioRehab();
        $record->patient_id = $id;
        $record->location = $request->location;
        $record->type = $request->type;
        $record->date = $request->date;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-physio-rehab',$id)->with('message', 'Physiotheraphy and Rehabilitation saved Successfully');
    }

    public function add_patient_physio_rehab(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.physio_rehab.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_physio_rehab(Request $request,$id,$recordId){
        $record = PatientPhysioRehab::find($recordId);
        $customer = Customer::find($id);
        return view('patient.physio_rehab.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_physio_rehab(Request $request,$id,$recordId){
        $record = PatientPhysioRehab::find($recordId);
        $customer = Customer::find($id);
        return view('patient.physio_rehab.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_physio_rehab(Request $request,$id,$recordId){
        $record = PatientPhysioRehab::find($recordId);
        $record->patient_id = $id;
        $record->location = $request->location;
        $record->type = $request->type;
        $record->date = $request->date;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-physio-rehab',$id)->with('message', 'Physiotheraphy and Rehabilitation updated Successfully');
    }


     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_opd_visits(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientOPDVisits::orderBy('id', 'DESC')->paginate(10);

        return view('patient.opd_visits.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_opd_visits(Request $request,$id){
        $record = new PatientOPDVisits();
        $record->patient_id = $id;
        $record->visit_date = $request->visit_date;
        $record->doctor = $request->doctor;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-opd-visits',$id)->with('message', 'OPD Visits saved Successfully');
    }

    public function add_patient_opd_visits(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.opd_visits.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_opd_visits(Request $request,$id,$recordId){
        $record = PatientOPDVisits::find($recordId);
        $customer = Customer::find($id);
        return view('patient.opd_visits.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_opd_visits(Request $request,$id,$recordId){
        $record = PatientOPDVisits::find($recordId);
        $customer = Customer::find($id);
        return view('patient.opd_visits.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_opd_visits(Request $request,$id,$recordId){
        $record = PatientOPDVisits::find($recordId);
        $record->patient_id = $id;
        $record->visit_date = $request->visit_date;
        $record->doctor = $request->doctor;
        $record->purpose = $request->purpose;
        $record->outcome = $request->outcome;
        $record->action_done_by = 1;
        $record->save();

        return redirect()->route('patient-opd-visits',$id)->with('message', 'OPD Visits updated Successfully');
    }


      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_physicians(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientPhysicians::orderBy('id', 'DESC')->paginate(10);

        return view('patient.physicians.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_physicians(Request $request,$id){
        $record = new PatientPhysicians();
        $record->patient_id = $id;
        $record->physician_name = $request->physician_name;
        $record->physician_type = $request->physician_type;
        $record->physician_phone = $request->physician_phone;
        $record->physician_fax = $request->physician_fax;
        $record->physician_email = $request->physician_email;
        $record->physician_address = $request->physician_address;
        $record->physician_note = $request->physician_note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-physicians',$id)->with('message', 'Physicians saved Successfully');
    }

    public function add_patient_physicians(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.physicians.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_physicians(Request $request,$id,$recordId){
        $record = PatientPhysicians::find($recordId);
        $customer = Customer::find($id);
        return view('patient.physicians.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_physicians(Request $request,$id,$recordId){
        $record = PatientPhysicians::find($recordId);
        $customer = Customer::find($id);
        return view('patient.physicians.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_physicians(Request $request,$id,$recordId){
        $record = PatientPhysicians::find($recordId);
        $record->patient_id = $id;
        $record->physician_name = $request->physician_name;
        $record->physician_type = $request->physician_type;
        $record->physician_phone = $request->physician_phone;
        $record->physician_fax = $request->physician_fax;
        $record->physician_email = $request->physician_email;
        $record->physician_address = $request->physician_address;
        $record->physician_note = $request->physician_note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-physicians',$id)->with('message', 'Physicians updated Successfully');
    }



      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_confidential_note(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientConfidentialNote::orderBy('id', 'DESC')->paginate(10);

        return view('patient.confidential_note.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_confidential_note(Request $request,$id){
        $record = new PatientConfidentialNote();
        $record->patient_id = $id;
        $record->note_date = $request->note_date;
        $record->note_doctor_name = $request->note_doctor_name;
        $record->confidential_note = $request->confidential_note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-confidential-note',$id)->with('message', 'Confidentia Note saved Successfully');
    }

    public function add_patient_confidential_note(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.confidential_note.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_confidential_note(Request $request,$id,$recordId){
        $record = PatientConfidentialNote::find($recordId);
        $customer = Customer::find($id);
        return view('patient.confidential_note.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_confidential_note(Request $request,$id,$recordId){
        $record = PatientConfidentialNote::find($recordId);
        $customer = Customer::find($id);
        return view('patient.confidential_note.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_confidential_note(Request $request,$id,$recordId){
        $record = PatientConfidentialNote::find($recordId);
        $record->patient_id = $id;
        $record->note_date = $request->note_date;
        $record->note_doctor_name = $request->note_doctor_name;
        $record->confidential_note = $request->confidential_note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-confidential-note',$id)->with('message', 'Confidential Note updated Successfully');
    }



      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_allergies(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientAllergies::orderBy('id', 'DESC')->paginate(10);

        return view('patient.allergies.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_allergies(Request $request,$id){
        $record = new PatientAllergies();
        $record->patient_id = $id;
        $record->allergen = $request->allergen;
        $record->reaction = $request->reaction;
        $record->severity = $request->severity;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-allergies',$id)->with('message', 'Allergies saved Successfully');
    }

    public function add_patient_allergies(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.allergies.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_allergies(Request $request,$id,$recordId){
        $record = PatientAllergies::find($recordId);
        $customer = Customer::find($id);
        return view('patient.allergies.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_allergies(Request $request,$id,$recordId){
        $record = PatientAllergies::find($recordId);
        $customer = Customer::find($id);
        return view('patient.allergies.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_allergies(Request $request,$id,$recordId){
        $record = PatientAllergies::find($recordId);
        $record->patient_id = $id;
        $record->allergen = $request->allergen;
        $record->reaction = $request->reaction;
        $record->severity = $request->severity;
        $record->note = $request->note;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-allergies',$id)->with('message', 'Allergies updated Successfully');
    }


      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_surgery(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientSurgery::orderBy('id', 'DESC')->paginate(10);

        return view('patient.surgery.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_surgery(Request $request,$id){
        $record = new PatientSurgery();
        $record->patient_id = $id;
        $record->date_of_surgery = $request->date_of_surgery;
        $record->procedure = $request->procedure;
        $record->ICDCode = $request->ICDCode;
        $record->stay_lenght_day = $request->stay_lenght_day;
        $record->hospital = $request->hospital;
        $record->result = $request->result;
        $record->attending_surgeon = $request->attending_surgeon;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-surgery',$id)->with('message', 'surgery saved Successfully');
    }

    public function add_patient_surgery(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.surgery.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_surgery(Request $request,$id,$recordId){
        $record = PatientSurgery::find($recordId);
        $customer = Customer::find($id);
        return view('patient.surgery.edit_patient_immunization', compact(['customer','record']));
    }

    public function view_patient_surgery(Request $request,$id,$recordId){
        $record = PatientSurgery::find($recordId);
        $customer = Customer::find($id);
        return view('patient.surgery.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_surgery(Request $request,$id,$recordId){
        $record = PatientSurgery::find($recordId);
        $record->patient_id = $id;
        $record->date_of_surgery = $request->date_of_surgery;
        $record->procedure = $request->procedure;
        $record->ICDCode = $request->ICDCode;
        $record->stay_lenght_day = $request->stay_lenght_day;
        $record->hospital = $request->hospital;
        $record->result = $request->result;
        $record->attending_surgeon = $request->attending_surgeon;
        $record->action_done_by = 1;
        $record->created_by = 1;
        $record->save();

        return redirect()->route('patient-surgery',$id)->with('message', 'Surgery updated Successfully');
    }

      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_diagnosis(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientDiagnosis::orderBy('id', 'DESC')->paginate(10);

        return view('patient.diagnosis.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_diagnosis(Request $request,$id){
        $record = new PatientDiagnosis();
        $record->patient_id = $id;
        $record->date = $request->date;
        $record->diagnosis = $request->diagnosis;
        $record->treatment = $request->treatment;
        $record->ICDCode = $request->ICDCode;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-diagnosis',$id)->with('message', 'Diagnosis saved Successfully');
    }

    public function add_patient_diagnosis(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.diagnosis.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_diagnosis(Request $request,$id,$recordId){
        $record = PatientDiagnosis::find($recordId);
        $customer = Customer::find($id);
        return view('patient.diagnosis.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_diagnosis(Request $request,$id,$recordId){
        $record = PatientDiagnosis::find($recordId);
        $customer = Customer::find($id);
        return view('patient.diagnosis.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_diagnosis(Request $request,$id,$recordId){
        $record = PatientDiagnosis::find($recordId);
        $record->patient_id = $id;
        $record->date = $request->date;
        $record->diagnosis = $request->diagnosis;
        $record->treatment = $request->treatment;
        $record->ICDCode = $request->ICDCode;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-diagnosis',$id)->with('message', 'Diagnosis updated Successfully');
    }



      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_episodes_injuries(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientEpisodesInjuries::orderBy('id', 'DESC')->paginate(10);

        return view('patient.episodes_injuries.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_episodes_injuries(Request $request,$id){
        $record = new PatientEpisodesInjuries();
        $record->patient_id = $id;
        $record->onset = $request->onset;
        $record->description = $request->description;
        $record->recovery = $request->recovery;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-episodes-injuries',$id)->with('message', 'Episodes & Injuries saved Successfully');
    }

    public function add_patient_episodes_injuries(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.episodes_injuries.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_episodes_injuries(Request $request,$id,$recordId){
        $record = PatientEpisodesInjuries::find($recordId);
        $customer = Customer::find($id);
        return view('patient.episodes_injuries.edit_patient_immunization', compact(['customer','record']));
    }
    public function view_patient_episodes_injuries(Request $request,$id,$recordId){
        $record = PatientEpisodesInjuries::find($recordId);
        $customer = Customer::find($id);
        return view('patient.episodes_injuries.view_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_episodes_injuries(Request $request,$id,$recordId){
        $record = PatientEpisodesInjuries::find($recordId);
        $record->patient_id = $id;
        $record->onset = $request->onset;
        $record->description = $request->description;
        $record->recovery = $request->recovery;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-episodes-injuries',$id)->with('message', 'Episodes & Injuries updated Successfully');
    }


      ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patient_advanced_directives(Request $request,$id)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $customer = Customer::find($id);
        $customers = PatientAdvancedDirectives::orderBy('id', 'DESC')->paginate(10);

        return view('patient.advanced_directives.patient_immunization', compact(['customer','customers', 'ss']));
    }

    public function save_patient_advanced_directives(Request $request,$id){
        $record = new PatientAdvancedDirectives();
        $record->patient_id = $id;
        $record->onset = $request->onset;
        $record->description = $request->description;
        $record->recovery = $request->recovery;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-advanced-directives',$id)->with('message', 'Advanced Directives saved Successfully');
    }

    public function add_patient_advanced_directives(Request $request,$id){
        $customer = Customer::find($id);
        return view('patient.advanced_directives.add_patient_immunization', compact(['customer']));
    }

    public function edit_patient_advanced_directives(Request $request,$id,$recordId){
        $record = PatientAdvancedDirectives::find($recordId);
        $customer = Customer::find($id);
        return view('patient.advanced_directives.edit_patient_immunization', compact(['customer','record']));
    }

    public function edit_save_patient_advanced_directives(Request $request,$id,$recordId){
        $record = PatientAdvancedDirectives::find($recordId);
        $record->patient_id = $id;
        $record->onset = $request->onset;
        $record->description = $request->description;
        $record->recovery = $request->recovery;
        $record->note = $request->note;

        $record->save();

        return redirect()->route('patient-advanced-directives',$id)->with('message', 'Advanced Directives updated Successfully');
    }

}
