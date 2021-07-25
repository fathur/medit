<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invoice extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = ['due_at'];

    protected $casts = [
        'due_at' => 'datetime'
    ];

    protected $appends = ['status'];

    public function invoiceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusAttribute(): string
    {
        return $this->attributes['status'] = $this->guessStatus();
    }

    private function guessStatus(): string
    {
        if ($this->paid == 0 and $this->balance_due == 0) {
            return 'no-item';
        }

        if ($this->paid == 0) {
            return 'unpaid';
        }

        if ($this->balance_due == 0) {
            return 'paid';
        }

        if ($this->balance_due > 0 and $this->balance_due > $this->paid and $this->paid !== 0) {
            return 'partial';
        }

        return 'no-item';
    }

    public static function statusMap(): array
    {
        return [
            'unpaid' => 'danger',
            'partial' => 'warning',
            'paid' => 'success',
            'no-item' => 'warning',
        ] ;
    }
}
