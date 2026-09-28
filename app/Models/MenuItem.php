<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = ['title_th', 'title_en', 'url', 'parent_id', 'order', 'target', 'location', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('nav_menus_v2');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('nav_menus_v2');
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('active', true)->orderBy('order');
    }

    public function allChildren(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function getUrlAttribute($value)
    {
        if (str_starts_with($value, 'http') || str_starts_with($value, '#')) {
            return $value;
        }
        return url($value);
    }

    /**
     * Localized menu title (returns English if current locale is 'en' and title_en exists).
     */
    public function getTitleAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        return $this->title_th;
    }
}
