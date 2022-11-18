<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_city_id',
        'name',
        'country_code',
        'coord_lon',
        'coord_lat'
    ];

    public function all_day_temp()
    {
        return $this->tempetatures->groupBy(function ($res){
            $dt = DateTime::createFromFormat("Y-m-d H:i:s", $res->dubai_time);
            return $dt->format('H');
        })->sortBy(function ($value, $key){
            return (int)$key;
        });
    }


    public function current_temp()
    {
        return $this->tempetatures->sortByDesc('dt')->first();
    }

    public function tempetatures()
    {
        return $this->hasMany(Temperature::class);
    }
}
