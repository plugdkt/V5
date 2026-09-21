<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';

    protected $fillable = [
        'eyebrow', 'title_th', 'title_highlight', 'title_th_end', 'subtitle', 'photo_path', 'primary_btn_text', 'primary_btn_url', 'secondary_btn_text', 'secondary_btn_url', 'order_key', 'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
