<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class department extends Model
{
    protected $garded = ['id'];

    public function users () : HasMany
    {
        return $this->hasMany(User::class);
    }
    public function schedules () : HasMany
    {
        return $this->hasMany(schedule::class);
    }
}
