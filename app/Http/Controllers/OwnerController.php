<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class OwnerController extends Controller
{
    public function OwnerDashboard() {

        $id = Auth::user()->id;
        $property = Property::where('owner_id', $id)->latest()->get();
        
        return view('owner.index', compact('property'));

    }

    public function OwnerLogin() {

    	return view('owner.owner_login');

    }

    public function OwnerRegister(Request $request){


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::OWNER);

    }// End Method    


    public function OwnerLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = array(
            'message' => 'Owner Logout Successfully',
            'alert-type' => 'success'
        ); 

        return redirect('/owner/login')->with($notification);
    }// End Method 


    public function OwnerProfile() {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('owner.owner_profile_view', compact('profileData'));

    } // End Method

    public function OwnerProfileStore(Request $request) {
        
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/owner_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/owner_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Owner Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function OwnerChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('owner.owner_change_password',compact('profileData'));

    }// End Method 


    public function OwnerUpdatePassword(Request $request){

        // Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'

        ]);

        /// Match The Old Password

        if (!Hash::check($request->old_password, auth::user()->password)) {

           $notification = array(
            'message' => 'Old Password Does not Match!',
            'alert-type' => 'error'
        );

        return back()->with($notification);
        }

        /// Update The New Password 

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);

         $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification); 

     }// End Method 

}
