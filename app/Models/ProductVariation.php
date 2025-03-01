<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductVariation extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'products_id',
        'variation_value',
        'product_variation_id',
        'price',
        'price_buying',
        'position'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variation_attributes')
            ->withPivot('attribute_value_id');
    }

    public function imagesVariation()
    {
        return $this->hasMany(ProductVariationImages::class)
            ->orderBy('updated_at', 'desc');
    }

    public function variationImages()
    {
        return $this->hasMany(ProductVariationImages::class)
            ->orderBy('updated_at', 'desc');
    }

    public function variationThumbnail()
    {
        return $this->hasOne(ProductVariationThumbnail::class);
    }

    public function productStatus()
    {
        return $this->hasOne(ProductVisibility::class, 'products_id', 'products_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'id', 'attribute_value_id');
    }

    public function getHumanReadableVariationValueAttribute()
    {
        // Ensure $variationValues is an array
        $variationValues = $this->getVariationAttributesWithAttrName();

        // Check if $variationValues is an array
        if (!is_array($variationValues)) {
            return []; // or handle the error as needed
        }

        // Extract all value IDs from the variation values
        $valueIds = array_values($variationValues);

        // Fetch attribute values by these IDs
        $attributeValues = AttributeValue::whereIn('id', $valueIds)->get()->keyBy('id');

        $readableValues = [];

        // Map the fetched attribute values to human-readable format
        foreach ($variationValues as $attribute => $valueId) {
            $valueId = (int) $valueId;
            if (isset($attributeValues[$valueId])) {
                $readableValues[$attribute] = $attributeValues[$valueId]->attribute_values;
            }
        }

        return $readableValues;
    }

    public static function getReadableVariationById($id)
    {
        return self::findOrFail($id)->human_readable_variation_value;
    }

    public function productVariationAttributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'product_variation_id');
    }

    public function getVariationAttributes()
    {
        return $this->attributes()
            ->with('attributeValues')
            ->get()
            ->mapWithKeys(function ($attribute) {
                return [$attribute->id => $attribute->pivot->attribute_value_id];
            })
            ->toArray();
    }

    public function getVariationAttributesWithAttrName()
    {
        return $this->attributes()
            ->with('attributeValues')
            ->get()
            ->mapWithKeys(function ($attribute) {
                return [$attribute->attribute_name => $attribute->pivot->attribute_value_id];
            })
            ->toArray();
    }

    // Accessor for variation_value attribute
    public function getVariationValueAttribute()
    {
        return $this->getVariationAttributes();
    }
}
