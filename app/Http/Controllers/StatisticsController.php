<?php

namespace App\Http\Controllers;

use App\Exports\ExportStatsSales_Debtor;
use App\Exports\ExportStatsSales_Detailed;
use App\Exports\ExportStatsSales_Payments;
use App\Exports\ExportStatsSales_Return;
use App\Models\PayementMethodSales;
use App\Models\Sales;
use App\Models\Store;
use App\Models\SalesPayments;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd($request);



        $pending_info = $paid_info = $other_info = $methode_info = array();
        $totals_pending = $totals_paid = $totals = 0;
        if (!isset($request->date_begin)) $request->date_begin = Carbon::now()->format('Y-m-d');
        if (!isset($request->date_end)) $request->date_end = Carbon::now()->format('Y-m-d');
        $date_d = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_begin)));
        $date_f = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
        $id_store = $request->store;
        if ($date_d > $date_f) {
            $date_permut = $date_f;
            $date_f = $date_d;
            $date_d = $date_permut;
        }


        if (empty($request->all())) {


            $payement_methodes = PayementMethodSales::orderBy('id', 'Asc')->get();

            if (!$id_store) {
                foreach ($payement_methodes as &$pm) {


                    // Get total amount for 'Pending' sales for the given payment method, store, and date range
                    $total_pending = Sales::where('status', '=', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })
                        ->sum('amount');


                    // Calculate total paid amount for the given payment method and date range
                    $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('payment_date', [$date_d, $date_f])
                                ->orWhereDate('payment_date', '=', $date_d)
                                ->orWhereDate('payment_date', '=', $date_f);
                        })->sum('amount');





                    $total_other = Sales::where('status', '<>', 'Paid')->where('status', '<>', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })->sum('amount');


                    $pm->pending = $total_pending;
                    $pm->paid = $total_paid;
                    $pm->other = $total_other;
                    $totals_pending += $total_pending;
                    $totals_paid += $total_paid;
                    $totals += $total_pending + $total_paid + $total_other;
                }
            } else {
                foreach ($payement_methodes as &$pm) {
                    // Get all sales with status 'Paid' for the given payment method, store, and date range
                    $id_sale = Sales::where('status', '=', 'Paid')
                        ->where('payment_methode', '=', $pm->id)
                        ->where('id_store', '=', $id_store)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })->pluck('id');  // Get an array of sale IDs

                    // Get total amount for 'Pending' sales for the given payment method, store, and date range
                    $total_pending = Sales::where('status', '=', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where('id_store', '=', $id_store)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })
                        ->sum('amount');


                    // Calculate total paid amount for the given payment method and date range
                    $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)
                        ->whereIn('sales_id', $id_sale)  // Use whereIn to match any of the sale IDs
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('payment_date', [$date_d, $date_f])
                                ->orWhereDate('payment_date', '=', $date_d)
                                ->orWhereDate('payment_date', '=', $date_f);
                        })->sum('amount');





                    $total_other = Sales::where('status', '<>', 'Paid')->where('status', '<>', 'Pending')->where('id_store', '=', $id_store)->where('payment_methode', '=', $pm->id)->where(function ($query) use ($date_d, $date_f) {
                        $query->whereBetween('created_at', [$date_d, $date_f])
                            ->orWhereDate('created_at', '=', $date_d)
                            ->orWhereDate('created_at', '=', $date_f);
                    })->sum('amount');


                    $pm->pending = $total_pending;
                    $pm->paid = $total_paid;
                    $pm->other = $total_other;

                    $totals_pending += $total_pending;
                    $totals_paid += $total_paid;
                    $totals += $total_pending + $total_paid + $total_other;
                }
            }

            $methode_info = $payement_methodes;
        }




        if ($request->has('search_button') && !empty($request->date_begin) && !empty($request->date_end)) {

            $payement_methodes = PayementMethodSales::orderBy('id', 'Asc')->get();

            if (!$id_store) {
                foreach ($payement_methodes as &$pm) {


                    // Get total amount for 'Pending' sales for the given payment method, store, and date range
                    $total_pending = Sales::where('status', '=', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })
                        ->sum('amount');


                    // Calculate total paid amount for the given payment method and date range
                    $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('payment_date', [$date_d, $date_f])
                                ->orWhereDate('payment_date', '=', $date_d)
                                ->orWhereDate('payment_date', '=', $date_f);
                        })->sum('amount');





                    $total_other = Sales::where('status', '<>', 'Paid')->where('status', '<>', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })->sum('amount');


                    $pm->pending = $total_pending;
                    $pm->paid = $total_paid;
                    $pm->other = $total_other;
                    $totals_pending += $total_pending;
                    $totals_paid += $total_paid;
                    $totals += $total_pending + $total_paid + $total_other;
                }
            } else {
                foreach ($payement_methodes as &$pm) {
                    // Get all sales with status 'Paid' for the given payment method, store, and date range
                    $id_sale = Sales::where('status', '=', 'Paid')
                        ->where('payment_methode', '=', $pm->id)
                        ->where('id_store', '=', $id_store)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })->pluck('id');  // Get an array of sale IDs

                    // Get total amount for 'Pending' sales for the given payment method, store, and date range
                    $total_pending = Sales::where('status', '=', 'Pending')
                        ->where('payment_methode', '=', $pm->id)
                        ->where('id_store', '=', $id_store)
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('created_at', [$date_d, $date_f])
                                ->orWhereDate('created_at', '=', $date_d)
                                ->orWhereDate('created_at', '=', $date_f);
                        })
                        ->sum('amount');


                    // Calculate total paid amount for the given payment method and date range
                    $total_paid = SalesPayments::where('payment_mode', '=', $pm->id)
                        ->whereIn('sales_id', $id_sale)  // Use whereIn to match any of the sale IDs
                        ->where(function ($query) use ($date_d, $date_f) {
                            $query->whereBetween('payment_date', [$date_d, $date_f])
                                ->orWhereDate('payment_date', '=', $date_d)
                                ->orWhereDate('payment_date', '=', $date_f);
                        })->sum('amount');





                    $total_other = Sales::where('status', '<>', 'Paid')->where('status', '<>', 'Pending')->where('id_store', '=', $id_store)->where('payment_methode', '=', $pm->id)->where(function ($query) use ($date_d, $date_f) {
                        $query->whereBetween('created_at', [$date_d, $date_f])
                            ->orWhereDate('created_at', '=', $date_d)
                            ->orWhereDate('created_at', '=', $date_f);
                    })->sum('amount');


                    $pm->pending = $total_pending;
                    $pm->paid = $total_paid;
                    $pm->other = $total_other;

                    $totals_pending += $total_pending;
                    $totals_paid += $total_paid;
                    $totals += $total_pending + $total_paid + $total_other;
                }
            }

            $methode_info = $payement_methodes;
        }
        if (!$id_store) $id_store = 0;



        

        if ($request->has('select_button_export_xls') && !empty($request->date_begin) && !empty($request->date_end)) {


            // dd($id_store);

            $date_b = date('d-m-Y', strtotime($date_d));
            $date_e = date('d-m-Y', strtotime($date_f));


            $date_f = date('Y-m-d', strtotime($date_f . ' +1 day'));


            return (new ExportStatsSales_Payments($date_d, $date_f, $id_store))->download($date_b . '-to-' . $date_e . '-sales-payment' . '.xlsx');
        }




        if ($request->has('select_button_export_xls_orders') && !empty($request->date_begin) && !empty($request->date_end)) {
            $date_b = date('d-m-Y', strtotime($date_d));
            $date_e = date('d-m-Y', strtotime($date_f));

            $date_f = date('Y-m-d', strtotime($date_f . ' +1 day'));


            return (new ExportStatsSales_Detailed($date_d, $date_f, $id_store))->download($date_b . '-to-' . $date_e . '-detailed-reported' . '.xlsx');
        }



        if ($request->has('select_button_export_xls_debtors') && !empty($request->date_begin) && !empty($request->date_end)) {
            $date_b = date('d-m-Y', strtotime($date_d));
            $date_e = date('d-m-Y', strtotime($date_f));

            $date_f = date('Y-m-d', strtotime($date_f . ' +1 day'));

            return (new ExportStatsSales_Debtor($date_d, $date_f, $id_store))->download($date_b . '-to-' . $date_e . '-debtors' . '.xlsx');
        }





        if ($request->has('select_button_export_xls_return') && !empty($request->date_begin) && !empty($request->date_end)) {
            $date_b = date('d-m-Y', strtotime($date_d));
            $date_e = date('d-m-Y', strtotime($date_f));

            $date_f = date('Y-m-d', strtotime($date_f . ' +1 day'));


            return (new ExportStatsSales_Return($date_d, $date_f, $id_store))->download($date_b . '-to-' . $date_e . '-return-report' . '.xlsx');
        }


        $stores = Store::orderBy('id', 'Desc')->get();
        return view('stats.index', compact(['stores', 'methode_info', 'date_d', 'date_f', 'id_store', 'totals_pending', 'totals_paid', 'totals']));
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
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
