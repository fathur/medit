<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use function Symfony\Component\Translation\t;

class Transaction extends Model
{
    use HasFactory;
    use Uuid;

    protected $casts = [
        'transaction_at' => 'datetime',
    ];

    protected $appends = ['status'];

    protected $with = ['invoice'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function invoice(): MorphOne
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    public function withholdings(): MorphMany
    {
        return $this->morphMany(Withholding::class, 'withholdingable');
    }

    public function expenses(): MorphMany
    {
        return $this->morphMany(Expense::class, 'expensable');
    }

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] = optional($this->invoice)->status;
    }

}
