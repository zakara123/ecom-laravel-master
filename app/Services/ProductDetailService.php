<?php

namespace App\Services;


use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Company;
use App\Models\HeaderMenuColor;
use App\Models\OnlineStockApi;
use App\Models\Products;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProductDetailService {

    public static function getProductBySlug($slug)
    {
        // Fetch the product with its relations and necessary data in one query
        $product = Products::with([
            'images',
            'categories',
            'variations.attributes.attributeValues',
            'variations.imagesVariation',
            'variations.variationThumbnail',
            'sku',
            'stockApi'
        ])->where('slug', $slug)->firstOrFail();

        $attributes = Attribute::with('attributeValues')->get();

        $enable_online_shop = Setting::where('key', 'display_online_shop_product')->value('value');

        // Abort if the online shop is disabled
        if ($enable_online_shop === 'no') {
            $session_id = Session::get('session_id');
            if ($session_id) {
                Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
        $stock_api_final = self::getStockApiData($product, $product_stock_from_api);

        $product_variations = ProductService::getProductVariations($product->id);
        $product_variations_array = ProductService::convertProductVariationsToArray($product_variations);
        $attributeMap = self::buildAttributeMap($product_variations);

        $theme = Setting::where('key', 'store_theme')->value('value') ?: 'default';
        return view('front.'.$theme.'.product-details', compact('product', 'attributes', 'product_variations_array', 'attributeMap'));
    }

    public static function getProductBySlug2($slug)
    {
        $product = Products::with([
            'images',
            'categories',
            'variations.attributes.attributeValues',
            'variations.imagesVariation',
            'sku',
            'stockApi'
        ])->where('slug', $slug)->firstOrFail();

        $session_id = Session::get('session_id');
        $enable_online_shop = Setting::where('key', 'display_online_shop_product')->value('value');

        if ($enable_online_shop === 'no') {
            if ($session_id) {
                Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
        $stock_api_final = self::getStockApiData($product, $product_stock_from_api);

        $product_variations = ProductService::getProductVariations($product->id);
        $product_variations_array = ProductService::convertProductVariationsToArray($product_variations);
        $attributeMap = self::buildAttributeMap($product_variations);

        $theme = Setting::where('key', 'store_theme')->value('value') ?: 'default';

        $view = 'front.default.product-details';
        if (CommonService::doStringMatch($theme, 'troketia')){
            $view = 'front.troketia.product';
        }

        return view($view, compact('product', 'product_variations_array', 'attributeMap'));
    }

    public static function getProductBySlugOld($slug)
    {
        $product = Products::with([
            'images',
            'categories',
            'variations',
            'variations.attributes.attributeValues',
            'variations.imagesVariation',
            'sku',
            'stockApi'
        ])->where('slug', $slug)->firstOrFail();

        $session_id = Session::get('session_id');
        $enable_online_shop = Setting::where('key', 'display_online_shop_product')->value('value');

        if ($enable_online_shop === 'no') {
            if ($session_id) {
                Cart::where('session_id', $session_id)->delete();
            }
            abort(404);
        }

        $carts = $session_id ? Cart::with(['productImage' => function($query) {
            $query->where('active_thumbnail', 1)->orWhereNull('active_thumbnail')->orderByDesc('active_thumbnail');
        }])->where('session_id', $session_id)->get() : [];

        $image_cover = $product->images->firstWhere('active_thumbnail', 1) ?? $product->images->first();
        $headerMenus = CommonService::getHeaderMenus();        $headerMenuColor = HeaderMenuColor::latest()->first();

        $product_variations = ProductService::getProductVariations($product->id);
        $product_variations_array = ProductService::convertProductVariationsToArray($product_variations);

        $attributeMap = self::buildAttributeMap($product_variations);

        $shop_name = Setting::where('key', 'store_name_meta')->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();
        $shop_color = Setting::where('key', 'shop_color')->first();
        $shop_product_detail_color = Setting::where('key', 'shop_product_detail_color')->first();
        $shop_product_detail_background_color = Setting::where('key', 'shop_product_detail_background_color')->first();
        $shop_product_detail_menu_color = Setting::where('key', 'shop_product_detail_menu_color')->first();

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

        $view = self::getViewBasedOnApiSetting($product, $carts, $image_cover, $headerMenuColor, $headerMenus, $product_variations, $product_variations_array, $shop_favicon, $company, $shop_name, $shop_description, $code_added_header, $attributeMap, $shop_color, $shop_product_detail_color, $shop_product_detail_background_color, $shop_product_detail_menu_color);

        return $view;
    }

    private static function buildAttributeMap($product_variations)
    {
        $attributeMap = [];

        foreach ($product_variations as $variation) {
            $attributes = [];
            $attributeValues = [];

            foreach ($variation->attributes as $variationDetail) {
                $attribute = $variationDetail['attribute'];
                $attributeValue = $variationDetail['attribute_value'];

                if (!isset($attributes[$attribute])) {
                    $attributes[$attribute] = [];
                }

                if (!in_array($attributeValue, $attributes[$attribute])) {
                    $attributes[$attribute][] = $attributeValue;
                }

                if (!isset($attributeValues[$attribute])) {
                    $attributeValues[$attribute] = [];
                }

                $attributeValues[$attribute][] = $attributeValue;
            }

            foreach ($attributes as $attribute => $values) {
                foreach ($values as $value) {
                    if (!isset($attributeMap[$attribute][$value])) {
                        $attributeMap[$attribute][$value] = [
                            'name' => $value,
                            'related' => []
                        ];
                    }
                }
            }

            foreach ($attributeValues as $attribute => $values) {
                foreach ($values as $value) {
                    if (isset($attributeMap[$attribute][$value])) {
                        foreach ($attributeValues as $otherAttribute => $otherValues) {
                            if ($otherAttribute !== $attribute) {
                                foreach ($otherValues as $otherValue) {
                                    if (!in_array($otherValue, isset($attributeMap[$attribute][$value]['related'][$otherAttribute]) ? $attributeMap[$attribute][$value]['related'][$otherAttribute] : [])) {
                                        $attributeMap[$attribute][$value]['related'][$otherAttribute][] = $otherValue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $attributeMap;
    }

    private static function getViewBasedOnApiSetting($product, $carts, $image_cover, $headerMenuColor, $headerMenus, $product_variations, $product_variations_array, $shop_favicon, $company, $shop_name, $shop_description, $code_added_header, $attributeMap, $shop_color, $shop_product_detail_color, $shop_product_detail_background_color, $shop_product_detail_menu_color)
    {
        $product_stock_from_api = Setting::where("key", "product_stock_from_api")->first();
        $stock_api_final = self::getStockApiData($product, $product_stock_from_api);

        if ($product_stock_from_api === 'yes') {
            $info_sku = $product->sku()->orderBy('id', 'desc')->first();
            return view('front.product_posterita', compact('product', 'carts', 'shop_favicon', 'company', 'image_cover', 'headerMenuColor', 'headerMenus', 'product_variations', 'product_variations_array', 'shop_name', 'shop_description', 'code_added_header', 'attributeMap', 'stock_api_final', 'info_sku', 'shop_color', 'shop_product_detail_color', 'shop_product_detail_background_color', 'shop_product_detail_menu_color'));
        }

        $info_sku = $product->sku()->orderBy('id', 'desc')->first();
        $theme = Setting::where('key', 'store_theme')->value('value') ?? 'default';

        $view = 'front.default.product';
        if ($theme === 'troketia'){
            $view = 'front.troketia.product';
        }

        return view($view, compact('product', 'carts', 'shop_favicon', 'company', 'image_cover', 'headerMenuColor', 'headerMenus', 'product_variations', 'product_variations_array', 'shop_name', 'shop_description', 'code_added_header', 'attributeMap', 'info_sku', 'shop_color', 'shop_product_detail_color', 'shop_product_detail_background_color', 'shop_product_detail_menu_color', 'stock_api_final'));
    }

    private static function getStockApiData($product, $fromapi)
    {
        $stock_api_final = $stock_api = [];
        if ($fromapi != NULL && $fromapi->value == "yes") {
            $stock_line = Stock::where('products_id', $product->id)->get();
            $online_stock_api = OnlineStockApi::latest()->first();
            if ($online_stock_api != NULL) {
                try {
                    foreach ($stock_line as $stock) {
                        $login = $online_stock_api->username;
                        $password = $online_stock_api->password;
                        $url = $online_stock_api->api_url . $stock->barcode_value;

                        $result = Http::withHeaders([
                            'Authorization' => 'Basic ' . base64_encode($login . ':' . $password)
                        ])->timeout(5)->post($url);

                        $stock_api_loc = json_decode($result->body());
                        //                    $stock_api_loc = [];
                        $product_variation_s = ProductVariation::find($stock->product_variation_id);
                        if ($product_variation_s && isset($product_variation_s->id_product_attributs_value)) {
                            $variation_value_s = json_decode($product_variation_s->id_product_attributs_value);
                            $variation_s['variation_value'] = [];
                            if ($variation_value_s != NULL) {
                                foreach ($variation_value_s as $v) {
                                    foreach ($v as $k => $a) {
                                        $attr = Attribute::find($k);
                                        $attr_val = AttributeValue::find($a);
                                        if ($attr_val != NULL && $attr != NULL) {
                                            if ($attr->attribute_name == 'Size' || $attr->attribute_slug == 'size')
                                                $variation_s['variation_value'] = array_merge($variation_s['variation_value'], [["attribute" => $attr->attribute_name, "m_attribute_slug" => $attr->attribute_slug, "attribute_value" => $attr_val->attribute_values, "sub_attribute_slug" => $attr_val->slug]]);
                                        }
                                    }
                                }
                            }
                            if (!empty($variation_s['variation_value']) && $stock_api_loc) {
                                $stock_api_loc->size_value = $variation_s['variation_value'][0]['attribute_value'];
                            }
                        }

                        $stock_api = array_merge($stock_api, [$stock_api_loc]);
                        if (is_null($first_upc)) {
                            $first_upc = $stock_api_loc;
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Error fetching stock data from API: " . $e->getMessage());
                    $stock_api_error = true;
                }
            }
            $api_product = NULL;
            $i = 0;
            $api_size_store = [];
            foreach ($stock_api as $stock_ap) {
                if (isset($stock_ap->stock)) {
                    if ($i == 0)
                        $api_product = $stock_ap;
                    foreach ($stock_ap->stock as $stock) {
                        $arr = [
                            "location" => $stock->location,
                            "upc" => $stock_ap->upc,
                            "size" => "",
                            "color" => "",
                            "qty" => $stock->qty,
                        ];
                        if (isset($stock_ap->size) && is_string($stock_ap->size) && $stock_ap->size != "" && $stock_ap->size != "-") {
                            $arr["size"] = $stock_ap->size;
                            if ($stock->qty > 0) {
                                $api_size_store[$stock_ap->size][] = array('location' => $stock->location, 'quantity' => $stock->qty);
                            }
                            $have_size = "yes";
                        } elseif (isset($stock_ap->size_value) && is_string($stock_ap->size_value) && $stock_ap->size_value != "" && $stock_ap->size_value != "-") {
                            $arr["size"] = $stock_ap->size_value;
                            if ($stock->qty > 0) {
                                $api_size_store[$stock_ap->size_value][] = array('location' => $stock->location, 'quantity' => $stock->qty);
                            }
                            $have_size = "yes";
                        }
                        if (isset($stock_ap->group5) && is_string($stock_ap->group5)) {
                            $arr["color"] = $stock_ap->group5;
                        }
                        if ($arr["location"] != "Defunct" && $arr["location"] != "Supplier Defect")
                            $stock_api_final = array_merge($stock_api_final, [$arr]);
                    }
                    $i++;
                }
            }

            if (count($api_size_store) > 0) {

                foreach ($api_size_store as $k => &$api_s) {
                    $api_size_store[$k] = array_reverse(
                        array_values(
                            array_column(
                                array_reverse($api_s),
                                null,
                                'location'
                            )
                        )
                    );
                }
            }
            usort($stock_api_final, fn($a, $b) => strcmp($a['location'], $b['location']));
        }

        return $stock_api_final;
    }
}
