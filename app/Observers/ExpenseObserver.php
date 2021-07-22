<?php

namespace App\Observers;

use App\Models\Expense;
use Illuminate\Support\Str;

class ExpenseObserver
{
    public function creating(Expense $expense)
    {
        $company = $expense->company;
        $latestCode = $company->expenses()->max('code');


        if ($latestCode) {
            $exploded = Str::of($latestCode)->explode('EXP/');

            $numberedLatestCode = (int)$exploded[1];
            $incrementCode = $numberedLatestCode + 1;
            $incrementCode = str_pad((string)$incrementCode, 6, '0', STR_PAD_LEFT);
            $expense->code = 'EXP/' . $incrementCode;
        } else {
            $expense->code = 'EXP/000001';
        }
    }

    public function created(Expense $expense)
    {
        $expense->invoice()->create(
            [
            'balance_due' => $expense->total
            ]
        );
    }

    public function updated(Expense $expense)
    {
        $expenseTotal = $expense->total;
        $invoicePaid = $expense->invoice->paid;
        $invoiceBalanceDue = $expenseTotal - $invoicePaid;
        $expense->invoice()->update(
            [
            'balance_due' => $invoiceBalanceDue
            ]
        );
    }
}
