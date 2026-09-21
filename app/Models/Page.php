<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'body', 'pdf_path', 'meta_description', 'published'];


    protected $casts = [
        'published' => 'boolean',
    ];
}
