<?php

namespace App\Http\Controllers;

use App\Models\Banking;
use App\Models\CreditNote;
use App\Models\Bills_payment;
use App\Models\JournalEntry;
use App\Models\Ledger;
use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\AppointmentBillable;
use App\Models\AppointmentBillableProducts;
use App\Models\AppointmentPayments;
use App\Models\PayementMethodSales;
use App\Models\Setting;
use App\Models\OnlineStockApi;
use Illuminate\Support\Facades\DB;

class AppointmentsPaymentsController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sales_id' => 'required',
            'payment_mode'=> 'required',
            'amount'=> 'required|gt:0|numeric'
        ]);

        $appointment = Appointments::find($request->sales_id);
        if($appointment === NULL) abort(404);


        $sales = AppointmentBillable::where('appointment_id',$appointment->id)->first();
        
        $amount_due = $sales->amount;
        
        $old_status = $sales->status;

        $amount_paied = AppointmentPayments::select(DB::raw("sum(appointment_payments.amount) as amount_paied"))->where("sales_id", $sales->id)->first();


        if($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied =  $amount_paied->amount_paied;

        $amount_paied += floatval($request->amount);


        if(floatval($amount_paied) > floatval($amount_due)){
            $amount_remain = floatval($amount_due) - floatval($amount_paied) + floatval($request->amount);
            return redirect()->back()->with('error_message','Payment paid cannot be great than amount due. Amount remaining is : ' . $amount_remain);
        }

        ///amount paid = amount due
        //change status to Paid
        if(floatval($amount_paied) == floatval($amount_due)){
            $appointment->update([
                "status"=>"Paid",
            ]);

            if($request->status == "Paid" && $old_status != "Paid"){
               // app('App\Http\Controllers\SalesController')->deduct_stock($request->sales_id);
            }

            $order_status_change_to_admin = Setting::where("key","order_status_change_to_admin")->first();
            if(isset($order_status_change_to_admin->value) && $order_status_change_to_admin->value == "yes"){
               // app('App\Http\Controllers\SalesController')->send_paid_mail($request->sales_id);
            }
            
        }
        $appointment->save();
        $payment_date = date("Y-m-d H:i:s");

        
        if(!empty($request->payment_date)){
            $payment_date = self::transform_date($request->payment_date);
        }

        $sales_payments = AppointmentPayments::updateOrCreate([
            'sales_id' => $request->sales_id,
            'payment_date' => $payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_reference' => $request->payment_reference,
            'amount'  => $request->amount,
            'due_amount'=>$sales->amount - $amount_paied,
        ]);

        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id','DESC')->first();
        $date = date('Y-m-d H:i:s', strtotime(str_replace('/','-',$payment_date)));
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;
        $name = 'Payment #'. $request->sales_id;
        $amount = 0;

        $credit = $debit= 0;
        $ledger_debit = Ledger::where('name','=', 'Bank')->orderBy('id','DESC')->first();
        $ledger_credit = Ledger::where('name','=', 'Accounts Receivable')->orderBy('id','DESC')->first();
        if (!$ledger_debit){
            $ledger_debit = Ledger::create([
                'name' =>  'Bank',
                'id_ledger_group' => 0
            ]);
        }

        if (!$ledger_credit){
            $ledger_credit = Ledger::create([
                'name' =>  'Accounts Receivable',
                'id_ledger_group' => 0
            ]);
        }
        $debit = $ledger_debit->id;
        $credit = $ledger_credit->id;


        return redirect()->back()->with('success','Payment created successfully');
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
        $payment = RentalPayments::find($id);
        $payment_mode = PayementMethodSales::where("is_on_bo_sales_order","yes")->get();
        return view('payment.edit', compact('payment','payment_mode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_post(Request $request){
        return $this->update($request, $request->id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sales_id' => 'required',
            'payment_mode'=> 'required',
            'amount'=> 'required|gt:0|numeric'
        ]);

        $sales = Rentals::find($request->sales_id);
        if($sales === NULL) abort(404);

        $payment = RentalPayments::find($id);

        $amount_due = $sales->amount;
        
        $old_status = $sales->status;

        $amount_paied = RentalPayments::select(DB::raw("sum(rental_payments.amount) as amount_paied"))->where("sales_id", $request->sales_id)->first();

        if($amount_paied == NULL) $amount_paied = 0;
        else {
            $amount_paied = $amount_paied->amount_paied - $payment->amount;
        }

        $amount_paied += floatval($request->amount);

        if(floatval($amount_paied) > floatval($amount_due)){
            $amount_remain = floatval($amount_due) - floatval($amount_paied) + floatval($request->amount);
            return redirect()->back()->with('error_message','Payment paid cannot be great than amount due. Amount remaining is : ' . $amount_remain);
        }

        ///amount paid = amount due
        //change status to Paid
        if(floatval($amount_paied) == floatval($amount_due)){
            $sales->update([
                "status"=>"Paid",
            ]);
            
            if($request->status == "Paid" && $old_status != "Paid"){
             //   app('App\Http\Controllers\SalesController')->deduct_stock($request->sales_id);
            }

            $order_status_change_to_admin = Setting::where("key","order_status_change_to_admin")->first();
            if(isset($order_status_change_to_admin->value) && $order_status_change_to_admin->value == "yes"){
              //  app('App\Http\Controllers\SalesController')->send_paid_mail($request->sales_id);
            }

            /// don't take in considaration product_stock_from_api because check is done while issued the order
            $online_stock_api = OnlineStockApi::latest()->first();
            
        }

        $payment_date =  $payment->payment_date;

        if(!empty($request->payment_date)){
            $payment_date = self::transform_date($request->payment_date);
        }

        $payment->update([
            'payment_date' => $payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_reference' => $request->payment_reference,
            'amount'  => $request->amount,            
            'due_amount'=>$sales->amount - $amount_paied,
        ]);

        $creditnote = CreditNote::find($payment->id_creditnote);
        if ($creditnote){
            $creditnote->update([
                'reason' => $request->payment_reference,
                'amount'  => $request->amount
            ]);
        }

        return redirect()->back()->with('success', 'Payment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = AppointmentPayments::find($id);

        $appointments = Appointments::find($payment->sales_id);
        $appointments->status = 'Pending Payment';
        $appointments->save();
        

        $banking = Banking::find($payment->matched_transaction);
        if ($banking) {
            $status_b = 0;
            $amount_sales_banking = AppointmentPayments::where('matched_transaction','=', $banking->id)->sum('amount');
            $amount_bill_banking = Bills_payment::where('matched_transaction','=', $banking->id)->sum('amount');
            $total_used = ($amount_sales_banking + $amount_bill_banking - $payment->amount);
            if ($banking->amount == $total_used) $status_b = 2;
            if ($banking->amount > $total_used && $total_used != 0)  $status_b = 1;
            $banking->update([
                'matching_status' => $status_b
            ]);
            $sales_payment = AppointmentPayments::where('matched_transaction','=',$id)
                ->where('sales_id','=',$payment->sales_id)
                ->delete();
        }

        $creditnote = CreditNote::find($payment->id_creditnote);
        if ($creditnote){
            $creditnote->delete();
        }


        $payment->delete();
        return redirect()->back()->with('message', 'Payment Deleted Successfully');
    }
    protected function transform_date($date){
//        $d = explode('/', $date);
//        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
//        return $d[2] . "-" . $d[1] . "-" . $d[0];
//        else
            return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
    }
}
