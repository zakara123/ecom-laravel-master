<?php

namespace App\Http\Controllers;

use App\Models\OnlineStockApi;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Category;
use App\Models\Product_image;
use App\Models\Products;
use App\Models\Category_product;
use App\Models\Cart;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\Company;
use App\Models\ProductSettings;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->orderBy('id', 'DESC')->paginate(10);
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'category' => 'required',
        ]);
        $slug = self::transform_slug($request->input('category'));


        $category = Category::updateOrCreate([
            'category' => $request->category,
            'slug' => $slug
        ]);
        // $category->save();

        return redirect()->route('category.index')->with('message', 'Category Created Successfully');
    }
    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        $exists = Products::whereSlug($str)->exists();
        if ($exists) return $str . "-1";
        return $str;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required',
        ]);
        $slug = self::transform_slug($request->input('category'));
        $category = Category::find($id);
        $category->update([
            'category' => $request->category,
            'slug' => $slug,
        ]);

        return redirect()->route('category.index')->with('message', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index')->with('message', 'Category Deleted Successfully');
    }



    public function category(Request $request,$id)
    {

        $products_cat = array();
        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();

        $sq = $sb_req = '';
        $sb = 'id;ASC';
        if ($request->search) $sq = $request->search;
        if ($request->sortBy){
            $sb = $request->sortBy;
            $sb_req = explode(';',$sb);
        } else {
            $sb_req = [
                0 => 'id',
                1 => 'ASC'
            ];
        }

        $paginate = 8;
        $product_settings = ProductSettings::where('name','product_per_page')->first();
        if($product_settings) $paginate = $product_settings->value;

        $products = Products::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy($sb_req[0],$sb_req[1])->paginate($paginate);

        $products_all = Products::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $query->orWhere('id', '=', $s)
                        ->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->orderBy($sb_req[0],$sb_req[1])->count();
        $category_name = 'Uncategorized';
        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        if(isset($enable_online_shop->value) && $enable_online_shop->value == "no"){
            abort(404);
        }
        /* if($id != 0){
            $category = Category::find($id);
            $category_name = $category->category;
            foreach($products as $p){
            $products_category = Category_product::where('id_category',$id)
                                                    ->where('id_product',$p->id)
                                                    ->get();
                if(count($products_category) > 0){
                    array_push($products_cat,$p);
                }
            }
        } else {
            foreach($products as $p){
                $products_category = Category_product::where('id_product',$p->id)->get();
                if(count($products_category) <=  0){
                    array_push($products_cat,$p);
                }
            }
        }

        // dd($products_cat);

        $products = $products_cat; */
        if($id == '0'){
            $products = Products::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])
            ->whereNotIn('id', DB::table('category_products')->select('id_product')->get()->pluck('id_product'))
            ->orderBy($sb_req[0],$sb_req[1])->paginate($paginate);

            $products_all =Products::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }]
            ])
                ->whereNotIn('id', DB::table('category_products')->select('id_product')->get()->pluck('id_product'))
                ->orderBy($sb_req[0],$sb_req[1])->count();
        }else{
            $category = Category::where('slug',$id)->first();
            if($category) {
                $category_name = $category->category ?? '';
                $products = Products::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('id', '=', $s)
                                ->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }]
                ])
                    ->whereIn('id', DB::table('category_products')->select('id_product')
                        ->where('id_category', '=', $category->id)->get()->pluck('id_product'))
                    ->orderBy($sb_req[0],$sb_req[1])->paginate($paginate);

                $products_all = Products::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('id', '=', $s)
                                ->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }]
                ])->whereIn('id', DB::table('category_products')->select('id_product')->where('id_category', '=', $category->id)->get()->pluck('id_product'))
                    ->orderBy($sb_req[0],$sb_req[1])->count();
            } else {
                $category_name = '';
                $products = Products::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('id', '=', $s)
                                ->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }]
                ])->whereIn('id', DB::table('category_products')->select('id_product')
                        ->get()->pluck('id_product'))
                    ->orderBy($sb_req[0],$sb_req[1])->paginate($paginate);

                $products_all = Products::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('id', '=', $s)
                                ->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }]
                ])->whereIn('id', DB::table('category_products')->select('id_product')->get()->pluck('id_product'))
                    ->orderBy($sb_req[0],$sb_req[1])->count();
            }

        }


        if ($request->search){
            $sq = $request->search;
            $products->appends(['search' => $sq,'sortBy' => $sb]);
        }
        if ($request->sortBy){
            $products->appends(['sortBy' => $sb]);
        }
        foreach ($products as &$product){
            $product['product_image'] = Product_image::where('products_id',$product['id'])->where(function ($query) {
                $query->where('active_thumbnail', 1)
                    ->orWhereNull('active_thumbnail');
            })->orderByDesc('active_thumbnail')->first();
        }

        $carts = [];
        $session_id = Session::get('session_id');
        if(!empty($session_id)){
            $carts = Cart::where("session_id",$session_id)->get();
        }

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

        $company = Company::latest()->first();

        $shop_name = Setting::where("key","store_name_meta")->first();
        $shop_description = Setting::where("key","store_description_meta")->first();
        $first = 1;
        $last = $paginate;
        if ($request->page > 1) {
            $first = ($paginate * ($request->page - 1)) + 1;
            $last = $paginate * $request->page;
        }
        if ($last > $products_all) $last = $products_all;

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

        $fromapi = Setting::where("key", "product_stock_from_api")->first();
        $online_stock_api = OnlineStockApi::latest()->first();
        foreach ($products as &$product) {
            $product['product_image'] = Product_image::where('products_id', $product['id'])->where(function ($query) {
                $query->where('active_thumbnail', 1)
                    ->orWhereNull('active_thumbnail');
            })->orderByDesc('active_thumbnail')->first();
            if ($fromapi != NULL && $fromapi->value == "yes") {
                $product['product_upc'] = Stock::where('products_id', $product['id'])->first();
                if ($online_stock_api != NULL && isset($product['product_upc']->barcode_value)) {
                    $login = $online_stock_api->username;
                    $password = $online_stock_api->password;
                    $url = $online_stock_api->api_url . $product['product_upc']->barcode_value;
                    $result = Http::withHeaders([
                        'Authorization' => 'Basic ' . base64_encode($login . ':' . $password)
                    ])->post($url);
//                    $ch = curl_init();
//                    curl_setopt($ch, CURLOPT_URL, $url);
//                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//                    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//                    $result = curl_exec($ch);
//                    curl_close($ch);
                    $product['product_api'] = json_decode($result->body());
                }
            } else {
                $product['product_upc'] = null;
                $product['product_api'] = null;
            }
        }

        return view('front/category', compact(['products','company','carts','headerMenuColor','headerMenus','category_name',
            'id','sq','products_all', 'first','last','shop_favicon','enable_online_shop']));
    }
}
