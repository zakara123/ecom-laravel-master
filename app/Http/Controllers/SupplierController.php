<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        
        $suppliers = Supplier::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('address', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy('id', 'DESC')->paginate(10);
        return view('supplier.index', compact(['suppliers', 'ss']));
    }

    public function search(Request $request)
    {
        $ss = '';
        if ($request->s) $ss = $request->s;
        /* company_name
        'firstname'
            'lastname' */
        // $customers = Customer::latest()->orderBy('id', 'DESC')->paginate(10);
        $suppliers = Supplier::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('address', 'LIKE', '%' . $s . '%')
                        ->orWhere('mobile', 'LIKE', '%' . $s . '%')
                        ->orWhere('email_address', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy('id', 'DESC')->paginate(10);
        return view('supplier.search_ajax', compact(['suppliers', 'ss']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
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
            'email' => 'email|unique:suppliers'
        ]);

        if(request()->has('halal_certified') === false){
            $request->request->add(['halal_certified' => 'no']);
        }  else $request->request->add(['halal_certified' => 'yes']);


        $supplier = Supplier::updateOrCreate([
            'name' => $request->name,
            'address' => $request->address,
            'brn' => $request->brn,
            'vat_supplier' => $request->vat_supplier,
            'halal_certified' => $request->halal_certified,
            'order_email' => $request->order_email,
            'credit_limit' => $request->credit_limit,
            'payment_frequency' => $request->payment_frequency,
            'ordering_frequency' => $request->ordering_frequency,
            'delivery_days' => $request->delivery_days,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'name_person' => $request->name_person,
            'email_address' => $request->email_address,
            'mobile' => $request->mobile,
            'office_phone' => $request->office_phone
        ]);
        return redirect()->route('supplier.index')->with('message', 'Supplier Created Successfully');

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
        $supplier = Supplier::find($id);
        return view('supplier.edit', compact('supplier'));
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
            'name' => 'required',
            'email' => 'email|unique:suppliers'
        ]);
        $supplier = Supplier::find($id);
        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'brn' => $request->brn,
            'vat' => $request->vat,
            'vat_supplier' => $request->vat_supplier,
            'halal_certified' => $request->halal_certified,
            'order_email' => $request->order_email,
            'credit_limit' => $request->credit_limit,
            'payment_frequency' => $request->payment_frequency,
            'ordering_frequency' => $request->ordering_frequency,
            'delivery_days' => $request->delivery_days,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'name_person' => $request->name_person,
            'email_address' => $request->email_address,
            'mobile' => $request->mobile,
            'office_phone' => $request->office_phone
        ]);

        return redirect()->route('supplier.index')->with('message', 'Supplier Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('supplier.index')->with('message', 'Supplier Deleted Successfully');
    }
}
