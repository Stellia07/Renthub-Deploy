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
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyMessage;  
use Carbon\Carbon;
use App\Models\Schedule; 

class IndexController extends Controller
{
    public function PropertyDetails($id,$slug){


    	$property = Property::findOrFail($id);

    	$amenities = $property->amenities_id;
        $property_amen = explode(',',$amenities);
        $facility = Facility::where('property_id',$id)->get();
        $risk = Risk::where('property_id',$id)->get();
        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id',$type_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(3)->get();

    	$multiImage = MultiImage::where('property_id',$id)->get();
        return view('frontend.property.property_details', compact('property', 'multiImage', 'property_amen', 'facility', 'risk', 'relatedProperty'));

    }// End Method 

    public function PropertyMessage(Request $request){

        $pid = $request->property_id;
        $aid = $request->owner_id;

        if (Auth::check()) {

            PropertyMessage::insert([

                'user_id' => Auth::user()->id,
                'owner_id' => $aid,
                'property_id' => $pid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(), 

            ]);

            $notification = array(
                'message' => 'Message Sent Successfully!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);



        }else{

            $notification = array(
            'message' => 'Please Login to your Account First',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
        }

    }// End Method 

    public function OwnerDetails($id){

        $owner = User::findOrFail($id);
        $property = Property::where('owner_id',$id)->get();
        $featured = Property::where('featured','1')->limit(3)->get();
        $rentproperty = Property::where('property_status','rent')->get();

        return view('frontend.owner.owner_details',compact('owner', 'property', 'featured', 'rentproperty'));

    }// End Method 

    public function OwnerDetailsMessage(Request $request){

        
        $aid = $request->owner_id;

        if (Auth::check()) {

            PropertyMessage::insert([

                'user_id' => Auth::user()->id,
                'owner_id' => $aid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(), 

            ]);

            $notification = array(
                'message' => 'Message Sent Successfully!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);



        }else{

            $notification = array(
            'message' => 'Please Login to your Account First',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
        }

    }// End Method 

    public function RentProperty(){

        $property = Property::where('status','1')->where('property_status','rent')->paginate(5);

        return view('frontend.property.rent_property',compact('property'));

    }// End Method 

    public function PropertyType($id){

        $property = Property::where('status','1')->where('ptype_id',$id)->get();

        $pbread = PropertyType::where('id',$id)->first();

        return view('frontend.property.property_type',compact('property','pbread'));

    }// End Method 

    public function RentPropertySeach(Request $request){

        $request->validate(['search' => 'required']);
        $item = $request->search;
        $barangay = $request->barangay;
        $ptype = $request->ptype_id;

        $property = Property::where('property_name', 'like', '%' . $item . '%')
            ->where('property_status', 'rent')
            ->where('barangay', 'like', '%' . $barangay . '%')
            ->when($ptype, function ($query, $ptype) {
                $query->whereHas('type', function ($q) use ($ptype) {
                    $q->where('type_name', 'like', '%' . $ptype . '%');
                });
            })
            ->get();

        return view('frontend.property.property_search', compact('property'));
    }// End Method 

    public function AllPropertySeach(Request $request)
    {
        $property = Property::where('status', '1')
            ->when($request->ptype_id && $request->ptype_id !== 'All Type', function ($query) use ($request) {
                $query->whereHas('type', function ($q) use ($request) {
                    $q->where('type_name', 'like', '%' . $request->ptype_id . '%');
                });
            })
            ->when($request->furnishing && $request->furnishing !== 'Furnish Status', function ($query) use ($request) {
                $query->where('furnish_status', $request->furnishing);
            })
            ->when($request->barangay && $request->barangay !== 'Select District', function ($query) use ($request) {
                $query->where('barangay', $request->barangay);
            })
            ->when($request->bedrooms && $request->bedrooms !== 'Bedrooms', function ($query) use ($request) {
                $query->where('bedrooms', $request->bedrooms);
            })
            ->when($request->bathrooms && $request->bathrooms !== 'Bathrooms', function ($query) use ($request) {
                $query->where('bathrooms', $request->bathrooms);
            })
            ->where('property_status', 'rent')
            ->paginate(5);

        return view('frontend.property.property_search', compact('property'));
    }

    public function StoreSchedule(Request $request){

        $oid = $request->owner_id;
        $pid = $request->property_id;

        if (Auth::check()) {

            Schedule::insert([

                'user_id' => Auth::user()->id,
                'property_id' => $pid,
                'owner_id' => $oid,
                'tour_date' => $request->tour_date,
                'tour_time' => $request->tour_time,
                'message' => $request->message,
                'created_at' => Carbon::now(), 
            ]);

             $notification = array(
            'message' => 'Tour Schedule Sent Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


        }else{

           $notification = array(
            'message' => 'Login to your Account First',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);

        }

    }// End Method 

}
