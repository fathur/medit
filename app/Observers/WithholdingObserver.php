<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Withholding;
use Exception;

class WithholdingObserver
{
    /**
     * @throws Exception
     */
    public function created(Withholding $withholding)
    {
        $withholdingable = $withholding->withholdingable;

        $this->allow($withholdingable);

        $subtractWithholding = $withholdingable->withholdings()->sum('nominal');

        $withholdingable->total = $withholdingable->total - $subtractWithholding;
        $withholdingable->save();
    }

    /**
     * @param  $withholdingable
     * @return bool
     * @throws Exception
     */
    protected function allow($withholdingable): bool
    {
        if (
            $withholdingable instanceof Expense || $withholdingable instanceof Purchase ||
            $withholdingable instanceof ExpenseItem || $withholdingable instanceof PurchaseItem ||
            $withholdingable instanceof Transaction || $withholdingable instanceof TransactionItem
        ) {
            return true;
        }

        throw new Exception('Unauthorized');
    }
}
