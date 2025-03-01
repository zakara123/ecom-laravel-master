<?php

namespace App\Http\Controllers;

use App\Models\Product_image;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_image  $product_image
     * @return \Illuminate\Http\Response
     */
    public function show(Product_image $product_image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_image  $product_image
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_image $product_image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_image  $product_image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_image $product_image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_image  $product_image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_image $product_image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_image  $product_image
     * @return \Illuminate\Http\Response
     */
    public function delete_product_image($id)
    {
        $productImage = Product_image::find($id);
        $id_product = 1;
        if (isset($productImage->products_id) && $productImage->products_id){
            $id_product = $productImage->products_id;
            $productImage->delete();
        }

        return redirect()->route('item.edit', $id_product)->with('message', 'Image deleted Successfully');
    }
}
