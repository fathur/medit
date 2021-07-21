<?php

namespace App\Observers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InvoiceObserver
{
    public function creating(Invoice $invoice)
    {
        $invoice->due_at = Carbon::now()->addHours(24);

        $this->generateCode($invoice);
    }


    public function generateCode(Invoice $invoice)
    {
//        $invoiceable = $invoice->invoiceable;
//        $latestCode = $invoiceable->invoice()->max('code');

//        if ($latestCode) {

//            $exploded = Str::of($latestCode)->explode('INV/');
//
//            $numberedLatestCode = (int)$exploded[1];
//            $incrementCode = $numberedLatestCode + 1;
//            $incrementCode = str_pad((string) $incrementCode, 6, '0', STR_PAD_LEFT);
        $incrementCode = Str::random(6);
        $invoice->code = 'INV/' . $incrementCode;
//        } else {
//            $invoice->code = 'INV/000001';
//        }
    }
}
