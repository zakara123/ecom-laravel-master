<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->orderBy('id', 'DESC')->paginate(10);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'tan' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        }

        $src = null;

        if($request->has('company_logo')){
            $image = $request->file('company_logo');

            $slug = self::transform_slug($request->company_name);
            $imageName = $slug . '-logo-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/logo/'. request()->getHttpHost()),$imageName);
            $src = '/files/logo/'.request()->getHttpHost().'/'. $imageName;


        }

        Company::updateOrCreate([
            'company_name' => $request->company_name,
            'company_address'  => $request->company_address,
            'brn_number'  => $request->brn_number,
            'vat_number'  => $request->vat_number,
            'tan'  => $request->tan,
            'company_email'  => $request->company_email,
            'company_phone'  => $request->company_phone,
            'company_fax'  => $request->company_fax,
            'whatsapp_number'  => $request->whatsapp_number,
            'logo'  => $src,
        ]);
        return redirect()->route('company.index')->with('message', 'Company Created Successfully');

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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ebs_mra_einvoincing = Setting::where("key", "ebs_mra_einvoincing")->first();
        if (isset($ebs_mra_einvoincing->value) && $ebs_mra_einvoincing->value == 'On') {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'tan' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'company_name' => 'required',
                'company_address' => 'required',
                'brn_number' => 'required',
                'company_email' => 'required',
                'company_phone' => 'required',
            ]);
        }

        $src = null;

        if($request->has('company_logo')){
            $image = $request->file('company_logo');

            $slug = self::transform_slug($request->company_name);
            $imageName = $slug . '-logo-'. time().rand(1,1000).'.'. $image->extension();
            $image->move(public_path('files/logo/'. request()->getHttpHost()),$imageName);
            $src = '/files/logo/'.request()->getHttpHost().'/'. $imageName;


        }

        $company = Company::find($id);
        $company->update([
            'company_name' => $request->company_name,
            'company_address'  => $request->company_address,
            'brn_number'  => $request->brn_number,
            'vat_number'  => $request->vat_number,
            'tan'  => $request->tan,
            'company_email'  => $request->company_email,
            'company_phone'  => $request->company_phone,
            'company_fax'  => $request->company_fax,
            'whatsapp_number'  => $request->whatsapp_number,
            'logo'  => $src
        ]);

        return redirect()->route('company.index')->with('message', 'Company Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        return redirect()->route('company.index')->with('message', 'Company Deleted Successfully');
    }
}
