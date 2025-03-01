<?php

namespace App\Http\Controllers;

use App\Models\HomeComponent;
use App\Models\HomeComponentMain;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomePageComponentController extends Controller
{
    public function homepage_component()
    {
        $homeCarousels = HomeComponentMain::latest()->orderBy('id', 'DESC')->paginate(10);
        $interval = Setting::where('key','=', 'homecarousel_interval')->orderBy('id','DESC')->first();

        return view('homecomponent.index', compact(['homeCarousels','interval']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_slider($id)
    {
        $id = $id;
        return view('homecomponent.create', compact(['id']));
    }
    public function create_collection($id)
    {
        $id = $id;
        return view('homecomponent.create_collection', compact(['id']));
    }
    public function store_slider_main(Request $request){
        HomeComponentMain::updateOrCreate([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'position'=>$request->position,
        ]);

        return redirect()->route('homepage_components')->with('message', 'Home Page '.$request->type.' Created Successfully');
    }
    public function store_slider(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            //'link' => 'required',
            //'title'=>'required',
        ]);

        $src = null;

        if($request->has('image')){
            $image = $request->file('image');
            $imageName = 'homeslider-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homeslider/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homeslider/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        }

        HomeComponent::updateOrCreate([
            'title' => $request->title,
            'image' => $src,
            'slider_id'=>$request->slider_id,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        $url = ['reload' => route('slider_list', ['id' => $request->slider_id])];
        die(json_encode($url));

        // Assuming $slide->id is the ID you want to pass to the route
        return redirect()->route('slider_list', ['id' => $request->slider_id])->with('message', 'Home Page Slides Created Successfully');
    }

    public function store_collection(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            // 'link' => 'required',
            // 'title'=>'required',
        ]);

        $src = null;

        if($request->has('image')){
            $image = $request->file('image');
            $imageName = 'homeslider-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homeslider/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homeslider/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        }

        HomeComponent::updateOrCreate([
            'title' => $request->title,
            'image' => $src,
            'slider_id'=>$request->slider_id,
            'description' => $request->description,
            'link' => $request->link,
            'width'=>$request->width
        ]);
        $url = ['reload' => route('collection_list', ['id' => $request->slider_id])];
        die(json_encode($url));

        // Assuming $slide->id is the ID you want to pass to the route
        return redirect()->route('collection_list', ['id' => $request->slider_id])->with('message', 'Home Page Collection Created Successfully');
    }
    public function slider_list($id)
    {

        $id = $id;
        $homeCarousels = HomeComponent::where('slider_id',$id)->latest()->orderBy('id', 'DESC')->paginate(100000);
        $mainComponent = HomeComponentMain::where('id',$id)->first();

        return view('homecomponent.sliderlist', compact(['homeCarousels','id','mainComponent']));
    }

    public function collection_list($id)
    {

        $id = $id;
        $homeCarousels = HomeComponent::where('slider_id',$id)->latest()->orderBy('id', 'DESC')->paginate(100000);

        $mainComponent = HomeComponentMain::where('id',$id)->first();

        return view('homecomponent.collectionlist', compact(['homeCarousels','id','mainComponent']));
    }

    public function edit_slider($id)
    {
        $homeCarousel = HomeComponent::find($id);
        return view('homecomponent.edit', compact('homeCarousel'));
    }

    public function edit_collection($id)
    {
        $homeCarousel = HomeComponent::find($id);
        return view('homecomponent.edit_collection', compact('homeCarousel'));
    }

    public function destroy_slides($id)
    {
        $homeCarousel = HomeComponent::find($id);
        $homeCarousel->delete();
        $main_component = $homeCarousel->id;
        return redirect()->route('slider_list', ['id' => $main_component])->with('message', 'Home Page Slide Deleted Successfully');

    }


    public function destroy_collection($id)
    {
        $homeCarousel = HomeComponent::find($id);

        $main_component = $homeCarousel->slider_id;
        $homeCarousel->delete();
        return redirect()->route('collection_list', ['id' => $main_component])->with('message', 'Home Page Collection Deleted Successfully');

    }

    public function destroy_slider($id)
    {
        $homeCarousel = HomeComponent::find($id);

        $main_component = $homeCarousel->slider_id;
        $homeCarousel->delete();
        return redirect()->route('slider_list', ['id' => $main_component])->with('message', 'Home Page Collection Deleted Successfully');

    }


    public function destroy_component($id)
    {
        $homeCarousel = HomeComponentMain::find($id);
        $homeCarousel->delete();
        return redirect()->route('homepage_components')->with('message', 'Home Page Component Deleted Successfully');

    }
    public function update_slider(Request $request, $id)
    {

        $src = null;
        $homeCarousel = HomeComponent::find($id);
        if($request->has('image')){
            $image = $request->file('image');
            $slug = self::transform_slug($id);
            $imageName = $slug . '-homeslider-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homeslider/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homeslider/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        } else $src = $homeCarousel->image;

        $homeCarousel->update([
            'title' => $request->title,
            'image' => $src,
            'description' => $request->description,
            'link' => $request->link,
        ]);
        $url = ['reload' => route('slider_list', ['id' => $homeCarousel->slider_id])];
        die(json_encode($url));

        //return redirect()->route('homepage_components')->with('message', 'Home Page Slider Updated Successfully');
        // Assuming $slide->id is the ID you want to pass to the route
        return redirect()->route('slider_list', ['id' => $homeCarousel->slider_id])->with('message', 'Home Page Slides Updated Successfully');
    }

    public function update_collection(Request $request, $id)
    {
        $src = null;
        $homeCarousel = HomeComponent::find($id);
        if($request->has('image')){
            $image = $request->file('image');
            $slug = self::transform_slug($id);
            $imageName = $slug . '-homeslider-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homeslider/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homeslider/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

        } else $src = $homeCarousel->image;

        $homeCarousel->update([
            'title' => $request->title,
            'image' => $src,
            'description' => $request->description,
            'link' => $request->link,
            'width' => $request->width,
        ]);

        $url = ['reload' => route('collection_list', ['id' => $homeCarousel->slider_id])];
        die(json_encode($url));

        //return redirect()->route('homepage_components')->with('message', 'Home Page Slider Updated Successfully');
        // Assuming $slide->id is the ID you want to pass to the route
        return redirect()->route('collection_list', ['id' => $homeCarousel->slider_id])->with('message', 'Home Page Collection Updated Successfully');

    }

    public function update_slider_main(Request $request, $id)
    {
        $this->validate($request, [
            //  'title' => 'required',
        ]);

        $homeCarousel = HomeComponentMain::find($id);
        $homeCarousel->update([
            'title' => $request->title,
            'description' => $request->description,
            'position'=>$request->position
        ]);
        if($homeCarousel->type == 'slider'){
            return redirect()->route('slider_list', ['id' => $homeCarousel->id])->with('message', 'Home Page Slides Updated Successfully');
        }else{
            return redirect()->route('collection_list', ['id' => $homeCarousel->id])->with('message', 'Home Page Collection Updated Successfully');
        }

    }

    public function upload_image(Request $request){
        if($request->has('file')){
            $image = $request->file('file');
            $imageName = 'homeslider-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/homeslider/'. str_replace(':','_',str_replace('.','__',request()->getHttpHost()))),$imageName);
            $src = '/files/homeslider/'.str_replace(':','_',str_replace('.','__',request()->getHttpHost())).'/'. $imageName;

            //return  json_encode(['location' => '/' . $src]);
            return response()->json(['location' => $src]);

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

    public function interval(Request $request){
        $interval = Setting::find($request->id);

        if(!$interval) {
            Setting::updateOrCreate([
                'key' => 'homecarousel_interval',
                'value'  => $request->interval
            ]);
        }else{
            $interval->update([
                'value'=>  $request->interval
            ]);

        }

        return redirect()->to('/homepage-components')->with('success', 'Home Page Carousel Items Interval Added/Updated Successfully');
    }
}
