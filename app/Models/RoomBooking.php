<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomBooking extends Model
{
    protected $fillable = [
        'room_id', 'user_id', 'title', 'purpose', 'attendees', 
        'start_datetime', 'end_datetime', 'status', 'approved_by', 'approved_at', 'note'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(MeetingRoom::class, 'room_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
