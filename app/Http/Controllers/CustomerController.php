<?php

namespace App\Http\Controllers;

use App\Exports\CustomerItems;
use App\Imports\CustomersImport;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerSalesEBSResult;
use App\Models\PayementMethodSales;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesPayments;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\User;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
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
        $customers = Customer::where('type', 'customer')->where([
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
        return view('customer.index', compact(['customers', 'ss']));
    }

    public function search(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        /* company_name
        'firstname'
            'lastname' */
        // $customers = Customer::latest()->orderBy('id', 'DESC')->paginate(10);
        $customers = Customer::where('type', 'customer')->where([
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
        return view('customer.search_ajax', compact(['customers', 'ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        if($request->can_customer_company == 1){
            $this->validate($request, [
                'can_customer_company' => 'sometimes|boolean',

                // Company name is required if "can_customer_company" is checked (value=1)
                'company_name' => [
                    'required_if:can_customer_company,1',
                    'string',
                    'max:255'
                ],


                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'), // Unique in users table
                ],

                'password' => [
                    'nullable', // Optional
                    'string',
                    'min:8',
                ],
            ]);
        } else {
            $this->validate($request, [
                // First name or last name must be required when "can_customer_company" is not checked
                'firstname' => [
                    Rule::requiredIf(!$request->has('can_customer_company') || $request->can_customer_company == 0),
                    'string',
                    'max:255'
                ],
                'lastname' => [
                    Rule::requiredIf(!$request->has('can_customer_company') || $request->can_customer_company == 0),
                    'string',
                    'max:255'
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'), // Unique in users table
                ],

                'password' => [
                    'nullable', // Optional
                    'string',
                    'min:8',
                ],
            ]);
        }
        // Create or update Customer
        $customer = Customer::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'company_name' => $request->company_name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'country' => $request->country,
            'city' => $request->city,
            'email' => $request->email,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'brn_customer' => $request->brn_customer,
            'vat_customer' => $request->vat_customer,
            'note_customer' => $request->note_customer,
            'can_customer_company' => $request->can_customer_company
        ]);

        // Create an associated User if a password is provided
        if ($request->filled('password')) {
            $user = User::create([
                'name' => $request->firstname . ' ' . $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);

            // Link the User to the Customer
            $customer->update(['user_id' => $user->id]);
        }

        return redirect()->route('customer.index')->with('message', 'Customer Created Successfully');
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
    public function edit($id)
    {
        $customer = Customer::find($id);

        if ($customer->is_default == "yes") {
            abort(404);
        }

        return view('customer.edit', compact('customer'));
    }

    public function customer_statement_perstatus($id_customer, $status){
        $sql = "
        SELECT (
            SELECT payement_method_sales.payment_method
            FROM sales
            INNER JOIN payement_method_sales ON payement_method_sales.id = sales.payment_methode
            WHERE sales.id = sales_payments.sales_id
        ) as payment_mode,
        SUM(sales_payments.amount) as total_amount
        FROM sales_payments
        WHERE sales_payments.sales_id IN (
            SELECT DISTINCT(sales.id)
            FROM sales
            WHERE sales.customer_id = ?
            AND sales.status = ?
        )
        GROUP BY payment_mode
    ";

        // Exécution de la requête avec le paramètre customer_id
        $result = DB::select($sql, [$id_customer, $status]);
        return $result;

    }

    public function order_customer_statement_perstatus($id_customer, $status){
        $sql = "
        SELECT payement_method_sales.payment_method as payment_mode, sales.payment_methode, sales.status, SUM(sales.amount) as total_amount FROM sales
            LEFT JOIN payement_method_sales ON  payement_method_sales.id = sales.payment_methode
            WHERE sales.customer_id = ? AND sales.status = ?
            GROUP BY sales.payment_methode
    ";

        // Exécution de la requête avec le paramètre customer_id
        $result = DB::select($sql, [$id_customer, $status]);
        return $result;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function customer_details($id)
    {
        $customer = Customer::find($id);
        $sales = Sales::where('customer_id', '=', $id)->where('status', '!=', 'Cancelled')->orderBy('id', 'ASC')->get();
        $cutomersalesEbs = CustomerSalesEBSResult::where("customer_id", $id)->orderBy('id', 'DESC')->first();
        $balance = 0;
        $sales_id_payment = [];

        $sales_stats = [];
        $sales_stats_pending = [];
        $sales_stats_completed = [];
        $sales_payment_pending = [];
        $sales_payment_completed = [];

        $sales_stats_pending = self::order_customer_statement_perstatus($id, "Pending Payment");
        $sales_stats_completed = self::order_customer_statement_perstatus($id, "Paid");
        $sales_payment_pending = self::customer_statement_perstatus($id, "Pending Payment");
        $sales_payment_completed = self::customer_statement_perstatus($id, "Paid");

        foreach ($sales as &$sale) {
            $paid_total = 0;
            $order_paid = SalesPayments::where('sales_id', $sale->id)->get();
            foreach ($order_paid as $op){
                $paid_total += $op->amount;
            }
            $sale->amount_paid = $paid_total;
            $sale->amount_due = $op->amount - $paid_total;
        }

        $sales = collect($sales)->sortBy('id')->reverse();

//        $total_pending = $total_pending - $total_paid;

        $final_list_pending = [];
        $final_list_completed = [];
        $total_pending = $total_paid = 0;

        foreach ($sales_stats_pending as $o) {
            $total_pending = $total_pending + floatval($o->total_amount);

            ///MERGE
            if (isset($final_list_pending[$o->payment_mode])) {
                $final_list_pending[$o->payment_mode]["total_amount"] = $final_list_pending[$o->payment_mode]["total_amount"] + $o->total_amount;
            } else {
                $final_list_pending[$o->payment_mode] = ["payment_method" => $o->payment_mode, "total_amount" => $o->total_amount];
            }
        }

        /*foreach ($sales_stats_completed as $o) {
            $total_paid = $total_paid + floatval($o->total_amount);
            ///MERGE

            if (isset($final_list_completed[$o->payment_mode])) {
                $final_list_completed[$o->payment_mode]["total_amount"] = $final_list_completed[$o->payment_mode]["total_amount"] + $o->total_amount;
            } else {
                $final_list_completed[$o->payment_mode] = ["payment_method" => $o->payment_mode, "total_amount" => $o->total_amount];
            }
        }*/

        /*foreach ($sales_payment_pending as $o) {
            $total_pending = $total_pending + floatval($o->total_amount);
            ///MERGE
            if (isset($final_list_pending[$o->payment_mode])) {
                $final_list_pending[$o->payment_mode]["total_amount"] = $final_list_pending[$o->payment_mode]["total_amount"] + $o->total_amount;
            } else {
                $final_list_pending[$o->payment_mode] = ["payment_method" => $o->payment_mode, "total_amount" => $o->total_amount];
            }
        }*/

        foreach ($sales_payment_completed as $o) {
            $total_paid = $total_paid + floatval($o->total_amount);
            ///MERGE
            if (isset($final_list_completed[$o->payment_mode])) {
                $final_list_completed[$o->payment_mode]["total_amount"] = $final_list_completed[$o->payment_mode]["total_amount"] + $o->total_amount;
            } else {
                $final_list_completed[$o->payment_mode] = ["payment_method" => $o->payment_mode, "total_amount" => $o->total_amount];
            }
        }

        $payment_methodes = PayementMethodSales::get();

        return view('customer.statements', compact(
            [
                'customer',
                'sales',
                'total_pending',
                'total_paid',
                'final_list_pending',
                'final_list_completed',
                'payment_methodes',
                'sales_stats_pending',
                'sales_stats_completed',
                'cutomersalesEbs'
            ]
        ));
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
        $customer = Customer::findOrFail($id);


        if($request->can_customer_company == 1){
            $this->validate($request, [
                'can_customer_company' => 'sometimes|boolean',

                // Company name is required if "can_customer_company" is checked (value=1)
                'company_name' => [
                    'required_if:can_customer_company,1',
                    'string',
                    'max:255'
                ],


                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'), // Unique in users table
                ],

                'password' => [
                    'nullable', // Optional
                    'string',
                    'min:8',
                ],
            ]);
        } else {
            $this->validate($request, [
                // First name or last name must be required when "can_customer_company" is not checked
                'firstname' => [
                    Rule::requiredIf(!$request->has('can_customer_company') || $request->can_customer_company == 0),
                    'string',
                    'max:255'
                ],
                'lastname' => [
                    Rule::requiredIf(!$request->has('can_customer_company') || $request->can_customer_company == 0),
                    'string',
                    'max:255'
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'), // Unique in users table
                ],

                'password' => [
                    'nullable', // Optional
                    'string',
                    'min:8',
                ],
            ]);
        }

        // Validate email uniqueness in customers table only if changed
        if ($request->email !== $customer->email) {
            $this->validate($request, [
                'email' => [
                    'email',
                    Rule::unique('customers')->ignore($customer->id), // Unique in customers table
                ],
            ]);
        }

        // Update the Customer record
        $customerData = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'company_name' => $request->company_name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'email' => $request->email,
            'country' => $request->country,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'brn_customer' => $request->brn_customer,
            'vat_customer' => $request->vat_customer,
            'note_customer' => $request->note_customer,
            'can_customer_company'=>$request->can_customer_company
        ];

        $customer->update($customerData);

        // Update or create associated User and update user_id in Customer
        if ($request->filled('password')) {
            $user = User::updateOrCreate(
                ['id' => $customer->user_id], // Match condition for the associated user
                [
                    'name' => $request->firstname . ' ' . $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                ]
            );

            // Ensure user_id in Customer is updated
            if ($customer->user_id !== $user->id) {
                $customer->update(['user_id' => $user->id]);
            }
        }


        return redirect()->route('customer.edit', $id)->with('message', 'Customer Updated Successfully');
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
        if ($customer->is_default == "yes") {
            abort(404);
        }
        $customer->delete();
        return redirect()->route('customer.index')->with('message', 'Customer Deleted Successfully');
    }

    public function importCustomerView(Request $request)
    {
        return view('customer.importCustomerFile');
    }

    public function customer_export_items(Request $request, $id)
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
        $orders = Sales::select(
            'id',
            'amount',
            'currency',
            'status',
            'order_reference',
            'customer_id',
            'customer_firstname',
            'customer_lastname',
            'customer_address',
            'customer_city',
            'customer_email',
            'customer_phone',
            'payment_methode',
            'created_at as order_date'
        )
            ->where('customer_id', '=', $id)->orderBy('id', 'ASC')->get();
        foreach ($orders as &$sale) {
            $method = PayementMethodSales::find($sale->payment_methode);
            $sale->payment_method = $method->payment_method;

            $orders_paid = SalesPayments::select('id as payment_id', 'sales_id', 'payment_date AS order_date', 'payment_mode', 'payment_reference', 'amount')
                ->where('sales_id', '=', $sale->id)->get();

            if (count($orders_paid))
                foreach ($orders_paid as $op) {
                    $method_ = PayementMethodSales::find($op->payment_mode);
                    if (!is_null($method_)) {
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
        $orders = Sales::select(
            'id',
            'amount',
            'currency',
            'status',
            'order_reference',
            'customer_id',
            'customer_firstname',
            'customer_lastname',
            'customer_address',
            'customer_city',
            'customer_email',
            'customer_phone',
            'payment_methode',
            'created_at as order_date'
        )
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
            $orders_paid = SalesPayments::select('id as payment_id', 'sales_id', 'payment_date AS order_date', 'payment_mode', 'payment_reference', 'amount')
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
                DB::raw('CURDATE()')
            ])
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
                    DB::raw('DATE_SUB(CURDATE(), INTERVAL ' . $day_begin . ' DAY)')
                ])
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
        $sales = Sales::where('customer_id', '=', $id)->orderBy('id', 'desc')->pluck('id');
        $customer = Customer::find($id);
        $customer_name = "";


        if ($customer) {
            if ($customer->firstname || $customer->lastname) $customer_name = $customer->firstname . ' ' . $customer->lastname;
            else $customer_name = $customer->name;
        }

        if (count($sales)) {
            foreach ($sales as $s) array_push($sales_i, $s);
            $productss = Sales_products::whereIn('sales_id', $sales_i)->paginate(8);
            if (count($productss)) {
                foreach ($productss as &$product_s) {
                    $sales_info = Sales::find($product_s->sales_id);
                    $product = Products::find($product_s->product_id);

                    if (isset($product->id)) {
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
                            if (isset($store_p->store_id) && is_null($store_p->store_id)) {
                                $store_product = Store::find($stock->store_id);
                                $store = $store_product->name;
                            }
                        }

                        $stock_t = DB::table('stocks')
                            ->where('products_id', $product->id)
                            ->orderBy('id', 'desc')->first();
                        $sku_ss = '';
                        if ($stock_t) $sku_ss = $stock_t->sku;
                        $product_variation = DB::table('product_variations')->where('products_id', $product->id)->where('id', $product_s->product_variations_id)->get();
                        if (count($product_variation)) {
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

                                if ($stock) $sku_ss = $stock->sku;
                                $product_s->sale_ref = $sales_info->order_reference;
                                $product_s->customer = $customer_name;
                                $product_s->sale_date = date('d/m/Y', strtotime($sales_info->created_at));
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
                        } else {
                            $product_s->sale_ref = $sales_info->order_reference;
                            $product_s->customer = $customer_name;
                            $product_s->sale_date = date('d/m/Y', strtotime($sales_info->created_at));
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


        return view('customer.product', compact(['productss', 'customer_name', 'customer']));
    }

    public function customerMRARequest($id)
    {
        $mra_sales = array();
        $sales = Sales::where('customer_id', '=', $id)->orderBy('id', 'desc')->get();
        $customer = Customer::find($id);
        $customer_name = "";


        if ($customer) {
            if ($customer->firstname || $customer->lastname) $customer_name = $customer->firstname . ' ' . $customer->lastname;
            else $customer_name = $customer->name;
        }

        if (count($sales)) {
            self::customer_mra_ebs_transaction($sales, $customer, $typeDesc = 'Standard');
        }

        return redirect()->back()->with('success', 'MRA Request sent successfully!');
    }

    public function customer_mra_ebs_transaction($sales, $customer, $typeDesc = 'Standard')
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

        $sales_trans = [];
        foreach ($sales as $sale) {
            $data = [];
            $newSales = Sales_products::where("sales_id", $sale->id)->get();
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
                    'itemNo' => $item->product_id,
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

            $payment_slug = PayementMethodSales::find($sale->payment_methode);

            if ($payment_slug->payment_method == 'Debit/Credit Card') {
                $sales_transaction = "CARD";
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

            $ebs_typeOfPersonDesc = $ebs_invoiceTypeDesc->value;
            $total_paid = 0;
            if ($sale->status == 'Paid') {
                $total_paid = $sale->amount;
            } else {
                $ebs_typeOfPersonDesc = 'PRF';
            }
            if ($typeDesc == 'Credit Note') {
                $ebs_typeOfPersonDesc = 'CRN';
            } elseif ($typeDesc == 'Debit Note') {
                $ebs_typeOfPersonDesc = 'DRN';
            }



            $ebs_sales_date = date('Ymd H:i:s', strtotime(str_replace('/', '-', $sale->created_at)));

            $reason = "";

            $b_tan = '';
            if ($customer->vat_customer) $b_tan = $customer->vat_customer;
            $b_brn = '';
            if ($customer->brn_customer) $b_brn = $customer->brn_customer;
            $b_adr = '';
            if ($customer->address1) $b_adr = $customer->address1;

            $arInvoice_t = [
                'invoiceCounter' => $requestId,
                'transactionType' => $ebs_transactionType->value,
                'personType' => $ebs_typeOfPerson->value,
                'invoiceTypeDesc' => $ebs_typeOfPersonDesc,
                'currency' => $sale->currency,
                'invoiceIdentifier' => $sale->id,
                'invoiceRefIdentifier' => $sale->id,
                'previousNoteHash' => 'prevNote',
                'reasonStated' => $reason,
                'totalVatAmount' => number_format((float)$sale->tax_amount, 2, '.', ''),
                'totalAmtWoVatCur' => number_format((float)$sale->subtotal, 2, '.', ''),
                'invoiceTotal' => number_format((float)$sale->amount, 2, '.', ''),
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
            $sales_trans[] = $arInvoice_t;
        }

        $invoiceArray = $sales_trans;

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


        $salesEbsResult = new CustomerSalesEBSResult();
        $salesEbsResult->customer_id = $customer->id;
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
}
