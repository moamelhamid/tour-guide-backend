<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class schedule extends Model
{
    protected $garded = ['id'];

    public function department() : BelongsTo
    {
        return $this->belongsTo(department::class);
    }
}
