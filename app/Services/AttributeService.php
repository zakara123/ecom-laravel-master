<?php

namespace App\Services;


use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeService {

    public static function getVariationValuesAsSeperateKeyValue(array $variation_val) : array
    {
        $variation_value = [];
        $variation_array = [];

        foreach ($variation_val as $item) {
            foreach ($item as $attribute => $value) {
                $attributeModel = Attribute::where('attribute_slug', $attribute)->first();
                $attributeValueModel = AttributeValue::find($value);

                if ($attributeModel && $attributeValueModel) {
                    $variation_array[] = ["id_attribute" => $attributeModel->id, "id_attribute_value" => $value];
                    $variation_value[] = [
                        "attribute" => $attributeModel->attribute_name,
                        "attribute_value" => $attributeValueModel->attribute_values
                    ];
                }
            }
        }

        return ['variation_value' => $variation_value, 'variation_array' => $variation_array];
    }

    public static function getVariationValues(array $variation_val) : array
    {
        $variation_value = [];

        foreach ($variation_val as $item) {
            foreach ($item as $attribute => $value) {
                $attributeModel = Attribute::where('attribute_slug', $attribute)->first();
                $attributeValueModel = AttributeValue::find($value);

                if ($attributeModel && $attributeValueModel) {
                    $variation_value[] = [
                        "attribute_id" => $attributeModel->id,
                        "attribute_value_id" => $value,
                        "attribute" => $attributeModel->attribute_name,
                        "attribute_value" => $attributeValueModel->attribute_values
                    ];
                }
            }
        }

        return $variation_value;
    }
}


