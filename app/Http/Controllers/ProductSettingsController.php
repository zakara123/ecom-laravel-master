<?php

namespace App\Http\Controllers;

use App\Models\ProductSettings;
use Illuminate\Http\Request;

class ProductSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_settings = ProductSettings::where('name','product_per_page')->first();
        return view('settings.product_settings', compact(['product_settings']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required',
        ]);
        $id = $request->id;
        if ($id != 0){
            $product_setting = ProductSettings::find($id);
            $product_setting->update([
                'value' => $request->value,
            ]);
            return redirect()->route('product-settings')->with('message', 'Product settings updated successfully');
        }
        ProductSettings::create([
            'name' => $request->name,
            'value' => $request->value,
        ]);
        return redirect()->route('product-settings')->with('message', 'Product settings added successfully');
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
}
