<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\TransactionItem;

class TransactionItemObserver
{
    public function creating(TransactionItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function created(TransactionItem $item)
    {
        $this->calculateTransactionTotal($item->transaction);
    }

    public function updating(TransactionItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function updated(TransactionItem $item)
    {
        $this->calculateTransactionTotal($item->transaction);
    }

    public function deleted(TransactionItem $item)
    {
        $this->calculateTransactionTotal($item->transaction);
    }

    /**
     */
    public function calculateTransactionTotal(Transaction $transaction): void
    {
        $subTotal = $transaction->items()->sum('total');

        $transaction->sub_total = $subTotal;
        $transaction->total = $subTotal;
        $transaction->save();
    }
}
