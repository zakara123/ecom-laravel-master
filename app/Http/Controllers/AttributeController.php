<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);
        return view('attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categories = Category::orderBy('id','desc')->get();
        return view('attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'attribute_name' => 'required',
            'attribute_type' => 'required',
        ]);

        $slug = self::transform_slug($request->attribute_name);
        $attribute = Attribute::updateOrCreate([
            'attribute_name' => $request->attribute_name,
            'attribute_slug' => $slug,
            'attribute_type' => $request->attribute_type,
           // 'visibility' => $request->visibility,
            'active_filter' => $request->active_filter,
        ]);
        if ($request->has('attribute_value') && !empty($request->attribute_value)) {
            $attribute_value = explode(',',$request->attribute_value);
            foreach ($attribute_value as $key => $value) {
                AttributeValue::updateOrCreate([
                    'attribute_values' => $value,
                    'attribute_id' => $attribute->id,
                ]);
            }

        }

        return redirect()->route('attribute.index')->with('message', 'Attribute Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        return view('attribute.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $attr_value = AttributeValue::where('attribute_id', $attribute->id)->get();
        $i = 0;
        foreach ($attr_value as $v_a){
            if($i < count($attr_value)-1) $attribute->attribute_value .=  $v_a->attribute_values.',';
            else $attribute->attribute_value.=  $v_a->attribute_values;
            $i++;
        }
        return view('attribute.edit', compact('attribute','attr_value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'attribute_name' => 'required',
            'attribute_type' => 'required',
        ]);

        $slug = self::transform_slug($request->attribute_name);
        $attribute = Attribute::find($id);
        $attribute->update([
            'attribute_name' => $request->attribute_name,
            'attribute_slug' => $slug,
            'attribute_type' => $request->attribute_type,
          //  'visibility' => $request->visibility,
            'active_filter' => $request->active_filter,
        ]);
        /* if ($request->has('attribute_value') && !empty($request->attribute_value)) {
            $attr_value = AttributeValue::where('attribute_id', $attribute->id);
            $attr_value->delete();
            $attribute_value = explode(',',$request->attribute_value);
            foreach ($attribute_value as $key => $value) {
                AttributeValue::updateOrCreate([
                    'attribute_values' => $value,
                    'attribute_id' => $attribute->id,
                ]);
            }
        } */

        return redirect()->route('attribute.index')->with('message', 'Attribute updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        $attribute->delete();
        return redirect()->route('attribute.index')->with('message', 'Attribute Deleted Successfully');
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
