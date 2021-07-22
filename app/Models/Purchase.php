<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = ['code'];

    protected $casts = ['purchased_at' => 'datetime'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'vendor_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    public function withholdings()
    {
        return $this->morphMany(Withholding::class, 'withholdingable');
    }
}
