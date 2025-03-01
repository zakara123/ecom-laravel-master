<?php

namespace App\Http\Controllers;

use App\Models\HeaderMenu;
use App\Models\HeaderMenuColor;
use Illuminate\Http\Request;

class HeaderMenuController extends Controller
{



    public function updateOrder(Request $request)
    {
        // Check the order received
        // dd($request->input('order'));
    
        // Assuming 'order' is an array like [1, 2, 3, 4]
        $order = $request->input('order');
    
        // Loop through the order and update the position in the database
        foreach ($order as $position => $id) {
            HeaderMenu::where('id', $id)->update(['position' => $position + 1]); // Update position (use +1 for 1-based indexing)
        }
    
        return response()->json(['success' => true]);
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        //        dd($headerMenuColor);
        return view('headermenu.index', compact(['headerMenus', 'headerMenuColor']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentMenu = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        return view('headermenu.create', compact('parentMenu'));
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
            'title' => 'required',
            'parent' => 'required|integer',
        ]);

        $headerMenu = HeaderMenu::updateOrCreate([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'parent' => $request->input('parent'),
        ]);
        if (empty($headerMenu->position)) $headerMenu->position = 0;

        $lowerPriorityHeaderMenus = HeaderMenu::where('parent', $headerMenu->parent)
            ->where('position', '>=', $headerMenu->position)
            ->get();

        foreach ($lowerPriorityHeaderMenus as $lowerPriorityHeaderMenu) {
            $lowerPriorityHeaderMenu->position++;
            $lowerPriorityHeaderMenu->save();
        }

        return redirect()->route('headermenu.index')->with('message', 'Header menu Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return \Illuminate\Http\Response
     */
    public function show(HeaderMenu $headerMenu)
    {
        return view('headermenu.show', compact('headerMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parentMenu = HeaderMenu::where('parent', 0)->orderBy('position', 'asc')->get();
        $headerMenu = HeaderMenu::find($id);
        return view('headermenu.edit', compact(['headerMenu', 'parentMenu']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'parent' => 'required|integer',
        ]);
        $headerMenu = HeaderMenu::find($id);
        $headerMenu->update([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'parent' => $request->input('parent'),
        ]);
        if (is_null($headerMenu->position)) {
            $headerMenu->position = HeaderMenu::where('parent', $headerMenu->parent)->max('position');
        }

        if ($headerMenu->getOriginal('position') > $headerMenu->position) {
            $positionRange = [
                $headerMenu->position,
                $headerMenu->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $headerMenu->getOriginal('position'),
                $headerMenu->position
            ];
        }

        $lowerPriorityHeaderMenus = HeaderMenu::where('parent', $headerMenu->parent)
            ->whereBetween('position', $positionRange)
            ->where('id', '!=', $headerMenu->id)
            ->get();

        foreach ($lowerPriorityHeaderMenus as $lowerPriorityHeaderMenu) {
            if ($headerMenu->getOriginal('position') < $headerMenu->position) {
                $lowerPriorityHeaderMenu->position--;
            } else {
                $lowerPriorityHeaderMenu->position++;
            }
            $lowerPriorityHeaderMenu->save();
        }
        return redirect()->route('headermenu.index')->with('message', 'Header menu Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeaderMenu  $headerMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $headerMenu = HeaderMenu::find($id);
        $headerMenu->delete();
        return redirect()->route('headermenu.index')->with('message', 'Header Menu Deleted Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeaderMenuColor  $headerMenuColor
     * @return \Illuminate\Http\Response
     */
    public function updateHeaderColor(Request $request, $id)
    {
        //        dd();header_color
        //        dd($request->all());
        $headerMenuColor = HeaderMenuColor::find($id);
        $headerMenuColor->update($request->all());
        return redirect()->route('headermenu.index')->with('The Header color successfully updated');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeaderMenuColor  $headerMenuColor
     * @return \Illuminate\Http\Response
     */
    public function createHeaderColor(Request $request)
    {
        HeaderMenuColor::create($request->all());
        return redirect()->route('headermenu.index')->with('The Header color successfully added');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeaderMenuColor  $headerMenuColor
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(Request $request)
    {
        dd($request->all());
        HeaderMenuColor::updateOrCreate($request->all());
        return redirect()->route('headermenu.index')->with('The Header color successfully added');
    }
}
