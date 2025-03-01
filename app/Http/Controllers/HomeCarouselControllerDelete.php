<?php

namespace App\Http\Controllers;

use App\Models\HomeCarousel;
use App\Models\HomeComponent;
use App\Models\HomeComponentMain;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeCarouselControllerDelete extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeCarousels = HomeCarousel::latest()->orderBy('id', 'DESC')->paginate(10);
        $interval = Setting::where('key','=', 'homecarousel_interval')->orderBy('id','DESC')->first();

        return view('homecarousel.index', compact(['homeCarousels','interval']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('homecarousel.create');
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
            'image' => 'required',
            'link' => 'required',
        ]);

        $src = null;

        if($request->has('image')){
            $image = $request->file('image');
            $imageName = 'homecarousel-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homecarousel/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homecarousel/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        }

        HomeCarousel::updateOrCreate([
            'title' => $request->title,
            'image' => $src,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->route('homecarousel.index')->with('message', 'Home Page Carousel Created Successfully');
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
     * Display the specified resource.
     *
     * @param  \App\Models\HomeCarousel  $homeCarousel
     * @return \Illuminate\Http\Response
     */
    public function show(HomeCarousel $homeCarousel)
    {
        return view('homecarousel.show', compact('homeCarousel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeCarousel  $homeCarousel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homeCarousel = HomeCarousel::find($id);
        return view('homecarousel.edit', compact('homeCarousel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeCarousel  $homeCarousel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'link' => 'required',
        ]);

        $src = null;
        $homeCarousel = HomeCarousel::find($id);
        if($request->has('image')){
            $image = $request->file('image');
            $slug = self::transform_slug($id);
            $imageName = $slug . '-homecarousel-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homecarousel/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homecarousel/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        } else $src = $homeCarousel->image;

        $homeCarousel->update([
            'title' => $request->title,
            'image' => $src,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->route('homecarousel.index')->with('message', 'Home Page Carousel Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeCarousel  $homeCarousel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homeCarousel = HomeCarousel::find($id);
        $homeCarousel->delete();
        return redirect()->route('homecarousel.index')->with('message', 'Home Page Carousel Deleted Successfully');
    }
}
