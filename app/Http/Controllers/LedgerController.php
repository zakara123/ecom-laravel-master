<?php

namespace App\Http\Controllers;

use App\Imports\LedgerImport;
use App\Imports\ImportLedgerMultiplSheet;
use App\Models\JournalEntry;
use App\Models\Ledger;
use App\Models\Sales;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LedgerController extends Controller
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
        ])->orderBy('id_ledger_group', 'ASC')->orderBy('id', 'ASC')->paginate(8);
        foreach ($ledgers as &$ledger){
            $ledger_group = Ledger::find($ledger->id_ledger_group);
            $ledger_group_name = '';
            if ($ledger_group != null) $ledger_group_name = $ledger_group->name;
            $ledger->ledger_group = $ledger_group_name;
        }
        return view('accounting.ledger.index', compact(['ledgers', 'ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ledgerGroups = Ledger::orderBy('name', 'ASC')->get();
        return view('accounting.ledger.create',compact('ledgerGroups'));
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
        ])->orderBy('id', 'DESC')->paginate(8);

        foreach ($ledgers as &$ledger){
            $ledger_group = Ledger::find($ledger->id_ledger_group);
            $ledger_group_name = '';
            if ($ledger_group != null) $ledger_group_name = $ledger_group->name;
            $ledger->ledger_group = $ledger_group_name;
        }
        return view('accounting.ledger.search_ajax', compact(['ledgers', 'ss']));
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
            'name' => 'required',
        ]);
        $name = $request->name;
        $id_ledger_group = $request->id_ledger_group;
        if ($id_ledger_group == "Parent") $id_ledger_group = 0;


        $ledger = Ledger::updateOrCreate([
            'name' => $name,
            'id_ledger_group' => $id_ledger_group,
        ]);

        return redirect()->route('ledger.index')->with('message', 'Ledger added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        $transactions_t = JournalEntry::where('credit','=',$ledger->id)
            ->orWhere('debit','=',$ledger->id)
            ->orderBy('date','DESC')
            ->paginate(8);
        $transaction_id = [];
        foreach ($transactions_t as &$transaction_t){
//            $transaction_id[$transaction_t->id_order] = $transaction_t->id;
            if($transaction_t->debit) $transaction_t->debit_amount = $transaction_t->amount;
            if($transaction_t->credit) $transaction_t->credit_amount = $transaction_t->amount;
            if (str_contains($transaction_t->name,'Sale'))$transactions_t->is_sale = 1;
            if (str_contains($transaction_t->name,'Bill'))$transactions_t->is_bill = 1;
            if (str_contains($transaction_t->name,'Petty'))$transactions_t->is_petty = 1;
            $transaction_t->balance = $transaction_t->amount;
        }

        $transactions = $transactions_t;
        foreach ($transactions as &$transaction){
            $customer_order = Sales::find($transaction->id_order);
            if ($customer_order){
                $transaction->customer_name = $customer_order->customer_firstname .' '. $customer_order->customer_lastname;
                $transaction->customer_id = $customer_order->customer_id;
            }
        }
        return view('accounting.ledger.details', compact(['transactions','ledger']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ledger = Ledger::find($id);
        $ledgerGroups = Ledger::orderBy('name', 'ASC')->get();
        return view('accounting.ledger.edit', compact(['ledgerGroups','ledger']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $ledger = Ledger::find($id);
        $name = $request->name;
        $id_ledger_group = $request->id_ledger_group;

        if ($id_ledger_group == "Parent") $id_ledger_group = 0;

        $ledger->update([
            'name' => $name,
            'id_ledger_group' => $id_ledger_group,
        ]);

        return redirect()->route('ledger.index')->with('message', 'Ledger Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ledger = Ledger::find($id);
        $ledger->delete();
        return redirect()->route('ledger.index')->with('message', 'Ledger Deleted Successfully');
    }

    public function details_ledger($id)
    {
        $total = 0;
        $ledger = Ledger::find($id);
        $transactions_t = JournalEntry::where('credit','=',$ledger->id)
        ->orWhere('debit','=',$ledger->id)
        ->orderBy('date','DESC')
        ->paginate(8);
        $transaction_id = [];
        foreach ($transactions_t as &$transaction_t){
//            $transaction_id[$transaction_t->id_order] = $transaction_t->id;
            if($transaction_t->debit) $transaction_t->debit_amount = $transaction_t->amount;
            if($transaction_t->credit) $transaction_t->credit_amount = $transaction_t->amount;
            if (str_contains($transaction_t->name,'Sale'))$transactions_t->is_sale = 1;
            if (str_contains($transaction_t->name,'Bill'))$transactions_t->is_bill = 1;
            if (str_contains($transaction_t->name,'Petty'))$transactions_t->is_petty = 1;
            $transaction_t->balance = $transaction_t->amount;
        }
        $transactions = $transactions_t;
        foreach ($transactions as &$transaction){
            $customer_order = Sales::find($transaction->id_order);
            if ($customer_order){
                $transaction->customer_name = $customer_order->customer_firstname .' '. $customer_order->customer_lastname;
                $transaction->customer_id = $customer_order->customer_id;
            }
        }
        return view('accounting.ledger.details', compact(['transactions','ledger']));

    }

    public function importLedgerView(Request $request)
    {
        return view('accounting.ledger.importLedgerFile');
    }
    
    public function importLedger(Request $request)
    {
        $import = new ImportLedgerMultiplSheet();
        $ts =  Excel::import($import, $request->file('file'));
        dd("import");
        return redirect()->route('ledger.index')->with('message', 'Ledger imported Successfully');
    }
}
