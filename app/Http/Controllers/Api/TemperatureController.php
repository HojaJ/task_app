<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Traits\ApiResponse;
use App\Models\City;
use App\Models\Temperature;
use Illuminate\Http\Request;


class TemperatureController extends Controller
{
    use ApiResponse;

    public function cities()
    {
        try {
            $cities = City::orderBy('created_at','ASC')->get();
            return $this->successResponse([
                'cities' => CityResource::collection($cities),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function humidity()
    {
        try {
            $city = City::where('id',1)->first();
            $humidity = $city->all_day_temp();
            $by_hour = $humidity->map(function($value, $key){
                return round(collect($value->pluck('humidity'))->avg());
            });

            return $this->successResponse([
                'labels' =>  array_keys($by_hour->toArray()),
                'datasets'=> array_values($by_hour->toArray())
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
