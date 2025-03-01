<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $attributes = $request->input('product_attributes', []);

        // Delete existing attributes for the product (if any)
        ProductAttribute::where('product_id', $product_id)->delete();

        // Save new attributes
        foreach ($attributes as $attribute_id) {
            ProductAttribute::create([
                'product_id' => $product_id,
                'attribute_id' => $attribute_id,
            ]);
        }

        return redirect()->back()->with('success', 'Attributes assigned successfully.');
    }
}
