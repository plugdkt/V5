<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_th',
        'title_en',
        'degree_full_th',
        'degree_abbr_th',
        'degree_full_en',
        'degree_abbr_en',
        'credits',
        'duration_years',
        'fee_per_semester',
        'curriculum_year',
        'overview',
        'hero_image',
        'hero_color_from',
        'hero_color_to',
        'plos',
        'curriculum',
        'careers',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'plos' => 'array',
        'curriculum' => 'array',
        'careers' => 'array',
        'is_active' => 'boolean',
    ];
}
