<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\BillFiles;
use App\Models\Bill;
use App\Models\PettyCash;
use App\Models\Store;
use App\Models\PayementMethodSales;
use App\Models\Bills_payment;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Email_smtp;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PettyCashController extends Controller
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
        $ledgers= Ledger::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->pluck('id');

        $pettycashs = PettyCash::orWhere('id', '=', $ss)
            ->orWhere('description', 'LIKE', '%' . $ss . '%')
            ->orWhereIn('ledger_account',$ledgers)
            ->orderBy('date','DESC')
            ->paginate(8);
        $balance = 0;
        foreach ($pettycashs as &$pettycash){
            if ($pettycash->ledger_account){
                $ledger = Ledger::find($pettycash->ledger_account);
                if ($ledger)
                    $pettycash->ledger_name = $ledger->name;
            }
            $balance = $balance + ($pettycash->amount);
            $pettycash->balance = $balance;
        }
        $ledgers = Ledger::orderBy('name','ASC')->get();
        $suppliers = Supplier::orderBy('id','ASC')->get();

        return view('accounting.pettycash.index', compact(['pettycashs','ledgers','ss','suppliers']));
    }

    public function search(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        $ledgers= Ledger::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->pluck('id');

        $pettycashs = PettyCash::orWhere('id', '=', $ss)
            ->orWhere('description', 'LIKE', '%' . $ss . '%')
            ->orWhereIn('ledger_account',$ledgers)
            ->orderBy('date','DESC')->paginate(8);
        $balance = 0;
        foreach ($pettycashs as &$pettycash){
            if ($pettycash->ledger_account){
                $ledger = Ledger::find($pettycash->ledger_account);
                if ($ledger)
                    $pettycash->ledger_name = $ledger->name;
            }
            $balance = $balance + ($pettycash->amount);
            $pettycash->balance = $balance;
        }

        return view('accounting.pettycash.search_ajax', compact(['pettycashs', 'ss']));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMoneyIn()
    {
        $ledgers = Ledger::orderBy('name','ASC')->get();
        return view('accounting.pettycash.createMoneyIn', compact(['ledgers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMoneyOut()
    {
        $ledgers = Ledger::orderBy('name','ASC')->get();
        return view('accounting.pettycash.createMoneyOut', compact(['ledgers']));
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
            'ledger_account' => 'required'
        ]);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        if ($request->has('moneyOut')) {

            $petty_cash = PettyCash::create([
                'debit' => 0,
                'credit' => $request->amount,
                'amount' => -$request->amount,
                'date' => $date,
                'description' => $request->descripton,
                'ledger_account' => $request->ledger_account

            ]);

            $id_supplier = $request->supplier;
            $count_journal_d = JournalEntry::count();
            $journal_id = 1;
            $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
            if ($count_journal_d > 0) $journal_id = $last_id_journal->journal_id + 1;
            $name = 'Petty Cash #' . $petty_cash->id;
            $amount = 0;
            if (!empty(trim($request->amount))) $amount = $request->amount;
            $bill = $this->add_bill($id_supplier,$amount,$request->descripton,$request->date);
            $payment_methode = PayementMethodSales::where('payment_method','=','Cash')->orderBy('id','DESC')->first();
            
            $bills = Bill::find($bill);
            if($bills)
                $bills->update([
                    "status"=>"Paid",
                ]);

            $payment_date = $date;
            $check_bill_payment = Bills_payment::where('bill_id','=',$bill)->where('amount','=',$amount)->get();
            $bills_payments = Bills_payment::create([
                'bill_id' => $bill,
                'payment_date' => $payment_date,
                'payment_mode' => $payment_methode->id,
                'payment_reference' => $request->descripton,
                'amount'  => $amount
            ]);
            $b_refrence = "#BILL_PAYMENT_".$id_supplier."_".$request->date;
            $credit = JournalEntry::create([
                'id_order' => $petty_cash->id,
                'debit' => null,
                'credit' => $request->ledger_account,
                'amount' => $amount,
                'date' => $date,
                'name' => $name,
                'is_pettycash' => 1,
                'bills' => 1,
                'journal_id' => $journal_id,
            ]);

            if ($request->has('file_bills')) {
                foreach ($request->file('file_bills') as $image) {
                    $imageName = 'bill-id-'. $bill . '-' . $image->getClientOriginalName();
                
                    $path = public_path('files/attachment/bills/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost())));
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $src = $path . '/' . $imageName;
                    $src_t = 'files/attachment/bills/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost())) . '/' . $imageName;
                    Storage::put($src, $image);
                    BillFiles::create([
                        'bill_id'=> $bill,
                        'name'=>$imageName,
                        'type'=> $image->extension(),
                        'src'=>$src_t,
                        'date_generated'=>date("Y-m-d H:i:s")
                    ]);
    
                }
            }
            $url = ['reload' => route('petty_cash.index')];
            die(json_encode($url));
        }


        if ($request->has('moneyIn')){
            $petty_cash = PettyCash::create([
                'debit' => $request->amount,
                'credit' => 0,
                'amount' => $request->amount,
                'date' => $date,
                'description' => $request->descripton,
                'ledger_account' => $request->ledger_account,
            ]);

            $count_journal_c = JournalEntry::count();
            $journal_id = 1;
            $last_id_journal = JournalEntry::orderBy('id', 'DESC')->first();
            if ($count_journal_c > 0) $journal_id = $last_id_journal->journal_id + 1;
            $name = 'Petty Cash #' . $petty_cash->id;
            $amount = 0;
            if (!empty(trim($request->amount))) $amount = $request->amount;

            $debit = JournalEntry::create([
                'id_order' => $petty_cash->id,
                'debit' => $request->ledger_account,
                'credit' => null,
                'amount' => $amount,
                'date' => $date,
                'name' => $name,
                'is_pettycash' => 1,
                'journal_id' => $journal_id,
            ]);
        }

        return redirect()->route('petty_cash.index')->with('message', 'Petty Cash added Successfully');

    }


    public function add_bill($id_supplier,$b_amount,$b_description,$date){
        $supplier = Supplier::find($id_supplier);

        $store = Store::where('name','=','Default Store')->first();
        $payment_methode = PayementMethodSales::where('payment_method','=','Cash')->first();

        $store_name = "";
        if(isset($store->name)) $store_name = $store->name;

        $bills = new Bill([
            'amount' => $b_amount,
            'status' => "Pending",
            'bill_reference' => "#BILL_".$id_supplier."_".$date,
            'id_supplier' => $supplier->id,
            'supplier_name' => $supplier->name,
            'supplier_email' => $supplier->order_email,
            'supplier_phone' => $supplier->mobile,
            'supplier_address' => $supplier->address,
            'comment' => $b_description,
            'id_store' => $store->id,
            'store' => $store_name,
            'payment_methode' => $payment_methode->id
        ]);
        $bills->save();
        return $bills->id;
    }

    public function match_petty_cash_account_ajax($bill,$amount_pettycash,$date_match,$reference_matching_pettycash){
    
        $payment_methode = PayementMethodSales::where('payment_method','=','Cash')->first();
        $bills = Bill::find($bill);
        if($bills)
            $bills->update([
                "status"=>"Paid",
            ]);

        $payment_date = self::transform_date($date_match);
        $check_bill_payment = Bills_payment::where('bill_id','=',$bill)->where('amount','=',$amount_pettycash)->get();
        if(count($check_bill_payment)) $check_bill_payment->delete();
        $bills_payments = Bills_payment::updateOrCreate([
            'bill_id' => $bill,
            'payment_date' => $payment_date,
            'payment_mode' => $payment_methode->id,
            'payment_reference' => $reference_matching_pettycash,
            'amount'  => $amount_pettycash
        ]);
    }

    protected function transform_date($date){
        $d = explode('/', $date);
        if (isset($d[2]) && isset($d[1]) && isset($d[0]))
        return $d[2] . "-" . $d[1] . "-" . $d[0];
        else return NULL;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PettyCash  $pettyCash
     * @return \Illuminate\Http\Response
     */
    public function show(PettyCash $pettyCash)
    {
        $ledgers = Ledger::orderBy('name','ASC')->get();
        return view('accounting.pettycash.show', compact(['ledgers','pettyCash']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PettyCash  $pettyCash
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ledgers = Ledger::orderBy('name','ASC')->get();
        $pettyCash = PettyCash::find($id);
        return view('accounting.pettycash.edit', compact(['ledgers','pettyCash']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PettyCash  $pettyCash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date' => 'required',
            'ledger_account' => 'required'
        ]);
        $pettyCash = PettyCash::find($id);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        if ($request->typeOfMoney == 'MoneyOut')
            $pettyCash->update([
                'debit' => 0,
                'credit' => $request->amount,
                'amount' => -$request->amount,
                'date' => $date,
                'description' => $request->descripton,
                'ledger_account' => $request->ledger_account,

            ]);

        if ($request->typeOfMoney == 'MoneyIn')
            $pettyCash->update([
                'debit' => $request->amount,
                'credit' => 0,
                'amount' => $request->amount,
                'date' => $date,
                'description' => $request->descripton,
                'ledger_account' => $request->ledger_account,
            ]);
        return redirect()->route('petty_cash.index')->with('message', 'Petty Cash updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PettyCash  $pettyCash
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pettyCash = PettyCash::find($id);
        $pettyCash->delete();
        return redirect()->route('petty_cash.index')->with('message', 'Petty Cash deleted Successfully');

    }

    public function petty_cash_ledger_ajax(Request $request){

        $name = $request->name;
        $id_ledger_group =0;
        $ledger = Ledger::where('name','=',$name)->orderBy('id','DESC')->first();
        if (!$ledger){
            $ledger = Ledger::updateOrCreate([
                'name' => $name,
                'id_ledger_group' => $id_ledger_group,
            ]);
        }

        return view('accounting.pettycash.new_option_ledger', compact(['ledger']));
    }
}
