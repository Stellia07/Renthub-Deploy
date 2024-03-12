<?php

namespace App\Http\Controllers\Backend;

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
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PropertyMessage;
use App\Models\District;

class PropertyController extends Controller
{
    
	public function AllProperty() {

		$property = Property::latest()->get();
		return view('backend.property.all_property', compact('property'));

	} // End Method

	public function AddProperty() {

		$propertytype = PropertyType::latest()->get();
		$pdistrict = District::latest()->get();
		$amenities = Amenities::latest()->get();
		$activeOwner = User::where('status', 'active')->where('role', 'owner')->latest()->get();

		return view('backend.property.add_property', compact('propertytype', 'amenities', 'activeOwner', 'pdistrict'));

	} // End Method

	public function StoreProperty(Request $request) {

		$amen = $request->amenities_id;
		$amenities = implode(",", $amen);
		// dd($amen);

		$pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC' ]);

		$image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        $valIdImg = $request->file('validId_photo');
        $genName_ID = hexdec(uniqid()).'.'.$valIdImg->getClientOriginalExtension();
        Image::make($valIdImg)->resize(370,250)->save('upload/property/valid-id/'.$genName_ID);
        $idImg_url = 'upload/property/valid-id/'.$genName_ID;

		$property_id = Property::insertGetId([

			'ptype_id' => $request->ptype_id,
			'amenities_id' => $amenities,
			'property_name' => $request->property_name,
			'property_slug' => strtolower(str_replace(' ', '-',  $request->property_name)),
			'property_code' => $pcode,
			'property_status' => 'rent', //$request->property_status
			'furnish_status' => $request->furnish_status,
			'validid_type' => $request->validid_type,

			'rent_price' => $request->rent_price,
			'rent_duration' => $request->rent_duration,
			'short_desc' => $request->short_desc,
			'long_desc' => $request->long_desc,
			'bedrooms' => $request->bedrooms,
			'bathrooms' => $request->bathrooms,
			'garage' => $request->garage,
			'garage_size' => $request->garage_size,

			'property_size' => $request->property_size,
			'property_video' => $request->property_video,
			'address' => $request->address,
			'city' => $request->city,
			'province' => $request->province,
			'postal_code' => $request->postal_code,
			'barangay' => $request->barangay,

			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'featured' => $request->featured,
			'hot' => $request->hot,
			'owner_id' => $request->owner_id,
			'status' => 2,
			'property_thumbnail' => $save_url,
			'validId_photo' => $idImg_url,
			'created_at' => Carbon::now(),

		]);


		// Multi Image

		$images = $request->file('multi_img');
		foreach ($images as $img) {
			$make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
			Image::make($img)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
			$uploadPath = 'upload/property/multi-image/'.$make_name;

			MultiImage::insert([

				'property_id' => $property_id,
				'photo_name' => $uploadPath,
				'created_at' => Carbon::now(),

			]);


		} // End Foreach


		// End Multi Image


		// Facility

		$facilities = Count($request->facility_name);

		if ($facilities != NULL) {
			for ($i=0; $i < $facilities ; $i++) { 
				$fcount = new Facility();
				$fcount->property_id = $property_id;
				$fcount->facility_name = $request->facility_name[$i];
				$fcount->distance = $request->distance[$i];
				$fcount->save();
			}
			# code...
		}

		// End Facility

		// Risk

		$risks = Count($request->risk_name);

		if ($risks != NULL) {
			for ($i=0; $i < $risks ; $i++) { 
				$fcount = new Risk();
				$fcount->property_id = $property_id;
				$fcount->risk_name = $request->risk_name[$i];
				$fcount->save();
			}
			# code...
		}

		// End Risk


		$notification = array(
            'message' => 'Property Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

	} // End Method

	public function EditProperty($id) {

		$facilities = Facility::where('property_id',$id)->get();
		$risks = Risk::where('property_id',$id)->get();
		$property = Property::findOrFail($id);

		$type = $property->amenities_id;
		$property_amenities = explode(',', $type);

		$multiImage = MultiImage::where('property_id',$id)->get();

		$pdistrict = District::latest()->get();
		$propertytype = PropertyType::latest()->get();
		$amenities = Amenities::latest()->get();
		$activeOwner = User::where('status', 'active')->where('role', 'owner')->latest()->get();

		return view('backend.property.edit_property', compact('property', 'propertytype', 'amenities', 'activeOwner', 'property_amenities', 'multiImage', 'facilities', 'risks', 'pdistrict'));


	} // End Method

	public function UpdateProperty(Request $request) {

		$amen = $request->amenities_id;
		$amenities = implode(",", $amen);

		$property_id = $request->id;

		Property::findOrFail($property_id)->update([

			'ptype_id' => $request->ptype_id,
			'amenities_id' => $amenities,
			'property_name' => $request->property_name,
			'property_slug' => strtolower(str_replace(' ', '-',  $request->property_name)),
			// 'property_status' => 'for rent', //$request->property_status
			'furnish_status' => $request->furnish_status,

			'rent_price' => $request->rent_price,
			'rent_duration' => $request->rent_duration,
			'short_desc' => $request->short_desc,
			'long_desc' => $request->long_desc,
			'bedrooms' => $request->bedrooms,
			'bathrooms' => $request->bathrooms,
			'garage' => $request->garage,
			'garage_size' => $request->garage_size,

			'property_size' => $request->property_size,
			'property_video' => $request->property_video,
			'address' => $request->address,
			'city' => $request->city,
			'province' => $request->province,
			'postal_code' => $request->postal_code,
			'barangay' => $request->barangay,

			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'featured' => $request->featured,
			'hot' => $request->hot,
			'owner_id' => $request->owner_id,
			'updated_at' => Carbon::now(),

		]);

		$notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

	} // End Method


	public function UpdatePropertyThumbnail(Request $request) {

		$pro_id = $request->id;
		$oldImage = $request->old_img;

		$image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        if (file_exists($oldImage)) {
        	unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([

        	'property_thumbnail' => $save_url,
        	'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Thumbnail Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


	} // End Method


    public function UpdatePropertyMultiimage(Request $request){

        $imgs = $request->multi_img;

        foreach($imgs as $id => $img){
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

	    $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
	    Image::make($img)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
	        $uploadPath = 'upload/property/multi-image/'.$make_name;

	        MultiImage::where('id',$id)->update([

	            'photo_name' => $uploadPath,
	            'updated_at' => Carbon::now(),

	        ]);

	        } // End Foreach 


	         $notification = array(
	            'message' => 'Property Multi Image Updated Successfully',
	            'alert-type' => 'success'
	        );

	        return redirect()->back()->with($notification); 


    }	// End Method 

    public function PropertyMultiImageDelete($id){

        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method 

    public function StoreNewMultiimage(Request $request){

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

     	$make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
	    Image::make($image)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
	        $uploadPath = 'upload/property/multi-image/'.$make_name;

	        MultiImage::insert([
	            'property_id' => $new_multi,
	            'photo_name' => $uploadPath,
	            'updated_at' => Carbon::now(), 
	        ]);

	    $notification = array(
	            'message' => 'Property Multi Image Added Successfully',
	            'alert-type' => 'success'
	        );

	        return redirect()->back()->with($notification); 
    }// End Method 



    public function UpdatePropertyFacilities(Request $request){

        $pid = $request->id;

        if ($request->facility_name == NULL) {
           return redirect()->back();
        }else{
            Facility::where('property_id',$pid)->delete();

          $facilities = Count($request->facility_name); 

           for ($i=0; $i < $facilities; $i++) { 
               $fcount = new Facility();
               $fcount->property_id = $pid;
               $fcount->facility_name = $request->facility_name[$i];
               $fcount->distance = $request->distance[$i];
               $fcount->save();
           } // end for 
        }

         $notification = array(
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method 


    public function UpdatePropertyRisks(Request $request){

        $pid = $request->id;

        if ($request->risk_name == NULL) {
           return redirect()->back();
        }else{
            Risk::where('property_id',$pid)->delete();

          $risks = Count($request->risk_name); 

           for ($i=0; $i < $risks; $i++) { 
               $fcount = new Risk();
               $fcount->property_id = $pid;
               $fcount->risk_name = $request->risk_name[$i];
               $fcount->save();
           } // end for 
        }

         $notification = array(
            'message' => 'Property Risk Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method 


    public function DeleteProperty($id){

        $property = Property::findOrFail($id);
        unlink($property->property_thumbnail);

        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id',$id)->get();

        foreach($image as $img){
            unlink($img->photo_name);
            MultiImage::where('property_id',$id)->delete();
        }

        $facilitiesData = Facility::where('property_id',$id)->get();
        foreach($facilitiesData as $item){
            $item->facility_name;
            Facility::where('property_id',$id)->delete();
        }


         $notification = array(
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method  


    public function DetailsProperty($id){

        $facilities = Facility::where('property_id',$id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id',$id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeOwner = User::where('status','active')->where('role','owner')->latest()->get();

        return view('backend.property.details_property',compact('property','propertytype','amenities','activeOwner','property_ami','multiImage','facilities'));

    }// End Method 

    public function InactiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([

            'status' => 0,

        ]);

      $notification = array(
            'message' => 'Property Deactivated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification); 


    }// End Method 


     public function ActiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([

            'status' => 1,

        ]);

      $notification = array(
            'message' => 'Property Activated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification); 


    }// End Method 


    public function AdminPackageHistory() {

    	$packagehistory = PackagePlan::latest()->get();
     	return view('backend.package.package_history',compact('packagehistory'));

    }// End Method

    public function PackageInvoice($id){

        $packagehistory = PackagePlan::where('id',$id)->first();

        $pdf = Pdf::loadView('backend.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }// End Method 

    public function AdminPropertyMessage(){

        $usermsg = PropertyMessage::latest()->get();
        return view('backend.message.all_message',compact('usermsg'));

    }// End Method  


}
