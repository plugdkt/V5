<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = ['name_th', 'name_en', 'level'];

    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class, 'position_id');
    }
}
