<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class department extends Model
{
    protected $fillable = [
        'name',


    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function schedules(): HasMany
    {
        return $this->hasMany(schedule::class);
    }
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }   
}
