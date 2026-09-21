<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $fillable = ['name', 'unit', 'description', 'category', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function stats(): HasMany
    {
        return $this->hasMany(ServiceStat::class, 'service_type_id');
    }
}
