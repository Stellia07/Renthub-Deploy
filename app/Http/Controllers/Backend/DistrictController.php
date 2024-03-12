<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use Intervention\Image\Facades\Image;

class DistrictController extends Controller
{
    //

    public function AllDistrict(){

        $district = District::latest()->get();
        return view('backend.district.all_district',compact('district'));

    } // End Method 

    public function AddDistrict(){
        return view('backend.district.add_district');
    } // End Method 

    public function StoreDistrict(Request $request){

    $image = $request->file('district_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(370,275)->save('upload/district/'.$name_gen);
    $save_url = 'upload/district/'.$name_gen;

    District::insert([
        'district_name' => $request->district_name,
        'district_image' => $save_url, 
    ]);

     $notification = array(
            'message' => 'District Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.district')->with($notification);

    }// End Method 

    public function EditDistrict($id){

        $district = District::findOrFail($id);
        return view('backend.district.edit_district',compact('district'));

    }// End Method 

    public function UpdateDistrict(Request $request){

    $district_id = $request->id;

    if ($request->file('district_image')) {
    $image = $request->file('district_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(370,275)->save('upload/district/'.$name_gen);
    $save_url = 'upload/district/'.$name_gen;

    District::findOrFail($district_id)->update([
        'district_name' => $request->district_name,
        'district_image' => $save_url, 
    ]);

     $notification = array(
            'message' => 'District Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.dsitrict')->with($notification);

        }else{

       District::findOrFail($district_id)->update([
        'district_name' => $request->district_name, 
    ]);

     $notification = array(
            'message' => 'District Updated without Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.district')->with($notification);

        }

    }// End Method 

    public function DeleteDistrict($id){

        $district = District::findOrFail($id);
        $img = $district->district_image;
        unlink($img);

        District::findOrFail($id)->delete();

         $notification = array(
            'message' => 'District Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method


}
