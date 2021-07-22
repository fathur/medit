<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    public function creating(Product $product)
    {
        $company = Auth::user()->companies()->first();

        $product->company_id = $company->id;
    }
}
