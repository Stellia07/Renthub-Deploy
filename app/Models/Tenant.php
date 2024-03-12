<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_name', 'property_price', 'owner_name', 'owner_email', 'tenant_email', 'status',
    ];

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
}
