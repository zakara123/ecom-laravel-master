<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Company;
use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $pages = Page::orderBy('id', 'DESC')->paginate(15);
        return view('pages.index', [
            'pages' => $pages
        ]);
    }

    public function createPage(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('pages.add');
    }

    public function storePage(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required'
            ]);
            $page = new Page();
            $page->title = $request->get('title');
            $page->slug = Str::slug($request->get('title'));
            $page->content = $request->get('content');
            $page->save();

            return redirect()->route('page.edit', $page->id)->with('message', 'Item add Successfully');
        } catch (\Exception $e) {
            return redirect()->route('page.index')->with('message', $e->getMessage());
        }
    }

    public function editPage($id)
    {
        $page = Page::find($id);
        return view('pages.edit', [
            'page' => $page
        ]);
    }

    public function updatePage(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required'
            ]);
            $page = Page::find($id);
            $page->title = $request->get('title');
            $page->slug = Str::slug($request->get('title'));
            $page->content = $request->get('content');
            $page->save();

            return redirect()->route('page.edit', $id)->with('message', 'Item update Successfully');
        } catch (\Exception $e) {
            return redirect()->route('page.index')->with('message', $e->getMessage());
        }
    }

    public function destroyPage($id): \Illuminate\Http\RedirectResponse
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->route('page.index')->with('message', 'Item delete Successfully');
    }

    public function viewPage($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('pages.view', compact([
            'page',
        ]));
    }

    public function viewPage1($slug)
    {
        $page = Page::where('slug', $slug)->first();

        $headerMenus = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        foreach ($headerMenus as &$lowerPriorityHeaderMenu) {
            $children = HeaderMenu::where('parent', $lowerPriorityHeaderMenu->id)->orderBy('position', 'asc')->get();
            foreach ($children as &$item_children) {
                $child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                if (sizeof($child_of_child) > 0) {
                    $item_children->child_of_child = HeaderMenu::where('parent', $item_children->id)->orderBy('position', 'asc')->get();
                    foreach ($item_children->child_of_child as $item_children_child) {
                        $child_of_childrens = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        if (sizeof($child_of_childrens) > 0) {
                            $item_children_child->child_of_childrends = HeaderMenu::where('parent', $item_children_child->id)->orderBy('position', 'asc')->get();
                        }
                    }
                }
            }
            $lowerPriorityHeaderMenu->children = $children;
        }
        $headerMenuColor = HeaderMenuColor::latest()->first();

        $carts = [];

        $session_id = Session::get('session_id');

        if (!empty($session_id)) {
            $carts = Cart::where("session_id", $session_id)->get();
        }
        $company = Company::latest()->first();
        $shop_name = Setting::where("key", "store_name_meta")->first();
        $shop_description = Setting::where("key", "store_description_meta")->first();
        $code_added_header = Setting::where("key", "code_added_header")->first();

        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key", "store_favicon")->first()) {
            $shop_favicon_db = Setting::where("key", "store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        } else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo)) {
                $shop_favicon = $company->logo;
            }
        }

        return view('pages.view', compact([
            'page',
            'headerMenuColor',
            'headerMenus',
            'company',
            'shop_favicon',
            'shop_name',
            'shop_description',
            'carts',
            'code_added_header'
        ]));
    }

    public function imageUpload(Request $request): object
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
            $imagePath = '/images/' . $imageName;

            return response()->json(['location' => url($imagePath)]);
        }
        return response()->json(['error' => 'Image upload failed.'], 400);
    }

    public function ckImageUpload(Request $request)
    {
        try {
//            $image = $request->upload->store('news', 'public');
//            return response()->json([
//                'uploaded' => true,
//                'url' => asset("storage/" . $image)
//            ]);
            $image = $request->file('upload');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
            $imagePath = '/images/' . $imageName;

            return response()->json([
                'uploaded' => true,
                'url' => $imagePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
