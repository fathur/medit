<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseItemObserver
{
    public function creating(PurchaseItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function created(PurchaseItem $item)
    {
        $this->calculatePurchaseTotal($item->purchase);
    }

    public function updating(PurchaseItem $item)
    {
        $item->sub_total = $item->price * $item->quantity;
        $withholding = $item->withholdings()->sum('nominal');
        $item->total = $item->sub_total - $withholding;
    }

    public function updated(PurchaseItem $item)
    {
        $this->calculatePurchaseTotal($item->purchase);
    }

    public function deleted(PurchaseItem $item)
    {
        $this->calculatePurchaseTotal($item->purchase);
    }

    /**
     * @param Purchase $purchase
     */
    public function calculatePurchaseTotal(Purchase $purchase): void
    {
        $subTotal = $purchase->items()->sum('total');

        $purchase->sub_total = $subTotal;
        $purchase->total = $subTotal;
        $purchase->save();
    }
}
