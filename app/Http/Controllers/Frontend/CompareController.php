<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\Risk;
use App\Models\PackagePlan;
use App\Models\Compare; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompareController extends Controller
{
    //

    public function AddToCompare(Request $request, $property_id){

        if(Auth::check()){

            $exists = Compare::where('user_id',Auth::id())->where('property_id',$property_id)->first();

            if (!$exists) {
                Compare::insert([
                'user_id' => Auth::id(),
                'property_id' => $property_id,
                'created_at' => Carbon::now()
                ]);
                return response()->json(['success' => 'Successfully Added On Your Compare List!']);
            }else{
                return response()->json(['error' => 'This Property is Already in your Compare List!']);
            }

        }else{
            return response()->json(['error' => 'Log Into Your Account First!']);
        }


    } // End Method 

    public function UserCompare(){ 

        return view('frontend.dashboard.compare');

    }// End Method 

    public function GetCompareProperty(){

        $compare = Compare::with('property')->where('user_id',Auth::id())->latest()->get(); 

        return response()->json($compare);

    }// End Method 

    public function CompareRemove($id){

      Compare::where('user_id',Auth::id())->where('id',$id)->delete();
      return response()->json(['success' => 'Successfully Property Remove']);

    }// End Method 

}
