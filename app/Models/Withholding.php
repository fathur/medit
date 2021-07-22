<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withholding extends Model
{
    use HasFactory;
    use Uuid;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function withholdingable()
    {
        return $this->morphTo();
    }
}
