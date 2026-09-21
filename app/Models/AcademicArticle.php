<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicArticle extends Model
{
    protected $fillable = [
        'title',
        'author',
        'division',
        'category',
        'link_url',
        'abstract',
        'published_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'date',
    ];

    public function getBadgeAttribute()
    {
        return match ($this->category) {
            'biochemistry' => '🧬 ชีวเคมี',
            'microbiology' => '🔬 จุลชีววิทยาและปรสิตวิทยา',
            'nutrition' => '🥗 โภชนาการและการกำหนดอาหาร',
            'physiology' => '⚡ สรีรวิทยา',
            'anatomy' => '🦴 กายวิภาคศาสตร์',
            default => '📚 บทความวิชาการ',
        };
    }
}
