<?php

namespace App\Http\Controllers;

use App\Models\CreditNote;
use App\Models\Customer;
use App\Models\DebitNoteSales;
use App\Models\MRATransaction;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Sales_products;
use App\Models\SalesEBSResults;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDF;
use PHPMailer\PHPMailer\PHPMailer;
use Session;

class MRAController extends Controller
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
//        $SalesEBS = SalesEBSResults::select('*')->where('status','Down')->orderBy('sale_id', 'ASC')->paginate(10);


        // Première requête
        $query1 = DB::table('sales_e_b_s_results')
            ->select(
                DB::raw('null as sales_id'),
                'sale_id',
                DB::raw('null as date'),
                DB::raw('null as amount'),
                DB::raw('null as reason'),
                'responseId',
                'requestId',
                'status',
                'jsonRequest',
                'invoiceIdentifier',
                'irn',
                'qrCode',
                'infoMessages',
                'created_at',
                'errorMessages')
            ->where('status','Down');

        // Deuxième requête avec union
        $query2 = DB::table('credit_notes')
            ->select(
                DB::raw('null as sale_id'),
                'sales_id',
                'date',
                'amount',
                'reason',
                'responseId',
                'requestId',
                'status',
                'jsonRequest',
                'invoiceIdentifier',
                'irn',
                'qrCode',
                'infoMessages',
                'created_at',
                'errorMessages')
            ->where('status','Down')
            ->union($query1);

        // Troisième requête avec union
        $query3 = DB::table('debit_note_sales')
            ->select(DB::raw('null as sale_id'),
                'sales_id',
                'date',
                'amount',
                'reason',
                'responseId',
                'requestId',
                'status',
                'jsonRequest',
                'invoiceIdentifier',
                'irn',
                'qrCode',
                'infoMessages',
                'created_at',
                'errorMessages')
            ->where('status','Down')
            ->union($query2);

        // Exécuter la requête combinée
        $allResults = $query3->orderBy('created_at','ASC')->get();

        // Pagination manuelle
        $perPage = 10; // Nombre d'éléments par page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageResults = $allResults->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Créer la pagination
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allResults), $perPage);

        // Assurer que les liens de pagination prennent en compte les paramètres de la requête
        $paginatedResults->setPath(request()->url());


        return view('mra.unsubmitted_invoices', compact(['paginatedResults']));
    }

    public function send_unsumbitted_invoices(Request $request){
        $salesESB = SalesEBSResults::where('status','Down')->get();
        foreach ($salesESB as $sebs){
            $sales = Sales::find($sebs->sale_id);
            $newSales = Sales_products::where("sales_id", $sebs->sale_id)->get();
            $customer = Customer::find($sales->customer_id);
            $id_mra_sales =  $sebs->id;
            MRATransaction::mra_ebs_transaction($sales, $newSales, $customer,false,'Standard',
                                        null,null,$id_mra_sales,true);
        }

        $cnESB = CreditNote::where('status','Down')->get();
        foreach ($cnESB as $cebs){
            $sales = Sales::find($cebs->sales_id);
            $newSales = Sales_products::where("sales_id", $cebs->sales_id)->get();
            $customer = Customer::find($sales->customer_id);
            $id_mra_sales =  $cebs->id;
            MRATransaction::mra_ebs_transaction($sales, $newSales, $customer,false,'Standard',
                $cebs->id,null,$id_mra_sales,true);
        }

        $dnsESB = DebitNoteSales::where('status','Down')->get();
        foreach ($dnsESB as $debs){
            $sales = Sales::find($debs->sales_id);
            $newSales = Sales_products::where("sales_id", $debs->sales_id)->get();
            $customer = Customer::find($sales->customer_id);
            $id_mra_sales =  $debs->id;
            MRATransaction::mra_ebs_transaction($sales, $newSales, $customer,false,'Standard',
                null,$debs->id,$id_mra_sales,true);
        }
        $msg = "Unsubmitted Invoice have send";
        return redirect()->route('mra.unsubmitted_invoices')->with('success', $msg);
    }
}
