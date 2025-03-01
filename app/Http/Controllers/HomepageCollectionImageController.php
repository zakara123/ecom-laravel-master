<?php

namespace App\Http\Controllers;

use App\Models\HomepageCollectionImage;
use Illuminate\Http\Request;


class HomepageCollectionImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        error_reporting(0);
        $homepageCollectionImages = HomepageCollectionImage::latest()->orderBy('id', 'DESC')->paginate(10);

        return view('homecollectionimages.index', compact("homepageCollectionImages"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('homecollectionimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        error_reporting(0);
        $this->validate($request, [
            'image' => 'required',
            'link' => 'required',
        ]);

        $src = null;

        if ($request->has('image')) {
            $image = $request->file('image');
            $imageName = 'homepage-collection-' . time() . rand(1, 1000) . '.' . $image->extension();
            $image->move(public_path('files/homepageCollection/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost()))), $imageName);
            $src = '/files/homepageCollection/' . str_replace(':', '_', str_replace('.', '__', request()->getHttpHost())) . '/' . $imageName;
        }

        HomepageCollectionImage::updateOrCreate([
            'title' => $request->title,
            'image' => $src,
            'width' => $request->width, // Add this line to store the width of the image
            'description' => $request->description,
            'link' => $request->link,
        ]);


        return redirect()->route('home-collection-image.index')->with('message', 'Home Page Collection Created Successfully');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomepageCollectionImage  $homepageCollectionImage
     * @return \Illuminate\Http\Response
     */
    public function show(HomepageCollectionImage $homepageCollectionImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomepageCollectionImage  $homepageCollectionImage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homepageCollectionImage = HomepageCollectionImage::find($id);
        return view('homecollectionimages.edit', compact('homepageCollectionImage'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomepageCollectionImage  $homepageCollectionImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'link' => 'required',
        ]);

        $src = null;
        $homeCarousel = HomepageCollectionImage::find($id);
        if($request->has('image')){
            $image = $request->file('image');
            $slug = self::transform_slug($id);
            $imageName = $slug . 'homepage-collection-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homepageCollection/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homepageCollection/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        } else $src = $homeCarousel->image;

        $homeCarousel->update([
            'title' => $request->title,
            'image' => $src,
            'description' => $request->description,
            'link' => $request->link,
            'width' => $request->width, // Add this line to store the width of the image
        ]);

        return redirect()->route('home-collection-image.index')->with('message', 'Home Page Carousel Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomepageCollectionImage  $homepageCollectionImage
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $HomepageCollectionImage = HomepageCollectionImage::find($id);
        $HomepageCollectionImage->delete();
        return redirect()->route('home-collection-image.index')->with('message', 'Home Page Carousel Deleted Successfully');
    }
}
