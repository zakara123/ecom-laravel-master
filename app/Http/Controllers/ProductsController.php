<?php

namespace App\Http\Controllers;

use App\Exports\ExportItem;
use App\Exports\ExportItemParamsImage;
use App\Imports\ImportItem;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\HomepageCollectionImage;
use App\Models\OnlineStockApi;
use App\Models\PayementMethodSales;
use App\Models\Product_image;
use App\Models\ProductVariation;
use App\Models\ProductPosition;
use App\Models\Products;
use App\Models\ProductSettings;
use App\Models\ProductSKU;
use App\Models\ProductVariationAttribute;
use App\Models\ProductVariationImages;
use App\Models\ProductVariationThumbnail;
use App\Models\ProductVisibility;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Stock_history;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\TemporaryFile;
use App\Services\AttributeService;
use App\Services\CommonService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

//use Session;


class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $ss = $fs = '';
        $sb = 'id';
        $cat = 'all';
        if ($request->s)
            $ss = $request->s;
        if ($request->fs)
            $fs = $request->fs;
        if ($request->category)
            $cat = $request->category;
        if ($request->sortby)
            $sb = $request->sortby;

        $ob = 'DESC';
        if ($request->orderby)
            $ob = trim($request->orderby);

        $sb_tmp = $sb;
        if ($sb != 'position')
            $sb = 'products.' . $sb;
        else
            $sb = 'product_positions.' . $sb;

        self::positionItemDefault();
        self::visibilityItemDefault();

        $products = Products::where([
            ['name', '!=', Null],
            [
                function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('products.id', '=', $s)
                            ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                            ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                            ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }
            ]
        ])
            ->select('products.*', 'product_positions.position')
            ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
            ->orderBy($sb, $ob)->paginate(10);
        $supplier_req = array();
        $category_req = array();
        $stock_req = array();
        $stock_req1 = array();
        if ($request->s) {
            $suppliers = Supplier::where([
                ['name', '!=', Null],
                [
                    function ($query) use ($request) {
                        if (($s = $request->s)) {
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->orWhere(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }
                ]
            ])->orderBy('id', 'DESC')->get();
            foreach ($suppliers as $s) {
                array_push($supplier_req, $s->id);
            }

            $stocks = Stock::where('barcode_value', 'LIKE', '%' . $request->s . '%')->orderBy('products_id', 'DESC')->get();
            $stocks1 = Stock::where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . $request->s . '%')->orderBy('products_id', 'DESC')->get();
            $stock_req = $stocks;
            $stock_req1 = $stocks1;
        }

        if ($cat != 'all' && $cat != '0') {
            $categorys = Category::where('id', $cat)->orderBy('id', 'DESC')->get();
            foreach ($categorys as $c) {
                array_push($category_req, $c->id);
            }
        } else if ($cat == '0') {
            $categorys = Category::orderBy('id', 'DESC')->get();
            foreach ($categorys as $c) {
                array_push($category_req, $c->id);
            }
        }

        if ($request->fs && $request->fs != '') {
            $id_arrays = array();
            if ($request->fs == 'Product with image') {

                $productsimages = Product_image::latest()->get();
                foreach ($productsimages as $pi) {
                    array_push($id_arrays, $pi->products_id);
                }
                $products = Products::whereIn('products.id', array_unique($id_arrays))
                    ->select('products.*', 'product_positions.position')
                    ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                    ->orderBy($sb, $ob)->get();

                if (($s = $request->s)) {
                    $id_arrays_ser = array();
                    $id_arrays_nser = array();
                    $products_se = Products::where([
                        ['name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', 'DESC')->get();

                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }
                    foreach ($products as $p_ns) {
                        array_push($id_arrays_nser, $p_ns->id);
                    }

                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {

                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {

                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }

                    array_unique($id_arrays_ser);
                    $id_arrays_intersect = array_intersect($id_arrays_nser, $id_arrays_ser);
                    $products = Products::whereIn('products.id', array_unique($id_arrays_intersect))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    $products = Products::whereIn('products.id', array_unique($id_arrays))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                }
            } elseif ($request->fs == "Product without image") {
                $productsimages = Product_image::latest()->get();
                foreach ($productsimages as $pi) {
                    array_push($id_arrays, $pi->products_id);
                }
                $products = Products::whereNotIn('products.id', array_unique($id_arrays))
                    ->select('products.*', 'product_positions.position')
                    ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                    ->orderBy($sb, $ob)->get();
                if (($s = $request->s)) {
                    $id_arrays_ser = array();
                    $id_arrays_nser = array();
                    $products_se = Products::where([
                        ['name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', 'DESC')->get();
                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }
                    foreach ($products as $p_ns) {
                        array_push($id_arrays_nser, $p_ns->id);
                    }
                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {
                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {
                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    $id_arrays_intersect = array_intersect($id_arrays_nser, array_unique($id_arrays_ser));
                    $products = Products::whereIn('products.id', array_unique($id_arrays_intersect))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    $products = Products::whereNotIn('products.id', array_unique($id_arrays))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                }
            } else {
                if ($request->s) {
                    $id_arrays_ser = array();
                    $products_se = Products::where([
                        ['name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', 'DESC')->get();
                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }

                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {
                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {
                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    array_unique($id_arrays_ser);
                    $products = Products::whereIn('products.id', array_unique($id_arrays_ser))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    if (!empty($category_req)) {
                        $id_arrays_ser = array();
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            //                            dd($products_cat);
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                }
            }
        }

        foreach ($products as &$product) {
            $categoryproduct = Category_product::where('id_product', $product['id'])->get();
            foreach ($categoryproduct as &$cp) {
                $category = Category::find($cp->id_category);
                $cp['category_name'] = $category->category;
            }
            $product['categoryproduct'] = $categoryproduct;
            $position = '';
            $active = '';
            $productPositions = ProductPosition::where('products_id', $product->id)->first();
            if ($productPositions)
                $position = $productPositions->position;

            $productVisibility = ProductVisibility::where('products_id', $product->id)->first();
            if ($productVisibility)
                $active = $productVisibility->active;
            $product['position'] = $position;
            $product['visibility'] = $active;
            $product->product_image = Product_image::where('products_id', $product->id)->first();

            if ($product->id_supplier) {
                $supplier = Supplier::find($product->id_supplier);
                $product['supplier'] = $supplier->name;
            }
        }
        if ($request->sortBy) {
            $products->appends(['sortby' => $sb]);
        }
        if ($request->category) {
            $products->appends(['category' => $cat]);
        }
        $categories = Category::orderBy('category', 'ASC')->get();
        $productsVisibility = ProductVisibility::orderBy('products_id', 'ASC')->get();
        $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
        $sb = $sb_tmp;
        return view('product.index', compact(['products', 'ss', 'fs', 'sb', 'ob', 'categories', 'product_stock_from_api', 'productsVisibility']));
    }

    public function positionItemDefault()
    {

        $products = Products::orderBy('id', 'DESC')->get();

        foreach ($products as &$product) {
            $productPositions = ProductPosition::where('products_id', $product->id)->first();
            $position = $product->id;
            if ($productPositions)
                $position = $productPositions->position;
            $product['position'] = $position;
            if ($productPositions)
                $productPositions->update(['position' => $position]);
            else {
                ProductPosition::create([
                    'products_id' => $product->id,
                    'position' => $position
                ]);
            }
        }
        //        return redirect()->route('item.index')->with('message', 'Position Item was created for default');
    }

    public function visibilityItemDefault()
    {

        $products = Products::orderBy('id', 'DESC')->get();


        foreach ($products as &$product) {
            $productActive = ProductVisibility::where('products_id', $product->id)->first();
            $active = 'yes';
            if ($productActive)
                $active = $productActive->active;
            $product['active'] = $active;
            if ($productActive)
                $productActive->update(['active' => $active]);
            else {
                ProductVisibility::create([
                    'products_id' => $product->id,
                    'active' => $active
                ]);
            }
        }

        // before Mai 2023
        /*$products_bfm = Products::where('created_at','<', Carbon::create(2023, 05, 01,00,00,00))->orderBy('id', 'DESC')->get();
        foreach ($products_bfm as &$product) {
            $productActive = ProductVisibility::where('products_id', $product->id)->first();
            $active = 'no';
            if ($productActive) $active = 'no';
            $product['active'] = $active;
            if ($productActive)
                $productActive->update(['active' => $active]);
            else {
                ProductVisibility::create([
                    'products_id' => $product->id,
                    'active' => $active
                ]);
            }
        }*/
    }

    public function search(Request $request)
    {
        $ss = $fs = '';
        $sb = 'id';
        $cat = 'all';

        if ($request->s)
            $ss = $request->s;
        if ($request->fs)
            $fs = $request->fs;
        if ($request->category)
            $cat = $request->category;
        if ($request->sortby)
            $sb = $request->sortby;
        $sb_tmp = $sb;
        if ($sb != 'position')
            $sb = 'products.' . $sb;
        else
            $sb = 'product_positions.' . $sb;

        $ob = 'ASC';
        if ($request->orderby)
            $ob = trim($request->orderby);

        $products = Products::where([
            ['products.name', '!=', Null],
            [
                function ($query) use ($request) {
                    if (($s = $request->s)) {
                        $query->orWhere('products.id', '=', $s)
                            ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                            ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                            ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }
            ]
        ])
            ->select('products.*', 'product_positions.position')
            ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
            ->orderBy($sb, $ob)->paginate(10);

        $supplier_req = array();
        $category_req = array();
        $stock_req = array();
        $stock_req1 = array();
        if ($request->s) {
            $suppliers = Supplier::where([
                ['name', '!=', Null],
                [
                    function ($query) use ($request) {
                        if (($s = $request->s)) {
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                                ->orWhere(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                ->get();
                        }
                    }
                ]
            ])->orderBy('id', 'DESC')->get();
            foreach ($suppliers as $s) {
                array_push($supplier_req, $s->id);
            }

            $stocks = Stock::where('barcode_value', 'LIKE', '%' . $request->s . '%')->orderBy('products_id', 'DESC')->get();
            $stocks1 = Stock::where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . $request->s . '%')->orderBy('products_id', 'DESC')->get();
            $stock_req = $stocks;
            $stock_req1 = $stocks1;
        }

        if ($cat != 'all' && $cat != '0') {
            $categorys = Category::where('id', $cat)->orderBy('id', 'DESC')->get();
            foreach ($categorys as $c) {
                array_push($category_req, $c->id);
            }
        } elseif ($request->category == '0') {
            $cat = 0;
            $categorys = Category::orderBy('id', 'DESC')->get();
            foreach ($categorys as $c) {
                array_push($category_req, $c->id);
            }
        }

        if ($request->fs && $request->fs != '') {
            $id_arrays = array();
            if ($request->fs == 'Product with image') {

                $productsimages = Product_image::latest()->get();
                foreach ($productsimages as $pi) {
                    array_push($id_arrays, $pi->products_id);
                }
                $products = Products::whereIn('products.id', array_unique($id_arrays))
                    ->select('products.*', 'product_positions.position')
                    ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                    ->orderBy($sb, 'DESC')->get();

                if (($s = $request->s)) {
                    $id_arrays_ser = array();
                    $id_arrays_nser = array();
                    $products_se = Products::where([
                        ['name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', $ob)->get();

                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }
                    foreach ($products as $p_ns) {
                        array_push($id_arrays_nser, $p_ns->id);
                    }

                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {

                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {

                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }

                    array_unique($id_arrays_ser);
                    $id_arrays_intersect = array_intersect($id_arrays_nser, $id_arrays_ser);
                    $products = Products::whereIn('products.id', array_unique($id_arrays_intersect))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    $products = Products::whereIn('products.id', array_unique($id_arrays))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                }
            } elseif ($request->fs == "Product without image") {
                $productsimages = Product_image::latest()->get();
                foreach ($productsimages as $pi) {
                    array_push($id_arrays, $pi->products_id);
                }
                $products = Products::whereNotIn('products.id', array_unique($id_arrays))
                    ->select('products.*', 'product_positions.position')
                    ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                    ->orderBy($sb, $ob)->get();
                if (($s = $request->s)) {
                    $id_arrays_ser = array();
                    $id_arrays_nser = array();
                    $products_se = Products::where([
                        ['products.name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', 'DESC')->get();
                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }
                    foreach ($products as $p_ns) {
                        array_push($id_arrays_nser, $p_ns->id);
                    }
                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {
                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {
                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {
                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    $id_arrays_intersect = array_intersect($id_arrays_nser, array_unique($id_arrays_ser));
                    $products = Products::whereIn('products.id', array_unique($id_arrays_intersect))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    $products = Products::whereNotIn('products.id', array_unique($id_arrays))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                }
            } else {

                if ($request->s) {
                    $id_arrays_ser = array();
                    $id_arrays_nser = array();
                    $products_se = Products::where([
                        ['name', '!=', Null],
                        [
                            function ($query) use ($request) {
                                if (($s = $request->s)) {
                                    $query->orWhere('products.id', '=', $s)
                                        ->orWhere('products.name', 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.name, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->orWhere(DB::raw('REPLACE(products.description, "-", "" )'), 'LIKE', '%' . $s . '%')
                                        ->get();
                                }
                            }
                        ]
                    ])->orderBy('id', 'DESC')->get();
                    foreach ($products_se as $p_s) {
                        array_push($id_arrays_ser, $p_s->id);
                    }

                    if (!empty($supplier_req)) {
                        $products_sup = Products::whereIn('id_supplier', array_unique($supplier_req))
                            ->orderBy('id', 'DESC')->get();
                        foreach ($products_sup as $p_sup) {
                            array_push($id_arrays_ser, $p_sup->id);
                        }
                    }
                    if (!empty($category_req)) {
                        if ($cat) {

                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        } else {
                            $products_cat = Category_product::whereNotIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                        }
                    }
                    if (!empty($stock_req)) {
                        foreach ($stock_req as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    if (!empty($stock_req1)) {
                        foreach ($stock_req1 as $p_s) {
                            array_push($id_arrays_ser, $p_s->products_id);
                        }
                    }
                    array_unique($id_arrays_ser);
                    $products = Products::whereIn('products.id', array_unique($id_arrays_ser))
                        ->select('products.*', 'product_positions.position')
                        ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                        ->orderBy($sb, $ob)->paginate(10);
                } else {
                    if (!empty($category_req)) {

                        $id_arrays_ser = array();
                        if ($cat) {

                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                            $id_arrays_intersect = array_unique($id_arrays_ser);
                            $products = Products::whereIn('products.id', array_unique($id_arrays_intersect))
                                ->select('products.*', 'product_positions.position')
                                ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                                ->orderBy($sb, $ob)->paginate(10);
                        } else {

                            $products_cat = Category_product::whereIn('id_category', array_unique($category_req))
                                ->orderBy('id', 'DESC')->get();
                            foreach ($products_cat as $p_cat) {
                                array_push($id_arrays_ser, $p_cat->id_product);
                            }
                            $id_arrays_intersect = array_unique($id_arrays_ser);
                            $products = Products::whereNotIn('products.id', array_unique($id_arrays_intersect))
                                ->select('products.*', 'product_positions.position')
                                ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
                                ->orderBy($sb, $ob)->paginate(10);
                        }
                    }
                }
            }
        }

        foreach ($products as &$product) {
            $categoryproduct = Category_product::where('id_product', $product['id'])->get();
            foreach ($categoryproduct as &$cp) {
                $category = Category::find($cp->id_category);
                $cp['category_name'] = $category->category;
            }
            $product['categoryproduct'] = $categoryproduct;

            $position = '';
            $productPositions = ProductPosition::where('products_id', $product->id)->first();
            if ($productPositions)
                $position = $productPositions->position;
            $product['position'] = $position;

            $active = '';
            $productVisibility = ProductVisibility::where('products_id', $product->id)->first();
            if ($productVisibility)
                $active = $productVisibility->active;
            $product['visibility'] = $active;

            $product->product_image = Product_image::where('products_id', $product->id)->first();

            if ($product->id_supplier) {
                $supplier = Supplier::find($product->id_supplier);
                $product['supplier'] = $supplier->name;
            }
        }
        if ($request->sortBy || $sb_tmp) {
            $products->appends(['sortby' => $sb_tmp]);
        }
        if ($request->orderby) {
            $products->appends(['orderby' => $ob]);
        }
        if ($request->category) {
            $products->appends(['category' => $cat]);
        }
        $sb = $sb_tmp;
        $productsVisibility = ProductVisibility::orderBy('products_id', 'ASC')->get();
        return view('product.search_ajax', compact(['products', 'ss', 'productsVisibility', 'fs', 'sb', 'ob']));
    }



    private function getReadableVariationValue($variationAttributes)
    {
        return $variationAttributes->map(fn($value, $attribute) => "$attribute: $value")
            ->join(', ');
    }


    private function getShopFavicon()
    {
        $shopFavicon = Setting::where('key', 'store_favicon')->first();
        if (!$shopFavicon) {
            $shopFavicon = Company::latest()->value('logo') ?? url('files/logo/ecom-logo.png');
        }
        return $shopFavicon;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $supplier = Supplier::get();
        $productsVisibility = ProductVisibility::orderBy('products_id', 'ASC')->get();
        $vatrate = Setting::where("key", "vatrate")->first();
        $vat_rate_setting = [];

        if (isset($vatrate->value) && $vatrate->value) {
            $vat_rate_explode = explode(",", $vatrate->value);
            foreach ($vat_rate_explode as $k => $vtv) {
                $value_vtv = $vtv;
                if (!str_contains($value_vtv, '%')) $value_vtv .= '%';
                if (!str_contains($value_vtv, 'VAT')) $value_vtv .= ' VAT';
                if (!empty(trim($vtv)) && trim($vtv) !== null) array_push($vat_rate_setting, trim($value_vtv));
            }
        }
        return view('product.create', compact('categories', 'productsVisibility', 'supplier', 'vat_rate_setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $slug = self::transform_slug($request->input('name'));
        $product = Products::updateOrCreate([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'price_buying' => $request->input('price_buying'),
            'unit' => $request->input('unit'),
            'vat' => $request->input('vat'),
            'slug' => $slug,
            'description' => $request->input('description')
        ]);

        $position = $product->id;
        if ($request->has('position') == true && $request->position) {
            $position = $request->position;
        }
        ProductPosition::create([
            'products_id' => $product->id,
            'position' => $position
        ]);
        // $product->save();

        $active = "yes";
        if ($request->has('visibility') == true && $request->visibility) {
            $active = $request->visibility;
        }
        ProductVisibility::create([
            'products_id' => $product->id,
            'active' => $active
        ]);

        return response()->json('The item successfully added');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return false|string
     */
    public function store(Request $request)
    {

        // dd($request);

        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric|gt:0', // Ensure price is greater than 0
            'rental_price' => 'nullable|numeric', // Allow rental_price to be nullable
        ], [
            'price.gt' => 'The price must be greater than 0.', // Change 'min' to 'gt'
        ]);

        // Check for the rental product condition
        if ($request->is_rental_product == 1 && $request->rental_price <= 0) {
            return redirect()->back()->with('message', 'Rental price must be greater than 0.');
        }

        if (request()->has('is_variable_product') === false) {
            $request->request->add(['is_variable_product' => 'no']);
        } else
            $request->request->add(['is_variable_product' => 'yes']);

        if (request()->has('is_rental_product') === false) {
            $request->request->add(['is_rental_product' => 'no']);
        } else {
            $request->request->add(['is_rental_product' => 'yes']);

            $this->validate($request, [
                'rental_price' => 'required',
            ]);
        }

        // Format price fields to 2 decimal places before saving
        $price = number_format((float)$request->price, 2, '.', '');
        $price_buying = number_format((float)$request->price_buying, 2, '.', '');
        $rental_price = number_format((float)$request->rental_price, 2, '.', '');

        $slug = self::transform_slug($request->input('name'));
        $supplier = NULL;
        if (!empty($request->supplier))
            $supplier = $request->supplier;

        // Save or update the product
        $product = Products::updateOrCreate([
            'name' => $request->name,
            'is_variable_product' => $request->is_variable_product,
            'price' => $price,
            'price_buying' => $price_buying,
            'is_rental_product' => $request->is_rental_product,
            'unit_selling_label' => $request->unit_selling_label,
            'unit_rental_label' => $request->unit_rental_label,
            'rental_price' => $rental_price,
            'vat' => $request->vat,
            'id_supplier' => $supplier,
            'slug' => $slug,
            'display_online' => $request->display_online,
            'description' => $request->description,
        ]);

        $product->save();

        $id_product = $product->id;
        $store = Store::where('is_default', 'yes')->first();
        $position = $product->id;
        if ($request->has('position') == true && $request->position) {
            $position = $request->position;
        }
        ProductPosition::create([
            'products_id' => $id_product,
            'position' => $position
        ]);

        $active = "yes";
        if ($request->has('visibility') == true && $request->visibility) {
            $active = $request->visibility;
        }
        ProductVisibility::create([
            'products_id' => $product->id,
            'active' => $active
        ]);

        ///add store
        // $stock = Stock::updateOrCreate([
        //     'products_id' => $id_product,
        //     'store_id' => $store->id,
        //     'product_variation_id' => NULL,
        //     'quantity_stock' => 0,
        //     'date_received' => date('Y-m-d'),
        //     'barcode_value' => $id_product
        // ]);

        ///add stock history
        // if ($stock->id) {
            //// add stock history
            // $stock_history = Stock_history::updateOrCreate([
            //     'stock_id' => $stock->id,
            //     'type_history' => "Update Stock",
            //     'quantity' => 0,
            //     'quantity_previous' => 0,
            //     'quantity_current' => 0,
            //     'sales_id' => NULL
            // ]);
        // }

        if ($request->has('category') && !empty($request->category)) {
            if (is_array($request->category)) {
                foreach ($request->category as $cat) {
                    Category_product::updateOrCreate([
                        'id_product' => $product->id,
                        'id_category' => $cat,
                    ]);
                }
            }
        }

        if (!empty($request->item_image)) {
            $productImages = explode(',', $request->item_image);

            foreach ($productImages as $prodImg) {
                $prodImgD = \App\Models\File::findOrFail($prodImg);
                $productImage = Product_image::create([
                    'products_id' => $id_product,
                    'file_id' => $prodImgD->id,
                    'name_product' => $prodImgD->title,
                    'src' => $prodImgD->url
                ]);
            }
        }

        $url = ['reload' => route('item.edit', $product->id)];
        die(json_encode($url));
        return redirect()->route('item.edit', $product->id)->with('message', 'Item Created Successfully');
    }


    public function store_old_delete(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric|gt:0', // Ensure price is greater than 0
            'rental_price' => 'nullable|numeric', // Allow rental_price to be nullable
        ], [
            'price.gt' => 'The price must be greater than 0.', // Change 'min' to 'gt'
        ]);

        // Check for the rental product condition
        if ($request->is_rental_product == 1 && $request->rental_price <= 0) {
            return redirect()->back()->with('message', 'Rental price must be greater than 0.');
        }

        if (request()->has('is_variable_product') === false) {
            $request->request->add(['is_variable_product' => 'no']);
        } else
            $request->request->add(['is_variable_product' => 'yes']);

        if (request()->has('is_rental_product') === false) {
            $request->request->add(['is_rental_product' => 'no']);
        } else {
            $request->request->add(['is_rental_product' => 'yes']);

            $this->validate($request, [
                'rental_price' => 'required',
            ]);
        }

        // Format price fields to 2 decimal places before saving
        $price = number_format((float)$request->price, 2, '.', '');
        $price_buying = number_format((float)$request->price_buying, 2, '.', '');
        $rental_price = number_format((float)$request->rental_price, 2, '.', '');

        $slug = self::transform_slug($request->input('name'));
        $supplier = NULL;
        if (!empty($request->supplier))
            $supplier = $request->supplier;

        // Save or update the product
        $product = Products::updateOrCreate([
            'name' => $request->name,
            'is_variable_product' => $request->is_variable_product,
            'price' => $price,
            'price_buying' => $price_buying,
            'is_rental_product' => $request->is_rental_product,
            'unit_selling_label' => $request->unit_selling_label,
            'unit_rental_label' => $request->unit_rental_label,
            'rental_price' => $rental_price,
            'vat' => $request->vat,
            'id_supplier' => $supplier,
            'slug' => $slug,
            'display_online' => $request->display_online,
            'description' => $request->description,
        ]);

        $product->save();

        $id_product = $product->id;
        $store = Store::where('is_default', 'yes')->first();
        $position = $product->id;
        if ($request->has('position') == true && $request->position) {
            $position = $request->position;
        }
        ProductPosition::create([
            'products_id' => $id_product,
            'position' => $position
        ]);

        $active = "yes";
        if ($request->has('visibility') == true && $request->visibility) {
            $active = $request->visibility;
        }
        ProductVisibility::create([
            'products_id' => $product->id,
            'active' => $active
        ]);

        ///add store
        $stock = Stock::updateOrCreate([
            'products_id' => $id_product,
            'store_id' => $store->id,
            'product_variation_id' => NULL,
            'quantity_stock' => 0,
            'date_received' => date('Y-m-d'),
            'barcode_value' => $id_product
        ]);

        ///add stock history
        if ($stock->id) {
            //// add stock history
            $stock_history = Stock_history::updateOrCreate([
                'stock_id' => $stock->id,
                'type_history' => "Update Stock",
                'quantity' => 0,
                'quantity_previous' => 0,
                'quantity_current' => 0,
                'sales_id' => NULL
            ]);
        }

        if ($request->has('category') && !empty($request->category)) {
            if (is_array($request->category)) {
                foreach ($request->category as $cat) {
                    Category_product::updateOrCreate([
                        'id_product' => $product->id,
                        'id_category' => $cat,
                    ]);
                }
            }
        }

        $path = public_path('/files/product');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->has('item_image')) {
            $id_product = $product->id;
            $no = 1;
            foreach ($request->file('item_image') as $image) {
                $randomId = rand(2, 50);
                $imageName = $randomId . $slug . '-image-product' . '.' . $image->extension();
                $image->move(public_path('files/product'), $imageName);
                $src = '/files/product' . '/' . $imageName;
                $is_iamges_products = Product_image::where('src', '=', $src)->orderBy('id', 'DESC')->first();
                if (!$is_iamges_products) {
                    $productImage = new Product_image([
                        'products_id' => $id_product,
                        'name_product' => "Image-" . $no,
                        'src' => $src
                    ]);
                    $productImage->save();
                }
                $no++;
            }
        }


        $url = ['reload' => route('item.edit', $product->id)];
        die(json_encode($url));
        return redirect()->route('item.edit', $product->id)->with('message', 'Item Created Successfully');
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
        if ($exists)
            return $str . "-1";
        return $str;
    }

    protected function transform_slug_update($str)
    {
        //Products::whereSlug($str)->where('id',$id)
        $str = preg_replace('~[^\pL\d]+~u', '-', $str);
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
        $str = preg_replace('~[^-\w]+~', '', $str);
        $str = trim($str, '-');
        $str = preg_replace('~-+~', '-', $str);
        $str = strtolower($str);
        $exists = Products::whereSlug($str)->where('id', $id)->exists();
        return $str;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Products $product
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Products $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);

        $position = '';
        $productPositions = ProductPosition::where('products_id', $product->id)->first();
        if ($productPositions)
            $position = $productPositions->position;
        $product->position = $position;
        $active = 'yes';
        $productVisibility = ProductVisibility::where('products_id', $product->id)->first();
        if ($productVisibility)
            $active = $productVisibility->active;
        $product->visibility = $active;

        $images = $product->images;
        $productCategory = Category_product::where('id_product', $id)->get();
        $categories = Category::orderBy('id', 'desc')->get();

        $supplier = Supplier::get();

        $vatrate = Setting::where("key", "vatrate")->first();
        $vat_rate_setting = [];

        if (isset($vatrate->value) && $vatrate->value) {
            $vat_rate_explode = explode(",", $vatrate->value);
            foreach ($vat_rate_explode as $k => $vtv) {
                $value_vtv = $vtv;
                if (!str_contains($value_vtv, '%')) $value_vtv .= '%';
                if (!str_contains($value_vtv, 'VAT')) $value_vtv .= ' VAT';
                if (!empty(trim($vtv)) && trim($vtv) !== null) array_push($vat_rate_setting, trim($value_vtv));
            }
        }

        return view('product.edit', compact('product', 'images', 'categories', 'productCategory', 'supplier', 'vat_rate_setting'));
    }

    public function stock($id_product)
    {
        $products = Products::find($id_product);
        $fromapi = Setting::where("key", "product_stock_from_api")->first();
        $stock_api = [];
        $stock_api_final = [];
        $have_size = "no";
        if ($fromapi != NULL && $fromapi->value == "yes") {
            $stock_line = Stock::where('products_id', $products->id)->get();
            $online_stock_api = OnlineStockApi::latest()->first();
            if ($online_stock_api != NULL) {
                foreach ($stock_line as $stock) {
                    $login = $online_stock_api->username;
                    $password = $online_stock_api->password;
                    $url = $online_stock_api->api_url . $stock->barcode_value;

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
                    //                    $stock_api_loc = json_decode($result);
                    $stock_api_loc = json_decode($result->body());
                    $stock_api = array_merge($stock_api, [$stock_api_loc]);
                }
            }
            foreach ($stock_api as $stock_ap) {
                if (isset($stock_ap->stock)) {
                    foreach ($stock_ap->stock as $stock) {
                        $arr = [
                            "location" => $stock->location,
                            "upc" => $stock_ap->upc,
                            "size" => "",
                            "color" => "",
                            "qty" => $stock->qty,
                        ];
                        if (isset($stock_ap->size) && is_string($stock_ap->size) && $stock_ap->size != "") {
                            $arr["size"] = $stock_ap->size;
                            $have_size = "yes";
                        }
                        if (isset($stock_ap->group5) && is_string($stock_ap->group5)) {
                            $arr["color"] = $stock_ap->group5;
                        }
                        if ($arr["location"] != "Defunct" && $arr["location"] != "Supplier Defect")
                            $stock_api_final = array_merge($stock_api_final, [$arr]);
                    }
                }
            }
            usort($stock_api_final, fn($a, $b) => strcmp($a['location'], $b['location']));
        }

        /// stock

        $stocks = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.products_id')
            ->join('stores', 'stores.id', '=', 'stocks.store_id')
            ->leftJoin('product_variations', 'product_variations.id', '=', 'stocks.product_variation_id')
            ->select('stocks.*', 'products.name', 'products.price', 'stores.name', 'product_variations.variation_value')
            ->where("stocks.products_id", $id_product)
            ->get();

        foreach ($stocks as $key => $stock) {
            $stock = (array) $stock;
            $variation_value = json_decode($stock['variation_value']);

            $stock['variation_value'] = "";
            if ($variation_value != NULL) {
                foreach ($variation_value as $v) {
                    foreach ($v as $k => $a) {
                        $attr = Attribute::find($k);
                        $attr_val = AttributeValue::find($a);
                        //if($attr_val!= NULL && $attr!=NULL) $stock['variation_value'] = array_merge($stock['variation_value'], [["attribute" => $attr->attribute_name, "attribute_value" => $attr_val->attribute_values]]);
                        if ($attr_val != NULL && $attr != NULL) {
                            if (empty($stock['variation_value']))
                                $stock['variation_value'] = $attr->attribute_name . " : " . $attr_val->attribute_values;
                            else
                                $stock['variation_value'] = $stock['variation_value'] . ', ' . $attr->attribute_name . " : " . $attr_val->attribute_values;
                        }
                    }
                }
            }

            $stock = (object) $stock;
            $stocks[$key] = $stock;
        }

        $image_cover = Product_image::where('products_id', $products['id'])->first();

        if (empty($image_cover))
            $image_cover = "";
        else
            $image_cover = $image_cover->src;

        $preview = "";
        $next = "";
        $products_next = Products::where('id', '>', $products->id)->orderBy('id', 'ASC')->first();
        $products_prev = Products::where('id', '<', $products->id)->orderBy('id', 'DESC')->first();
        if (!is_null($products_next))
            $next = $products_next->id;
        if (!is_null($products_prev))
            $preview = $products_prev->id;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "products" => $products,
            "api" => $stock_api_final,
            "stocks" => $stocks,
            "image_cover" => $image_cover,
            "preview" => $preview,
            "next" => $next,
            "error" => false
        ]);
        die;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Products $product
     * @return false|string
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric|gt:0', // Ensure price is greater than 0
            'rental_price' => 'nullable|numeric', // Allow rental_price to be nullable
        ], [
            'price.gt' => 'The price must be greater than 0.', // Change 'min' to 'gt'
        ]);

        // Check for the rental product condition
        if (isset($request->is_rental_product) && $request->is_rental_product == 1 && $request->rental_price == 0) {
            return json_encode(['message' => 'Rental price must be greater than 0.']);
        }

        //$slug = self::transform_slug_update($request->name, $id);

        if (request()->has('is_variable_product') === false) {
            $request->request->add(['is_variable_product' => 'no']);
        } else
            $request->request->add(['is_variable_product' => 'yes']);

        if (request()->has('is_rental_product') === false) {
            $request->request->add(['is_rental_product' => 'no']);
        } else
            $request->request->add(['is_rental_product' => 'yes']);

        $product = Products::find($id);
        $supplier = NULL;
        if (!empty($request->supplier)) {
            $supplier = $request->supplier;
        }

        // Format price fields to 2 decimal places before saving
        $price = number_format((float)$request->price, 2, '.', '');
        $price_buying = number_format((float)$request->price_buying, 2, '.', '');
        $rental_price = number_format((float)$request->rental_price, 2, '.', '');

        $product->update([
            'name' => $request->name,
            'is_variable_product' => $request->is_variable_product,
            'price' => $price,
            'price_buying' => $price_buying,
            'is_rental_product' => $request->is_rental_product,
            'unit_selling_label' => $request->unit_selling_label,
            'unit_rental_label' => $request->unit_rental_label,
            'rental_price' => $rental_price,
            'vat' => $request->vat,
            'id_supplier' => $supplier,
            'display_online' => $request->display_online,
            'description' => $request->description
        ]);

        if ($request->has('category') && !empty($request->category)) {
            if (is_array($request->category)) {
                Category_product::where('id_product', $id)->delete();
                foreach ($request->category as $cat) {
                    Category_product::updateOrCreate([
                        'id_product' => $id,
                        'id_category' => $cat,
                    ]);
                }
            }
        }

        if (!empty($request->item_image)) {
            $productImages = explode(',', $request->item_image);

            foreach ($productImages as $prodImg) {
                $prodImgD = \App\Models\File::findOrFail($prodImg);
                $productImage = Product_image::create([
                    'products_id' => $id,
                    'file_id' => $prodImgD->id,
                    'name_product' => $prodImgD->title,
                    'src' => $prodImgD->url
                ]);
            }
        }

        // thumbnail update
        if (empty($request->file('item_image'))) {
            if ($request["old_active_thumbnail"] != null || $request["active_thumbnail"] != null) {
                if ($request["old_active_thumbnail"]) {
                    $old_thumbnail = Product_image::find($request["old_active_thumbnail"]);
                    $old_thumbnail->update(['active_thumbnail' => null]);
                }
                $new_thumbnail = Product_image::find($request["active_thumbnail"]);
                $new_thumbnail->update(['active_thumbnail' => 1]);
            }
        }

        if ($request->has('position') === true && $request->position) {
            $productposition = ProductPosition::where('products_id', $id)->first();
            $position = $id;
            if ($request->position)
                $position = $request->position;
            if ($productposition) {
                $current_position = $productposition->position;
                $productposition_old = ProductPosition::where('position', $position)->first();
                if ($productposition_old) {
                    $productposition_old->update(['position' => $current_position]);
                }
                $productposition->update(['position' => $position]);
            } else {
                ProductPosition::create([
                    'products_id' => $id,
                    'position' => $position
                ]);
            }
        }

        if ($request->has('visibility') === true && $request->visibility) {

            $productactive = ProductVisibility::where('products_id', $id)->first();
            $active = "yes";
            if ($request->visibility)
                $active = $request->visibility;
            if ($productactive) {
                $productactive->update(['active' => $active]);
            } else {
                ProductVisibility::create([
                    'products_id' => $id,
                    'active' => $active
                ]);
            }
        }
        $url = ['reload' => route('item.edit', $id)];
        die(json_encode($url));
        return redirect()->route('item.edit', $id)->with('message', 'Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Products $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();
        Product_image::where("products_id", $id)->delete();
        Stock::where("products_id", $id)->delete();
        ProductPosition::where("products_id", $id)->delete();
        ProductVisibility::where("products_id", $id)->delete();
        ProductVariation::where("products_id", $id)->each(function ($variation) {
            // Delete all related imagesVariation
            $variation->imagesVariation()->delete();

            // Delete the related variationThumbnail
            $variation->variationThumbnail()->delete();

            // Delete the ProductVariation itself
            $variation->delete();
        });
        return redirect()->route('item.index')->with('message', 'Item Deleted Successfully');
    }

    public function delete_all()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Stock::truncate();
        Category_product::truncate();
        ProductSKU::truncate();
        Products::truncate();
        ProductVariation::truncate();
        ProductVisibility::truncate();
        ProductPosition::truncate();
        Attribute::truncate();
        AttributeValue::truncate();
        Category::truncate();
        Category_product::truncate();
        Product_image::truncate();
        ProductVariationAttribute::truncate();
        DB::table('product_attributes')->truncate();
        ProductVariationImages::truncate();
        ProductVariationThumbnail::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->route('item.index')->with('message', 'Item Table empty successfully Successfully');
    }

    public function importItemView(Request $request)
    {
        return view('product.importItemFile');
    }

    /**
     * This function returns the maximum files size that can be uploaded
     * in PHP
     * @returns int File size in bytes
     **/
    function getMaximumFileUploadSize()
    {
        return min(self::convertPHPSizeToBytes(ini_get('post_max_size')), self::convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
     *
     * @param string $sSize
     * @return integer The value in bytes
     */
    function convertPHPSizeToBytes($sSize)
    {
        //
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int) $sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
                // Fallthrough intended
            case 'T':
                $iValue *= 1024;
                // Fallthrough intended
            case 'G':
                $iValue *= 1024;
                // Fallthrough intended
            case 'M':
                $iValue *= 1024;
                // Fallthrough intended
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int) $iValue;
    }

    /**
     * This function returns the maximum files size that can be uploaded
     * in PHP
     * @returns int File size in bytes
     **/
    function getMaxFileUploads()
    {
        return ini_get('max_file_uploads');
    }

    public function importItemImageView(Request $request)
    {

        if (isset($request->success) && $request->success) {
            return redirect()->route('import-item-image-view')->with('message', 'Item Image imported Successfully');
        }
        $maxfileUploads = self::getMaxFileUploads();
        $maxfileUploadsSize = self::getMaximumFileUploadSize();

        return view('product.importItemImage', compact(['maxfileUploads', 'maxfileUploadsSize']));
    }

    public function importItem(Request $request)
    {
        Excel::import(new ImportItem, $request->file('file'));
        // return redirect()->back();
        return redirect()->route('item.index')->with('message', 'Item imported Successfully');
    }

    public function importItemImage(Request $request)
    {

        if ($request->has('item_image') && !empty($request->file('item_image'))) {
            $nb_file = count($request->file('item_image'));

            if ($nb_file > 1) {

                foreach ($request->file('item_image') as $image) {
                    $image_name = explode('.', $image->getClientOriginalName());
                }

                $path = public_path('/files/product');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                foreach ($request->file('item_image') as $image) {
                    $image_name = explode('.', $image->getClientOriginalName());
                    $slug = self::transform_slug($image_name[0]);
                    $imageName = $slug . '-image-product.' . $image->extension();
                    $src = '/files/product' . '/' . str_replace(')', '_', str_replace('(', '_', $imageName));
                    $name_product = $image_name[0];

                    if (str_contains($name_product, ')') && str_contains($name_product, ')')) {
                        $name_product = substr($name_product, 0, -3);
                    } elseif (str_contains($name_product, '-')) {
                        $name_prod = explode('-', $name_product);
                        if (strlen($name_prod[count($name_prod) - 1]) == 1) {
                            $name_product = substr($name_product, 0, -2);
                        }
                    }

                    $stock = DB::table('stocks')
                        ->where('barcode_value', 'LIKE', '%' . $name_product . '%')
                        ->orWhere(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . trim($name_product) . '%')
                        ->orderBy('id', 'desc')->first();

                    $products = Products::where('name', 'LIKE', '%' . $name_product . '%')
                        ->orderBy('id', 'desc')->first();

                    if ($stock || $products) {
                        if ($stock) {
                            $image->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                            $id_product = $stock->products_id;
                            $product = Products::find($stock->products_id);
                            $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                            if (!$product_images) {
                                $productImage = new Product_image([
                                    'products_id' => $id_product,
                                    'name_product' => $product->name,
                                    'src' => $src
                                ]);
                                $productImage->save();
                            }
                        } else {
                            $image->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                            $id_product = $products->id;
                            $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                            if (!$product_images) {
                                $productImage = new Product_image([
                                    'products_id' => $id_product,
                                    'name_product' => $products->name,
                                    'src' => $src
                                ]);
                                $productImage->save();
                            }
                        }
                    } else {
                        $stock = DB::table('stocks')
                            ->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . trim($name_product) . '%')
                            ->orderBy('id', 'desc')->first();
                        if ($stock) {

                            $image->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                            $id_product = $stock->products_id;
                            $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                            if (!$product_images) {
                                $product = Products::find($stock->products_id);
                                $productImage = new Product_image([
                                    'products_id' => $id_product,
                                    'name_product' => $product->name,
                                    'src' => $src
                                ]);
                                $productImage->save();
                            }
                        }
                    }

                    $attributes = DB::table('attribute_values')
                        ->where('attribute_values', 'LIKE', '%' . $name_product . '%')
                        ->orderBy('id', 'desc')->first();
                    if ($attributes) {
                        $id_attribue = $attributes->attribute_id;
                        $id_attribute_value = $attributes->id;
                        $variations = DB::table('product_variations')->select('products_id', 'variation_value')
                            ->get();

                        if (count($variations) > 0) {
                            foreach ($variations as $key1 => $variation) {
                                $variation = (array) $variation;
                                $variation_value = json_decode($variation['variation_value']);
                                if ($variation_value != NULL) {
                                    foreach ($variation_value as $v) {
                                        foreach ($v as $k => $a) {
                                            $attr = Attribute::find($k);
                                            $attr_val = AttributeValue::find($a);

                                            if (!empty($attr->id) && !empty($attr_val->id)) {
                                                if ($id_attribue == $attr->id && $attr_val->id == $id_attribute_value) {
                                                    $image->move(public_path('files/product_variation'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                                                    $id_product = $variation['products_id'];
                                                    $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                                                    if (!$product_images) {
                                                        $product = Products::find($variation['products_id']);
                                                        $productImage = new Product_image([
                                                            'products_id' => $id_product,
                                                            'name_product' => $product->name,
                                                            'src' => $src
                                                        ]);
                                                        $productImage->save();
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $image = $request->file('item_image');
                $image_name = explode('.', $image[0]->getClientOriginalName());
                $name_product = $image_name[0];
                if (str_contains($name_product, ')') && str_contains($name_product, ')')) {
                    $name_product = substr($name_product, 0, -3);
                } elseif (str_contains($name_product, '-')) {
                    $name_prod = explode('-', $name_product);
                    if (strlen($name_prod[count($name_prod) - 1]) == 1) {
                        $name_product = substr($name_product, 0, -2);
                    }
                }

                $stock = DB::table('stocks')
                    // ->where('barcode_value', trim($image_name[0]))
                    ->where('barcode_value', 'LIKE', '%' . $name_product . '%')
                    ->orWhere(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . trim($name_product) . '%')
                    ->orderBy('id', 'desc')->first();

                $slug = self::transform_slug(trim(str_replace(')', '_', str_replace('(', '_', $image_name[0]))));
                $imageName = $slug . '-image-product.' . $image[0]->extension();
                $src = '/files/product' . '/' . str_replace(')', '_', str_replace('(', '_', $imageName));


                if ($stock) {
                    $id_product = $stock->products_id;
                    $product = Products::find($id_product);
                    $path = public_path('/files/product');

                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $image[0]->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                    $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                    if (!$product_images) {
                        $productImage = new Product_image([
                            'products_id' => $id_product,
                            'name_product' => $product->name,
                            'src' => $src
                        ]);
                        $productImage->save();
                    }
                } else {
                    $stock = DB::table('stocks')
                        ->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . trim($name_product) . '%')
                        ->orderBy('id', 'desc')->first();
                    if ($stock) {

                        $image->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));
                        $id_product = $stock->products_id;
                        $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                        if (!$product_images) {
                            $product = Products::find($stock->products_id);
                            $productImage = new Product_image([
                                'products_id' => $id_product,
                                'name_product' => $product->name,
                                'src' => $src
                            ]);
                            $productImage->save();
                        }
                    }
                }
                $products = Products::where('name', 'LIKE', '%' . trim($name_product) . '%')
                    ->orderBy('id', 'desc')->first();
                if ($products) {
                    $image[0]->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));

                    $id_product = $products->id;
                    $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                    if (!$product_images) {
                        $productImage = new Product_image([
                            'products_id' => $id_product,
                            'name_product' => $products->name,
                            'src' => $src
                        ]);
                        $productImage->save();
                    }
                }
                $attributes = DB::table('attribute_values')
                    ->where('attribute_values', 'LIKE', '%' . $name_product . '%')
                    ->orderBy('id', 'desc')->first();

                if ($attributes) {
                    $id_attribue = $attributes->attribute_id;
                    $id_attribute_value = $attributes->id;
                    $variations = DB::table('product_variations')->select('products_id', 'variation_value')
                        ->get();

                    if (count($variations) > 0) {
                        foreach ($variations as $key1 => $variation) {
                            $variation = (array) $variation;
                            $variation_value = json_decode($variation['variation_value']);
                            if ($variation_value != NULL) {
                                foreach ($variation_value as $v) {
                                    foreach ($v as $k => $a) {
                                        $attr = Attribute::find($k);
                                        $attr_val = AttributeValue::find($a);

                                        if (!empty($attr->id) && !empty($attr_val->id)) {
                                            if ($id_attribue == $attr->id && $attr_val->id == $id_attribute_value) {
                                                $image[0]->move(public_path('files/product'), str_replace(')', '_', str_replace('(', '_', $imageName)));

                                                $id_product = $variation['products_id'];
                                                $product_images = Product_image::where('src', "=", $src)->orderBy("id", "desc")->first();
                                                if (!$product_images) {
                                                    $product = Products::find($variation['products_id']);
                                                    $productImage = new Product_image([
                                                        'products_id' => $id_product,
                                                        'name_product' => $product->name,
                                                        'src' => $src
                                                    ]);
                                                    $productImage->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $url = ['reload' => route('import-item-image-view')];
        die(json_encode($url));
        return redirect()->route('item.index')->with('message', 'Item imported Successfully');
    }

    public function exportItems(Request $request)
    {
        return Excel::download(new ExportItem, 'product' . date('Y-m-d-h-i-s') . '.xlsx');
    }

    public function exportItemsParamsImage(Request $request)
    {
        $has_image = 0;
        if ($request->filter_image == "Product with image")
            $has_image = 1;
        if ($request->filter_image == "Product without image")
            $has_image = 2;
        return Excel::download(new ExportItemParamsImage($has_image), 'product' . date('Y-m-d-h-i-s') . '.xlsx');
    }

    public function itemsImage($id)
    {
        $product = Products::find($id);

        if (!$product)
            abort(404);

        $images = $product->images;
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        return view('product.image', compact('shop_favicon', 'product', 'images'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Products $product
     *
     */
    public function itemUploadImage(Request $request)
    {
        if ($request->hasFile('item_image')) {
            $file = $request->file('item_image');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('product/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename
            ]);
            return $folder;
        }

        return '';
    }



    public function is_out_of_stock_onlineshop($id_product)
    {
        $products = Products::find((int) $id_product);
        $stock_war = '';
        $stock_war_tmp = 0;
        $has_stock = false;
        $stock_line = ProductSKU::where('products_id', $products->id)->get('stock_warehouse');
        foreach ($stock_line as $s) {
            if (!empty($s->stock_warehouse)) {
                $stock_war_tmp += $s->stock_warehouse;
                $has_stock = true;
            }
        }
        if ($has_stock)
            $stock_war = $stock_war_tmp;
        return $stock_war;
    }

    public function updateVariableStatus(Request $request, $id)
    {
        $response = ['message' => 'No variation for this product. Create before activating this option.'];
        $status = 400;

        $productVariations = ProductVariation::where('products_id', $id)->count();
        if (!empty($productVariations) && $productVariations > 0) {
            $request->validate([
                'is_variable_product' => 'required|in:yes,no',
            ]);

            $product = Products::findOrFail($id);
            $product->is_variable_product = $request->input('is_variable_product');
            $product->save();

            $response = ['message' => 'Product updated successfully.'];
            $status = 200;
        }
        return response()->json($response, $status);
    }



    public function updateImage($id)
    {
        $image = Product_image::findOrFail($id);
        $image->touch(); // Updates the `updated_at` column
        return response()->json(['success' => true, 'message' => 'Image updated successfully!']);
    }
}
