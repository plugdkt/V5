<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'category_id', 'name', 'asset_code', 'serial_number', 'purchase_date', 
        'purchase_price', 'location', 'condition', 'responsible_person_id', 
        'status', 'description', 'image'
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function responsiblePerson(): BelongsTo
    {
        return $this->belongsTo(Personnel::class, 'responsible_person_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(AssetTransaction::class, 'asset_id');
    }
}
