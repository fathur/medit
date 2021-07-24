<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerObserver
{
    public function creating(Customer $customer)
    {
        $company = Auth::user()->companies()->first();

        $customer->company_id = $company->id;
    }
}
