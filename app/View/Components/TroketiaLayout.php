<?php

namespace App\View\Components;

use App\Models\Cart;
use App\Models\Company;
use App\Models\Setting;
use App\Models\HeaderMenu;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;

class TroketiaLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $company = Company::latest()->first();
        $shop_favicon = url('files/logo/ecom-logo.png');
        if (Setting::where("key","store_favicon")->first()){
            $shop_favicon_db = Setting::where("key","store_favicon")->first();
            $shop_favicon = $shop_favicon_db->value;
        }
        else {
            $company = Company::latest()->first();
            if ($company && !empty($company->logo))
                $shop_favicon =  $company->logo;
        }
        $theme = Setting::where('key', 'store_theme')->value('value') ?? 'default';
        $session_id = Session::get('session_id');
        $carts  = Cart::where("session_id", $session_id)->get();
        $headerMenus = HeaderMenu::get();
        return view('templates.troketia.layouts.troketia',compact(['company','shop_favicon', 'theme', 'carts','headerMenus']));
    }
}
