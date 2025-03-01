<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Category_product;
use App\Models\Company;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\HomeCarousel;
use App\Models\HomepageCollectionImage;
use App\Models\OnlineStockApi;
use App\Models\Product_image;
use App\Models\Products;
use App\Models\ProductSettings;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use App\Models\Setting;
use App\Models\Stock;
use App\Services\CommonService;
use App\Services\ProductService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $sq = $request->search ?? '';
        $sb = $request->sortBy ?? 'id;ASC';
        $paginate = ProductSettings::where('name', 'product_per_page')->value('value') ?? 8;
        $filter_by = '';
        list($sortField, $sortOrder) = explode(';', $sb);
        $sortOrder = $sortOrder ?: 'ASC';

        $query = Products::query();
        $query->where('display_online', '=', 1);

        if ($sq) {
            $query->where(function ($subQuery) use ($sq) {
                $subQuery->where('id', $sq)
                    ->orWhere('name', 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", "")'), 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", " ")'), 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(description, "-", "")'), 'LIKE', "%{$sq}%");
            });
        }

        if ($sortField === 'price') {
            $filter_by = "Price low to high";
        } elseif ($sortField === 'name' && $sortOrder === 'ASC') {
            $filter_by = "Name Ascending";
        } elseif ($sortField === 'name' && $sortOrder === 'DESC') {
            $filter_by = "Name Descending";
        } elseif ($sortField === 'filter_sort') {
            $filter_sort = true;
            $sortField = 'id';
            $sortOrder = 'ASC';
        }

        $query->orderBy($sortField, $sortOrder);

        $stock_required = Setting::where("key", "stock_required_online_shop")->value('value') === "yes";
        $image_required = Setting::where("key", "image_required_for_product_onlineshop")->value('value') === "yes";

        if ($image_required) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('products_id')
                    ->from('product_images')
                    ->distinct();
            });
        }

        if ($stock_required) {
            $query->whereIn('id', function ($subQuery) use ($stock_required) {
                $subQuery->select('products_id')
                    ->from('stocks')
                    ->join('stores', 'stores.id', '=', 'stocks.store_id')
                    ->where('stores.is_online', 'yes');

                if ($stock_required) {
                    $subQuery->where('quantity_stock', '>', 0);
                }
            });
        }

        $products = $query->paginate($paginate);

        $headerMenuColor = HeaderMenuColor::latest()->first();
        $HomepageCollectionImage = HomepageCollectionImage::latest()->get();
        $homeComponent1 = DB::table('home_components')
            ->join('home_component_mains', 'home_component_mains.id', '=', 'home_components.slider_id')
            ->orderBy('position', 'asc')
            ->get(['home_components.*', 'home_component_mains.title']);

        $homeComponentName1 = DB::table('home_component_mains')->orderBy('position', 'asc')->get();
        foreach ($homeComponentName1 as $item) {
            $item->slider_items = DB::table('home_components')->where('slider_id', $item->id)->get();
        }

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $company = Company::latest()->first();
        $attributes = $this->getActiveAttributes();
        $categories = $this->getActiveCategories();
        $carts = $this->getCarts();

        $fromapi = Setting::where("key", "product_stock_from_api")->value('value') === "yes";
        $online_stock_api = OnlineStockApi::latest()->first();
        $url = '';

        foreach ($products as &$product) {
            $product->product_image = Product_image::where('products_id', $product->id)
                ->where(function ($query) {
                    $query->where('active_thumbnail', 1)
                        ->orWhereNull('active_thumbnail');
                })->orderByDesc('active_thumbnail')->first();

            // Handle product variation attributes
            $product_variations = ProductVariation::where('products_id', $product->id)->get();
            $product->variation_attributes = $product_variations->flatMap(function ($variation) {
                return ProductVariationAttribute::where('product_variation_id', $variation->id)
                    ->get()
                    ->mapWithKeys(function ($attr) {
                        return [$attr->attribute_id => $attr->attribute_value_id];
                    });
            })->all();

            // Uncomment and adjust if using API for stock data
            // if ($fromapi && $online_stock_api) {
            //     $product_upc = Stock::where('products_id', $product->id)->first();
            //     if ($product_upc && isset($product_upc->barcode_value)) {
            //         $login = $online_stock_api->username;
            //         $password = $online_stock_api->password;
            //         $url = $online_stock_api->api_url . $product_upc->barcode_value;
            //
            //         try {
            //             $response = Http::withHeaders([
            //                 'Authorization' => 'Basic ' . base64_encode("$login:$password")
            //             ])->post($url);
            //
            //             $product->product_api = $response->json();
            //         } catch (\Exception $e) {
            //             $product->product_api = null;
            //         }
            //     } else {
            //         $product->product_api = null;
            //     }
            // } else {
            //     $product->product_api = null;
            // }
        }

        $first = $products->firstItem();
        $last = $products->lastItem();
        $products_all = $products->total();

        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $filtering = Setting::where("key", "filtered_required_for_product_onlineshop")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();
        $interval_homecarousel = Setting::where('key', '=', 'homecarousel_interval')->latest()->first();
        $shop_favicon = Setting::where("key", "store_favicon")->value('value') ?? url('files/logo/ecom-logo.png');

        $is_api_active = $fromapi;
        $url_origin = url()->current();
        $settings = Setting::get();

        $theme = ThemeService::getTheme();
        $view = 'front.default.home';
        if (!empty($theme)) {
            $view = 'front.' . $theme . '.home';
        }

        return view($view, compact([
            'homeComponentName1',
            'products',
            'carts',
            'headerMenuColor',
            'is_api_active',
            'filter_by',
            'settings',
            'enable_online_shop',
            'company',
            'shop_favicon',
            'categories',
            'attributes',
            'url',
            'url_origin',
            'shop_name',
            'shop_description',
            'filtering',
            'code_added_header',
            'sq',
            'products_all',
            'first',
            'last',
            'interval_homecarousel',
            'HomepageCollectionImage'
        ]));
    }
    public function shop(Request $request)
    {
        $sq = $request->search ?? '';
        $sb = $request->sortBy ?? 'id;ASC';
        $paginate = ProductSettings::where('name', 'product_per_page')->value('value') ?? 8;
        $filter_by = '';
        list($sortField, $sortOrder) = explode(';', $sb);
        $sortOrder = $sortOrder ?: 'ASC';

        $query = Products::query();
        $query->where('display_online', '=', 1);

        if ($sq) {
            $query->where(function ($subQuery) use ($sq) {
                $subQuery->where('id', $sq)
                    ->orWhere('name', 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", "")'), 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", " ")'), 'LIKE', "%{$sq}%")
                    ->orWhere(DB::raw('REPLACE(description, "-", "")'), 'LIKE', "%{$sq}%");
            });
        }

        if ($sortField === 'price') {
            $filter_by = "Price low to high";
        } elseif ($sortField === 'name' && $sortOrder === 'ASC') {
            $filter_by = "Name Ascending";
        } elseif ($sortField === 'name' && $sortOrder === 'DESC') {
            $filter_by = "Name Descending";
        } elseif ($sortField === 'filter_sort') {
            $filter_sort = true;
            $sortField = 'id';
            $sortOrder = 'ASC';
        }

        $query->orderBy($sortField, $sortOrder);

        $stock_required = Setting::where("key", "stock_required_online_shop")->value('value') === "yes";
        $image_required = Setting::where("key", "image_required_for_product_onlineshop")->value('value') === "yes";

        if ($image_required) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('products_id')
                    ->from('product_images')
                    ->distinct();
            });
        }

        if ($stock_required) {
            $query->whereIn('id', function ($subQuery) use ($stock_required) {
                $subQuery->select('products_id')
                    ->from('stocks')
                    ->join('stores', 'stores.id', '=', 'stocks.store_id')
                    ->where('stores.is_online', 'yes');

                if ($stock_required) {
                    $subQuery->where('quantity_stock', '>', 0);
                }
            });
        }

        $products = $query->paginate($paginate);

        $headerMenuColor = HeaderMenuColor::latest()->first();
        $HomepageCollectionImage = HomepageCollectionImage::latest()->get();
        $homeComponent1 = DB::table('home_components')
            ->join('home_component_mains', 'home_component_mains.id', '=', 'home_components.slider_id')
            ->orderBy('position', 'asc')
            ->get(['home_components.*', 'home_component_mains.title']);

        $homeComponentName1 = DB::table('home_component_mains')->orderBy('position', 'asc')->get();
        foreach ($homeComponentName1 as $item) {
            $item->slider_items = DB::table('home_components')->where('slider_id', $item->id)->get();
        }

        $enable_online_shop = Setting::where("key", "display_online_shop_product")->first();
        $company = Company::latest()->first();
        $attributes = $this->getActiveAttributes();
        $categories = $this->getActiveCategories();
        $carts = $this->getCarts();

        $fromapi = Setting::where("key", "product_stock_from_api")->value('value') === "yes";
        $online_stock_api = OnlineStockApi::latest()->first();
        $url = '';

        foreach ($products as &$product) {
            $product->product_image = Product_image::where('products_id', $product->id)
                ->where(function ($query) {
                    $query->where('active_thumbnail', 1)
                        ->orWhereNull('active_thumbnail');
                })->orderByDesc('active_thumbnail')->first();

            // Handle product variation attributes
            $product_variations = ProductVariation::where('products_id', $product->id)->get();
            $product->variation_attributes = $product_variations->flatMap(function ($variation) {
                return ProductVariationAttribute::where('product_variation_id', $variation->id)
                    ->get()
                    ->mapWithKeys(function ($attr) {
                        return [$attr->attribute_id => $attr->attribute_value_id];
                    });
            })->all();

            // Uncomment and adjust if using API for stock data
            // if ($fromapi && $online_stock_api) {
            //     $product_upc = Stock::where('products_id', $product->id)->first();
            //     if ($product_upc && isset($product_upc->barcode_value)) {
            //         $login = $online_stock_api->username;
            //         $password = $online_stock_api->password;
            //         $url = $online_stock_api->api_url . $product_upc->barcode_value;
            //
            //         try {
            //             $response = Http::withHeaders([
            //                 'Authorization' => 'Basic ' . base64_encode("$login:$password")
            //             ])->post($url);
            //
            //             $product->product_api = $response->json();
            //         } catch (\Exception $e) {
            //             $product->product_api = null;
            //         }
            //     } else {
            //         $product->product_api = null;
            //     }
            // } else {
            //     $product->product_api = null;
            // }
        }

        $first = $products->firstItem();
        $last = $products->lastItem();
        $products_all = $products->total();

        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $filtering = Setting::where("key", "filtered_required_for_product_onlineshop")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();
        $interval_homecarousel = Setting::where('key', '=', 'homecarousel_interval')->latest()->first();
        $shop_favicon = Setting::where("key", "store_favicon")->value('value') ?? url('files/logo/ecom-logo.png');

        $is_api_active = $fromapi;
        $url_origin = url()->current();
        $settings = Setting::get();
        $theme = ThemeService::getTheme();
        $view = 'front.default.home';
        if (!empty($theme) && $theme !== 'care-connect') {
            return redirect('/');
        }



        return view($view, compact([
            'homeComponentName1',
            'products',
            'carts',
            'headerMenuColor',
            'is_api_active',
            'filter_by',
            'settings',
            'enable_online_shop',
            'company',
            'shop_favicon',
            'categories',
            'attributes',
            'url',
            'url_origin',
            'shop_name',
            'shop_description',
            'filtering',
            'code_added_header',
            'sq',
            'products_all',
            'first',
            'last',
            'interval_homecarousel',
            'HomepageCollectionImage'
        ]));
    }

    private function getActiveCategories()
    {
        $categories = [];
        $category_list = Category::orderBy('id', 'DESC')->get();
        foreach ($category_list as $category) {

            $products_category = Category_product::where('id_category', $category['id'])->get();
            if ($products_category->isNotEmpty()) {
                $categories[] = $category;
            }
        }
        return $categories;
    }

    private function getActiveAttributes()
    {
        return Attribute::with('attributeValues')->orderBy('id', 'ASC')->where('active_filter', 1)->get()->map(function ($attribute) {
            $attribute->attributes_values = ProductService::getActiveAttributeValues($attribute->id);
            return $attribute;
        });
    }

    private function getCarts()
    {
        $session_id = Session::get('session_id');
        return Cart::where("session_id", $session_id)->get();
    }

    public function filter(Request $request)
    {
        $url = $request->url;
        $parent_attr = $request->parent_attributes;
        $category = $request->category;
        $search_products = trim($request->search_products);
        $products = array();
        $search_product = trim($request->search);
        $sort_product = $request->sortBy;
        $attribute_value_id = $request->attribute_value_id;
        $searchable = [];
        $array_variation = [];
        $filter_by = "";

        if (!$search_products)
            $search_products = $search_product;

        if ($search_product != '') {
            $searchable = Products::where(DB::raw('name'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")->orderBy('id', 'DESC')->get();
        }
        // settings stock_required_online_shop
        $stock_required = Setting::where("key", "stock_required_online_shop")->first();
        if (isset($stock_required->value) && $stock_required->value == "yes") {
            if (isset($search_product)) {
                $searchable = Products::latest()
                    ->whereIn('id', DB::table('stocks')->select('products_id')->where('quantity_stock', '>', 0)->get()->pluck('products_id'))
                    ->whereIn('id', DB::table('stocks')->select('products_id')->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(sku, "-", " " )'), 'LIKE', "%{$search_product}%")->get()->pluck('products_id'))
                    ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orderBy('id', 'DESC')->get();
            }
        }
        ///Product image required to display product on online shop
        $required_image = Setting::where("key", "image_required_for_product_onlineshop")->first();
        if (isset($required_image->value) && $required_image->value == "yes") {
            if (isset($search_product)) {
                $searchable = Products::latest()
                    ->whereIn(
                        'id',
                        DB::table('product_images')
                            ->select('products_id')
                            ->distinct()
                            ->get()->pluck('products_id')
                    )
                    ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orderBy('id', 'DESC')->get();
            }
        }

        if (isset($stock_required->value) && $stock_required->value == "yes" && isset($required_image->value) && $required_image->value == "yes") {
            if (isset($search_product)) {
                $searchable = Products::latest()
                    ->whereIn('id', DB::table('stocks')->select('products_id')->where('quantity_stock', '>', 0)->get()->pluck('products_id'))
                    ->whereIn('id', DB::table('stocks')->select('products_id')->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(sku, "-", " " )'), 'LIKE', "%{$search_product}%")->get()->pluck('products_id'))
                    ->whereIn(
                        'id',
                        DB::table('product_images')
                            ->select('products_id')
                            ->distinct()
                            ->get()->pluck('products_id')
                    )
                    ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                    ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                    ->orderBy('id', 'DESC')->get();
            }
        }
        if (isset($category) && $category) {
            foreach ($category as $k => $cat) {
                if ($cat != 0) {
                    $products_category = Category_product::where('id_category', $cat)->get();
                    if (count($products_category) > 0) {
                        foreach ($products_category as $pc) {
                            if (!empty($searchable)) {
                                foreach ($searchable as $search_a) {
                                    if ($search_a->id == $pc->id_product) {
                                        $product = Products::find($pc->id_product);
                                        if (isset($product->id) && $product->id != null)
                                            $products[] = $product->id;
                                    }
                                }
                            } else {
                                $product = Products::find($pc->id_product);
                                if (isset($product->id) && $product->id != null)
                                    $products[] = $product->id;
                            }
                        }
                    }
                } else {
                    $product_filter = Products::orderBy('id', 'DESC')->get();
                    foreach ($product_filter as $p) {
                        if (!empty($searchable)) {
                            foreach ($searchable as $search_a) {
                                if ($search_a->id == $p->id) {
                                    $check_product_uncategorized = Category_product::where('id_product', $p->id)->get();
                                    if (count($check_product_uncategorized) <= 0)
                                        $products[] = $p->id;
                                }
                            }
                        } else {
                            $check_product_uncategorized = Category_product::where('id_product', $p->id)->get();
                            if (count($check_product_uncategorized) <= 0)
                                $products[] = $p->id;
                        }
                    }
                }
            }
        } else {
            if (isset($search_product) && $search_product != "") {
                $category = Category::where('category', $search_product)->orderBy('id', 'DESC')->first();
                if ($category) {
                    $products_category = Category_product::where('id_category', $category->id)->get();
                    if (count($products_category) > 0) {
                        foreach ($products_category as $pc) {
                            if (!empty($searchable)) {
                                foreach ($searchable as $search_a) {
                                    if ($search_a->id == $pc->id_product) {
                                        $product = Products::find($pc->id_product);
                                        $products[] = $product->id;
                                    }
                                }
                            } else {
                                $product = Products::find($pc->id_product);
                                $products[] = $product->id;
                            }
                        }
                    }
                } else {
                    foreach ($searchable as $search_a) {
                        $products[] = $search_a->id;
                    }
                }
            } else {
                $products_p = Products::latest()->orderBy('id', 'DESC')->get();
                if (isset($stock_required->value) && $stock_required->value == "yes") {
                    $products_p = Products::latest()
                        ->whereIn('id', DB::table('stocks')->select('products_id')->where('quantity_stock', '>', 0)->get()->pluck('products_id'))
                        ->whereIn('id', DB::table('stocks')->select('products_id')->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(sku, "-", " " )'), 'LIKE', "%{$search_product}%")->get()->pluck('products_id'))
                        ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orderBy('id', 'DESC')->get();
                }
                if (isset($required_image->value) && $required_image->value == "yes") {
                    $products_p = Products::latest()
                        ->whereIn(
                            'id',
                            DB::table('product_images')
                                ->select('products_id')
                                ->distinct()
                                ->get()->pluck('products_id')
                        )
                        ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('REPLACE(name, "-", " " )'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orderBy('id', 'DESC')->get();
                }
                if (isset($stock_required->value) && $stock_required->value == "yes" && isset($required_image->value) && $required_image->value == "yes") {
                    $searchable = Products::latest()
                        ->whereIn('id', DB::table('stocks')->select('products_id')->where('quantity_stock', '>', 0)->get()->pluck('products_id'))
                        ->whereIn('id', DB::table('stocks')->select('products_id')->where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', "%{$search_product}%")->orWhere(DB::raw('REPLACE(sku, "-", " " )'), 'LIKE', "%{$search_product}%")->get()->pluck('products_id'))
                        ->whereIn(
                            'id',
                            DB::table('product_images')
                                ->select('products_id')
                                ->distinct()
                                ->get()->pluck('products_id')
                        )
                        ->where(DB::raw('REPLACE(name, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('name'), 'LIKE', "%{$search_product}%")
                        ->orWhere(DB::raw('REPLACE(description, "-", "" )'), 'LIKE', "%{$search_product}%")
                        ->orderBy('id', 'DESC')->get();
                }
                if (!empty($searchable))
                    $products_p = $searchable;
                foreach ($products_p as $product) {
                    $products[] = $product['id'];
                }
            }
        }

        $paginate = 8;
        $product_settings = ProductSettings::where('name', 'product_per_page')->first();
        if ($product_settings)
            $paginate = $product_settings->value;

        $stock_req = array();
        $stock_req1 = array();
        if ($search_product) {
            $stocks = Stock::where('barcode_value', 'LIKE', '%' . $search_product . '%')->orderBy('products_id', 'DESC')->get();
            $stocks1 = Stock::where(DB::raw('REPLACE(sku, "-", "" )'), 'LIKE', '%' . $search_product . '%')->orWhere(DB::raw('REPLACE(sku, "-", " " )'), 'LIKE', '%' . $search_product . '%')->orderBy('products_id', 'DESC')->get();
            $stock_req = $stocks;
            $stock_req1 = $stocks1;
        }

        if (!empty($stock_req)) {
            foreach ($stock_req as $p_s) {
                array_push($products, $p_s->products_id);
            }
        }

        if (!empty($stock_req1)) {
            foreach ($stock_req1 as $p_s1) {
                array_push($products, $p_s1->products_id);
            }
        }

        $id_arrays = array_unique($products);

        $sort_product_exp = [
            0 => 'id',
            1 => 'DESC'
        ];

        if ($sort_product != '') {
            $sort_product_exp = explode(';', $sort_product);
            if ($sort_product_exp[0] == 'price')
                $filter_by = "Price low to high";
            elseif ($sort_product_exp[0] == 'name' && $sort_product_exp[1] == 'ASC')
                $filter_by = "Name Ascending";
            elseif ($sort_product_exp[0] == 'name' && $sort_product_exp[1] == 'DESC')
                $filter_by = "Name Descending";

            if ($sort_product_exp[0] == 'filter_sort') {

                if ($sort_product_exp[1] == 'in_stock_online')
                    $filter_by = "In stock online";
                else
                    $filter_by = "Out of stock online";

                $array_out = [];

                if ($sort_product_exp[1] == 'out_of_stock_online') {
                    foreach (array_unique($id_arrays) as $id_product) {
                        $is_out = self::is_out_of_stock_onlineshop($id_product);
                        if (!empty($is_out) && 0 >= (int) $is_out)
                            array_push($array_out, $id_product);
                    }
                } else {
                    foreach (array_unique($id_arrays) as $id_product) {
                        $is_out = self::is_out_of_stock_onlineshop($id_product);
                        if (!empty($is_out) && (int) $is_out > 0)
                            array_push($array_out, $id_product);
                    }
                }

                $id_arrays = $array_out;
                $sort_product_exp = [
                    0 => 'id',
                    1 => 'DESC'
                ];
            }
        }
        $sort_product_exp[0] = 'products.' . $sort_product_exp[0];
        $products_all_qry = Products::leftjoin('product_visibilities', 'products.id', 'product_visibilities.products_id')
            ->leftjoin('product_variations', 'products.id', 'product_variations.products_id')
            ->leftjoin('product_variation_attributes', 'product_variations.id', 'product_variation_attributes.product_variation_id')
            ->where('product_visibilities.active', 'yes')
            ->whereIn('products.id', array_unique($id_arrays));

        if (!empty($attribute_value_id))
            $products_all_qry->whereIn('product_variation_attributes.attribute_value_id', array_unique($attribute_value_id));

        $products_all = $products_all_qry->count();

        $products_qry = Products::whereIn('products.id', array_unique($id_arrays))
            ->select('products.*', 'product_positions.position')
            ->leftjoin('product_visibilities', 'products.id', 'product_visibilities.products_id')
            ->leftjoin('product_positions', 'products.id', 'product_positions.products_id')
            ->leftjoin('product_variations', 'products.id', 'product_variations.products_id')
            ->leftjoin('product_variation_attributes', 'product_variations.id', 'product_variation_attributes.product_variation_id')
            ->where('product_visibilities.active', 'yes');

        if (!empty($attribute_value_id))
            $products_qry->whereIn('product_variation_attributes.attribute_value_id', array_unique($attribute_value_id));

        $products = $products_qry->groupBy('products.id')
            ->orderBy('product_positions.position', 'ASC')
            ->orderBy($sort_product_exp[0], $sort_product_exp[1])
            ->paginate($paginate);

        foreach ($products as &$product) {
            $images_variation = [];
            $is_image_variation = 0;
            $images_product = Product_image::where('products_id', $product['id'])->first();

            if (!empty($array_variation)) {
                foreach ($array_variation as $av) {
                    if ($product->id == $av['id_product']) {
                        $images_v = array();
                        if (isset($av['id_variation'])) {
                            $variationiimg = ProductVariation::find($av['id_variation']);

                            if (!empty($variationiimg->imagesVariation))
                                $images_v = $variationiimg->imagesVariation;

                            if (!empty($images_v)) {

                                foreach ($images_v as $img) {
                                    $is_image_variation++;
                                    $images_variation = $img;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            if ($is_image_variation) {
                $product['product_image'] = $images_variation;
            } else {
                $product['product_image'] = $images_product;
            }
        }
        $first = 1;
        $last = $paginate;
        if ($request->page > 1) {
            $first = ($paginate * ($request->page - 1)) + 1;
            $last = $paginate * $request->page;
        }
        if ($last > $products_all)
            $last = $products_all;

        if ($products_all == 0) {
            $first = $products_all;
            $last = $products_all;
        }

        $company = Company::latest()->first();
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon = $company->logo;
        }
        $filter_filter = '';
        if (isset($category) && $category) {
            foreach ($category as $k => $cat) {
                $cat_val = Category::find($cat);
                if ($cat_val)
                    $filter_filter .= $cat_val->category . ', ';
            }
        }
        if (isset($parent_attr) && !empty($parent_attr)) {
            foreach ($parent_attr as $k => $parent_a) {
                if (isset($request['attribute_value_' . $k]) && !empty($request['attribute_value_' . $k])) {
                    $id_attribute_value = $request['attribute_value_' . $k];
                    if ($id_attribute_value != 0) {
                        $attribute_val = AttributeValue::find($id_attribute_value);
                        if ($attribute_val)
                            $filter_filter .= $attribute_val->attribute_values . ', ';
                    }
                }
            }
        }


        return view('front.filter_listing_ajax', compact([
            'filter_by',
            'filter_filter',
            'company',
            'shop_favicon',
            'products',
            'search_product',
            'products_all',
            'first',
            'last',
            'search_product'
        ]));
    }
}
