<?php

namespace App\Services;


use App\Models\AttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use App\Models\ProductVariationImages;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Products;

use Illuminate\Support\Facades\DB;

class ProductService
{

    public static function convertProductVariationsToArray($product_variations)
    {
        return $product_variations->map(function ($variation) {
            return [
                'id' => $variation->id,
                'products_id' => $variation->products_id,
                'attributes' => $variation->attributes,
                'price' => $variation->price,
                'price_buying' => $variation->price_buying,
                'images' => $variation->imagesVariation,
                'created_at' => $variation->created_at,
                'updated_at' => $variation->updated_at,
            ];
        })->toArray();
    }

    public static function getProductVariations($productId)
    {
        $stock_required = Setting::where('key', 'stock_required_online_shop')->value('value');

        $variationsQuery = ProductVariation::with(['attributes', 'imagesVariation'])->where('products_id', $productId);

        if ($stock_required === 'yes') {
            $variationsQuery->whereIn('id', function ($query) {
                $query->select('product_variation_id')
                    ->from('stocks')
                    ->join('stores', 'stores.id', '=', 'stocks.store_id')
                    ->where('stocks.quantity_stock', '>', 0)
                    ->where('stores.is_online', 'yes');
            });
        }

        $variations = $variationsQuery->get()->map(function ($variation) {
            $variation->attributes = ProductVariationAttribute::where('product_variation_id', $variation->id)
                ->with('attribute', 'attributeValue')
                ->get()
                ->map(function ($attr) {
                    return [
                        'attribute_id' => $attr->attribute_id,
                        'attribute_value_id' => $attr->attribute_value_id,
                        'attribute' => $attr->attribute->attribute_name,
                        'attribute_value' => $attr->attributeValue->attribute_values
                    ];
                });

            $variation->stock = Stock::where('product_variation_id', $variation->id)->sum('quantity_stock');

            // Generate readable_product_variations
            $readable_product_variations = [];
            foreach ($variation->attributes as $attribute) {
                $readable_product_variations[] = "{$attribute['attribute']}: {$attribute['attribute_value']}";
            }
            $variation->readable_product_variations = implode(' | ', $readable_product_variations);

            return $variation;
        });

        return $variations;
    }

    public static function getActiveAttributeValues($attributeId)
    {
        // Fetch all attribute values for the given attributeId
        $values = AttributeValue::where('attribute_id', $attributeId)
            ->orderBy('id', 'ASC')
            ->get();

        //        commented below because it only gets valid attributes only if that attribute type of product is present or not
        //            ->filter(function ($attributeValue) {
        //                // Check if there are active product variations with this attribute value
        //                return ProductVariationAttribute::where('attribute_id', $attributeValue->attribute_id)
        //                    ->where('attribute_value_id', $attributeValue->id)
        //                    ->whereHas('productVariation', function ($q) {
        //                        $q->whereHas('productStatus', function ($query) {
        //                            $query->where('active', 'yes');
        //                        });
        //                    })
        //                    ->exists();
        //            });

        return $values;
    }

    public static function processVariation(&$variation)
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
        $variation->variation_value_text = implode(' | ', $variation_value_text);
    }

    public static function getProductVariationsByProductId($product_id)
    {
        return DB::table('product_variations')
            ->select(
                'product_variations.*',
            )
            ->leftJoin('stocks', 'stocks.product_variation_id', '=', 'product_variations.id')
            ->where('product_variations.products_id', $product_id)
            ->get()
            ->map(function ($variation) {
                ProductService::processVariation($variation);
                return $variation;
            });
    }

    public static function getItemsByStoreId($storeId)
    {
        $products = [];
        // $products = DB::table('stocks')
        //     ->join('products', 'products.id', '=', 'stocks.products_id')
        //     ->join('stores', 'stores.id', '=', 'stocks.store_id')
        //     ->select('products.*')
        //     ->distinct('products.id')
        //     ->where("stores.id", $storeId)
        //     ->get();

        $products=Products::all();
        return $products;
    }
}
