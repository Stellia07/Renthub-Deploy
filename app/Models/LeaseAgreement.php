<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseAgreement extends Model
{
    protected $fillable = [
        'lessor_name', 'lessor_address', 'lessee_name', 'lessee_email', 
        'property_address', 'start_date', 'end_date', 'rent_amount', 
        'jurisdiction', 'lessor_signed', 'lessee_signed',
    ];
    

    // The rest of your model...
}
