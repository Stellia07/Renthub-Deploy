<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test; // Make sure to import your model

class TestController extends Controller
{
    public function create()
    {
        return view('submit-test');
    }

    public function store(Request $request)
    {
        // Validation can be added here as needed

        $test = new Test([
            'description' => 'Rustic Charm Meets Contemporary Comfort',
            'price' => 10000,
            'owner_name' => 'Owner',
            'owner_email' => 'owner@gmail.com',
            'user_email' => 'basicuser1@gmail.com',
        ]);
        $test->save();

        return back()->with('success', 'Test data has been added.');
    }
}
