<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Company;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\HomeCarousel;
use App\Models\Product_image;
use App\Models\Products;
use App\Models\ProductSettings;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'attribute_value' => 'required',
            'attribute_id' => 'required'
        ]);

        $slug = self::transform_slug($request->attribute_value);


        AttributeValue::updateOrCreate([
            'attribute_values' => $request->attribute_value,
            'slug' => $slug,
            'attribute_id' => $request->attribute_id
        ]);

        return redirect()->back()->with('success', 'Attribute Value Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute_values = AttributeValue::find($id);

        if($attribute_values == NULL) abort(404);

        $attribute = Attribute::find($attribute_values->attribute_id);

        return view('attribute.edit_attribute_value', compact('attribute','attribute_values'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute_value = AttributeValue::find($id);

        $this->validate($request, [
            'attribute_value' => 'required',
            'attribute_id' => 'required',
        ]);

        $slug = self::transform_slug($request->attribute_value);

        $attribute_value->update([
            'attribute_values' => $request->attribute_value,
            'slug' => $slug,
            'attribute_id' => $request->attribute_id
        ]);

        return redirect()->route('attribute.edit', $request->attribute_id)->with('success', 'Attribute Value Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeValue  $attributeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = AttributeValue::find($id);

        if (!$attribute) {
            return redirect()->back()->with('error', 'Attribute Value Not Found');
        }

        $attribute->delete();

        return redirect()->back()->with('success', 'Attribute Value Deleted Successfully');
    }

    protected function transform_slug($str)
    {
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        return $str;
    }



    public function attribute(Request $request, $main, $sub)
    {
           $id=$sub;
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
        if($sub == '0'){
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
            $mainn = Attribute::where('attribute_slug',$main)->first();
            $subb = AttributeValue::where('slug',$sub)->first();
            $category_name = $subb->attribute_values;
              $products = Products::select('products.*')
            ->join('product_variations as pv', 'products.id', '=', 'pv.products_id')
            ->whereJsonContains('pv.variation_value', ["$mainn->id" => $subb->id])->groupBy('pv.products_id')->paginate($paginate);

            $products_all = Products::select('products.*')
            ->join('product_variations as pv', 'products.id', '=', 'pv.products_id')
            ->whereJsonContains('pv.variation_value', ["$mainn->id" => $subb->id])->groupBy('pv.products_id')
            ->count();
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
        return view('front/category', compact(['products','company','carts','headerMenuColor','headerMenus','category_name',
            'id','sq','products_all', 'first','last','shop_favicon','enable_online_shop']));
    }

}
