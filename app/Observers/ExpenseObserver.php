<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpenseObserver
{
    /**
     * @param Expense $expense
     */
    public function creating(Expense $expense)
    {
        $company = $this->decideCompany($expense);

        $this->generateCode($company, $expense);
    }

    public function created(Expense $expense)
    {
        $expense->invoice()->create(
            [
                'balance_due' => $expense->total
            ]
        );

        $this->adjustTotal($expense);
    }

    public function updating(Expense $expense)
    {
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

        //
        $this->adjustTotal($expense);
    }

    /**
     * @param Expense $expense
     * @return mixed
     */
    public function decideCompany(Expense $expense): Company
    {
        if (is_null($expense->company_id)) {
            $company = Auth::user()->companies()->first();

            $expense->company_id = $company->id;

            return $company;
        }

        return $expense->company;
    }

    /**
     * @param Company $company
     * @param Expense $expense
     */
    protected function generateCode(Company $company, Expense $expense): void
    {
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

    /**
     * @param Expense $expense
     */
    public function adjustTotal(Expense $expense): void
    {
        // Jika ada expansable maka update total di expansable-nya
        // Dalam kasus ini transaction dan purchases
        if (!is_null($expense->expensable)) {
            $expensable = $expense->expensable;

            $totalWithholding = $expensable->withholdings()->sum('nominal');
            $totalExpense = $expensable->expenses()->sum('total');
            $expensable->total = $expensable->sub_total - $totalWithholding + $totalExpense;
            $expensable->save();
        }
    }
}

// Bagaimana cara menanggulangi stress?
// 3 Dari gejala stress di slide saya alami, apakah saya stress, tetapi saya tidak merasa stress?
// mau datang ke psikolog harus bayar tambah stress.

/**
 * Four A to manage stress
 *
 * 1. Avoid
 * 2. Alter
 * 3. Accept
 * 4. Adapt
 */
