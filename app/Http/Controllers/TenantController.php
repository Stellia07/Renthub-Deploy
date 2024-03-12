<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;
use App\Models\Property;  // Add this line at the top with other 'use' statements
use App\Models\User;
use App\Models\ElectricityBilling;
use App\Models\WaterBilling;
use App\Models\RentBilling;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    public function TenantDashboard()
    {
        $userEmail = Auth::user()->email; // Get the currently logged-in user's email
        $tenantInfo = Tenant::where('tenant_email', $userEmail)->first(); // Retrieve tenant information

        return view('tenant.tenant_dashboard', compact('tenantInfo')); // Pass the tenant information to the view
    }
    public function TenantLogout()
    {
        Auth::logout();
        return redirect()->route('login'); // Redirect to the login or home page after logout
    }
    public function TenantProfile()
    {
        $profileData = Auth::user();  // Fetch tenant data
        return view('tenant.tenant_profile', compact('profileData'));
    }

    public function TenantProfileStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules as necessary
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        // Update other fields similarly

        // If there's a photo and you want to allow users to upload it
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/tenant_images/' . $user->photo)); // Remove old photo if exists
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/tenant_images'), $filename);
            $user['photo'] = $filename;
        }

        $user->save();

        // Notification for successful profile update
        $notification = array(
            'message' => 'Tenant Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function TenantChangePassword()
    {
        // Assuming you're using the same authentication guard for all users
        $profileData = Auth::user();
        return view('tenant.tenant_change_password', compact('profileData'));
    }


    public function TenantUpdatePassword(Request $request)
    {
        // Validate input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Check if the old password matches
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            // If old password doesn't match
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        // Update the new password
        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Notification for successful password change
        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );


        return back()->with($notification);
    }


    public function storeTenant(Request $request)
    {
        $request->merge([
            'property_price' => str_replace(',', '', $request->property_price)
        ]);

        $validatedData = $request->validate([
            'property_name' => 'required',
            'property_price' => 'required|numeric',
            'owner_name' => 'required',
            'owner_email' => 'required|email',
            'tenant_email' => 'required|email',
        ]);

        $existingRequest = Tenant::where([
            ['property_name', '=', $validatedData['property_name']],
            ['owner_email', '=', $validatedData['owner_email']],
            ['tenant_email', '=', $validatedData['tenant_email']],
        ])->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'You already have a pending request for this property from the owner.');
        } else {
            Tenant::create($validatedData);

            // Change the role of the currently logged-in user
            $user = Auth::user();
            if ($user && $user->email === $request->tenant_email) {
                $user->role = 'tenant'; // Set the role to 'tenant'
                $user->save(); // Save the changes
                Log::info("User with ID {$user->id} role updated to tenant.");
            }

            return redirect()->route('tenant.dashboard')->with('success', 'Tenant added successfully and your role has been updated!');
        }
    }


    public function showRentalForm($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $user = auth()->user();  // Get the currently logged-in user

        // Check if there's a logged-in user
        if (!$user) {
            // Redirect or handle the case where there is no logged-in user
            return redirect()->route('login')->with('error', 'You need to login first!');
        }

        return view('tenant.rental_form', compact('property', 'user'));
    }
    public function acceptTenant($tenantId)
    {
        // Find the tenant and update their status to 'accepted'
        $tenant = Tenant::findOrFail($tenantId);
        $tenant->status = 'accepted';

        // Create default electricity billing record
        $electricityBilling = new ElectricityBilling([
            'tenant_email' => $tenant->tenant_email,
            // ... other electricity billing properties
        ]);

        // Create default water billing record
        $waterBilling = new WaterBilling([
            'tenant_email' => $tenant->tenant_email,
            // ... other water billing properties
        ]);

        // Create default rent billing record
        $rentBilling = new RentBilling([
            'tenant_email' => $tenant->tenant_email,
            'monthly_rent' => $tenant->property_price, // Assuming 'property_price' is available in the Tenant model
            'balance' => 0,
            'last_payment_date' => null,
            'last_payment_amount' => 0,
        ]);

        // Save the tenant and billing records
        $tenant->save();
        $electricityBilling->save();
        $waterBilling->save();
        $rentBilling->save();

        // Redirect back with a success message
        return back()->with('success', 'Tenant accepted and billing records created.');
    }



    public function rejectTenant($tenantId)
    {
        $tenant = Tenant::find($tenantId);
        $tenant->status = 'rejected';
        $tenant->save();

        return back()->with('success', 'Tenant has been rejected.');
    }
    public function showMyTenantInfo()
    {
        // Get the currently logged-in user's email
        $userEmail = Auth::user()->email;

        // Retrieve the tenant information where tenant_email matches the logged-in user's email
        $tenantInfo = Tenant::where('tenant_email', $userEmail)->first();

        // Pass the tenant information to the view
        return view('tenant.my_info', compact('tenantInfo'));
    }
    public function showTenantManager()
    {
        $ownerEmail = auth()->user()->email;
        $tenants = Tenant::with(['electricityBilling', 'waterBilling', 'rentBilling'])
            ->where('owner_email', $ownerEmail)
            ->where('status', 'accepted')
            ->get();

        return view('owner.tenant_manager', compact('tenants'));
    }
    public function electricityBilling()
    {
        return $this->hasOne(ElectricityBilling::class, 'tenant_email', 'tenant_email');
    }

    public function waterBilling()
    {
        return $this->hasOne(WaterBilling::class, 'tenant_email', 'tenant_email');
    }

    public function rentBilling()
    {
        return $this->hasOne(RentBilling::class, 'tenant_email', 'tenant_email');
    }
    public function updateRentBilling(Request $request, $tenantId)
    {
        $validatedData = $request->validate([
            'rent_payment' => 'nullable|numeric',
        ]);

        $tenant = Tenant::findOrFail($tenantId);
        $rentBilling = $tenant->rentBilling;

        // Ensure rent_payment is a number or 0 if null
        $rent_payment = $validatedData['rent_payment'] ?? 0;

        // Update the rent balance and record the payment only if rent_payment is provided
        if ($rent_payment > 0) {
            $rentBilling->balance = max($rentBilling->balance - $rent_payment, 0);
            $rentBilling->last_payment_date = now();
            $rentBilling->last_payment_amount = $rent_payment;
        }

        $rentBilling->save();

        // Redirect back with a success message
        return back()->with('success', 'Rent payment updated successfully.');
    }

    public function updateTenantStatus($tenantId)
    {
        Log::info("Updating tenant status for tenant ID: $tenantId");
        // Retrieve the tenant record by ID
        $tenant = Tenant::findOrFail($tenantId);

        // Find the user whose email matches the tenant's tenant_email and has the role 'user'
        $user = User::where('email', $tenant->tenant_email)
            ->where('role', 'user')
            ->first();

        if ($user) {
            Log::error("No user found with email: {$tenant->tenant_email}");
            // Update the user's status to 'active'
            $user->status = 'active';
            $user->save();

            // Redirect to the specific URL with a success message
            return redirect('http://127.0.0.1:8000/owner/tenant/manager')
                ->with('success', 'Tenant status updated successfully.');
        } else {
            // Handle the case where the user is not found
            return redirect('google.com')->with('error', 'Associated user not found.');
        }
    }

    public function changeUserStatus($email)
    {
        $user = User::where('email', $email)
            ->where('role', 'user')
            ->first();

        if ($user && $user->status == 'inactive') {
            $user->status = 'active';
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully.');
        }

        return redirect()->back()->with('error', 'User not found or already active.');
    }
}
