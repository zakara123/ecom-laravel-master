<?php

namespace App\Http\Controllers;

use App\Models\Banking;
use App\Models\DebitNote;
use App\Models\SalesPayments;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Bill_product;
use App\Models\Bills_payment;


use Illuminate\Support\Facades\DB;

class BillsPaymentController extends Controller
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
            'bill_id' => 'required',
            'payment_mode'=> 'required',
            'amount'=> 'required|gt:0|numeric'
        ]);

        $bills = Bill::find($request->bill_id);
        if($bills === NULL) abort(404);

        $amount_due = $bills->amount;

        $amount_paied = Bills_payment::select(DB::raw("sum(bills_payments.amount) as amount_paied"))->where("bill_id", $request->bill_id)->first();

        if($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied =  $amount_paied->amount_paied;

        $amount_paied += floatval($request->amount);

        if(floatval($amount_paied) > floatval($amount_due)){
            $amount_remain = floatval($amount_due) - floatval($amount_paied) + floatval($request->amount);
            return redirect()->back()->with('error_message','Payment paid cannot be great than amount due. Amount remaining is : ' . $amount_remain);
        }

        if(floatval($amount_paied) == floatval($amount_due)){
            $bills->update([
                "status"=>"Paid",
            ]);
        }

        $payment_date = date("Y-m-d");

        if(!empty($request->payment_date)){
            $payment_date = self::transform_date($request->payment_date);
        }

        $bills_payments = Bills_payment::updateOrCreate([
            'bill_id' => $request->bill_id,
            'payment_date' => $payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_reference' => $request->payment_reference,
            'amount'  => $request->amount
        ]);

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
        //
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
            'bill_id' => 'required',
            'payment_mode'=> 'required',
            'amount'=> 'required|gt:0|numeric'
        ]);
        $bills = Bill::find($id);
        if($bills === NULL) abort(404);

        $payment = Bills_payment::find($request->id);

        $amount_due = $bills->amount;

        $amount_paied = Bills_payment::select(DB::raw("sum(bills_payments.amount) as amount_paied"))->where("bill_id", $request->bill_id)->first();

        if($amount_paied == NULL) $amount_paied = 0;
        else $amount_paied =  $amount_paied->amount_paied - $payment->amount;

        $amount_paied += floatval($request->amount);

        if(floatval($amount_paied) > floatval($amount_due)){
            $amount_remain = floatval($amount_due) - floatval($amount_paied) + floatval($request->amount);
            return redirect()->back()->with('error_message','Payment paid cannot be great than amount due. Amount remaining is : ' . $amount_remain);
        }

        if(floatval($amount_paied) == floatval($amount_due)){
            $bills->update([
                "status"=>"Paid",
            ]);
        }

        $payment_date = date("Y-m-d");

        if(!empty($request->payment_date)){
            $payment_date = self::transform_date($request->payment_date);
        }

        $payment->update([
            'payment_date' => $payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_reference' => $request->payment_reference,
            'amount'  => $request->amount
        ]);

        $debitnote = DebitNote::find($payment->id_debitnote);
        if ($debitnote){
            $debitnote->update([
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
        $payment = Bills_payment::find($id);
        $banking = Banking::find($payment->matched_transaction);
        if ($banking){
            $status_b = 0;
            $amount_sales_banking = SalesPayments::where('matched_transaction','=', $banking->id)->sum('amount');
            $amount_bill_banking = Bills_payment::where('matched_transaction','=', $banking->id)->sum('amount');
            $total_used = ($amount_sales_banking + $amount_bill_banking - $payment->amount);
            if ($banking->amount == $total_used) $status_b = 2;
            if ($banking->amount > $total_used && $total_used != 0)  $status_b = 1;
            $banking->update([
                'matching_status' => $status_b
            ]);
            $bill_payment = Bills_payment::where('matched_transaction','=',$id)
                ->where('bill_id','=',$payment->bill_id)
                ->delete();
        }

        $debitnote = DebitNote::find($payment->id_debitnote);
        if ($debitnote){
            $debitnote->delete();
        }

        $payment->delete();
        return redirect()->back()->with('message', 'Payment Deleted Successfully');
    }
    protected function transform_date($date){
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
        return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
    }
}
