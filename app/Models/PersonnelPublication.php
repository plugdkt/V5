<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonnelPublication extends Model
{
    protected $table = 'personnel_publications';

    protected $fillable = ['personnel_id', 'title', 'journal', 'year', 'doi', 'type'];

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}
