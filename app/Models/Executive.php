<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    protected $table = 'executives';

    protected $fillable = [
        'name_th', 'name_en', 'position_th', 'position_en', 'email', 'phone', 'photo_path', 'duties', 'order_key'
    ];
}
