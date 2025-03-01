<?php

namespace App\Services;


use App\Models\AttributeValue;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use App\Models\ProductVariationImages;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ProductVariationService {

    public static function validateExistingVariationsByProductId($productId, $attributes, $throwErrors=true)
    {
        // Check for existing variations
        $existingVariations = DB::table('product_variations')
            ->where('products_id', $productId)
            ->pluck('id');

        $isExactMatch = false;
        $isSubset = false;

        foreach ($existingVariations as $variationId) {
            $existingAttributes = DB::table('product_variation_attributes')
                ->where('product_variation_id', $variationId)
                ->pluck('attribute_value_id', 'attribute_id')
                ->toArray();

            // Check for exact match
            if ($existingAttributes == $attributes) {
                $isExactMatch = true;
                break;
            }
            // Check if the existing attributes are a subset of the new attributes
            if (!empty($existingAttributes) && count(array_intersect_assoc($existingAttributes, $attributes)) == count($existingAttributes)) {
                $isSubset = true;
                break;
            }
        }

        if ($isExactMatch && $throwErrors) {
            throw new \Exception('Variation already exists for this product, please select other variation attributes.');
        }

        if ($isSubset && $throwErrors) {
            throw new \Exception('Variation subset already exists. Modify existing subset to add new variation values.');
        }
    }
}
