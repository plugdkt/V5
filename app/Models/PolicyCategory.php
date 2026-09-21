<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PolicyCategory extends Model
{
    use HasFactory;

    protected $table = 'policy_categories';

    protected $fillable = [
        'name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(PolicyDocument::class, 'policy_category_id')->orderBy('sort_order');
    }
}
