<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Expense extends Model
{
    use HasFactory;
    use Uuid;


    protected $fillable = ['code'];

    protected $casts = ['expensed_at' => 'datetime'];

    protected $appends = ['status'];

    protected $with = ['invoice'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'vendor_id');
    }

    public function fromAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function toAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ExpenseItem::class);
    }

    public function invoice(): MorphOne
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    public function withholdings(): MorphMany
    {
        return $this->morphMany(Withholding::class, 'withholdingable');
    }

    public function expensable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] = optional($this->invoice)->status;
    }
}
