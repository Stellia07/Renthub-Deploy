<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RentBilling;

class AddMonthlyRent extends Command
{
    protected $signature = 'rent:add-monthly';
    protected $description = 'Add monthly rent to each tenant\'s balance';

    public function handle()
    {
        $rentBillings = RentBilling::all();
        foreach ($rentBillings as $billing) {
            $billing->balance += $billing->monthly_rent;
            $billing->save();
        }

        $this->info('Monthly rent added to all tenants.');
    }
}

