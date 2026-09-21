<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingRoom extends Model
{
    protected $fillable = ['name', 'capacity', 'location', 'description', 'image', 'amenities', 'active'];

    protected $casts = [
        'amenities' => 'array',
        'active' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(RoomBooking::class, 'room_id');
    }
}
