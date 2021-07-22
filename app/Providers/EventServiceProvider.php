<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Withholding;
use App\Observers\ExpenseItemObserver;
use App\Observers\ExpenseObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use App\Observers\PurchaseItemObserver;
use App\Observers\PurchaseObserver;
use App\Observers\WithholdingObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        Purchase::observe(PurchaseObserver::class);
        PurchaseItem::observe(PurchaseItemObserver::class);
        Withholding::observe(WithholdingObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
        Expense::observe(ExpenseObserver::class);
        ExpenseItem::observe(ExpenseItemObserver::class);
    }
}
