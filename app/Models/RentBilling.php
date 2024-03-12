<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_email',
        'monthly_rent',
        'balance',
        'last_payment_date',
        'last_payment_amount',
    ];
}
