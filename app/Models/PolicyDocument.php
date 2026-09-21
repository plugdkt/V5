<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolicyDocument extends Model
{
    use HasFactory;

    protected $table = 'policy_documents';

    protected $fillable = [
        'policy_category_id',
        'group_name',
        'sub_group_name',
        'title',
        'file_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PolicyCategory::class, 'policy_category_id');
    }
}
