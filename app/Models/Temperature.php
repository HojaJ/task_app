<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'dt',
        'condition',
        'condition_icon',
        'dubai_time',
        'temp',
        'feels_like_temp',
        'humidity',
        'wind_speed'
    ];
}
