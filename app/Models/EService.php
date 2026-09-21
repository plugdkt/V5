<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EService extends Model
{
    use HasFactory;

    protected $table = 'e_services';

    protected $fillable = [
        'title',
        'description',
        'url',
        'manual_url',
        'category',
        'badge_text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'category' => 'array',
    ];
}
