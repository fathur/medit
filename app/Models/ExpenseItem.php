<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = ['sub_total', 'total'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function withholdings()
    {
        return $this->morphMany(Withholding::class, 'withholdingable');
    }
}
