<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\Products;
use App\Models\ProductVariationAttribute;
use App\Models\ProductVariationImages;
use App\Models\ProductVariationThumbnail;
use App\Services\AttributeService;
use App\Services\ProductVariationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductVariationController extends Controller
{
    public function index($productId)
    {
        $product = Products::with('attributes.attributeValues')->find($productId);

        $variations = ProductVariation::with(['attributes.attributeValues', 'imagesVariation', 'variationThumbnail'])
            ->where('products_id', $productId)
            ->paginate(10);
        $allAttributes = Attribute::with('attributeValues')->get();
        $attributes = $product->attributes;

        return view('variation.index', compact('product', 'variations', 'attributes', 'allAttributes'));
    }

    public function index1_delete($id_product)
    {
        $products = Products::find($id_product);
        $attributes = DB::table('attributes')->get();
        foreach ($attributes as $key => $attribute) {
            $attribute = (array) $attribute;
            $attribute['attribute_value'] = AttributeValue::where('attribute_id', $attribute['id'])->get();
            $attribute = (object) $attribute;
            $attributes[$key] = $attribute;
        }

        $product_variation = DB::table('product_variations')->where('products_id', $id_product)->get();
        foreach ($product_variation as $key1 => $variation) {
            $variation = (array) $variation;
            $variation_value = json_decode($variation['variation_value']);
            $variation['variation_value'] = AttributeService::getVariationValues($variation_value);
            $variationImg = ProductVariation::find($variation['id']);
            $images = array();
            if (!empty($variationImg->imagesVariation)) $images =  $variationImg->imagesVariation;
            $variation['images'] = $images;
            $variation = (object) $variation;
            $product_variation[$key1] = $variation;
        }
        return view('variation.index2', compact(['products', 'product_variation', 'attributes']));
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
        
        try {
            $this->validate($request, [
                'products_id' => 'required'
            ]);

            $data = $request->all();
            $isRequiredAttributeNull = false;

            // Retrieve the product's required attribute IDs from ProductAttribute table
            $productAttributes = ProductAttribute::where('product_id', $request->products_id)
                ->pluck('attribute_id')
                ->toArray();

            $attributes = [];
            foreach ($data as $key => $value) {
                if (!in_array($key, ["_token", "_method", "id", "products_id", "price", "price_buying", "item_variation_image"])) {
                    if (in_array($key, $productAttributes)) {
                        if (empty($value)) {
                            $isRequiredAttributeNull = true;
                            break;
                        } else {
                            $attributes[$key] = (int)$value;
                        }
                    }
                }
            }

            if ($isRequiredAttributeNull) {
                return response()->json(['success' => false, 'message' => 'Please select a value for all required attributes.'], 400);
            }

            // Validate for existing variations with the given attributes
            ProductVariationService::validateExistingVariationsByProductId($request->products_id, $attributes);

            // Save the new variation
            $variation = ProductVariation::create([
                'products_id' => $request->products_id,
                'price' => $request->price ?? 0,
                'price_buying' => $request->price_buying ?? 0,
                'position' => null,
            ]);

            // Insert attribute values for the variation
            foreach ($attributes as $attributeId => $attributeValueId) {
                DB::table('product_variation_attributes')->insert([
                    'product_variation_id' => $variation->id,
                    'attribute_id' => $attributeId,
                    'attribute_value_id' => $attributeValueId
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Variation created successfully']);
        } catch (\Exception $ex) {
            // Log the error and return a generic error message
            \Log::error('Error creating product variation: ' . $ex->getMessage());

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // Fetch the product variation by ID
        $product_variation = ProductVariation::with(['attributes.attributeValues', 'imagesVariation', 'variationThumbnail'])->findOrFail($id);

        // Retrieve images associated with the variation
        $images = isset($product_variation->imagesVariation) ? $product_variation->imagesVariation : [];
        $thumbnail = isset($product_variation->variationThumbnail) ? $product_variation->variationThumbnail : null;

        // Fetch the associated product
        $product = Products::with('attributes.attributeValues')->find($product_variation->products_id);

        // Fetch the attributes for the product variation
        $product_variation->attributes = ProductVariationAttribute::where('product_variation_id', $product_variation->id)
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

        // Generate readable product variations
        $readable_product_variations = [];
        foreach ($product_variation->attributes as $attribute) {
            $readable_product_variations[] = "{$attribute['attribute']}: {$attribute['attribute_value']}";
        }
        $product_variation->readable_product_variations = implode(' | ', $readable_product_variations);

        // Fetch all attributes with their associated values
        $attributes = $product->attributes;

        // Return the view with the required data
        return view('variation.edit', compact('product', 'product_variation', 'attributes', 'images', 'thumbnail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'products_id' => 'required'
            ]);

            $isRequiredAttributeNull = false;
            $data = $request->all();
            $productVariationImageData = [];
            $uploadedImages = [];
            $uploadedThumbnail = null;

            // Retrieve the product's attributes from the ProductAttribute table
            $productAttributes = ProductAttribute::where('product_id', $request->products_id)
                ->pluck('attribute_id')
                ->toArray();

            $attributes = [];
            foreach ($data as $key => $value) {
                if ($key != "_token" && $key != "_method" && $key != "id" && $key != "products_id" && $key != "price" && $key != "price_buying" && $key != "item_variation_image" && $key != "thumbnail_image") {
                    if (in_array($key, $productAttributes)) {
                        if (empty($value)) {
                            $isRequiredAttributeNull = true;
                            break;
                        } else {
                            $attributes[$key] = (int)$value;
                        }
                    }
                }
            }

            if ($isRequiredAttributeNull) {
                return response()->json(['success' => false, 'message' => 'Please select value for all variation types'], 400);
            }

            // Retrieve the current attributes for comparison
            $currentAttributes = DB::table('product_variation_attributes')
                ->where('product_variation_id', $id)
                ->pluck('attribute_value_id', 'attribute_id')
                ->toArray();

            // Check if attributes have changed
            $attributesChanged = $attributes != $currentAttributes;

            if ($attributesChanged) {
                // Validate only if attributes have changed
                ProductVariationService::validateExistingVariationsByProductId($request->products_id, $attributes);
            }

            // Update the existing variation
            $product_variation = ProductVariation::find($id);
            $product_variation->update([
                'price' => !empty($request->price) ? $request->price : 0,
                'price_buying' => !empty($request->price_buying) ? $request->price_buying : 0
            ]);

            if ($attributesChanged) {
                // Update the product variation attributes
                DB::table('product_variation_attributes')->where('product_variation_id', $id)->delete();

                foreach ($attributes as $attributeId => $attributeValueId) {
                    DB::table('product_variation_attributes')->insert([
                        'product_variation_id' => $id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $attributeValueId
                    ]);
                }
            }

            // Handle image uploads
            if (!empty($request->item_variation_image)) {
                ProductVariationImages::where('product_variation_id', $id)->delete();

                $productImages = explode(',', $request->item_variation_image);

                foreach ($productImages as $prodImg) {
                    $prodImgD = \App\Models\File::findOrFail($prodImg);
                    ProductVariationImages::create([
                        'product_variation_id' => $id,
                        'file_id' => $prodImgD->id,
                        'name' => $prodImgD->title,
                        'src' => $prodImgD->url
                    ]);
                }
            }

            // Handle thumbnail image upload
            if (!empty($request->thumbnail_image)) {
                ProductVariationThumbnail::where('product_variation_id', $id)->delete();

                $productImages = explode(',', $request->thumbnail_image);

                foreach ($productImages as $prodImg) {
                    $prodImgD = \App\Models\File::findOrFail($prodImg);
                    ProductVariationThumbnail::create([
                        'product_variation_id' => $id,
                        'file_id' => $prodImgD->id,
                        'src' => $prodImgD->url
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Variation updated successfully',
                'images' => $uploadedImages,
                'thumbnail' => $uploadedThumbnail
            ], 200);
        } catch (\Exception $ex) {
            // Log the error and return a generic error message
            \Log::error('Error updating product variation: ' . $ex->getMessage());

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_variation = ProductVariation::find($id);
        $product_variation->delete();
        return redirect()->back()->with('success', 'Variation deleted successfully');
    }

    public function destroy_variation_image($id)
    {
        $product_variation = ProductVariationImages::find($id);
        $product_variation->delete();
        return redirect()->back()->with('success', 'Variation image deleted successfully');
    }

    public function updateImage($id)
    {
        $image = ProductVariationImages::findOrFail($id);
        $image->touch(); // Updates the `updated_at` timestamp
        return redirect()->back()->with('success', 'Variation image place changed successfully');
    }
}
