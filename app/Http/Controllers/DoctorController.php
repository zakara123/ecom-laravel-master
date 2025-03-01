<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Doctor::latest()->orderBy('id', 'DESC')->paginate(10);
        return view('doctors.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "ggg";exit;
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'type' => 'required',
            'email' => 'email|unique:users',
        ]);
        if($request->type == 'Specialist'){
            $this->validate($request, [
                'specialities' => 'required',
            ]);
        }
        $customer = User::updateOrCreate([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->email,
            'role' => 'doctor',
            //'supplier' => $request->supplier,
            //'id_store' => $request->id_store,
            //'store' => $request->store,
            //'zone' => $request->zone,
            'password' => Hash::make($request->password),
        ]);

        if (is_array($request->languages)) {
            $languagesString = implode(',', $request->languages);
        } else {
            // Handle the case where $request->languages is not an array
            $languagesString = ''; // or handle as appropriate
        }

        if (is_array($request->specialities)) {
            $specialitiesString = implode(',', $request->specialities);
        } else {
            // Handle the case where $request->languages is not an array
            $specialitiesString = ''; // or handle as appropriate
        }

        $doctor = Doctor::updateOrCreate([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type'=>$request->type,
            'nationality'=>$request->nationality,
            'nid_passport_no'=>$request->nid_passport_no,
            'sex'=>$request->sex,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,            
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'village_town' => $request->village_town,
            'languages' => $languagesString,
            'specialities' => $specialitiesString,
            'user_id'=>$customer->id,
            'public_page_status'=>$request->public_page_status,
            'description'=>$request->description,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
            'fee'=>$request->fee,
        ]);
        return redirect()->route('doctor.index')->with('message', 'Doctor Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('doctors.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = Doctor::find($id);
        $user = User::find($doctor->user_id);
        
        return view('doctors.edit', compact('doctor','user'));
    }

    public function doctoPublicPage($id)
    {
        $doctor = Doctor::find($id);
        $user = User::find($doctor->user_id);
        
        return view('front.public_profile_doctor', compact('doctor','user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'type' => 'required',

        ]);
        if($request->type == 'Specialist'){
            $this->validate($request, [
                'specialities' => 'required',
            ]);
        }else{
            $request->specialities = null;
        }

        $doctor = Doctor::find($id);
        if (is_array($request->languages)) {
            $languagesString = implode(',', $request->languages);
        } else {
            // Handle the case where $request->languages is not an array
            $languagesString = ''; // or handle as appropriate
        }

        if (is_array($request->specialities)) {
            $specialitiesString = implode(',', $request->specialities);
        } else {
            // Handle the case where $request->languages is not an array
            $specialitiesString = ''; // or handle as appropriate
        }

        $doctor->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'nationality'=>$request->nationality,
            'nid_passport_no'=>$request->nid_passport_no,
            'sex'=>$request->sex,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,            
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'village_town' => $request->village_town,
            'languages' => $languagesString,
            'specialities' => $specialitiesString,
            'type'=>$request->type,
            'public_page_status'=>$request->public_page_status,
            'description'=>$request->description,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
            'fee'=>$request->fee,
        ]);

        $user = User::find($doctor->user_id);
        $user->update([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->email,
            
            'account_status'=>$request->account_status,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('message', 'Doctor Updated Successfully');
        
        //return redirect()->route('user.index')->with('message', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Doctor::find($id);
        $user->delete();
        return redirect()->route('doctor.index')->with('message', 'Doctor Deleted Successfully');
    }
}
