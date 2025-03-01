<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Company;
use App\Models\HeaderMenuColor;
use App\Models\Products;
use App\Models\ProductVariation;
use App\Models\Setting;
use App\Services\CommonService;
use App\Services\ProductDetailService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function getProductBySlug($slug)
    {
        return ProductDetailService::getProductBySlug($slug);
//        return ProductDetailService::getProductBySlug2($slug);
//        return ProductDetailService::getProductBySlugOld($slug);
    }

    public function getProductDetails($productId, $storeId = "")
    {
        $stock_required_online_shop = Setting::where('key', '=', 'stock_required_online_shop')->pluck('value')->first();

        $product = Products::find($productId);

        if (empty($storeId)) {
            return response()->json(['msg' => 'Undefined Store', 'error' => true], 400);
        }

        $product_variations = DB::table('product_variations')
            ->select(
                'product_variations.*',
                'stocks.id as stock_id',
                'stocks.quantity_stock'
            )
            ->leftJoin('stocks', 'stocks.product_variation_id', '=', 'product_variations.id')
            ->where('product_variations.products_id', $productId)
            ->where(function ($query) use ($storeId) {
                $query->where('stocks.store_id', '=', $storeId)
                    ->orWhereNull('stocks.product_variation_id');
            })
            ->get()
            ->map(function ($variation) {
                $this->processVariation($variation);
                return $variation;
            });

        $product_stock = DB::table('stocks')
            ->select('quantity_stock')
            ->where([
                ['products_id', '=', $productId],
                ['store_id', '=', $storeId],
                ['product_variation_id', '=', null],
            ])
            ->first();

        return response()->json([
            "product" => $product,
            "stock" => isset($product_stock) ? $product_stock : ["quantity_stock" => 0],
            "variation" => $product_variations,
        ]);
    }

    private function processVariation(&$variation)
    {
        $variation_value_final = $variation_value_text = [];
        $variationRv = ProductVariation::getReadableVariationById($variation->id);

        if (!empty($variationRv)) {
            foreach ($variationRv as $attribute => $value) {
                $variation_value_final[] = ["attribute" => $attribute, "attribute_value" => $value];
                $variation_value_text[] = $attribute . ": " . $value;
            }
        }

        $variation->variation_value = $variation_value_final;
        $variation->variation_value_text = $variation_value_text;
    }

}
