<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportDocument extends Model
{
    use HasFactory;

    protected $table = 'report_documents';

    protected $fillable = [
        'report_category_id',
        'group_name',
        'sub_group_name',
        'title',
        'file_path',
        'file_path_excel',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class, 'report_category_id');
    }
}
