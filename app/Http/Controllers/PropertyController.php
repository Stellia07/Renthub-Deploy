<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function create()
{
    return view('submit-property');
}

public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_name' => 'required|string|max:255',
            'property_price' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'tenant_email' => 'required|email|max:255',
        ]);

        $property = new Property();
        $property->property_name = $validatedData['property_name'];
        $property->rent_price = $validatedData['property_price']; // Assuming your column is named rent_price
        $property->owner_name = $validatedData['owner_name']; // Make sure you have these fields in your model and database
        $property->owner_email = $validatedData['owner_email'];
        $property->tenant_email = $validatedData['tenant_email'];
        $property->save();

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

}
