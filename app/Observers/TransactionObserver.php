<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        $company = Auth::user()->companies()->first();

        $transaction->company_id = $company->id;

        $latestCode = $company->transactions()->max('code');

        if ($latestCode) {
            $exploded = Str::of($latestCode)->explode('TRX/');

            $numberedLatestCode = (int)$exploded[1];
            $incrementCode = $numberedLatestCode + 1;
            $incrementCode = str_pad((string)$incrementCode, 6, '0', STR_PAD_LEFT);
            $transaction->code = 'TRX/' . $incrementCode;
        } else {
            $transaction->code = 'TRX/000001';
        }
    }

    public function created(Transaction $transaction)
    {
        $transaction->invoice()->create(
            [
                'balance_due' => $transaction->total
            ]
        );
    }

    public function updated(Transaction $transaction)
    {
        $purchaseTotal = $transaction->total;
        $invoicePaid = $transaction->invoice->paid;
        $invoiceBalanceDue = $purchaseTotal - $invoicePaid;
        $transaction->invoice()->update(
            [
                'balance_due' => $invoiceBalanceDue
            ]
        );
    }
}
