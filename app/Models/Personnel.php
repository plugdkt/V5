<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personnel extends Model
{
    protected $table = 'personnel';

    protected $fillable = [
        'user_id', 'employee_code', 'prefix', 'firstname_th', 'lastname_th',
        'firstname_en', 'lastname_en', 'position_id', 'department_id',
        'academic_position', 'photo', 'email', 'phone', 'order', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(PersonnelEducation::class, 'personnel_id');
    }

    public function publications(): HasMany
    {
        return $this->hasMany(PersonnelPublication::class, 'personnel_id');
    }

    public function getFullNameThAttribute(): string
    {
        return trim("{$this->prefix}{$this->firstname_th} {$this->lastname_th}");
    }

    public function getFullNameEnAttribute(): string
    {
        $prefix = $this->prefix;
        if (in_array(strtolower($prefix), ['นาย', 'นาง', 'นางสาว'])) {
            $prefix = strtolower($prefix) === 'นาย' ? 'Mr. ' : (strtolower($prefix) === 'นาง' ? 'Mrs. ' : 'Ms. ');
        }
        return trim("{$prefix}{$this->firstname_en} {$this->lastname_en}");
    }
}
