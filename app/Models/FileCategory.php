<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileCategory extends Model
{
    protected $fillable = ['name', 'parent_id', 'icon', 'order'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FileCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FileCategory::class, 'parent_id')->orderBy('order');
    }

    public function files(): HasMany
    {
        return $this->hasMany(DownloadableFile::class, 'category_id')->where('active', true);
    }
}
