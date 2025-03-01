<?php

namespace App\Http\Controllers;

use App\Exports\ExportBanking;
use App\Imports\ImportBanking;
use App\Models\Banking;
use App\Models\Bill;
use App\Models\Bills_payment;
use App\Models\Customer;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\PayementMethodSales;
use App\Models\PettyCash;
use App\Models\Sales;
use App\Models\SalesPayments;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ss = '';
        $bankings = Banking::orderBy('date','DESC')->paginate(8);
        if ($b= $request->b){
            $ss = $b;
            $bankings= Banking::where([
                ['reference', '!=', Null],
                [function ($query) use ($request) {
                    if (($b = $request->b)) {
                        $query->orWhere('id', '=', $b)
                            ->get();
                    }
                }]
            ])->orderBy('id', 'DESC')->paginate(8);
        }
        $balance = 0;
        $total = 0;
        foreach ($bankings as &$banking){
            $balance = $balance + ($banking->debit - $banking->credit);
            $banking->balance = abs($balance);
        }
        $bankings_total = Banking::orderBy('date','DESC')->get();
        foreach ($bankings_total as $banking_t){
            $total = $total + ($banking_t->debit - $banking_t->credit);
        }
        $total = abs($total);
        $customers = Customer::orderBy('id','DESC')->get();
        $suppliers = Supplier::orderBy('id','DESC')->get();
        return view('accounting.banking.index', compact(['bankings','total','customers','suppliers','ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.banking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date' => 'required',
            'type_banking' => 'required',
            'reference' => 'required'
        ]);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        $id_banking ='';
        if ($request->has('type_banking') && $request->type_banking == "Credit") {
            $banking= Banking::create([
                'debit' => 0,
                'credit' => $request->amount,
                'amount' => $request->amount,
                'date' => $date,
                'description' => $request->description,
                'reference' => $request->reference,

            ]);
            $id_banking = $banking->id;
        } elseif ($request->has('type_banking') && $request->type_banking == "Debit"){
            $banking = Banking::create([
                'debit' => $request->amount,
                'credit' => 0,
                'amount' => $request->amount,
                'date' => $date,
                'description' => $request->description,
                'reference' => $request->reference,
            ]);
            $id_banking = $banking->id;
        }

        return redirect()->route('banking.index','b='.$id_banking)->with('message', 'Banking added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banking  $banking
     * @return \Illuminate\Http\Response
     */
    public function show(Banking $banking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banking  $banking
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banking = Banking::find($id);
        return view('accounting.banking.edit', compact(['banking']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banking  $banking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date' => 'required',
            'type_banking' => 'required',
            'reference' => 'required'
        ]);

        $banking = Banking::find($id);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        $debit = $credit = 0;
        if ($request->has('type_banking') && $request->type_banking == "Credit") {
            $credit = $request->amount;
        } elseif ($request->has('type_banking') && $request->type_banking == "Debit"){
            $debit = $request->amount;
        }
        $banking->update([
            'debit' => $debit,
            'credit' => $credit,
            'amount' => $request->amount,
            'date' => $date,
            'description' => $request->description,
            'reference' => $request->reference,

        ]);

        return redirect()->route('banking.index')->with('message', 'Banking updated Successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banking  $banking
     * @return \Illuminate\Http\Response
     */
    public function update_banking(Request $request)
    {
        $this->validate($request,[
            'date' => 'required',
            'type_banking' => 'required',
            'reference' => 'required'
        ]);
        $id = $request->banking_id;

        $banking = Banking::find($id);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        $debit = $credit = 0;
        if ($request->has('type_banking') && $request->type_banking == "Credit") {
            $credit = $request->amount;
        } elseif ($request->has('type_banking') && $request->type_banking == "Debit"){
            $debit = $request->amount;
        }
        $banking->update([
            'debit' => $debit,
            'credit' => $credit,
            'amount' => $request->amount,
            'date' => $date,
            'description' => $request->description,
            'reference' => $request->reference,

        ]);

        return redirect()->route('banking.index')->with('message', 'Banking updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banking  $banking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banking = Banking::find($id);
        $journales= JournalEntry::where('banking','=',$id)->delete();
        $sales_payment = SalesPayments::where('matched_transaction','=',$id)->delete();
        $bill_payment = Bills_payment::where('matched_transaction','=',$id)->delete();
        $banking->delete();
        return redirect()->route('banking.index')->with('message', 'Banking Deleted Successfully');
    }

    public function delete_matching_banking_bill(Request $request)
    {
        $banking = $request->matched_transaction;
        $bill = $request->id_bill;
        $journales= JournalEntry::where('banking','=',$banking)->where('bills','!=', null)->delete();
        $bill_payment = Bills_payment::where('matched_transaction','=',$banking)->where('bill_id','=',$bill)->delete();
        return redirect()->route('banking.index')->with('message', 'Matched Banking Deleted Successfully');
    }

    public function delete_matching_banking_sales(Request $request)
    {
        $banking = $request->matched_transaction;
        $sale = $request->id_sale;
        $journales = JournalEntry::where('banking','=',$banking)->where('bills','=', null)->delete();
        $sales_payment = SalesPayments::where('matched_transaction','=',$banking)->where('sales_id','=', $sale)->delete();
        return redirect()->route('banking.index')->with('message', 'Matched Banking Deleted Successfully');
    }

    public function import_banking(Request $request)
    {
        $type = $request->file_format;
        Excel::import(new ImportBanking($type), $request->file('file'));
//        exit();
        return redirect()->route('banking.index')->with('message', 'Banking Imported Successfully');
    }

    public function export_banking()
    {
        return Excel::download(new ExportBanking, 'banking' . date('Y-m-d-h-i-s') . '.xlsx');
    }

    public function delete_all_banking()
    {
        Banking::truncate();
        return redirect()->route('banking.index')->with('message', 'Banking deleted all');
    }

    public function search(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;

        $bankings= Banking::where([
            ['reference', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('reference', 'LIKE', '%' . $s . '%')
                        ->orWhere('description', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy('id', 'DESC')->paginate(8);
        $balance = 0;
        foreach ($bankings as &$banking){
            $balance = $balance + ($banking->debit - $banking->credit);
            $banking->balance = abs($balance);

        }

        return view('accounting.banking.search_ajax', compact(['bankings', 'ss']));
    }

    public function matching_pettycash(Request $request, $id){
        $b_id = $id;
        $b_date = $request->date;
        $b_debit = $request->debit;
        $b_credit = $request->credit;
        $b_amount = $request->amount;
        $b_refrence = $request->reference;
        $b_description = $request->description;
        //petty_cash_matched

        $pettycash_exist = PettyCash::where('banking_matched','=', $b_id)->orderBy('banking_matched','desc')->first();
        if (!$pettycash_exist){

            $ledger_account = Ledger::where('name','=', 'Cash')->orderBy('id','desc')->first();
            if (!$ledger_account) {
                $ledger_account = Ledger::create([
                    'name' => 'Cash',
                    'id_ledger_group' => 0
                ]);
            }

            if ($b_credit == 0) $b_amount = $b_debit; else $b_amount =  $b_credit;
            if ($b_debit == 0) $b_debit = $b_credit;

            $pettycash_exist = PettyCash::create([
                'date' => $b_date,
                'debit' => $b_debit,
                'amount' => $b_amount,
                'ledger_account' => $ledger_account->id,
                'description' => $b_description,
                'credit' => 0,
                'is_account_payable' => 1,
                'banking_matched' => $b_id,
                'matching_status' => 2
            ]);
        }
        $banking = Banking::find($id);
        $banking->update([
            'petty_cash_matched' => $pettycash_exist->id,
            'matching_status' => 2,
        ]);
        return redirect()->route('banking.index')->with('message', 'Banking matched on petty cash');
    }

    public function matching_view(Request $request){
        $id_banking = $request->id;
        $banking = Banking::find($id_banking);
        $total = 0;
        $matching_petty_cashs = PettyCash::where('banking_matched','=',$id_banking)->orderBy('date','DESC')->get();
        foreach ($matching_petty_cashs as $matching_petty_cash) $total += abs($matching_petty_cash->amount);

        $sales_payments = SalesPayments::where('matched_transaction','=',$id_banking)->orderBy('sales_id','DESC')->get();
        foreach ($sales_payments as &$sp){
            $total += abs($sp->amount);
            $sale = Sales::find($sp->sales_id);
            $sp->customer_id = $sale->customer_id;
            $sp->date = $sale->created_at;
            $sp->customer_name = $sale->customer_firstname . '' .$sale->customer_lastname;
        }

        $bill_payments = Bills_payment::where('matched_transaction','=',$id_banking)->orderBy('bill_id','DESC')->get();
        foreach ($bill_payments as &$bp){
            $total += abs($bp->amount);
            $bill = Bill::find($bp->bill_id);
            $bp->supplier_id = $bill->id_supplier;
            $bp->date = $bill->created_at;
            $bp->supplier_name = $bill->supplier_name;
        }
        return view('accounting.banking.matching_view', compact(['matching_petty_cashs','total','banking','bill_payments','sales_payments']));
    }

    public function matching_pettycash_delete(Request $request){
        $id_banking = $request->id_banking;
        $id_petty_cash = $request->id_petty_cash;
        $banking = Banking::find($id_banking);
        $banking->update([
            'petty_cash_matched' => 0,
            'matching_status' => 0,
        ]);
        $petty_cash = PettyCash::find($id_petty_cash);
        $petty_cash->delete();

        return redirect()->route('banking.index')->with('message', 'Banking matching deleted');
    }

    public function get_sales_customer_ajax(Request $request){
        $id_customer = $request->id;
        $sales = Sales::where('customer_id','=',$id_customer)->orderBy('id', 'DESC')->get();
        return view('accounting.banking.sales_customer_option', compact(['sales']));
    }

    public function get_bills_supplier_ajax(Request $request){
        $id_bill = $request->id;
        $bills = Bill::where('id_supplier','=',$id_bill)->orderBy('id', 'DESC')->get();
        return view('accounting.banking.bills_supplier_option', compact(['bills']));
    }

    public function matching_banking(Request $request){
        $match_bank_select = $request->match_bank_select;
        $type_sales_receivable = $request->type_sales_receivable;
        $type_bill_payable = $request->type_bill_payable;
        $customer_matching_select = $request->customer_matching_select;
        $supplier_matching_select = $request->supplier_matching_select;
//        $date_new_sales = $request->date_new_sales;
        $date_new_bill_due = $request->date_new_bill_due;
        $description_sale = $request->description_sale;
        $description_bill = $request->description_bill;
        $sales_matching_select = $request->sales_matching_select;
        $match_payement_method_select = $request->match_payement_method_select;
        $bills_matching_select = $request->bills_matching_select;
        $match_payement_method_select_bill = $request->match_payement_method_select_bill;
        $amount = $request->amount;
        $id_matching_banking = $request->id_matching_banking;
        $date_matching_banking = $request->date_matching_banking;
        $reference_matching_banking = $request->reference_matching_banking;

        $date = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $date_new_bill_due)));
        $today = date('Y-m-d H:i:s');

        if ($match_bank_select == "Accounts Receivable"){
            $id_customer = $customer_matching_select;
            $sale = Sales::find((int)$sales_matching_select);
            $customer_info = Customer::find((int)$id_customer);
            if ($type_sales_receivable == "New Sale"){
                $status = "Paid";
                $customer_mail = NULL;
                if (isset($customer_info->email))
                    $customer_mail = $customer_info->email;

                if ($customer_mail == NULL || $customer_mail == "") $customer_mail = "noreply@ecom.mu";
                $customer_phone = NULL;

                if (isset($customer_info->phone))
                    $customer_phone = $customer_info->phone;

                if ($customer_info->firstname == "Guest") $customer_phone = "";
                $customer_firstname = $customer_info->firstname;
                $customer_lastname = $customer_info->lastname;
                $stores = Store::where('is_on_newsale_page', 'yes')
                    ->where('is_online', 'no')
                    ->get();
                $store = Store::find($stores[0]->id);

                $paymentModeNew = PayementMethodSales::where('payment_method','=','Cash')->orderBy('id','DESC')->first();

                $sale = Sales::create([
                    'amount' => $amount,
                    'status' => $status,
                    'order_reference' =>$reference_matching_banking,
                    'customer_id' =>$customer_info->id,
                    'customer_firstname' =>$customer_firstname,
                    'customer_lastname' =>$customer_lastname,
                    'customer_address' =>$customer_info->address1,
                    'customer_city' =>$customer_info->city,
                    'customer_email' =>$customer_mail,
                    'customer_phone' =>$customer_phone,
                    'comment' => $description_sale,
                    'payment_methode' => $paymentModeNew->id,
                    'id_store' => $store->id,
                ]);
            }
            $check_sales_amount = SalesPayments::where('sales_id','=',$sale->id)
                ->where('amount','=',$amount)->count();

//            if ($check_sales_amount) SalesPayments::where('sales_id','=',$sale->id)->where('amount','=',$amount)->delete();
            $paymentMode = PayementMethodSales::where('payment_method','=','Bank Transfer')->orderBy('id','DESC')->first();
            if ($type_sales_receivable != "New Sale")
                $paymentMode = PayementMethodSales::where('payment_method','=', $match_payement_method_select)->orderBy('id','DESC')->first();

            $payments_banking = SalesPayments::create([
                'sales_id' => $sale->id,
                'payment_date' => $today,
                'payment_mode' => $paymentMode->id,
                'payment_reference' => $reference_matching_banking,
                'matched_transaction' => $id_matching_banking,
                'amount' => $amount
            ]);
            $name = $customer_info->firstname . ' '. $customer_info->lastname;
            $this->add_ledger_or_journal_history($sale->id, $name, $amount, 0, $id_matching_banking, $sale->created_at);
        }
        else {
            $id_supplier = $supplier_matching_select;
            $bill = Bill::find((int)$bills_matching_select);
            $supplier_info = Supplier::find((int)$id_supplier);
            if ($type_bill_payable == "New Bill"){
                $status = "Paid";
                $supplier_mail = NULL;
                if (isset($supplier_info->email))
                    $supplier_mail = $supplier_info->email;

                if ($supplier_mail == NULL || $supplier_mail == "") $supplier_mail = "noreply@ecom.mu";
                $supplier_phone = NULL;

                if (isset($supplier_info->phone))
                    $supplier_phone = $supplier_info->phone;

                if ($supplier_info->name == "Guest") $supplier_phone = "";
                $stores = Store::where('is_on_newsale_page', 'yes')
                    ->where('is_online', 'no')
                    ->get();
                $store = Store::find($stores[0]->id);

                $paymentModeNew = PayementMethodSales::where('payment_method','=','Cash')->orderBy('id','DESC')->first();

                $bill = Bill::create([
                    'amount' => $amount,
                    'status' => $status,
                    'due_date' => $date,
                    'order_reference' =>$reference_matching_banking,
                    'id_supplier' =>$supplier_info->id,
                    'supplier_name' => $supplier_info->name,
                    'supplier_address' =>$supplier_info->address,
                    'supplier_email' =>$supplier_mail,
                    'supplier_phone' =>$supplier_phone,
                    'comment' => $description_bill,
                    'payment_methode' => $paymentModeNew->id,
                    'id_store' => $store->id,
                    'store' => $store->name,
                ]);
            }
            $check_bill_amount = Bills_payment::where('bill_id','=',$bill->id)
                ->where('amount','=',$amount)->count();

//            if ($check_bill_amount) Bills_payment::where('bill_id','=',$bill->id)->where('amount','=',$amount)->delete();
            $paymentMode = PayementMethodSales::where('payment_method','=','Bank Transfer')->orderBy('id','DESC')->first();
            if ($type_bill_payable != "New Bill")
                $paymentMode = PayementMethodSales::where('payment_method','=', $match_payement_method_select_bill)->orderBy('id','DESC')->first();

            $payments_banking = Bills_payment::create([
                'bill_id' => $bill->id,
                'payment_date' => $today,
                'payment_mode' => $paymentMode->id,
                'payment_reference' => $reference_matching_banking,
                'matched_transaction' => $id_matching_banking,
                'amount' => $amount
            ]);
            $name = trim($supplier_info->name);
            $this->add_ledger_or_journal_history($bill->id, $name, $amount, 1, $id_matching_banking, $bill->created_at);
        }
        $banking = Banking::find($id_matching_banking);
        $status_b = 0;
        $amount_sales_banking = SalesPayments::where('matched_transaction','=', $banking->id)->sum('amount');
        $amount_bill_banking = Bills_payment::where('matched_transaction','=', $banking->id)->sum('amount');
        $total_used = ($amount_sales_banking + $amount_bill_banking);
        if ($banking->amount == $total_used) $status_b = 2;
        if ($banking->amount > $total_used && $total_used != 0)  $status_b = 1;
        $banking->update([
            'matching_status' => $status_b
        ]);
        return redirect()->route('banking.index')->with('message', 'Banking matched successfully');
    }

    public function add_ledger_or_journal_history($id_sales_bills, $customer_name,$amount_banking, $is_bill,$id_banking,$date)
    {
        $ledger_debit = $ledger_credit = '';

        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id','DESC')->first();
        $date = date('Y-m-d', strtotime(str_replace('/','-',$date)));
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;

        $name = '';
        if ($is_bill){
            $ledger_debit = $this->check_ledger_banking($customer_name,'Accounts Payable');
            $ledger_credit = $this->check_ledger_banking('Bank','Bank Account');

            $name = 'Bill #';
        }else {
            $ledger_debit = $this->check_ledger_banking('Bank','Bank Account');
            $ledger_credit = $this->check_ledger_banking($customer_name,'Accounts Receivable');
            $name = 'Sale #';
        }
        $name .= $id_sales_bills;
        $credit = $debit= 0;

        $debit = $ledger_debit->id;
        $credit = $ledger_credit->id;



        JournalEntry::create([
            'id_order'=> $id_sales_bills,
            'debit' => $debit,
            'credit' => null,
            'amount' => $amount_banking,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
            'bills' => $is_bill,
            'banking' => !$is_bill,
        ]);

        JournalEntry::create([
            'id_order'=> $id_sales_bills,
            'debit' => null,
            'credit' => $credit,
            'amount' => $amount_banking,
            'date' => $date,
            'name' => $name,
            'journal_id' => $journal_id,
            'bills' => $is_bill,
            'banking' => !$is_bill,
        ]);
        return $id_sales_bills;
    }

    public function check_ledger_banking($ledger,$groupLedger){
        $ledger_child = Ledger::where('name','=', $ledger)->orderBy('id','DESC')->first();
        $ledger_parent = Ledger::where('name','=', $groupLedger)->orderBy('id','DESC')->first();

        if (!$ledger_parent){
            $ledger_parent = Ledger::create([
                'name' =>  $groupLedger,
                'id_ledger_group' => 0
            ]);
        }

        if (!$ledger_child){
            $ledger_child = Ledger::create([
                'name' =>  $ledger,
                'id_ledger_group' => $ledger_parent->id
            ]);
        } else {
            $ledger_child->update([
                'id_ledger_group' => $ledger_parent->id
            ]);
        }

        return $ledger_child;

    }

}
