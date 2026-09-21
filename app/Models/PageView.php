<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'view_date',
        'path',
        'page_title',
        'views_count',
        'views_desktop',
        'views_mobile',
        'views_tablet',
        'views_morning',
        'views_afternoon',
        'views_evening',
        'views_night',
    ];

    protected $casts = [
        'view_date' => 'date',
        'views_count' => 'integer',
        'views_desktop' => 'integer',
        'views_mobile' => 'integer',
        'views_tablet' => 'integer',
        'views_morning' => 'integer',
        'views_afternoon' => 'integer',
        'views_evening' => 'integer',
        'views_night' => 'integer',
    ];
}
