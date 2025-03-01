<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocompleteCustomer(Request $request)
    {
        $res = Customer::where("firstname","LIKE","%{$request->search}%")
            ->orWhere("lastname","LIKE","%{$request->search}%")
            ->get();

        return response()->json($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocompleteSupplier(Request $request)
    {
        $res = Supplier::where("name","LIKE","%{$request->search}%")
            ->get();

        return response()->json($res);
    }
}
