<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name_th', 'name_en', 'code', 'parent_id', 'order'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id')->orderBy('order');
    }

    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class, 'department_id')->orderBy('order');
    }
}
