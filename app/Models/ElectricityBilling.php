<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricityBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_email',
        'overall_usage',
        'previous_reading',
        'new_reading',
        'price_per_unit',
        'amount_due',
        'balance',
    ];
}
