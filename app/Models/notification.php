<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class notification extends Model
{
    protected $garded = ['id'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
