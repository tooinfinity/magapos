<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $guarded = [];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
