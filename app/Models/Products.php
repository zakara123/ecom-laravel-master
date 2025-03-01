<?php

namespace App\Models;

use App\Models\Product_image;
use App\Models\ProductPosition;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Products extends Model
{
    use Searchable;

    use HasFactory;

    protected $guarded = ['slug'];

    public function images() {
        return $this->hasMany(Product_image::class)->orderByDesc('updated_at');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::created(function ($product) {
//            ProductPosition::create([
//                'products_id'=>$product->id,
//                'position' => count(Products::all())
//                ]);
            $product->slug = $product->generateSlug($product->name);

            $product->save();
        });
    }
    private function generateSlug($name)
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'id_product', 'id_category');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'products_id', 'id');
    }

    public function sku()
    {
        return $this->hasOne(ProductSKU::class, 'products_id', 'id');
    }

    public function stockApi()
    {
        return $this->hasMany(Stock::class, 'products_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(Product_image::class, 'products_id');
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class, 'products_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id')
            ->with('attributeValues');
    }
}
