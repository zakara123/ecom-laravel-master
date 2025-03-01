<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Ledger;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
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
        $journals = JournalEntry::orWhere('journal_id', '=', $ss)
            ->orWhere('name', 'LIKE', '%' . $ss . '%')
            ->orWhere('date', 'LIKE', '%' . $ss . '%')
            ->orWhere('description', 'LIKE', '%' . $ss . '%')
            ->orWhereIn('credit',$ledgers)
            ->orWhereIn('debit',$ledgers)
            ->orderBy('date','DESC')
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
            $double_entry = 0;
            $journal->is_double = count($journal_get_all_info);
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
        return view('accounting.journal.index', compact(['journals','ss']));
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
        $journals = JournalEntry::orWhere('journal_id', '=', $ss)
            ->orWhere('name', 'LIKE', '%' . $ss . '%')
            ->orWhere('date', 'LIKE', '%' . $ss . '%')
            ->orWhere('description', 'LIKE', '%' . $ss . '%')
            ->orWhereIn('credit',$ledgers)
            ->orWhereIn('debit',$ledgers)
            ->orderBy('date','DESC')
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
            $double_entry = 0;
            $journal->is_double = count($journal_get_all_info);
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

        return view('accounting.journal.search_ajax', compact(['journals', 'ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ledgers = Ledger::orderBy('name','ASC')->get();
        return view('accounting.journal.create', compact(['ledgers']));
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
            'date' => 'required',
        ]);

        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        $count_journal = JournalEntry::count();
        $journal_id = 1;
        $last_id_journal = JournalEntry::orderBy('id','DESC')->first();
        if ($count_journal > 0) $journal_id = $last_id_journal->journal_id + 1;
        $name = 'Journal #'. $journal_id;
        $amount = 0;
        if (!empty(trim($request->name))) $name = $request->name;
        if (!empty(trim($request->amount))) $amount = $request->amount;
        $debit = JournalEntry::create([
            'debit' => $request->debit,
            'credit' => null,
            'amount' => $amount,
            'date' => $date,
            'description' =>$request->description,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        $credit = JournalEntry::create([
            'debit' => null,
            'credit' => $request->credit,
            'amount' => $amount,
            'date' => $date,
            'description' => $request->description,
            'name' => $name,
            'journal_id' => $journal_id,
        ]);

        return redirect()->route('journal.index')->with('message', 'Journal Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function show(JournalEntry $journals)
    {
        return view('accounting.journal.show', compact(['journals']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $journal = JournalEntry::find($id);
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
//        dd($journal);
        $ledgers = Ledger::orderBy('name','ASC')->get();
        return view('accounting.journal.edit', compact(['ledgers','journal']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required',
        ]);

        $journal = JournalEntry::find($id);
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request->date)));
        $name = 'Journal #'. $journal->journal_id;
        $amount = 0;
        if (!empty(trim($request->name))) $name = $request->name;
        if (!empty(trim($request->amount))) $amount = $request->amount;

        $journal_debit = JournalEntry::find($request->journal_id_debit);
        $journal_credit = JournalEntry::find($request->journal_id_credit);
        if ($journal_debit){
            $journal_debit->update([
                'debit' => $request->debit,
                'credit' => null,
                'amount' => $request->amount,
                'date' => $date,
                'description' =>$request->description,
                'name' => $name,
            ]);
        }

        if ($journal_credit){
            $journal_credit->update([
                'debit' => null,
                'credit' => $request->credit,
                'amount' => $request->amount,
                'date' => $date,
                'description' =>$request->description,
                'name' => $name,
            ]);
        }
        if (!$journal_debit && !$journal_debit)
            $journal->update([
                'debit' => $request->debit,
                'credit' => $request->credit,
                'amount' => $request->amount,
                'date' => $date,
                'description' =>$request->description,
                'name' => $name,
            ]);

        return redirect()->route('journal.index')->with('message', 'Journal Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = JournalEntry::where('journal_id','=',$id)->delete();
//        $journal->delete();
        return redirect()->route('journal.index')->with('message', 'Journal Deleted Successfully');
    }
}
