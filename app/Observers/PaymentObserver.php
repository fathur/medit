<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function created(Payment $payment)
    {
        $invoice = $payment->invoice;
        $totalPaid = $invoice->payments()->sum('nominal');

        $invoice->paid = $totalPaid;
        $invoice->balance_due = $invoice->invoiceable->total - $totalPaid;
        $invoice->save();
    }
}
