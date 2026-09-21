<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadableFile extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'filename', 
        'original_name', 'mime_type', 'size', 'download_count', 'uploaded_by', 'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FileCategory::class, 'category_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
