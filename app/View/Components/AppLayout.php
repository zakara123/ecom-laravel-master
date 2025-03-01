<?php

namespace App\View\Components;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\View\Component;

class AppLayout extends Component
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
        return view('layouts.app',compact(['company','shop_favicon']));
    }
}
