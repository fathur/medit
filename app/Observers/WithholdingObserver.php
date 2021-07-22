<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Withholding;

class WithholdingObserver
{
    public function created(Withholding $withholding)
    {
        $withholdingable = $withholding->withholdingable;

        $this->allow($withholdingable);

        $subtractWithholding = $withholdingable->withholdings()->sum('nominal');

        $withholdingable->total = $withholdingable->total - $subtractWithholding;
        $withholdingable->save();


        //        if ($withholdingable instanceof PurchaseItem) {
        //            $purchaseItem = PurchaseItem::find($withholdingable->id);
        //
        //            $subtractWithholding = $purchaseItem->withholdings()->sum('nominal');
        //
        //            $purchaseItem->total = $purchaseItem->total - $subtractWithholding;
        //            $purchaseItem->save();
        //        } elseif ($withholdingable instanceof Purchase) {
        //            $purchase = Purchase::find($withholdingable->id);
        //
        //            $subtractWithholding = $purchase->withholdings()->sum('nominal');
        //
        //            $purchase->total = $purchase->total - $subtractWithholding;
        //
        //            $purchase->save();
        //        } elseif ($withholdingable instanceof Expense) {
        //            $expense = Expense::find($withholdingable->id);
        //
        //            $subtractWithholding = $expense->withholdings()->sum('nominal');
        //
        //            $expense->total = $expense->total - $subtractWithholding;
        //
        //            $expense->save();
        //        } elseif ($withholdingable instanceof ExpenseItem) {
        //            $expenseItem = ExpenseItem::find($withholdingable->id);
        //
        //            $subtractWithholding = $expenseItem->withholdings()->sum('nominal');
        //
        //            $expenseItem->total = $expenseItem->total - $subtractWithholding;
        //            $expenseItem->save();
        //        }
    }

    /**
     * @param  $withholdingable
     * @return bool
     * @throws \Exception
     */
    protected function allow($withholdingable): bool
    {
        if ($withholdingable instanceof Expense || $withholdingable instanceof Purchase || $withholdingable instanceof ExpenseItem || $withholdingable instanceof PurchaseItem) {
            return true;
        }

        throw new \Exception('Unauthorized');
    }
}
