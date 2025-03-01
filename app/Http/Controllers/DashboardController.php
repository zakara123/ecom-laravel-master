<?php

namespace App\Http\Controllers;

use App\Exports\StatsExport;
use App\Models\Sales;
use App\Models\SalesPayments;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\Cart;
use App\Models\Setting;
use App\Models\Company;
use Session;
use DB;

use App\Models\User;
use App\Models\Doctor;
class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $strWeek_date = [];
        $Week_data_current = [];
        $week_data_previous = [];
        $now = Carbon::now();

        $first_day_week = $now->copy()->startOfWeek();
        $first_previews_day_week = $now->copy()->subWeek()->startOfWeek();

        $f_day = $now->copy()->startOfWeek();
        $f_day_p = $now->copy()->subWeek()->startOfWeek();

        $l_day = $now->copy()->endOfWeek();
        $l_day_p = $now->copy()->subWeek()->endOfWeek();

        $strWeek_date[] = $now->copy()->startOfWeek()->format('d M');
        $total_revenu = 0;
        $total__previous_revenu = 0;
        $sum = SalesPayments::where('payment_date', '=',$now->copy()->startOfWeek()->format('Y-m-d'))
            ->groupBy('payment_date')
            ->sum('amount');
        $Week_data_current[] = $sum;
        $total_revenu += $sum;
        $i = 1;

        $diff_days = $f_day->diffInDays($l_day);

        for($j=0; $j < $diff_days; $j++){
            $day_week = $first_day_week->addDays($i);
            $strWeek_date[] = $day_week->format('d M');
            $sum = SalesPayments::where('payment_date', '=',$day_week->format('Y-m-d'))
                ->groupBy('payment_date')
                ->sum('amount');

            $Week_data_current[] = $sum;
            $total_revenu += $sum;
        }

        $sum_previous = SalesPayments::where('payment_date', '=',$first_previews_day_week->format('Y-m-d'))
            ->groupBy('payment_date')
            ->sum('amount');
        $week_data_previous[] = $sum_previous;
        $total__previous_revenu += $sum_previous;
        $p = 1;

        $diff_days_p = $f_day_p->diffInDays($l_day_p);
        for($k=0; $k < $diff_days_p; $k++){
            $sum_previous = SalesPayments::where('payment_date', '=',$first_previews_day_week->addDays($p)->format('Y-m-d'))
                ->groupBy('payment_date')
                ->sum('amount');
            $week_data_previous[] = $sum_previous;
            $total__previous_revenu += $sum_previous;
        }

        $check_aug = ($total_revenu - $total__previous_revenu)/100;
        $total_revenu = number_format($total_revenu,2,".",",");
        $chartSale = (new LarapexChart)->areaChart()
            ->setTitle('Rs '. $total_revenu)
            ->setSubtitle('Sales this week.')
            ->addData('Revenu', $Week_data_current)
            ->addData('Previous Revenu', $week_data_previous)
            ->setXAxis($strWeek_date);

        $last_transaction_payement = SalesPayments::latest()->orderBy('payment_date','DESC')->paginate(8);
        foreach ($last_transaction_payement as &$ltp){
            $sale = Sales::find($ltp->sales_id);
            if ($sale){
                $ltp->name = $sale->customer_firstname.' '. $sale->customer_lastname;
            }
        }

        return view('dashboard',compact(['chartSale','check_aug','last_transaction_payement']));
    }

    public function exportStat(Request $request){
        $this->validate($request, [
            'start' => 'required',
        ]);

        $date_start = date('Y-m-d', strtotime($request->start));
        $date_end = date('Y-m-d', strtotime($request->end));
        if($date_end < $date_start && $request->end != ''){
            $date_f = $date_start;
            $date_start = $date_end;
            $date_end =$date_f;
        }

//        return Excel::download(new StatsExport, 'stats.xlsx');
        return (new StatsExport($date_start,$date_end))->download('Stats Exported '. date('Y-m-d-H-i-s') .'.xlsx');
    }

    /// front
    public function privacyPolicy()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $privacy_policy = Setting::where("key","privacy_policy")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        return view('front.privacy_policy', compact(['headerMenuColor','headerMenus', 'company', 'shop_favicon', 'shop_name', 'shop_description','carts','privacy_policy','code_added_header']));
    }

    public function contactUs()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $privacy_policy = Setting::where("key","privacy_policy")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        return view('front.contact_us', compact(['headerMenuColor','headerMenus', 'company', 'shop_favicon', 'shop_name', 'shop_description','carts','privacy_policy','code_added_header']));
    }
    public function termsConditions()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $terms_conditions = Setting::where("key","terms_conditions")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        return view('front.terms_conditions', compact(['headerMenuColor','headerMenus', 'company', 'shop_name','shop_favicon', 'shop_description','carts','terms_conditions','code_added_header']));
    }


    public function doctorsDirectory()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $terms_conditions = Setting::where("key","terms_conditions")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        $doctors = Doctor::get();
        foreach($doctors as $item){
            $item->user =  User::find($item->user_id);
        }

        
        return view('front.doctor-directory', compact(['doctors','headerMenuColor','headerMenus', 'company', 'shop_name','shop_favicon', 'shop_description','carts','terms_conditions','code_added_header']));
    }
    
    public function doctorPublicPage($id)
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $terms_conditions = Setting::where("key","terms_conditions")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        $doctor = Doctor::find($id);
        $user = User::find($doctor->user_id);

        if($doctor->public_page_status != 'Active'){
            return redirect('/');
        }
        return view('front.public_profile_doctor', compact(['doctor','user','headerMenuColor','headerMenus', 'company', 'shop_name','shop_favicon', 'shop_description','carts','terms_conditions','code_added_header']));
    }

    public function appointmentRequest()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $terms_conditions = Setting::where("key","terms_conditions")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        $doctors = DB::table('doctors')->get();

        // Initialize an array to hold grouped results
        $groupedBySpecialities = [];

        // Process each doctor record
        foreach ($doctors as $doctor) {
            // Split the comma-separated specialities
            $specialities = explode(',', $doctor->specialities);

            foreach ($specialities as $speciality) {
                // Trim any extra whitespace
                $speciality = trim($speciality);

                // Initialize the array for this speciality if it doesn't exist
                if (!isset($groupedBySpecialities[$speciality])) {
                    $groupedBySpecialities[$speciality] = [];
                }

                // Add the doctor to the array for this speciality
                $groupedBySpecialities[$speciality][] = $doctor;
            }
        }

        return view('front.appointment-request', compact(['groupedBySpecialities','headerMenuColor','headerMenus','company', 'shop_name','shop_favicon', 'shop_description','carts','terms_conditions','code_added_header']));
    }

    public function returnPolicy()
    {
        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children){
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0){
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child){
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0){
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $session_id = Session::get('session_id');
        if (isset($enable_online_shop->value) && $enable_online_shop->value == "no") {
            if (!empty($session_id)) {
                $res = Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $return_policy = Setting::where("key","return_policy")->first();
        $code_added_header = Setting::where("key","code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }

        return view('front.return_policy', compact(['headerMenuColor','headerMenus', 'company', 'shop_name','shop_favicon', 'shop_description','carts','return_policy','code_added_header']));
    }
}
