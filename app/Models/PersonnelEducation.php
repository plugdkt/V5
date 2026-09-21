<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonnelEducation extends Model
{
    protected $table = 'personnel_educations';

    protected $fillable = ['personnel_id', 'degree', 'field', 'institution', 'year'];

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}
