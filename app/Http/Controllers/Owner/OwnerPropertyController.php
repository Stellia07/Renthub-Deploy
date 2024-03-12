<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\Risk;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\PackagePlan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PropertyMessage;
use App\Models\Schedule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleMail;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentLog;
use App\Models\ElectricityBilling;
use App\Models\WaterBilling;
use App\Models\RentBilling;

class OwnerPropertyController extends Controller
{
    public function OwnerAllProperty()
    {

        $id = Auth::user()->id;
        $property = Property::where('owner_id', $id)->latest()->get();
        return view('owner.property.all_property', compact('property'));
    }

    public function OwnerAddProperty()
    {

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        $id = Auth::user()->id;
        $property = User::where('role', 'owner')->where('id', $id)->first();
        // $pcount = $property->credit;

        // if ($pcount == 7) {
        //     return redirect()->route('buy.package');
        // } else {

        //     return view('owner.property.add_property', compact('propertytype', 'amenities'));
        // }

        return view('owner.property.add_property', compact('propertytype', 'amenities'));
    } // End Method

    public function OwnerStoreProperty(Request $request)
    {

        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        // $nid = $uid->credit;

        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);
        // dd($amen);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        $valIdImg = $request->file('validId_photo');
        $genName_ID = hexdec(uniqid()) . '.' . $valIdImg->getClientOriginalExtension();
        Image::make($valIdImg)->resize(370, 250)->save('upload/property/valid-id/' . $genName_ID);
        $idImg_url = 'upload/property/valid-id/' . $genName_ID;

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
            'owner_id' => Auth::user()->id,
            'status' => 2,
            'property_thumbnail' => $save_url,
            'validId_photo' => $idImg_url,
            'created_at' => Carbon::now(),

        ]);


        // Multi Image

        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

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
            for ($i = 0; $i < $facilities; $i++) {
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
            for ($i = 0; $i < $risks; $i++) {
                $fcount = new Risk();
                $fcount->property_id = $property_id;
                $fcount->risk_name = $request->risk_name[$i];
                $fcount->save();
            }
            # code...
        }

        // End Risk

        // User::where('id', $id)->update([
        //     'credit' => DB::raw('1+ ' . $nid),
        // ]);


        $notification = array(
            'message' => 'Property Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('owner.all.property')->with($notification);
    } // End Method

    public function OwnerEditProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $risks = Risk::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_amenities = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        return view('owner.property.edit_property', compact('property', 'propertytype', 'amenities', 'property_amenities', 'multiImage', 'facilities', 'risks'));
    } // End Method


    public function OwnerUpdateProperty(Request $request)
    {

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
            'owner_id' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('owner.all.property')->with($notification);
    } // End Method


    public function OwnerUpdatePropertyThumbnail(Request $request)
    {

        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

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

    public function OwnerUpdatePropertyMultiimage(Request $request)
    {

        $imgs = $request->multi_img;

        foreach ($imgs as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::where('id', $id)->update([

                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),

            ]);
        } // End Foreach 


        $notification = array(
            'message' => 'Property Multi Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }    // End Method 


    public function OwnerPropertyMultiimageDelete($id)
    {

        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function OwnerStoreNewMultiimage(Request $request)
    {

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
        $uploadPath = 'upload/property/multi-image/' . $make_name;

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
    } // End Method 


    public function OwnerUpdatePropertyFacility(Request $request)
    {

        $pid = $request->id;

        if ($request->facility_name == NULL) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $pid)->delete();

            $facilities = Count($request->facility_name);

            for ($i = 0; $i < $facilities; $i++) {
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
    } // End Method 


    public function OwnerUpdatePropertyRisks(Request $request)
    {

        $pid = $request->id;

        if ($request->risk_name == NULL) {
            return redirect()->back();
        } else {
            Risk::where('property_id', $pid)->delete();

            $risks = Count($request->risk_name);

            for ($i = 0; $i < $risks; $i++) {
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
    } // End Method 

    public function OwnerDetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();

        return view('owner.property.details_property', compact('property', 'propertytype', 'amenities', 'property_ami', 'multiImage', 'facilities'));
    } // End Method 


    public function OwnerDeleteProperty($id)
    {

        $property = Property::findOrFail($id);
        unlink($property->property_thumbnail);

        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id', $id)->get();

        foreach ($image as $img) {
            unlink($img->photo_name);
            MultiImage::where('property_id', $id)->delete();
        }

        $facilitiesData = Facility::where('property_id', $id)->get();
        foreach ($facilitiesData as $item) {
            $item->facility_name;
            Facility::where('property_id', $id)->delete();
        }


        $notification = array(
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method  


    public function BuyPackage()
    {

        return view('owner.package.buy_package');
    } // End Method  

    public function BuyBusinessPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('owner.package.business_plan', compact('data'));
    } // End Method  

    public function StoreBusinessPlan(Request $request)
    {

        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Business',
            'package_credits' => '3',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '599',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('3 + ' . $nid),
        ]);

        $notification = array(
            'message' => 'You have purchase Basic Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('owner.all.property')->with($notification);
    } // End Method 


    public function BuyProfessionalPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('owner.package.professional_plan', compact('data'));
    } // End Method  

    public function StoreProfessionalPlan(Request $request)
    {

        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->credit;

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Professional',
            'package_credits' => '10',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '1999',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('10 + ' . $nid),
        ]);



        $notification = array(
            'message' => 'You have purchase Professional Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('owner.all.property')->with($notification);
    } // End Method 


    public function PackageHistory()
    {

        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id', $id)->get();
        return view('owner.package.package_history', compact('packagehistory'));
    } // End Method 

    public function OwnerPackageInvoice($id)
    {

        $packagehistory = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('owner.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    } // End Method 

    public function OwnerPropertyMessage()
    {

        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('owner_id', $id)->get();
        return view('owner.message.all_message', compact('usermsg'));
    } // End Method  

    public function OwnerMessageDetails($id)
    {

        $uid = Auth::user()->id;
        $usermsg = PropertyMessage::where('owner_id', $uid)->get();

        $msgdetails = PropertyMessage::findOrFail($id);
        return view('owner.message.message_details', compact('usermsg', 'msgdetails'));
    } // End Method  

    public function OwnerScheduleRequest()
    {

        $id = Auth::user()->id;
        $usermsg = Schedule::where('owner_id', $id)->get();
        return view('owner.schedule.schedule_request', compact('usermsg'));
    } // End Method  

    public function OwnerDetailsSchedule($id)
    {

        $schedule = Schedule::findOrFail($id);
        return view('owner.schedule.schedule_details', compact('schedule'));
    } // End Method 

    public function OwnerUpdateSchedule(Request $request)
    {

        $sid = $request->id;

        Schedule::findOrFail($sid)->update([
            'status' => '1',

        ]);

        //// Start Send Email 

        $sendmail = Schedule::findOrFail($sid);

        $data = [
            'tour_date' => $sendmail->tour_date,
            'tour_time' => $sendmail->tour_time,
        ];

        Mail::to($request->email)->send(new ScheduleMail($data));


        /// End Send Email 

        $notification = array(
            'message' => 'Schedule Confirmed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('owner.schedule.request')->with($notification);
    } // End Method 
    public function OwnerTenantRequest()
    {
        $userEmail = Auth::user()->email;
        $tenants = Tenant::where('owner_email', $userEmail)->get();
        return view('owner.managetenants.tenant_request', compact('tenants'));
    }

    public function OwnerTenantmanager()
    {
        $ownerEmail = Auth::user()->email; // Get the currently logged-in owner's email
        $tenants = Tenant::where('owner_email', $ownerEmail)->where('status', 'accepted')->get(); // Get only accepted tenants for this owner

        return view('owner.managetenants.tenant_manager', compact('tenants')); // Pass the tenants to the view
    }


    public function showTenants()
    {
        $tenants = Tenant::all();
        return view('owner.tenants', compact('tenants'));
    }

    public function acceptTenant(Tenant $tenant)
    {
        try {
            $tenant->update(['status' => 'accepted']);
            return back()->with('success', 'Tenant request accepted.');
        } catch (\Exception $e) {
            Log::error('Error accepting tenant: ' . $e->getMessage());
            return back()->with('error', 'Error accepting tenant.');
        }
    }

    public function rejectTenant(Tenant $tenant)
    {
        try {
            $tenant->update(['status' => 'rejected']);
            return back()->with('success', 'Tenant request rejected.');
        } catch (\Exception $e) {
            Log::error('Error rejecting tenant: ' . $e->getMessage());
            return back()->with('error', 'Error rejecting tenant.');
        }
    }

    // In app/Http/Controllers/BillingController.php
    public function updateBilling(Request $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $electricityBilling = $tenant->electricityBilling;

            // Adjusted validation rules
            $validatedData = $request->validate([
                'new_reading' => [
                    'nullable', 'numeric',
                    function ($attribute, $value, $fail) use ($electricityBilling) {
                        if (!is_null($value) && $value < $electricityBilling->previous_reading) {
                            $fail('The new reading must be greater than the previous reading.');
                        }
                    },
                ],
                'payment' => 'nullable|numeric',
            ]);

            // Only process new_reading if it's not null
            if ($new_reading = $validatedData['new_reading']) {
                $usage = $new_reading - $electricityBilling->previous_reading;
                $amount_due = $usage * $electricityBilling->price_per_unit;
                $electricityBilling->previous_reading = $new_reading;
                $electricityBilling->amount_due += $amount_due; // Increment the amount due
            }

            // Ensure payment is a number or 0
            $payment = $validatedData['payment'] ?? 0;
            // Adjust the balance based on the payment and possibly new amount_due
            $new_balance = max(($electricityBilling->balance + ($amount_due ?? 0)) - $payment, 0);
            $electricityBilling->balance = $new_balance; // Update with the new balance

            $electricityBilling->save();

            return back()->with('success', 'Electricity billing details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating electricity billing: ' . $e->getMessage());
            return back()->with('error', 'Error updating electricity billing.');
        }
    }


    // In app/Http/Controllers/Owner/OwnerPropertyController.php

    public function updateWaterBilling(Request $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $waterBilling = $tenant->waterBilling; // Assuming there's a waterBilling relationship
    
            // Adjusted validation rules to allow new_water_reading to be nullable
            $validatedData = $request->validate([
                'new_water_reading' => [
                    'nullable', 'numeric',
                    function ($attribute, $value, $fail) use ($waterBilling) {
                        if (!is_null($value) && $value < $waterBilling->previous_reading) {
                            $fail('The new reading must be greater than the previous reading.');
                        }
                    },
                ],
                'water_payment' => 'nullable|numeric',
            ]);
    
            // Initialize amount_due outside the conditional scope
            $amount_due = 0;
    
            // Only process new_water_reading if it's not null
            if ($new_reading = $validatedData['new_water_reading']) {
                $usage = $new_reading - $waterBilling->previous_reading;
                $amount_due = $usage * $waterBilling->price_per_unit;
                $waterBilling->previous_reading = $new_reading;
                $waterBilling->amount_due += $amount_due; // Increment the amount due
            }
    
            // Ensure payment is a number or 0
            $payment = $validatedData['water_payment'] ?? 0;
    
            // Adjust the balance based on the payment and possibly new amount_due
            $new_balance = max(($waterBilling->balance + $amount_due) - $payment, 0);
            $waterBilling->balance = $new_balance; // Update with the new balance
    
            $waterBilling->save();
    
            return back()->with('success', 'Water billing details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating water billing: ' . $e->getMessage());
            return back()->with('error', 'Error updating water billing.');
        }
    }
    
    // In OwnerPropertyController
    public function paymentLogs()
    {
        $userEmail = auth()->user()->email;
        $allPaymentLogs = PaymentLog::all();
        $userPaymentLogs = PaymentLog::where('recipient_email', $userEmail)->get();

        return view('owner.managetenants.payment_logs', compact('allPaymentLogs', 'userPaymentLogs'));
    }
    public function showElectricity()
    {
        $electricityBillings = ElectricityBilling::all();
        return view('tenant.electricity', compact('electricityBillings'));
    }

    public function showWater()
    {
        $waterBillings = WaterBilling::all();
        return view('tenant.water', compact('waterBillings'));
    }
    public function showRentBilling()
    {
        $rentBillings = RentBilling::all();
        return view('tenant.rent', compact('rentBillings'));
    }
}
