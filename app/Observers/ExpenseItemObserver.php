<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\ExpenseItem;

class ExpenseItemObserver
{
    public function creating(ExpenseItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function created(ExpenseItem $item)
    {
        $this->calculateExpenseTotal($item->expense);
    }

    public function updating(ExpenseItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function updated(ExpenseItem $item)
    {
        $this->calculateExpenseTotal($item->expense);
    }

    public function deleted(ExpenseItem $item)
    {
        $this->calculateExpenseTotal($item->expense);
    }

    /**
     * @param Expense $expense
     */
    public function calculateExpenseTotal(Expense $expense): void
    {
        $subTotal = $expense->items()->sum('total');

        $expense->sub_total = $subTotal;
        $expense->total = $subTotal;
        $expense->save();
    }
}
