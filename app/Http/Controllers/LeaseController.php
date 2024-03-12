<?php

// app/Http/Controllers/LeaseController.php

namespace App\Http\Controllers;

use App\Models\LeaseAgreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LeaseController extends Controller
{
    public function create()
    {
        return view('lease-form');
    }
    public function leaseAgreementForm()
    {
        return view('lease_agreement_form'); // The name of your Blade file
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lessor_name' => 'required|string',
            'lessor_address' => 'required|string',
            'lessee_name' => 'required|string',
            'lessee_email' => 'required|string',
            'property_address' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'rent_amount' => 'required|numeric',
            'jurisdiction' => 'required|string',
            // Notice: We don't need to validate 'lessor_signed' and 'lessee_signed' here,
            // as they are boolean and we will be setting them with a default value if not provided.
        ]);

        // Set default values for the checkboxes if they are not present in the request
        $validatedData['lessor_signed'] = $request->has('lessor_signed') ? true : false; // Default to false if not checked
        $validatedData['lessee_signed'] = $request->has('lessee_signed') ? true : false; // Default to false if not checked

        // Create the LeaseAgreement instance and fill with validated data
        $leaseAgreement = new LeaseAgreement($validatedData);
        $leaseAgreement->save();

        // Pass the validatedData only to the tenant_manager view
        return view('lease-agreement', ['data' => $leaseAgreement]);
    }

    
    public function viewContract($email)
    {
        // Hypothetical method to retrieve data based on email
        // This could be a query to your database to get the relevant information
        $data = LeaseAgreement::where('lessee_email', $email)->first();

        // Check if data was successfully retrieved
        if ($data) {
            // Data found, pass it to the view
            return view('lease-agreement', compact('data'));
        } else {
            // No data found, redirect back with an error message
            return back()->withErrors(['message' => 'Data not found for the provided email.']);
        }
    }
    public function myLeaseAgreement()
{
    $userEmail = Auth::user()->email;
    // Assuming the lease agreement's lessee_email or lessee_name column stores the email
    $leaseAgreementData = LeaseAgreement::where('lessee_email', $userEmail)->firstOrFail();

    return view('lease-agreement-tenant', ['data' => $leaseAgreementData]);
}
}
