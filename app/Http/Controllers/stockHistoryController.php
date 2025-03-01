<?php

namespace App\Http\Controllers;

use App\Models\Stock_history;

use Illuminate\Http\Request;

class stockHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_history = Stock_history::get();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($stock_history);
    }
    public function stock_history_per_id_stock($stock_id)
    {
        $stock_history = Stock_history::where('stock_id',$stock_id)->orderByDesc('id')->get();
        foreach($stock_history as &$line){
            $line->normal_date_time = date_format(date_create($line->created_at), 'd/m/Y H:i');
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($stock_history);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
