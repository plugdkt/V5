<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    protected $fillable = ['name_th', 'name_en', 'slug', 'color', 'icon', 'order'];

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id')->orderBy('published_at', 'desc');
    }
}
