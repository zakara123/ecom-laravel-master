<?php

namespace App\Http\Controllers;
use App\Models\Delivery;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery = Delivery::get();
        return view("delivery.index", compact(['delivery']));
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
            'delivery_name' => 'required'
        ]);
        Delivery::updateOrCreate([
            'delivery_name' => $request->delivery_name,
            'vat' => $request->vat,
            'delivery_fee' => $request->delivery_fee
        ]);

        return redirect()->back()->with('success','Delivery added successfully!');
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
        $delivery = Delivery::find($id);

        if($delivery == NULL) abort(404);

        return view('delivery.edit', compact('delivery'));
    }
    public function updateActiveDelivery(Request $request){
        $delivery = Delivery::find($request->id);

        if($delivery->is_active == "yes"){
            $delivery->update([
                'is_active'=> "no"
            ]);
        }else{
            $delivery->update([
                'is_active'=> "yes"
            ]);
        }

        return redirect()->back()->with('success', 'Delivery updated Successfully');
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
            'delivery_name' => 'required',
            'delivery_fee' => 'required|gt:0',
            'vat' => 'required'
        ]);

        if(request()->has('is_active') === false){
            $request->request->add(['is_active' => 'no']);
        }  else $request->request->add(['is_active' => 'yes']);

        $delivery = Delivery::find($id);
        $delivery->update([
            'delivery_name' => $request->delivery_name,
            'delivery_fee'  => $request->delivery_fee,
            'vat'  => $request->vat,
            'is_active'  => $request->is_active,
        ]);

        return redirect()->route('delivery.index')->with('message', 'Delivery Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();
        return redirect()->back()->with('success','Delivery deleted successfully!');
    }
}
