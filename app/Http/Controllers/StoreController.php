<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::latest()->orderBy('id', 'DESC')->paginate(10);
        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stores.create');
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

        if(request()->has('pickup_location') === false){
            $request->request->add(['pickup_location' => 'no']);
        }  else $request->request->add(['pickup_location' => 'yes']);

        Store::updateOrCreate([
            'name' => $request->name,
            'pickup_location'  => $request->pickup_location,
//            'vat_type'  => $request->vat_type
        ]);
        // $category->save();

        return redirect()->route('settings.index')->with('message', 'Store Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return view('stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = Store::find($id);

        if($store == NULL) abort(404);

        return view('stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if(request()->has('pickup_location') === false){
            $request->request->add(['pickup_location' => 'no']);
        }  else $request->request->add(['pickup_location' => 'yes']);

        $store = Store::find($id);
        $store->update([
            'name' => $request->name,
            'pickup_location'  => $request->pickup_location,
//            'vat_type'  => $request->vat_type,
        ]);

        return redirect()->route('settings.index')->with('message', 'Store Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);
        $store->delete();
        return redirect()->route('settings.index')->with('message', 'Store Deleted Successfully');
    }
}
