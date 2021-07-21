<?php

namespace App\Observers;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PurchaseObserver
{
    public function creating(Purchase $purchase)
    {
        $company = $purchase->company;
        $latestCode = $company->purchases()->max('code');

        if ($latestCode) {

            $exploded = Str::of($latestCode)->explode('PUR/');

            $numberedLatestCode = (int)$exploded[1];
            $incrementCode = $numberedLatestCode + 1;
            $incrementCode = str_pad((string) $incrementCode, 6, '0', STR_PAD_LEFT);
            $purchase->code = 'PUR/' . $incrementCode;
        } else {
            $purchase->code = 'PUR/000001';
        }

    }

    public function created(Purchase $purchase)
    {
        $purchase->invoice()->create([
            'balance_due' => $purchase->total
        ]);
    }
}
