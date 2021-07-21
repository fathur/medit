<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Withholding;

class WithholdingObserver
{
    public function created(Withholding $withholding)
    {
        $withholdingable = $withholding->withholdingable;

        if ($withholdingable instanceof PurchaseItem) {

            $purchaseItem = PurchaseItem::find($withholdingable->id);

            $subtractWithholding = $purchaseItem->withholdings()->sum('nominal');

            $purchaseItem->total = $purchaseItem->total - $subtractWithholding;
            $purchaseItem->save();

        } elseif ($withholdingable instanceof Purchase) {

            $purchase = Purchase::find($withholdingable->id);

            $subtractWithholding = $purchase->withholdings()->sum('nominal');

            $purchase->total = $purchase->total - $subtractWithholding;

            $purchase->save();
        }
    }
}
